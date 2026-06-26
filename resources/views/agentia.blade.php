@extends('layouts.sidebar')

@section('title', 'Agent IA — GazApp')
@section('page-title', 'Agent IA')
@section('page-subtitle', '')

@section('content')
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ══════════════════════════════════════
       VARIABLES & BASE
    ══════════════════════════════════════ */
    :root {
        --gz-green:      #16a34a;
        --gz-green-dark: #15803d;
        --gz-deep:       #052e16;
        --gz-light:      #f0fdf4;
        --gz-border:     #dcfce7;
        --gz-mint:       #bbf7d0;
        --gz-red:        #dc2626;
        --gz-red-light:  #fef2f2;
        --gz-red-border: #fca5a5;
        --gz-text:       #1f2937;
        --gz-muted:      #6b7280;
        --gz-radius:     20px;
        --gz-shadow:     0 2px 16px rgba(0,0,0,.07);
    }

    /* ══════════════════════════════════════
       LAYOUT PRINCIPAL
    ══════════════════════════════════════ */
    #gz-wrap {
        display: flex;
        gap: 16px;
        height: calc(100vh - 112px);
    }

    /* ── Panneau gauche (historique + infos) ── */
    #gz-sidebar {
        width: 260px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Carte modèle actif */
    .gz-model-card {
        background: #fff;
        border: 1px solid var(--gz-border);
        border-radius: 18px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .gz-model-card h3 {
        font-size: 11px;
        font-weight: 700;
        color: var(--gz-muted);
        text-transform: uppercase;
        letter-spacing: .6px;
    }
    .gz-model-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--gz-light);
        border: 1.5px solid var(--gz-border);
        border-radius: 12px;
        padding: 10px 12px;
    }
    .gz-model-badge .gz-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34,197,94,.2);
        flex-shrink: 0;
    }
    .gz-model-badge span {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--gz-text);
    }
    .gz-model-badge small {
        font-size: 10.5px;
        color: var(--gz-muted);
        margin-left: auto;
    }

    /* Carte capacités */
    .gz-caps-card {
        background: #fff;
        border: 1px solid var(--gz-border);
        border-radius: 18px;
        padding: 16px;
        flex: 1;
        overflow-y: auto;
    }
    .gz-caps-card h3 {
        font-size: 11px;
        font-weight: 700;
        color: var(--gz-muted);
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 12px;
    }
    .gz-cap-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 12px;
        margin-bottom: 6px;
        font-size: 12.5px;
        color: var(--gz-text);
        font-weight: 500;
        transition: background .15s;
    }
    .gz-cap-item:hover { background: var(--gz-light); }
    .gz-cap-icon {
        width: 30px; height: 30px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .gz-cap-icon.green  { background: #dcfce7; }
    .gz-cap-icon.blue   { background: #dbeafe; }
    .gz-cap-icon.orange { background: #ffedd5; }
    .gz-cap-icon.red    { background: #fee2e2; }
    .gz-cap-icon.purple { background: #ede9fe; }

    /* Bouton nouvelle conv dans sidebar */
    #gz-new-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        background: linear-gradient(135deg, var(--gz-green), var(--gz-green-dark));
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: transform .15s, box-shadow .15s;
        box-shadow: 0 4px 14px rgba(22,163,74,.3);
        font-family: inherit;
    }
    #gz-new-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(22,163,74,.4); }
    #gz-new-btn svg { width: 15px; height: 15px; }

    /* ── Zone de chat principale ── */
    #gz-chat {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        background: var(--gz-light);
        border-radius: 24px;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
        border: 1px solid var(--gz-border);
    }

    /* ══════════════════════════════════════
       HEADER
    ══════════════════════════════════════ */
    #gz-head {
        background: #fff;
        border-bottom: 1px solid var(--gz-border);
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }
    #gz-bot-av {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, var(--gz-green), var(--gz-deep));
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(22,163,74,.35);
        position: relative;
    }
    #gz-bot-av svg { width: 25px; height: 25px; }
    #gz-bot-av::after {
        content: '';
        position: absolute;
        bottom: -2px; right: -2px;
        width: 11px; height: 11px;
        background: #22c55e;
        border-radius: 50%;
        border: 2px solid #fff;
        animation: gz-pulse 2s infinite;
    }
    @keyframes gz-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,.4); }
        50%       { box-shadow: 0 0 0 5px rgba(34,197,94,0); }
    }
    #gz-head-txt { flex: 1; }
    #gz-head-txt h2 { font-size: 14.5px; font-weight: 700; color: #111827; }
    #gz-head-txt p  { font-size: 11.5px; color: var(--gz-muted); margin-top: 1px; }

    /* Indicateur "En train de réfléchir…" dans le header */
    #gz-thinking {
        display: none;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: var(--gz-green);
        font-weight: 600;
        background: #dcfce7;
        padding: 5px 12px;
        border-radius: 20px;
    }
    #gz-thinking.active { display: flex; }
    #gz-thinking svg { width: 13px; height: 13px; animation: spin .8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Compteur tokens (déco) */
    #gz-token-badge {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--gz-muted);
        background: var(--gz-light);
        border: 1px solid var(--gz-border);
        padding: 5px 11px;
        border-radius: 20px;
    }
    #gz-token-badge strong { color: var(--gz-green); }

    /* ══════════════════════════════════════
       MESSAGES
    ══════════════════════════════════════ */
    #gz-msgs {
        flex: 1;
        overflow-y: auto;
        padding: 24px 22px 16px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-height: 0;
        scroll-behavior: smooth;
    }
    #gz-msgs::-webkit-scrollbar { width: 4px; }
    #gz-msgs::-webkit-scrollbar-thumb { background: var(--gz-mint); border-radius: 4px; }

    /* Rows */
    .gz-row { display: flex; gap: 10px; align-items: flex-end; animation: fadeUp .22s ease; }
    .gz-row.me { flex-direction: row-reverse; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

    /* Avatars */
    .gz-av {
        width: 32px; height: 32px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 12px; font-weight: 700;
    }
    .gz-av.bot { background: linear-gradient(135deg, var(--gz-green), var(--gz-deep)); }
    .gz-av.bot svg { width: 17px; height: 17px; }
    .gz-av.usr { background: linear-gradient(135deg,#4ade80, var(--gz-green)); color:#fff; }

    /* Colonnes */
    .gz-col { display: flex; flex-direction: column; max-width: 68%; }
    .me .gz-col { align-items: flex-end; }

    /* Bulles */
    .gz-bub {
        padding: 13px 17px;
        border-radius: 20px;
        font-size: 13.5px;
        line-height: 1.7;
        word-break: break-word;
    }
    .gz-bub.bot {
        background: #fff;
        color: var(--gz-text);
        border-bottom-left-radius: 5px;
        box-shadow: var(--gz-shadow);
    }
    .gz-bub.usr {
        background: linear-gradient(135deg, var(--gz-green), var(--gz-green-dark));
        color: #fff;
        border-bottom-right-radius: 5px;
        box-shadow: 0 4px 14px rgba(22,163,74,.3);
    }

    /* Formatage markdown léger dans les bulles bot */
    .gz-bub.bot strong { color: var(--gz-green-dark); }
    .gz-bub.bot code {
        background: var(--gz-light);
        border: 1px solid var(--gz-border);
        border-radius: 6px;
        padding: 1px 6px;
        font-size: 12px;
        font-family: 'Courier New', monospace;
    }
    .gz-bub.bot ul { margin: 8px 0 4px 18px; }
    .gz-bub.bot li { margin-bottom: 4px; }

    /* Badge "outil utilisé" */
    .gz-tool-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10.5px;
        font-weight: 600;
        color: var(--gz-green-dark);
        background: #dcfce7;
        border: 1px solid var(--gz-mint);
        border-radius: 20px;
        padding: 3px 10px;
        margin-bottom: 6px;
    }
    .gz-tool-badge svg { width: 11px; height: 11px; }

    /* Timestamp & actions */
    .gz-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 5px;
        padding: 0 3px;
    }
    .me .gz-meta { justify-content: flex-end; }
    .gz-time { font-size: 10.5px; color: #9ca3af; }
    .gz-copy-btn {
        font-size: 10.5px;
        color: #9ca3af;
        background: none;
        border: none;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 6px;
        transition: background .15s, color .15s;
        display: none;
        font-family: inherit;
    }
    .gz-row:hover .gz-copy-btn { display: inline-flex; align-items: center; gap: 3px; }
    .gz-copy-btn:hover { background: var(--gz-border); color: var(--gz-green); }

    /* Chips de démarrage rapide */
    .gz-chips { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 13px; }
    .gz-chip {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; font-weight: 600;
        padding: 7px 13px;
        border-radius: 20px;
        border: 1.5px solid var(--gz-mint);
        background: var(--gz-light);
        color: var(--gz-green-dark);
        cursor: pointer;
        transition: all .15s;
        white-space: nowrap;
        user-select: none;
        font-family: inherit;
    }
    .gz-chip:hover:not(:disabled) {
        background: #dcfce7;
        border-color: #4ade80;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(22,163,74,.15);
    }
    .gz-chip:disabled { opacity: .4; cursor: default; transform: none !important; }
    .gz-chip.red  { background: var(--gz-red-light); color: var(--gz-red); border-color: var(--gz-red-border); }
    .gz-chip.red:hover:not(:disabled) { background: #fee2e2; border-color: #f87171; }
    .gz-chip.blue { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .gz-chip.blue:hover:not(:disabled) { background: #dbeafe; border-color: #93c5fd; }

    /* Typing indicator */
    .gz-typing { display: flex; gap: 5px; align-items: center; padding: 4px 2px; }
    .gz-typing span {
        width: 7px; height: 7px;
        background: #d1d5db; border-radius: 50%;
        animation: gzdot 1.3s infinite ease-in-out;
    }
    .gz-typing span:nth-child(2) { animation-delay: .18s; background: #9ca3af; }
    .gz-typing span:nth-child(3) { animation-delay: .36s; background: #6b7280; }
    @keyframes gzdot { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-7px)} }

    /* Divider "Nouvelle conversation" */
    .gz-divider {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        color: #9ca3af;
        margin: 4px 0;
    }
    .gz-divider::before, .gz-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--gz-border);
    }

    /* ══════════════════════════════════════
       ZONE INPUT
    ══════════════════════════════════════ */
    #gz-foot {
        padding: 14px 18px;
        background: #fff;
        border-top: 1px solid var(--gz-border);
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
    }

    /* Suggestions rapides dans le footer */
    #gz-quick-row {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 2px;
        scrollbar-width: none;
    }
    #gz-quick-row::-webkit-scrollbar { display: none; }
    .gz-quick {
        display: inline-flex; align-items: center; gap: 4px;
        white-space: nowrap;
        font-size: 11.5px; font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        border: 1.5px solid var(--gz-border);
        background: var(--gz-light);
        color: var(--gz-green-dark);
        cursor: pointer;
        transition: all .15s;
        flex-shrink: 0;
        font-family: inherit;
    }
    .gz-quick:hover { background: #dcfce7; border-color: #4ade80; }

    /* Input + bouton */
    #gz-input-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    #gz-inp {
        flex: 1;
        border: 1.5px solid #e5e7eb;
        border-radius: 16px;
        padding: 11px 18px;
        font-size: 13.5px;
        color: #111827;
        background: #f9fafb;
        outline: none;
        font-family: 'Inter', sans-serif;
        transition: border-color .15s, box-shadow .15s, background .15s;
        resize: none;
        min-height: 44px;
        max-height: 120px;
        line-height: 1.5;
    }
    #gz-inp:focus {
        border-color: var(--gz-green);
        box-shadow: 0 0 0 3px rgba(22,163,74,.1);
        background: #fff;
    }
    #gz-inp::placeholder { color: #9ca3af; }
    #gz-btn {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, var(--gz-green), var(--gz-green-dark));
        border: none; border-radius: 13px;
        cursor: pointer; color: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(22,163,74,.35);
        transition: transform .15s, box-shadow .15s, opacity .15s;
    }
    #gz-btn:hover:not(:disabled) { transform: scale(1.07); box-shadow: 0 6px 20px rgba(22,163,74,.45); }
    #gz-btn:disabled { opacity: .4; cursor: not-allowed; transform: none; }
    #gz-btn svg { width: 18px; height: 18px; }

    /* Barre du bas : infos conversation */
    #gz-foot-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 10.5px;
        color: #9ca3af;
        padding: 0 2px;
    }
    #gz-conv-id { font-family: monospace; font-size: 10px; }

    /* ══════════════════════════════════════
       TOAST
    ══════════════════════════════════════ */
    #gz-toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #111827;
        color: #fff;
        font-size: 13px;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 14px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s, transform .25s;
        z-index: 9999;
        white-space: nowrap;
    }
    #gz-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* ══════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════ */
    @media (max-width: 900px) {
        #gz-sidebar { display: none; }
    }
    @media (max-width: 768px) {
        #gz-wrap { height: calc(100vh - 96px); }
        #gz-chat  { border-radius: 16px; }
        .gz-col   { max-width: 82%; }
        #gz-msgs  { padding: 18px 14px 12px; }
        #gz-quick-row { display: none; }
    }
