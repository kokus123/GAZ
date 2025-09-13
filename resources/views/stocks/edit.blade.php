@extends('layouts.app')

@section('title', 'Modifier le Stock')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier le Stock #{{ $stock->id }}</h1>
            <a href="{{ route('stocks.show', $stock) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stocks.update', $stock) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="type_gaz" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de gaz *
                    </label>
                    <select name="type_gaz" id="type_gaz" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="butane" {{ old('type_gaz', $stock->type_gaz) == 'butane' ? 'selected' : '' }}>Butane</option>
                        <option value="propane" {{ old('type_gaz', $stock->type_gaz) == 'propane' ? 'selected' : '' }}>Propane</option>
                        <option value="gaz_naturel" {{ old('type_gaz', $stock->type_gaz) == 'gaz_naturel' ? 'selected' : '' }}>Gaz Naturel</option>
                        <option value="autre" {{ old('type_gaz', $stock->type_gaz) == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label for="quantite_disponible" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantité disponible *
                    </label>
                    <input type="number" name="quantite_disponible" id="quantite_disponible" required min="0" 
                           value="{{ old('quantite_disponible', $stock->quantite_disponible) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nombre de bouteilles">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="prix_unitaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix unitaire (FCFA) *
                    </label>
                    <input type="number" name="prix_unitaire" id="prix_unitaire" required min="0" step="0.01" 
                           value="{{ old('prix_unitaire', $stock->prix_unitaire) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Prix par bouteille">
                </div>

                <div>
                    <label for="disponible" class="block text-sm font-medium text-gray-700 mb-2">
                        Disponible *
                    </label>
                    <select name="disponible" id="disponible" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1" {{ old('disponible', $stock->disponible) == '1' ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ old('disponible', $stock->disponible) == '0' ? 'selected' : '' }}>Indisponible</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Description du stock...">{{ old('description', $stock->description) }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('stocks.show', $stock) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
