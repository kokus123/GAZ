<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllee;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminController;


// Routes protégées par auth (vendeur)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboardv', [UserController::class, 'index'])->name('dashboardv');
//     Route::post('/vendeur/users', [UserController::class, 'store'])->name('users.store');
//     Route::put('/vendeur/users/{id}', [UserController::class, 'update'])->name('users.update');
//     Route::delete('/vendeur/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
// });

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('Admin.users.index');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('Admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('Admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('Admin.users.destroy');
});
// Page inscription
    Route::get('/inscription', [AuthControllee::class, 'showInscriptionForm'])->name('inscription.form');
    Route::post('/inscription', [AuthControllee::class, 'store'])->name('inscription.store');

// Page connexion
    Route::get('/connexion', function () {
        return view('connexion');
    })->name('connexion');
    Route::post('/connexion', [AuthControllee::class, 'login'])->name('connexion.login');



// Mot de passe oublié
    Route::get('/Mot-de-passe', function () {
        return view('Mot-de-passe');
    })->name('forgot');
    Route::post('/Mot-de-passe', [AuthControllee::class, 'mdpOublier'])->name('mdpOublier');

    Route::get('/commande', function () {
        return view('commande');
    })->name('commande');
    Route::post('/commande', [AuthControllee::class, 'storeCommande'])->name('commande.store');

    Route::get('/dashboardc', function () {
        return view('dashboardc');
    })->name('dashboardc')->middleware('auth');

// Welcome / catalogue
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome'); 

    Route::get('/visite', function () {
        return view('visite');
    })->name('visite');
