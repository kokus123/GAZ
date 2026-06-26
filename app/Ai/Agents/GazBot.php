<?php

namespace App\Ai\Agents;

use App\Ai\Tools\InfosUrgence;
use App\Ai\Tools\VerifierStock;
use App\Ai\Tools\VoirMesCommandes;
use App\Models\User;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;

class GazBot implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    // Modèle Groq rapide et gratuit
    protected string $provider = 'groq';
    protected string $model    = 'llama-3.3-70b-versatile';

    public function __construct(public User $user) {}

    public function instructions(): string
    {
        return <<<PROMPT
        Tu es GazBot, l'assistant IA de GazApp — plateforme de livraison de gaz à Douala, Cameroun.
        Utilisateur : {$this->user->name} (rôle : {$this->user->role})

        TES MISSIONS :
        - Consulter les commandes en temps réel avec l'outil voir_mes_commandes
        - Vérifier les stocks disponibles avec l'outil verifier_stock
        - Donner les consignes d'urgence avec l'outil infos_urgence
        - Expliquer comment passer commande, payer (Mobile Money Orange/MTN/Moov)

        RÈGLES :
        - Réponds toujours en français, de façon chaleureuse et concise
        - Pour toute urgence gaz, appelle IMMÉDIATEMENT l'outil infos_urgence
        - Utilise les outils avant de répondre sur commandes ou stock
        PROMPT;
    }

    public function tools(): iterable
    {
        return [
            new VoirMesCommandes,
            new VerifierStock,
            new InfosUrgence,
        ];
    }
}
