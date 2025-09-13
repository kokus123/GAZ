<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    /**
     * Afficher la liste des paiements
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $paiements = Paiement::with(['commande.client', 'commande.vendeur'])->paginate(15);
        } elseif ($user->isVendeur()) {
            $paiements = Paiement::with(['commande.client'])
                ->whereHas('commande', function($query) use ($user) {
                    $query->where('vendeur_id', $user->id);
                })
                ->paginate(15);
        } else {
            $paiements = Paiement::with(['commande.vendeur'])
                ->whereHas('commande', function($query) use ($user) {
                    $query->where('client_id', $user->id);
                })
                ->paginate(15);
        }

        return view('paiements.index', compact('paiements'));
    }

    /**
     * Afficher un paiement spécifique
     */
    public function show(Paiement $paiement)
    {
        $this->authorize('view', $paiement);
        $paiement->load(['commande.client', 'commande.vendeur', 'reçus']);
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Afficher le formulaire de paiement
     */
    public function create(Request $request)
    {
        $commandeId = $request->get('commande_id');
        $commande = null;
        
        if ($commandeId) {
            $commande = Commande::findOrFail($commandeId);
            $this->authorize('view', $commande);
        }

        return view('paiements.create', compact('commande'));
    }

    /**
     * Traiter un paiement
     */
    public function store(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'methode' => 'required|in:mobile_money,carte_bancaire,especes',
            'numero_telephone' => 'required_if:methode,mobile_money|string|max:20',
            'operateur' => 'required_if:methode,mobile_money|in:orange,mtn,moov',
            'numero_carte' => 'required_if:methode,carte_bancaire|string|max:20',
            'type_carte' => 'required_if:methode,carte_bancaire|in:visa,mastercard'
        ]);

        $commande = Commande::findOrFail($request->commande_id);
        $this->authorize('view', $commande);

        // Vérifier que la commande n'est pas déjà payée
        if ($commande->isPaid()) {
            return back()->withErrors(['error' => 'Cette commande est déjà payée.']);
        }

        // Créer le paiement
        $paiement = Paiement::create([
            'commande_id' => $commande->id,
            'numero_transaction' => 'TXN-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 8)),
            'montant' => $commande->prix_total,
            'methode' => $request->methode,
            'statut' => 'en_attente',
            'numero_telephone' => $request->numero_telephone,
            'operateur' => $request->operateur,
            'details_transaction' => json_encode([
                'numero_carte' => $request->numero_carte,
                'type_carte' => $request->type_carte
            ])
        ]);

        // Traiter le paiement selon la méthode
        if ($request->methode === 'mobile_money') {
            return $this->traiterMobileMoney($paiement);
        } elseif ($request->methode === 'carte_bancaire') {
            return $this->traiterCarteBancaire($paiement);
        } else {
            return $this->traiterEspeces($paiement);
        }
    }

    /**
     * Traiter un paiement Mobile Money
     */
    private function traiterMobileMoney(Paiement $paiement)
    {
        // Simulation de traitement Mobile Money
        $success = rand(1, 10) <= 8; // 80% de succès
        
        if ($success) {
            $paiement->valider();
            $paiement->commande->update(['statut' => 'confirmee']);
            
            return redirect()->route('paiements.show', $paiement)
                ->with('success', 'Paiement Mobile Money effectué avec succès !');
        } else {
            $paiement->marquerEchec();
            
            return back()->withErrors(['error' => 'Échec du paiement Mobile Money. Veuillez réessayer.']);
        }
    }

    /**
     * Traiter un paiement par carte bancaire
     */
    private function traiterCarteBancaire(Paiement $paiement)
    {
        // Simulation de traitement carte bancaire
        $success = rand(1, 10) <= 7; // 70% de succès
        
        if ($success) {
            $paiement->valider();
            $paiement->commande->update(['statut' => 'confirmee']);
            
            return redirect()->route('paiements.show', $paiement)
                ->with('success', 'Paiement par carte effectué avec succès !');
        } else {
            $paiement->marquerEchec();
            
            return back()->withErrors(['error' => 'Paiement par carte refusé. Veuillez vérifier vos informations.']);
        }
    }

    /**
     * Traiter un paiement en espèces
     */
    private function traiterEspeces(Paiement $paiement)
    {
        // Pour les espèces, on met en attente de validation manuelle
        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement en espèces enregistré. En attente de validation par le vendeur.');
    }

    /**
     * Valider un paiement (vendeur/admin)
     */
    public function valider(Paiement $paiement)
    {
        $this->authorize('update', $paiement);
        
        if ($paiement->isEnAttente()) {
            $paiement->valider();
            $paiement->commande->update(['statut' => 'confirmee']);
            
            return back()->with('success', 'Paiement validé avec succès !');
        }

        return back()->withErrors(['error' => 'Ce paiement ne peut pas être validé.']);
    }

    /**
     * Marquer un paiement comme échec
     */
    public function echec(Paiement $paiement)
    {
        $this->authorize('update', $paiement);
        
        $paiement->marquerEchec();
        
        return back()->with('success', 'Paiement marqué comme échec.');
    }
}