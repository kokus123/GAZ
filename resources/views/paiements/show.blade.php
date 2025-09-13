@extends('layouts.app')

@section('title', 'Détails du Paiement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Détails du Paiement #{{ $paiement->id }}</h1>
            <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations du Paiement</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">ID Paiement</label>
                            <p class="text-sm text-gray-900">{{ $paiement->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Statut</label>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($paiement->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                @elseif($paiement->statut === 'payé') bg-green-100 text-green-800
                                @elseif($paiement->statut === 'échoué') bg-red-100 text-red-800
                                @elseif($paiement->statut === 'annulé') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Montant</label>
                            <p class="text-sm text-gray-900 font-semibold">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Méthode</label>
                            <p class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $paiement->methode_paiement)) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date de création</label>
                            <p class="text-sm text-gray-900">{{ $paiement->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date de mise à jour</label>
                            <p class="text-sm text-gray-900">{{ $paiement->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de la Commande</h3>
                
                @if($paiement->commande)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Numéro de commande</label>
                                <p class="text-sm text-gray-900">{{ $paiement->commande->numero_commande }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Client</label>
                                <p class="text-sm text-gray-900">{{ $paiement->commande->nom_client }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Téléphone</label>
                                <p class="text-sm text-gray-900">{{ $paiement->commande->telephone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Quantité</label>
                                <p class="text-sm text-gray-900">{{ $paiement->commande->quantite }} bouteilles</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Prix total</label>
                                <p class="text-sm text-gray-900 font-semibold">{{ number_format($paiement->commande->prix_total, 0, ',', ' ') }} FCFA</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Statut commande</label>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($paiement->commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                    @elseif($paiement->commande->statut === 'confirmée') bg-blue-100 text-blue-800
                                    @elseif($paiement->commande->statut === 'livrée') bg-green-100 text-green-800
                                    @elseif($paiement->commande->statut === 'annulée') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $paiement->commande->statut)) }}
                                </span>
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

        @if($paiement->reference_transaction)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Référence de Transaction</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-900 font-mono">{{ $paiement->reference_transaction }}</p>
                </div>
            </div>
        @endif

        @if($paiement->notes)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Notes</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-900">{{ $paiement->notes }}</p>
                </div>
            </div>
        @endif

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            @if($paiement->statut === 'en_attente')
                <a href="{{ route('paiements.verifier', $paiement) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Vérifier le Paiement
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
