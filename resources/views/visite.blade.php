@extends('layouts.app')

@section('title', 'GazApp — Livraison de gaz à domicile')

@section('content')
<div class="min-h-screen" style="background:#f0fdf4; font-family:'Inter',sans-serif;">

    {{-- ════════════════════════════════════════
         NAVBAR
    ════════════════════════════════════════ --}}
    <nav style="background:#fff; border-bottom:1px solid #dcfce7; position:sticky; top:0; z-index:50;">
        <div style="max-width:1100px; margin:0 auto; padding:0 24px; height:64px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:#16A34A; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2C8 2 5 6 5 10c0 5.25 7 12 7 12s7-6.75 7-12c0-4-3-8-7-8z"/>
                        <circle cx="12" cy="10" r="2.5"/>
                    </svg>
                </div>
                <span style="font-size:18px; font-weight:700; color:#15803D; letter-spacing:-.3px;">GazApp</span>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <a href="#fonctionnalites" style="font-size:14px; font-weight:500; color:#4b5563; text-decoration:none; padding:8px 14px; border-radius:8px; transition:background .15s;" 
                   onmouseover="this.style.background='#f0fdf4';this.style.color='#16A34A'" onmouseout="this.style.background='transparent';this.style.color='#4b5563'">
                    Fonctionnalités
                </a>
                <a href="#comment-ca-marche" style="font-size:14px; font-weight:500; color:#4b5563; text-decoration:none; padding:8px 14px; border-radius:8px; transition:background .15s;"
                   onmouseover="this.style.background='#f0fdf4';this.style.color='#16A34A'" onmouseout="this.style.background='transparent';this.style.color='#4b5563'">
                    Comment ça marche
                </a>
            </div>
        </div>
    </nav>

    {{-- ════════════════════════════════════════
         HERO
    ════════════════════════════════════════ --}}
    <section style="max-width:1100px; margin:0 auto; padding:96px 24px 80px; display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center;">
        <div>
            <span style="display:inline-flex; align-items:center; gap:6px; background:#dcfce7; color:#15803D; font-size:12px; font-weight:700; padding:5px 12px; border-radius:20px; letter-spacing:.04em; text-transform:uppercase; margin-bottom:20px;">
                <span style="width:6px;height:6px;background:#16A34A;border-radius:50%;display:inline-block;"></span>
                Disponible au Cameroun
            </span>
            <h1 style="font-size:clamp(36px,5vw,56px); font-weight:800; color:#111827; line-height:1.1; letter-spacing:-1.5px; margin:0 0 20px;">
                Le gaz à domicile,<br>
                <span style="color:#16A34A;">en quelques clics</span>
            </h1>
            <p style="font-size:17px; color:#6b7280; line-height:1.7; margin:0 0 36px; max-width:480px;">
                GazApp connecte les particuliers aux vendeurs de gaz les plus proches, pour une livraison rapide, sécurisée et sans contrainte.
            </p>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="{{ route('commandes.create') }}"
                   style="display:inline-flex; align-items:center; gap:8px; background:#16A34A; color:#fff; font-size:15px; font-weight:600; padding:14px 28px; border-radius:12px; text-decoration:none; box-shadow:0 4px 14px rgba(22,163,74,.3); transition:all .2s;"
                   onmouseover="this.style.background='#15803D';this.style.transform='translateY(-1px)'" 
                   onmouseout="this.style.background='#16A34A';this.style.transform='translateY(0)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    Commander maintenant
                </a>
                <a href="#comment-ca-marche"
                   style="display:inline-flex; align-items:center; gap:8px; background:#fff; color:#374151; font-size:15px; font-weight:600; padding:14px 24px; border-radius:12px; text-decoration:none; border:1.5px solid #e5e7eb; transition:all .2s;"
                   onmouseover="this.style.borderColor='#16A34A';this.style.color='#16A34A'" 
                   onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151'">
                    Voir comment ça marche
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Stats --}}
            <div style="display:flex; gap:32px; margin-top:48px; padding-top:32px; border-top:1px solid #e5e7eb;">
                <div>
                    <p style="font-size:28px; font-weight:800; color:#111827; margin:0; letter-spacing:-1px;">2 000+</p>
                    <p style="font-size:13px; color:#9ca3af; margin:4px 0 0; font-weight:500;">Clients satisfaits</p>
                </div>
                <div style="width:1px; background:#e5e7eb;"></div>
                <div>
                    <p style="font-size:28px; font-weight:800; color:#111827; margin:0; letter-spacing:-1px;">&lt; 1h</p>
                    <p style="font-size:13px; color:#9ca3af; margin:4px 0 0; font-weight:500;">Délai moyen</p>
                </div>
                <div style="width:1px; background:#e5e7eb;"></div>
                <div>
                    <p style="font-size:28px; font-weight:800; color:#111827; margin:0; letter-spacing:-1px;">100%</p>
                    <p style="font-size:13px; color:#9ca3af; margin:4px 0 0; font-weight:500;">Sécurisé</p>
                </div>
            </div>
        </div>

        {{-- Illustration carte --}}
        <div style="position:relative; display:flex; justify-content:center;">
            <div style="width:320px; background:#fff; border-radius:24px; border:1px solid #dcfce7; padding:28px; box-shadow:0 20px 60px rgba(22,163,74,.1);">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                    <div style="width:44px; height:44px; background:#f0fdf4; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    </div>
                    <div>
                        <p style="font-size:14px; font-weight:700; color:#111827; margin:0;">Livraison en cours</p>
                        <p style="font-size:12px; color:#9ca3af; margin:3px 0 0;">Commande #LIV-2847</p>
                    </div>
                    <span style="margin-left:auto; display:inline-flex; align-items:center; gap:5px; background:#dcfce7; color:#15803D; font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px;">
                        <span style="width:5px;height:5px;background:#16A34A;border-radius:50%;animation:pulse 1.5s infinite;"></span>
                        En route
                    </span>
                </div>

                {{-- Barre de progression --}}
                <div style="margin-bottom:20px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                        <span style="font-size:12px; color:#6b7280; font-weight:500;">Progression</span>
                        <span style="font-size:12px; color:#16A34A; font-weight:700;">68%</span>
                    </div>
                    <div style="height:6px; background:#f3f4f6; border-radius:99px; overflow:hidden;">
                        <div style="height:100%; width:68%; background:linear-gradient(90deg,#16A34A,#22C55E); border-radius:99px;"></div>
                    </div>
                </div>

                {{-- Détails --}}
                <div style="space-y:0;">
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-top:1px solid #f3f4f6;">
                        <span style="font-size:13px; color:#9ca3af;">Produit</span>
                        <span style="font-size:13px; font-weight:600; color:#111827;">Bouteille 12 kg</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-top:1px solid #f3f4f6;">
                        <span style="font-size:13px; color:#9ca3af;">Arrivée estimée</span>
                        <span style="font-size:13px; font-weight:600; color:#16A34A;">~25 min</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-top:1px solid #f3f4f6;">
                        <span style="font-size:13px; color:#9ca3af;">Montant</span>
                        <span style="font-size:13px; font-weight:700; color:#111827;">8 500 FCFA</span>
                    </div>
                </div>
            </div>

            {{-- Badge flottant --}}
            <div style="position:absolute; bottom:-16px; right:0; background:#fff; border:1px solid #dcfce7; border-radius:14px; padding:10px 16px; display:flex; align-items:center; gap:8px; box-shadow:0 8px 24px rgba(0,0,0,.08);">
                <div style="width:32px;height:32px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p style="font-size:12px; font-weight:700; color:#111827; margin:0;">Paiement sécurisé</p>
                    <p style="font-size:11px; color:#9ca3af; margin:2px 0 0;">Mobile Money · Carte</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         FONCTIONNALITÉS
    ════════════════════════════════════════ --}}
    <section id="fonctionnalites" style="background:#fff; padding:96px 24px;">
        <div style="max-width:1100px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:56px;">
                <span style="display:inline-block; background:#dcfce7; color:#15803D; font-size:12px; font-weight:700; padding:5px 14px; border-radius:20px; letter-spacing:.06em; text-transform:uppercase; margin-bottom:16px;">Fonctionnalités</span>
                <h2 style="font-size:clamp(28px,4vw,40px); font-weight:800; color:#111827; margin:0 0 16px; letter-spacing:-1px;">
                    Tout ce dont vous avez besoin
                </h2>
                <p style="font-size:16px; color:#6b7280; max-width:520px; margin:0 auto; line-height:1.6;">
                    Une expérience pensée pour être simple, rapide et rassurante de bout en bout.
                </p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:24px;">

                @php
                $features = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>', 'color' => '#dcfce7', 'icon_color' => '#16A34A', 'title' => 'Commande rapide', 'desc' => 'Commandez votre gaz en quelques clics. Géolocalisation automatique pour trouver le vendeur le plus proche.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3m-3 3.75h3"/>', 'color' => '#dbeafe', 'icon_color' => '#2563eb', 'title' => 'Paiement sécurisé', 'desc' => 'Mobile Money, carte bancaire ou paiement à la livraison. Toutes les options disponibles.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>', 'color' => '#fef9c3', 'icon_color' => '#ca8a04', 'title' => 'Livraison à domicile', 'desc' => 'Le vendeur le plus proche prend en charge votre commande. Suivi en temps réel jusqu\'à votre porte.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>', 'color' => '#fee2e2', 'icon_color' => '#dc2626', 'title' => 'Urgences gaz', 'desc' => 'En cas de fuite ou d\'incident, signalez l\'urgence directement depuis l\'app. Services de sécurité alertés.'],
                ];
                @endphp

                @foreach($features as $f)
                    <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:20px; padding:28px; transition:all .2s;"
                         onmouseover="this.style.background='#fff';this.style.borderColor='#dcfce7';this.style.boxShadow='0 8px 32px rgba(22,163,74,.08)'"
                         onmouseout="this.style.background='#fafafa';this.style.borderColor='#f3f4f6';this.style.boxShadow='none'">
                        <div style="width:48px; height:48px; background:{{ $f['color'] }}; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ $f['icon_color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $f['icon'] !!}
                            </svg>
                        </div>
                        <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0 0 10px;">{{ $f['title'] }}</h3>
                        <p style="font-size:14px; color:#6b7280; line-height:1.65; margin:0;">{{ $f['desc'] }}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         COMMENT ÇA MARCHE
    ════════════════════════════════════════ --}}
    <section id="comment-ca-marche" style="padding:96px 24px; background:#f0fdf4;">
        <div style="max-width:800px; margin:0 auto;">
            <div style="text-align:center; margin-bottom:56px;">
                <span style="display:inline-block; background:#dcfce7; color:#15803D; font-size:12px; font-weight:700; padding:5px 14px; border-radius:20px; letter-spacing:.06em; text-transform:uppercase; margin-bottom:16px;">Simple & rapide</span>
                <h2 style="font-size:clamp(28px,4vw,40px); font-weight:800; color:#111827; margin:0; letter-spacing:-1px;">Comment ça marche ?</h2>
            </div>

            @php
            $steps = [
                ['num' => '1', 'title' => 'Créez votre commande', 'desc' => 'Choisissez le type de bouteille, renseignez votre adresse et validez votre commande en moins de 2 minutes.'],
                ['num' => '2', 'title' => 'Un vendeur accepte', 'desc' => 'Le vendeur le plus proche reçoit votre demande et confirme la prise en charge de la livraison.'],
                ['num' => '3', 'title' => 'Suivez en temps réel', 'desc' => 'Recevez des mises à jour sur l\'avancement de votre livraison jusqu\'à la réception à domicile.'],
                ['num' => '4', 'title' => 'Payez & profitez', 'desc' => 'Réglez en ligne ou à la livraison. Évaluez ensuite votre expérience pour aider la communauté.'],
            ];
            @endphp

            <div style="display:flex; flex-direction:column; gap:0;">
                @foreach($steps as $i => $step)
                    <div style="display:flex; gap:20px; align-items:flex-start; {{ $i < count($steps)-1 ? 'padding-bottom:32px;' : '' }}">
                        {{-- Ligne verticale --}}
                        <div style="display:flex; flex-direction:column; align-items:center; flex-shrink:0;">
                            <div style="width:44px; height:44px; border-radius:50%; background:#16A34A; color:#fff; font-size:16px; font-weight:800; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(22,163,74,.3);">
                                {{ $step['num'] }}
                            </div>
                            @if($i < count($steps)-1)
                                <div style="width:2px; flex:1; min-height:32px; background:repeating-linear-gradient(to bottom, #dcfce7 0, #dcfce7 6px, transparent 6px, transparent 12px); margin-top:8px;"></div>
                            @endif
                        </div>
                        {{-- Contenu --}}
                        <div style="padding-top:10px;">
                            <h3 style="font-size:17px; font-weight:700; color:#111827; margin:0 0 8px;">{{ $step['title'] }}</h3>
                            <p style="font-size:14px; color:#6b7280; line-height:1.65; margin:0;">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         À PROPOS
    ════════════════════════════════════════ --}}
    <section style="background:#fff; padding:96px 24px;">
        <div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center;">
            <div>
                <span style="display:inline-block; background:#dcfce7; color:#15803D; font-size:12px; font-weight:700; padding:5px 14px; border-radius:20px; letter-spacing:.06em; text-transform:uppercase; margin-bottom:20px;">Notre mission</span>
                <h2 style="font-size:clamp(26px,3.5vw,38px); font-weight:800; color:#111827; margin:0 0 20px; letter-spacing:-1px; line-height:1.15;">
                    Simplifier l'accès au gaz pour tous
                </h2>
                <p style="font-size:15px; color:#6b7280; line-height:1.75; margin:0 0 16px;">
                    GazApp est née d'un constat simple : l'approvisionnement en gaz domestique est encore trop souvent synonyme de déplacements, d'attentes et d'incertitudes.
                </p>
                <p style="font-size:15px; color:#6b7280; line-height:1.75; margin:0 0 32px;">
                    Notre plateforme met en relation directe les particuliers avec des vendeurs locaux certifiés, pour une livraison fiable, traçable et sécurisée — directement depuis votre smartphone.
                </p>
                <div style="display:flex; flex-direction:column; gap:14px;">
                    @php $values = [
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Vendeurs locaux vérifiés et certifiés'],
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Suivi de livraison en temps réel'],
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Service client disponible 7j/7'],
                    ]; @endphp
                    @foreach($values as $v)
                        <div style="display:flex; align-items:center; gap:10px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                                <path d="{{ $v['icon'] }}"/>
                            </svg>
                            <span style="font-size:14px; font-weight:500; color:#374151;">{{ $v['text'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Carte valeurs --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                @php $cards = [
                    ['emoji_icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12c0 .778.099 1.533.284 2.253', 'label' => 'Local', 'sub' => 'Vendeurs de proximité', 'bg' => '#f0fdf4', 'color' => '#15803D'],
                    ['emoji_icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'label' => 'Sécurisé', 'sub' => 'Transactions protégées', 'bg' => '#eff6ff', 'color' => '#1d4ed8'],
                    ['emoji_icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Rapide', 'sub' => 'Livraison en moins d\'1h', 'bg' => '#fef9c3', 'color' => '#854d0e'],
                    ['emoji_icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'label' => 'Communauté', 'sub' => 'Des milliers d\'utilisateurs', 'bg' => '#fdf4ff', 'color' => '#7e22ce'],
                ]; @endphp
                @foreach($cards as $c)
                    <div style="background:{{ $c['bg'] }}; border-radius:18px; padding:24px 20px;">
                        <div style="width:40px; height:40px; border-radius:10px; background:#fff; display:flex; align-items:center; justify-content:center; margin-bottom:14px; box-shadow:0 2px 8px rgba(0,0,0,.06);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $c['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="{{ $c['emoji_icon'] }}"/>
                            </svg>
                        </div>
                        <p style="font-size:15px; font-weight:700; color:#111827; margin:0 0 4px;">{{ $c['label'] }}</p>
                        <p style="font-size:12px; color:#9ca3af; margin:0; line-height:1.5;">{{ $c['sub'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         CTA FINAL
    ════════════════════════════════════════ --}}
    <section style="padding:96px 24px;">
        <div style="max-width:680px; margin:0 auto; text-align:center;">
            <div style="background:#fff; border-radius:28px; border:1px solid #dcfce7; padding:56px 40px; box-shadow:0 20px 60px rgba(22,163,74,.08);">
                <div style="width:64px; height:64px; background:#f0fdf4; border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 002 1.58h9.78a2 2 0 001.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                </div>
                <h2 style="font-size:clamp(26px,4vw,36px); font-weight:800; color:#111827; margin:0 0 14px; letter-spacing:-1px; line-height:1.2;">
                    Prêt à commander<br>votre gaz ?
                </h2>
                <p style="font-size:15px; color:#6b7280; line-height:1.7; margin:0 0 36px;">
                    Rejoignez des milliers de foyers qui font confiance à GazApp pour leurs besoins en gaz domestique.
                </p>
                <a href="{{ route('commandes.create') }}"
                   style="display:inline-flex; align-items:center; gap:10px; background:#16A34A; color:#fff; font-size:16px; font-weight:700; padding:16px 36px; border-radius:14px; text-decoration:none; box-shadow:0 6px 20px rgba(22,163,74,.35); transition:all .2s;"
                   onmouseover="this.style.background='#15803D';this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.background='#16A34A';this.style.transform='translateY(0)'">
                    Commander maintenant
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer style="border-top:1px solid #dcfce7; padding:32px 24px; background:#fff;">
        <div style="max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:26px; height:26px; background:#16A34A; border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8 2 5 6 5 10c0 5.25 7 12 7 12s7-6.75 7-12c0-4-3-8-7-8z"/><circle cx="12" cy="10" r="2.5"/></svg>
                </div>
                <span style="font-size:14px; font-weight:700; color:#15803D;">GazApp</span>
            </div>
            <p style="font-size:13px; color:#9ca3af; margin:0;">
                © {{ date('Y') }} GazApp — Tous droits réservés
            </p>
        </div>
    </footer>

</div>

<style>
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
    @media(max-width:768px){
        section { padding-left:16px !important; padding-right:16px !important; }
        section > div { grid-template-columns:1fr !important; gap:40px !important; }
        nav > div > div:last-child { display:none; }
    }
</style>

@endsection