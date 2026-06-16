{{-- =========================================================
     GazApp — welcome.blade.php
     Thème : Blanc / Vert — Inter, AOS scroll reveals
     ========================================================= --}}
@extends('layouts.app')

@section('title', 'Accueil - GazApp')

@section('content')

{{-- ── CDN : Inter + AOS ── --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
  /* ── Variables de couleur Blanc/Vert ── */
  :root {
    --color-primary:   #16A34A;
    --color-secondary: #15803D;
    --color-accent:    #22C55E;
    --color-surface:   #F0FDF4;
    --g50:  #F0FDF4;
    --g100: #DCFCE7;
    --g200: #BBF7D0;
    --g400: #4ADE80;
    --g500: #22C55E;
    --g600: #16A34A;
    --g700: #15803D;
    --g800: #166534;
    --g900: #14532D;
    --border-green: rgba(22,163,74,.18);
  }

  body { font-family: 'Inter', sans-serif; }

  /* Dégradé hero animé */
  .hero-gradient {
    background: linear-gradient(135deg, #166534 0%, #15803D 40%, #16A34A 100%);
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
  }
  @keyframes gradientShift {
    0%   { background-position: 0%   50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0%   50%; }
  }

  /* Image hero — statique, pas d'animation */
  .hero-img-wrap {
    /* aucune animation */
  }

  /* Bouton primaire */
  .btn-primary {
    background: linear-gradient(135deg, #16A34A, #15803D);
    color: #fff;
    box-shadow: 0 8px 20px rgba(22,163,74,.30);
    transition: transform .2s, box-shadow .2s;
  }
  .btn-primary:hover { transform: scale(1.05); box-shadow: 0 12px 28px rgba(22,163,74,.40); }

  /* Bouton secondaire (outline blanc) */
  .btn-outline {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,.7);
    transition: background .2s, transform .2s;
  }
  .btn-outline:hover { background: rgba(255,255,255,.15); transform: scale(1.05); }

  /* Carte feature */
  .feature-card {
    transition: transform .25s, box-shadow .25s, border-color .25s;
  }
  .feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(22,163,74,.12);
    border-color: var(--g200) !important;
  }

  /* Compteur chiffres */
  .stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    background: linear-gradient(135deg, #16A34A, #15803D);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* Carte témoignage */
  .testimonial-card {
    transition: transform .25s, box-shadow .25s;
  }
  .testimonial-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(22,163,74,.10);
  }

  /* Connecteur étape (desktop) */
  .step-connector { display: none; }
  @media(min-width:768px) { .step-connector { display: block; } }

  /* Navbar override — liens actifs */
  nav a.nav-link {
    position: relative;
    transition: color .2s;
  }
  nav a.nav-link::after {
    content: '';
    position: absolute;
    left: 0; bottom: -2px;
    width: 0; height: 2px;
    background: var(--color-accent);
    transition: width .25s;
  }
  nav a.nav-link:hover::after,
  nav a.nav-link.active::after { width: 100%; }
</style>

{{-- ══════════════════════════════════════════════════════════
     NAVBAR PRINCIPALE
     ══════════════════════════════════════════════════════════ --}}
<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm border-b border-green-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      {{-- Logo --}}
      <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#16A34A;">
          <svg class="w-5 h-5" viewBox="0 0 24 28" fill="none">
            <path d="M12 26C6 24 4 18 5.5 13.5C6.5 10 8 8.5 7.5 5
                     C9 7.5 9.2 10 8.5 12.5C10.5 10 11 7 10 3
                     C13.5 6.5 14.5 11 12.5 14.5C14.5 12 15.5 9 15 6
                     C17.5 9 17 14.5 15 18C16.5 16 17 13 16.5 10.5
                     C18 13.5 17.5 18 16 21C14.5 24 13.2 25.5 12 26Z"
                  fill="#fff"/>
          </svg>
        </div>
        <span class="font-extrabold text-xl tracking-tight" style="color:#166534;">GazApp</span>
      </a>

      {{-- Liens desktop --}}
      <div class="hidden md:flex items-center gap-7 text-sm font-medium text-gray-600">
        <a href="{{ route('home') }}"   class="nav-link hover:text-green-800">Accueil</a>
        <a href="{{ route('visite') }}" class="nav-link hover:text-green-800">À propos</a>
        @auth
          <a href="{{ route('commandes.create') }}" class="nav-link hover:text-green-800">Commander</a>
          <a href="{{ route('dashboard') }}"        class="nav-link hover:text-green-800">Mon espace</a>
        @else
          <a href="{{ route('inscription.form') }}" class="nav-link hover:text-green-800">S'inscrire</a>
        @endauth
      </div>

      {{-- CTA desktop --}}
      <div class="hidden md:flex items-center gap-3">
        @auth
          <a href="{{ route('commandes.create') }}"
             class="btn-primary px-5 py-2 rounded-xl text-sm font-semibold">
            Nouvelle commande
          </a>
        @else
          <a href="{{ route('connexion') }}"
             class="text-sm font-semibold text-gray-600 hover:text-green-800 transition-colors">
            Se connecter
          </a>
          <a href="{{ route('inscription.form') }}"
             class="btn-primary px-5 py-2 rounded-xl text-sm font-semibold">
            Commencer gratuitement
          </a>
        @endauth
      </div>

      {{-- Burger mobile --}}
      <button id="nav-burger" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-green-50 transition-colors"
              aria-label="Menu" aria-expanded="false" aria-controls="nav-mobile-menu">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
        </svg>
      </button>
    </div>
  </div>

  {{-- Menu mobile --}}
  <div id="nav-mobile-menu" class="hidden md:hidden border-t border-green-100 bg-white px-4 pb-4 pt-2">
    <div class="flex flex-col gap-1 text-sm font-medium text-gray-600">
      <a href="{{ route('home') }}"   class="py-2 px-3 rounded-lg hover:bg-green-50 hover:text-green-800">Accueil</a>
      <a href="{{ route('visite') }}" class="py-2 px-3 rounded-lg hover:bg-green-50 hover:text-green-800">À propos</a>
      @auth
        <a href="{{ route('commandes.create') }}" class="py-2 px-3 rounded-lg hover:bg-green-50">Commander</a>
        <a href="{{ route('dashboard') }}"        class="py-2 px-3 rounded-lg hover:bg-green-50">Mon espace</a>
      @else
        <a href="{{ route('inscription.form') }}" class="py-2 px-3 rounded-lg hover:bg-green-50">S'inscrire</a>
        <a href="{{ route('connexion') }}"        class="py-2 px-3 rounded-lg hover:bg-green-50">Se connecter</a>
      @endauth
    </div>
  </div>
</nav>

{{-- ══════════════════════════════════════════════════════════
     HERO — Split-screen plein bord
     ══════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden" style="min-height: 580px; display: flex;">

  {{-- ── CÔTÉ GAUCHE : texte sur fond vert ── --}}
  <div class="hero-gradient relative z-10 flex items-center"
       style="flex: 0 0 52%; padding: 72px 5% 72px 6%;">

    {{-- Motifs décoratifs discrets --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
      <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full"
           style="background: rgba(255,255,255,.04);"></div>
      <div class="absolute bottom-0 right-0 w-48 h-48 rounded-full"
           style="background: rgba(255,255,255,.04);"></div>
    </div>

    <div data-aos="fade-right" data-aos-duration="650" class="relative">

      {{-- Badge label --}}
      <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase mb-5
                   bg-white/10 border border-white/20 text-green-200 px-4 py-2 rounded-full">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
        </svg>
        Yaoundé &amp; environs
      </span>

      {{-- Titre --}}
      <h1 class="font-extrabold text-white leading-tight tracking-tight mb-5"
          style="font-size: clamp(2rem, 3.5vw, 3.25rem); line-height: 1.1;">
        Votre gaz livré<br>
        <span style="color:#86efac;">en moins de 24h.</span>
      </h1>

      {{-- Sous-titre --}}
      <p class="text-green-100 leading-relaxed mb-8"
         style="font-size:1.05rem; max-width: 420px;">
        Commandez depuis chez vous. Nous trouvons le vendeur le plus proche
        et vous payez via Mobile Money ou carte bancaire.
      </p>

      {{-- CTAs --}}
      <div class="flex flex-wrap gap-3">
        @auth
          <a href="{{ route('commandes.create') }}"
             class="inline-block bg-white font-bold px-7 py-3.5 rounded-xl text-sm shadow-lg
                    hover:shadow-xl hover:scale-105 transition-all duration-200"
             style="color:#166534;">
            Nouvelle commande →
          </a>
        @else
          <a href="{{ route('inscription.form') }}"
             class="inline-block bg-white font-bold px-7 py-3.5 rounded-xl text-sm shadow-lg
                    hover:shadow-xl hover:scale-105 transition-all duration-200"
             style="color:#166534;">
            Commencer gratuitement →
          </a>
        @endauth
        <a href="{{ route('visite') }}"
           class="inline-block border border-white/50 text-white font-semibold px-7 py-3.5 rounded-xl text-sm
                  hover:bg-white/10 transition-all duration-200">
          Découvrir le service
        </a>
      </div>

      {{-- Proof bar --}}
      <div class="flex items-center gap-5 mt-8 pt-6" style="border-top: 1px solid rgba(255,255,255,.15);">
        <div class="flex items-center gap-1.5">
          <div class="flex gap-0.5">
            @for ($i = 0; $i < 5; $i++)
              <svg class="w-4 h-4" style="color:#FCD34D;" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
          </div>
          <span class="text-sm font-semibold text-white">98 % satisfaits</span>
        </div>
        <div style="width:1px; height:20px; background:rgba(255,255,255,.2);"></div>
        <div class="flex items-center gap-1.5">
          <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
          </svg>
          <span class="text-sm font-semibold text-white">+5 000 clients</span>
        </div>
      </div>

    </div>
  </div>

  {{-- ── CÔTÉ DROIT : image plein bord ── --}}
  <div class="relative" style="flex: 0 0 48%;" data-aos="fade-left" data-aos-duration="700" data-aos-delay="100">

    {{-- Image plein bord --}}
    <img
      src="{{ asset('images/gaz-flamme.png') }}"
      alt="Flamme de gaz — GazApp"
      loading="eager"
      onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYqhasDLoAuwHc2qFCU60N5LxCm9Bwtn9MTm77ng3f3Q&s=10'"
      style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;"
    >

    {{-- Overlay dégradé gauche pour fondu avec le texte --}}
    <div style="position:absolute; inset:0;
                background: linear-gradient(to right, #15803D 0%, transparent 30%);
                pointer-events:none;" aria-hidden="true"></div>

    {{-- Badge livraison express — bas gauche --}}
    <div style="position:absolute; bottom:28px; left:28px; z-index:10;"
         data-aos="fade-up" data-aos-delay="350" data-aos-duration="500">
      <div class="bg-white rounded-2xl shadow-2xl px-4 py-3 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:#16A34A;">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125
                     1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3
                     0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193
                     2.256 2.256 0 0 0-1.586-.948l-1.524-.32a48.5 48.5 0 0 0-5.545-.694A2.25
                     2.25 0 0 0 7.5 9.648v1.402a2.25 2.25 0 0 0 1.524 2.132l.167.063"/>
          </svg>
        </div>
        <div>
          <p class="text-xs font-extrabold text-gray-900 leading-tight">Livraison express</p>
          <p class="text-xs font-semibold" style="color:#16A34A;">En moins de 24h</p>
        </div>
      </div>
    </div>

  </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     FONCTIONNALITÉS
     ══════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14" data-aos="fade-up">
      <span class="text-sm font-semibold tracking-widest uppercase" style="color:#16A34A;">Pourquoi GazApp ?</span>
      <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
        Un service pensé pour votre quotidien
      </h2>
      <p class="mt-3 text-lg text-gray-500 max-w-xl mx-auto leading-relaxed">
        Plus de déplacements inutiles. Plus d'attente. Votre gaz arrive à votre porte.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      {{-- Carte 1 --}}
      <div class="feature-card rounded-2xl p-8 border border-green-100" style="background:#F0FDF4;"
           data-aos="fade-up" data-aos-delay="0">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6"
             style="background: linear-gradient(135deg,#16A34A,#15803D);">
          <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Livraison Express</h3>
        <p class="text-gray-500 leading-relaxed">
          Recevez votre gaz en moins de 24h grâce à la géolocalisation qui identifie
          instantanément le vendeur le plus proche de chez vous.
        </p>
      </div>

      {{-- Carte 2 --}}
      <div class="feature-card rounded-2xl p-8 border border-green-100" style="background:#F0FDF4;"
           data-aos="fade-up" data-aos-delay="100">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6"
             style="background: linear-gradient(135deg,#059669,#047857);">
          <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6
                     3.95 3.95 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623
                     5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751
                     h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Paiement 100 % Sécurisé</h3>
        <p class="text-gray-500 leading-relaxed">
          Mobile Money (MTN/Orange), carte bancaire ou espèces — choisissez la méthode
          qui vous convient. Chaque transaction est chiffrée et protégée.
        </p>
      </div>

      {{-- Carte 3 --}}
      <div class="feature-card rounded-2xl p-8 border border-green-100" style="background:#F0FDF4;"
           data-aos="fade-up" data-aos-delay="200">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6"
             style="background: linear-gradient(135deg,#166534,#14532D);">
          <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6
                     3.95 3.95 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622
                     5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.572-.598-3.75
                     h-.152c-3.196 0-6.1-1.248-8.25-3.285ZM12 15.75h.008v.008H12v-.008Z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Votre Sécurité d'Abord</h3>
        <p class="text-gray-500 leading-relaxed">
          Signalement direct aux forces de l'ordre en cas d'incident. Chaque livraison
          est tracée et validée avant clôture de commande.
        </p>
      </div>

    </div>
  </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CHIFFRES CLÉS
     ══════════════════════════════════════════════════════════ --}}
<section class="py-16" style="background: #F0FDF4; border-top: 1px solid #DCFCE7; border-bottom: 1px solid #DCFCE7;">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">

      <div data-aos="zoom-in" data-aos-delay="0">
        <p class="stat-number">+5 000</p>
        <p class="mt-2 text-sm font-semibold text-gray-500 uppercase tracking-widest">Clients satisfaits</p>
      </div>

      <div data-aos="zoom-in" data-aos-delay="100">
        <p class="stat-number">98 %</p>
        <p class="mt-2 text-sm font-semibold text-gray-500 uppercase tracking-widest">Taux de satisfaction</p>
      </div>

      <div data-aos="zoom-in" data-aos-delay="200">
        <p class="stat-number">&lt; 24h</p>
        <p class="mt-2 text-sm font-semibold text-gray-500 uppercase tracking-widest">Délai de livraison</p>
      </div>

    </div>

    <div class="mt-14 h-px bg-gradient-to-r from-transparent via-green-200 to-transparent"></div>
  </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     COMMENT ÇA MARCHE
     ══════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14" data-aos="fade-up">
      <span class="text-sm font-semibold tracking-widest uppercase" style="color:#16A34A;">Simple &amp; Rapide</span>
      <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
        Commander en 3 étapes
      </h2>
    </div>

    <div class="relative">
      <div class="step-connector absolute top-10 left-1/6 right-1/6 h-0.5 z-0"
           style="background: linear-gradient(to right, #BBF7D0, #4ADE80, #BBF7D0);"></div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative z-10">

        {{-- Étape 1 --}}
        <div class="text-center" data-aos="fade-up" data-aos-delay="0">
          <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg ring-4 ring-green-50"
               style="background: linear-gradient(135deg,#16A34A,#15803D);">
            <svg class="w-9 h-9 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0
                       2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08
                       m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0
                       0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5
                       2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08
                       C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125
                       1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504
                       1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Remplissez le formulaire</h3>
          <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">
            Indiquez votre localisation, le type de bouteille et la quantité souhaitée.
          </p>
        </div>

        {{-- Étape 2 --}}
        <div class="text-center" data-aos="fade-up" data-aos-delay="120">
          <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg ring-4 ring-green-50"
               style="background: linear-gradient(135deg,#059669,#047857);">
            <svg class="w-9 h-9 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75
                       3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0
                       19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25
                       2.25 0 0 0 4.5 19.5Z"/>
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Payez en sécurité</h3>
          <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">
            Choisissez Mobile Money, carte bancaire ou règlement à la livraison.
          </p>
        </div>

        {{-- Étape 3 --}}
        <div class="text-center" data-aos="fade-up" data-aos-delay="240">
          <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg ring-4 ring-green-50"
               style="background: linear-gradient(135deg,#166534,#14532D);">
            <svg class="w-9 h-9 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439
                       1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504
                       1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125
                       1.125-1.125h2.25c.621 0 1.125.504 1.125
                       1.125V21h4.125c.621 0 1.125-.504
                       1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Recevez chez vous</h3>
          <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">
            Le vendeur le plus proche prend en charge la livraison directement à votre porte.
          </p>
        </div>

      </div>
    </div>
  </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     TÉMOIGNAGES
     ══════════════════════════════════════════════════════════ --}}
<section class="py-20" style="background: #F0FDF4;">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-14" data-aos="fade-up">
      <span class="text-sm font-semibold tracking-widest uppercase" style="color:#16A34A;">Ils nous font confiance</span>
      <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
        Ce qu'en disent nos clients
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      {{-- Témoignage 1 --}}
      <div class="testimonial-card bg-white rounded-2xl p-8 border border-green-100 shadow-sm"
           data-aos="fade-up" data-aos-delay="0">
        <div class="flex gap-1 mb-4">
          @for ($i = 0; $i < 5; $i++)
            <svg class="w-5 h-5" style="color:#F59E0B;" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          @endfor
        </div>
        <p class="text-gray-600 leading-relaxed mb-6 italic">
          « Franchement, j'ai commandé à 10h, j'ai été livré avant 14h. Service impeccable
          et le gars était super professionnel. Je recommande vraiment ! »
        </p>
        <div class="flex items-center gap-3">
          <img src="https://ui-avatars.com/api/?name=Marie+T&background=16A34A&color=fff&size=48&rounded=true"
               alt="Marie T." class="w-12 h-12 rounded-full object-cover">
          <div>
            <p class="font-semibold text-gray-900 text-sm">Marie Tchoumba</p>
            <p class="text-gray-400 text-xs">Cliente à Yaoundé, Bastos</p>
          </div>
        </div>
      </div>

      {{-- Témoignage 2 --}}
      <div class="testimonial-card bg-white rounded-2xl p-8 border border-green-100 shadow-sm"
           data-aos="fade-up" data-aos-delay="100">
        <div class="flex gap-1 mb-4">
          @for ($i = 0; $i < 5; $i++)
            <svg class="w-5 h-5" style="color:#F59E0B;" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          @endfor
        </div>
        <p class="text-gray-600 leading-relaxed mb-6 italic">
          « Le paiement Mobile Money est super pratique. Plus besoin de sortir chercher
          de la monnaie. L'application est simple à utiliser même pour ma grand-mère ! »
        </p>
        <div class="flex items-center gap-3">
          <img src="https://ui-avatars.com/api/?name=Paul+N&background=059669&color=fff&size=48&rounded=true"
               alt="Paul N." class="w-12 h-12 rounded-full object-cover">
          <div>
            <p class="font-semibold text-gray-900 text-sm">Paul Nguele</p>
            <p class="text-gray-400 text-xs">Client à Yaoundé, Mvan</p>
          </div>
        </div>
      </div>

      {{-- Témoignage 3 --}}
      <div class="testimonial-card bg-white rounded-2xl p-8 border border-green-100 shadow-sm"
           data-aos="fade-up" data-aos-delay="200">
        <div class="flex gap-1 mb-4">
          @for ($i = 0; $i < 5; $i++)
            <svg class="w-5 h-5" style="color:#F59E0B;" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          @endfor
        </div>
        <p class="text-gray-600 leading-relaxed mb-6 italic">
          « J'avais peur au début de commander du gaz en ligne, mais GazApp m'a rassuré.
          Le vendeur est arrivé à l'heure et la bouteille était bien contrôlée. 5 étoiles ! »
        </p>
        <div class="flex items-center gap-3">
          <img src="https://ui-avatars.com/api/?name=Ines+B&background=166534&color=fff&size=48&rounded=true"
               alt="Inès B." class="w-12 h-12 rounded-full object-cover">
          <div>
            <p class="font-semibold text-gray-900 text-sm">Inès Bella</p>
            <p class="text-gray-400 text-xs">Cliente à Yaoundé, Omnisports</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CTA FINAL
     ══════════════════════════════════════════════════════════ --}}
<section class="py-20" style="background: linear-gradient(135deg,#15803D 0%,#16A34A 100%);">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-4">
      Prêt à commander votre gaz ?
    </h2>
    <p class="text-lg text-green-100 mb-10 leading-relaxed">
      Rejoignez plus de 5 000 ménages qui font confiance à GazApp chaque jour à Yaoundé.
    </p>
    @auth
      <a href="{{ route('commandes.create') }}"
         class="inline-block bg-white font-bold px-10 py-4 rounded-xl text-base shadow-xl hover:scale-105 transition-transform duration-200"
         style="color:#166534;">
        Créer une commande →
      </a>
    @else
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('inscription.form') }}"
           class="inline-block bg-white font-bold px-10 py-4 rounded-xl text-base shadow-xl hover:scale-105 transition-transform duration-200"
           style="color:#166534;">
          S'inscrire gratuitement →
        </a>
        <a href="{{ route('connexion') }}"
           class="inline-block border-2 border-white text-white font-semibold px-10 py-4 rounded-xl text-base hover:bg-white transition-all duration-200"
           style="hover:color:#166534;">
          Se connecter
        </a>
      </div>
    @endauth
  </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     FOOTER
     ══════════════════════════════════════════════════════════ --}}
