@extends('layouts.app')

@section('title', 'Commande ' . $commande->numero_commande)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- En-tête -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Commande {{ $commande->numero_commande }}</h1>
                    <p class="text-sm text-gray-600">Créée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        @if($commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                        @elseif($commande->statut === 'confirmee') bg-blue-100 text-blue-800
                        @elseif($commande->statut === 'en_cours') bg-purple-100 text-purple-800
                        @elseif($commande->statut === 'livree') bg-green-100 text-green-800
                        @elseif($commande->statut === 'annulee') bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Informations de la commande -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations Client</h2>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p><span class="font-medium">Nom:</span> {{ $commande->nom_client }}</p>
                            <p><span class="font-medium">Téléphone:</span> {{ $commande->telephone }}</p>
                            @if($commande->email)
                                <p><span class="font-medium">Email:</span> {{ $commande->email }}</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails de la Commande</h2>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p><span class="font-medium">Quantité:</span> {{ $commande->quantite }} kg</p>
                            <p><span class="font-medium">Prix unitaire:</span> {{ number_format($commande->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                            <p><span class="font-medium">Prix total:</span> <span class="text-lg font-bold text-primary">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</span></p>
                            @if($commande->notes)
                                <p><span class="font-medium">Notes:</span> {{ $commande->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Adresse de Livraison</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $commande->adresse_livraison }}</p>
                            @if($commande->latitude && $commande->longitude)
                                <p class="text-sm text-gray-500 mt-2">
                                    Coordonnées: {{ $commande->latitude }}, {{ $commande->longitude }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Vendeur et livraison -->
                <div class="space-y-6">
                    @if($commande->vendeur)
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Vendeur Assigné</h2>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <p><span class="font-medium">Nom:</span> {{ $commande->vendeur->name }}</p>
                                <p><span class="font-medium">Email:</span> {{ $commande->vendeur->email }}</p>
                            </div>
                        </div>
                    @endif

                    @if($commande->date_livraison_prevue)
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Livraison</h2>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <p><span class="font-medium">Date prévue:</span> {{ $commande->date_livraison_prevue->format('d/m/Y à H:i') }}</p>
                                @if($commande->date_livraison_effective)
                                    <p><span class="font-medium">Date effective:</span> {{ $commande->date_livraison_effective->format('d/m/Y à H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Paiements -->
                    @if($commande->paiements->count() > 0)
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Paiements</h2>
                            <div class="space-y-3">
                                @foreach($commande->paiements as $paiement)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium">{{ $paiement->numero_transaction }}</p>
                                                <p class="text-sm text-gray-600">{{ ucfirst($paiement->methode) }}</p>
                                                <p class="text-sm text-gray-600">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($paiement->statut === 'valide') bg-green-100 text-green-800
                                                @elseif($paiement->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                                @elseif($paiement->statut === 'echec') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($paiement->statut) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Reçus -->
                    @if($commande->reçus->count() > 0)
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Reçus</h2>
                            <div class="space-y-2">
                                @foreach($commande->reçus as $reçu)
                                    <a href="{{ route('reçus.telecharger', $reçu) }}" 
                                       class="block bg-primary text-white px-4 py-2 rounded-lg text-center hover:bg-secondary">
                                        Télécharger le reçu {{ $reçu->numero_reçu }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-4">
                        @if($commande->canBeCancelled())
                            <form method="POST" action="{{ route('commandes.annuler', $commande) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                    Annuler la Commande
                                </button>
                            </form>
                        @endif

                        @if(Auth::user()->isVendeur() && $commande->statut === 'en_attente')
                            <form method="POST" action="{{ route('commandes.confirmer', $commande) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                                    Confirmer la Commande
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="flex space-x-4">
                        <!-- Boutons de signalement -->
                        @if($commande->statut === 'livree' && !$commande->signalements()->where('type', 'non_livraison')->exists())
                            <form method="POST" action="{{ route('signalements.police') }}">
                                @csrf
                                <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                                <input type="hidden" name="type" value="non_livraison">
                                <input type="hidden" name="description" value="Non livraison après paiement">
                                <input type="hidden" name="adresse_incident" value="{{ $commande->adresse_livraison }}">
                                <button type="submit" 
                                        class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700">
                                    🚨 Signaler à la Police
                                </button>
                            </form>
                        @endif

                        <button type="button" 
                                class="bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-orange-700"
                                onclick="alert('Fonctionnalité de signalement aux pompiers en cours de développement')">
                            🚒 Contacter les Pompiers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
