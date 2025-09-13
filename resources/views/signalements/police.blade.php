@extends('layouts.app')

@section('title', 'Signaler à la Police')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-red-800">🚨 Signaler à la Police</h1>
            <a href="{{ route('signalements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Urgence - Signalement Police
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p><strong>En cas d'urgence immédiate, appelez directement :</strong></p>
                        <p class="text-lg font-bold">🚨 17 (Police) ou 112 (Urgences)</p>
                        <p>Ce formulaire est pour les signalements non urgents ou complémentaires.</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('signalements.police') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre du signalement *
                    </label>
                    <input type="text" name="titre" id="titre" required 
                           value="{{ old('titre') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                           placeholder="Ex: Non-livraison après paiement">
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Votre téléphone *
                    </label>
                    <input type="tel" name="telephone" id="telephone" required 
                           value="{{ old('telephone') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                           placeholder="Ex: 0123456789">
                </div>
            </div>

            <div>
                <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                    Adresse de l'incident *
                </label>
                <input type="text" name="adresse" id="adresse" required 
                       value="{{ old('adresse') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="Adresse où s'est produit l'incident">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description détaillée *
                </label>
                <textarea name="description" id="description" rows="6" required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                          placeholder="Décrivez en détail l'incident, les personnes impliquées, l'heure, etc...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="type_incident" class="block text-sm font-medium text-gray-700 mb-2">
                        Type d'incident *
                    </label>
                    <select name="type_incident" id="type_incident" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">Sélectionner un type</option>
                        <option value="non_livraison" {{ old('type_incident') == 'non_livraison' ? 'selected' : '' }}>Non-livraison après paiement</option>
                        <option value="vol" {{ old('type_incident') == 'vol' ? 'selected' : '' }}>Vol de marchandises</option>
                        <option value="agression" {{ old('type_incident') == 'agression' ? 'selected' : '' }}>Agression</option>
                        <option value="fraude" {{ old('type_incident') == 'fraude' ? 'selected' : '' }}>Fraude</option>
                        <option value="autre" {{ old('type_incident') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label for="urgence" class="block text-sm font-medium text-gray-700 mb-2">
                        Niveau d'urgence *
                    </label>
                    <select name="urgence" id="urgence" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="faible" {{ old('urgence') == 'faible' ? 'selected' : '' }}>Faible</option>
                        <option value="moyenne" {{ old('urgence') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="élevée" {{ old('urgence') == 'élevée' ? 'selected' : '' }}>Élevée</option>
                        <option value="critique" {{ old('urgence') == 'critique' ? 'selected' : '' }}>Critique</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="témoins" class="block text-sm font-medium text-gray-700 mb-2">
                    Témoins (optionnel)
                </label>
                <textarea name="témoins" id="témoins" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                          placeholder="Nom et coordonnées des témoins éventuels...">{{ old('témoins') }}</textarea>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
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
                            <p>• Fournissez des informations précises et détaillées</p>
                            <p>• Gardez une copie de ce signalement</p>
                            <p>• Vous serez contacté par les autorités compétentes</p>
                            <p>• En cas d'urgence, appelez directement le 17</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('signalements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    🚨 Envoyer le Signalement Police
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
