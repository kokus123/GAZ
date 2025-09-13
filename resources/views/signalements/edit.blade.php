@extends('layouts.app')

@section('title', 'Modifier le Signalement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier le Signalement #{{ $signalement->id }}</h1>
            <a href="{{ route('signalements.show', $signalement) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('signalements.update', $signalement) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de signalement *
                    </label>
                    <select name="type" id="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="police" {{ old('type', $signalement->type) == 'police' ? 'selected' : '' }}>🚨 Police (Non-livraison, Vol, etc.)</option>
                        <option value="pompiers" {{ old('type', $signalement->type) == 'pompiers' ? 'selected' : '' }}>🚒 Pompiers (Incendie, Accident, etc.)</option>
                        <option value="autre" {{ old('type', $signalement->type) == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="en_attente" {{ old('statut', $signalement->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="traité" {{ old('statut', $signalement->statut) == 'traité' ? 'selected' : '' }}>Traité</option>
                        <option value="rejeté" {{ old('statut', $signalement->statut) == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre du signalement *
                </label>
                <input type="text" name="titre" id="titre" required 
                       value="{{ old('titre', $signalement->titre) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Titre du signalement">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description détaillée *
                </label>
                <textarea name="description" id="description" rows="6" required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Décrivez en détail le problème rencontré...">{{ old('description', $signalement->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse de l'incident
                    </label>
                    <input type="text" name="adresse" id="adresse" 
                           value="{{ old('adresse', $signalement->adresse) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Adresse où s'est produit l'incident">
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone de contact
                    </label>
                    <input type="tel" name="telephone" id="telephone" 
                           value="{{ old('telephone', $signalement->telephone) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Votre numéro de téléphone">
                </div>
            </div>

            <div>
                <label for="reponse" class="block text-sm font-medium text-gray-700 mb-2">
                    Réponse (optionnel)
                </label>
                <textarea name="reponse" id="reponse" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Réponse ou commentaire sur le signalement...">{{ old('reponse', $signalement->reponse) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('signalements.show', $signalement) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
