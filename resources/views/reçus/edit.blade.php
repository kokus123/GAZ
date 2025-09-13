@extends('layouts.app')

@section('title', 'Modifier le Reçu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier le Reçu #{{ $reçu->id }}</h1>
            <a href="{{ route('reçus.show', $reçu) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reçus.update', $reçu) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="généré" {{ old('statut', $reçu->statut) == 'généré' ? 'selected' : '' }}>Généré</option>
                        <option value="téléchargé" {{ old('statut', $reçu->statut) == 'téléchargé' ? 'selected' : '' }}>Téléchargé</option>
                    </select>
                </div>

                <div>
                    <label for="methode_paiement" class="block text-sm font-medium text-gray-700 mb-2">
                        Méthode de paiement *
                    </label>
                    <select name="methode_paiement" id="methode_paiement" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="mobile_money" {{ old('methode_paiement', $reçu->methode_paiement) == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                        <option value="carte_bancaire" {{ old('methode_paiement', $reçu->methode_paiement) == 'carte_bancaire' ? 'selected' : '' }}>Carte Bancaire</option>
                        <option value="especes" {{ old('methode_paiement', $reçu->methode_paiement) == 'especes' ? 'selected' : '' }}>Espèces</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant (FCFA) *
                    </label>
                    <input type="number" name="montant" id="montant" required 
                           value="{{ old('montant', $reçu->montant) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Montant en FCFA">
                </div>

                <div>
                    <label for="reference_transaction" class="block text-sm font-medium text-gray-700 mb-2">
                        Référence de transaction
                    </label>
                    <input type="text" name="reference_transaction" id="reference_transaction" 
                           value="{{ old('reference_transaction', $reçu->reference_transaction) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Référence de la transaction">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes
                </label>
                <textarea name="notes" id="notes" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Notes sur le reçu...">{{ old('notes', $reçu->notes) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('reçus.show', $reçu) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
