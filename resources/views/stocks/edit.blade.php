@extends('layouts.sidebar')

@section('title', 'Modifier le Stock — GazApp')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Modifier le Stock
                <span class="text-green-600">#{{ $stock->id }}</span>
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Mettez à jour les informations de ce stock</p>
        </div>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
        <div class="mb-6 flex gap-3 items-start p-4 rounded-2xl bg-red-50 border border-red-100">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <ul class="text-sm text-red-700 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Carte formulaire --}}
    <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">

        <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>

        <div class="p-8">
            <form action="{{ route('stocks.update', $stock) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Type de gaz --}}
                    <div>
                        <label for="type_gaz" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Type de gaz <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="type_gaz" id="type_gaz" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent appearance-none transition">
                                <option value="butane"      {{ old('type_gaz', $stock->type_gaz) == 'butane'      ? 'selected' : '' }}>🟠 Butane</option>
                                <option value="propane"     {{ old('type_gaz', $stock->type_gaz) == 'propane'     ? 'selected' : '' }}>🔵 Propane</option>
                                <option value="gaz_naturel" {{ old('type_gaz', $stock->type_gaz) == 'gaz_naturel' ? 'selected' : '' }}>🟢 Gaz Naturel</option>
                                <option value="autre"       {{ old('type_gaz', $stock->type_gaz) == 'autre'       ? 'selected' : '' }}>⚪ Autre</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Quantité disponible --}}
                    <div>
                        <label for="quantite_disponible" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Quantité disponible <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="quantite_disponible" id="quantite_disponible" required min="0"
                               value="{{ old('quantite_disponible', $stock->quantite_disponible) }}"
                               placeholder="Nombre de bouteilles"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                    </div>

                    {{-- Prix unitaire --}}
                    <div>
                        <label for="prix_unitaire" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Prix unitaire (FCFA) <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-sm font-semibold text-gray-400">FCFA</span>
                            <input type="number" name="prix_unitaire" id="prix_unitaire" required min="0" step="0.01"
                                   value="{{ old('prix_unitaire', $stock->prix_unitaire) }}"
                                   placeholder="Prix par bouteille"
                                   class="w-full pl-16 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                          focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                        </div>
                    </div>

                    {{-- Disponibilité --}}
                    <div>
                        <label for="disponible" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Disponibilité <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="disponible" id="disponible" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent appearance-none transition">
                                <option value="1" {{ old('disponible', $stock->disponible) == '1' ? 'selected' : '' }}>✅ Disponible</option>
                                <option value="0" {{ old('disponible', $stock->disponible) == '0' ? 'selected' : '' }}>❌ Indisponible</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Description du stock (optionnel)..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none">{{ old('description', $stock->description) }}</textarea>
                    </div>

                </div>

                <div class="my-8 border-t border-gray-100"></div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('stocks.show', $stock) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                              hover:bg-gray-50 hover:border-gray-300 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition
                                   hover:opacity-90 active:scale-95 shadow-lg"
                            style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Mettre à jour
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection