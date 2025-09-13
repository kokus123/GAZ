<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllee;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\SignalementController;
use App\Http\Controllers\ReçuController;
use App\Http\Controllers\GeolocalisationController;
use App\Http\Controllers\PaymentServiceController;


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

// Route racine
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Welcome / catalogue
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome'); 

    Route::get('/visite', function () {
        return view('visite');
    })->name('visite');

// Routes pour les commandes
Route::middleware(['auth'])->group(function () {
    Route::resource('commandes', CommandeController::class);
    Route::post('/commandes/{commande}/confirmer', [CommandeController::class, 'confirmer'])->name('commandes.confirmer');
    Route::post('/commandes/{commande}/annuler', [CommandeController::class, 'annuler'])->name('commandes.annuler');
});

// Routes pour les stocks (vendeurs et admin)
Route::middleware(['auth', 'is_vendeur'])->group(function () {
    Route::resource('stocks', StockController::class);
});

// Routes pour les livraisons (vendeurs et admin)
Route::middleware(['auth'])->group(function () {
    Route::resource('livraisons', LivraisonController::class);
    Route::post('/livraisons/{livraison}/demarrer', [LivraisonController::class, 'demarrer'])->name('livraisons.demarrer');
    Route::post('/livraisons/{livraison}/finaliser', [LivraisonController::class, 'finaliser'])->name('livraisons.finaliser');
});

// Routes pour les paiements
Route::middleware(['auth'])->group(function () {
    Route::resource('paiements', PaiementController::class);
    Route::post('/paiements/mobile-money', [PaymentServiceController::class, 'initierMobileMoney'])->name('paiements.mobile-money');
    Route::post('/paiements/carte', [PaymentServiceController::class, 'traiterCarte'])->name('paiements.carte');
    Route::get('/paiements/{paiement}/verifier', [PaymentServiceController::class, 'verifier'])->name('paiements.verifier');
});

// Routes pour les signalements
Route::middleware(['auth'])->group(function () {
    Route::resource('signalements', SignalementController::class);
    Route::post('/signalements/police', [SignalementController::class, 'signalerPolice'])->name('signalements.police');
    Route::post('/signalements/pompiers', [SignalementController::class, 'signalerPompiers'])->name('signalements.pompiers');
});

// Routes pour les reçus
Route::middleware(['auth'])->group(function () {
    Route::get('/reçus/{reçu}/telecharger', [ReçuController::class, 'telecharger'])->name('reçus.telecharger');
});

// Routes pour la géolocalisation
Route::post('/geolocalisation/coordonnees', [GeolocalisationController::class, 'obtenirCoordonnees'])->name('geolocalisation.coordonnees');

// Routes de déconnexion
Route::post('/logout', [AuthControllee::class, 'logout'])->name('logout');

// Routes de dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboardv', [DashboardController::class, 'index'])->name('dashboardv')->middleware('auth');
Route::get('/dashboardc', [DashboardController::class, 'index'])->name('dashboardc')->middleware('auth');
