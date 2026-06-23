@extends('layouts.sidebar')

@section('title', 'Compléter mon profil vendeur')
@section('page-title', 'Profil vendeur')
@section('page-subtitle', 'Renseignez votre localisation pour recevoir des commandes')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header de page --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.25);">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Complétez votre localisation</h2>
            <p class="text-sm text-gray-500 mt-0.5">Indispensable pour que les clients proches de vous puissent vous trouver</p>
        </div>
    </div>

    {{-- Bandeau d'information --}}
    <div class="rounded-2xl p-4 mb-6 flex items-start gap-3"
         style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1.5px solid #bbf7d0;">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
        </svg>
        <p class="text-sm text-green-800">
            Votre position GPS exacte sera demandée automatiquement par votre navigateur.
            Elle permet aux clients de vous trouver parmi les vendeurs les plus proches d'eux.
        </p>
    </div>

    {{-- Erreur si géolocalisation refusée --}}
    <div id="geoloc-erreur" class="hidden rounded-2xl p-4 mb-6 flex items-start gap-3 bg-red-50 border border-red-200">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
        </svg>
        <p class="text-sm text-red-700">
            La géolocalisation a été refusée ou n'est pas disponible. Vous devez l'autoriser dans votre navigateur
            pour pouvoir enregistrer votre profil vendeur. Cliquez sur l'icône 🔒 ou ⓘ près de la barre d'adresse pour l'activer,
            puis rechargez la page.
        </p>
    </div>

    {{-- Formulaire --}}
    <form action="{{ route('vendeur.profil.enregistrer') }}" method="POST" class="space-y-6" id="profil-form">
        @csrf

        {{-- Section Contact --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Informations de contact</h3>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Quartier <span class="text-red-500">*</span></label>
                    <input type="text" name="quartier" required
                           value="{{ old('quartier', $vendeur->quartier) }}"
                           placeholder="Ex: Bonamoussadi, Akwa, Mvan…"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    @error('quartier')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse détaillée <span class="text-red-500">*</span></label>
                    <textarea name="adresse_detaillee" required rows="2"
                              placeholder="Rue, numéro, point de repère…"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all resize-none"
                              onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('adresse_detaillee', $vendeur->adresse_detaillee) }}</textarea>
                    @error('adresse_detaillee')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone <span class="text-red-500">*</span></label>
                    <input type="tel" name="telephone" required
                           value="{{ old('telephone', $vendeur->telephone) }}"
                           placeholder="Ex: 699 00 00 00"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:outline-none transition-all"
                           onfocus="this.style.borderColor='#16A34A'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,.12)';"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    @error('telephone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Section Géolocalisation --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                    </svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider" style="color:#15803D;">Position GPS</h3>
                </div>
            </div>
            <div class="p-6">
                <div id="geoloc-loading" class="flex items-center gap-3 mb-5 px-4 py-3 rounded-xl"
                     style="background:#f0fdf4;">
                    <svg class="w-5 h-5 animate-spin" style="color:#16A34A;" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <p class="text-sm text-green-800">Localisation en cours… autorisez l'accès à votre position si demandé.</p>
                </div>

                <div id="geoloc-success" class="hidden flex items-center gap-3 mb-5 px-4 py-3 rounded-xl"
                     style="background:#f0fdf4; border:1.5px solid #bbf7d0;">
                    <svg class="w-5 h-5 flex-shrink-0" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    <p class="text-sm font-semibold text-green-800">Position détectée avec succès !</p>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Latitude <span class="text-red-500">*</span></label>
                        <input type="text" id="latitude" name="latitude" readonly required
                               value="{{ old('latitude', $vendeur->latitude) }}"
                               placeholder="Détection automatique…"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 bg-gray-50 cursor-not-allowed">
                        @error('latitude')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Longitude <span class="text-red-500">*</span></label>
                        <input type="text" id="longitude" name="longitude" readonly required
                               value="{{ old('longitude', $vendeur->longitude) }}"
                               placeholder="Détection automatique…"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 bg-gray-50 cursor-not-allowed">
                        @error('longitude')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="button" onclick="demarrerGeolocalisation()"
                        class="mt-4 text-sm font-semibold flex items-center gap-1.5" style="color:#16A34A;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    Réessayer la détection GPS
                </button>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-2">
            <button type="submit" id="submit-btn"
                    class="flex items-center gap-2 px-7 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105 active:scale-95"
                    style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 16px rgba(22,163,74,.35);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Enregistrer mon profil
            </button>
        </div>
    </form>
</div>

<script>
function demarrerGeolocalisation() {
    document.getElementById('geoloc-loading').classList.remove('hidden');
    document.getElementById('geoloc-success').classList.add('hidden');
    document.getElementById('geoloc-erreur').classList.add('hidden');

    if (!navigator.geolocation) {
        afficherErreurGeoloc();
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('geoloc-loading').classList.add('hidden');
            document.getElementById('geoloc-success').classList.remove('hidden');
        },
        function (error) {
            afficherErreurGeoloc();
        },
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
    );
}

function afficherErreurGeoloc() {
    document.getElementById('geoloc-loading').classList.add('hidden');
    document.getElementById('geoloc-erreur').classList.remove('hidden');
}

// Lancer automatiquement dès le chargement de la page
document.addEventListener('DOMContentLoaded', demarrerGeolocalisation);
</script>
@endsection