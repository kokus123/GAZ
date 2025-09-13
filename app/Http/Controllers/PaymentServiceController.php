<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\Commande;
use App\Models\Paiement;

class PaymentServiceController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Initier un paiement Mobile Money
     */
    public function initierMobileMoney(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'numero_telephone' => 'required|string|max:20',
            'operateur' => 'required|in:orange,mtn,moov'
        ]);

        $commande = Commande::findOrFail($request->commande_id);
        
        $result = $this->paymentService->initierPaiementMobileMoney(
            $commande,
            $request->numero_telephone,
            $request->operateur
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'paiement' => $result['paiement']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 400);
    }

    /**
     * Traiter un paiement par carte bancaire
     */
    public function traiterCarte(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'numero_carte' => 'required|string|max:20',
            'type_carte' => 'required|in:visa,mastercard'
        ]);

        $commande = Commande::findOrFail($request->commande_id);
        
        $result = $this->paymentService->traiterPaiementCarte(
            $commande,
            $request->only(['numero_carte', 'type_carte'])
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'paiement' => $result['paiement']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 400);
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function verifier(Paiement $paiement)
    {
        $isValid = $this->paymentService->verifierStatutPaiement($paiement);
        
        return response()->json([
            'success' => true,
            'valide' => $isValid,
            'statut' => $paiement->statut
        ]);
    }
}