</style>

{{-- ══ TOAST ══ --}}
<div id="gz-toast"></div>

<div id="gz-wrap">

    {{-- ══════════════════════════════════════
         SIDEBAR GAUCHE
    ══════════════════════════════════════ --}}
    <div id="gz-sidebar">

        {{-- Bouton nouvelle conversation --}}
        <button id="gz-new-btn" onclick="resetChat()">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Nouvelle conversation
        </button>

        {{-- Modèle actif --}}
        <div class="gz-model-card">
            <h3>Modèle actif</h3>
            <div class="gz-model-badge">
                <span class="gz-dot"></span>
                <span>Grok 3 Mini</span>
                <small>xAI</small>
            </div>
            <div class="gz-model-badge" style="opacity:.5;">
                <span class="gz-dot" style="background:#9ca3af;box-shadow:none;"></span>
                <span style="color:var(--gz-muted);font-weight:500;">Gemini (secours)</span>
                <small>Google</small>
            </div>
        </div>

        {{-- Capacités de l'agent --}}
        <div class="gz-caps-card">
            <h3>Capacités</h3>
            <div class="gz-cap-item">
                <div class="gz-cap-icon green">🛒</div>
                <span>Suivi des commandes</span>
            </div>
            <div class="gz-cap-item">
                <div class="gz-cap-icon blue">📦</div>
                <span>État des livraisons</span>
            </div>
            <div class="gz-cap-item">
                <div class="gz-cap-icon orange">💳</div>
                <span>Aide au paiement</span>
            </div>
            <div class="gz-cap-item">
                <div class="gz-cap-icon purple">🔵</div>
                <span>Catalogue & stocks</span>
            </div>
            <div class="gz-cap-item">
                <div class="gz-cap-icon green">🧾</div>
                <span>Reçus & factures</span>
            </div>
            <div class="gz-cap-item">
                <div class="gz-cap-icon red">🚨</div>
                <span>Urgences gaz</span>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         ZONE CHAT PRINCIPALE
    ══════════════════════════════════════ --}}
    <div id="gz-chat">

        {{-- ── HEADER ── --}}
        <div id="gz-head">
            <div id="gz-bot-av">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect x="7" y="10" width="26" height="16" rx="5.5" fill="white"/>
                    <rect x="11" y="14" width="7" height="5.5" rx="2" fill="#16a34a"/>
                    <circle cx="14.5" cy="16.8" r="1.7" fill="white"/>
                    <rect x="22" y="14" width="7" height="5.5" rx="2" fill="#16a34a"/>
                    <circle cx="25.5" cy="16.8" r="1.7" fill="white"/>
                    <rect x="13" y="21.5" width="14" height="2" rx="1" fill="#bbf7d0"/>
                    <line x1="16" y1="26" x2="16" y2="29" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                    <line x1="24" y1="26" x2="24" y2="29" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                    <line x1="12" y1="29" x2="28" y2="29" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>
            <div id="gz-head-txt">
                <h2>GazBot &mdash; Agent IA</h2>
                <p>Grok · Propulsé par Laravel AI SDK · Disponible 24h/24</p>
            </div>

            {{-- Indicateur "réfléchit…" --}}
            <div id="gz-thinking">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                Réfléchit…
            </div>

            {{-- Compteur de messages --}}
            <div id="gz-token-badge">
                <strong id="gz-msg-count">0</strong> msg
            </div>
        </div>

        {{-- ── MESSAGES ── --}}
        <div id="gz-msgs">
            {{-- Message de bienvenue --}}
            <div class="gz-row" id="gz-welcome">
                <div class="gz-av bot">
                    <svg viewBox="0 0 20 20" fill="none">
                        <rect x="3" y="5" width="14" height="9" rx="3" fill="white"/>
                        <rect x="5.5" y="7.5" width="4" height="3" rx="1" fill="#16a34a"/>
                        <circle cx="7.5" cy="9" r=".9" fill="white"/>
                        <rect x="10.5" y="7.5" width="4" height="3" rx="1" fill="#16a34a"/>
                        <circle cx="12.5" cy="9" r=".9" fill="white"/>
                    </svg>
                </div>
                <div class="gz-col">
                    <div class="gz-bub bot">
                        Bonjour <strong>{{ Auth::user()->name }}</strong> 👋<br><br>
                        Je suis <strong>GazBot</strong>, votre assistant IA propulsé par <strong>Grok</strong> via le Laravel AI SDK. Je peux consulter vos commandes en temps réel, vérifier les stocks disponibles, vous guider pour payer ou télécharger vos reçus — et intervenir en cas d'urgence gaz.<br><br>
                        Comment puis-je vous aider aujourd'hui ?
                        <div class="gz-chips" id="gz-welcome-chips">
                            <button class="gz-chip" onclick="pickChip(this,'Montre-moi mes dernières commandes')">🛒 Mes commandes</button>
                            <button class="gz-chip" onclick="pickChip(this,'Quels gaz sont disponibles en stock ?')">🔵 Stock disponible</button>
                            <button class="gz-chip" onclick="pickChip(this,'Où en est ma dernière livraison ?')">📦 Suivi livraison</button>
                            <button class="gz-chip" onclick="pickChip(this,'Comment payer par Mobile Money MTN ou Orange ?')">💳 Paiement Mobile</button>
                            <button class="gz-chip" onclick="pickChip(this,'Comment télécharger mon reçu de paiement ?')">🧾 Télécharger reçu</button>
                            <button class="gz-chip blue" onclick="pickChip(this,'Comment passer une nouvelle commande de gaz ?')">ℹ️ Guide commande</button>
                            <button class="gz-chip red" onclick="pickChip(this,'URGENCE : je détecte une fuite de gaz !')">🚨 Urgence fuite gaz</button>
                        </div>
                    </div>
                    <div class="gz-meta">
                        <span class="gz-time">{{ now()->timezone('Africa/Douala')->format('H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── INPUT ── --}}
        <div id="gz-foot">
            {{-- Suggestions rapides --}}
            <div id="gz-quick-row">
                <button class="gz-quick" onclick="quickSend('Mes commandes en attente')">⏳ En attente</button>
                <button class="gz-quick" onclick="quickSend('Stock de gaz propane disponible')">⛽ Propane dispo</button>
                <button class="gz-quick" onclick="quickSend('Statut de ma dernière livraison')">🚚 Ma livraison</button>
                <button class="gz-quick" onclick="quickSend('Comment annuler une commande ?')">❌ Annuler commande</button>
                <button class="gz-quick" onclick="quickSend('Numéro urgence gaz Cameroun')">🆘 Urgence</button>
            </div>

            {{-- Zone saisie + bouton envoi --}}
            <div id="gz-input-row">
                <textarea
                    id="gz-inp"
                    placeholder="Écrivez votre message… (Entrée pour envoyer, Maj+Entrée pour saut de ligne)"
                    autocomplete="off"
                    rows="1"
                    onkeydown="handleKey(event)"
                    oninput="autoResize(this)"
                ></textarea>
                <button id="gz-btn" onclick="send()" title="Envoyer">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                    </svg>
                </button>
            </div>

            {{-- Méta pied de page --}}
            <div id="gz-foot-meta">
                <span>Conversation ID : <span id="gz-conv-id">—</span></span>
                <span>Laravel AI SDK &nbsp;·&nbsp; xAI Grok</span>
            </div>
        </div>

    </div>{{-- #gz-chat --}}
</div>{{-- #gz-wrap --}}

<script>
/* ══════════════════════════════════════
   ÉTAT GLOBAL
══════════════════════════════════════ */
let conversationId = null;
let msgCount = 0;

const ME = '{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}';

/* SVG avatar bot réutilisable */
const botSVG = `<div class="gz-av bot">
    <svg viewBox="0 0 20 20" fill="none">
        <rect x="3" y="5" width="14" height="9" rx="3" fill="white"/>
        <rect x="5.5" y="7.5" width="4" height="3" rx="1" fill="#16a34a"/>
        <circle cx="7.5" cy="9" r=".9" fill="white"/>
        <rect x="10.5" y="7.5" width="4" height="3" rx="1" fill="#16a34a"/>
        <circle cx="12.5" cy="9" r=".9" fill="white"/>
    </svg>
</div>`;

/* ══════════════════════════════════════
   UTILITAIRES
══════════════════════════════════════ */
function t() {
    return new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
}

function scroll() {
    const z = document.getElementById('gz-msgs');
    z.scrollTop = z.scrollHeight;
}

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        send();
    }
}

function showToast(msg, duration = 2000) {
    const t = document.getElementById('gz-toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), duration);
}

function setLoading(on) {
    document.getElementById('gz-btn').disabled = on;
    document.getElementById('gz-inp').disabled = on;
    document.getElementById('gz-thinking').classList.toggle('active', on);
}

function updateMsgCount() {
    msgCount++;
    document.getElementById('gz-msg-count').textContent = msgCount;
}

/* ══════════════════════════════════════
   RENDU DES BULLES
══════════════════════════════════════ */

/**
 * Formatage simple : **gras**, listes à tirets, retours à la ligne, emojis.
 */
function formatBot(text) {
    return text
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/`(.+?)`/g, '<code>$1</code>')
        .replace(/^[•\-]\s+(.+)$/gm, '<li>$1</li>')
        .replace(/((<li>.*<\/li>\n?)+)/g, '<ul>$1</ul>')
        .replace(/\n/g, '<br>');
}

function addBubble(text, role, toolUsed = null) {
    const zone = document.getElementById('gz-msgs');
    const row  = document.createElement('div');
    row.className = 'gz-row' + (role === 'usr' ? ' me' : '');

    const av = role === 'bot'
        ? botSVG
        : `<div class="gz-av usr">${ME}</div>`;

    const content = role === 'bot' ? formatBot(text) : escapeHtml(text).replace(/\n/g, '<br>');

    const toolBadge = (role === 'bot' && toolUsed)
        ? `<div class="gz-tool-badge">
               <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l5.654-4.654m5.654-4.654 4.654-5.654a2.548 2.548 0 0 1 3.586 3.586l-5.654 4.654"/>
               </svg>
               Outil utilisé : ${toolUsed}
           </div>`
        : '';

    row.innerHTML = `
        ${role === 'bot' ? av : ''}
        <div class="gz-col">
            ${toolBadge}
            <div class="gz-bub ${role}">${content}</div>
            <div class="gz-meta">
                <span class="gz-time">${t()}</span>
                ${role === 'bot' ? `<button class="gz-copy-btn" onclick="copyMsg(this)" data-text="${escapeAttr(text)}">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    Copier
                </button>` : ''}
            </div>
        </div>
        ${role === 'usr' ? av : ''}
    `;
    zone.appendChild(row);
    updateMsgCount();
    scroll();
    return row;
}

function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
function escapeAttr(str) {
    return str.replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

function showTyping() {
    const zone = document.getElementById('gz-msgs');
    const row  = document.createElement('div');
    const id   = 'typ-' + Date.now();
    row.className = 'gz-row';
    row.id = id;
    row.innerHTML = `
        ${botSVG}
        <div class="gz-col">
            <div class="gz-bub bot" style="padding:14px 18px;">
                <div class="gz-typing"><span></span><span></span><span></span></div>
            </div>
        </div>`;
    zone.appendChild(row);
    scroll();
    return id;
}

/* ══════════════════════════════════════
   CHIPS & SUGGESTIONS
══════════════════════════════════════ */
function lockChips() {
    document.querySelectorAll('#gz-welcome-chips .gz-chip').forEach(b => b.disabled = true);
}

function pickChip(btn, text) {
    lockChips();
    document.getElementById('gz-inp').value = text;
    send();
}

function quickSend(text) {
    document.getElementById('gz-inp').value = text;
    send();
}

/* ══════════════════════════════════════
   COPIER UN MESSAGE
══════════════════════════════════════ */
function copyMsg(btn) {
    const text = btn.dataset.text;
    navigator.clipboard.writeText(text).then(() => {
        showToast('✅ Message copié !');
    });
}

/* ══════════════════════════════════════
   ENVOI DU MESSAGE
══════════════════════════════════════ */
async function send() {
    const inp = document.getElementById('gz-inp');
    const msg = inp.value.trim();
    if (!msg) return;

    lockChips();
    addBubble(msg, 'usr');
    inp.value = '';
    inp.style.height = 'auto';
    setLoading(true);

    const tid = showTyping();

    try {
        const r = await fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message: msg,
                conversation_id: conversationId
            })
        });

        const d = await r.json();
        document.getElementById(tid)?.remove();

        /* Mémoriser l'ID de conversation retourné par Laravel AI SDK */
        if (d.conversation_id) {
            conversationId = d.conversation_id;
            document.getElementById('gz-conv-id').textContent =
                conversationId.substring(0, 8) + '…';
        }

        const reply   = d.reponse  ?? 'Désolé, une erreur est survenue.';
        const toolUsed = d.tool_used ?? null;

        addBubble(reply, 'bot', toolUsed);

    } catch (err) {
        document.getElementById(tid)?.remove();
        addBubble('❌ Erreur de connexion. Vérifiez votre réseau et réessayez.', 'bot');
    }

    setLoading(false);
    inp.focus();
}

/* ══════════════════════════════════════
   RÉINITIALISER LA CONVERSATION
══════════════════════════════════════ */
function resetChat() {
    conversationId = null;
    msgCount = 0;
    document.getElementById('gz-msg-count').textContent = '0';
    document.getElementById('gz-conv-id').textContent = '—';

    const zone = document.getElementById('gz-msgs');
    zone.innerHTML = '';

    /* Divider */
    const div = document.createElement('div');
    div.className = 'gz-divider';
    div.textContent = 'Nouvelle conversation · ' + t();
    zone.appendChild(div);

    /* Message de bienvenue simplifié */
    const row = document.createElement('div');
    row.className = 'gz-row';
    row.innerHTML = `
        ${botSVG}
        <div class="gz-col">
            <div class="gz-bub bot">
                Nouvelle conversation démarrée 👋<br>
                Comment puis-je vous aider ?
                <div class="gz-chips">
                    <button class="gz-chip" onclick="pickChip(this,'Mes dernières commandes')">🛒 Mes commandes</button>
                    <button class="gz-chip" onclick="pickChip(this,'Stock de gaz disponible')">🔵 Stock</button>
                    <button class="gz-chip red" onclick="pickChip(this,'URGENCE fuite de gaz')">🚨 Urgence</button>
                </div>
            </div>
            <div class="gz-meta"><span class="gz-time">${t()}</span></div>
        </div>`;
    zone.appendChild(row);

    document.getElementById('gz-inp').focus();
    showToast('🔄 Nouvelle conversation démarrée');
}
</script>
@endsection
