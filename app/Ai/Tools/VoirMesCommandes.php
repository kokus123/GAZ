<?php

namespace App\Ai\Tools;

use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Laravel\Ai\Contracts\Tool;

class VoirMesCommandes implements Tool
{
    public function name(): string
    {
        return 'voir_mes_commandes';
    }

    public function description(): string
    {
        return 'Retourne les dernières commandes de l\'utilisateur connecté avec leur statut et montant.';
    }

    public function handle(): string
    {
        $user = Auth::user();

        $commandes = Commande::where('client_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        if ($commandes->isEmpty()) {
            return 'Vous n\'avez aucune commande pour le moment.';
        }

        $statuts = [
            'en_attente'   => '⏳ En attente',
            'confirmee'    => '✅ Confirmée',
            'en_livraison' => '🚚 En livraison',
            'livree'       => '🎉 Livrée',
            'annulee'      => '❌ Annulée',
        ];

        return $commandes->map(fn($c) =>
            "#{$c->numero_commande} | " .
            ($statuts[$c->statut] ?? $c->statut) . " | " .
            number_format($c->prix_total, 0, ',', ' ') . " FCFA | " .
            $c->created_at->format('d/m/Y')
        )->join("\n");
    }
}
