<?php

namespace App\Ai\Tools;

use Laravel\Ai\Contracts\Tool;

class InfosUrgence implements Tool
{
    public function name(): string { return 'infos_urgence'; }

    public function description(): string
    {
        return 'Fournit les numéros d\'urgence et les consignes de sécurité en cas de fuite ou incident gaz.';
    }

    public function handle(): string
    {
        return implode("\n", [
            '🚨 CONSIGNES URGENCE GAZ :',
            '1. Fermez immédiatement la vanne de la bouteille',
            '2. N\'allumez aucun interrupteur, pas de flamme',
            '3. Ouvrez portes et fenêtres pour aérer',
            '4. Évacuez les personnes',
            '5. Appelez depuis l\'extérieur :',
            '   • Pompiers : 118',
            '   • Police   : 117',
            '   • Support GazApp : +237 6XX XXX XXX',
        ]);
    }
}
