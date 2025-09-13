<?php

namespace App\Http\Controllers;

use App\Models\Reçu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReçuController extends Controller
{
    /**
     * Télécharger un reçu
     */
    public function telecharger(Reçu $reçu)
    {
        $this->authorize('view', $reçu);
        
        if (!$reçu->existe()) {
            return back()->withErrors(['error' => 'Le fichier reçu n\'existe pas.']);
        }

        // Marquer comme téléchargé
        $reçu->marquerTelecharge();

        return response()->download($reçu->chemin_complet, $reçu->numero_reçu . '.pdf');
    }

    /**
     * Afficher un reçu
     */
    public function show(Reçu $reçu)
    {
        $this->authorize('view', $reçu);
        $reçu->load(['commande.client', 'paiement']);
        return view('reçus.show', compact('reçu'));
    }

    /**
     * Générer un nouveau reçu
     */
    public function generer(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'paiement_id' => 'required|exists:paiements,id'
        ]);

        $commande = \App\Models\Commande::with(['client', 'vendeur', 'paiements'])->findOrFail($request->commande_id);
        $paiement = \App\Models\Paiement::findOrFail($request->paiement_id);

        // Vérifier que le paiement est valide
        if (!$paiement->isValide()) {
            return back()->withErrors(['error' => 'Le paiement doit être validé pour générer un reçu.']);
        }

        // Créer le reçu
        $reçu = Reçu::create([
            'commande_id' => $commande->id,
            'paiement_id' => $paiement->id,
            'numero_reçu' => 'REC-' . date('Ymd') . '-' . str_pad(Reçu::count() + 1, 4, '0', STR_PAD_LEFT),
            'chemin_fichier' => 'receipts/rec-' . date('Ymd') . '-' . str_pad(Reçu::count() + 1, 4, '0', STR_PAD_LEFT) . '.pdf',
            'date_generation' => now()
        ]);

        // Générer le PDF (simulation)
        $this->genererPDF($reçu, $commande, $paiement);

        return redirect()->route('reçus.show', $reçu)
            ->with('success', 'Reçu généré avec succès !');
    }

    /**
     * Générer le PDF du reçu
     */
    private function genererPDF(Reçu $reçu, $commande, $paiement)
    {
        // Créer le dossier s'il n'existe pas
        $directory = storage_path('app/receipts');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Contenu du reçu (simulation)
        $content = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reçu - {$reçu->numero_reçu}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; }
                .info { margin: 20px 0; }
                .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                .total { font-weight: bold; font-size: 18px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>GAZAPP</h1>
                <h2>Reçu de Paiement</h2>
                <p>N° {$reçu->numero_reçu}</p>
            </div>
            
            <div class='info'>
                <p><strong>Date:</strong> {$reçu->date_generation->format('d/m/Y H:i')}</p>
                <p><strong>Client:</strong> {$commande->client->name}</p>
                <p><strong>Email:</strong> {$commande->client->email}</p>
                <p><strong>Téléphone:</strong> {$commande->telephone}</p>
            </div>
            
            <table class='table'>
                <tr>
                    <th>Description</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Gaz {$commande->type_gaz ?? 'Propane'}</td>
                    <td>{$commande->quantite} kg</td>
                    <td>" . number_format($commande->prix_unitaire, 0, ',', ' ') . " FCFA</td>
                    <td>" . number_format($commande->prix_total, 0, ',', ' ') . " FCFA</td>
                </tr>
            </table>
            
            <div class='total'>
                <p>Total: " . number_format($commande->prix_total, 0, ',', ' ') . " FCFA</p>
            </div>
            
            <div class='info'>
                <p><strong>Méthode de paiement:</strong> " . ucfirst($paiement->methode) . "</p>
                <p><strong>Transaction:</strong> {$paiement->numero_transaction}</p>
                <p><strong>Adresse de livraison:</strong> {$commande->adresse_livraison}</p>
            </div>
            
            <div style='margin-top: 40px; text-align: center;'>
                <p>Merci pour votre confiance !</p>
                <p>GazApp - Votre partenaire gaz de confiance</p>
            </div>
        </body>
        </html>";

        // Sauvegarder le fichier
        file_put_contents($reçu->chemin_complet, $content);
    }
}