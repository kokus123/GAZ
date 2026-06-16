<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GazApp')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   '#1a7a4a',
                        secondary: '#155c38',
                        accent:    '#f59e0b',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- ── Messages Flash globaux (hors welcome qui gère les siens) ── --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Contenu principal ── --}}
    @yield('content')

    {{-- ── Chatbot IA (clients uniquement) ── --}}
    @auth
    @if(!Auth::user()->isAdmin() && !Auth::user()->isVendeur())
    <style>
        #chatbot-btn { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        #chatbot-btn:hover { transform: scale(1.08); box-shadow: 0 8px 28px rgba(26,122,74,0.5) !important; }
        #chat-window { transition: opacity 0.25s ease, transform 0.25s ease; transform-origin: bottom right; }
        #chat-window.chat-hidden  { opacity: 0; transform: scale(0.92) translateY(10px); pointer-events: none; }
        #chat-window.chat-visible { opacity: 1; transform: scale(1) translateY(0);       pointer-events: all;  }
        .dot-typing { width:7px; height:7px; background:#9ca3af; border-radius:50%; display:inline-block; animation: dotBounce 1.3s infinite ease-in-out; }
        .dot-typing:nth-child(2) { animation-delay: 0.2s; }
        .dot-typing:nth-child(3) { animation-delay: 0.4s; }
        @keyframes dotBounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-7px)} }
        #chat-messages::-webkit-scrollbar { width: 4px; }
        #chat-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    </style>

    <div id="chatbot-container" style="position:fixed;bottom:24px;right:24px;z-index:9999;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

        {{-- Bouton robot --}}
        <button onclick="toggleChat()" id="chatbot-btn" aria-label="Ouvrir l'assistant GazApp"
            style="width:62px;height:62px;background:#1a7a4a;border:none;border-radius:50%;
                   cursor:pointer;display:flex;align-items:center;justify-content:center;
                   box-shadow:0 4px 18px rgba(26,122,74,0.45);">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                <line x1="18" y1="2" x2="18" y2="7" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                <circle cx="18" cy="2" r="2" fill="white"/>
                <rect x="5" y="7" width="26" height="16" rx="5" fill="white"/>
                <rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                <circle cx="12" cy="14.2" r="1.8" fill="white"/>
                <circle cx="12.5" cy="13.7" r="0.7" fill="#1a7a4a"/>
                <rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                <circle cx="24" cy="14.2" r="1.8" fill="white"/>
                <circle cx="24.5" cy="13.7" r="0.7" fill="#1a7a4a"/>
                <rect x="11" y="19.5" width="14" height="2.2" rx="1.1" fill="#d1fae5"/>
                <rect x="8" y="25" width="20" height="9" rx="3.5" fill="white"/>
                <circle cx="13" cy="29.5" r="2" fill="#1a7a4a" opacity="0.6"/>
                <circle cx="18" cy="29.5" r="2" fill="#1a7a4a" opacity="0.6"/>
                <circle cx="23" cy="29.5" r="2" fill="#1a7a4a" opacity="0.6"/>
                <rect x="2"  y="26" width="5" height="4.5" rx="2.2" fill="white"/>
                <rect x="29" y="26" width="5" height="4.5" rx="2.2" fill="white"/>
            </svg>
        </button>

        {{-- Fenêtre chat --}}
        <div id="chat-window" class="chat-hidden"
             style="position:absolute;bottom:74px;right:0;width:330px;background:white;
                    border-radius:20px;overflow:hidden;box-shadow:0 12px 48px rgba(0,0,0,0.2);
                    border:1px solid #e5e7eb;display:flex;flex-direction:column;height:460px;">

            <div style="background:#1a7a4a;padding:14px 16px;display:flex;align-items:center;gap:12px;flex-shrink:0;">
                <div style="width:44px;height:44px;background:rgba(255,255,255,0.18);border-radius:50%;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="26" height="26" viewBox="0 0 36 36" fill="none">
                        <rect x="5" y="7" width="26" height="16" rx="5" fill="white"/>
                        <rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                        <circle cx="12" cy="14.2" r="1.8" fill="white"/>
                        <rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                        <circle cx="24" cy="14.2" r="1.8" fill="white"/>
                        <rect x="11" y="19.5" width="14" height="2.2" rx="1.1" fill="#d1fae5"/>
                    </svg>
                </div>
                <div style="flex:1;">
                    <p style="color:white;font-weight:600;font-size:14px;margin:0;line-height:1.3;">Assistant GazApp</p>
                    <p style="color:rgba(255,255,255,0.78);font-size:11.5px;margin:0;">
                        <span style="display:inline-block;width:7px;height:7px;background:#86efac;border-radius:50%;margin-right:4px;vertical-align:middle;"></span>
                        En ligne · répond en quelques secondes
                    </p>
                </div>
                <button onclick="toggleChat()" aria-label="Fermer le chat"
                    style="background:rgba(255,255,255,0.15);border:none;color:white;cursor:pointer;
                           width:28px;height:28px;border-radius:50%;display:flex;align-items:center;
                           justify-content:center;font-size:14px;flex-shrink:0;">✕</button>
            </div>

            <div id="chat-messages"
                 style="flex:1;overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:10px;background:#f9fafb;">
                <div style="display:flex;gap:8px;align-items:flex-start;">
                    <div style="width:30px;height:30px;background:#1a7a4a;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="17" height="17" viewBox="0 0 36 36" fill="none">
                            <rect x="5" y="7" width="26" height="16" rx="5" fill="white"/>
                            <rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                            <circle cx="12" cy="14.2" r="1.8" fill="white"/>
                            <rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                            <circle cx="24" cy="14.2" r="1.8" fill="white"/>
                        </svg>
                    </div>
                    <div style="background:white;border-radius:16px;border-top-left-radius:4px;
                                padding:10px 13px;font-size:13px;color:#374151;max-width:240px;
                                box-shadow:0 1px 4px rgba(0,0,0,0.07);line-height:1.5;">
                        Bonjour <strong>{{ Auth::user()->name }}</strong> ! 👋<br><br>
                        Je suis votre assistant GazApp. Je peux vous aider avec vos commandes, livraisons et urgences gaz.
                    </div>
                </div>
            </div>

            <div id="suggestions"
                 style="padding:8px 12px;display:flex;gap:6px;flex-wrap:wrap;
                        background:white;border-top:1px solid #f3f4f6;flex-shrink:0;">
                <button onclick="envoyerSuggestion('Comment passer une commande ?')"
                    style="font-size:11.5px;background:#f0fdf4;color:#1a7a4a;border:1px solid #bbf7d0;
                           padding:5px 11px;border-radius:20px;cursor:pointer;font-weight:500;">🛒 Commander</button>
                <button onclick="envoyerSuggestion('Où en est ma livraison ?')"
                    style="font-size:11.5px;background:#f0fdf4;color:#1a7a4a;border:1px solid #bbf7d0;
                           padding:5px 11px;border-radius:20px;cursor:pointer;font-weight:500;">📦 Suivi</button>
                <button onclick="envoyerSuggestion('Urgence fuite de gaz !')"
                    style="font-size:11.5px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;
                           padding:5px 11px;border-radius:20px;cursor:pointer;font-weight:500;">🚨 Urgence</button>
            </div>

            <div style="padding:10px 12px;background:white;border-top:1px solid #f3f4f6;
                        display:flex;gap:8px;align-items:center;flex-shrink:0;">
                <input id="chat-input" type="text" placeholder="Posez votre question..."
                    onkeydown="if(event.key==='Enter') envoyerMessage()"
                    style="flex:1;border:1.5px solid #e5e7eb;border-radius:12px;padding:8px 13px;
                           font-size:13px;outline:none;color:#111827;background:#fafafa;transition:border-color 0.2s;"
                    onfocus="this.style.borderColor='#1a7a4a';this.style.boxShadow='0 0 0 3px rgba(26,122,74,0.12)';"
                    onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';">
                <button onclick="envoyerMessage()" id="send-btn" aria-label="Envoyer"
                    style="background:#1a7a4a;border:none;border-radius:12px;width:38px;height:38px;
                           cursor:pointer;color:white;font-size:15px;display:flex;align-items:center;
                           justify-content:center;flex-shrink:0;transition:background 0.2s;"
                    onmouseover="this.style.background='#155c38'" onmouseout="this.style.background='#1a7a4a'">➤</button>
            </div>
        </div>
    </div>

    <script>
    let historiqueChat = [];
    let chatVisible = false;

    function robotAvatarHTML() {
        return `<div style="width:30px;height:30px;background:#1a7a4a;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="17" height="17" viewBox="0 0 36 36" fill="none">
                <rect x="5" y="7" width="26" height="16" rx="5" fill="white"/>
                <rect x="8.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                <circle cx="12" cy="14.2" r="1.8" fill="white"/>
                <rect x="20.5" y="11.5" width="7" height="5.5" rx="2" fill="#1a7a4a"/>
                <circle cx="24" cy="14.2" r="1.8" fill="white"/>
            </svg></div>`;
    }

    function toggleChat() {
        const w = document.getElementById('chat-window');
        chatVisible = !chatVisible;
        if (chatVisible) {
            w.classList.remove('chat-hidden'); w.classList.add('chat-visible');
            setTimeout(() => document.getElementById('chat-input').focus(), 100);
        } else {
            w.classList.remove('chat-visible'); w.classList.add('chat-hidden');
        }
    }

    function envoyerSuggestion(texte) {
        document.getElementById('suggestions').style.display = 'none';
        document.getElementById('chat-input').value = texte;
        envoyerMessage();
    }

    async function envoyerMessage() {
        const input = document.getElementById('chat-input');
        const btn   = document.getElementById('send-btn');
        const msg   = input.value.trim();
        if (!msg) return;

        ajouterMessage(msg, 'user');
        input.value = '';
        btn.disabled = true; btn.style.opacity = '0.5';

        const typingId = afficherTyping();
        historiqueChat.push({ role: 'user', content: msg });

        try {
            const res = await fetch('/chatbot', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ message: msg, historique: historiqueChat.slice(-6) })
            });
            const data = await res.json();
            supprimerTyping(typingId);
            const reponse = data.reponse ?? "Désolé, une erreur est survenue. Réessayez.";
            ajouterMessage(reponse, 'bot');
            historiqueChat.push({ role: 'assistant', content: reponse });
        } catch(e) {
            supprimerTyping(typingId);
            ajouterMessage("Erreur de connexion. Vérifiez votre réseau.", 'bot');
        }

        btn.disabled = false; btn.style.opacity = '1';
        input.focus();
    }

    function ajouterMessage(texte, role) {
        const zone = document.getElementById('chat-messages');
        const div  = document.createElement('div');
        if (role === 'user') {
            div.style.cssText = 'display:flex;justify-content:flex-end;';
            div.innerHTML = `<div style="background:#1a7a4a;color:white;border-radius:16px;border-top-right-radius:4px;
                padding:10px 13px;font-size:13px;max-width:230px;line-height:1.5;box-shadow:0 1px 4px rgba(0,0,0,0.1);">${texte}</div>`;
        } else {
            div.style.cssText = 'display:flex;gap:8px;align-items:flex-start;';
            div.innerHTML = `${robotAvatarHTML()}<div style="background:white;border-radius:16px;border-top-left-radius:4px;
                padding:10px 13px;font-size:13px;color:#374151;max-width:225px;line-height:1.5;
                box-shadow:0 1px 4px rgba(0,0,0,0.07);">${texte}</div>`;
        }
        zone.appendChild(div);
        zone.scrollTop = zone.scrollHeight;
    }

    function afficherTyping() {
        const zone = document.getElementById('chat-messages');
        const id   = 'typing-' + Date.now();
        const div  = document.createElement('div');
        div.id = id;
        div.style.cssText = 'display:flex;gap:8px;align-items:flex-start;';
        div.innerHTML = `${robotAvatarHTML()}<div style="background:white;border-radius:16px;border-top-left-radius:4px;
             padding:12px 16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);display:flex;gap:5px;align-items:center;">
            <span class="dot-typing"></span><span class="dot-typing"></span><span class="dot-typing"></span></div>`;
        zone.appendChild(div);
        zone.scrollTop = zone.scrollHeight;
        return id;
    }

    function supprimerTyping(id) { const el = document.getElementById(id); if (el) el.remove(); }
    </script>
    @endif
    @endauth

    @stack('scripts')
</body>
</html>