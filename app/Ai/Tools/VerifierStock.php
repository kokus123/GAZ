<?php

namespace App\Ai\Tools;

use App\Models\Stock;
use Laravel\Ai\Contracts\Tool;

class VerifierStock implements Tool
{
    public function name(): string { return 'verifier_stock'; }

    public function description(): string
    {
        return 'Vérifie les bouteilles de gaz disponibles sur la plateforme (type, prix, vendeur).';
    }

    public function handle(): string
    {
        $stocks = Stock::disponibles()
            ->where('quantite_disponible', '>', 0)
            ->with('vendeur:id,name,quartier')
            ->limit(5)
            ->get();

        if ($stocks->isEmpty()) {
            return 'Aucun stock disponible pour le moment.';
        }

        return $stocks->map(fn($s) =>
            "• {$s->type_gaz} {$s->unite} — " .
            number_format($s->prix_unitaire, 0, ',', ' ') . " FCFA — " .
            "Qté: {$s->quantite_disponible} — " .
            "Vendeur: {$s->vendeur->name} ({$s->vendeur->quartier})"
        )->join("\n");
    }
}
