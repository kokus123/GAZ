<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher formulaire inscription
    public function showInscriptionForm()
    {
        return view('inscription');
    }

    // Enregistrer utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:client,vendeur',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Connexion automatique
        Auth::login($user);
        $request->session()->regenerate();

        // Redirection selon rôle
        return $user->role === 'vendeur'
            ? redirect()->route('dashboardv')
            : redirect()->route('dashboardc');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $user->role === 'vendeur'
                ? redirect()->route('dashboardv')
                : redirect()->route('dashboardc');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function mdpOublier(Request $request)
    {
        // Logique de réinitialisation de mot de passe
        return back()->with('success', 'Instructions envoyées par email');
    }

    public function storeCommande(Request $request)
    {
        // Rediriger vers le formulaire de commande
        return redirect()->route('commandes.create');
    }
}
