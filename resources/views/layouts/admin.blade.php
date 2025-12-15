<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — Culture Bénin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r">
            <div class="p-4 border-b">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Culture Bénin" class="w-12 h-12 object-cover rounded-md">
                    <div class="hidden sm:block">
                        <div class="font-bold">Admin</div>
                        <div class="text-xs text-gray-500">Culture Bénin</div>
                    </div>
                </a>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">Tableau de bord</a>
                <a href="{{ route('admin.contenus.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.contenus*') ? 'bg-gray-100 font-semibold' : '' }}">Contenus</a>
                <a href="{{ route('admin.utilisateurs.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.utilisateurs*') ? 'bg-gray-100 font-semibold' : '' }}">Utilisateurs</a>
                <a href="{{ route('admin.roles.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.roles*') ? 'bg-gray-100 font-semibold' : '' }}">Rôles</a>
                <a href="{{ route('admin.regions.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.regions*') ? 'bg-gray-100 font-semibold' : '' }}">Régions</a>
                <a href="{{ route('admin.langues.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.langues*') ? 'bg-gray-100 font-semibold' : '' }}">Langues</a>
                <a href="{{ route('admin.type-contenus.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.type-contenus*') ? 'bg-gray-100 font-semibold' : '' }}">Types de contenu</a>
                <a href="{{ route('admin.type-media.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.type-media*') ? 'bg-gray-100 font-semibold' : '' }}">Types de media</a>
                <a href="{{ route('admin.media.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.media*') ? 'bg-gray-100 font-semibold' : '' }}">Médias</a>
                <a href="{{ route('admin.commentaires.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.commentaires*') ? 'bg-gray-100 font-semibold' : '' }}">Commentaires</a>
                <a href="{{ route('admin.parler.index') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.parler*') ? 'bg-gray-100 font-semibold' : '' }}">Parler (Région-Langue)</a>
                <a href="{{ route('admin.statistiques') }}" class="block px-3 py-2 rounded hover:bg-gray-50 {{ request()->routeIs('admin.statistiques') ? 'bg-gray-100 font-semibold' : '' }}">Statistiques</a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b p-4">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <div class="flex-1">@yield('header')</div>

                    <div class="ml-4">
                        @auth
                            <div class="relative" x-data="{open:false}">
                                <button @click="open = !open" class="inline-flex items-center space-x-3 px-2 py-1 rounded hover:bg-gray-50">
                                    <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-medium">{{ strtoupper(substr(optional(Auth::user())->prenom ?? '',0,1)) }}</div>
                                    <div class="hidden sm:block text-sm">{{ optional(Auth::user())->prenom ? (optional(Auth::user())->prenom . ' ' . optional(Auth::user())->nom) : Auth::user()->email }}</div>
                                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white border rounded shadow py-2 z-20">
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="{{ route('mes-contenus') }}">Mes contenus</a>
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="{{ route('profile.edit') }}">Profil</a>
                                    @if(Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isContributor())
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="{{ route('dashboard') }}">Tableau de bord</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">@csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600">Déconnexion</button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </header>
            <main class="p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>