@extends('layouts.app')

@section('title', 'Nouvelle Commande')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Nouvelle Commande de Gaz</h1>

        <form action="{{ route('commandes.store') }}" method="POST" id="commandeForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations client -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations Client</h2>
                    
                    <div>
                        <label for="nom_client" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                        <input type="text" name="nom_client" id="nom_client" 
                               value="{{ old('nom_client', Auth::user()->name ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                        <input type="tel" name="telephone" id="telephone" 
                               value="{{ old('telephone') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', Auth::user()->email ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                    </div>
                </div>

                <!-- Détails de la commande -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Détails de la Commande</h2>
                    
                    <div>
                        <label for="type_gaz" class="block text-sm font-medium text-gray-700">Type de gaz *</label>
                        <select name="type_gaz" id="type_gaz" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="propane" {{ old('type_gaz') == 'propane' ? 'selected' : '' }}>Propane</option>
                            <option value="butane" {{ old('type_gaz') == 'butane' ? 'selected' : '' }}>Butane</option>
                            <option value="gaz_naturel" {{ old('type_gaz') == 'gaz_naturel' ? 'selected' : '' }}>Gaz Naturel</option>
                        </select>
                    </div>

                    <div>
                        <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité (kg) *</label>
                        <input type="number" name="quantite" id="quantite" min="1" 
                               value="{{ old('quantite') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Adresse de livraison -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Adresse de Livraison</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="adresse_livraison" class="block text-sm font-medium text-gray-700">Adresse complète *</label>
                        <textarea name="adresse_livraison" id="adresse_livraison" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>{{ old('adresse_livraison') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude *</label>
                            <input type="number" name="latitude" id="latitude" step="any" 
                                   value="{{ old('latitude') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude *</label>
                            <input type="number" name="longitude" id="longitude" step="any" 
                                   value="{{ old('longitude') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Géolocalisation requise</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Veuillez activer la géolocalisation pour que nous puissions vous associer au vendeur le plus proche.</p>
                                    <button type="button" id="getLocation" class="mt-2 bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        Obtenir ma position
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('welcome') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md text-sm font-medium hover:bg-gray-400">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-primary text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-secondary">
                    Créer la Commande
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const getLocationBtn = document.getElementById('getLocation');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    getLocationBtn.addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    latitudeInput.value = position.coords.latitude;
                    longitudeInput.value = position.coords.longitude;
                    
                    // Afficher un message de succès
                    const successDiv = document.createElement('div');
                    successDiv.className = 'mt-2 text-sm text-green-600';
                    successDiv.textContent = 'Position obtenue avec succès !';
                    getLocationBtn.parentNode.appendChild(successDiv);
                    
                    // Masquer le bouton
                    getLocationBtn.style.display = 'none';
                },
                function(error) {
                    alert('Erreur lors de l\'obtention de la position: ' + error.message);
                }
            );
        } else {
            alert('La géolocalisation n\'est pas supportée par ce navigateur.');
        }
    });
});
</script>
@endpush
@endsection
