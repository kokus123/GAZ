{{-- =========================================================
     GazApp — layouts/sidebar.blade.php
     Layout avec sidebar blanc/vert — Client & Vendeur
     ========================================================= --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GazApp')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   '#16A34A',
                        secondary: '#15803D',
                        accent:    '#22C55E',
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* ── Sidebar ── */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #dcfce7;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 40;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            box-shadow: 4px 0 24px rgba(22,163,74,.06);
        }
        #sidebar.sidebar-hidden { transform: translateX(-100%); }

        /* ── Contenu principal décalé ── */
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: #f0fdf4;
            transition: margin-left .28s cubic-bezier(.4,0,.2,1);
        }
        #main-content.full-width { margin-left: 0; }

        /* ── Overlay mobile ── */
        #sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.35);
            z-index: 39;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.active { display: block; }

        /* ── Nav items ── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 12px;
            margin: 2px 12px;
            color: #4b5563;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background .18s, color .18s, transform .18s;
            cursor: pointer;
        }
        .nav-item:hover {
            background: #f0fdf4;
            color: #15803D;
            transform: translateX(3px);
        }
        .nav-item.active {
            background: linear-gradient(135deg, #16A34A, #15803D);
            color: #fff;
            box-shadow: 0 4px 14px rgba(22,163,74,.30);
        }
        .nav-item.active svg { color: #fff !important; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .nav-section-label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #9ca3af;
            padding: 18px 16px 6px 28px;
        }

        /* ── Badge notif ── */
        .nav-badge {
            margin-left: auto;
            background: #dcfce7;
            color: #15803D;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .nav-item.active .nav-badge {
            background: rgba(255,255,255,.25);
            color: #fff;
        }

        /* ── Topbar ── */
        #topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #dcfce7;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: 0 2px 12px rgba(22,163,74,.06);
        }

        /* ── Scrollbar vert discret ── */
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background: #bbf7d0; border-radius: 4px; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.mobile-open { transform: translateX(0); }
            #main-content { margin-left: 0 !important; }
        }

        /* ── Divider ── */
        .sidebar-divider {
            height: 1px;
            background: #f0fdf4;
            margin: 8px 16px;
        }

        /* ── Avatar initiales ── */
        .avatar-initials {
            width: 36px; height: 36px;
            background: linear-gradient(135deg,#16A34A,#15803D);
            color: #fff;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
            flex-shrink: 0;
        }

        /* ── Pulse online ── */
        .pulse-dot {
            width: 8px; height: 8px;
            background: #22C55E;
            border-radius: 50%;
            position: relative;
        }
        .pulse-dot::after {
            content: '';
            position: absolute; inset: -3px;
            border-radius: 50%;
            background: #22C55E;
            opacity: .3;
            animation: pulsering 1.8s infinite;
        }
        @keyframes pulsering { 0%,100%{transform:scale(1);opacity:.3} 50%{transform:scale(1.5);opacity:0} }

        /* ── Flash messages ── */
        .flash-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
        .flash-error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
    </style>
</head>
<body class="bg-gray-50" style="font-family:'Inter',sans-serif;">

{{-- ══════════════════════════════════════════════════════════
     SIDEBAR
     ══════════════════════════════════════════════════════════ --}}
<aside id="sidebar">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-green-50">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.3);">
            <svg class="w-5 h-5" viewBox="0 0 24 28" fill="none">
                <path d="M12 26C6 24 4 18 5.5 13.5C6.5 10 8 8.5 7.5 5
                         C9 7.5 9.2 10 8.5 12.5C10.5 10 11 7 10 3
                         C13.5 6.5 14.5 11 12.5 14.5C14.5 12 15.5 9 15 6
                         C17.5 9 17 14.5 15 18C16.5 16 17 13 16.5 10.5
                         C18 13.5 17.5 18 16 21C14.5 24 13.2 25.5 12 26Z"
                      fill="#fff"/>
            </svg>
        </div>
        <div>
            <span class="font-extrabold text-lg tracking-tight" style="color:#166534;">GazApp</span>
            <p class="text-xs text-gray-400 leading-none mt-0.5">
                @auth
                    @if(Auth::user()->isAdmin())
                        Administrateur
                    @elseif(Auth::user()->isVendeur())
                        Espace Vendeur
                    @else
                        Espace Client
                    @endif
                @endauth
            </p>
        </div>
        {{-- Bouton fermer sidebar (desktop) --}}
        <button onclick="toggleSidebar()" class="ml-auto p-1.5 rounded-lg hover:bg-green-50 text-gray-400 hover:text-green-700 transition-colors" title="Réduire">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>
        </button>
    </div>

    {{-- Profil compact --}}
    @auth
    <div class="flex items-center gap-3 mx-4 my-4 p-3 rounded-2xl" style="background:#f0fdf4; border:1px solid #dcfce7;">
        <div class="avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
        </div>
        <div class="pulse-dot flex-shrink-0"></div>
    </div>
    @endauth

    {{-- Navigation scrollable --}}
    <nav class="flex-1 overflow-y-auto py-2">

        @auth

        {{-- ── NAVIGATION CLIENT ── --}}
        @if(!Auth::user()->isAdmin() && !Auth::user()->isVendeur())

            <p class="nav-section-label">Principal</p>

            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') || request()->routeIs('welcome') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                Accueil
            </a>

            <a href="{{ route('dashboardc') }}" class="nav-item {{ request()->routeIs('dashboardc') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                Mon Dashboard
            </a>

            <p class="nav-section-label">Mes commandes</p>

            <a href="{{ route('commandes.create') }}" class="nav-item {{ request()->routeIs('commandes.create') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                Nouvelle commande
            </a>

            <a href="{{ route('commandes.index') }}" class="nav-item {{ request()->routeIs('commandes.index') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
                </svg>
                Mes commandes
            </a>

            <p class="nav-section-label">Suivi & Support</p>

            <a href="{{ route('paiements.index') }}" class="nav-item {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                </svg>
                Paiements
            </a>

            <a href="{{ route('signalements.index') }}" class="nav-item {{ request()->routeIs('signalements.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
                Signaler un problème
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('visite') }}" class="nav-item {{ request()->routeIs('visite') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                </svg>
                À propos
            </a>

        {{-- ── NAVIGATION VENDEUR ── --}}
        @elseif(Auth::user()->isVendeur())

            <p class="nav-section-label">Principal</p>

            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') || request()->routeIs('welcome') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                Accueil
            </a>

            <a href="{{ route('dashboardv') }}" class="nav-item {{ request()->routeIs('dashboardv') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                Mon Dashboard
            </a>

            <p class="nav-section-label">Commandes</p>

            <a href="{{ route('commandes.index') }}" class="nav-item {{ request()->routeIs('commandes.index') || request()->routeIs('commandes.show') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
                </svg>
                Toutes les commandes
            </a>

            <a href="{{ route('livraisons.index') }}" class="nav-item {{ request()->routeIs('livraisons.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                </svg>
                Livraisons
            </a>

            <p class="nav-section-label">Gestion</p>

            <a href="{{ route('stocks.index') }}" class="nav-item {{ request()->routeIs('stocks.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                </svg>
                Mes stocks
            </a>

            <a href="{{ route('paiements.index') }}" class="nav-item {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                </svg>
                Paiements reçus
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('visite') }}" class="nav-item {{ request()->routeIs('visite') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                </svg>
                À propos
            </a>

        @endif

        @endauth

    </nav>

    {{-- Footer sidebar — Déconnexion + Paramètres --}}
    @auth
    <div class="border-t border-green-50 p-3 space-y-1">
        <a href="{{ route('settings.profile') }}" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
            Paramètres
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item w-full text-left" style="border:none;background:none;">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="color:#dc2626;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                </svg>
                <span style="color:#dc2626; font-weight:600;">Déconnexion</span>
            </button>
        </form>
    </div>
    @endauth

</aside>

{{-- ══════════════════════════════════════════════════════════
     OVERLAY MOBILE
     ══════════════════════════════════════════════════════════ --}}
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ══════════════════════════════════════════════════════════
     CONTENU PRINCIPAL
     ══════════════════════════════════════════════════════════ --}}
