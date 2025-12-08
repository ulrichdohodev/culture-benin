@extends('layouts.app')

@section('title', 'Accueil - Culture Bénin')

@section('content')

<style>
    /* Variables de couleurs et thème */
    :root {
        --cb-primary: #0f7a3a;
        --cb-secondary: #ffd24d;
        --cb-accent: #d4af37;
        --cb-dark: #24170f;
        --cb-light: #fbf7f0;
        --cb-earth: #8b4513;
        --cb-sky: #2e8b57;
    }

    /* Animations personnalisées */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(15, 122, 58, 0.3); }
        50% { box-shadow: 0 0 30px rgba(15, 122, 58, 0.6); }
    }

    /* Classes utilitaires */
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out both; }
    .animate-delay-100 { animation-delay: 0.1s; }
    .animate-delay-200 { animation-delay: 0.2s; }
    .animate-delay-300 { animation-delay: 0.3s; }

    /* Styles spécifiques */
    .hero-gradient {
        background: linear-gradient(135deg, var(--cb-primary) 0%, var(--cb-dark) 50%, var(--cb-earth) 100%);
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .shimmer-text {
        background: linear-gradient(90deg, var(--cb-secondary), var(--cb-accent), var(--cb-secondary));
        background-size: 200% auto;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }

    .culture-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230f7a3a' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--cb-primary), var(--cb-sky));
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s;
    }

    .btn-primary:hover::after {
        left: 100%;
    }

    .btn-secondary {
        border: 2px solid var(--cb-primary);
        background: var(--cb-primary);
        color: white;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }

    .btn-secondary:hover {
        background: #0c5f2d;
        border-color: #0c5f2d;
        color: white;
        transform: translateY(-1px);
    }
</style>

