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
use Illuminate\Support\Facades\Session;
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
     * Afficher le formulaire de commande (étape 1 : infos client + adresse + GPS)
     */
    public function create()
    {
        return view('commandes.create');
    }

    /**
     * ÉTAPE 1 -> 2 : Réceptionner le formulaire client, calculer les vendeurs
     * les plus proches, et afficher la liste des vendeurs à choisir.
     *
     * On ne crée RIEN en base ici : tout est stocké en session jusqu'à
     * la validation finale du panier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse_livraison' => 'required|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Tous les vendeurs inscrits sont affichés, sans aucune exclusion
        // (ni par stock, ni par localisation manquante). Triés par distance
        // quand le GPS du client est disponible, sinon par nom.
        $vendeursAvecCatalogue = $this->geolocalisationService->tousLesVendeurs(
            $request->filled('latitude') ? (float) $request->latitude : null,
            $request->filled('longitude') ? (float) $request->longitude : null
        );

        if ($vendeursAvecCatalogue->isEmpty()) {
            return back()->withInput()->withErrors([
                'error' => 'Aucun vendeur n\'est encore inscrit sur la plateforme.',
            ]);
        }

        // On ajoute, pour chaque vendeur, le nombre de produits qu'il a
        // actuellement en stock — utilisé uniquement pour informer le client
        // (badge "Pas encore de produits"), sans jamais exclure personne.
        $vendeursAvecCatalogue = $vendeursAvecCatalogue->map(function ($item) {
            $item['nb_produits'] = Stock::where('vendeur_id', $item['vendeur']->id)
                ->disponibles()
                ->where('quantite_disponible', '>', 0)
                ->count();

            return $item;
        });

        // Stocker les infos client en session pour les étapes suivantes
        Session::put('commande_client_infos', $request->only([
            'nom_client', 'telephone', 'email', 'adresse_livraison',
            'latitude', 'longitude', 'notes',
        ]));
        Session::put('panier', []); // on repart d'un panier vide à chaque nouvelle commande

        return view('commandes.choisir-vendeur', [
            'vendeurs' => $vendeursAvecCatalogue,
            'utiliseGps' => $request->filled('latitude') && $request->filled('longitude'),
        ]);
    }

    /**
     * ÉTAPE 2 -> 3 : Le client a choisi un vendeur -> afficher son catalogue
     * (photos, prix, stock) pour qu'il puisse ajouter des produits au panier.
     */
    public function catalogueVendeur(User $vendeur)
    {
        if (! Session::has('commande_client_infos')) {
            return redirect()->route('commandes.create')
                ->withErrors(['error' => 'Veuillez d\'abord renseigner vos informations de livraison.']);
        }

        $produits = Stock::where('vendeur_id', $vendeur->id)
            ->disponibles()
            ->where('quantite_disponible', '>', 0)
            ->get();

        Session::put('vendeur_choisi_id', $vendeur->id);

        return view('commandes.catalogue-vendeur', [
            'vendeur' => $vendeur,
            'produits' => $produits,
            'panier' => Session::get('panier', []),
        ]);
    }

    /**
     * Ajouter un produit du catalogue au panier (session).
     */
    public function ajouterAuPanier(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $stock = Stock::findOrFail($request->stock_id);

        if ($request->quantite > $stock->quantite_disponible) {
            return back()->withErrors(['error' => 'Quantité demandée supérieure au stock disponible.']);
        }

        $panier = Session::get('panier', []);

        // Si le produit est déjà dans le panier, on met à jour la quantité
        $panier[$stock->id] = [
            'stock_id' => $stock->id,
            'type_gaz' => $stock->type_gaz,
            'unite' => $stock->unite,
            'prix_unitaire' => $stock->prix_unitaire,
            'photo' => $stock->photo,
            'quantite' => $request->quantite,
        ];

        Session::put('panier', $panier);

        return back()->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Retirer un produit du panier.
     */
    public function retirerDuPanier(Request $request)
    {
        $request->validate(['stock_id' => 'required|integer']);

        $panier = Session::get('panier', []);
        unset($panier[$request->stock_id]);
        Session::put('panier', $panier);

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * ÉTAPE 3 -> 4 : Afficher le récapitulatif du panier avant validation finale.
     */
    public function voirPanier()
    {
        $panier = Session::get('panier', []);
        $vendeurId = Session::get('vendeur_choisi_id');

        if (empty($panier) || ! $vendeurId) {
            return redirect()->route('commandes.create')
                ->withErrors(['error' => 'Votre panier est vide.']);
        }

        $vendeur = User::findOrFail($vendeurId);
        $total = collect($panier)->sum(fn ($item) => $item['prix_unitaire'] * $item['quantite']);

        return view('commandes.panier', compact('panier', 'vendeur', 'total'));
    }

    /**
     * ÉTAPE 4 -> FIN : Validation finale -> création réelle de la/des commande(s)
     * et décrémentation du stock pour chaque produit du panier.
     */
    public function validerPanier()
    {
        $panier = Session::get('panier', []);
        $vendeurId = Session::get('vendeur_choisi_id');
        $infosClient = Session::get('commande_client_infos');

        if (empty($panier) || ! $vendeurId || ! $infosClient) {
            return redirect()->route('commandes.create')
                ->withErrors(['error' => 'Votre session de commande a expiré. Veuillez recommencer.']);
        }

        try {
            DB::beginTransaction();

            $commandesCreees = [];

            foreach ($panier as $item) {
                $stock = Stock::find($item['stock_id']);

                if (! $stock || $stock->quantite_disponible < $item['quantite']) {
                    throw new \Exception("Stock insuffisant pour {$item['type_gaz']}.");
                }

                $commande = Commande::create([
                    'client_id' => Auth::id(),
                    'vendeur_id' => $vendeurId,
                    'numero_commande' => 'CMD-'.date('YmdHis').'-'.Str::random(6),
                    'nom_client' => $infosClient['nom_client'],
                    'telephone' => $infosClient['telephone'],
                    'email' => $infosClient['email'] ?? null,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix_unitaire'],
                    'prix_total' => $item['prix_unitaire'] * $item['quantite'],
                    'adresse_livraison' => $infosClient['adresse_livraison'],
                    'latitude' => $infosClient['latitude'] ?? null,
                    'longitude' => $infosClient['longitude'] ?? null,
                    'statut' => 'en_attente',
                    'notes' => $infosClient['notes'] ?? null,
                    'date_livraison_prevue' => now()->addDays(1),
                ]);

                $stock->decrementerStock($item['quantite']);

                $commandesCreees[] = $commande;
            }

            DB::commit();

            Session::forget(['panier', 'vendeur_choisi_id', 'commande_client_infos']);

            return redirect()->route('commandes.show', $commandesCreees[0])
                ->with('success', count($commandesCreees) > 1
                    ? count($commandesCreees).' commandes créées avec succès !'
                    : 'Commande créée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Erreur lors de la création de la commande : '.$e->getMessage()]);
        }
    }

    /**
     * Afficher une commande spécifique
     */
    public function show(Commande $commande)
    {
        $commande->load(['client', 'vendeur', 'paiements', 'livraisons', 'reçus']);

        $user = Auth::user();
        if (! $user->isAdmin() && $commande->client_id !== $user->id && $commande->vendeur_id !== $user->id) {
            abort(403, 'Accès refusé');
        }

        return view('commandes.show', compact('commande'));
    }

    /**
     * Confirmer une commande (vendeur)
     */
    public function confirmer(Commande $commande)
    {
        if (! Auth::user()->isVendeur() || $commande->vendeur_id !== Auth::id()) {
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

        if (! $user->isAdmin() && $commande->client_id !== $user->id) {
            abort(403, 'Accès refusé');
        }

        if (! $commande->canBeCancelled()) {
            return back()->withErrors(['error' => 'Cette commande ne peut pas être annulée.']);
        }

        try {
            DB::beginTransaction();

            $commande->update(['statut' => 'annulee']);

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
}
