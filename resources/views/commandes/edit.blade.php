@extends('layouts.app')

@section('title', 'Modifier la Commande')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier la Commande #{{ $commande->numero_commande }}</h1>
            <a href="{{ route('commandes.show', $commande) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <form action="{{ route('commandes.update', $commande) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nom_client" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet *
                    </label>
                    <input type="text" name="nom_client" id="nom_client" required 
                           value="{{ old('nom_client', $commande->nom_client) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nom complet du client">
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone *
                    </label>
                    <input type="tel" name="telephone" id="telephone" required 
                           value="{{ old('telephone', $commande->telephone) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: 0123456789">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="quantite" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantité (bouteilles) *
                    </label>
                    <input type="number" name="quantite" id="quantite" required min="1" 
                           value="{{ old('quantite', $commande->quantite) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nombre de bouteilles">
                </div>

                <div>
                    <label for="prix_unitaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix unitaire (FCFA) *
                    </label>
                    <input type="number" name="prix_unitaire" id="prix_unitaire" required min="0" step="0.01" 
                           value="{{ old('prix_unitaire', $commande->prix_unitaire) }}" 
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
                          placeholder="Adresse complète de livraison...">{{ old('adresse_livraison', $commande->adresse_livraison) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Latitude (optionnel)
                    </label>
                    <input type="number" name="latitude" id="latitude" step="any" 
                           value="{{ old('latitude', $commande->latitude) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: 4.123456">
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Longitude (optionnel)
                    </label>
                    <input type="number" name="longitude" id="longitude" step="any" 
                           value="{{ old('longitude', $commande->longitude) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: 9.123456">
                </div>
            </div>

            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                    Statut *
                    </label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="en_attente" {{ old('statut', $commande->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmée" {{ old('statut', $commande->statut) == 'confirmée' ? 'selected' : '' }}>Confirmée</option>
                        <option value="en_livraison" {{ old('statut', $commande->statut) == 'en_livraison' ? 'selected' : '' }}>En livraison</option>
                        <option value="livrée" {{ old('statut', $commande->statut) == 'livrée' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulée" {{ old('statut', $commande->statut) == 'annulée' ? 'selected' : '' }}>Annulée</option>
                        <option value="payée" {{ old('statut', $commande->statut) == 'payée' ? 'selected' : '' }}>Payée</option>
                    </select>
                </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes (optionnel)
                </label>
                <textarea name="notes" id="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Instructions spéciales, horaires de livraison, etc...">{{ old('notes', $commande->notes) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('commandes.show', $commande) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
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
