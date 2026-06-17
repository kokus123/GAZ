@extends('layouts.sidebar')

@section('title', 'Détails de la Livraison')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <a href="{{ route('livraisons.index') }}" class="text-gray-400 hover:text-green-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Livraison <span class="text-green-600">#{{ $livraison->id }}</span></h1>
        </div>
        <p class="text-sm text-gray-500 ml-8">Créée le {{ $livraison->created_at->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="flex items-center gap-3">
        @if($livraison->statut === 'en_cours')
            <form action="{{ route('livraisons.finaliser', $livraison) }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Finaliser la livraison
                </button>
            </form>
        @endif
        <a href="{{ route('livraisons.edit', $livraison) }}"
           class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-green-300 text-gray-700 hover:text-green-700 font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Modifier
        </a>
    </div>
</div>

{{-- ── Badge statut central ── --}}
<div class="mb-6">
    @if($livraison->statut === 'en_cours')
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">
            <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
            Livraison en cours
        </span>
    @elseif($livraison->statut === 'livrée')
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-green-50 text-green-700 border border-green-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Livraison effectuée
        </span>
    @elseif($livraison->statut === 'annulée')
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-red-50 text-red-700 border border-red-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            Livraison annulée
        </span>
    @endif
</div>

{{-- ── Grille infos ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Infos livraison --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            </div>
            <h2 class="text-base font-bold text-gray-900">Informations livraison</h2>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                <span class="text-sm text-gray-500">ID Livraison</span>
                <span class="text-sm font-semibold text-gray-900">#{{ $livraison->id }}</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                <span class="text-sm text-gray-500">Statut</span>
                <span class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $livraison->statut)) }}</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                <span class="text-sm text-gray-500">Créée le</span>
                <span class="text-sm font-semibold text-gray-900">{{ $livraison->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-gray-500">Date prévue</span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $livraison->date_livraison_prevue ? $livraison->date_livraison_prevue->format('d/m/Y H:i') : '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Infos commande --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h2 class="text-base font-bold text-gray-900">Informations commande</h2>
        </div>
        @if($livraison->commande)
            <div class="px-6 py-5 space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">N° commande</span>
                    <span class="text-sm font-bold text-green-700">{{ $livraison->commande->numero_commande }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Client</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $livraison->commande->nom_client }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Téléphone</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $livraison->commande->telephone }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Quantité</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $livraison->commande->quantite }} bouteille(s)</span>
                </div>
                <div class="py-3">
                    <span class="text-sm text-gray-500 block mb-1">Adresse de livraison</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $livraison->commande->adresse_livraison }}</span>
                </div>
            </div>
        @else
            <div class="px-6 py-8 flex flex-col items-center gap-2 text-center">
                <svg class="w-8 h-8 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-red-600 font-medium">Commande introuvable</p>
            </div>
        @endif
    </div>
</div>

{{-- ── Notes ── --}}
@if($livraison->notes)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h2 class="text-base font-bold text-gray-900">Notes</h2>
        </div>
        <div class="px-6 py-5">
            <p class="text-sm text-gray-700 leading-relaxed">{{ $livraison->notes }}</p>
        </div>
    </div>
@endif

@endsection