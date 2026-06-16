@extends('layouts.app')

@section('title', 'Connexion - GazApp')

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
        max-width: 880px;
        min-height: 540px;
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
        font-size: 28px;
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

    /* ─── Panneau droit ─── */
    .gazapp-right {
        flex: 1;
        padding: 48px 44px;
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
        margin-bottom: 32px;
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
        margin-bottom: 16px;
    }

    .gazapp-field label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 6px;
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

    .gazapp-field-wrap input {
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
    }

    .gazapp-field-wrap input:focus {
        border-color: #1a7a4a;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(26,122,74,0.08);
    }

    .gazapp-field-wrap input::placeholder {
        color: #d1d5db;
    }

    .gazapp-field-wrap input.is-invalid {
        border-color: #ef4444;
        background: #fff5f5;
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
        margin-top: 5px;
    }

    /* ─── Ligne remember / forgot ─── */
    .gazapp-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .gazapp-remember {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        color: #6b7280;
        cursor: pointer;
    }

    .gazapp-remember input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: #1a7a4a;
        cursor: pointer;
    }

    .gazapp-forgot {
        font-size: 13px;
        color: #1a7a4a;
        font-weight: 600;
        text-decoration: none;
    }

    .gazapp-forgot:hover {
        text-decoration: underline;
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
        transition: background 0.15s, transform 0.1s;
    }

    .gazapp-btn-primary:hover {
        background: #155c38;
    }

    .gazapp-btn-primary:active {
        transform: scale(0.99);
    }

    /* ─── Séparateur ─── */
    .gazapp-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 18px 0;
    }

    .gazapp-divider span {
        font-size: 12px;
        color: #9ca3af;
        white-space: nowrap;
    }

    .gazapp-divider::before,
    .gazapp-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }

    /* ─── Bouton Google ─── */
    .gazapp-btn-google {
        width: 100%;
        height: 44px;
        background: #ffffff;
        color: #374151;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 500;
        transition: background 0.15s, border-color 0.15s;
    }

    .gazapp-btn-google:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .gazapp-btn-google svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    /* ─── Comptes de test ─── */
    .gazapp-test-box {
        margin-top: 20px;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 12px 14px;
        background: #f0fdf4;
    }

    .gazapp-test-box p {
        font-size: 12px;
        color: #166534;
        line-height: 1.8;
    }

    .gazapp-test-box strong {
        font-weight: 600;
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

    .gazapp-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
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
                <h1>Bienvenue sur<br>votre espace</h1>
                <p>Gérez vos commandes de gaz en toute simplicité, où que vous soyez.</p>
            </div>
        </div>

        {{-- Panneau droit : formulaire --}}
        <div class="gazapp-right">

            <h2>Connexion</h2>
            <p class="gazapp-sub">
                Pas encore de compte ?
                <a href="{{ route('inscription.form') }}">Créer un compte</a>
            </p>

            {{-- Alertes --}}
            @if (session('error'))
                <div class="gazapp-alert gazapp-alert-error">{{ session('error') }}</div>
            @endif

            @if (session('status'))
                <div class="gazapp-alert gazapp-alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('connexion.login') }}" method="POST">
                @csrf

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

                {{-- Remember me / Forgot --}}
                <div class="gazapp-row">
                    <label class="gazapp-remember">
                        <input id="remember-me" name="remember-me" type="checkbox">
                        Se souvenir de moi
                    </label>
                    <a href="{{ route('forgot') }}" class="gazapp-forgot">Mot de passe oublié ?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="gazapp-btn-primary" id="btn-login">
                    <span class="gaz-spinner" aria-hidden="true"></span>
                    <span class="gaz-btn-text">Se connecter</span>
                </button>
            </form>

            {{-- Séparateur --}}
            <div class="gazapp-divider"><span>ou</span></div>

            {{-- Connexion Google (optionnel) --}}
            <button type="button" class="gazapp-btn-google">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continuer avec Google
            </button>

            {{-- Comptes de test --}}
            <div class="gazapp-test-box">
                <p>
                    <strong>Comptes de test :</strong><br>
                    Admin : admin@gazapp.com / password<br>
                    Vendeur : vendeur1@gazapp.com / password<br>
                    Client : client@gazapp.com / password
                </p>
            </div>

        </div>
    </div>
</div>

{{-- Icônes Tabler (si pas déjà chargées dans le layout) --}}
@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

<script>
document.querySelector('form[action="{{ route('connexion.login') }}"]').addEventListener('submit', function() {
    var btn = document.getElementById('btn-login');
    btn.classList.add('is-loading');
    btn.disabled = true;
    btn.querySelector('.gaz-btn-text').textContent = 'Connexion en cours…';
});
</script>

@endsection