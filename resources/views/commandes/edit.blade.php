@extends('layouts.sidebar')

@section('title', 'Modifier la Commande')
@section('page-title', 'Modifier la commande')
@section('page-subtitle', '#{{ $commande->numero_commande }}')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('commandes.show', $commande) }}"
           class="p-2 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-500 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Modifier la commande</h2>
            <p class="text-sm text-gray-500 mt-0.5">#{{ $commande->numero_commande }}</p>
        </div>
    </div>

    <form action="{{ route('commandes.update', $commande) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Section Client --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Informations client</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="nom_client" required
                           value="{{ old('nom_client', $commande->nom_client) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone <span class="text-red-500">*</span></label>
                    <input type="tel" name="telephone" required
                           value="{{ old('telephone', $commande->telephone) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Statut <span class="text-red-500">*</span></label>
                    <select name="statut" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all bg-white"
                            onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        @foreach(['en_attente'=>'En attente','confirmée'=>'Confirmée','en_livraison'=>'En livraison','livrée'=>'Livrée','annulée'=>'Annulée','payée'=>'Payée'] as $val => $label)
                            <option value="{{ $val }}" {{ old('statut', $commande->statut) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Section Gaz --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Commande de gaz</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Quantité (bouteilles) <span class="text-red-500">*</span></label>
                    <input type="number" name="quantite" min="1" required id="edit-quantite"
                           value="{{ old('quantite', $commande->quantite) }}"
                           oninput="editCalculateTotal()"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prix unitaire (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="prix_unitaire" min="0" step="0.01" required id="edit-prix"
                           value="{{ old('prix_unitaire', $commande->prix_unitaire) }}"
                           oninput="editCalculateTotal()"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div class="md:col-span-2" id="edit-total-display">
                    <div class="flex items-center justify-between px-5 py-3.5 rounded-xl"
                         style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1.5px solid #bbf7d0;">
                        <span class="text-sm font-semibold text-green-800">💰 Total</span>
                        <span id="edit-total-amount" class="text-xl font-bold" style="color:#15803D;">
                            {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Livraison --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Livraison</h3>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse de livraison <span class="text-red-500">*</span></label>
                    <textarea name="adresse_livraison" rows="3" required
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('adresse_livraison', $commande->adresse_livraison) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Latitude</label>
                        <input type="number" name="latitude" step="any"
                               value="{{ old('latitude', $commande->latitude) }}" placeholder="4.0511"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Longitude</label>
                        <input type="number" name="longitude" step="any"
                               value="{{ old('longitude', $commande->longitude) }}" placeholder="9.7679"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="3"
                              placeholder="Instructions spéciales…"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('notes', $commande->notes) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('commandes.show', $commande) }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-7 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105"
                    style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Mettre à jour
            </button>
        </div>
    </form>
</div>

<script>
function editCalculateTotal() {
    const qty = parseFloat(document.getElementById('edit-quantite').value) || 0;
    const prix = parseFloat(document.getElementById('edit-prix').value) || 0;
    if (qty > 0 && prix > 0) {
        document.getElementById('edit-total-amount').textContent = (qty * prix).toLocaleString('fr-FR') + ' FCFA';
    }
}
</script>
@endsection