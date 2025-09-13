@extends('layouts.app')

@section('title', 'Détails de la Livraison')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Détails de la Livraison #{{ $livraison->id }}</h1>
            <a href="{{ route('livraisons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de la Livraison</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">ID Livraison</label>
                            <p class="text-sm text-gray-900">{{ $livraison->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Statut</label>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($livraison->statut === 'en_cours') bg-yellow-100 text-yellow-800
                                @elseif($livraison->statut === 'livrée') bg-green-100 text-green-800
                                @elseif($livraison->statut === 'annulée') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $livraison->statut)) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date de création</label>
                            <p class="text-sm text-gray-900">{{ $livraison->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date de livraison prévue</label>
                            <p class="text-sm text-gray-900">
                                {{ $livraison->date_livraison_prevue ? $livraison->date_livraison_prevue->format('d/m/Y H:i') : 'Non définie' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de la Commande</h3>
                
                @if($livraison->commande)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Numéro de commande</label>
                                <p class="text-sm text-gray-900">{{ $livraison->commande->numero_commande }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Client</label>
                                <p class="text-sm text-gray-900">{{ $livraison->commande->nom_client }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Téléphone</label>
                                <p class="text-sm text-gray-900">{{ $livraison->commande->telephone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Quantité</label>
                                <p class="text-sm text-gray-900">{{ $livraison->commande->quantite }} bouteilles</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Adresse de livraison</label>
                                <p class="text-sm text-gray-900">{{ $livraison->commande->adresse_livraison }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-red-600">Commande non trouvée</p>
                    </div>
                @endif
            </div>
        </div>

        @if($livraison->notes)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Notes</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-900">{{ $livraison->notes }}</p>
                </div>
            </div>
        @endif

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('livraisons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            @if($livraison->statut === 'en_cours')
                <form action="{{ route('livraisons.finaliser', $livraison) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Finaliser la Livraison
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
