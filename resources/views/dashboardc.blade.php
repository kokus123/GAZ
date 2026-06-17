{{-- =========================================================
     GazApp — dashboardc.blade.php (Client)
     Utilise layouts/sidebar
     ========================================================= --}}
@extends('layouts.sidebar')

@section('title', 'Mon Espace - GazApp')
@section('page-title', 'Mon Dashboard')
@section('page-subtitle', 'Bienvenue, {{ Auth::user()->name }} 👋')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .stat-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #dcfce7;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(22,163,74,.1);
    }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #166534;
        line-height: 1;
    }
    .stat-label {
        font-size: 12.5px;
        color: #6b7280;
        font-weight: 500;
        margin-top: 2px;
    }
    .action-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: #fff;
        border: 1px solid #dcfce7;
        border-radius: 16px;
        text-decoration: none;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
        transition: all .2s;
    }
    .action-card:hover {
        border-color: #86efac;
        background: #f0fdf4;
        transform: translateX(4px);
        box-shadow: 0 4px 16px rgba(22,163,74,.1);
    }
    .action-card .icon-wrap {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .badge-statut {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .table-row:hover { background: #f0fdf4; }
    .section-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #dcfce7;
        overflow: hidden;
    }
    .section-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f0fdf4;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #166534;
    }
</style>

{{-- ── Statistiques ── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7;">
            <svg class="w-6 h-6" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['mes_commandes'] ?? 0 }}</div>
            <div class="stat-label">Mes commandes</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fef9c3;">
            <svg class="w-6 h-6" style="color:#ca8a04;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color:#92400e;">{{ $stats['commandes_en_attente'] ?? 0 }}</div>
            <div class="stat-label">En attente</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7;">
            <svg class="w-6 h-6" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['commandes_livrees'] ?? 0 }}</div>
            <div class="stat-label">Livrées</div>
        </div>
    </div>

</div>

{{-- ── Actions rapides ── --}}
<div class="section-card mb-6">
    <div class="section-header">
        <h2 class="section-title">Actions rapides</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4">

        <a href="{{ route('commandes.create') }}" class="action-card">
            <div class="icon-wrap" style="background:#dcfce7;">
                <svg class="w-5 h-5" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <span>Nouvelle commande</span>
            <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
        </a>

        <a href="{{ route('commandes.index') }}" class="action-card">
            <div class="icon-wrap" style="background:#dbeafe;">
                <svg class="w-5 h-5" style="color:#2563eb;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>
            </div>
            <span>Mes commandes</span>
            <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
        </a>

        <a href="{{ route('signalements.index') }}" class="action-card">
            <div class="icon-wrap" style="background:#fee2e2;">
                <svg class="w-5 h-5" style="color:#dc2626;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
            </div>
            <span>Signaler un problème</span>
            <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
        </a>

    </div>
</div>

{{-- ── Commandes récentes ── --}}
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Mes commandes récentes</h2>
        <a href="{{ route('commandes.index') }}" class="text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
            Voir tout →
        </a>
    </div>

    @if(isset($commandes_recentes) && $commandes_recentes->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="background:#f0fdf4; border-bottom:1px solid #dcfce7;">
                    <th class="px-6 py-3 text-left text-xs font-700 text-green-800 uppercase tracking-wider">N° Commande</th>
                    <th class="px-6 py-3 text-left text-xs font-700 text-green-800 uppercase tracking-wider">Vendeur</th>
                    <th class="px-6 py-3 text-left text-xs font-700 text-green-800 uppercase tracking-wider">Quantité</th>
                    <th class="px-6 py-3 text-left text-xs font-700 text-green-800 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-700 text-green-800 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-700 text-green-800 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes_recentes as $commande)
                <tr class="table-row border-b border-gray-50 transition-colors">
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $commande->numero_commande }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $commande->vendeur->name ?? 'Non assigné' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $commande->quantite }} kg</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4">
                        <span class="badge-statut
                            @if($commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                            @elseif($commande->statut === 'confirmee') bg-blue-100 text-blue-800
                            @elseif($commande->statut === 'en_cours') " style="background:#ede9fe;color:#6d28d9;"
                            @elseif($commande->statut === 'livree') bg-green-100 text-green-800
                            @elseif($commande->statut === 'annulee') bg-red-100 text-red-800
                            @endif">
                            @if($commande->statut === 'en_attente') ⏳
                            @elseif($commande->statut === 'confirmee') ✅
                            @elseif($commande->statut === 'en_cours') 🚚
                            @elseif($commande->statut === 'livree') 🎉
                            @elseif($commande->statut === 'annulee') ❌
                            @endif
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('commandes.show', $commande) }}"
                               class="text-xs font-semibold text-green-700 hover:text-green-900 transition-colors">
                                Voir →
                            </a>
                            @if($commande->canBeCancelled())
                            <form method="POST" action="{{ route('commandes.annuler', $commande) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 transition-colors"
                                        onclick="return confirm('Annuler cette commande ?')">Annuler</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
    <div class="flex flex-col items-center py-14 px-6 text-center">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4" style="background:#dcfce7;">
            <svg class="w-8 h-8" style="color:#16A34A;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-800 mb-1">Aucune commande encore</h3>
        <p class="text-sm text-gray-400 mb-5">Passez votre première commande de gaz en quelques clics.</p>
        <a href="{{ route('commandes.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:scale-105"
           style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.3);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9"/>
            </svg>
            Commander maintenant
        </a>
    </div>
    @endif

</div>

@endsection