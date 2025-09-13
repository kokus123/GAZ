<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Stock;
use App\Models\User;
use App\Services\GeolocalisationService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommandeController extends Controller
{
    protected $geolocalisationService;
    protected $paymentService;

    public function __construct(GeolocalisationService $geolocalisationService, PaymentService $paymentService)
    {
        $this->geolocalisationService = $geolocalisationService;
        $this->paymentService = $paymentService;
    }

    /**
     * Afficher la liste des commandes
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $commandes = Commande::with(['client', 'vendeur', 'paiements'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } elseif ($user->isVendeur()) {
            $commandes = Commande::with(['client', 'paiements'])
                ->where('vendeur_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $commandes = Commande::with(['vendeur', 'paiements'])
                ->where('client_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('commandes.index', compact('commandes'));
    }

    /**
     * Afficher le formulaire de commande
     */
    public function create()
    {
        $stocks = Stock::disponibles()->with('vendeur')->get();
        return view('commandes.create', compact('stocks'));
    }

    /**
     * Traiter une nouvelle commande
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'quantite' => 'required|integer|min:1',
            'adresse_livraison' => 'required|string|max:500',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type_gaz' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Trouver le vendeur le plus proche avec du stock
            $vendeurProche = $this->trouverVendeurProche(
                $request->latitude,
                $request->longitude,
                $request->type_gaz,
                $request->quantite
            );

            if (!$vendeurProche) {
                return back()->withErrors(['error' => 'Aucun vendeur disponible avec du stock suffisant dans votre région.']);
            }

            // Créer la commande
            $commande = Commande::create([
                'client_id' => Auth::id(),
                'vendeur_id' => $vendeurProche->vendeur_id,
                'numero_commande' => 'CMD-' . date('YmdHis') . '-' . Str::random(6),
                'nom_client' => $request->nom_client,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'quantite' => $request->quantite,
                'prix_unitaire' => $vendeurProche->prix_unitaire,
                'prix_total' => $vendeurProche->prix_unitaire * $request->quantite,
                'adresse_livraison' => $request->adresse_livraison,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'statut' => 'en_attente',
                'notes' => $request->notes,
                'date_livraison_prevue' => now()->addDays(1),
            ]);

            // Décrémenter le stock
            $vendeurProche->decrementerStock($request->quantite);

            DB::commit();

            return redirect()->route('commandes.show', $commande)
                ->with('success', 'Commande créée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la création de la commande.']);
        }
    }

    /**
     * Afficher une commande spécifique
     */
    public function show(Commande $commande)
    {
        $commande->load(['client', 'vendeur', 'paiements', 'livraisons', 'reçus']);
        
        // Vérifier les permissions
        $user = Auth::user();
        if (!$user->isAdmin() && $commande->client_id !== $user->id && $commande->vendeur_id !== $user->id) {
            abort(403, 'Accès refusé');
        }

        return view('commandes.show', compact('commande'));
    }

    /**
     * Confirmer une commande (vendeur)
     */
    public function confirmer(Commande $commande)
    {
        if (!Auth::user()->isVendeur() || $commande->vendeur_id !== Auth::id()) {
            abort(403, 'Accès refusé');
        }

        $commande->update(['statut' => 'confirmee']);
        
        return back()->with('success', 'Commande confirmée avec succès !');
    }

    /**
     * Annuler une commande
     */
    public function annuler(Commande $commande)
    {
        $user = Auth::user();
        
        // Vérifier les permissions
        if (!$user->isAdmin() && $commande->client_id !== $user->id) {
            abort(403, 'Accès refusé');
        }

        if (!$commande->canBeCancelled()) {
            return back()->withErrors(['error' => 'Cette commande ne peut pas être annulée.']);
        }

        try {
            DB::beginTransaction();

            $commande->update(['statut' => 'annulee']);

            // Restaurer le stock
            if ($commande->vendeur_id) {
                $stock = Stock::where('vendeur_id', $commande->vendeur_id)
                    ->where('type_gaz', $commande->type_gaz ?? 'propane')
                    ->first();
                
                if ($stock) {
                    $stock->incrementerStock($commande->quantite);
                }
            }

            DB::commit();

            return back()->with('success', 'Commande annulée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de l\'annulation de la commande.']);
        }
    }

    /**
     * Trouver le vendeur le plus proche avec du stock
     */
    private function trouverVendeurProche($latitude, $longitude, $typeGaz, $quantite)
    {
        $stocks = Stock::disponibles()
            ->parType($typeGaz)
            ->where('quantite_disponible', '>=', $quantite)
            ->with('vendeur')
            ->get();

        if ($stocks->isEmpty()) {
            return null;
        }

        // Calculer la distance pour chaque vendeur
        $vendeursAvecDistance = $stocks->map(function ($stock) use ($latitude, $longitude) {
            $distance = $this->geolocalisationService->calculerDistance(
                $latitude,
                $longitude,
                $stock->vendeur->latitude ?? 0,
                $stock->vendeur->longitude ?? 0
            );
            
            return [
                'stock' => $stock,
                'distance' => $distance
            ];
        });

        // Retourner le vendeur le plus proche
        return $vendeursAvecDistance->sortBy('distance')->first()['stock'];
    }
}
