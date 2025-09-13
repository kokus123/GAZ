<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Afficher tous les utilisateurs
    public function index()
    {
        $users = User::all();

        return view('dashboardv', compact('users'));
    }

    //  Ajouter un utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Utilisateur ajouté avec succès');
    }

    // Modifier un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->except(['_token', '_method']));

        return back()->with('success', 'Utilisateur modifié');
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        User::destroy($id);

        return back()->with('success', 'Utilisateur supprimé');
    }
}
