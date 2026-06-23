@extends('layouts.sidebar')

@section('title', 'Modifier le produit')
@section('page-title', 'Modifier le produit')
@section('page-subtitle', 'Mettez à jour les informations de ce produit')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $stock->type_gaz }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">Modifiez les informations de ce produit</p>
        </div>
    </div>

    <form action="{{ route('vendeur.catalogue.update', $stock) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        {{-- Photo --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Photo du produit</h3>
            </div>
            <div class="p-6">
                <div id="preview-zone" class="aspect-square max-w-xs mx-auto rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden mb-4 cursor-pointer"
                     onclick="document.getElementById('photo-input').click()">
                    <img id="preview-img" src="{{ $stock->photo_url }}" class="w-full h-full object-cover">
                </div>
                <input type="file" id="photo-input" name="photo" accept="image/png,image/jpeg,image/webp" class="hidden" onchange="previewPhoto(event)">
                <p class="text-xs text-gray-400 text-center">Cliquez sur la photo pour la remplacer — JPG, PNG ou WEBP, 4 Mo max</p>
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
                        <option value="Bouteille de 6 kg" {{ old('type_gaz', $stock->type_gaz) == 'Bouteille de 6 kg' ? 'selected' : '' }}>Bouteille de 6 kg</option>
                        <option value="Bouteille de 12,5 kg" {{ old('type_gaz', $stock->type_gaz) == 'Bouteille de 12,5 kg' ? 'selected' : '' }}>Bouteille de 12,5 kg</option>
                        <option value="Bouteille de 35 kg" {{ old('type_gaz', $stock->type_gaz) == 'Bouteille de 35 kg' ? 'selected' : '' }}>Bouteille de 35 kg</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nombre de bouteilles en stock <span class="text-red-500">*</span></label>
                    <input type="number" name="quantite_disponible" required min="0" value="{{ old('quantite_disponible', $stock->quantite_disponible) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <input type="hidden" name="unite" value="bouteille">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prix par bouteille (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="prix_unitaire" required min="0" value="{{ old('prix_unitaire', $stock->prix_unitaire) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Seuil d'alerte stock</label>
                    <input type="number" name="quantite_minimum" min="0" value="{{ old('quantite_minimum', $stock->quantite_minimum) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('description', $stock->description) }}</textarea>
                </div>
                <div class="md:col-span-2 flex items-center gap-3 pt-2">
                    <input type="hidden" name="disponible" value="0">
                    <input type="checkbox" name="disponible" id="disponible" value="1"
                           {{ old('disponible', $stock->disponible) ? 'checked' : '' }}
                           class="w-4 h-4 rounded" style="accent-color:#16A34A;">
                    <label for="disponible" class="text-sm font-medium text-gray-700">Produit visible par les clients</label>
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
                Enregistrer les modifications
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
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
