<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignalementController extends Controller
{
    /**
     * Afficher la liste des signalements
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $signalements = Signalement::with(['client', 'commande'])->paginate(15);
        } else {
            $signalements = Signalement::with(['commande'])
                ->where('client_id', $user->id)
                ->paginate(15);
        }

        return view('signalements.index', compact('signalements'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('signalements.create');
    }

    /**
     * Créer un nouveau signalement
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:non_livraison,incendie,autre',
            'service' => 'required|in:police,pompiers,gendarmerie',
            'description' => 'required|string|max:1000',
            'adresse_incident' => 'required|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'commande_id' => 'nullable|exists:commandes,id'
        ]);

        $signalement = Signalement::create([
            'client_id' => Auth::id(),
            'commande_id' => $request->commande_id,
            'type' => $request->type,
            'service' => $request->service,
            'description' => $request->description,
            'adresse_incident' => $request->adresse_incident,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'numero_signalement' => 'SIG-' . date('Ymd') . '-' . str_pad(Signalement::count() + 1, 4, '0', STR_PAD_LEFT),
            'statut' => 'en_attente'
        ]);

        return redirect()->route('signalements.show', $signalement)
            ->with('success', 'Signalement créé avec succès !');
    }

    /**
     * Afficher un signalement spécifique
     */
    public function show(Signalement $signalement)
    {
        $this->authorize('view', $signalement);
        $signalement->load(['client', 'commande']);
        return view('signalements.show', compact('signalement'));
    }

    /**
     * Signaler à la police
     */
    public function signalerPolice(Request $request)
    {
        $request->validate([
            'commande_id' => 'nullable|exists:commandes,id',
            'description' => 'required|string|max:1000',
            'adresse_incident' => 'required|string|max:500'
        ]);

        $signalement = Signalement::create([
            'client_id' => Auth::id(),
            'commande_id' => $request->commande_id,
            'type' => 'non_livraison',
            'service' => 'police',
            'description' => $request->description,
            'adresse_incident' => $request->adresse_incident,
            'numero_signalement' => 'SIG-' . date('Ymd') . '-' . str_pad(Signalement::count() + 1, 4, '0', STR_PAD_LEFT),
            'statut' => 'en_attente'
        ]);

        return back()->with('success', 'Signalement envoyé à la police !');
    }

    /**
     * Signaler aux pompiers
     */
    public function signalerPompiers(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'adresse_incident' => 'required|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);

        $signalement = Signalement::create([
            'client_id' => Auth::id(),
            'type' => 'incendie',
            'service' => 'pompiers',
            'description' => $request->description,
            'adresse_incident' => $request->adresse_incident,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'numero_signalement' => 'SIG-' . date('Ymd') . '-' . str_pad(Signalement::count() + 1, 4, '0', STR_PAD_LEFT),
            'statut' => 'en_attente'
        ]);

        return back()->with('success', 'Signalement envoyé aux pompiers !');
    }

    /**
     * Traiter un signalement (admin)
     */
    public function traiter(Signalement $signalement)
    {
        $this->authorize('update', $signalement);
        
        $signalement->traiter();
        
        return back()->with('success', 'Signalement traité avec succès !');
    }

    /**
     * Résoudre un signalement (admin)
     */
    public function resoudre(Signalement $signalement)
    {
        $this->authorize('update', $signalement);
        
        $signalement->resoudre();
        
        return back()->with('success', 'Signalement résolu avec succès !');
    }
}