<div id="main-content">

    {{-- TOPBAR --}}
    <header id="topbar">

        {{-- Burger --}}
        <button onclick="toggleSidebar()" id="sidebar-toggle"
                class="p-2 rounded-xl hover:bg-green-50 text-gray-500 hover:text-green-700 transition-colors"
                aria-label="Toggle sidebar">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
            </svg>
        </button>

        {{-- Titre de la page --}}
        <div class="flex-1">
            <h1 class="text-base font-semibold text-gray-800">@yield('page-title', 'GazApp')</h1>
            <p class="text-xs text-gray-400 hidden sm:block">@yield('page-subtitle', '')</p>
        </div>

        {{-- Accueil rapide --}}
        <a href="{{ route('home') }}"
           class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-xl text-green-700 hover:bg-green-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            Accueil
        </a>

        @auth
        {{-- CTA selon le rôle --}}
        @if(!Auth::user()->isAdmin() && !Auth::user()->isVendeur())
            <a href="{{ route('commandes.create') }}"
               class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white rounded-xl transition-all hover:scale-105"
               style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.3);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span class="hidden sm:inline">Commander</span>
            </a>
        @elseif(Auth::user()->isVendeur())
            <a href="{{ route('stocks.index') }}"
               class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white rounded-xl transition-all hover:scale-105"
               style="background:linear-gradient(135deg,#16A34A,#15803D); box-shadow:0 4px 12px rgba(22,163,74,.3);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9"/>
                </svg>
                <span class="hidden sm:inline">Gérer stock</span>
            </a>
        @endif
        @endauth

    </header>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flash-success mx-6 mt-4 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-error mx-6 mt-4 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="flash-error mx-6 mt-4 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Contenu de la page --}}
    <main class="p-6">
        @yield('content')
    </main>

