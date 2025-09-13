@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Mes Commandes</h1>
                <a href="{{ route('commandes.create') }}" 
                   class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-secondary">
                    Nouvelle Commande
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            N° Commande
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vendeur
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($commandes as $commande)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $commande->numero_commande }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $commande->nom_client }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $commande->vendeur->name ?? 'Non assigné' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $commande->quantite }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                    @elseif($commande->statut === 'confirmee') bg-blue-100 text-blue-800
                                    @elseif($commande->statut === 'en_cours') bg-purple-100 text-purple-800
                                    @elseif($commande->statut === 'livree') bg-green-100 text-green-800
                                    @elseif($commande->statut === 'annulee') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $commande->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('commandes.show', $commande) }}" 
                                   class="text-primary hover:text-secondary">
                                    Voir
                                </a>
                                
                                @if(Auth::user()->isVendeur() && $commande->statut === 'en_attente')
                                    <form method="POST" action="{{ route('commandes.confirmer', $commande) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Confirmer
                                        </button>
                                    </form>
                                @endif

                                @if($commande->canBeCancelled())
                                    <form method="POST" action="{{ route('commandes.annuler', $commande) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                Aucune commande trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($commandes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $commandes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
