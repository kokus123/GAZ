@extends('layouts.sidebar')

@section('title', 'Nouveau Paiement')
@section('page-title', 'Nouveau paiement')
@section('page-subtitle', 'Enregistrer une transaction')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('paiements.index') }}"
           class="p-2 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-500 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nouveau paiement</h2>
            <p class="text-sm text-gray-500 mt-0.5">Les champs <span class="text-red-500">*</span> sont obligatoires</p>
        </div>
    </div>

    <form action="{{ route('paiements.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Informations du paiement</h3>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Commande <span class="text-red-500">*</span></label>
                    <select name="commande_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all bg-white"
                            onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="">Sélectionner une commande</option>
                        @foreach($commandes as $commande)
                            <option value="{{ $commande->id }}" {{ old('commande_id') == $commande->id ? 'selected' : '' }}>
                                {{ $commande->numero_commande }} — {{ $commande->nom_client }} ({{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Méthode de paiement <span class="text-red-500">*</span></label>
                        <select name="methode_paiement" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all bg-white"
                                onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <option value="">Choisir</option>
                            <option value="mobile_money" {{ old('methode_paiement') == 'mobile_money' ? 'selected' : '' }}>📱 Mobile Money</option>
                            <option value="carte_bancaire" {{ old('methode_paiement') == 'carte_bancaire' ? 'selected' : '' }}>💳 Carte Bancaire</option>
                            <option value="especes" {{ old('methode_paiement') == 'especes' ? 'selected' : '' }}>💵 Espèces</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Statut <span class="text-red-500">*</span></label>
                        <select name="statut" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all bg-white"
                                onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                            <option value="payé" {{ old('statut') == 'payé' ? 'selected' : '' }}>✅ Payé</option>
                            <option value="échoué" {{ old('statut') == 'échoué' ? 'selected' : '' }}>❌ Échoué</option>
                            <option value="annulé" {{ old('statut') == 'annulé' ? 'selected' : '' }}>🚫 Annulé</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Montant (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="montant" required
                           value="{{ old('montant') }}" placeholder="Ex: 15000"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Référence de transaction</label>
                    <input type="text" name="reference_transaction"
                           value="{{ old('reference_transaction') }}" placeholder="REF-XXXXXXXXX"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all font-mono"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Informations complémentaires…"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('paiements.index') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-7 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105"
                    style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Enregistrer le paiement
            </button>
        </div>
    </form>
</div>
@endsection