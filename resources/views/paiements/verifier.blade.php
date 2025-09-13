@extends('layouts.app')

@section('title', 'Vérifier le Paiement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Vérifier le Paiement</h1>
            <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations du paiement</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Paiement :</span>
                            <span class="font-semibold">{{ $paiement->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Commande :</span>
                            <span class="font-semibold">{{ $paiement->commande->numero_commande ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant :</span>
                            <span class="font-bold text-green-600">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Méthode :</span>
                            <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $paiement->methode_paiement)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut actuel :</span>
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
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date de création :</span>
                            <span class="font-semibold">{{ $paiement->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Vérification du paiement</h3>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Instructions de vérification
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>1. Vérifiez le statut de votre paiement</p>
                                <p>2. Consultez votre relevé bancaire</p>
                                <p>3. Vérifiez les notifications de votre opérateur</p>
                                <p>4. Contactez le support si nécessaire</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('paiements.verifier', $paiement) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="reference_transaction" class="block text-sm font-medium text-gray-700 mb-2">
                            Référence de transaction
                        </label>
                        <input type="text" name="reference_transaction" id="reference_transaction" 
                               value="{{ old('reference_transaction', $paiement->reference_transaction) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Référence de la transaction">
                    </div>

                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                            Nouveau statut
                        </label>
                        <select name="statut" id="statut" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="en_attente" {{ old('statut', $paiement->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="payé" {{ old('statut', $paiement->statut) == 'payé' ? 'selected' : '' }}>Payé</option>
                            <option value="échoué" {{ old('statut', $paiement->statut) == 'échoué' ? 'selected' : '' }}>Échoué</option>
                            <option value="annulé" {{ old('statut', $paiement->statut) == 'annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes de vérification
                        </label>
                        <textarea name="notes" id="notes" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Notes sur la vérification...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Annuler
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ✅ Vérifier le Paiement
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($paiement->notes)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Notes existantes</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-900">{{ $paiement->notes }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
