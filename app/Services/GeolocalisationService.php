<?php

namespace App\Services;

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

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    /**
     * Obtenir les coordonnées à partir d'une adresse (simulation)
     * Dans une vraie application, utiliser une API comme Google Maps ou OpenStreetMap
     */
    public function obtenirCoordonnees($adresse)
    {
        // Simulation - dans une vraie app, faire un appel API
        return [
            'latitude' => 5.3600 + (rand(-100, 100) / 1000), // Abidjan approximatif
            'longitude' => -4.0083 + (rand(-100, 100) / 1000),
        ];
    }

    /**
     * Vérifier si une adresse est valide
     */
    public function validerAdresse($adresse)
    {
        // Simulation - dans une vraie app, valider avec une API
        return !empty(trim($adresse)) && strlen($adresse) > 10;
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
        // Estimation : 30 km/h en moyenne en ville
        $vitesseMoyenne = 30;
        return round(($distanceKm / $vitesseMoyenne) * 60);
    }
}