<!-- Hero Section Améliorée -->
<section class="relative min-h-[90vh] overflow-hidden culture-pattern">
    <!-- Background avec vidéo et superposition -->
    <div class="absolute inset-0 z-0">
        <!-- Vidéo de fond -->
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="{{ asset('videos/arriere_hero.mp4') }}" type="video/mp4">
            <img src="{{ asset('images/hero.jpg') }}" alt="Culture Bénin" class="w-full h-full object-cover">
        </video>
        <div class="absolute inset-0 bg-gradient-to-br from-green-700/40 via-green-600/30 to-green-800/20 z-10"></div>
        <!-- Éléments décoratifs animés -->
        <div class="absolute top-1/4 left-10 w-24 h-24 rounded-full border-2 border-yellow-500/30 animate-float"></div>
        <div class="absolute bottom-1/3 right-20 w-16 h-16 rounded-full border-2 border-green-500/30 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 rounded-full border-2 border-amber-500/30 animate-float" style="animation-delay: 2s;"></div>
    </div>

    <!-- Contenu Hero -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20">
        <div class="text-center">
            <!-- Titre principal avec animation -->
            <h1 class="animate-fade-in-up text-5xl md:text-7xl lg:text-8xl font-bold mb-6">
                <span class="block text-white">CULTURE</span>
                <span class="shimmer-text">BÉNIN</span>
            </h1>

            <!-- Sous-titre -->
            <p class="animate-fade-in-up animate-delay-100 text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto leading-relaxed">
                Explorez la richesse du patrimoine béninois à travers ses traditions vivantes, 
                ses arts vibrants et ses histoires captivantes.
            </p>

            <!-- Boutons CTA -->
            <div class="animate-fade-in-up animate-delay-200 flex flex-col sm:flex-row gap-6 justify-center items-center mt-12">
                <a href="{{ route('explorer') }}" 
                   class="btn-primary px-8 py-4 rounded-full text-white font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
                   <span class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Explorer le Patrimoine
                   </span>
                </a>

                @auth
                    <a href="{{ url('/mes-contenus') }}" 
                       class="btn-secondary px-8 py-4 rounded-full font-bold text-lg bg-white/10 backdrop-blur-sm border-2 border-white/30 hover:border-white/60 transition-all duration-300">
                       Partager une Découverte
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="btn-secondary px-8 py-4 rounded-full font-bold text-lg bg-white/10 backdrop-blur-sm border-2 border-white/30 hover:border-white/60 transition-all duration-300">
                       Se Connecter
                    </a>
                @endauth
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Statistiques en Temps Réel -->
<section class="relative py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="absolute inset-0 culture-pattern opacity-5"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Une Communauté <span class="text-green-600">Vivante</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Des passionnés qui partagent, préservent et célèbrent la culture béninoise
            </p>
        </div>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $stats = [
                    ['icon' => 'fa-book', 'label' => 'Contenus Validés', 'value' => $totalContenus ?? 0, 'color' => 'green'],
                    ['icon' => 'fa-map', 'label' => 'Régions Couvertes', 'value' => $totalRegions ?? 0, 'color' => 'amber'],
                    ['icon' => 'fa-comments', 'label' => 'Langues Documentées', 'value' => $totalLangues ?? 0, 'color' => 'blue'],
                    ['icon' => 'fa-users', 'label' => 'Contributeurs Actifs', 'value' => $totalUtilisateurs ?? 0, 'color' => 'purple'],
                ];
            @endphp

            @foreach($stats as $index => $stat)
                <div class="card-hover bg-white rounded-2xl p-8 shadow-xl border border-gray-100 animate-fade-in-up"
                     style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="text-center">
                        <div class="text-5xl mb-4 text-green-600"><i class="fas {{ $stat['icon'] }}"></i></div>
                        <div class="text-5xl font-bold text-gray-900 mb-2">
                            <span class="counter" data-target="{{ $stat['value'] }}">0</span>+
                        </div>
                        <div class="text-lg font-semibold text-gray-700">{{ $stat['label'] }}</div>
                        <div class="mt-4 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $stat['color'] }}-500 rounded-full" 
                                 style="width: {{ min(100, ($stat['value'] / 1000) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sections Thématiques -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Explorez par <span class="text-amber-600">Thème</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Plongez dans les différentes facettes de la culture béninoise
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Musique & Danse -->
            <a href="{{ route('decouvrir.show', 'musique-et-danse') }}" 
               class="group relative overflow-hidden rounded-3xl shadow-2xl card-hover">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('images/musique.jpg') }}" alt="Musique et Danse"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-amber-500 text-white font-bold text-sm">
                            🎵 Musique & Danse
                        </span>
                    </div>
                </div>
                <div class="p-6 bg-white">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Rythmes et Mouvements</h3>
                    <p class="text-gray-600 mb-4">Découvrez les traditions musicales et chorégraphiques du Bénin</p>
                    <div class="flex items-center text-green-600 font-semibold">
                        <span>Explorer</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Gastronomie -->
            <a href="{{ route('decouvrir.show', 'gastronomie') }}" 
               class="group relative overflow-hidden rounded-3xl shadow-2xl card-hover">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('images/gastronomie.jpg') }}" alt="Gastronomie"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-red-500 text-white font-bold text-sm">
                            🍲 Gastronomie
                        </span>
                    </div>
                </div>
                <div class="p-6 bg-white">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Saveurs Traditionnelles</h3>
                    <p class="text-gray-600 mb-4">Goûtez aux plats emblématiques et recettes ancestrales</p>
                    <div class="flex items-center text-green-600 font-semibold">
                        <span>Découvrir</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Événements -->
            <a href="{{ route('decouvrir.show', 'evenements') }}" 
               class="group relative overflow-hidden rounded-3xl shadow-2xl card-hover">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('images/evenements.jpg') }}" alt="Événements"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-purple-500 text-white font-bold text-sm">
                            🎉 Événements
                        </span>
                    </div>
                </div>
                <div class="p-6 bg-white">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Festivals & Célébrations</h3>
                    <p class="text-gray-600 mb-4">Participez aux événements culturels à travers le pays</p>
                    <div class="flex items-center text-green-600 font-semibold">
                        <span>Voir le Calendrier</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Carrousel Gastronomie -->
<section class="py-20 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div class="mb-8 md:mb-0">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Saveurs du <span class="text-green-600">Bénin</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Découvrez les plats traditionnels et leurs histoires
                </p>
            </div>
            <a href="{{ route('decouvrir.show', 'gastronomie') }}" 
               class="btn-primary px-8 py-3 rounded-full text-white font-bold shadow-lg hover:shadow-xl bg-green-600 hover:bg-green-700">
               Voir toute la gastronomie
            </a>
        </div>

        <!-- Carrousel Gastronomie -->
        <div class="relative">
            <div class="gastronomie-carousel flex gap-6 overflow-x-auto pb-8 snap-x snap-mandatory scrollbar-hide">
                @php
                    $plats = [
                        ['img' => 'images/amiwo.jpg', 'title' => 'Amiwo', 'desc' => 'Sauce à base de tomates et de piments', 'region' => 'Sud Bénin', 'price' => 2500],
                        ['img' => 'images/wassa.jpg', 'title' => 'Wassa-Wassa', 'desc' => 'Plat à base de igname pilée', 'region' => 'Nord Bénin', 'price' => 3000],
                        ['img' => 'images/to.jpg', 'title' => 'Tô', 'desc' => 'Pâte de maïs ou de mil', 'region' => 'Partout', 'price' => 2000],
                        ['img' => 'images/gombo.jpg', 'title' => 'Sauce Gombo', 'desc' => 'Sauce gluante aux multiples vertus', 'region' => 'Centre', 'price' => 2800],
                        ['img' => 'images/akassa.jpg', 'title' => 'Akassa', 'desc' => 'Pâte de maïs fermentée', 'region' => 'Côtière', 'price' => 3200],
                    ];
                @endphp

                @foreach($plats as $plat)
                    <div class="flex-shrink-0 w-80 snap-center">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-xl card-hover border-2 border-green-100">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ asset($plat['img']) }}" alt="{{ $plat['title'] }}"
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-green-600 text-white rounded-full text-sm font-bold">
                                        {{ $plat['region'] }}
                                    </span>
                                </div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-green-500 text-white rounded-full text-sm font-bold">
                                        {{ number_format($plat['price'], 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $plat['title'] }}</h3>
                                </div>
                                <p class="text-gray-600 mb-4">{{ $plat['desc'] }}</p>
                                <div class="flex gap-3">
                                    <button class="flex-1 px-4 py-2 bg-green-600 text-white rounded-full font-bold text-sm hover:bg-green-700 transition-colors pay-gastro"
                                            data-slug="{{ $plat['title'] }}" data-amount="{{ $plat['price'] }}">
                                        Commander
                                    </button>
                                    <a href="{{ route('decouvrir.show', 'gastronomie') }}?plat={{ urlencode($plat['title']) }}"
                                       class="flex-1 px-4 py-2 text-green-600 border-2 border-green-600 rounded-full font-bold text-sm hover:bg-green-50 transition-colors flex items-center justify-center gap-2">
                                        <span>Plus</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Événements à Venir -->
<section class="py-20 bg-gradient-to-b from-white to-green-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div class="mb-8 md:mb-0">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Événements <span class="text-green-600">Culturels</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Ne manquez pas les prochains rendez-vous culturels
                </p>
            </div>
            <a href="{{ route('decouvrir.show', 'evenements') }}" 
               class="btn-secondary px-8 py-3 rounded-full font-bold border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white">
               Tous les événements
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @php
                $evenements = [
                    ['date' => '15 DÉC', 'title' => 'Festival des Rythmes', 'lieu' => 'Cotonou', 'img' => 'images/events/festival-rythmes.jpg'],
                    ['date' => '20 JAN', 'title' => 'Fête des Arts', 'lieu' => 'Abomey', 'img' => 'images/events/fete-des-arts.jpg'],
                    ['date' => '05 FÉV', 'title' => 'Nuit du Conte', 'lieu' => 'Porto-Novo', 'img' => 'images/events/nuit-du-conte.jpg'],
                ];
            @endphp

            @foreach($evenements as $index => $event)
                @php
                    $slugs = ['festival-des-rythmes', 'fete-des-arts', 'nuit-du-conte'];
                    $prices = [5000, 3000, 2000];
                @endphp
                <div class="bg-white rounded-2xl overflow-hidden shadow-xl card-hover">
                    <div class="relative h-48">
                        <img src="{{ asset($event['img']) }}" alt="{{ $event['title'] }}"
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <div class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg">
                                <div class="text-2xl font-bold text-gray-900">{{ $event['date'] }}</div>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <div class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ number_format($prices[$index], 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $event['lieu'] }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $event['title'] }}</h3>
                        <p class="text-gray-600 mb-4">Un événement culturel incontournable avec des performances traditionnelles et modernes.</p>
                        <div class="flex items-center justify-between">
                            <button type="button"
                               data-slug="{{ $slugs[$index] }}"
                               class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition open-payment-modal">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Voir plus</span>
                            </button>
                            <span class="text-sm text-gray-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Paiement requis
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Appel à l'Action Final -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-amber-900/90"></div>
    <div class="absolute inset-0 culture-pattern opacity-10"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
            Contribuez à Préserver le Patrimoine
        </h2>
        <p class="text-xl text-gray-200 mb-10 max-w-3xl mx-auto leading-relaxed">
            Partagez vos connaissances, photos et histoires. Chaque contribution enrichit notre collection collective et aide à préserver la culture béninoise pour les générations futures.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            @auth
                <a href="{{ url('/mes-contenus') }}" 
                   class="px-8 py-4 bg-white text-green-900 rounded-full font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Publier un Contenu
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="px-8 py-4 border-2 border-white text-white rounded-full font-bold text-lg hover:bg-white/10 transition-all duration-300">
                    Se Connecter
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Modal Paiement KKiaPay -->
<div id="payment-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-8 relative">
            <button id="payment-modal-close" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="text-center mb-6">
                <p class="text-sm uppercase tracking-wide text-green-600 font-semibold">Accès Premium</p>
                <h3 class="text-2xl font-bold text-gray-900">Choisissez votre pack</h3>
                <p class="text-gray-600 mt-2">Payez via KKiaPay et débloquez les détails complets de l'événement.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php $packs = [200, 300, 500]; @endphp
                @foreach($packs as $pack)
                    <div class="border-2 border-gray-100 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition cursor-pointer pack-option" data-amount="{{ $pack }}">
                        <p class="text-sm text-gray-500">Pack</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($pack, 0, ',', ' ') }} FCFA</p>
                        <p class="text-xs text-gray-500 mt-2">Accès immédiat après paiement</p>
                        <button type="button" class="mt-4 w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">Payer avec KKiaPay</button>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-gray-500 text-center mt-4">Paiement sécurisé via KKiaPay (MTN, Moov, cartes bancaires).</p>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
