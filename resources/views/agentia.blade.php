@extends('layouts.sidebar')

@section('title', 'Agent IA — GazApp')
@section('page-title', 'Agent IA')
@section('page-subtitle', '')

@section('content')
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #gz-chat {
        height: calc(100vh - 112px);
        display: flex;
        flex-direction: column;
        background: #f0fdf4;
        border-radius: 24px;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
        position: relative;
    }

    /* ══ HEADER ══ */
    #gz-head {
        background: #fff;
        border-bottom: 1px solid #dcfce7;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }
    #gz-bot-av {
        width: 46px; height: 46px;
        background: linear-gradient(135deg, #16a34a, #052e16);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(22,163,74,.35);
        position: relative;
    }
    #gz-bot-av svg { width: 26px; height: 26px; }
    #gz-bot-av::after {
        content: '';
        position: absolute;
        bottom: -2px; right: -2px;
        width: 12px; height: 12px;
        background: #22c55e;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    #gz-head-txt { flex: 1; }
    #gz-head-txt h2 { font-size: 15px; font-weight: 700; color: #111827; letter-spacing: -.2px; }
    #gz-head-txt p  { font-size: 12px; color: #6b7280; margin-top: 1px; }
    #gz-clear {
        width: 36px; height: 36px;
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background .15s, border-color .15s;
        color: #6b7280;
    }
    #gz-clear:hover { background: #dcfce7; border-color: #86efac; color: #15803d; }
    #gz-clear svg { width: 16px; height: 16px; }

    /* ══ MESSAGES ══ */
    #gz-msgs {
        flex: 1;
        overflow-y: auto;
        padding: 28px 24px 16px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-height: 0;
        scroll-behavior: smooth;
    }
    #gz-msgs::-webkit-scrollbar { width: 4px; }
    #gz-msgs::-webkit-scrollbar-thumb { background: #bbf7d0; border-radius: 4px; }

    /* ── Rows ── */
    .gz-row { display: flex; gap: 10px; align-items: flex-end; animation: fadeUp .25s ease; }
    .gz-row.me { flex-direction: row-reverse; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

    /* ── Avatars ── */
    .gz-av {
        width: 32px; height: 32px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 13px; font-weight: 700;
    }
    .gz-av.bot { background: linear-gradient(135deg,#16a34a,#052e16); }
    .gz-av.bot svg { width: 17px; height: 17px; }
    .gz-av.usr { background: linear-gradient(135deg,#4ade80,#16a34a); color:#fff; font-size:13px; }

    /* ── Bulles ── */
    .gz-col { display: flex; flex-direction: column; max-width: 66%; }
    .me .gz-col { align-items: flex-end; }

    .gz-bub {
        padding: 12px 16px;
        border-radius: 20px;
        font-size: 13.5px;
        line-height: 1.65;
        word-break: break-word;
    }
    .gz-bub.bot {
        background: #fff;
        color: #1f2937;
        border-bottom-left-radius: 5px;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
    }
    .gz-bub.usr {
        background: linear-gradient(135deg,#16a34a,#15803d);
        color: #fff;
        border-bottom-right-radius: 5px;
        box-shadow: 0 4px 14px rgba(22,163,74,.3);
    }
    .gz-time { font-size: 10.5px; color: #9ca3af; margin-top: 5px; padding: 0 4px; }
    .me .gz-time { text-align: right; }

    /* ── Chips intégrées dans bulle bot ── */
    .gz-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 12px;
    }
    .gz-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px; font-weight: 600;
        padding: 7px 13px;
        border-radius: 20px;
        border: 1.5px solid #bbf7d0;
        background: #f0fdf4;
        color: #15803d;
        cursor: pointer;
        transition: all .15s;
        white-space: nowrap;
        user-select: none;
    }
    .gz-chip:hover:not(:disabled) { background: #dcfce7; border-color: #4ade80; transform: translateY(-1px); box-shadow: 0 3px 10px rgba(22,163,74,.15); }
    .gz-chip:disabled { opacity: .4; cursor: default; transform: none !important; }
    .gz-chip.red { background: #fff5f5; color: #dc2626; border-color: #fca5a5; }
    .gz-chip.red:hover:not(:disabled) { background: #fee2e2; border-color: #f87171; box-shadow: 0 3px 10px rgba(220,38,38,.15); }

    /* ── Typing ── */
    .gz-typing { display: flex; gap: 5px; align-items: center; padding: 3px 2px; }
    .gz-typing span {
        width: 7px; height: 7px;
        background: #d1d5db; border-radius: 50%;
        animation: gzdot 1.3s infinite ease-in-out;
    }
    .gz-typing span:nth-child(2) { animation-delay: .18s; background: #9ca3af; }
    .gz-typing span:nth-child(3) { animation-delay: .36s; background: #6b7280; }
    @keyframes gzdot { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-7px)} }

    /* ══ INPUT ══ */
    #gz-foot {
        padding: 14px 20px;
        background: #fff;
        border-top: 1px solid #dcfce7;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    #gz-inp {
        flex: 1;
        border: 1.5px solid #e5e7eb;
        border-radius: 16px;
        padding: 12px 18px;
        font-size: 13.5px;
        color: #111827;
        background: #f9fafb;
        outline: none;
        font-family: 'Inter', sans-serif;
        transition: border-color .15s, box-shadow .15s, background .15s;
    }
    #gz-inp:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22,163,74,.1);
        background: #fff;
    }
    #gz-inp::placeholder { color: #9ca3af; }
    #gz-btn {
        width: 46px; height: 46px;
        background: linear-gradient(135deg,#16a34a,#15803d);
        border: none; border-radius: 14px;
        cursor: pointer; color: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(22,163,74,.35);
        transition: transform .15s, box-shadow .15s, opacity .15s;
    }
    #gz-btn:hover:not(:disabled) { transform: scale(1.07); box-shadow: 0 6px 20px rgba(22,163,74,.45); }
    #gz-btn:disabled { opacity: .4; cursor: not-allowed; transform: none; }
    #gz-btn svg { width: 19px; height: 19px; }

    @media (max-width: 768px) {
        #gz-chat { height: calc(100vh - 96px); border-radius: 16px; }
        .gz-col { max-width: 80%; }
        #gz-msgs { padding: 20px 14px 12px; }
    }
</style>

<div id="gz-chat">

    {{-- ══ HEADER ══ --}}
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
            <p>Propulsé par l'intelligence artificielle · Disponible 24h/24</p>
        </div>
        <button id="gz-clear" onclick="resetChat()" title="Nouvelle conversation">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </button>
    </div>

    {{-- ══ MESSAGES ══ --}}
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
                    Je suis <strong>GazBot</strong>, votre assistant IA dédié. Posez-moi n'importe quelle question sur vos commandes, livraisons, paiements ou en cas d'urgence gaz.<br><br>
                    Par où voulez-vous commencer ?
                    <div class="gz-chips" id="gz-welcome-chips">
                        <button class="gz-chip" onclick="pickChip(this,'Comment passer une nouvelle commande de gaz ?')">🛒 Passer une commande</button>
                        <button class="gz-chip" onclick="pickChip(this,'Où en est ma dernière livraison ?')">📦 Suivi de livraison</button>
                        <button class="gz-chip" onclick="pickChip(this,'Comment payer par Mobile Money ?')">💳 Paiement Mobile Money</button>
                        <button class="gz-chip" onclick="pickChip(this,'Quels types de bouteilles de gaz proposez-vous ?')">🔵 Nos produits</button>
                        <button class="gz-chip" onclick="pickChip(this,'Comment télécharger mon reçu de paiement ?')">🧾 Télécharger un reçu</button>
                        <button class="gz-chip red" onclick="pickChip(this,'URGENCE : je détecte une fuite de gaz !')">🚨 Urgence fuite gaz</button>
                    </div>
                </div>
                <div class="gz-time">{{ now()->format('H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- ══ INPUT ══ --}}
    <div id="gz-foot">
        <input id="gz-inp" type="text" placeholder="Écrivez votre message…" autocomplete="off"
               onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();send();}">
        <button id="gz-btn" onclick="send()">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
            </svg>
        </button>
    </div>

</div>

<script>
let hist = [];
const ME = '{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}';

const botSVG = `<div class="gz-av bot"><svg viewBox="0 0 20 20" fill="none"><rect x="3" y="5" width="14" height="9" rx="3" fill="white"/><rect x="5.5" y="7.5" width="4" height="3" rx="1" fill="#16a34a"/><circle cx="7.5" cy="9" r=".9" fill="white"/><rect x="10.5" y="7.5" width="4" height="3" rx="1" fill="#16a34a"/><circle cx="12.5" cy="9" r=".9" fill="white"/></svg></div>`;

function t() {
    return new Date().toLocaleTimeString('fr-FR',{hour:'2-digit',minute:'2-digit'});
}

function scroll() {
    const z = document.getElementById('gz-msgs');
    z.scrollTop = z.scrollHeight;
}

function addBubble(text, role) {
    const zone = document.getElementById('gz-msgs');
    const row  = document.createElement('div');
    row.className = 'gz-row' + (role === 'usr' ? ' me' : '');

    const av = role === 'bot'
        ? botSVG
        : `<div class="gz-av usr">${ME}</div>`;

    row.innerHTML = `
        ${role === 'bot' ? av : ''}
        <div class="gz-col">
            <div class="gz-bub ${role}">${text.replace(/\n/g,'<br>')}</div>
            <div class="gz-time">${t()}</div>
        </div>
        ${role === 'usr' ? av : ''}
    `;
    zone.appendChild(row);
    scroll();
    return row;
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

function lockChips() {
    document.querySelectorAll('#gz-welcome-chips .gz-chip').forEach(b => b.disabled = true);
}

function pickChip(btn, text) {
    lockChips();
    document.getElementById('gz-inp').value = text;
    send();
}

async function send() {
    const inp = document.getElementById('gz-inp');
    const btn = document.getElementById('gz-btn');
    const msg = inp.value.trim();
    if (!msg) return;

    lockChips();
    addBubble(msg, 'usr');
    inp.value = '';
    btn.disabled = true;
    hist.push({ role:'user', content: msg });

    const tid = showTyping();
    try {
        const r = await fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: msg, historique: hist.slice(-10) })
        });
        const d = await r.json();
        document.getElementById(tid)?.remove();
        const reply = d.reponse ?? 'Désolé, une erreur est survenue.';
        addBubble(reply, 'bot');
        hist.push({ role:'assistant', content: reply });
    } catch {
        document.getElementById(tid)?.remove();
        addBubble('Erreur de connexion. Vérifiez votre réseau.', 'bot');
    }
    btn.disabled = false;
    inp.focus();
}

function resetChat() {
    hist = [];
    document.getElementById('gz-msgs').innerHTML = '';
    const welcomeRow = document.createElement('div');
    welcomeRow.className = 'gz-row';
    welcomeRow.innerHTML = `
        ${botSVG}
        <div class="gz-col">
            <div class="gz-bub bot">Nouvelle conversation démarrée. Comment puis-je vous aider ?</div>
            <div class="gz-time">${t()}</div>
        </div>`;
    document.getElementById('gz-msgs').appendChild(welcomeRow);
    document.getElementById('gz-inp').focus();
}
</script>
@endsection