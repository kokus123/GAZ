@extends('layouts.sidebar')

@section('title', 'Paiements')
@section('page-title', 'Paiements')
@section('page-subtitle', 'Gestion de vos transactions')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Paiements</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $paiements->total() ?? $paiements->count() }} transaction(s)</p>
        </div>
        <a href="{{ route('paiements.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105"
           style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 14px rgba(22,163,74,.3);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            Nouveau paiement
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Commande</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Montant</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Méthode</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-green-800">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($paiements as $paiement)
                        <tr class="hover:bg-green-50/40 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-xs font-mono font-bold text-gray-400">#{{ $paiement->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-800">{{ $paiement->commande->numero_commande ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-900">{{ number_format($paiement->montant, 0, ',', ' ') }}</span>
                                <span class="text-xs text-gray-400"> FCFA</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $methodIcons = ['mobile_money'=>'📱','carte_bancaire'=>'💳','especes'=>'💵'];
                                    $icon = $methodIcons[$paiement->methode_paiement] ?? '💳';
                                @endphp
                                <span class="text-sm text-gray-600">{{ $icon }} {{ ucfirst(str_replace('_', ' ', $paiement->methode_paiement)) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $sb = [
                                        'en_attente'=>'background:#FEF9C3; color:#854D0E;',
                                        'payé'=>'background:#DCFCE7; color:#166534;',
                                        'échoué'=>'background:#FEE2E2; color:#991B1B;',
                                        'annulé'=>'background:#F3F4F6; color:#374151;',
                                    ];
                                    $ss = $sb[$paiement->statut] ?? 'background:#F3F4F6; color:#374151;';
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold" style="{{ $ss }}">
                                    {{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $paiement->created_at->format('d/m/Y') }}</span>
                                <span class="block text-xs text-gray-400">{{ $paiement->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('paiements.show', $paiement) }}"
                                       class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white"
                                       style="background:linear-gradient(135deg,#16A34A,#15803D);">
                                        Voir
                                    </a>
                                    @if($paiement->statut === 'en_attente')
                                        <a href="{{ route('paiements.verifier', $paiement) }}"
                                           class="px-3 py-1.5 rounded-lg text-xs font-semibold"
                                           style="background:#FEF9C3; color:#854D0E;">
                                            Vérifier
                                        </a>
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-500">Aucun paiement enregistré</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($paiements->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">{{ $paiements->links() }}</div>
        @endif
    </div>
</div>
@endsection