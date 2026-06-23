@extends('layouts.sidebar')

@section('title', 'Catalogue de ' . $vendeur->name)
@section('page-title', $vendeur->name)
@section('page-subtitle', $vendeur->quartier ?? 'Catalogue de produits')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header vendeur --}}
    <div class="bg-white rounded-2xl shadow-sm border border-green-50 p-5 mb-6 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <svg class="w-7 h-7" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-base">{{ $vendeur->name }}</p>
                <p class="text-sm text-gray-500">{{ $vendeur->quartier }} @if($vendeur->telephone) · {{ $vendeur->telephone }} @endif</p>
            </div>
        </div>
        <a href="{{ route('commandes.panier') }}" class="relative flex-shrink-0">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center border border-gray-200 hover:bg-gray-50">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.972-4.704 2.532-7.214.106-.473-.27-.928-.755-.928H5.106M7.5 14.25 5.106 5.272M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                </svg>
            </div>
            @if(count($panier) > 0)
                <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full text-white text-xs font-bold flex items-center justify-center"
                      style="background:#16A34A;">{{ count($panier) }}</span>
            @endif
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
    @endif

    {{-- Catalogue produits --}}
    @if($produits->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 p-12 text-center">
            <p class="text-gray-500 text-sm">Ce vendeur n'a pas encore de produits disponibles.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($produits as $produit)
                <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
                    <div class="aspect-square bg-gray-50 overflow-hidden">
                        <img src="{{ $produit->photo_url }}" alt="{{ $produit->type_gaz }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <p class="font-bold text-gray-900">{{ $produit->type_gaz }}</p>
                        @if($produit->description)
                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $produit->description }}</p>
                        @endif
                        <p class="text-lg font-bold mt-2" style="color:#16A34A;">
                            {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA
                            <span class="text-xs font-normal text-gray-400">/ bouteille</span>
                        </p>

                        <form action="{{ route('commandes.panier.ajouter') }}" method="POST" class="mt-3 flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $produit->id }}">
                            <input type="number" name="quantite" min="1" max="{{ $produit->quantite_disponible }}" value="1"
                                   class="w-16 px-2 py-2 rounded-lg border border-gray-200 text-sm text-center focus:outline-none"
                                   onfocus="this.style.borderColor='#16A34A';" onblur="this.style.borderColor='#e5e7eb';">
                            <button type="submit"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-bold text-white transition-all hover:scale-[1.02]"
                                    style="background:linear-gradient(135deg,#16A34A,#15803D);">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Ajouter
                            </button>
                        </form>
                        <p class="text-xs text-gray-400 mt-1.5">{{ $produit->quantite_disponible }} bouteille{{ $produit->quantite_disponible > 1 ? 's' : '' }} en stock</p>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($panier) > 0)
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-10">
                <a href="{{ route('commandes.panier') }}"
                   class="flex items-center gap-3 px-6 py-3.5 rounded-2xl text-sm font-bold text-white shadow-2xl transition-all hover:scale-105"
                   style="background:linear-gradient(135deg,#16A34A,#15803D);">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.972-4.704 2.532-7.214.106-.473-.27-.928-.755-.928H5.106M7.5 14.25 5.106 5.272"/>
                    </svg>
                    Voir mon panier ({{ count($panier) }})
                </a>
            </div>
        @endif
    @endif
</div>
@endsection
