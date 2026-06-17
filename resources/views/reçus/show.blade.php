@extends('layouts.sidebar')

@section('title', 'Reçu #{{ $reçu->id }} — GazApp')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
            <a href="{{ route('reçus.index') }}" class="hover:text-green-600 transition-colors">Reçus</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Reçu #{{ $reçu->id }}</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Détails du Reçu</h1>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('reçus.telecharger', $reçu) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-600 text-white text-sm font-600 hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Télécharger PDF
        </a>
        <a href="{{ route('reçus.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-600 text-sm font-600 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour
        </a>
    </div>
</div>

{{-- ── Reçu imprimable ── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Header reçu ── --}}
    <div class="bg-gradient-to-r from-green-600 to-green-500 px-8 py-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-white/70 text-xs font-500 uppercase tracking-wider">GazApp</p>
                        <p class="text-white font-700 text-lg">REÇU DE PAIEMENT</p>
                    </div>
                </div>
                <p class="text-white/60 text-sm">Distribution de Gaz Domestique</p>
            </div>
            <div class="text-right">
                <p class="text-white/70 text-xs mb-1">Numéro de reçu</p>
                <p class="text-white font-800 text-2xl">#{{ $reçu->id }}</p>
                <p class="text-white/70 text-xs mt-1">{{ $reçu->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        {{-- Infos 2 colonnes ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

            {{-- Infos reçu ── --}}
            <div>
                <h3 class="text-xs font-700 text-gray-400 uppercase tracking-wider mb-4">Informations du Reçu</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Statut</span>
                        @if($reçu->statut === 'généré')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-600 bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Généré
                            </span>
                        @elseif($reçu->statut === 'téléchargé')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-600 bg-blue-100 text-blue-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Téléchargé
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-600 bg-gray-100 text-gray-600">{{ ucfirst($reçu->statut) }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Méthode de paiement</span>
                        <span class="text-sm font-600 text-gray-800">{{ ucfirst(str_replace('_', ' ', $reçu->methode_paiement)) }}</span>
                    </div>
                    @if($reçu->reference_transaction)
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Référence</span>
                        <span class="text-xs font-mono font-600 text-gray-700 bg-gray-50 px-2 py-1 rounded-lg">{{ $reçu->reference_transaction }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-500">Date d'émission</span>
                        <span class="text-sm font-600 text-gray-800">{{ $reçu->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Infos commande ── --}}
            <div>
                <h3 class="text-xs font-700 text-gray-400 uppercase tracking-wider mb-4">Informations de la Commande</h3>
                @if($reçu->commande)
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Commande</span>
                            <span class="text-sm font-700 text-green-700">{{ $reçu->commande->numero_commande }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Client</span>
                            <span class="text-sm font-600 text-gray-800">{{ $reçu->commande->nom_client }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Téléphone</span>
                            <span class="text-sm font-600 text-gray-800">{{ $reçu->commande->telephone }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-500">Quantité</span>
                            <span class="text-sm font-600 text-gray-800">{{ $reçu->commande->quantite }} bouteilles</span>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2 text-red-500 bg-red-50 px-4 py-3 rounded-xl text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        Commande non trouvée
                    </div>
                @endif
            </div>
        </div>

        {{-- Montant total ── --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Montant total payé</p>
                    <p class="text-3xl font-800 text-green-700">{{ number_format($reçu->montant, 0, ',', ' ') }} <span class="text-lg font-600 text-green-500">FCFA</span></p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-green-600 flex items-center justify-center shadow-lg shadow-green-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        {{-- Adresse livraison ── --}}
        @if($reçu->commande && $reçu->commande->adresse_livraison)
            <div class="mb-8">
                <h3 class="text-xs font-700 text-gray-400 uppercase tracking-wider mb-3">Adresse de Livraison</h3>
                <div class="flex items-start gap-3 bg-gray-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-sm text-gray-700">{{ $reçu->commande->adresse_livraison }}</p>
                </div>
            </div>
        @endif

        {{-- Pied de reçu ── --}}
        <div class="border-t border-dashed border-gray-200 pt-6 text-center">
            <p class="text-sm text-gray-500">Ce reçu confirme le paiement de votre commande de gaz domestique.</p>
            <p class="text-sm font-600 text-green-600 mt-1">Merci de votre confiance !</p>
            <p class="text-xs text-gray-400 mt-3">Reçu généré le {{ $reçu->created_at->format('d/m/Y à H:i') }} par GazApp</p>
        </div>
    </div>
</div>

@endsection