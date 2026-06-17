@extends('layouts.sidebar')

@section('title', 'Détails de la Commande')
@section('page-title', 'Détail commande')
@section('page-subtitle', 'Commande #{{ $commande->numero_commande }}')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- En-tête --}}
    <div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
        <div class="flex items-center gap-4">
            <a href="{{ route('commandes.index') }}"
               class="p-2 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-500 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Commande #{{ $commande->numero_commande }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">Créée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
        @php
            $badges = [
                'en_attente'  => 'bg:#FEF9C3; color:#854D0E;',
                'confirmée'   => 'bg:#DBEAFE; color:#1E40AF;',
                'en_livraison'=> 'bg:#EDE9FE; color:#6B21A8;',
                'livrée'      => 'bg:#DCFCE7; color:#166534;',
                'annulée'     => 'bg:#FEE2E2; color:#991B1B;',
                'payée'       => 'bg:#DCFCE7; color:#166534;',
            ];
            $badgeStyle = $badges[$commande->statut] ?? 'bg:#F3F4F6; color:#374151;';
        @endphp
        <span class="px-4 py-2 rounded-xl text-sm font-bold" style="{{ $badgeStyle }}">
            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Colonne principale --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Infos commande --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Détails de la commande</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-xs text-gray-500 font-medium mb-1">Quantité</p>
                            <p class="text-lg font-bold text-gray-900">{{ $commande->quantite }} <span class="text-sm font-normal text-gray-500">bouteilles</span></p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-xs text-gray-500 font-medium mb-1">Prix unitaire</p>
                            <p class="text-lg font-bold text-gray-900">{{ number_format($commande->prix_unitaire, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-500">FCFA</span></p>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl flex justify-between items-center"
                         style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1.5px solid #bbf7d0;">
                        <span class="text-sm font-semibold text-green-800">Prix total</span>
                        <span class="text-2xl font-extrabold" style="color:#15803D;">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            {{-- Adresse de livraison --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">📍 Adresse de livraison</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $commande->adresse_livraison }}</p>
                    @if($commande->latitude && $commande->longitude)
                        <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                            </svg>
                            GPS : {{ $commande->latitude }}, {{ $commande->longitude }}
                        </div>
                    @endif
                </div>
            </div>

            @if($commande->notes)
            <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $commande->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Colonne latérale --}}
        <div class="space-y-6">

            {{-- Informations client --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Client</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-white"
                             style="background:linear-gradient(135deg,#16A34A,#15803D);">
                            {{ strtoupper(substr($commande->nom_client, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $commande->nom_client }}</p>
                            <p class="text-xs text-gray-500">{{ $commande->telephone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dates --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Suivi</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Vendeur assigné</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $commande->vendeur->name ?? 'Non assigné' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Livraison prévue</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5">
                            {{ $commande->date_livraison_prevue ? $commande->date_livraison_prevue->format('d/m/Y H:i') : 'Non définie' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Livraison effective</p>
                        <p class="text-sm font-semibold mt-0.5" style="{{ $commande->date_livraison_effective ? 'color:#16A34A;' : 'color:#9CA3AF;' }}">
                            {{ $commande->date_livraison_effective ? $commande->date_livraison_effective->format('d/m/Y H:i') : 'En attente' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="space-y-2">
                @if($commande->statut === 'en_attente' && Auth::user()->isClient())
                    <form action="{{ route('commandes.annuler', $commande) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Annuler cette commande ?')"
                                class="w-full px-5 py-2.5 rounded-xl text-sm font-bold text-red-600 bg-red-50 border border-red-100 hover:bg-red-100 transition-colors">
                            ✕ Annuler la commande
                        </button>
                    </form>
                @endif
                @if($commande->statut === 'en_attente' && Auth::user()->isVendeur())
                    <form action="{{ route('commandes.confirmer', $commande) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105"
                                style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.3);">
                            ✓ Confirmer la commande
                        </button>
                    </form>
                @endif
                <a href="{{ route('commandes.index') }}"
                   class="w-full px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                    ← Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection