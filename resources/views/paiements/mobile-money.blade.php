@extends('layouts.sidebar')

@section('title', 'Paiement Mobile Money — GazApp')

@section('content')

{{-- ── En-tête ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
            <a href="{{ route('paiements.index') }}" class="hover:text-green-600 transition-colors">Paiements</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Mobile Money</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Paiement Mobile Money</h1>
        <p class="text-sm text-gray-500 mt-1">Orange Money · MTN MoMo · Moov Money</p>
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

    {{-- ── Résumé commande ── --}}
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

        {{-- Opérateurs disponibles ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-4">Opérateurs acceptés</h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-orange-50 border border-orange-100">
                    <div class="w-9 h-9 rounded-lg bg-orange-500 flex items-center justify-center text-white text-xs font-800">OM</div>
                    <div>
                        <p class="text-sm font-700 text-gray-700">Orange Money</p>
                        <p class="text-xs text-gray-400">Cameroun</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-yellow-50 border border-yellow-100">
                    <div class="w-9 h-9 rounded-lg bg-yellow-500 flex items-center justify-center text-white text-xs font-800">MTN</div>
                    <div>
                        <p class="text-sm font-700 text-gray-700">MTN Mobile Money</p>
                        <p class="text-xs text-gray-400">Cameroun</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 border border-blue-100">
                    <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center text-white text-xs font-800">MV</div>
                    <div>
                        <p class="text-sm font-700 text-gray-700">Moov Money</p>
                        <p class="text-xs text-gray-400">Cameroun</p>
                    </div>
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
                    <p class="text-sm font-700 text-blue-800 mb-2">Instructions</p>
                    <ul class="text-xs text-blue-700 space-y-1.5">
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">1.</span> Vérifiez votre numéro de téléphone</li>
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">2.</span> Assurez-vous d'avoir suffisamment de crédit</li>
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">3.</span> Confirmez le paiement sur votre téléphone</li>
                        <li class="flex items-start gap-1.5"><span class="font-700 flex-shrink-0">4.</span> Attendez la confirmation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Formulaire ── --}}
    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-700 text-gray-700 uppercase tracking-wider mb-6 flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                Informations de paiement
            </h2>

            <form action="{{ route('paiements.mobile-money') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="operateur" class="block text-sm font-600 text-gray-700 mb-2">Opérateur <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-3" id="operateur-choice">
                        <label class="operateur-option cursor-pointer">
                            <input type="radio" name="operateur" value="orange" class="sr-only" {{ old('operateur') == 'orange' ? 'checked' : '' }}>
                            <div class="operateur-card flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-100 hover:border-orange-300 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-orange-500 flex items-center justify-center text-white text-xs font-800">OM</div>
                                <span class="text-xs font-600 text-gray-600">Orange</span>
                            </div>
                        </label>
                        <label class="operateur-option cursor-pointer">
                            <input type="radio" name="operateur" value="mtn" class="sr-only" {{ old('operateur') == 'mtn' ? 'checked' : '' }}>
                            <div class="operateur-card flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-100 hover:border-yellow-300 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-yellow-500 flex items-center justify-center text-white text-xs font-800">MTN</div>
                                <span class="text-xs font-600 text-gray-600">MTN</span>
                            </div>
                        </label>
                        <label class="operateur-option cursor-pointer">
                            <input type="radio" name="operateur" value="moov" class="sr-only" {{ old('operateur') == 'moov' ? 'checked' : '' }}>
                            <div class="operateur-card flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-100 hover:border-blue-300 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white text-xs font-800">MV</div>
                                <span class="text-xs font-600 text-gray-600">Moov</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="numero_telephone" class="block text-sm font-600 text-gray-700 mb-2">Numéro de téléphone <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-600">+237</span>
                        <input type="tel" name="numero_telephone" id="numero_telephone" required
                               value="{{ old('numero_telephone') }}"
                               class="w-full pl-16 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50 transition"
                               placeholder="6X XXX XXXX">
                    </div>
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
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Payer par Mobile Money
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sélection visuelle opérateur
document.querySelectorAll('.operateur-option input').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.operateur-card').forEach(c => {
            c.classList.remove('border-green-500', 'bg-green-50');
            c.classList.add('border-gray-100');
        });
        this.closest('.operateur-option').querySelector('.operateur-card').classList.add('border-green-500', 'bg-green-50');
        this.closest('.operateur-option').querySelector('.operateur-card').classList.remove('border-gray-100');
    });
    if (radio.checked) radio.dispatchEvent(new Event('change'));
});
</script>
@endpush

@endsection