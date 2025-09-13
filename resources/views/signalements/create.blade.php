@extends('layouts.app')

@section('title', 'Nouveau Signalement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Nouveau Signalement</h1>
            <a href="{{ route('signalements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('signalements.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de signalement *
                    </label>
                    <select name="type" id="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner un type</option>
                        <option value="police" {{ old('type') == 'police' ? 'selected' : '' }}>🚨 Police (Non-livraison, Vol, etc.)</option>
                        <option value="pompiers" {{ old('type') == 'pompiers' ? 'selected' : '' }}>🚒 Pompiers (Incendie, Accident, etc.)</option>
                        <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="traité" {{ old('statut') == 'traité' ? 'selected' : '' }}>Traité</option>
                        <option value="rejeté" {{ old('statut') == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre du signalement *
                </label>
                <input type="text" name="titre" id="titre" required 
                       value="{{ old('titre') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Titre du signalement">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description détaillée *
                </label>
                <textarea name="description" id="description" rows="6" required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Décrivez en détail le problème rencontré...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse de l'incident
                    </label>
                    <input type="text" name="adresse" id="adresse" 
                           value="{{ old('adresse') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Adresse où s'est produit l'incident">
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone de contact
                    </label>
                    <input type="tel" name="telephone" id="telephone" 
                           value="{{ old('telephone') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Votre numéro de téléphone">
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Important
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>En cas d'urgence, appelez directement les services d'urgence :</p>
                            <ul class="list-disc list-inside mt-1">
                                <li><strong>Police :</strong> 17</li>
                                <li><strong>Pompiers :</strong> 18</li>
                                <li><strong>Samu :</strong> 15</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('signalements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Envoyer le Signalement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
