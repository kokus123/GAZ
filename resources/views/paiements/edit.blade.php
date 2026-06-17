@extends('layouts.sidebar')

@section('title', 'Modifier le Paiement #{{ $paiement->id }} — GazApp')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
            <a href="{{ route('paiements.index') }}" class="hover:text-green-600 transition-colors">Paiements</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('paiements.show', $paiement) }}" class="hover:text-green-600 transition-colors">Paiement #{{ $paiement->id }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Modifier</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Modifier le Paiement <span class="text-green-600">#{{ $paiement->id }}</span></h1>
    </div>
    <a href="{{ route('paiements.show', $paiement) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-600 text-sm font-600 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Retour
    </a>
</div>

{{-- ── Erreurs ── --}}
@if($errors->any())
    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl mb-6">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <ul class="text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── Formulaire ── --}}
<form action="{{ route('paiements.update', $paiement) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Colonne principale ── --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    Détails du paiement
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="methode_paiement" class="block text-sm font-600 text-gray-700 mb-2">Méthode de paiement <span class="text-red-500">*</span></label>
                        <select name="methode_paiement" id="methode_paiement" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition">
                            <option value="mobile_money" {{ old('methode_paiement', $paiement->methode_paiement) == 'mobile_money' ? 'selected' : '' }}>📱 Mobile Money</option>
                            <option value="carte_bancaire" {{ old('methode_paiement', $paiement->methode_paiement) == 'carte_bancaire' ? 'selected' : '' }}>💳 Carte Bancaire</option>
                            <option value="especes" {{ old('methode_paiement', $paiement->methode_paiement) == 'especes' ? 'selected' : '' }}>💵 Espèces</option>
                        </select>
                    </div>

                    <div>
                        <label for="statut" class="block text-sm font-600 text-gray-700 mb-2">Statut <span class="text-red-500">*</span></label>
                        <select name="statut" id="statut" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition">
                            <option value="en_attente" {{ old('statut', $paiement->statut) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                            <option value="payé" {{ old('statut', $paiement->statut) == 'payé' ? 'selected' : '' }}>✅ Payé</option>
                            <option value="échoué" {{ old('statut', $paiement->statut) == 'échoué' ? 'selected' : '' }}>❌ Échoué</option>
                            <option value="annulé" {{ old('statut', $paiement->statut) == 'annulé' ? 'selected' : '' }}>🚫 Annulé</option>
                        </select>
                    </div>

                    <div>
                        <label for="montant" class="block text-sm font-600 text-gray-700 mb-2">Montant (FCFA) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="montant" id="montant" required
                                   value="{{ old('montant', $paiement->montant) }}"
                                   class="w-full pl-4 pr-16 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-600 text-gray-400">FCFA</span>
                        </div>
                    </div>

                    <div>
                        <label for="reference_transaction" class="block text-sm font-600 text-gray-700 mb-2">Référence de transaction</label>
                        <input type="text" name="reference_transaction" id="reference_transaction"
                               value="{{ old('reference_transaction', $paiement->reference_transaction) }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition"
                               placeholder="Ex: TXN-2024-001">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <label for="notes" class="block text-sm font-600 text-gray-700 mb-3">Notes</label>
                <textarea name="notes" id="notes" rows="4"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition resize-none"
                          placeholder="Notes sur le paiement...">{{ old('notes', $paiement->notes) }}</textarea>
            </div>
        </div>

        {{-- Colonne latérale ── --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5">Actions</h2>
                <div class="space-y-3">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-600 text-white text-sm font-700 hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Mettre à jour
                    </button>
                    <a href="{{ route('paiements.show', $paiement) }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gray-100 text-gray-600 text-sm font-600 hover:bg-gray-200 transition-colors">
                        Annuler
                    </a>
                </div>
            </div>

            {{-- Résumé paiement actuel ── --}}
            <div class="bg-green-50 rounded-2xl border border-green-100 p-5">
                <p class="text-xs font-700 text-green-700 uppercase tracking-wider mb-3">Paiement actuel</p>
                <p class="text-2xl font-800 text-green-700">{{ number_format($paiement->montant, 0, ',', ' ') }} <span class="text-sm font-600">FCFA</span></p>
                <p class="text-xs text-green-600 mt-1">Créé le {{ $paiement->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</form>

@endsection