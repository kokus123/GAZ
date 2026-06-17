@extends('layouts.sidebar')

@section('title', 'Mes Reçus — GazApp')

@section('content')

{{-- ── En-tête page ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Mes Reçus</h1>
        <p class="text-sm text-gray-500 mt-1">Historique de tous vos reçus de paiement</p>
    </div>
</div>

{{-- ── Alertes ── --}}
@if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
@endif

{{-- ── Tableau ── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-700 text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-700 text-gray-500 uppercase tracking-wider">Commande</th>
                    <th class="px-6 py-4 text-left text-xs font-700 text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-4 text-left text-xs font-700 text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-700 text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-right text-xs font-700 text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reçus as $reçu)
                    <tr class="hover:bg-green-50/40 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono font-semibold text-gray-400">#{{ $reçu->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">{{ $reçu->commande->numero_commande ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-green-700">{{ number_format($reçu->montant, 0, ',', ' ') }} FCFA</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($reçu->statut === 'généré')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-600 bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Généré
                                </span>
                            @elseif($reçu->statut === 'téléchargé')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-600 bg-blue-100 text-blue-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Téléchargé
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-600 bg-gray-100 text-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>{{ ucfirst($reçu->statut) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $reçu->created_at->format('d/m/Y') }}</span>
                            <span class="text-xs text-gray-400 block">{{ $reçu->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('reçus.telecharger', $reçu) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-600 bg-green-600 text-white hover:bg-green-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    PDF
                                </a>
                                <a href="{{ route('reçus.show', $reçu) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-600 bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Voir
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-green-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Aucun reçu trouvé</p>
                                <p class="text-xs text-gray-400">Vos reçus apparaîtront ici après chaque paiement</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reçus->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reçus->links() }}
        </div>
    @endif
</div>

@endsection