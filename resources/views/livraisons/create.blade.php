@extends('layouts.app')

@section('title', 'Nouvelle Livraison')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Nouvelle Livraison</h1>
            <a href="{{ route('livraisons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('livraisons.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="commande_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Commande *
                    </label>
                    <select name="commande_id" id="commande_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner une commande</option>
                        @foreach($commandes as $commande)
                            <option value="{{ $commande->id }}" {{ old('commande_id') == $commande->id ? 'selected' : '' }}>
                                {{ $commande->numero_commande }} - {{ $commande->nom_client }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="en_cours" {{ old('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="livrée" {{ old('statut') == 'livrée' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulée" {{ old('statut') == 'annulée' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="date_livraison_prevue" class="block text-sm font-medium text-gray-700 mb-2">
                    Date de livraison prévue
                </label>
                <input type="datetime-local" name="date_livraison_prevue" id="date_livraison_prevue" 
                       value="{{ old('date_livraison_prevue') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes
                </label>
                <textarea name="notes" id="notes" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Notes sur la livraison...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('livraisons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Créer la Livraison
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
