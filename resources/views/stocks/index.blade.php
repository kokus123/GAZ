@extends('layouts.sidebar')

@section('title', 'Gestion des Stocks — GazApp')
@section('page-title', 'Gestion des Stocks')
@section('page-subtitle', 'Inventaire de vos bouteilles de gaz')

@section('content')
<div class="space-y-6">

    {{-- En-tête avec stats rapides --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-green-100 shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.25);">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total stocks</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stocks->total() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-green-100 shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-green-50">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Disponibles</p>
                <p class="text-2xl font-bold text-green-600">{{ $stocks->where('disponible', 1)->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-green-100 shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-red-50">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Indisponibles</p>
                <p class="text-2xl font-bold text-red-500">{{ $stocks->where('disponible', 0)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Tableau principal --}}
    <div class="bg-white rounded-2xl border border-green-100 shadow-sm overflow-hidden">

        {{-- Header tableau --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-5 border-b border-gray-50">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Tous les stocks</h2>
                <p class="text-xs text-gray-400 mt-0.5">Gérez votre inventaire de gaz</p>
            </div>
            <a href="{{ route('stocks.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:scale-105 hover:shadow-lg"
               style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.3);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouveau stock
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background:#f0fdf4;">
                        <th class="px-6 py-3.5 text-left text-xs font-700 text-green-700 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3.5 text-left text-xs font-700 text-green-700 uppercase tracking-wider">Type de gaz</th>
                        <th class="px-6 py-3.5 text-left text-xs font-700 text-green-700 uppercase tracking-wider">Quantité</th>
                        <th class="px-6 py-3.5 text-left text-xs font-700 text-green-700 uppercase tracking-wider">Prix unitaire</th>
                        <th class="px-6 py-3.5 text-left text-xs font-700 text-green-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3.5 text-left text-xs font-700 text-green-700 uppercase tracking-wider">Vendeur</th>
                        <th class="px-6 py-3.5 text-right text-xs font-700 text-green-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($stocks as $stock)
                        <tr class="hover:bg-green-50/40 transition-colors group">
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">#{{ $stock->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                         style="background:#f0fdf4; border:1px solid #bbf7d0;">
                                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800 capitalize">{{ $stock->type_gaz }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-800">{{ number_format($stock->quantite_disponible, 0, ',', ' ') }}</span>
                                <span class="text-xs text-gray-400 ml-1">bouteilles</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-green-700">{{ number_format($stock->prix_unitaire, 0, ',', ' ') }}</span>
                                <span class="text-xs text-gray-400 ml-1">FCFA</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($stock->disponible)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Disponible
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Indisponible
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $stock->vendeur->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('stocks.show', $stock) }}"
                                       class="p-2 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors" title="Voir">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>
                                    @if(Auth::user()->isVendeur() && $stock->vendeur_id === Auth::id())
                                        <a href="{{ route('stocks.edit', $stock) }}"
                                           class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Modifier">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('stocks.destroy', $stock) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Supprimer ce stock ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-green-50">
                                        <svg class="w-7 h-7 text-green-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Aucun stock trouvé</p>
                                    <a href="{{ route('stocks.create') }}" class="text-xs font-semibold text-green-600 hover:underline">Créer le premier stock →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($stocks->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $stocks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection