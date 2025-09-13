@extends('layouts.app')

@section('title', 'Détails du Signalement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Détails du Signalement #{{ $signalement->id }}</h1>
            <a href="{{ route('signalements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations du Signalement</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">ID Signalement</label>
                            <p class="text-sm text-gray-900">{{ $signalement->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Type</label>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($signalement->type === 'police') bg-red-100 text-red-800
                                @elseif($signalement->type === 'pompiers') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($signalement->type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Statut</label>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($signalement->statut === 'en_attente') bg-yellow-100 text-yellow-800
                                @elseif($signalement->statut === 'traité') bg-green-100 text-green-800
                                @elseif($signalement->statut === 'rejeté') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $signalement->statut)) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date de création</label>
                            <p class="text-sm text-gray-900">{{ $signalement->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Informations de Contact</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Utilisateur</label>
                            <p class="text-sm text-gray-900">{{ $signalement->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Téléphone</label>
                            <p class="text-sm text-gray-900">{{ $signalement->telephone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-500">Adresse</label>
                            <p class="text-sm text-gray-900">{{ $signalement->adresse ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Titre</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-900 font-semibold">{{ $signalement->titre }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $signalement->description }}</p>
            </div>
        </div>

        @if($signalement->reponse)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Réponse</h3>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-900 whitespace-pre-line">{{ $signalement->reponse }}</p>
                </div>
            </div>
        @endif

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('signalements.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
            @if($signalement->statut === 'en_attente')
                <form action="{{ route('signalements.update', $signalement) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="statut" value="traité">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Marquer comme traité
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
