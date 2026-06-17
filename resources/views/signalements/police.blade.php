@extends('layouts.sidebar')

@section('title', 'Signaler à la Police — GazApp')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background:linear-gradient(135deg,#dc2626,#b91c1c);box-shadow:0 6px 20px rgba(220,38,38,.25);">
            <span class="text-2xl">🚨</span>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Signaler à la Police</h1>
            <p class="text-sm text-gray-500 mt-0.5">Signalez un incident nécessitant l'intervention de la police</p>
        </div>
    </div>

    {{-- Bannière urgence --}}
    <div class="mb-6 p-5 rounded-2xl border" style="background:#fef2f2;border-color:#fecaca;">
        <div class="flex gap-3 items-start">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-red-800 mb-1">En cas d'urgence immédiate, appelez directement :</p>
                <p class="text-2xl font-black text-red-700">🚨 17 — Police</p>
                <p class="text-sm text-red-600 mt-1">ou le <strong>112</strong> (Urgences). Ce formulaire est pour les signalements non urgents.</p>
            </div>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 flex gap-3 items-center p-4 rounded-2xl bg-green-50 border border-green-100">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 flex gap-3 items-center p-4 rounded-2xl bg-red-50 border border-red-100">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Erreurs validation --}}
    @if($errors->any())
        <div class="mb-6 flex gap-3 items-start p-4 rounded-2xl bg-red-50 border border-red-100">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <ul class="text-sm text-red-700 space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <div class="bg-white rounded-3xl shadow-sm border border-red-50 overflow-hidden">

        <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#dc2626,#f97316,#fbbf24)"></div>

        <div class="p-8">
            <form action="{{ route('signalements.police') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Titre --}}
                    <div>
                        <label for="titre" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Titre du signalement <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="titre" id="titre" required
                               value="{{ old('titre') }}"
                               placeholder="Ex: Non-livraison après paiement"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>

                    {{-- Téléphone --}}
                    <div>
                        <label for="telephone" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Votre téléphone <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" name="telephone" id="telephone" required
                               value="{{ old('telephone') }}"
                               placeholder="Ex: 0123456789"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>

                    {{-- Adresse --}}
                    <div class="md:col-span-2">
                        <label for="adresse" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Adresse de l'incident <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="adresse" id="adresse" required
                               value="{{ old('adresse') }}"
                               placeholder="Adresse où s'est produit l'incident"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Description détaillée <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" required
                                  placeholder="Décrivez en détail l'incident, les personnes impliquées, l'heure, etc..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Type d'incident --}}
                    <div>
                        <label for="type_incident" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Type d'incident <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="type_incident" id="type_incident" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent appearance-none transition">
                                <option value="">Sélectionner un type</option>
                                <option value="non_livraison" {{ old('type_incident') == 'non_livraison' ? 'selected' : '' }}>Non-livraison après paiement</option>
                                <option value="vol"           {{ old('type_incident') == 'vol'           ? 'selected' : '' }}>Vol de marchandises</option>
                                <option value="agression"     {{ old('type_incident') == 'agression'     ? 'selected' : '' }}>Agression</option>
                                <option value="fraude"        {{ old('type_incident') == 'fraude'        ? 'selected' : '' }}>Fraude</option>
                                <option value="autre"         {{ old('type_incident') == 'autre'         ? 'selected' : '' }}>Autre</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Niveau d'urgence --}}
                    <div>
                        <label for="urgence" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Niveau d'urgence <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="urgence" id="urgence" required
                                    class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm font-medium
                                           focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent appearance-none transition">
                                <option value="faible"   {{ old('urgence') == 'faible'   ? 'selected' : '' }}>🟢 Faible</option>
                                <option value="moyenne"  {{ old('urgence') == 'moyenne'  ? 'selected' : '' }}>🟡 Moyenne</option>
                                <option value="élevée"   {{ old('urgence') == 'élevée'   ? 'selected' : '' }}>🟠 Élevée</option>
                                <option value="critique" {{ old('urgence') == 'critique' ? 'selected' : '' }}>🔴 Critique</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Témoins --}}
                    <div class="md:col-span-2">
                        <label for="témoins" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Témoins <span class="text-gray-400 font-normal normal-case">(optionnel)</span>
                        </label>
                        <textarea name="témoins" id="témoins" rows="3"
                                  placeholder="Nom et coordonnées des témoins éventuels..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition resize-none">{{ old('témoins') }}</textarea>
                    </div>

                </div>

                {{-- Note informative --}}
                <div class="mt-6 p-4 rounded-2xl border" style="background:#f0fdf4;border-color:#bbf7d0;">
                    <div class="flex gap-2 items-start">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-xs text-green-800 space-y-0.5">
                            <p>• Fournissez des informations précises et détaillées</p>
                            <p>• Gardez une copie de ce signalement</p>
                            <p>• Vous serez contacté par les autorités compétentes</p>
                            <p>• En cas d'urgence, appelez directement le <strong>17</strong></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6 flex items-center justify-between">
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
                        🚨 Envoyer le Signalement Police
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection