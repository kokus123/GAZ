@extends('layouts.app')

@section('title', 'Créer un Stock - GazApp')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un nouveau stock</h1>
        <p class="mt-2 text-gray-600">Ajoutez un nouveau type de gaz à votre inventaire</p>
    </div>

    <!-- Formulaire -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('stocks.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type de gaz -->
                    <div>
                        <label for="type_gaz" class="block text-sm font-medium text-gray-700">Type de Gaz</label>
                        <select id="type_gaz" name="type_gaz" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('type_gaz') border-red-500 @enderror">
                            <option value="">Sélectionnez un type</option>
                            <option value="propane" {{ old('type_gaz') == 'propane' ? 'selected' : '' }}>Propane</option>
                            <option value="butane" {{ old('type_gaz') == 'butane' ? 'selected' : '' }}>Butane</option>
                            <option value="gaz_naturel" {{ old('type_gaz') == 'gaz_naturel' ? 'selected' : '' }}>Gaz Naturel</option>
                        </select>
                        @error('type_gaz')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unité -->
                    <div>
                        <label for="unite" class="block text-sm font-medium text-gray-700">Unité</label>
                        <select id="unite" name="unite" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('unite') border-red-500 @enderror">
                            <option value="">Sélectionnez une unité</option>
                            <option value="kg" {{ old('unite') == 'kg' ? 'selected' : '' }}>Kilogrammes (kg)</option>
                            <option value="litres" {{ old('unite') == 'litres' ? 'selected' : '' }}>Litres</option>
                            <option value="m3" {{ old('unite') == 'm3' ? 'selected' : '' }}>Mètres cubes (m³)</option>
                        </select>
                        @error('unite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantité disponible -->
                    <div>
                        <label for="quantite_disponible" class="block text-sm font-medium text-gray-700">Quantité Disponible</label>
                        <input type="number" id="quantite_disponible" name="quantite_disponible" required min="0"
                               value="{{ old('quantite_disponible') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('quantite_disponible') border-red-500 @enderror">
                        @error('quantite_disponible')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantité minimum -->
                    <div>
                        <label for="quantite_minimum" class="block text-sm font-medium text-gray-700">Quantité Minimum</label>
                        <input type="number" id="quantite_minimum" name="quantite_minimum" required min="0"
                               value="{{ old('quantite_minimum') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('quantite_minimum') border-red-500 @enderror">
                        @error('quantite_minimum')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix unitaire -->
                    <div class="md:col-span-2">
                        <label for="prix_unitaire" class="block text-sm font-medium text-gray-700">Prix Unitaire (FCFA)</label>
                        <input type="number" id="prix_unitaire" name="prix_unitaire" required min="0" step="0.01"
                               value="{{ old('prix_unitaire') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('prix_unitaire') border-red-500 @enderror">
                        @error('prix_unitaire')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror"
                                  placeholder="Description du stock...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('stocks.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Créer le Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.sidebar')

@section('title', 'Créer un Stock — GazApp')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Créer un nouveau stock</h1>
            <p class="text-sm text-gray-500 mt-0.5">Ajoutez un nouveau type de gaz à votre inventaire</p>
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

        {{-- Bandeau supérieur --}}
        <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>

        <div class="p-8">
            <form action="{{ route('stocks.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Type de gaz --}}
                    <div>
                        <label for="type_gaz" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Type de Gaz <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select id="type_gaz" name="type_gaz" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                                           appearance-none transition
                                           @error('type_gaz') border-red-300 bg-red-50 @else border-gray-200 @enderror">
                                <option value="">Sélectionnez un type</option>
                                <option value="propane"     {{ old('type_gaz') == 'propane'     ? 'selected' : '' }}>🔵 Propane</option>
                                <option value="butane"      {{ old('type_gaz') == 'butane'      ? 'selected' : '' }}>🟠 Butane</option>
                                <option value="gaz_naturel" {{ old('type_gaz') == 'gaz_naturel' ? 'selected' : '' }}>🟢 Gaz Naturel</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        @error('type_gaz')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Unité --}}
                    <div>
                        <label for="unite" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Unité <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select id="unite" name="unite" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                                           appearance-none transition
                                           @error('unite') border-red-300 bg-red-50 @else border-gray-200 @enderror">
                                <option value="">Sélectionnez une unité</option>
                                <option value="kg"     {{ old('unite') == 'kg'     ? 'selected' : '' }}>Kilogrammes (kg)</option>
                                <option value="litres" {{ old('unite') == 'litres' ? 'selected' : '' }}>Litres</option>
                                <option value="m3"     {{ old('unite') == 'm3'     ? 'selected' : '' }}>Mètres cubes (m³)</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        @error('unite')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Quantité disponible --}}
                    <div>
                        <label for="quantite_disponible" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Quantité Disponible <span class="text-red-400">*</span>
                        </label>
                        <input type="number" id="quantite_disponible" name="quantite_disponible" required min="0"
                               value="{{ old('quantite_disponible') }}"
                               placeholder="0"
                               class="w-full px-4 py-3 rounded-xl border bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition
                                      @error('quantite_disponible') border-red-300 bg-red-50 @else border-gray-200 @enderror">
                        @error('quantite_disponible')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Quantité minimum --}}
                    <div>
                        <label for="quantite_minimum" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Quantité Minimum <span class="text-red-400">*</span>
                        </label>
                        <input type="number" id="quantite_minimum" name="quantite_minimum" required min="0"
                               value="{{ old('quantite_minimum') }}"
                               placeholder="0"
                               class="w-full px-4 py-3 rounded-xl border bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition
                                      @error('quantite_minimum') border-red-300 bg-red-50 @else border-gray-200 @enderror">
                        @error('quantite_minimum')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Prix unitaire --}}
                    <div class="md:col-span-2">
                        <label for="prix_unitaire" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Prix Unitaire (FCFA) <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-sm font-semibold text-gray-400">FCFA</span>
                            <input type="number" id="prix_unitaire" name="prix_unitaire" required min="0" step="0.01"
                                   value="{{ old('prix_unitaire') }}"
                                   placeholder="0"
                                   class="w-full pl-16 pr-4 py-3 rounded-xl border bg-gray-50 text-gray-800 text-sm font-medium
                                          focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition
                                          @error('prix_unitaire') border-red-300 bg-red-50 @else border-gray-200 @enderror">
                        </div>
                        @error('prix_unitaire')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  placeholder="Description du stock (optionnel)..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none
                                         @error('description') border-red-300 bg-red-50 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Séparateur --}}
                <div class="my-8 border-t border-gray-100"></div>

                {{-- Actions --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('stocks.index') }}"
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
                        Créer le Stock
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection