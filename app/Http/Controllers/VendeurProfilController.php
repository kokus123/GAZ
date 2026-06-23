<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendeurProfilController extends Controller
{
    /**
     * Afficher le formulaire de complétion du profil vendeur
     * (quartier, adresse détaillée, téléphone, GPS).
     */
    public function completer()
    {
        $vendeur = Auth::user();

        // Si déjà complété, on renvoie directement vers le dashboard vendeur
        if ($vendeur->aLocalisationComplete()) {
            return redirect()->route('dashboardv');
        }

        return view('vendeur.profil-completer', compact('vendeur'));
    }

    /**
     * Enregistrer la localisation et les informations de contact du vendeur.
     */
    public function enregistrer(Request $request)
    {
        $request->validate([
            'quartier' => 'required|string|max:255',
            'adresse_detaillee' => 'required|string|max:500',
            'telephone' => 'required|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'latitude.required' => 'La géolocalisation est obligatoire. Veuillez autoriser l\'accès à votre position GPS.',
            'longitude.required' => 'La géolocalisation est obligatoire. Veuillez autoriser l\'accès à votre position GPS.',
        ]);

        $vendeur = Auth::user();

        $vendeur->update([
            'quartier' => $request->quartier,
            'adresse_detaillee' => $request->adresse_detaillee,
            'telephone' => $request->telephone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'localisation_completee_at' => now(),
        ]);

        return redirect()->route('dashboardv')
            ->with('success', 'Votre profil vendeur a été complété avec succès !');
    }

    /**
     * Permettre au vendeur de modifier sa localisation plus tard
     * (depuis son dashboard, par exemple en cas de déménagement).
     */
    public function modifier()
    {
        $vendeur = Auth::user();

        return view('vendeur.profil-completer', compact('vendeur'));
    }
}