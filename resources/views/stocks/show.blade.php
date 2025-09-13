@extends('layouts.app')

@section('title', 'Détails du Stock')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Stock #{{ $stock->id }}</h1>
            <a href="{{ route('stocks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations du stock</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Stock :</span>
                            <span class="font-semibold">{{ $stock->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type de gaz :</span>
                            <span class="font-semibold">{{ $stock->type_gaz }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Quantité disponible :</span>
                            <span class="font-semibold">{{ $stock->quantite_disponible }} bouteilles</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prix unitaire :</span>
                            <span class="font-semibold">{{ number_format($stock->prix_unitaire, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Disponible :</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($stock->disponible) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $stock->disponible ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date de création :</span>
                            <span class="font-semibold">{{ $stock->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dernière mise à jour :</span>
                            <span class="font-semibold">{{ $stock->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations du vendeur</h3>
                
                @if($stock->vendeur)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nom :</span>
                                <span class="font-semibold">{{ $stock->vendeur->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email :</span>
                                <span class="font-semibold">{{ $stock->vendeur->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Statut :</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($stock->vendeur->is_online) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $stock->vendeur->is_online ? 'En ligne' : 'Hors ligne' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-red-600">Vendeur non trouvé</p>
                    </div>
                @endif
            </div>
        </div>

        @if($stock->description)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-900">{{ $stock->description }}</p>
                </div>
            </div>
        @endif

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('stocks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            @if(Auth::user()->isVendeur() && $stock->vendeur_id === Auth::id())
                <a href="{{ route('stocks.edit', $stock) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
