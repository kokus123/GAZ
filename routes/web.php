<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllee;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboardv', function () {
    return view('dashboardv');
})->name('dashboardv');

// Welcome / catalogue
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome'); 

Route::get('/visite', function () {
    return view('visite');
})->name('visite');