<footer style="background:#0f1f0f; color:#9ca3af;">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

      {{-- Logo + description --}}
      <div class="md:col-span-1">
        <div class="flex items-center gap-2 mb-4">
          <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#16A34A;">
            <svg class="w-5 h-5" viewBox="0 0 24 28" fill="none">
              <path d="M12 26C6 24 4 18 5.5 13.5C6.5 10 8 8.5 7.5 5
                       C9 7.5 9.2 10 8.5 12.5C10.5 10 11 7 10 3
                       C13.5 6.5 14.5 11 12.5 14.5C14.5 12 15.5 9 15 6
                       C17.5 9 17 14.5 15 18C16.5 16 17 13 16.5 10.5
                       C18 13.5 17.5 18 16 21C14.5 24 13.2 25.5 12 26Z"
                    fill="#fff"/>
            </svg>
          </div>
          <span class="font-extrabold text-xl tracking-tight" style="color:#f0fdf4;">GazApp</span>
        </div>
        <p class="text-sm leading-relaxed">
          La plateforme de commande de gaz domestique la plus rapide et la plus fiable de Yaoundé.
        </p>
        <div class="flex gap-3 mt-5">
          {{-- Facebook --}}
          <a href="#" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
             style="background:#1a2e1a;"
             onmouseover="this.style.background='#166534'" onmouseout="this.style.background='#1a2e1a'"
             aria-label="Facebook">
            <svg class="w-4 h-4" style="fill:#9ca3af;" viewBox="0 0 24 24">
              <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
            </svg>
          </a>
          {{-- WhatsApp --}}
          <a href="#" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
             style="background:#1a2e1a;"
             onmouseover="this.style.background='#166534'" onmouseout="this.style.background='#1a2e1a'"
             aria-label="WhatsApp">
            <svg class="w-4 h-4" style="fill:#9ca3af;" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.985-1.407A9.947 9.947 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.946 7.946 0 0 1-4.075-1.117l-.29-.173-3.005.847.862-2.944-.19-.303A7.947 7.947 0 0 1 4 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8z"/>
            </svg>
          </a>
          {{-- Instagram --}}
          <a href="#" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
             style="background:#1a2e1a;"
             onmouseover="this.style.background='#166534'" onmouseout="this.style.background='#1a2e1a'"
             aria-label="Instagram">
            <svg class="w-4 h-4" style="fill:#9ca3af;" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
            </svg>
          </a>
        </div>
      </div>

      {{-- Navigation --}}
      <div>
        <h4 class="font-semibold text-sm uppercase tracking-widest mb-4" style="color:#d1fae5;">Navigation</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('home') }}"   class="hover:text-green-400 transition-colors">Accueil</a></li>
          <li><a href="{{ route('visite') }}" class="hover:text-green-400 transition-colors">À propos</a></li>
          @auth
            <li><a href="{{ route('commandes.create') }}" class="hover:text-green-400 transition-colors">Commander</a></li>
            <li><a href="{{ route('dashboard') }}"        class="hover:text-green-400 transition-colors">Mon espace</a></li>
          @else
            <li><a href="{{ route('inscription.form') }}" class="hover:text-green-400 transition-colors">S'inscrire</a></li>
            <li><a href="{{ route('connexion') }}"        class="hover:text-green-400 transition-colors">Se connecter</a></li>
          @endauth
        </ul>
      </div>

      {{-- Services --}}
      <div>
        <h4 class="font-semibold text-sm uppercase tracking-widest mb-4" style="color:#d1fae5;">Services</h4>
        <ul class="space-y-2 text-sm">
          <li><span class="cursor-default">Commande en ligne</span></li>
          <li><span class="cursor-default">Livraison express</span></li>
          <li><span class="cursor-default">Paiement Mobile Money</span></li>
          <li><span class="cursor-default">Suivi de commande</span></li>
          <li><span class="cursor-default">Signalement d'incident</span></li>
        </ul>
      </div>

      {{-- Contact --}}
      <div>
        <h4 class="font-semibold text-sm uppercase tracking-widest mb-4" style="color:#d1fae5;">Contact</h4>
        <ul class="space-y-3 text-sm">
          <li class="flex items-start gap-2">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color:#4ADE80;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
            </svg>
            Yaoundé, Cameroun
          </li>
          <li class="flex items-start gap-2">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color:#4ADE80;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
            </svg>
            +237 6XX XXX XXX
          </li>
          <li class="flex items-start gap-2">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color:#4ADE80;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
            </svg>
            contact@gazapp.cm
          </li>
        </ul>
      </div>

    </div>

    {{-- Copyright --}}
    <div class="mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs"
         style="border-top: 1px solid #1a2e1a; color:#4b5563;">
      <p>© {{ date('Y') }} GazApp. Tous droits réservés.</p>
      <div class="flex gap-6">
        <a href="#" class="hover:text-green-400 transition-colors">Confidentialité</a>
        <a href="#" class="hover:text-green-400 transition-colors">Conditions d'utilisation</a>
        <a href="#" class="hover:text-green-400 transition-colors">Mentions légales</a>
      </div>
    </div>

  </div>
</footer>

{{-- ── AOS Init ── --}}
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 650, easing: 'ease-out-cubic', once: true, offset: 80 });

  // Burger menu mobile
  const burger = document.getElementById('nav-burger');
  const mobileMenu = document.getElementById('nav-mobile-menu');
  if (burger && mobileMenu) {
    burger.addEventListener('click', () => {
      const isOpen = !mobileMenu.classList.contains('hidden');
      mobileMenu.classList.toggle('hidden', isOpen);
      burger.setAttribute('aria-expanded', String(!isOpen));
    });
  }
</script>

@endsection