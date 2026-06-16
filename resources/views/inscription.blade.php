@extends('layouts.app')

@section('title', 'Inscription - GazApp')

@section('content')
<style>
    .gazapp-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6;
        padding: 2rem 1rem;
    }

    .gazapp-card {
        display: flex;
        width: 100%;
        max-width: 900px;
        min-height: 580px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(0,0,0,0.10);
        background: #ffffff;
    }

    /* ─── Panneau gauche ─── */
    .gazapp-left {
        flex: 1;
        background: #1a7a4a;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 40px;
        overflow: hidden;
    }

    .gazapp-blob {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }
    .gazapp-blob-1 { width: 280px; height: 280px; top: -80px; left: -90px; }
    .gazapp-blob-2 { width: 200px; height: 200px; bottom: 50px; right: -60px; background: rgba(255,255,255,0.12); }
    .gazapp-blob-3 { width: 130px; height: 130px; top: 130px; right: 30px; background: rgba(255,255,255,0.07); }

    .gazapp-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .gazapp-logo-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(255,255,255,0.20);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gazapp-logo-icon svg {
        width: 22px;
        height: 22px;
        stroke: white;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .gazapp-logo-name {
        font-size: 20px;
        font-weight: 600;
        color: white;
        letter-spacing: 0.5px;
    }

    .gazapp-tagline {
        position: relative;
        z-index: 1;
    }

    .gazapp-tagline h1 {
        font-size: 26px;
        font-weight: 700;
        color: white;
        line-height: 1.35;
        margin-bottom: 12px;
    }

    .gazapp-tagline p {
        font-size: 13px;
        color: rgba(255,255,255,0.65);
        line-height: 1.7;
        max-width: 230px;
    }

    /* ─── Avantages ─── */
    .gazapp-perks {
        position: relative;
        z-index: 1;
        margin-top: 28px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .gazapp-perk {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .gazapp-perk-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .gazapp-perk-icon svg {
        width: 14px;
        height: 14px;
        stroke: white;
        fill: none;
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .gazapp-perk span {
        font-size: 13px;
        color: rgba(255,255,255,0.80);
    }

    /* ─── Panneau droit ─── */
    .gazapp-right {
        flex: 1;
        padding: 44px 44px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .gazapp-right h2 {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .gazapp-right .gazapp-sub {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 28px;
    }

    .gazapp-right .gazapp-sub a {
        color: #1a7a4a;
        font-weight: 600;
        text-decoration: none;
    }

    .gazapp-right .gazapp-sub a:hover {
        text-decoration: underline;
    }

    /* ─── Champs ─── */
    .gazapp-field {
        margin-bottom: 14px;
    }

    .gazapp-field label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 5px;
    }

    .gazapp-field-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .gazapp-field-wrap .gaz-icon {
        position: absolute;
        left: 12px;
        color: #9ca3af;
        font-size: 16px;
        pointer-events: none;
    }

    .gazapp-field-wrap input,
    .gazapp-field-wrap select {
        width: 100%;
        height: 44px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 0 12px 0 40px;
        font-size: 14px;
        color: #111827;
        background: #f9fafb;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
        appearance: none;
        -webkit-appearance: none;
    }

    .gazapp-field-wrap input:focus,
    .gazapp-field-wrap select:focus {
        border-color: #1a7a4a;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(26,122,74,0.08);
    }

    .gazapp-field-wrap input::placeholder {
        color: #d1d5db;
    }

    .gazapp-field-wrap select {
        color: #6b7280;
        cursor: pointer;
    }

    .gazapp-field-wrap select:valid,
    .gazapp-field-wrap select option:not([value=""]) {
        color: #111827;
    }

    .gazapp-field-wrap input.is-invalid,
    .gazapp-field-wrap select.is-invalid {
        border-color: #ef4444;
        background: #fff5f5;
    }

    /* Flèche du select */
    .gazapp-select-wrap::after {
        content: '';
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #9ca3af;
        pointer-events: none;
    }

    .gazapp-show-btn {
        position: absolute;
        right: 12px;
        font-size: 12px;
        font-weight: 600;
        color: #1a7a4a;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
    }

    .gazapp-error {
        font-size: 12px;
        color: #ef4444;
        margin-top: 4px;
    }

    /* ─── Bouton principal ─── */
    .gazapp-btn-primary {
        width: 100%;
        height: 46px;
        background: #1a7a4a;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 0.2px;
        margin-top: 6px;
        transition: background 0.15s, transform 0.1s;
    }

    .gazapp-btn-primary:hover {
        background: #155c38;
    }

    .gazapp-btn-primary:active {
        transform: scale(0.99);
    }

    /* ─── Alertes session ─── */
    .gazapp-alert {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .gazapp-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    /* ─── Bouton loading ─── */
    .gazapp-btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .gazapp-btn-primary:disabled {
        background: #4aaa74;
        cursor: not-allowed;
        transform: none;
    }

    .gaz-spinner {
        display: none;
        width: 18px;
        height: 18px;
        border: 2.5px solid rgba(255,255,255,0.35);
        border-top-color: white;
        border-radius: 50%;
        animation: gaz-spin 0.7s linear infinite;
        flex-shrink: 0;
    }

    @keyframes gaz-spin {
        to { transform: rotate(360deg); }
    }

    .gazapp-btn-primary.is-loading .gaz-spinner {
        display: block;
    }

    .gazapp-btn-primary.is-loading .gaz-btn-text {
        opacity: 0.85;
    }

    /* ─── Responsive ─── */
    @media (max-width: 640px) {
        .gazapp-left { display: none; }
        .gazapp-right { padding: 36px 24px; }
        .gazapp-card { border-radius: 16px; }
    }
</style>

<div class="gazapp-wrap">
    <div class="gazapp-card">

        {{-- Panneau gauche --}}
        <div class="gazapp-left">
            <div class="gazapp-blob gazapp-blob-1"></div>
            <div class="gazapp-blob gazapp-blob-2"></div>
            <div class="gazapp-blob gazapp-blob-3"></div>

            <div class="gazapp-logo">
                <div class="gazapp-logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C8 2 5 5.5 5 9c0 3 2 5.5 4.5 7L12 22l2.5-6C17 14.5 19 12 19 9c0-3.5-3-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                </div>
                <span class="gazapp-logo-name">GazApp</span>
            </div>

            <div class="gazapp-tagline">
                <h1>Rejoignez<br>GazApp</h1>
                <p>Créez votre compte en quelques secondes et accédez à tous nos services.</p>

                <div class="gazapp-perks">
                    <div class="gazapp-perk">
                        <div class="gazapp-perk-icon">
                            <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span>Commandes de gaz rapides</span>
                    </div>
                    <div class="gazapp-perk">
                        <div class="gazapp-perk-icon">
                            <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span>Suivi en temps réel</span>
                    </div>
                    <div class="gazapp-perk">
                        <div class="gazapp-perk-icon">
                            <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span>Accès vendeurs & clients</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panneau droit : formulaire --}}
        <div class="gazapp-right">

            <h2>Créer un compte</h2>
            <p class="gazapp-sub">
                Déjà inscrit ?
                <a href="{{ route('connexion') }}">Se connecter</a>
            </p>

            {{-- Alertes --}}
            @if (session('error'))
                <div class="gazapp-alert gazapp-alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ route('inscription.store') }}" method="POST">
                @csrf

                {{-- Nom complet --}}
                <div class="gazapp-field">
                    <label for="name">Nom complet</label>
                    <div class="gazapp-field-wrap">
                        <i class="ti ti-user gaz-icon" aria-hidden="true"></i>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            placeholder="Jean Dupont"
                            value="{{ old('name') }}"
                            class="@error('name') is-invalid @enderror"
                        >
                    </div>
                    @error('name')
                        <p class="gazapp-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="gazapp-field">
                    <label for="email">Adresse email</label>
                    <div class="gazapp-field-wrap">
                        <i class="ti ti-mail gaz-icon" aria-hidden="true"></i>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            placeholder="vous@exemple.com"
                            value="{{ old('email') }}"
                            class="@error('email') is-invalid @enderror"
                        >
                    </div>
                    @error('email')
                        <p class="gazapp-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="gazapp-field">
                    <label for="password">Mot de passe</label>
                    <div class="gazapp-field-wrap">
                        <i class="ti ti-lock gaz-icon" aria-hidden="true"></i>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="••••••••"
                            class="@error('password') is-invalid @enderror"
                        >
                        <button
                            type="button"
                            class="gazapp-show-btn"
                            onclick="var i=document.getElementById('password');i.type=i.type==='password'?'text':'password';this.textContent=i.type==='password'?'Voir':'Masquer'"
                        >Voir</button>
                    </div>
                    @error('password')
                        <p class="gazapp-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Type de compte --}}
                <div class="gazapp-field">
                    <label for="role">Type de compte</label>
                    <div class="gazapp-field-wrap gazapp-select-wrap">
                        <i class="ti ti-briefcase gaz-icon" aria-hidden="true"></i>
                        <select
                            id="role"
                            name="role"
                            required
                            class="@error('role') is-invalid @enderror"
                        >
                            <option value="">Sélectionnez votre type de compte</option>
                            <option value="client"  {{ old('role') == 'client'  ? 'selected' : '' }}>Client</option>
                            <option value="vendeur" {{ old('role') == 'vendeur' ? 'selected' : '' }}>Vendeur</option>
                        </select>
                    </div>
                    @error('role')
                        <p class="gazapp-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="gazapp-btn-primary" id="btn-register">
                    <span class="gaz-spinner" aria-hidden="true"></span>
                    <span class="gaz-btn-text">Créer mon compte</span>
                </button>

            </form>

        </div>
    </div>
</div>

{{-- Icônes Tabler (si pas déjà chargées dans le layout) --}}
@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

<script>
document.querySelector('form[action="{{ route('inscription.store') }}"]').addEventListener('submit', function() {
    var btn = document.getElementById('btn-register');
    btn.classList.add('is-loading');
    btn.disabled = true;
    btn.querySelector('.gaz-btn-text').textContent = 'Création en cours…';
});
</script>

@endsection