<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class GeolocalisationService
{
    /**
     * Calculer la distance entre deux points géographiques (formule de Haversine)
     */
    public function calculerDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Rayon de la Terre en kilomètres

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Obtenir les coordonnées à partir d'une adresse (simulation)
     * Dans une vraie application, utiliser une API comme Google Maps ou OpenStreetMap
     */
    public function obtenirCoordonnees($adresse)
    {
        return [
            'latitude' => 5.3600 + (rand(-100, 100) / 1000),
            'longitude' => -4.0083 + (rand(-100, 100) / 1000),
        ];
    }

    /**
     * Vérifier si une adresse est valide
     */
    public function validerAdresse($adresse)
    {
        return ! empty(trim($adresse)) && strlen($adresse) > 10;
    }

    /**
     * Obtenir la distance de livraison estimée
     */
    public function obtenirDistanceLivraison($lat1, $lon1, $lat2, $lon2)
    {
        return $this->calculerDistance($lat1, $lon1, $lat2, $lon2);
    }

    /**
     * Calculer le temps de livraison estimé (en minutes)
     */
    public function calculerTempsLivraison($distanceKm)
    {
        $vitesseMoyenne = 30;

        return round(($distanceKm / $vitesseMoyenne) * 60);
    }

    /**
     * Trouver les vendeurs ayant une localisation GPS valide,
     * classés du plus proche au plus éloigné.
     */
    public function trouverVendeursProches(float $latitude, float $longitude, ?int $limite = null): Collection
    {
        $vendeurs = User::avecLocalisation()->get();

        if ($vendeurs->isEmpty()) {
            return collect();
        }

        $resultats = $vendeurs->map(function (User $vendeur) use ($latitude, $longitude) {
            $distance = $this->calculerDistance(
                $latitude,
                $longitude,
                (float) $vendeur->latitude,
                (float) $vendeur->longitude
            );

            return [
                'vendeur' => $vendeur,
                'distance' => round($distance, 2),
                'temps_estime' => $this->calculerTempsLivraison($distance),
            ];
        })->sortBy('distance')->values();

        return $limite ? $resultats->take($limite) : $resultats;
    }

    /**
     * Fallback : trouver les vendeurs par correspondance de quartier.
     */
    public function trouverVendeursParQuartier(string $quartier): Collection
    {
        $quartierNormalise = mb_strtolower(trim($quartier));

        $vendeurs = User::where('role', 'vendeur')
            ->whereNotNull('quartier')
            ->get()
            ->filter(function (User $vendeur) use ($quartierNormalise) {
                return mb_strtolower($vendeur->quartier) === $quartierNormalise;
            })
            ->values();

        if ($vendeurs->isEmpty()) {
            $vendeurs = User::where('role', 'vendeur')
                ->whereNotNull('quartier')
                ->get();
        }

        return $vendeurs->map(function (User $vendeur) {
            return [
                'vendeur' => $vendeur,
                'distance' => null,
                'temps_estime' => null,
            ];
        });
    }

    /**
     * Tous les vendeurs inscrits dans le système, sans aucune exclusion
     * (ni par stock, ni par localisation incomplète, ni par quartier).
     *
     * - Si latitude/longitude client fournies : tri du plus proche au plus
     *   éloigné pour les vendeurs ayant une position GPS ; les vendeurs SANS
     *   position GPS sont placés à la fin (distance = null), triés par nom.
     * - Si aucune position fournie : tri alphabétique simple.
     */
    public function tousLesVendeurs(?float $latitude = null, ?float $longitude = null): Collection
    {
        $vendeurs = User::where('role', 'vendeur')->get();

        if ($vendeurs->isEmpty()) {
            return collect();
        }

        $resultats = $vendeurs->map(function (User $vendeur) use ($latitude, $longitude) {
            $aGps = ! empty($vendeur->latitude) && ! empty($vendeur->longitude);

            $distance = null;
            $tempsEstime = null;

            if ($aGps && $latitude !== null && $longitude !== null) {
                $distance = round($this->calculerDistance(
                    $latitude,
                    $longitude,
                    (float) $vendeur->latitude,
                    (float) $vendeur->longitude
                ), 2);
                $tempsEstime = $this->calculerTempsLivraison($distance);
            }

            return [
                'vendeur' => $vendeur,
                'distance' => $distance,
                'temps_estime' => $tempsEstime,
            ];
        });

        // Vendeurs avec distance connue triés en premier (du plus proche au
        // plus loin), puis vendeurs sans distance triés par nom ensuite.
        return $resultats
            ->sortBy(function ($item) {
                return $item['distance'] !== null ? $item['distance'] : INF;
            })
            ->values();
    }
}
