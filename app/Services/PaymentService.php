<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.payment.api_url', 'https://api.payment.example.com');
        $this->apiKey = config('services.payment.api_key', 'your-api-key');
    }

    /**
     * Initier un paiement Mobile Money
     */
    public function initierPaiementMobileMoney($commande, $numeroTelephone, $operateur)
    {
        try {
            $paiement = Paiement::create([
                'commande_id' => $commande->id,
                'numero_transaction' => $this->genererNumeroTransaction(),
                'montant' => $commande->prix_total,
                'methode' => 'mobile_money',
                'statut' => 'en_attente',
                'numero_telephone' => $numeroTelephone,
                'operateur' => $operateur,
            ]);

            // Simulation d'appel API Mobile Money
            $response = $this->simulerAppelMobileMoney($paiement);

            if ($response['success']) {
                $paiement->update([
                    'details_transaction' => json_encode($response),
                ]);

                return [
                    'success' => true,
                    'paiement' => $paiement,
                    'message' => 'Paiement initié avec succès'
                ];
            } else {
                $paiement->marquerEchec();
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Erreur lors de l\'initiation du paiement'
                ];
            }

        } catch (\Exception $e) {
            Log::error('Erreur paiement Mobile Money: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur technique lors du paiement'
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function verifierStatutPaiement(Paiement $paiement)
    {
        try {
            // Simulation de vérification
            $response = $this->simulerVerificationPaiement($paiement);

            if ($response['statut'] === 'valide') {
                $paiement->valider();
                $this->finaliserCommande($paiement->commande);
                return true;
            } elseif ($response['statut'] === 'echec') {
                $paiement->marquerEchec();
                return false;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Erreur vérification paiement: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Traiter un paiement par carte bancaire
     */
    public function traiterPaiementCarte($commande, $donneesCarte)
    {
        try {
            $paiement = Paiement::create([
                'commande_id' => $commande->id,
                'numero_transaction' => $this->genererNumeroTransaction(),
                'montant' => $commande->prix_total,
                'methode' => 'carte_bancaire',
                'statut' => 'en_attente',
                'details_transaction' => json_encode([
                    'numero_carte' => substr($donneesCarte['numero_carte'], -4),
                    'type_carte' => $donneesCarte['type_carte'] ?? 'visa'
                ]),
            ]);

            // Simulation de traitement carte
            $response = $this->simulerPaiementCarte($paiement);

            if ($response['success']) {
                $paiement->valider();
                $this->finaliserCommande($commande);
                return [
                    'success' => true,
                    'paiement' => $paiement,
                    'message' => 'Paiement effectué avec succès'
                ];
            } else {
                $paiement->marquerEchec();
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Paiement refusé'
                ];
            }

        } catch (\Exception $e) {
            Log::error('Erreur paiement carte: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur technique lors du paiement'
            ];
        }
    }

    /**
     * Finaliser une commande après paiement validé
     */
    private function finaliserCommande(Commande $commande)
    {
        $commande->update(['statut' => 'confirmee']);
        
        // Créer une livraison
        $commande->livraisons()->create([
            'vendeur_id' => $commande->vendeur_id,
            'numero_livraison' => 'LIV-' . date('Ymd') . '-' . str_pad($commande->id, 4, '0', STR_PAD_LEFT),
            'statut' => 'programmee',
            'adresse_livraison' => $commande->adresse_livraison,
            'latitude' => $commande->latitude,
            'longitude' => $commande->longitude,
            'date_livraison_prevue' => $commande->date_livraison_prevue,
        ]);
    }

    /**
     * Générer un numéro de transaction unique
     */
    private function genererNumeroTransaction()
    {
        return 'TXN-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }

    /**
     * Simuler un appel API Mobile Money
     */
    private function simulerAppelMobileMoney(Paiement $paiement)
    {
        // Simulation - 90% de succès
        $success = rand(1, 10) <= 9;
        
        return [
            'success' => $success,
            'transaction_id' => 'MM-' . time(),
            'message' => $success ? 'Paiement initié' : 'Numéro de téléphone invalide',
            'statut' => $success ? 'en_attente' : 'echec'
        ];
    }

    /**
     * Simuler la vérification d'un paiement
     */
    private function simulerVerificationPaiement(Paiement $paiement)
    {
        // Simulation - 85% de validation
        $valide = rand(1, 100) <= 85;
        
        return [
            'statut' => $valide ? 'valide' : 'echec',
            'transaction_id' => 'MM-' . time(),
            'message' => $valide ? 'Paiement validé' : 'Paiement échoué'
        ];
    }

    /**
     * Simuler un paiement par carte
     */
    private function simulerPaiementCarte(Paiement $paiement)
    {
        // Simulation - 80% de succès
        $success = rand(1, 10) <= 8;
        
        return [
            'success' => $success,
            'transaction_id' => 'CARD-' . time(),
            'message' => $success ? 'Paiement effectué' : 'Carte refusée'
        ];
    }
}
