@extends('layouts.sidebar')

@section('title', 'Modifier la Livraison')

@section('content')

{{-- ── En-tête de page ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
            <a href="{{ route('livraisons.index') }}" class="hover:text-green-600 transition-colors">Livraisons</a>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('livraisons.show', $livraison) }}" class="hover:text-green-600 transition-colors">#{{ $livraison->id }}</a>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-gray-800 font-medium">Modifier</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">
            Modifier la Livraison
            <span class="text-green-600">#{{ $livraison->id }}</span>
        </h1>
    </div>
    <a href="{{ route('livraisons.show', $livraison) }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-white hover:bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Retour
    </a>
</div>

{{-- ── Erreurs ── --}}
@if($errors->any())
    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── Info commande liée (lecture seule) ── --}}
<div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-4 mb-6 flex items-center gap-4">
    <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
        </svg>
    </div>
    <div>
        <p class="text-xs font-semibold text-green-700 uppercase tracking-wide mb-0.5">Commande associée</p>
        <p class="text-sm font-bold text-gray-800">
            {{ $livraison->commande->numero_commande ?? 'N/A' }}
            <span class="font-normal text-gray-500 ml-1">— {{ $livraison->commande->nom_client ?? 'N/A' }}</span>
        </p>
    </div>
    <div class="ml-auto">
        <span class="text-xs text-green-600 bg-green-100 px-2.5 py-1 rounded-lg font-medium">Non modifiable</span>
    </div>
</div>

{{-- ── Formulaire ── --}}
<form action="{{ route('livraisons.update', $livraison) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- Carte principale --}}
    <div class="bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden">

        {{-- Header carte --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Modifier les informations</p>
                    <p class="text-xs text-gray-500">Champs obligatoires marqués (*)</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- Ligne 1 : Statut + Date --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Statut --}}
                <div class="space-y-1.5">
                    <label for="statut" class="block text-sm font-semibold text-gray-700">
                        Statut <span class="text-green-600">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                            </svg>
                        </div>
                        <select name="statut" id="statut" required
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none cursor-pointer text-gray-700">
                            <option value="en_cours" {{ old('statut', $livraison->statut) == 'en_cours' ? 'selected' : '' }}>⏳ En cours</option>
                            <option value="livrée"   {{ old('statut', $livraison->statut) == 'livrée'   ? 'selected' : '' }}>✅ Livrée</option>
                            <option value="annulée"  {{ old('statut', $livraison->statut) == 'annulée'  ? 'selected' : '' }}>❌ Annulée</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Date prévue --}}
                <div class="space-y-1.5">
                    <label for="date_livraison_prevue" class="block text-sm font-semibold text-gray-700">
                        Date de livraison prévue
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                        </div>
                        <input type="datetime-local" name="date_livraison_prevue" id="date_livraison_prevue"
                               value="{{ old('date_livraison_prevue', $livraison->date_livraison_prevue ? $livraison->date_livraison_prevue->format('Y-m-d\TH:i') : '') }}"
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-gray-700">
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div class="space-y-1.5">
                <label for="notes" class="block text-sm font-semibold text-gray-700">Notes</label>
                <textarea name="notes" id="notes" rows="4"
                          placeholder="Informations complémentaires sur la livraison..."
                          class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-gray-700 resize-none placeholder-gray-400">{{ old('notes', $livraison->notes) }}</textarea>
            </div>

        </div>
    </div>

    {{-- ── Boutons ── --}}
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('livraisons.show', $livraison) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-white hover:bg-gray-50 border border-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition-all duration-200">
            Annuler
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            Mettre à jour
        </button>
    </div>

</form>

@endsection