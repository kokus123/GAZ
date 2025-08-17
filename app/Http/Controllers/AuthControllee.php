<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail; // ajout

class AuthControllee extends Controller
{
    public function showInscriptionForm()
    {
        return view('inscription');
    }
public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role'     => 'required',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
    ]);

    // Après inscription → page de connexion
    return redirect()->route('connexion')->with('success', 'Inscription réussie ! Veuillez vous connecter.');
}

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        // Après connexion → page dashboardv
        return redirect()->route('dashboardv');
    }

    return back()->withErrors([
        'email' => 'Vos identifiants sont incorrects'
    ]);
}
public function mdpOublier(Request $request)
{
    //dd($request->email);
    Mail::to($request->email)->send(new ResetPasswordMail()); // ajout
}
}


