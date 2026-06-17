@extends('layouts.sidebar')

@section('title', 'Modifier le Signalement — GazApp')

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
            <h1 class="text-2xl font-bold text-gray-900">Modifier le Signalement
                <span class="text-green-600">#{{ $signalement->id }}</span>
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Mettez à jour les informations de ce signalement</p>
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

    <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">

        <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>

        <div class="p-8">
            <form action="{{ route('signalements.update', $signalement) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Type --}}
                    <div>
                        <label for="type" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Type de signalement <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="type" id="type" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent appearance-none transition">
                                <option value="police"   {{ old('type', $signalement->type) == 'police'   ? 'selected' : '' }}>🚨 Police (Non-livraison, Vol, etc.)</option>
                                <option value="pompiers" {{ old('type', $signalement->type) == 'pompiers' ? 'selected' : '' }}>🚒 Pompiers (Incendie, Accident, etc.)</option>
                                <option value="autre"    {{ old('type', $signalement->type) == 'autre'    ? 'selected' : '' }}>Autre</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Statut --}}
                    <div>
                        <label for="statut" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Statut <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="statut" id="statut" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent appearance-none transition">
                                <option value="en_attente" {{ old('statut', $signalement->statut) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                                <option value="traité"     {{ old('statut', $signalement->statut) == 'traité'     ? 'selected' : '' }}>✅ Traité</option>
                                <option value="rejeté"     {{ old('statut', $signalement->statut) == 'rejeté'     ? 'selected' : '' }}>❌ Rejeté</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Titre --}}
                    <div class="md:col-span-2">
                        <label for="titre" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Titre du signalement <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="titre" id="titre" required
                               value="{{ old('titre', $signalement->titre) }}"
                               placeholder="Titre du signalement"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Description détaillée <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" required
                                  placeholder="Décrivez en détail le problème rencontré..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none">{{ old('description', $signalement->description) }}</textarea>
                    </div>

                    {{-- Adresse --}}
                    <div>
                        <label for="adresse" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Adresse de l'incident
                        </label>
                        <input type="text" name="adresse" id="adresse"
                               value="{{ old('adresse', $signalement->adresse) }}"
                               placeholder="Adresse où s'est produit l'incident"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                    </div>

                    {{-- Téléphone --}}
                    <div>
                        <label for="telephone" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Téléphone de contact
                        </label>
                        <input type="tel" name="telephone" id="telephone"
                               value="{{ old('telephone', $signalement->telephone) }}"
                               placeholder="Votre numéro de téléphone"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                    </div>

                    {{-- Réponse --}}
                    <div class="md:col-span-2">
                        <label for="reponse" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Réponse <span class="text-gray-400 font-normal normal-case">(optionnel)</span>
                        </label>
                        <textarea name="reponse" id="reponse" rows="4"
                                  placeholder="Réponse ou commentaire sur le signalement..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none">{{ old('reponse', $signalement->reponse) }}</textarea>
                    </div>

                </div>

                <div class="my-8 border-t border-gray-100"></div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('signalements.show', $signalement) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                              hover:bg-gray-50 transition">
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