// KKiaPay modal & payment
const kkiapayConfig = {
    key: '{{ env('KKIAPAY_PUBLIC_KEY') }}',
    callback: '{{ route('event.payment.kkiapay.callback') }}',
    sandbox: {{ env('KKIAPAY_SANDBOX', true) ? 'true' : 'false' }},
};

let currentEventSlug = null;

function startGastroPayment(title, amount) {
    currentEventSlug = title;
    startKkiapayPayment(amount, { type: 'dish', title, amount });
}

function openPaymentModal(slug) {
    currentEventSlug = slug;
    document.getElementById('payment-modal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('payment-modal').classList.add('hidden');
}

function startKkiapayPayment(amount, meta = null) {
    const payload = meta ?? { type: 'event', event_slug: currentEventSlug, amount };
    openKkiapayWidget({
        amount: amount,
        position: 'center',
        callback: kkiapayConfig.callback,
        data: JSON.stringify(payload),
        theme: '#15803d',
        key: kkiapayConfig.key,
        sandbox: kkiapayConfig.sandbox,
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('payment-modal');
    const closeBtn = document.getElementById('payment-modal-close');
    const packCards = document.querySelectorAll('.pack-option');
    const openButtons = document.querySelectorAll('.open-payment-modal');
    const payGastroButtons = document.querySelectorAll('.pay-gastro');

    openButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const slug = btn.dataset.slug;
            // Démarrer paiement directement pour "Voir plus" avec type event
            currentEventSlug = slug;
            const price = btn.closest('.card-hover')?.querySelector('.bg-green-600.text-white')?.textContent?.replace(/\D/g,'');
            const amount = Number(price || 0);
            if (amount > 0) {
                startKkiapayPayment(amount, { type: 'event', event_slug: slug, amount });
            } else {
                openPaymentModal(slug);
            }
        });
    });

    packCards.forEach(card => {
        card.addEventListener('click', () => {
            const amount = Number(card.dataset.amount || 0);
            if (amount > 0) {
                startKkiapayPayment(amount);
            }
        });
    });

    payGastroButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const amount = Number(btn.dataset.amount || 0);
            const slug = btn.dataset.slug || 'gastronomie';
            if (amount > 0) {
                startGastroPayment(slug, amount);
            }
        });
    });

    closeBtn?.addEventListener('click', closePaymentModal);
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closePaymentModal();
    });

    if (typeof addKkiapayListener === 'function') {
        addKkiapayListener('success', function() {
            closePaymentModal();
            // Rediriger vers la page des événements après succès
            window.location.href = "{{ route('evenements') }}";
        });
        addKkiapayListener('failed', function() {
            alert('Le paiement a échoué. Veuillez réessayer.');
        });
        addKkiapayListener('pending', function() {
            alert('Paiement en cours de traitement.');
        });
    }
});

// Animation des compteurs
document.addEventListener('DOMContentLoaded', function() {
    // Compteurs animés
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const updateCount = () => {
            const count = +counter.innerText;
            const increment = target / speed;
            
            if(count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 10);
            } else {
                counter.innerText = target;
            }
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    updateCount();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });

    // Animation au défilement
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);

    // Observer les éléments à animer
    document.querySelectorAll('.card-hover').forEach(el => {
        observer.observe(el);
    });

    // Carrousel gastronomie avec navigation
    const carousel = document.querySelector('.gastronomie-carousel');
    if (carousel) {
        let isDown = false;
        let startX;
        let scrollLeft;

        carousel.addEventListener('mousedown', (e) => {
            isDown = true;
            carousel.classList.add('active');
            startX = e.pageX - carousel.offsetLeft;
            scrollLeft = carousel.scrollLeft;
        });

        carousel.addEventListener('mouseleave', () => {
            isDown = false;
            carousel.classList.remove('active');
        });

        carousel.addEventListener('mouseup', () => {
            isDown = false;
            carousel.classList.remove('active');
        });

        carousel.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - carousel.offsetLeft;
            const walk = (x - startX) * 2;
            carousel.scrollLeft = scrollLeft - walk;
        });
    }
});

// Effet parallax léger
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector('.hero-gradient');
    if (parallax) {
        parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});
</script>
@endpush

@endsection