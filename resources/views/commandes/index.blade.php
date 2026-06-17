@extends('layouts.sidebar')

@section('title', 'Mes Commandes')
@section('page-title', 'Mes commandes')
@section('page-subtitle', 'Historique et suivi de vos commandes de gaz')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- En-tête + action --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Commandes</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $commandes->total() ?? $commandes->count() }} commande(s) au total</p>
        </div>
        <a href="{{ route('commandes.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105"
           style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 14px rgba(22,163,74,.3);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            Nouvelle commande
        </a>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Commande</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Quantité</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Montant</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($commandes as $commande)
                        <tr class="hover:bg-green-50/40 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-900">{{ $commande->numero_commande }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                         style="background:linear-gradient(135deg,#16A34A,#15803D);">
                                        {{ strtoupper(substr($commande->nom_client, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $commande->nom_client }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700">{{ $commande->quantite }} btl.</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-900">{{ number_format($commande->prix_total, 0, ',', ' ') }} <span class="font-normal text-gray-500">FCFA</span></span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badges = [
                                        'en_attente'  => ['bg:#FEF9C3; color:#854D0E; border:1px solid #FEF08A;', '⏳'],
                                        'confirmée'   => ['bg:#DBEAFE; color:#1E40AF; border:1px solid #BFDBFE;', '✅'],
                                        'en_livraison'=> ['bg:#EDE9FE; color:#6B21A8; border:1px solid #DDD6FE;', '🚚'],
                                        'livrée'      => ['bg:#DCFCE7; color:#166534; border:1px solid #BBF7D0;', '📦'],
                                        'annulée'     => ['bg:#FEE2E2; color:#991B1B; border:1px solid #FECACA;', '❌'],
                                        'payée'       => ['bg:#DCFCE7; color:#166534; border:1px solid #BBF7D0;', '💰'],
                                    ];
                                    $b = $badges[$commande->statut] ?? ['bg:#F3F4F6; color:#374151; border:1px solid #E5E7EB;', '•'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold" style="{{ $b[0] }}">
                                    {{ $b[1] }} {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $commande->created_at->format('d/m/Y') }}</span>
                                <span class="block text-xs text-gray-400">{{ $commande->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('commandes.show', $commande) }}"
                                       class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition-all hover:scale-105"
                                       style="background:linear-gradient(135deg,#16A34A,#15803D);">
                                        Voir
                                    </a>
                                    @if($commande->statut === 'en_attente' && Auth::user()->isClient())
                                        <form action="{{ route('commandes.annuler', $commande) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Annuler cette commande ?')"
                                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-600 bg-red-50 border border-red-100 hover:bg-red-100 transition-colors">
                                                Annuler
                                            </button>
                                        </form>
                                    @endif
                                    @if($commande->statut === 'en_attente' && Auth::user()->isVendeur())
                                        <form action="{{ route('commandes.confirmer', $commande) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition-all hover:scale-105"
                                                    style="background:#16A34A;">
                                                Confirmer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background:#f0fdf4;">
                                        <svg class="w-8 h-8 text-green-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-500">Aucune commande pour le moment</p>
                                    <a href="{{ route('commandes.create') }}" class="text-sm font-bold hover:underline" style="color:#16A34A;">Passer ma première commande →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($commandes->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $commandes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection