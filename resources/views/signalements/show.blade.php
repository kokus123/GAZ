@extends('layouts.sidebar')

@section('title', 'Détails du Signalement — GazApp')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                 @if($signalement->type === 'police')
                     style="background:linear-gradient(135deg,#dc2626,#b91c1c);box-shadow:0 6px 20px rgba(220,38,38,.25);"
                 @elseif($signalement->type === 'pompiers')
                     style="background:linear-gradient(135deg,#ea580c,#c2410c);box-shadow:0 6px 20px rgba(234,88,12,.25);"
                 @else
                     style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);"
                 @endif>
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Signalement
                    <span class="text-green-600">#{{ $signalement->id }}</span>
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">Détails complets du signalement</p>
            </div>
        </div>
        <a href="{{ route('signalements.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                  hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </a>
    </div>

    {{-- Badges statut + type --}}
    <div class="mb-6 flex flex-wrap items-center gap-3">
        {{-- Type --}}
        @if($signalement->type === 'police')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">🚨 Police</span>
        @elseif($signalement->type === 'pompiers')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">🚒 Pompiers</span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Autre</span>
        @endif

        {{-- Statut --}}
        @if($signalement->statut === 'en_attente')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                En attente
            </span>
        @elseif($signalement->statut === 'traité')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Traité
            </span>
        @elseif($signalement->statut === 'rejeté')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                Rejeté
            </span>
        @endif

        <span class="text-xs text-gray-400">Créé le {{ $signalement->created_at->format('d/m/Y à H:i') }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Informations du signalement --}}
        <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">
            <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Signalement
                </h3>
                <dl class="space-y-3">
                    <div class="py-2 border-b border-gray-50">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">ID</dt>
                        <dd class="text-sm font-semibold text-gray-900">#{{ $signalement->id }}</dd>
                    </div>
                    <div class="py-2 border-b border-gray-50">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">Titre</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ $signalement->titre }}</dd>
                    </div>
                    <div class="py-2 border-b border-gray-50">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">Créé le</dt>
                        <dd class="text-sm text-gray-700">{{ $signalement->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Contact --}}
        <div class="bg-white rounded-3xl shadow-sm border border-green-50 overflow-hidden">
            <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#16A34A,#22C55E,#86efac)"></div>
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Contact
                </h3>
                <dl class="space-y-3">
                    <div class="py-2 border-b border-gray-50">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">Utilisateur</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ $signalement->user->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-2 border-b border-gray-50">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">Téléphone</dt>
                        <dd class="text-sm text-gray-700">{{ $signalement->telephone ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-2">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide mb-1">Adresse</dt>
                        <dd class="text-sm text-gray-700">{{ $signalement->adresse ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="mt-6 bg-white rounded-3xl shadow-sm border border-green-50 p-6">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            Description
        </h3>
        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $signalement->description }}</p>
    </div>

    {{-- Réponse --}}
    @if($signalement->reponse)
        <div class="mt-6 bg-white rounded-3xl shadow-sm border border-green-100 p-6">
            <h3 class="text-sm font-bold text-green-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                Réponse
            </h3>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $signalement->reponse }}</p>
        </div>
    @endif

    {{-- Actions --}}
    <div class="mt-6 flex items-center justify-between">
        <a href="{{ route('signalements.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                  hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>

        @if($signalement->statut === 'en_attente')
            <form action="{{ route('signalements.update', $signalement) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="statut" value="traité">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition
                               hover:opacity-90 active:scale-95 shadow-lg"
                        style="background:linear-gradient(135deg,#16A34A,#15803D);box-shadow:0 6px 20px rgba(22,163,74,.30);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Marquer comme traité
                </button>
            </form>
        @endif
    </div>

</div>
@endsection