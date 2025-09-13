@extends('layouts.app')

@section('title', 'Nouvelle Commande')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Nouvelle Commande de Gaz</h1>
            <a href="{{ route('commandes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('commandes.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="nom_client" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet *
                    </label>
                    <input type="text" name="nom_client" id="nom_client" required 
                           value="{{ old('nom_client', Auth::user()->name ?? '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Votre nom complet">
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone *
                    </label>
                    <input type="tel" name="telephone" id="telephone" required 
                           value="{{ old('telephone') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: 0123456789">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email (optionnel)
                    </label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', Auth::user()->email ?? '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="votre@email.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="type_gaz" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de gaz *
                    </label>
                    <select name="type_gaz" id="type_gaz" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner le type de gaz</option>
                        <option value="propane" {{ old('type_gaz') == 'propane' ? 'selected' : '' }}>Propane</option>
                        <option value="butane" {{ old('type_gaz') == 'butane' ? 'selected' : '' }}>Butane</option>
                        <option value="mixte" {{ old('type_gaz') == 'mixte' ? 'selected' : '' }}>Mixte</option>
                    </select>
                </div>

                <div>
                    <label for="quantite" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantité (bouteilles) *
                    </label>
                    <input type="number" name="quantite" id="quantite" required min="1" 
                           value="{{ old('quantite') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nombre de bouteilles">
                </div>

                <div>
                    <label for="prix_unitaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix unitaire (FCFA) *
                    </label>
                    <input type="number" name="prix_unitaire" id="prix_unitaire" required min="0" step="0.01" 
                           value="{{ old('prix_unitaire', 15000) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Prix par bouteille">
                </div>
            </div>

            <div>
                <label for="adresse_livraison" class="block text-sm font-medium text-gray-700 mb-2">
                    Adresse de livraison *
                </label>
                <textarea name="adresse_livraison" id="adresse_livraison" rows="3" required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Adresse complète de livraison...">{{ old('adresse_livraison') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Latitude (optionnel)
                    </label>
                    <input type="number" name="latitude" id="latitude" step="any" 
                           value="{{ old('latitude') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: 4.123456">
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Longitude (optionnel)
                    </label>
                    <input type="number" name="longitude" id="longitude" step="any" 
                           value="{{ old('longitude') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: 9.123456">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes (optionnel)
                </label>
                <textarea name="notes" id="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Instructions spéciales, horaires de livraison, etc...">{{ old('notes') }}</textarea>
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
                            Informations importantes
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>• La localisation est obligatoire pour toute commande</p>
                            <p>• Vous serez redirigé vers le vendeur le plus proche</p>
                            <p>• Le paiement se fera après confirmation de la commande</p>
                            <p>• Un reçu numérique sera généré après paiement</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('commandes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    📦 Passer la Commande
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Calcul automatique du prix total
document.getElementById('quantite').addEventListener('input', calculateTotal);
document.getElementById('prix_unitaire').addEventListener('input', calculateTotal);

function calculateTotal() {
    const quantite = parseFloat(document.getElementById('quantite').value) || 0;
    const prixUnitaire = parseFloat(document.getElementById('prix_unitaire').value) || 0;
    const prixTotal = quantite * prixUnitaire;
    
    // Afficher le prix total (optionnel)
    let totalDisplay = document.getElementById('total-display');
    if (!totalDisplay) {
        totalDisplay = document.createElement('div');
        totalDisplay.id = 'total-display';
        totalDisplay.className = 'mt-2 p-3 bg-green-50 border border-green-200 rounded-lg';
        document.getElementById('prix_unitaire').parentNode.appendChild(totalDisplay);
    }
    
    if (quantite > 0 && prixUnitaire > 0) {
        totalDisplay.innerHTML = `<strong>Prix total: ${prixTotal.toLocaleString()} FCFA</strong>`;
        totalDisplay.style.display = 'block';
    } else {
        totalDisplay.style.display = 'none';
    }
}
</script>
@endsection