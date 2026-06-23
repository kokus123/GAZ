<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\GeolocalisationController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PaymentServiceController;
use App\Http\Controllers\ReçuController;
use App\Http\Controllers\SignalementController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendeurProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Pages publiques
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::get('/visite', function () {
    return view('visite');
})->name('visite');



/*
|--------------------------------------------------------------------------
| ROUTES D'AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

// Connexion
Route::get('/connexion', function () {
    return view('connexion');
})->name('connexion');

Route::get('/login', function () {
    return view('connexion');
})->name('login');

Route::post('/connexion', [AuthController::class, 'login'])->name('connexion.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Inscription
Route::get('/inscription', [AuthController::class, 'showInscriptionForm'])->name('inscription.form');
Route::get('/register', [AuthController::class, 'showInscriptionForm'])->name('register');

Route::post('/inscription', [AuthController::class, 'store'])->name('inscription.store');
Route::post('/register', [AuthController::class, 'store'])->name('register.submit');

// Mot de passe oublié
Route::get('/Mot-de-passe', function () {
    return view('Mot-de-passe');
})->name('forgot');

Route::get('/forgot-password', function () {
    return view('Mot-de-passe');
})->name('password.request');

Route::post('/Mot-de-passe', [AuthController::class, 'mdpOublier'])->name('mdpOublier');
Route::post('/forgot-password', [AuthController::class, 'mdpOublier'])->name('password.email');

// Réinitialisation de mot de passe
Route::get('/reset-password/{token}', function () {
    return view('Mot-de-passe');
})->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'mdpOublier'])->name('password.update');

// Confirmation de mot de passe
Route::get('/confirm-password', function () {
    return view('connexion');
})->name('password.confirm');

Route::post('/confirm-password', [AuthController::class, 'login'])->name('password.confirm.submit');

// Vérification d'email
Route::get('/verify-email', function () {
    return view('connexion');
})->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'repondre'])->name('chatbot.repondre');

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES PAR AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/agent-ia', function () {
        return view('agentia');
    })->name('agent-ia');


    // Dashboards
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboardv', [DashboardController::class, 'index'])
    ->middleware('localisation.vendeur')
    ->name('dashboardv');
    Route::get('/dashboardc', [DashboardController::class, 'index'])->name('dashboardc');

    // Commandes
    Route::resource('commandes', CommandeController::class);
    Route::post('/commandes/{commande}/confirmer', [CommandeController::class, 'confirmer'])->name('commandes.confirmer');
    Route::post('/commandes/{commande}/annuler', [CommandeController::class, 'annuler'])->name('commandes.annuler');

    // Catalogue + panier (nouveau flux client : choisir vendeur -> catalogue -> panier)
    Route::get('/commandes/vendeur/{vendeur}/catalogue', [CommandeController::class, 'catalogueVendeur'])
        ->name('commandes.catalogue-vendeur');
    Route::post('/commandes/panier/ajouter', [CommandeController::class, 'ajouterAuPanier'])
        ->name('commandes.panier.ajouter');
    Route::post('/commandes/panier/retirer', [CommandeController::class, 'retirerDuPanier'])
        ->name('commandes.panier.retirer');
    Route::get('/commandes/panier', [CommandeController::class, 'voirPanier'])
        ->name('commandes.panier');
    Route::post('/commandes/panier/valider', [CommandeController::class, 'validerPanier'])
        ->name('commandes.panier.valider');

    // Catalogue vendeur (le vendeur gère ses propres produits avec photos)
    Route::get('/vendeur/catalogue', [CatalogueController::class, 'index'])
        ->name('vendeur.catalogue.index');
    Route::get('/vendeur/catalogue/creer', [CatalogueController::class, 'create'])
        ->name('vendeur.catalogue.create');
    Route::post('/vendeur/catalogue', [CatalogueController::class, 'store'])
        ->name('vendeur.catalogue.store');
    Route::get('/vendeur/catalogue/{stock}/editer', [CatalogueController::class, 'edit'])
        ->name('vendeur.catalogue.edit');
    Route::put('/vendeur/catalogue/{stock}', [CatalogueController::class, 'update'])
        ->name('vendeur.catalogue.update');
    Route::delete('/vendeur/catalogue/{stock}', [CatalogueController::class, 'destroy'])
        ->name('vendeur.catalogue.destroy');

    // Profil vendeur — localisation
    Route::get('/vendeur/profil/completer', [VendeurProfilController::class, 'completer'])
        ->name('vendeur.profil.completer');
    Route::post('/vendeur/profil/enregistrer', [VendeurProfilController::class, 'enregistrer'])
        ->name('vendeur.profil.enregistrer');
    Route::get('/vendeur/profil/modifier', [VendeurProfilController::class, 'modifier'])
        ->name('vendeur.profil.modifier');

    // Livraisons
    Route::resource('livraisons', LivraisonController::class);
    Route::post('/livraisons/{livraison}/demarrer', [LivraisonController::class, 'demarrer'])->name('livraisons.demarrer');
    Route::post('/livraisons/{livraison}/finaliser', [LivraisonController::class, 'finaliser'])->name('livraisons.finaliser');

    // Paiements
    Route::resource('paiements', PaiementController::class);
    Route::post('/paiements/mobile-money', [PaymentServiceController::class, 'initierMobileMoney'])->name('paiements.mobile-money');
    Route::post('/paiements/carte', [PaymentServiceController::class, 'traiterCarte'])->name('paiements.carte');
    Route::get('/paiements/{paiement}/verifier', [PaymentServiceController::class, 'verifier'])->name('paiements.verifier');

    // Signalements
    Route::resource('signalements', SignalementController::class);
    Route::post('/signalements/police', [SignalementController::class, 'signalerPolice'])->name('signalements.police');
    Route::post('/signalements/pompiers', [SignalementController::class, 'signalerPompiers'])->name('signalements.pompiers');
    // Dans web.php, à l’intérieur du groupe auth
    Route::get('/signalements/creer/police', [SignalementController::class, 'createPolice'])->name('signalements.create.police');
Route::get('/signalements/creer/pompiers', [SignalementController::class, 'createPompiers'])->name('signalements.create.pompiers');

    // Reçus
    Route::get('/reçus/{reçu}/telecharger', [ReçuController::class, 'telecharger'])->name('reçus.telecharger');

    // Géolocalisation
    Route::post('/geolocalisation/coordonnees', [GeolocalisationController::class, 'obtenirCoordonnees'])->name('geolocalisation.coordonnees');

    // Commande (redirection)
    Route::get('/commande', function () {
        return view('commande');
    })->name('commande');

    Route::post('/commande', [AuthController::class, 'storeCommande'])->name('commande.store');

    // Paramètres
    Route::get('/settings/profile', \App\Livewire\Settings\Profile::class)->name('settings.profile');
    Route::get('/settings/password', \App\Livewire\Settings\Password::class)->name('settings.password');
    Route::get('/settings/appearance', \App\Livewire\Settings\Appearance::class)->name('settings.appearance');
    Route::get('/settings/delete-user', \App\Livewire\Settings\DeleteUserForm::class)->name('settings.delete-user');
});

/*
|--------------------------------------------------------------------------
| ROUTES VENDEURS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_vendeur_or_admin'])->group(function () {
    // Gestion des stocks
    Route::resource('stocks', StockController::class);
});

/*
|--------------------------------------------------------------------------
| ROUTES ADMINISTRATEURS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'index'])->name('Admin.users.index');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
});