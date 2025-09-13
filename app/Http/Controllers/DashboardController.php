<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isVendeur()) {
            return $this->vendeurDashboard();
        } else {
            return $this->clientDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_commandes' => Commande::count(),
            'total_stocks' => Stock::count(),
            'commandes_en_attente' => Commande::enAttente()->count(),
            'commandes_livrees' => Commande::livrees()->count(),
        ];

        $commandes_recentes = Commande::with(['client', 'vendeur'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'commandes_recentes'));
    }

    private function vendeurDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'mes_commandes' => Commande::where('vendeur_id', $user->id)->count(),
            'commandes_en_attente' => Commande::where('vendeur_id', $user->id)->enAttente()->count(),
            'commandes_livrees' => Commande::where('vendeur_id', $user->id)->livrees()->count(),
            'stock_total' => Stock::where('vendeur_id', $user->id)->sum('quantite_disponible'),
        ];

        $commandes_recentes = Commande::with(['client'])
            ->where('vendeur_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboardv', compact('stats', 'commandes_recentes'));
    }

    private function clientDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'mes_commandes' => Commande::where('client_id', $user->id)->count(),
            'commandes_en_attente' => Commande::where('client_id', $user->id)->enAttente()->count(),
            'commandes_livrees' => Commande::where('client_id', $user->id)->livrees()->count(),
        ];

        $commandes_recentes = Commande::with(['vendeur'])
            ->where('client_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboardc', compact('stats', 'commandes_recentes'));
    }
}
