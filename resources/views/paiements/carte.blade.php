@extends('layouts.sidebar')

@section('title', 'Paiement par Carte — GazApp')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
            <a href="{{ route('paiements.index') }}" class="hover:text-green-600 transition-colors">Paiements</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Carte Bancaire</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Paiement par Carte Bancaire</h1>
        <p class="text-sm text-gray-500 mt-1">Saisissez les informations de votre carte</p>
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

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- ── Résumé commande (colonne gauche) ── --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-5">Résumé de la commande</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Commande</span>
                    <span class="text-sm font-700 text-green-700">{{ $commande->numero_commande ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Client</span>
                    <span class="text-sm font-600 text-gray-700">{{ $commande->nom_client ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Quantité</span>
                    <span class="text-sm font-600 text-gray-700">{{ $commande->quantite ?? 0 }} bouteilles</span>
                </div>
            </div>
            <div class="mt-5 bg-green-50 rounded-xl p-4 border border-green-100">
                <p class="text-xs text-gray-500 mb-1">Montant total</p>
                <p class="text-2xl font-800 text-green-700">{{ number_format($commande->prix_total ?? 0, 0, ',', ' ') }} <span class="text-sm font-600">FCFA</span></p>
            </div>
        </div>

        {{-- Badge sécurité ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <p class="text-sm font-700 text-gray-700">Paiement sécurisé</p>
            </div>
            <ul class="space-y-2 text-xs text-gray-500">
                <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Informations de carte sécurisées</li>
                <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Paiement crypté SSL</li>
                <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Aucune donnée bancaire stockée</li>
                <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Protégé par 3D Secure</li>
            </ul>
        </div>
    </div>

    {{-- ── Formulaire carte ── --}}
    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-6 flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                Informations de la carte
            </h2>

            <form action="{{ route('paiements.carte') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Visuel carte ── --}}
                <div class="h-44 rounded-2xl bg-gradient-to-br from-green-600 via-green-500 to-emerald-400 p-6 text-white shadow-lg shadow-green-200/50 mb-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-white/10 -translate-y-12 translate-x-12"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full bg-white/10 translate-y-10 -translate-x-10"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <p class="text-xs font-600 text-white/70 uppercase tracking-wider">GazApp</p>
                            <div class="flex gap-1">
                                <div class="w-7 h-7 rounded-full bg-white/30"></div>
                                <div class="w-7 h-7 rounded-full bg-white/50 -ml-3"></div>
                            </div>
                        </div>
                        <div>
                            <p id="card-number-display" class="font-mono text-lg tracking-widest font-600 mb-3">•••• •••• •••• ••••</p>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-xs text-white/60 mb-0.5">Titulaire</p>
                                    <p id="card-name-display" class="text-sm font-600 uppercase">VOTRE NOM</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-white/60 mb-0.5">Expire</p>
                                    <p id="card-exp-display" class="text-sm font-600">MM/AA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="numero_carte" class="block text-sm font-600 text-gray-700 mb-2">Numéro de carte <span class="text-red-500">*</span></label>
                    <input type="text" name="numero_carte" id="numero_carte" required
                           value="{{ old('numero_carte') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition tracking-widest"
                           placeholder="1234 5678 9012 3456" maxlength="19">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="date_expiration" class="block text-sm font-600 text-gray-700 mb-2">Date d'expiration <span class="text-red-500">*</span></label>
                        <input type="text" name="date_expiration" id="date_expiration" required
                               value="{{ old('date_expiration') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition"
                               placeholder="MM/AA" maxlength="5">
                    </div>
                    <div>
                        <label for="cvv" class="block text-sm font-600 text-gray-700 mb-2">CVV <span class="text-red-500">*</span></label>
                        <input type="text" name="cvv" id="cvv" required
                               value="{{ old('cvv') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition"
                               placeholder="123" maxlength="4">
                    </div>
                </div>

                <div>
                    <label for="nom_titulaire" class="block text-sm font-600 text-gray-700 mb-2">Nom du titulaire <span class="text-red-500">*</span></label>
                    <input type="text" name="nom_titulaire" id="nom_titulaire" required
                           value="{{ old('nom_titulaire') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition uppercase"
                           placeholder="NOM COMPLET">
                </div>

                <div>
                    <label for="montant" class="block text-sm font-600 text-gray-700 mb-2">Montant (FCFA) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="montant" id="montant" required
                               value="{{ old('montant', $commande->prix_total ?? 0) }}"
                               class="w-full pl-4 pr-16 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-600 text-gray-400">FCFA</span>
                    </div>
                </div>

                <div>
                    <label for="reference_transaction" class="block text-sm font-600 text-gray-700 mb-2">Référence de transaction</label>
                    <input type="text" name="reference_transaction" id="reference_transaction"
                           value="{{ old('reference_transaction') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition"
                           placeholder="Ex: TXN-2024-001">
                </div>

                <div>
                    <label for="notes" class="block text-sm font-600 text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition resize-none"
                              placeholder="Notes sur le paiement...">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('paiements.index') }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gray-100 text-gray-600 text-sm font-600 hover:bg-gray-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-600 text-white text-sm font-700 hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Payer maintenant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Mise à jour visuel carte
document.getElementById('numero_carte').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    e.target.value = v.match(/.{1,4}/g)?.join(' ') || v;
    const disp = v.padEnd(16, '•');
    document.getElementById('card-number-display').textContent =
        disp.match(/.{1,4}/g)?.join(' ') || '•••• •••• •••• ••••';
});
document.getElementById('date_expiration').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2,4);
    e.target.value = v;
    document.getElementById('card-exp-display').textContent = v || 'MM/AA';
});
document.getElementById('nom_titulaire').addEventListener('input', function(e) {
    document.getElementById('card-name-display').textContent = e.target.value.toUpperCase() || 'VOTRE NOM';
});
document.getElementById('cvv').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
});
</script>
@endpush

@endsection