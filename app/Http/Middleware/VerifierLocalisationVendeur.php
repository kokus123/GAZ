<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifierLocalisationVendeur
{
    /**
     * Redirige le vendeur connecté vers la page de complétion de profil
     * s'il n'a pas encore renseigné sa localisation (quartier + GPS).
     *
     * À enregistrer dans bootstrap/app.php (Laravel 12) ou app/Http/Kernel.php
     * sous l'alias 'localisation.vendeur', et à appliquer sur les routes
     * du dashboard vendeur.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->isVendeur() && ! $user->aLocalisationComplete()) {
            // Évite la boucle de redirection infinie sur la page de profil elle-même
            if (! $request->routeIs('vendeur.profil.*')) {
                return redirect()->route('vendeur.profil.completer')
                    ->with('warning', 'Veuillez compléter votre profil vendeur (localisation) avant de continuer.');
            }
        }

        return $next($request);
    }
}
