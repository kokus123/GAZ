@extends('layouts.sidebar')

@section('title', 'Choisir votre vendeur')
@section('page-title', 'Choisissez votre vendeur')
@section('page-subtitle', 'Sélectionnez le vendeur pour voir son catalogue')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Vendeurs disponibles près de vous</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                @if($utiliseGps)
                    Tous les vendeurs inscrits, classés du plus proche au plus éloigné
                @else
                    Tous les vendeurs inscrits sur la plateforme
                @endif
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            @foreach($errors->all() as $error)
                <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="space-y-4">
        @foreach($vendeurs as $index => $item)
            @php
                $vendeur = $item['vendeur'];
                $distance = $item['distance'];
                $tempsEstime = $item['temps_estime'];
                $estRecommande = $index === 0 && $distance !== null;
                $nbProduits = $item['nb_produits'] ?? 0;
            @endphp

            <a href="{{ route('commandes.catalogue-vendeur', $vendeur) }}" class="block group {{ $nbProduits === 0 ? 'opacity-60' : '' }}">
                <div class="bg-white rounded-2xl shadow-sm border-2 border-green-50 overflow-hidden transition-all group-hover:shadow-md group-hover:border-green-200">

                    @if($estRecommande)
                        <div class="px-4 py-1.5 text-xs font-bold text-white flex items-center gap-1.5"
                             style="background:linear-gradient(135deg,#16A34A,#15803D);">
                            ⭐ Vendeur recommandé — le plus proche
                        </div>
                    @endif

                    <div class="p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                             style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                            <svg class="w-7 h-7" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/>
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 text-base truncate">{{ $vendeur->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $vendeur->quartier ?? 'Quartier non précisé' }}</p>
                            @if($vendeur->adresse_detaillee)
                                <p class="text-xs text-gray-400 truncate mt-0.5">{{ $vendeur->adresse_detaillee }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-2">
                                @if($vendeur->telephone)
                                <span class="text-xs font-medium text-gray-600">📞 {{ $vendeur->telephone }}</span>
                                @endif
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $nbProduits > 0 ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    @if($nbProduits > 0)
                                        🟢 {{ $nbProduits }} produit{{ $nbProduits > 1 ? 's' : '' }} dispo
                                    @else
                                        ⚪ Pas encore de produits
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="text-right flex-shrink-0">
                            @if($distance !== null)
                                <p class="text-lg font-bold" style="color:#16A34A;">{{ $distance }} km</p>
                                <p class="text-xs text-gray-400">~{{ $tempsEstime }} min</p>
                            @else
                                <p class="text-xs font-medium text-gray-400">Distance inconnue</p>
                            @endif
                        </div>

                        <svg class="w-5 h-5 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="pt-6">
        <a href="{{ route('commandes.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors w-fit">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Modifier ma commande
        </a>
    </div>
</div>
@endsection
