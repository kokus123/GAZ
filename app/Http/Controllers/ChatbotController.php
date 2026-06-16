<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function repondre(Request $request, ChatbotService $chatbot)
    {
        $request->validate([
            'message'    => 'required|string|max:500',
            'historique' => 'nullable|array',
        ]);

        $reponse = $chatbot->repondre(
            $request->message,
            $request->historique ?? []
        );

        return response()->json(['reponse' => $reponse]);
    }
}
