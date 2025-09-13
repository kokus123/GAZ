@extends('layouts.app')

@section('title', 'Modifier la Livraison')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier la Livraison #{{ $livraison->id }}</h1>
            <a href="{{ route('livraisons.show', $livraison) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('livraisons.update', $livraison) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="en_cours" {{ old('statut', $livraison->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="livrée" {{ old('statut', $livraison->statut) == 'livrée' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulée" {{ old('statut', $livraison->statut) == 'annulée' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>

                <div>
                    <label for="date_livraison_prevue" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de livraison prévue
                    </label>
                    <input type="datetime-local" name="date_livraison_prevue" id="date_livraison_prevue" 
                           value="{{ old('date_livraison_prevue', $livraison->date_livraison_prevue ? $livraison->date_livraison_prevue->format('Y-m-d\TH:i') : '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes
                </label>
                <textarea name="notes" id="notes" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Notes sur la livraison...">{{ old('notes', $livraison->notes) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('livraisons.show', $livraison) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
