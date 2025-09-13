@extends('layouts.app')

@section('title', 'Paiement Mobile Money')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Paiement Mobile Money</h1>
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
                <h3 class="text-lg font-semibold text-gray-800">Informations de la commande</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Commande :</span>
                            <span class="font-semibold">{{ $commande->numero_commande ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Client :</span>
                            <span class="font-semibold">{{ $commande->nom_client ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Quantité :</span>
                            <span class="font-semibold">{{ $commande->quantite ?? 0 }} bouteilles</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span class="text-gray-600">Montant total :</span>
                            <span class="font-bold text-green-600">{{ number_format($commande->prix_total ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Paiement Mobile Money</h3>
                
                <form action="{{ route('paiements.mobile-money') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="numero_telephone" class="block text-sm font-medium text-gray-700 mb-2">
                            Numéro de téléphone *
                        </label>
                        <input type="tel" name="numero_telephone" id="numero_telephone" required 
                               value="{{ old('numero_telephone') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ex: 0123456789">
                    </div>

                    <div>
                        <label for="operateur" class="block text-sm font-medium text-gray-700 mb-2">
                            Opérateur *
                        </label>
                        <select name="operateur" id="operateur" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionner un opérateur</option>
                            <option value="orange" {{ old('operateur') == 'orange' ? 'selected' : '' }}>Orange Money</option>
                            <option value="mtn" {{ old('operateur') == 'mtn' ? 'selected' : '' }}>MTN Mobile Money</option>
                            <option value="moov" {{ old('operateur') == 'moov' ? 'selected' : '' }}>Moov Money</option>
                        </select>
                    </div>

                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">
                            Montant (FCFA) *
                        </label>
                        <input type="number" name="montant" id="montant" required 
                               value="{{ old('montant', $commande->prix_total ?? 0) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Montant en FCFA">
                    </div>

                    <div>
                        <label for="reference_transaction" class="block text-sm font-medium text-gray-700 mb-2">
                            Référence de transaction
                        </label>
                        <input type="text" name="reference_transaction" id="reference_transaction" 
                               value="{{ old('reference_transaction') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Référence de la transaction">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Notes sur le paiement...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">
                                    Instructions de paiement
                                </h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>1. Vérifiez que votre numéro de téléphone est correct</p>
                                    <p>2. Assurez-vous d'avoir suffisamment de crédit</p>
                                    <p>3. Confirmez le paiement sur votre téléphone</p>
                                    <p>4. Attendez la confirmation de la transaction</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Annuler
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            💳 Payer avec Mobile Money
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection