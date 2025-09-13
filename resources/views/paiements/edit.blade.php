@extends('layouts.app')

@section('title', 'Modifier le Paiement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier le Paiement #{{ $paiement->id }}</h1>
            <a href="{{ route('paiements.show', $paiement) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('paiements.update', $paiement) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="methode_paiement" class="block text-sm font-medium text-gray-700 mb-2">
                        Méthode de paiement *
                    </label>
                    <select name="methode_paiement" id="methode_paiement" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="mobile_money" {{ old('methode_paiement', $paiement->methode_paiement) == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                        <option value="carte_bancaire" {{ old('methode_paiement', $paiement->methode_paiement) == 'carte_bancaire' ? 'selected' : '' }}>Carte Bancaire</option>
                        <option value="especes" {{ old('methode_paiement', $paiement->methode_paiement) == 'especes' ? 'selected' : '' }}>Espèces</option>
                    </select>
                </div>

                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="en_attente" {{ old('statut', $paiement->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="payé" {{ old('statut', $paiement->statut) == 'payé' ? 'selected' : '' }}>Payé</option>
                        <option value="échoué" {{ old('statut', $paiement->statut) == 'échoué' ? 'selected' : '' }}>Échoué</option>
                        <option value="annulé" {{ old('statut', $paiement->statut) == 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant (FCFA) *
                    </label>
                    <input type="number" name="montant" id="montant" required 
                           value="{{ old('montant', $paiement->montant) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Montant en FCFA">
                </div>

                <div>
                    <label for="reference_transaction" class="block text-sm font-medium text-gray-700 mb-2">
                        Référence de transaction
                    </label>
                    <input type="text" name="reference_transaction" id="reference_transaction" 
                           value="{{ old('reference_transaction', $paiement->reference_transaction) }}" 
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
                          placeholder="Notes sur le paiement...">{{ old('notes', $paiement->notes) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('paiements.show', $paiement) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
