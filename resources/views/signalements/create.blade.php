@extends('layouts.sidebar')

@section('title', 'Nouveau Signalement — GazApp')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background:linear-gradient(135deg,#dc2626,#b91c1c);box-shadow:0 6px 20px rgba(220,38,38,.25);">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nouveau Signalement</h1>
            <p class="text-sm text-gray-500 mt-0.5">Signalez un problème ou un incident</p>
        </div>
    </div>

    {{-- Bannière urgence --}}
    <div class="mb-6 p-4 rounded-2xl border flex gap-3 items-start" style="background:#fff7ed;border-color:#fed7aa;">
        <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-orange-800">En cas d'urgence, appelez directement :</p>
            <div class="mt-1 flex flex-wrap gap-3">
                <span class="text-sm font-bold text-red-700">🚨 Police : 17</span>
                <span class="text-sm font-bold text-orange-700">🚒 Pompiers : 18</span>
                <span class="text-sm font-bold text-blue-700">🏥 Samu : 15</span>
            </div>
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

    {{-- Formulaire --}}
    <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">

        <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#dc2626,#f97316,#fbbf24)"></div>

        <div class="p-8">
            <form action="{{ route('signalements.store') }}" method="POST">
                @csrf

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
                                <option value="">Sélectionner un type</option>
                                <option value="police"   {{ old('type') == 'police'   ? 'selected' : '' }}>🚨 Police (Non-livraison, Vol, etc.)</option>
                                <option value="pompiers" {{ old('type') == 'pompiers' ? 'selected' : '' }}>🚒 Pompiers (Incendie, Accident, etc.)</option>
                                <option value="autre"    {{ old('type') == 'autre'    ? 'selected' : '' }}>Autre</option>
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
                                <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                                <option value="traité"     {{ old('statut') == 'traité'     ? 'selected' : '' }}>✅ Traité</option>
                                <option value="rejeté"     {{ old('statut') == 'rejeté'     ? 'selected' : '' }}>❌ Rejeté</option>
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
                               value="{{ old('titre') }}"
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
                                         focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Adresse --}}
                    <div>
                        <label for="adresse" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Adresse de l'incident
                        </label>
                        <input type="text" name="adresse" id="adresse"
                               value="{{ old('adresse') }}"
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
                               value="{{ old('telephone') }}"
                               placeholder="Votre numéro de téléphone"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                    </div>

                </div>

                <div class="my-8 border-t border-gray-100"></div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('signalements.index') }}"
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
                            style="background:linear-gradient(135deg,#dc2626,#b91c1c);box-shadow:0 6px 20px rgba(220,38,38,.25);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Envoyer le Signalement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection