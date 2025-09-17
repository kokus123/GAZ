@extends('layouts.app')

@section('title', 'Accueil - GazApp')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-primary to-secondary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-green-500 font-extrabold">
                Commandez votre gaz en ligne
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 text-green-500 font-semibold">
                Livraison rapide, paiement sécurisé, service de qualité
            </p>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('commandes.create') }}" 
                       class="bg-white text-primary px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Nouvelle Commande
                    </a>
                @else
                    <a href="{{ route('inscription.form') }}" 
                       class="bg-white text-black border-2 border-green-500 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-400 transition duration-300">
                        Commencer
                    </a>
                @endauth
                <a href="{{ route('visite') }}" 
                   class="bg-white text-black border-2 border-green-500 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-400 transition duration-300">
                    En savoir plus
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi choisir GazExpress ?</h2>
            <p class="text-lg text-gray-600">Une solution complète pour vos besoins en gaz domestique</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Livraison Rapide</h3>
                <p class="text-gray-600">Livraison sous 24h avec géolocalisation pour trouver le vendeur le plus proche</p>
            </div>

            <div class="text-center">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Paiement Sécurisé</h3>
                <p class="text-gray-600">Mobile Money, carte bancaire ou espèces - paiement 100% sécurisé</p>
            </div>

            <div class="text-center">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Sécurité Garantie</h3>
                <p class="text-gray-600">Signalement direct à la police en cas de problème - votre sécurité est notre priorité</p>
            </div>
        </div>
    </div>
</div>

<!-- How it works Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Comment ça marche ?</h2>
            <p class="text-lg text-gray-600">3 étapes simples pour commander votre gaz</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-primary">1</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Commandez en ligne</h3>
                <p class="text-gray-600">Remplissez le formulaire avec vos informations et votre localisation</p>
            </div>

            <div class="text-center">
                <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-primary">2</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Payez sécurisé</h3>
                <p class="text-gray-600">Choisissez votre méthode de paiement préférée et payez en toute sécurité</p>
            </div>

            <div class="text-center">
                <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-primary">3</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Recevez votre gaz</h3>
                <p class="text-gray-600">Livraison rapide par le vendeur le plus proche de chez vous</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-16 bg-primary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4 text-green-300">Prêt à commander ?</h2>
        <p class="text-xl mb-8 text-blue-500">Rejoignez des milliers de clients satisfaits</p>
        @auth
            <a href="{{ route('commandes.create') }}" 
               class="bg-white text-primary px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300">
                Créer une commande
            </a>
        @else
            <a href="{{ route('inscription.form') }}" 
               class="bg-white text-primary px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-500 transition duration-300">
                S'inscrire maintenant
            </a>
        @endauth
    </div>
</div>
@endsection