</div>

{{-- ══════════════════════════════════════════════════════════
     CHATBOT IA (clients uniquement)
     ══════════════════════════════════════════════════════════ --}}
@auth
@if(!Auth::user()->isAdmin() && !Auth::user()->isVendeur())
<style>
    #chatbot-btn { transition: transform .2s ease, box-shadow .2s ease; }
    #chatbot-btn:hover { transform: scale(1.08); box-shadow: 0 8px 28px rgba(26,122,74,.5) !important; }
    #chat-window { transition: opacity .25s ease, transform .25s ease; transform-origin: bottom right; }
    #chat-window.chat-hidden  { opacity: 0; transform: scale(.92) translateY(10px); pointer-events: none; }
    #chat-window.chat-visible { opacity: 1; transform: scale(1) translateY(0); pointer-events: all; }
    .dot-typing { width:7px;height:7px;background:#9ca3af;border-radius:50%;display:inline-block;animation:dotBounce 1.3s infinite ease-in-out; }
    .dot-typing:nth-child(2){animation-delay:.2s}.dot-typing:nth-child(3){animation-delay:.4s}
    @keyframes dotBounce{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-7px)}}
</style>
<div id="chatbot-container" style="position:fixed;bottom:24px;right:24px;z-index:9999;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
    <button onclick="toggleChat()" id="chatbot-btn" aria-label="Ouvrir l'assistant GazApp"
        style="width:56px;height:56px;background:#16A34A;border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 18px rgba(22,163,74,.45);">
        <svg width="30" height="30" viewBox="0 0 36 36" fill="none">
            <rect x="5" y="7" width="26" height="16" rx="5" fill="white"/>
            <rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/>
            <circle cx="12" cy="14.2" r="1.8" fill="white"/>
            <rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/>
            <circle cx="24" cy="14.2" r="1.8" fill="white"/>
            <rect x="11" y="19.5" width="14" height="2.2" rx="1.1" fill="#d1fae5"/>
        </svg>
    </button>
    <div id="chat-window" class="chat-hidden"
         style="position:absolute;bottom:68px;right:0;width:320px;background:white;border-radius:20px;overflow:hidden;box-shadow:0 12px 48px rgba(0,0,0,.2);border:1px solid #e5e7eb;display:flex;flex-direction:column;height:440px;">
        <div style="background:#16A34A;padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;">
            <div style="width:38px;height:38px;background:rgba(255,255,255,.18);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" viewBox="0 0 36 36" fill="none"><rect x="5" y="7" width="26" height="16" rx="5" fill="white"/><rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/><circle cx="12" cy="14.2" r="1.8" fill="white"/><rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/><circle cx="24" cy="14.2" r="1.8" fill="white"/></svg>
            </div>
            <div style="flex:1;">
                <p style="color:white;font-weight:600;font-size:13px;margin:0;">Assistant GazApp</p>
                <p style="color:rgba(255,255,255,.75);font-size:11px;margin:0;"><span style="display:inline-block;width:6px;height:6px;background:#86efac;border-radius:50%;margin-right:4px;vertical-align:middle;"></span>En ligne</p>
            </div>
            <button onclick="toggleChat()" style="background:rgba(255,255,255,.15);border:none;color:white;cursor:pointer;width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">✕</button>
        </div>
        <div id="chat-messages" style="flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:10px;background:#f9fafb;">
            <div style="display:flex;gap:8px;align-items:flex-start;">
                <div style="width:28px;height:28px;background:#16A34A;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="15" height="15" viewBox="0 0 36 36" fill="none"><rect x="5" y="7" width="26" height="16" rx="5" fill="white"/><rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/><circle cx="12" cy="14.2" r="1.8" fill="white"/><rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/><circle cx="24" cy="14.2" r="1.8" fill="white"/></svg></div>
                <div style="background:white;border-radius:14px;border-top-left-radius:4px;padding:9px 12px;font-size:12.5px;color:#374151;max-width:220px;box-shadow:0 1px 4px rgba(0,0,0,.07);line-height:1.5;">
                    Bonjour <strong>{{ Auth::user()->name }}</strong> ! 👋 Je suis votre assistant GazApp.
                </div>
            </div>
        </div>
        <div id="suggestions" style="padding:8px 10px;display:flex;gap:5px;flex-wrap:wrap;background:white;border-top:1px solid #f3f4f6;flex-shrink:0;">
            <button onclick="envoyerSuggestion('Comment passer une commande ?')" style="font-size:11px;background:#f0fdf4;color:#16A34A;border:1px solid #bbf7d0;padding:4px 10px;border-radius:20px;cursor:pointer;font-weight:500;">🛒 Commander</button>
            <button onclick="envoyerSuggestion('Où en est ma livraison ?')" style="font-size:11px;background:#f0fdf4;color:#16A34A;border:1px solid #bbf7d0;padding:4px 10px;border-radius:20px;cursor:pointer;font-weight:500;">📦 Suivi</button>
            <button onclick="envoyerSuggestion('Urgence fuite de gaz !')" style="font-size:11px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:4px 10px;border-radius:20px;cursor:pointer;font-weight:500;">🚨 Urgence</button>
        </div>
        <div style="padding:10px;background:white;border-top:1px solid #f3f4f6;display:flex;gap:7px;align-items:center;flex-shrink:0;">
            <input id="chat-input" type="text" placeholder="Votre message..." onkeydown="if(event.key==='Enter')envoyerMessage()"
                style="flex:1;border:1.5px solid #e5e7eb;border-radius:10px;padding:7px 11px;font-size:12.5px;outline:none;color:#111827;background:#fafafa;"
                onfocus="this.style.borderColor='#16A34A'" onblur="this.style.borderColor='#e5e7eb'">
            <button onclick="envoyerMessage()" id="send-btn" style="background:#16A34A;border:none;border-radius:10px;width:36px;height:36px;cursor:pointer;color:white;font-size:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">➤</button>
        </div>
    </div>
