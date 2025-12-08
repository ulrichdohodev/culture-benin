<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Culture Bénin')</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Variables de Couleur */
    :root {
      --cb-btn-green: #15803d;
      --cb-btn-green-dark: #14532d;
    }

    /* Style par défaut des boutons (couleur du texte en vert principal) */
    button:not(.text-white):not(.btn-except),
    input[type="button"]:not(.text-white):not(.btn-except),
    input[type="submit"]:not(.text-white):not(.btn-except),
    .btn:not(.text-white):not(.btn-except) {
      color: var(--cb-btn-green) !important;
    }

    /* Classe utilitaire pour exclure un bouton de la règle globale */
    .btn-except {
      color: inherit !important;
    }

    /* Styles forcés du Footer (pour une palette de couleurs cohérente) */
    footer {
      background-color: #0f7a3a !important;
      color: #f7ecd6 !important;
    }

    /* Titres et textes importants du footer */
    footer h3,
    footer .font-bold,
    footer .text-gray-100 {
      color: #fbf3e6 !important;
    }

    /* Paragraphe, petits textes et mentions du footer */
    footer p,
    footer .text-sm,
    footer .text-gray-300,
    footer .text-gray-400,
    footer .text-gray-200 {
      color: #e6dcc8 !important;
    }

    /* Liens du footer: couleur par défaut + hover visible */
    footer a {
      color: #e6dcc8 !important;
      text-decoration: none !important;
    }

    footer a:hover {
      color: #ffd24d !important;
    }

    /* Rendre les icônes SVG blanches et s'assurer qu'elles utilisent la couleur actuelle */
    footer svg {
      color: #ffffff !important;
      fill: currentColor !important;
    }

    /* Forcer visibilité des vignettes / boutons sociaux */
    footer .w-10,
    footer .w-5,
    footer a {
      opacity: 1 !important;
      filter: none !important;
    }

    /* Bordure supérieure du footer (légèrement claire pour contraste) */
    footer .border-t {
      border-color: rgba(255, 255, 255, 0.08) !important;
    }
  </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">
  <div class="min-h-screen flex flex-col">

    <header class="bg-white/95 border-b sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileOpen: false }" @resize.window="if (window.innerWidth >= 768) mobileOpen = false">
        <div class="flex items-center justify-between h-16">

          <!-- Logo -->
          <a href="{{ route('accueil') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="Culture Bénin" class="w-12 h-12 object-cover rounded-md">
            <div class="hidden sm:block">
              <h1 class="text-sm font-bold leading-tight">Culture Bénin</h1>
              <p class="text-xs text-gray-500">Patrimoine & savoir-faire</p>
            </div>
          </a>

          <!-- Navigation Desktop -->
          <nav class="hidden md:flex items-center justify-center flex-1 space-x-8 text-base font-medium">
            <a href="{{ route('accueil') }}" class="px-3 text-gray-700 hover:text-yellow-600 transition {{ request()->routeIs('accueil') ? 'text-yellow-600' : '' }}">Accueil</a>

            <div class="relative" x-data="{open:false}" @mouseenter="open=true" @mouseleave="open=false" @keydown.window.escape="open=false">
              <button @click="open = !open" @keydown.enter.prevent="open = true; $nextTick(()=> $refs.first && $refs.first.focus())" @keydown.space.prevent="open = true; $nextTick(()=> $refs.first && $refs.first.focus())" @keydown.arrow-down.prevent="open = true; $nextTick(()=> $refs.first && $refs.first.focus())" :aria-expanded="open ? 'true' : 'false'" aria-haspopup="true" class="text-gray-700 hover:text-yellow-600 transition focus:outline-none flex items-center gap-4">
                Découvrir
                <svg class="w-3 h-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
              </button>

              <div x-cloak x-show="open" x-ref="menu" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="absolute left-0 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 py-2 w-56 z-[9999]">
                <a href="{{ url('/decouvrir/art-et-artisanat') }}" x-ref="first" @keydown.arrow-down.prevent="$event.target.nextElementSibling?.focus() || $refs.first.focus()" @keydown.arrow-up.prevent="$refs.last.focus()" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50">Art & Artisanat</a>
                <a href="{{ url('/decouvrir/musique-danse') }}" @keydown.arrow-down.prevent="$event.target.nextElementSibling?.focus() || $refs.first.focus()" @keydown.arrow-up.prevent="$event.target.previousElementSibling?.focus()" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50">Musique & Danse</a>
                <a href="{{ url('/evenements') }}" @keydown.arrow-down.prevent="$event.target.nextElementSibling?.focus() || $refs.first.focus()" @keydown.arrow-up.prevent="$event.target.previousElementSibling?.focus()" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50">Événements</a>
                <a href="{{ url('/decouvrir/gastronomie') }}" x-ref="last" @keydown.arrow-down.prevent="$refs.first.focus()" @keydown.arrow-up.prevent="$event.target.previousElementSibling?.focus() || $refs.last.focus()" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50">Gastronomie</a>
              </div>
            </div>

            <a href="{{ url('/communaute') }}" class="px-3 text-gray-700 hover:text-yellow-600 transition {{ request()->is('communaute*') ? 'text-yellow-600' : '' }}">Communauté</a>
            <a href="{{ route('about') }}" class="px-3 text-gray-700 hover:text-yellow-600 transition {{ request()->routeIs('about') ? 'text-yellow-600' : '' }}">À propos</a>
            <a href="{{ route('contact') }}" class="px-3 text-gray-700 hover:text-yellow-600 transition {{ request()->routeIs('contact') ? 'text-yellow-600' : '' }}">Contact</a>
          </nav>

          <!-- Boutons Desktop -->
          <div class="hidden md:flex items-center space-x-4">
            @guest
              
            @else
              <div class="relative" x-data="{open:false}">
                <button @click="open = !open" class="flex items-center space-x-2">
                  @if(Auth::user()->photo)
                    <img src="{{ route('profile.photo', ['filename' => basename(Auth::user()->photo)]) }}" alt="Photo de profil" class="w-8 h-8 rounded-full object-cover border-2 border-green-600" />
                  @else
                    <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-medium">{{ strtoupper(substr(optional(Auth::user())->prenom ?? '',0,1)) }}</div>
                  @endif
                  <span class="hidden sm:inline text-base">{{ optional(Auth::user())->prenom ? (optional(Auth::user())->prenom . ' ' . optional(Auth::user())->nom) : Auth::user()->email }}</span>
                </button>

                <div x-cloak x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white border rounded shadow py-2 z-50">
                  <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="{{ url('/mes-contenus') }}">Mes contenus</a>
                  <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="{{ route('user.dashboard') }}">Mon Dashboard</a>
                  @if(Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isContributor())
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" href="{{ route('dashboard') }}">Tableau de bord</a>
                  @endif
                  <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Déconnexion</button>
                  </form>
                </div>
              </div>
            @endguest
          </div>

          <!-- Menu Hamburger Mobile -->
          <div class="md:hidden flex items-center space-x-2">
            @guest
              
            @endguest
            <button @click="mobileOpen = !mobileOpen" class="p-2 rounded hover:bg-gray-100 focus:outline-none">
              <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
          </div>
        </div>

        <!-- Menu Mobile -->
        <div x-cloak x-show="mobileOpen" x-transition class="lg:hidden border-t bg-white max-h-[calc(100vh-70px)] overflow-y-auto">
          <nav class="px-4 py-4 space-y-3 text-base font-medium">
            <a href="{{ route('accueil') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Accueil</a>
            <a href="{{ url('/decouvrir/art-et-artisanat') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Art & Artisanat</a>
            <a href="{{ url('/decouvrir/musique-danse') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Musique & Danse</a>
            <a href="{{ url('/evenements') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Événements</a>
            <a href="{{ url('/decouvrir/gastronomie') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Gastronomie</a>
            <a href="{{ url('/communaute') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Communauté</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">À propos</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Contact</a>

            @auth
              <div class="border-t pt-3 mt-3">
                <div class="flex items-center space-x-2 px-3 py-2 mb-3">
                  @if(Auth::user()->photo)
                    <img src="{{ route('profile.photo', ['filename' => basename(Auth::user()->photo)]) }}" alt="Photo de profil" class="w-8 h-8 rounded-full object-cover border-2 border-green-600" />
                  @else
                    <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-medium">{{ strtoupper(substr(optional(Auth::user())->prenom ?? '',0,1)) }}</div>
                  @endif
                  <span class="text-sm">{{ optional(Auth::user())->prenom ? (optional(Auth::user())->prenom . ' ' . optional(Auth::user())->nom) : Auth::user()->email }}</span>
                </div>
                <a href="{{ url('/mes-contenus') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">Mes contenus</a>
                <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">Mon Dashboard</a>
                @if(Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isContributor())
                  <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">Tableau de bord</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf
                  <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-gray-50 rounded">Déconnexion</button>
                </form>
              </div>
            @endauth

            @guest
              
            @endguest
          </nav>
        </div>
      </div>
    </header>

    <main class="flex-1">
      <div class="py-8">
        @yield('content')
      </div>
    </main>

    <footer class="bg-emerald-700 text-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          
          <div class="space-y-3">
            <a href="{{ route('accueil') }}" class="flex items-center gap-3">
              <img src="{{ asset('images/logo.png') }}" alt="Culture Bénin" class="w-16 h-16 object-cover rounded-md">
              <div>
                <div class="font-bold text-lg">Culture Bénin</div>
                <div class="text-sm text-gray-300">Valoriser et partager notre patrimoine culturel</div>
              </div>
            </a>

            <div class="mt-4 text-sm text-gray-400 space-y-1">
              <div><strong>Email :</strong> <a href="mailto:contact@culture-benin.org" class="hover:text-yellow-300 transition">contact@culture-benin.org</a></div>
              <div><strong>Téléphone/WhatsApp :</strong> <a href="tel:+22912345678" class="hover:text-yellow-300 transition">+229 12 34 56 78</a></div>
              <div><strong>Adresse :</strong> <span class="text-gray-300">Cotonou, Bénin</span></div>
            </div>
          </div>

          <div>
            <h3 class="font-semibold text-gray-100">Liens rapides</h3>
            <ul class="mt-3 space-y-2 text-sm text-gray-300">
              <li><a href="{{ route('accueil') }}" class="hover:text-yellow-300 transition">Accueil</a></li>
              <li><a href="{{ url('/decouvrir/art-et-artisanat') }}" class="hover:text-yellow-300 transition">Art & Artisanat</a></li>
              <li><a href="{{ url('/evenements') }}" class="hover:text-yellow-300 transition">Événements</a></li>
              <li><a href="{{ route('admin.media.index') }}" class="hover:text-yellow-300 transition">Galerie</a></li>
              <li><a href="{{ url('/communaute') }}" class="hover:text-yellow-300 transition">Communauté</a></li>
              <li><a href="{{ route('about') }}" class="hover:text-yellow-300 transition">À propos</a></li>
              <li><a href="{{ route('contact') }}" class="hover:text-yellow-300 transition">Contact</a></li>
            </ul>
          </div>

          <div>
            <h3 class="font-semibold text-[#f7ecd6]">Réseaux sociaux</h3>
            <p class="mt-2 text-sm text-[#e6dcc8]">Suivez-nous pour ne rien manquer des événements et des nouveautés.</p>

            <div class="mt-4 flex items-center gap-3">
              <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#3b5998] hover:scale-105 transform transition shadow-inner" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.6 9.9v-7H8.5v-2.9h2.9V9.1c0-2.8 1.7-4.3 4.2-4.3 1.2 0 2.5.2 2.5.2v2.8h-1.4c-1.4 0-1.8.9-1.8 1.8v2.1h3.1l-.5 2.9h-2.6v7A10 10 0 0022 12z" /></svg>
              </a>

              <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-pink-500 to-yellow-400 hover:scale-105 transform transition shadow-inner" aria-label="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 6.2A3.8 3.8 0 1012 15a3.8 3.8 0 000-7.6zM18.5 6a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
              </a>

              <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#e33] hover:scale-105 transform transition shadow-inner" aria-label="YouTube">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M10 15l5.2-3L10 9v6zm12-6.5s-.2-1.6-.8-2.3c-.8-.9-1.7-.9-2.1-1C16.6 4 12 4 12 4s-4.6 0-7.1.2c-.4.1-1.3.1-2.1 1C2.2 7.9 2 9.5 2 9.5S2 11.1 2 12.7v.6C2 14.9 2.2 16.5 2.8 17.2c.8.9 1.9.9 2.4 1 1.8.2 7.8.2 7.8.2s4.6 0 7.1-.2c.4-.1 1.3-.1 2.1-1 .6-.7.8-2.3.8-2.3S24 14 24 12.5v-.5c0-1.6-.2-3.1-2-3.5z" /></svg>
              </a>

              <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-black hover:scale-105 transform transition shadow-inner" aria-label="TikTok">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3v7.1a4 4 0 01-2-.6 4 4 0 00-3.3-.1 4 4 0 00-1.6 1.5A4 4 0 009 16a4 4 0 104 -4V7h2a5 5 0 001 0V3h1z" /></svg>
              </a>

              <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#1da1f2] hover:scale-105 transform transition shadow-inner" aria-label="X (Twitter)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016.5 3c-2.5 0-4.5 2.1-4.5 4.6 0 .36.04.72.12 1.06A12.9 12.9 0 013 4.7s-4 9 5 13c-1 0-2-.3-3-.8v.1c0 2.2 1.5 4 3.6 4.4a4.5 4.5 0 01-2 .1 4.6 4.6 0 004.2 3.2A9 9 0 012 19.5 12.8 12.8 0 008 21c8 0 12.4-6.6 12.4-12.3v-.6A8.9 8.9 0 0023 3z" /></svg>
              </a>
            </div>
          </div>

          <div>
            <h3 class="font-semibold text-gray-100">Newsletter</h3>
            <p class="mt-2 text-sm text-gray-300">Inscrivez-vous pour recevoir les nouveautés et événements.</p>

            <div class="mt-3 flex items-center gap-2">
              <input id="footer-newsletter-email" type="email" placeholder="Votre adresse email" class="w-full px-3 py-2 rounded bg-gray-800 border border-gray-700 text-gray-200" />
              <button id="footer-newsletter-cta" class="px-3 py-2 rounded bg-yellow-500 text-black font-semibold btn-except flex-shrink-0">S'abonner</button>
            </div>

            <div class="mt-4 text-sm text-gray-400 space-y-1">
              <a href="{{ url('/privacy') }}" class="block hover:text-yellow-300">Politique de confidentialité</a>
              <a href="{{ url('/terms') }}" class="block hover:text-yellow-300">Conditions d'utilisation (CGU)</a>
              <a href="{{ url('/copyright') }}" class="block hover:text-yellow-300">Droits d'auteur</a>
            </div>
          </div>
        </div>

        <div class="mt-8 border-t border-gray-800 pt-6 text-sm text-gray-400 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
          <div>© {{ date('Y') }} Culture Bénin — Tous droits réservés.</div>
          <div class="flex items-center gap-4">
            <a href="#top" class="hover:text-yellow-300">Retour en haut</a>
            <a href="{{ route('contact') }}" class="hover:text-yellow-300">Contact</a>
            <a href="{{ route('about') }}" class="hover:text-yellow-300">À propos</a>
          </div>
        </div>
      </div>
    </footer>

    <script>
      // Newsletter submit (footer)
      (function() {
        const btn = document.getElementById('footer-newsletter-cta');
        const input = document.getElementById('footer-newsletter-email');
        if (!btn || !input) return;

        btn.addEventListener('click', async function() {
          const email = input.value && input.value.trim();
          if (!email || !/.+@.+\..+/.test(email)) {
            return alert('Veuillez fournir une adresse email valide.');
          }

          try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            // Assurez-vous que la route 'newsletter.subscribe' est définie dans Laravel
            const res = await fetch('{{ route('newsletter.subscribe') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || ''
              },
              body: JSON.stringify({
                email
              })
            });

            if (res.ok) {
              alert("Merci ! Vous êtes inscrit(e) à la newsletter.");
              input.value = '';
            } else {
              const err = await res.json().catch(() => ({}));
              console.error('Newsletter error', err);
              alert('Une erreur est survenue. Réessayez plus tard.');
            }
          } catch (e) {
            console.error(e);
            alert('Erreur réseau.');
          }
        });
      })();
    </script>
  </div>

  @stack('scripts')

  <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>