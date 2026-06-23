@extends('layouts.sidebar')

@section('title', 'Mon catalogue')
@section('page-title', 'Mon catalogue de produits')
@section('page-subtitle', 'Gérez vos bouteilles de gaz avec photos, prix et stock')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header de page --}}
    <div class="flex items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Mes produits</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $stocks->count() }} produit(s) dans votre catalogue</p>
            </div>
        </div>
        <a href="{{ route('vendeur.catalogue.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105 active:scale-95 flex-shrink-0"
           style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Ajouter un produit
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($stocks->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
            </svg>
            <p class="text-gray-500 text-sm">Votre catalogue est vide pour le moment.</p>
            <a href="{{ route('vendeur.catalogue.create') }}" class="text-sm font-semibold mt-2 inline-block" style="color:#16A34A;">
                Ajouter votre premier produit →
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($stocks as $stock)
                <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                    <div class="aspect-square bg-gray-50 flex items-center justify-center overflow-hidden">
                        <img src="{{ $stock->photo_url }}" alt="{{ $stock->type_gaz }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-1">
                            <p class="font-bold text-gray-900">{{ $stock->type_gaz }}</p>
                            @if($stock->disponible)
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-green-50 text-green-700">Actif</span>
                            @else
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">Inactif</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-3">{{ number_format($stock->prix_unitaire, 0, ',', ' ') }} FCFA / bouteille</p>

                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="text-gray-500">Bouteilles en stock</span>
                            <span class="font-semibold {{ $stock->isEnRupture() ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $stock->quantite_disponible }}
                                @if($stock->isEnRupture()) ⚠️ @endif
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('vendeur.catalogue.edit', $stock) }}"
                               class="flex-1 text-center text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">
                                Modifier
                            </a>
                            <form action="{{ route('vendeur.catalogue.destroy', $stock) }}" method="POST"
                                  onsubmit="return confirm('Supprimer ce produit du catalogue ?');" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full text-center text-xs font-semibold px-3 py-2 rounded-lg border border-red-100 text-red-500 hover:bg-red-50">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
