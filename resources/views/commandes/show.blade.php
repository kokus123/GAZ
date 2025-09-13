@extends('layouts.app')

@section('title', 'Détails de la Commande')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Commande #{{ $commande->numero_commande }}</h1>
            <a href="{{ route('commandes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de la commande</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numéro :</span>
                            <span class="font-semibold">{{ $commande->numero_commande }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Client :</span>
                            <span class="font-semibold">{{ $commande->nom_client }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Téléphone :</span>
                            <span class="font-semibold">{{ $commande->telephone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Quantité :</span>
                            <span class="font-semibold">{{ $commande->quantite }} bouteilles</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prix unitaire :</span>
                            <span class="font-semibold">{{ number_format($commande->prix_unitaire, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span class="text-gray-600">Prix total :</span>
                            <span class="font-bold text-green-600">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Statut et livraison</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut :</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                @elseif($commande->statut === 'confirmée') bg-blue-100 text-blue-800
                                @elseif($commande->statut === 'en_livraison') bg-purple-100 text-purple-800
                                @elseif($commande->statut === 'livrée') bg-green-100 text-green-800
                                @elseif($commande->statut === 'annulée') bg-red-100 text-red-800
                                @elseif($commande->statut === 'payée') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Vendeur :</span>
                            <span class="font-semibold">{{ $commande->vendeur->name ?? 'Non assigné' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date de création :</span>
                            <span class="font-semibold">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison prévue :</span>
                            <span class="font-semibold">
                                {{ $commande->date_livraison_prevue ? $commande->date_livraison_prevue->format('d/m/Y H:i') : 'Non définie' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison effective :</span>
                            <span class="font-semibold">
                                {{ $commande->date_livraison_effective ? $commande->date_livraison_effective->format('d/m/Y H:i') : 'Non livrée' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Adresse de livraison</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-900">{{ $commande->adresse_livraison }}</p>
                @if($commande->latitude && $commande->longitude)
                    <p class="text-sm text-gray-600 mt-2">
                        Coordonnées: {{ $commande->latitude }}, {{ $commande->longitude }}
                    </p>
                @endif
            </div>
        </div>

        @if($commande->notes)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Notes</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-900">{{ $commande->notes }}</p>
                </div>
            </div>
        @endif

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('commandes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            
            @if($commande->statut === 'en_attente' && Auth::user()->isClient())
                <form action="{{ route('commandes.annuler', $commande) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Annuler la Commande
                    </button>
                </form>
            @endif
            
            @if($commande->statut === 'en_attente' && Auth::user()->isVendeur())
                <form action="{{ route('commandes.confirmer', $commande) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Confirmer la Commande
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection