<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gaz Application')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        secondary: '#0f766e',
                        accent: '#f59e0b',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex-shrink-0 flex items-center">
                        <img class="h-8 w-8" src="{{ asset('sctm.png') }}" alt="Logo">
                        <span class="ml-2 text-xl font-bold text-primary">GazApp</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">Bonjour, {{ Auth::user()->name }}</span>
                            
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="text-primary hover:text-secondary px-3 py-2 rounded-md text-sm font-medium">
                                    Dashboard Admin
                                </a>
                            @elseif(Auth::user()->isVendeur())
                                <a href="{{ route('dashboardv') }}" class="text-primary hover:text-secondary px-3 py-2 rounded-md text-sm font-medium">
                                    Dashboard Vendeur
                                </a>
                            @else
                                <a href="{{ route('dashboardc') }}" class="text-primary hover:text-secondary px-3 py-2 rounded-md text-sm font-medium">
                                    Mon Dashboard
                                </a>
                            @endif

                            <a href="{{ route('commandes.index') }}" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                Mes Commandes
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 px-3 py-2 rounded-md text-sm font-medium">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('connexion') }}" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('inscription.form') }}" class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-secondary">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages Flash -->
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

    <!-- Contenu principal -->
    <main class="py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">GazApp</h3>
                    <p class="text-gray-300">Votre plateforme de commande et livraison de gaz domestique en ligne.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Commande en ligne</a></li>
                        <li><a href="#" class="hover:text-white">Paiement sécurisé</a></li>
                        <li><a href="#" class="hover:text-white">Livraison rapide</a></li>
                        <li><a href="#" class="hover:text-white">Support 24/7</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Sécurité</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Signaler à la police</a></li>
                        <li><a href="#" class="hover:text-white">Contacter les pompiers</a></li>
                        <li><a href="#" class="hover:text-white">Assistance d'urgence</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} GazApp. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
