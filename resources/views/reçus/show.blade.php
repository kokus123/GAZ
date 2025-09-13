@extends('layouts.app')

@section('title', 'Détails du Reçu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Reçu #{{ $reçu->id }}</h1>
            <div class="space-x-2">
                <a href="{{ route('reçus.telecharger', $reçu) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Télécharger PDF
                </a>
                <a href="{{ route('reçus.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour
                </a>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">REÇU DE PAIEMENT</h2>
                <p class="text-gray-600">GazApp - Distribution de Gaz Domestique</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Informations du Reçu</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numéro de reçu :</span>
                            <span class="font-semibold">#{{ $reçu->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date :</span>
                            <span class="font-semibold">{{ $reçu->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut :</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($reçu->statut === 'généré') bg-green-100 text-green-800
                                @elseif($reçu->statut === 'téléchargé') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($reçu->statut) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Informations de la Commande</h3>
                    @if($reçu->commande)
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Commande :</span>
                                <span class="font-semibold">{{ $reçu->commande->numero_commande }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Client :</span>
                                <span class="font-semibold">{{ $reçu->commande->nom_client }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Téléphone :</span>
                                <span class="font-semibold">{{ $reçu->commande->telephone }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantité :</span>
                                <span class="font-semibold">{{ $reçu->commande->quantite }} bouteilles</span>
                            </div>
                        </div>
                    @else
                        <p class="text-red-600">Commande non trouvée</p>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Détails du Paiement</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-lg">
                        <span class="text-gray-600">Montant total :</span>
                        <span class="font-bold text-xl text-green-600">{{ number_format($reçu->montant, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Méthode de paiement :</span>
                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $reçu->methode_paiement)) }}</span>
                    </div>
                    @if($reçu->reference_transaction)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Référence :</span>
                            <span class="font-mono text-sm">{{ $reçu->reference_transaction }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($reçu->commande && $reçu->commande->adresse_livraison)
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Adresse de Livraison</h3>
                    <p class="text-gray-700">{{ $reçu->commande->adresse_livraison }}</p>
                </div>
            @endif

            <div class="border-t border-gray-200 pt-4 mt-4 text-center">
                <p class="text-sm text-gray-500">
                    Ce reçu confirme le paiement de votre commande de gaz domestique.<br>
                    Merci de votre confiance !
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Reçu généré le {{ $reçu->created_at->format('d/m/Y à H:i') }} par GazApp
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('reçus.telecharger', $reçu) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Télécharger PDF
            </a>
            <a href="{{ route('reçus.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
