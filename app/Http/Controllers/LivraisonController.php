<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivraisonController extends Controller
{
    /**
     * Afficher la liste des livraisons
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $livraisons = Livraison::with(['commande', 'vendeur'])->paginate(15);
        } elseif ($user->isVendeur()) {
            $livraisons = Livraison::with(['commande'])
                ->where('vendeur_id', $user->id)
                ->paginate(15);
        } else {
            $livraisons = Livraison::with(['vendeur'])
                ->whereHas('commande', function($query) use ($user) {
                    $query->where('client_id', $user->id);
                })
                ->paginate(15);
        }

        return view('livraisons.index', compact('livraisons'));
    }

    /**
     * Afficher une livraison spécifique
     */
    public function show(Livraison $livraison)
    {
        $this->authorize('view', $livraison);
        $livraison->load(['commande.client', 'vendeur']);
        return view('livraisons.show', compact('livraison'));
    }

    /**
     * Démarrer une livraison
     */
    public function demarrer(Livraison $livraison)
    {
        $this->authorize('update', $livraison);
        
        if ($livraison->isProgrammee()) {
            $livraison->demarrer();
            return back()->with('success', 'Livraison démarrée avec succès !');
        }

        return back()->withErrors(['error' => 'Cette livraison ne peut pas être démarrée.']);
    }

    /**
     * Finaliser une livraison
     */
    public function finaliser(Livraison $livraison)
    {
        $this->authorize('update', $livraison);
        
        if ($livraison->isEnCours()) {
            $livraison->finaliser();
            
            // Mettre à jour le statut de la commande
            $livraison->commande->update(['statut' => 'livree']);
            
            return back()->with('success', 'Livraison finalisée avec succès !');
        }

        return back()->withErrors(['error' => 'Cette livraison ne peut pas être finalisée.']);
    }

    /**
     * Marquer une livraison comme échec
     */
    public function echec(Livraison $livraison)
    {
        $this->authorize('update', $livraison);
        
        $livraison->marquerEchec();
        
        return back()->with('success', 'Livraison marquée comme échec.');
    }
}