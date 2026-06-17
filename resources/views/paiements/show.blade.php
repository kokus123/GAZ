@extends('layouts.sidebar')

@section('title', 'Paiement #{{ $paiement->id }} — GazApp')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
            <a href="{{ route('paiements.index') }}" class="hover:text-green-600 transition-colors">Paiements</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Paiement #{{ $paiement->id }}</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Détails du Paiement</h1>
    </div>
    <div class="flex gap-3">
        @if($paiement->statut === 'en_attente')
            <a href="{{ route('paiements.verifier', $paiement) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-600 text-white text-sm font-600 hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Vérifier
            </a>
        @endif
        <a href="{{ route('paiements.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-600 text-sm font-600 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour
        </a>
    </div>
</div>

{{-- ── Statut en haut ── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-500">Montant</p>
            <p class="text-xl font-800 text-green-700">{{ number_format($paiement->montant, 0, ',', ' ') }} <span class="text-sm font-600">FCFA</span></p>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-500">Méthode</p>
            <p class="text-sm font-700 text-gray-700">{{ ucfirst(str_replace('_', ' ', $paiement->methode_paiement)) }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl
            @if($paiement->statut === 'payé') bg-green-50
            @elseif($paiement->statut === 'en_attente') bg-yellow-50
            @else bg-red-50
            @endif flex items-center justify-center flex-shrink-0">
            @if($paiement->statut === 'payé')
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @elseif($paiement->statut === 'en_attente')
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
        </div>
        <div>
            <p class="text-xs text-gray-400 font-500">Statut</p>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-700
                @if($paiement->statut === 'en_attente') bg-yellow-100 text-yellow-700
                @elseif($paiement->statut === 'payé') bg-green-100 text-green-700
                @elseif($paiement->statut === 'échoué') bg-red-100 text-red-700
                @elseif($paiement->statut === 'annulé') bg-gray-100 text-gray-600
                @else bg-gray-100 text-gray-600
                @endif">
                <span class="w-1.5 h-1.5 rounded-full
                    @if($paiement->statut === 'en_attente') bg-yellow-500
                    @elseif($paiement->statut === 'payé') bg-green-500
                    @else bg-red-500
                    @endif"></span>
                {{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}
            </span>
        </div>
    </div>
</div>

{{-- ── Grille détails ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Infos paiement ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5">Informations du Paiement</h2>
        <div class="space-y-3">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">ID Paiement</span>
                <span class="text-xs font-mono font-700 text-gray-600 bg-gray-50 px-2 py-1 rounded-lg">#{{ $paiement->id }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Date de création</span>
                <span class="text-sm font-600 text-gray-700">{{ $paiement->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Dernière mise à jour</span>
                <span class="text-sm font-600 text-gray-700">{{ $paiement->updated_at->format('d/m/Y H:i') }}</span>
            </div>
            @if($paiement->reference_transaction)
            <div class="flex justify-between items-center py-2">
                <span class="text-sm text-gray-500">Référence</span>
                <span class="text-xs font-mono font-700 text-gray-700 bg-gray-50 px-2 py-1 rounded-lg">{{ $paiement->reference_transaction }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Infos commande ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5">Informations de la Commande</h2>
        @if($paiement->commande)
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Numéro</span>
                    <span class="text-sm font-700 text-green-700">{{ $paiement->commande->numero_commande }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Client</span>
                    <span class="text-sm font-600 text-gray-700">{{ $paiement->commande->nom_client }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Téléphone</span>
                    <span class="text-sm font-600 text-gray-700">{{ $paiement->commande->telephone }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Quantité</span>
                    <span class="text-sm font-600 text-gray-700">{{ $paiement->commande->quantite }} bouteilles</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">Statut commande</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-700
                        @if($paiement->commande->statut === 'en_attente') bg-yellow-100 text-yellow-700
                        @elseif($paiement->commande->statut === 'confirmée') bg-blue-100 text-blue-700
                        @elseif($paiement->commande->statut === 'livrée') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $paiement->commande->statut)) }}
                    </span>
                </div>
            </div>
        @else
            <div class="flex items-center gap-2 text-red-500 bg-red-50 px-4 py-3 rounded-xl text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                Commande non trouvée
            </div>
        @endif
    </div>
</div>

{{-- ── Notes ── --}}
@if($paiement->notes)
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-3">Notes</h2>
        <p class="text-sm text-gray-600 leading-relaxed">{{ $paiement->notes }}</p>
    </div>
@endif

@endsection