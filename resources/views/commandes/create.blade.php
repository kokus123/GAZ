@extends('layouts.sidebar')

@section('title', 'Nouvelle Commande')
@section('page-title', 'Nouvelle commande')
@section('page-subtitle', 'Remplissez les informations pour commander votre gaz')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header de page --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nouvelle commande de gaz</h2>
            <p class="text-sm text-gray-500 mt-0.5">Les champs marqués <span class="text-red-500">*</span> sont obligatoires</p>
        </div>
    </div>

    {{-- Barre de progression --}}
    <div class="bg-white rounded-2xl shadow-sm border border-green-50 p-5 mb-6">
        <div class="flex justify-between text-xs font-semibold text-gray-400 mb-3 uppercase tracking-wider">
            <span>Client</span>
            <span>Gaz</span>
            <span>Livraison</span>
            <span>Finalisation</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2.5">
            <div id="progress-bar"
                 class="h-2.5 rounded-full transition-all duration-500"
                 style="width:0%; background:linear-gradient(90deg,#16A34A,#22C55E);"></div>
        </div>
        <p id="progress-text" class="text-sm font-medium mt-2" style="color:#16A34A;">0% complété</p>
    </div>

    {{-- Formulaire --}}
    <form action="{{ route('commandes.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Section Client --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Informations client</h3>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="nom_client" required oninput="updateProgress()"
                           value="{{ old('nom_client') }}"
                           placeholder="Ex: Jean-Paul Mbarga"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                           style="focus:ring-color:#16A34A;"
                           onfocus="this.style.ringColor='#16A34A'; this.style.borderColor='#16A34A';"
                           onblur="this.style.borderColor='#e5e7eb';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone <span class="text-red-500">*</span></label>
                    <input type="tel" name="telephone" required oninput="updateProgress()"
                           value="{{ old('telephone') }}"
                           placeholder="Ex: 699 00 00 00"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" oninput="updateProgress()"
                           value="{{ old('email') }}"
                           placeholder="exemple@email.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
            </div>
        </div>

        {{-- Section Gaz --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 26C6 24 4 18 5.5 13.5"/>
                    </svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Commande de gaz</h3>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Type de gaz <span class="text-red-500">*</span></label>
                    <select name="type_gaz" required onchange="updateProgress()"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all bg-white"
                            onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="">Choisir</option>
                        <option value="propane" {{ old('type_gaz') == 'propane' ? 'selected' : '' }}>Bouteille de 6 kg</option>
                        <option value="butane" {{ old('type_gaz') == 'butane' ? 'selected' : '' }}>Bouteille de 12,5 kg</option>
                        <option value="butane" {{ old('type_gaz') == 'butane' ? 'selected' : '' }}>Bouteille de 35 kg</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Quantité <span class="text-red-500">*</span></label>
                    <input type="number" name="quantite" min="1" required oninput="updateProgress(); calculateTotal();"
                           value="{{ old('quantite') }}"
                           placeholder="Nb. bouteilles"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prix unitaire (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="prix_unitaire" required oninput="updateProgress(); calculateTotal();"
                           value="{{ old('prix_unitaire', 15000) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                {{-- Total dynamique --}}
                <div class="md:col-span-3" id="total-display" style="display:none;">
                    <div class="flex items-center justify-between px-5 py-3.5 rounded-xl"
                         style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1.5px solid #bbf7d0;">
                        <span class="text-sm font-semibold text-green-800">💰 Total estimé</span>
                        <span id="total-amount" class="text-xl font-bold" style="color:#15803D;">— FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Livraison --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                    </svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Livraison</h3>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse de livraison <span class="text-red-500">*</span></label>
                    <textarea name="adresse_livraison" required oninput="updateProgress()" rows="3"
                              placeholder="Quartier, rue, numéro — soyez précis pour une livraison rapide"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('adresse_livraison') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Latitude <span class="text-gray-400 font-normal">(optionnel)</span></label>
                        <input type="text" name="latitude" oninput="updateProgress()"
                               value="{{ old('latitude') }}" placeholder="Ex: 4.0511"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Longitude <span class="text-gray-400 font-normal">(optionnel)</span></label>
                        <input type="text" name="longitude" oninput="updateProgress()"
                               value="{{ old('longitude') }}" placeholder="Ex: 9.7679"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes <span class="text-gray-400 font-normal">(optionnel)</span></label>
                    <textarea name="notes" oninput="updateProgress()" rows="2"
                              placeholder="Instructions spéciales, horaires de disponibilité…"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('commandes.index') }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Retour
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-7 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105 active:scale-95"
                    style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Valider la commande
            </button>
        </div>
    </form>
</div>

<script>
function updateProgress() {
    const fields = document.querySelectorAll('input:not([type=submit]), select, textarea');
    let filled = 0, total = 0;
    fields.forEach(f => { total++; if (f.value.trim() !== '') filled++; });
    const pct = Math.round((filled / total) * 100);
    document.getElementById('progress-bar').style.width = pct + '%';
    document.getElementById('progress-text').textContent = pct + '% complété';
}

function calculateTotal() {
    const qty = parseFloat(document.querySelector('[name=quantite]')?.value) || 0;
    const prix = parseFloat(document.querySelector('[name=prix_unitaire]')?.value) || 0;
    const totalEl = document.getElementById('total-display');
    const amountEl = document.getElementById('total-amount');
    if (qty > 0 && prix > 0) {
        amountEl.textContent = (qty * prix).toLocaleString('fr-FR') + ' FCFA';
        totalEl.style.display = 'block';
    } else {
        totalEl.style.display = 'none';
    }
}
</script>
@endsection