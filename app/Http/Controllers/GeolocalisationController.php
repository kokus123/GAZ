<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeolocalisationService;

class GeolocalisationController extends Controller
{
    protected $geolocalisationService;

    public function __construct(GeolocalisationService $geolocalisationService)
    {
        $this->geolocalisationService = $geolocalisationService;
    }

    /**
     * Obtenir les coordonnées à partir d'une adresse
     */
    public function obtenirCoordonnees(Request $request)
    {
        $request->validate([
            'adresse' => 'required|string|max:500'
        ]);

        try {
            $coordonnees = $this->geolocalisationService->obtenirCoordonnees($request->adresse);
            
            return response()->json([
                'success' => true,
                'coordonnees' => $coordonnees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'obtention des coordonnées'
            ], 500);
        }
    }

    /**
     * Valider une adresse
     */
    public function validerAdresse(Request $request)
    {
        $request->validate([
            'adresse' => 'required|string|max:500'
        ]);

        $isValid = $this->geolocalisationService->validerAdresse($request->adresse);
        
        return response()->json([
            'success' => true,
            'valide' => $isValid
        ]);
    }

    /**
     * Calculer la distance entre deux points
     */
    public function calculerDistance(Request $request)
    {
        $request->validate([
            'lat1' => 'required|numeric',
            'lon1' => 'required|numeric',
            'lat2' => 'required|numeric',
            'lon2' => 'required|numeric'
        ]);

        $distance = $this->geolocalisationService->calculerDistance(
            $request->lat1,
            $request->lon1,
            $request->lat2,
            $request->lon2
        );

        return response()->json([
            'success' => true,
            'distance' => $distance,
            'temps_estime' => $this->geolocalisationService->calculerTempsLivraison($distance)
        ]);
    }
}