</div>
<script>
let historiqueChat=[];let chatVisible=false;
function toggleChat(){const w=document.getElementById('chat-window');chatVisible=!chatVisible;if(chatVisible){w.classList.remove('chat-hidden');w.classList.add('chat-visible');setTimeout(()=>document.getElementById('chat-input').focus(),100);}else{w.classList.remove('chat-visible');w.classList.add('chat-hidden');}}
function envoyerSuggestion(t){document.getElementById('suggestions').style.display='none';document.getElementById('chat-input').value=t;envoyerMessage();}
async function envoyerMessage(){const input=document.getElementById('chat-input');const btn=document.getElementById('send-btn');const msg=input.value.trim();if(!msg)return;ajouterMessage(msg,'user');input.value='';btn.disabled=true;btn.style.opacity='.5';const typingId=afficherTyping();historiqueChat.push({role:'user',content:msg});try{const res=await fetch('/chatbot',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({message:msg,historique:historiqueChat.slice(-6)})});const data=await res.json();supprimerTyping(typingId);const reponse=data.reponse??"Désolé, une erreur est survenue.";ajouterMessage(reponse,'bot');historiqueChat.push({role:'assistant',content:reponse});}catch(e){supprimerTyping(typingId);ajouterMessage("Erreur de connexion.","bot");}btn.disabled=false;btn.style.opacity='1';input.focus();}
function ajouterMessage(texte,role){const zone=document.getElementById('chat-messages');const div=document.createElement('div');if(role==='user'){div.style.cssText='display:flex;justify-content:flex-end;';div.innerHTML=`<div style="background:#16A34A;color:white;border-radius:14px;border-top-right-radius:4px;padding:9px 12px;font-size:12.5px;max-width:210px;line-height:1.5;">${texte}</div>`;}else{div.style.cssText='display:flex;gap:7px;align-items:flex-start;';div.innerHTML=`<div style="width:28px;height:28px;background:#16A34A;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="15" height="15" viewBox="0 0 36 36" fill="none"><rect x="5" y="7" width="26" height="16" rx="5" fill="white"/><rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/><circle cx="12" cy="14.2" r="1.8" fill="white"/><rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#16A34A"/><circle cx="24" cy="14.2" r="1.8" fill="white"/></svg></div><div style="background:white;border-radius:14px;border-top-left-radius:4px;padding:9px 12px;font-size:12.5px;color:#374151;max-width:210px;line-height:1.5;box-shadow:0 1px 4px rgba(0,0,0,.07);">${texte}</div>`;}zone.appendChild(div);zone.scrollTop=zone.scrollHeight;}
function afficherTyping(){const zone=document.getElementById('chat-messages');const id='typing-'+Date.now();const div=document.createElement('div');div.id=id;div.style.cssText='display:flex;gap:7px;align-items:flex-start;';div.innerHTML=`<div style="width:28px;height:28px;background:#16A34A;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="15" height="15" viewBox="0 0 36 36" fill="none"><rect x="5" y="7" width="26" height="16" rx="5" fill="white"/></svg></div><div style="background:white;border-radius:14px;border-top-left-radius:4px;padding:10px 14px;box-shadow:0 1px 4px rgba(0,0,0,.07);display:flex;gap:4px;align-items:center;"><span class="dot-typing"></span><span class="dot-typing"></span><span class="dot-typing"></span></div>`;zone.appendChild(div);zone.scrollTop=zone.scrollHeight;return id;}
function supprimerTyping(id){const el=document.getElementById(id);if(el)el.remove();}
</script>
@endif
@endauth

{{-- Sidebar JS --}}
<script>
let sidebarOpen = true;

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main    = document.getElementById('main-content');
    const overlay = document.getElementById('sidebar-overlay');

    if (window.innerWidth <= 768) {
        // Mobile : slide in/out
        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('active');
    } else {
        // Desktop : collapse/expand
        sidebarOpen = !sidebarOpen;
        if (sidebarOpen) {
            sidebar.classList.remove('sidebar-hidden');
            main.classList.remove('full-width');
        } else {
            sidebar.classList.add('sidebar-hidden');
            main.classList.add('full-width');
        }
    }
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sidebar-overlay').classList.remove('active');
}

// Fermer sidebar mobile si resize vers desktop
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        closeSidebar();
        if (sidebarOpen) {
            document.getElementById('sidebar').classList.remove('sidebar-hidden');
            document.getElementById('main-content').classList.remove('full-width');
        }
    }
});
</script>

@stack('scripts')
</body>
</html>