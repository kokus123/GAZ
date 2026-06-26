<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function repondre(Request $request)
    {
        $request->validate([
            'message'         => 'required|string|max:500',
            'conversation_id' => 'nullable|string',
        ]);

        try {
            $reponse = $this->appelGroq($request->message);

            return response()->json([
                'reponse' => $reponse,
                'success' => true,
            ]);

        } catch (\Exception $e) {
            Log::error('GazBot error: ' . $e->getMessage());

            return response()->json([
                'reponse' => '🔧 Erreur : ' . $e->getMessage(),
                'success' => false,
            ], 200);
        }
    }

    private function appelGroq(string $message): string
    {
        $user = Auth::user();

        // ✅ Utilise config() au lieu de env() directement
        $apiKey = config('services.groq.api_key');

        if (empty($apiKey)) {
            throw new \Exception('Clé API Groq non configurée. Vérifie GROQ_API_KEY dans .env');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant', // ✅ Modèle qui fonctionne (gratuit)
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => "Tu es GazBot, l'assistant IA de GazApp, une plateforme de livraison de gaz à Douala, Cameroun. L'utilisateur connecté s'appelle {$user->name}. Réponds toujours en français, de façon chaleureuse et concise.",
                ],
                [
                    'role'    => 'user',
                    'content' => $message,
                ],
            ],
            'temperature' => 0.7,
            'max_tokens'  => 500,
        ]);

        if ($response->failed()) {
            $body = $response->body();
            Log::error('Groq API error: ' . $body);
            throw new \Exception('Erreur de l\'API Groq : ' . $body);
        }

        return $response->json('choices.0.message.content');
    }
}
        