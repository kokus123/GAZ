@extends('layouts.sidebar')

@section('title', 'Mon panier')
@section('page-title', 'Mon panier')
@section('page-subtitle', 'Vérifiez votre commande avant de valider')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.972-4.704 2.532-7.214.106-.473-.27-.928-.755-.928H5.106M7.5 14.25 5.106 5.272M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Votre panier</h2>
            <p class="text-sm text-gray-500 mt-0.5">Vendeur : {{ $vendeur->name }} — {{ $vendeur->quartier }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden mb-6">
        @foreach($panier as $item)
            <div class="flex items-center gap-4 p-4 border-b border-gray-50 last:border-b-0">
                <div class="w-16 h-16 rounded-xl bg-gray-50 overflow-hidden flex-shrink-0">
                    <img src="{{ $item['photo'] ? asset('storage/'.$item['photo']) : asset('images/bouteille-gaz-defaut.png') }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm">{{ $item['type_gaz'] }}</p>
                    <p class="text-xs text-gray-500">{{ $item['quantite'] }} bouteille{{ $item['quantite'] > 1 ? 's' : '' }} × {{ number_format($item['prix_unitaire'], 0, ',', ' ') }} FCFA</p>
                </div>
                <p class="font-bold text-sm flex-shrink-0" style="color:#16A34A;">
                    {{ number_format($item['prix_unitaire'] * $item['quantite'], 0, ',', ' ') }} FCFA
                </p>
                <form action="{{ route('commandes.panier.retirer') }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <input type="hidden" name="stock_id" value="{{ $item['stock_id'] }}">
                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors" aria-label="Retirer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </form>
            </div>
        @endforeach

        <div class="p-4 flex items-center justify-between" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
            <span class="text-sm font-semibold text-green-800">Total</span>
            <span class="text-xl font-bold" style="color:#15803D;">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('commandes.catalogue-vendeur', $vendeur) }}"
           class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Continuer mes achats
        </a>
        <form action="{{ route('commandes.panier.valider') }}" method="POST">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 px-7 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105 active:scale-95"
                    style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
                Valider ma commande
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection
