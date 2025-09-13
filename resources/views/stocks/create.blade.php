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
