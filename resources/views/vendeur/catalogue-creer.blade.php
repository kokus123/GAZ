@extends('layouts.sidebar')

@section('title', 'Ajouter un produit')
@section('page-title', 'Ajouter un produit')
@section('page-subtitle', 'Ajoutez une bouteille de gaz à votre catalogue avec photo')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nouveau produit</h2>
            <p class="text-sm text-gray-500 mt-0.5">Les clients verront ce produit dans votre catalogue</p>
        </div>
    </div>

    <form action="{{ route('vendeur.catalogue.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Photo --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Photo du produit</h3>
            </div>
            <div class="p-6">
                <div id="preview-zone" class="aspect-square max-w-xs mx-auto rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden mb-4 cursor-pointer"
                     onclick="document.getElementById('photo-input').click()">
                    <img id="preview-img" class="hidden w-full h-full object-cover">
                    <div id="preview-placeholder" class="text-center px-4">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.034 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.034l-.822 1.316Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/>
                        </svg>
                        <p class="text-xs text-gray-400">Cliquez pour ajouter une photo</p>
                    </div>
                </div>
                <input type="file" id="photo-input" name="photo" accept="image/png,image/jpeg,image/webp" class="hidden" onchange="previewPhoto(event)">
                <p class="text-xs text-gray-400 text-center">JPG, PNG ou WEBP — 4 Mo maximum</p>
                @error('photo')<p class="text-xs text-red-500 mt-1 text-center">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Informations produit --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Détails du produit</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Format de bouteille <span class="text-red-500">*</span></label>
                    <select name="type_gaz" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all bg-white"
                            onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="">Choisir un format</option>
                        <option value="Bouteille de 6 kg" {{ old('type_gaz') == 'Bouteille de 6 kg' ? 'selected' : '' }}>Bouteille de 6 kg</option>
                        <option value="Bouteille de 12,5 kg" {{ old('type_gaz') == 'Bouteille de 12,5 kg' ? 'selected' : '' }}>Bouteille de 12,5 kg</option>
                        <option value="Bouteille de 35 kg" {{ old('type_gaz') == 'Bouteille de 35 kg' ? 'selected' : '' }}>Bouteille de 35 kg</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Ce format doit correspondre à celui choisi par les clients dans leur commande.</p>
                    @error('type_gaz')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nombre de bouteilles en stock <span class="text-red-500">*</span></label>
                    <input type="number" name="quantite_disponible" required min="0" value="{{ old('quantite_disponible') }}"
                           placeholder="Ex: 20"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <p class="text-xs text-gray-400 mt-1">Nombre de bouteilles physiques disponibles, pas le poids total.</p>
                </div>
                <input type="hidden" name="unite" value="bouteille">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prix par bouteille (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="prix_unitaire" required min="0" value="{{ old('prix_unitaire') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Seuil d'alerte stock</label>
                    <input type="number" name="quantite_minimum" min="0" value="{{ old('quantite_minimum', 10) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-gray-400 font-normal">(optionnel)</span></label>
                    <textarea name="description" rows="3" placeholder="Détails utiles pour le client…"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('vendeur.catalogue.index') }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-7 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105 active:scale-95"
                    style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
                Ajouter au catalogue
            </button>
        </div>
    </form>
</div>

<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-img').classList.remove('hidden');
        document.getElementById('preview-placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
