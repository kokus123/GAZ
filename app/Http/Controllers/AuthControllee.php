<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControllee extends Controller
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6', 
            'role'     => 'required|in:client,vendeur',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
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
            'email'    => 'required|email',
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
}
