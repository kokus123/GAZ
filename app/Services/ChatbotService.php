<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatbotService
{
    public function repondre(string $message, array $historique = []): string
    {
        // Construire l'historique au format Gemini
        $contents = [];

        foreach ($historique as $h) {
            $contents[] = [
                'role'  => $h['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $h['content']]]
            ];
        }

        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $message]]
        ];

        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . config('services.gemini.key'),
            [
                'system_instruction' => [
                    'parts' => [[
                        'text' => "Tu es l'assistant virtuel officiel de GazExpress, une plateforme
de commande et livraison de gaz domestique au Cameroun.

TON RÔLE : Aider uniquement les clients de GazExpress avec des questions
liées à la plateforme et au gaz domestique.

TU PEUX RÉPONDRE À :
- Comment passer une commande de gaz sur GazExpress
- Les types de bouteilles disponibles (6kg, 12kg, etc.)
- Les modes de paiement acceptés (Mobile Money Orange/MTN/Moov, carte, espèces)
- Le suivi de livraison et les statuts de commande
- Les délais et zones de livraison
- Comment télécharger un reçu après paiement
- La géolocalisation et l'attribution du vendeur le plus proche
- Comment créer un compte ou se connecter
- Les urgences gaz : fuite, odeur suspecte → toujours orienter vers le 18 (pompiers)
- Signalement à la police ou aux pompiers via la plateforme

TU NE RÉPONDS PAS À :
- Des questions sans rapport avec GazExpress ou le gaz domestique
- De la politique, des blagues, de la météo, du sport, etc.
- Des demandes de code ou d'aide technique non liées à la plateforme

SI quelqu'un pose une question hors sujet, réponds poliment :
'Je suis l'assistant GazExpress, je ne peux répondre qu'aux questions
concernant notre service de livraison de gaz. Comment puis-je vous aider
avec votre commande ?'

EN CAS D'URGENCE GAZ (fuite, odeur forte, explosion) :
Dis IMMÉDIATEMENT : 'URGENCE ! Quittez les lieux maintenant et appelez
les pompiers au 18. N'allumez aucun appareil électrique.'

Réponds toujours en français, de façon courte, claire et professionnelle."
                    ]]
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'maxOutputTokens' => 300,
                    'temperature'     => 0.4,
                ]
            ]
        );

        return $response->json('candidates.0.content.parts.0.text')
            ?? "Désolé, je suis momentanément indisponible. Appelez le 18 en cas d'urgence.";
    }
}
