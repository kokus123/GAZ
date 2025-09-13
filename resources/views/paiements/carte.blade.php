@extends('layouts.app')

@section('title', 'Paiement par Carte')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Paiement par Carte Bancaire</h1>
            <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de la commande</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Commande :</span>
                            <span class="font-semibold">{{ $commande->numero_commande ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Client :</span>
                            <span class="font-semibold">{{ $commande->nom_client ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Quantité :</span>
                            <span class="font-semibold">{{ $commande->quantite ?? 0 }} bouteilles</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span class="text-gray-600">Montant total :</span>
                            <span class="font-bold text-green-600">{{ number_format($commande->prix_total ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de la carte</h3>
                
                <form action="{{ route('paiements.carte') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="numero_carte" class="block text-sm font-medium text-gray-700 mb-2">
                            Numéro de carte *
                        </label>
                        <input type="text" name="numero_carte" id="numero_carte" required 
                               value="{{ old('numero_carte') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="date_expiration" class="block text-sm font-medium text-gray-700 mb-2">
                                Date d'expiration *
                            </label>
                            <input type="text" name="date_expiration" id="date_expiration" required 
                                   value="{{ old('date_expiration') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="MM/AA" maxlength="5">
                        </div>

                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">
                                CVV *
                            </label>
                            <input type="text" name="cvv" id="cvv" required 
                                   value="{{ old('cvv') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="123" maxlength="4">
                        </div>
                    </div>

                    <div>
                        <label for="nom_titulaire" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom du titulaire *
                        </label>
                        <input type="text" name="nom_titulaire" id="nom_titulaire" required 
                               value="{{ old('nom_titulaire') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Nom complet du titulaire">
                    </div>

                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">
                            Montant (FCFA) *
                        </label>
                        <input type="number" name="montant" id="montant" required 
                               value="{{ old('montant', $commande->prix_total ?? 0) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Montant en FCFA">
                    </div>

                    <div>
                        <label for="reference_transaction" class="block text-sm font-medium text-gray-700 mb-2">
                            Référence de transaction
                        </label>
                        <input type="text" name="reference_transaction" id="reference_transaction" 
                               value="{{ old('reference_transaction') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Référence de la transaction">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Notes sur le paiement...">{{ old('notes') }}</textarea>
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
                                    Sécurité des paiements
                                </h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>• Vos informations de carte sont sécurisées</p>
                                    <p>• Paiement crypté SSL</p>
                                    <p>• Aucune donnée bancaire n'est stockée</p>
                                    <p>• Transaction protégée par 3D Secure</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('paiements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Annuler
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            💳 Payer avec ma Carte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Formatage automatique du numéro de carte
document.getElementById('numero_carte').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formattedValue;
});

// Formatage automatique de la date d'expiration
document.getElementById('date_expiration').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

// Formatage automatique du CVV
document.getElementById('cvv').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
});
</script>
@endsection