@extends('layouts.sidebar')

@section('title', 'Vérifier le Paiement — GazApp')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
            <a href="{{ route('paiements.index') }}" class="hover:text-green-600 transition-colors">Paiements</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Vérifier #{{ $paiement->id }}</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Vérifier le Paiement</h1>
        <p class="text-sm text-gray-500 mt-1">Confirmer ou rejeter ce paiement en attente</p>
    </div>
    <a href="{{ route('paiements.index') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-600 text-sm font-600 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Retour
    </a>
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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Résumé paiement ── --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5">Récapitulatif du paiement</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">ID Paiement</span>
                    <span class="text-xs font-mono font-700 text-gray-600 bg-gray-50 px-2 py-1 rounded-lg">#{{ $paiement->id }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Commande</span>
                    <span class="text-sm font-700 text-green-700">{{ $paiement->commande->numero_commande ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Montant</span>
                    <span class="text-lg font-800 text-green-700">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Méthode</span>
                    <span class="text-sm font-600 text-gray-700">{{ ucfirst(str_replace('_', ' ', $paiement->methode_paiement)) }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Statut actuel</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-700
                        @if($paiement->statut === 'en_attente') bg-yellow-100 text-yellow-700
                        @elseif($paiement->statut === 'payé') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700
                        @endif">
                        <span class="w-1.5 h-1.5 rounded-full
                            @if($paiement->statut === 'en_attente') bg-yellow-500
                            @elseif($paiement->statut === 'payé') bg-green-500
                            @else bg-red-500
                            @endif"></span>
                        {{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">Date de création</span>
                    <span class="text-sm font-600 text-gray-700">{{ $paiement->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Instructions ── --}}
        <div class="bg-blue-50 rounded-2xl border border-blue-100 p-5">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <p class="text-sm font-700 text-blue-800 mb-2">Instructions de vérification</p>
                    <ul class="text-xs text-blue-700 space-y-1.5">
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">1.</span> Vérifiez le statut de votre paiement</li>
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">2.</span> Consultez votre relevé bancaire</li>
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">3.</span> Vérifiez les notifications de votre opérateur</li>
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">4.</span> Contactez le support si nécessaire</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Notes existantes ── --}}
        @if($paiement->notes)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-3">Notes existantes</h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $paiement->notes }}</p>
            </div>
        @endif
    </div>

    {{-- Formulaire vérification ── --}}
    <div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                Mettre à jour le statut
            </h2>

            <form action="{{ route('paiements.verifier', $paiement) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="reference_transaction" class="block text-sm font-600 text-gray-700 mb-2">Référence de transaction</label>
                    <input type="text" name="reference_transaction" id="reference_transaction"
                           value="{{ old('reference_transaction', $paiement->reference_transaction) }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition"
                           placeholder="Ex: TXN-2024-001">
                </div>

                <div>
                    <label for="statut" class="block text-sm font-600 text-gray-700 mb-2">Nouveau statut</label>
                    <select name="statut" id="statut"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition">
                        <option value="en_attente" {{ old('statut', $paiement->statut) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="payé" {{ old('statut', $paiement->statut) == 'payé' ? 'selected' : '' }}>✅ Payé</option>
                        <option value="échoué" {{ old('statut', $paiement->statut) == 'échoué' ? 'selected' : '' }}>❌ Échoué</option>
                        <option value="annulé" {{ old('statut', $paiement->statut) == 'annulé' ? 'selected' : '' }}>🚫 Annulé</option>
                    </select>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-600 text-gray-700 mb-2">Notes de vérification</label>
                    <textarea name="notes" id="notes" rows="4"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition resize-none"
                              placeholder="Notes sur la vérification...">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('paiements.index') }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gray-100 text-gray-600 text-sm font-600 hover:bg-gray-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-600 text-white text-sm font-700 hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection