@extends('layouts.sidebar')

@section('title', 'Détails du Stock — GazApp')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Stock
                    <span class="text-green-600">#{{ $stock->id }}</span>
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">Détails complets du stock</p>
            </div>
        </div>
        <a href="{{ route('stocks.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                  hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </a>
    </div>

    {{-- Badge statut en haut --}}
    <div class="mb-6 flex items-center gap-3">
        @if($stock->disponible)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                Disponible
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                Indisponible
            </span>
        @endif
        <span class="text-xs text-gray-400">Mis à jour le {{ $stock->updated_at->format('d/m/Y à H:i') }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Informations du stock --}}
        <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">
            <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Informations du stock
                </h3>
                <dl class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">ID Stock</dt>
                        <dd class="text-sm font-semibold text-gray-900">#{{ $stock->id }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">Type de gaz</dt>
                        <dd class="text-sm font-semibold text-gray-900 capitalize">{{ $stock->type_gaz }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">Quantité disponible</dt>
                        <dd class="text-sm font-bold text-green-600">{{ number_format($stock->quantite_disponible) }} bouteilles</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">Prix unitaire</dt>
                        <dd class="text-sm font-bold text-gray-900">{{ number_format($stock->prix_unitaire, 0, ',', ' ') }} FCFA</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">Créé le</dt>
                        <dd class="text-sm text-gray-700">{{ $stock->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <dt class="text-sm text-gray-500">Dernière mise à jour</dt>
                        <dd class="text-sm text-gray-700">{{ $stock->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Informations vendeur --}}
        <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">
            <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informations vendeur
                </h3>
                @if($stock->vendeur)
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                             style="background:linear-gradient(135deg,#16A34A,#15803D);">
                            {{ strtoupper(substr($stock->vendeur->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $stock->vendeur->name }}</p>
                            <p class="text-sm text-gray-500">{{ $stock->vendeur->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($stock->vendeur->is_online)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                En ligne
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Hors ligne
                            </span>
                        @endif
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-28 gap-2 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="text-sm">Vendeur non trouvé</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($stock->description)
        <div class="mt-6 bg-white rounded-3xl shadow-sm border border-green-50 p-6">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Description
            </h3>
            <p class="text-sm text-gray-700 leading-relaxed">{{ $stock->description }}</p>
        </div>
    @endif

    {{-- Actions --}}
    <div class="mt-6 flex items-center justify-between">
        <a href="{{ route('stocks.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                  hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>
        @if(Auth::user()->isVendeur() && $stock->vendeur_id === Auth::id())
            <a href="{{ route('stocks.edit', $stock) }}"
               class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition
                      hover:opacity-90 active:scale-95 shadow-lg"
               style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </a>
        @endif
    </div>

</div>
@endsection