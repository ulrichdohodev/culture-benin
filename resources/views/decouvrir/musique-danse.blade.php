@extends('layouts.app')

@section('title', 'Musique & Danse - Culture Bénin')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden min-h-[450px] flex items-center">
    <!-- Vidéo de fond -->
    <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="{{ asset('videos/arriere_hero.mp4') }}" type="video/mp4">
        <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=1600&q=80" alt="Musique et Danse" class="w-full h-full object-cover">
    </video>
    
    <!-- Overlay vert -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-700/85 via-green-600/80 to-green-800/85"></div>
    
    <div class="relative py-16 px-12 text-center text-white w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-extrabold mb-6 drop-shadow-lg text-yellow-300"> Musique & Danse du Bénin</h1>
            <p class="text-xl font-semibold max-w-3xl mx-auto drop-shadow-md text-yellow-100">Rythmes, mouvements et traditions : plongez dans l'univers vibrant de la culture musicale et chorégraphique béninoise.</p>
        </div>
    </div>
</div>

<!-- Navigation rapide -->
<div class="bg-white border-b sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex overflow-x-auto gap-4 py-4">
            <a href="#genres-musicaux" class="whitespace-nowrap px-4 py-2 rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition text-sm font-semibold">Genres musicaux</a>
            <a href="#instruments" class="whitespace-nowrap px-4 py-2 rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition text-sm font-semibold">Instruments</a>
            <a href="#danses" class="whitespace-nowrap px-4 py-2 rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition text-sm font-semibold">Danses traditionnelles</a>
            <a href="#artistes" class="whitespace-nowrap px-4 py-2 rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition text-sm font-semibold">Artistes célèbres</a>
            <a href="#videos" class="whitespace-nowrap px-4 py-2 rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition text-sm font-semibold">Vidéos</a>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

    <!-- Genres musicaux -->
    <section id="genres-musicaux" class="scroll-mt-20">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Genres musicaux béninois</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Du traditionnel au contemporain, découvrez la richesse des styles musicaux du Bénin.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $genres = [
                    [
                        'titre' => 'Agbadja',
                        'description' => 'Rythme traditionnel du peuple Fon, joué lors des cérémonies royales et funérailles. Caractérisé par des percussions puissantes et des chants collectifs.',
                        'region' => 'Sud Bénin (Abomey, Porto-Novo)',
                       
                        'image' => 'https://images.unsplash.com/photo-1528395874238-34ebe249b3f2?auto=format&fit=crop&w=800&q=60'
                    ],
                    [
                        'titre' => 'Tchinkounmè',
                        'description' => 'Musique des chasseurs, rythmée par le tam-tam et les cris guerriers. Célèbre la bravoure et l\'esprit communautaire.',
                        'region' => 'Centre et Nord',
                       
                        'image' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=60'
                    ],
                    [
                        'titre' => 'Zinli',
                        'description' => 'Musique festive des ethnies du Nord, accompagnée de danses acrobatiques. Idéale pour les mariages et célébrations.',
                        'region' => 'Natitingou, Djougou',
                       
                        'image' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?auto=format&fit=crop&w=800&q=60'
                    ],
                    [
                        'titre' => 'Sakpata',
                        'description' => 'Rythmes sacrés liés au culte vodoun de la divinité de la terre. Musique spirituelle profonde.',
                        'region' => 'Ouidah, Abomey',
                    
                        'image' => 'https://images.unsplash.com/photo-1484755560615-a4c64e778a6c?auto=format&fit=crop&w=800&q=60'
                    ],
                    [
                        'titre' => 'Afrobeat béninois',
                        'description' => 'Fusion moderne entre les rythmes traditionnels et le jazz, le funk et le hip-hop. Popularisé par des artistes contemporains.',
                        'region' => 'Cotonou, Porto-Novo',
                      
                        'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=800&q=60'
                    ],
                    [
                        'titre' => 'Gèlèdè',
                        'description' => 'Musique et chants accompagnant les masques gèlèdè lors des cérémonies honorant les mères et les ancêtres.',
                        'region' => 'Kétou, Porto-Novo',
                        
                        'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=60'
                    ],
                ];
            @endphp

            @foreach($genres as $genre)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1">
                    <div class="relative h-48 bg-gradient-to-br from-green-400 to-green-600">
                        <img src="{{ $genre['image'] }}" alt="{{ $genre['titre'] }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $genre['titre'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $genre['description'] }}</p>
                        <div class="flex items-center text-sm text-green-700 bg-green-50 px-3 py-1 rounded-full inline-flex">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            {{ $genre['region'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Instruments traditionnels -->
    <section id="instruments" class="scroll-mt-20 bg-gradient-to-br from-green-50 to-white rounded-3xl p-10">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Instruments traditionnels</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Les instruments qui font vibrer le cœur du Bénin depuis des générations.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $instruments = [
                    ['nom' => 'Djembé', 'description' => 'Tambour en forme de calice, sculpté dans du bois et recouvert de peau de chèvre.', 'image' => 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Gankogui', 'description' => 'Double cloche en métal, joue le rôle de métronome dans les orchestres traditionnels.', 'image' => 'https://images.unsplash.com/photo-1460667262436-cf19894f4774?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Xylophone (Balafon)', 'description' => 'Instrument à lames de bois frappées, typique du Nord-Bénin.', 'image' => 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Flûte peule', 'description' => 'Flûte en bambou utilisée par les bergers peuls pour la musique pastorale.', 'image' => 'https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Akpessè', 'description' => 'Calebasse remplie de graines ou coquillages, secouée rythmiquement.', 'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Kora', 'description' => 'Instrument à cordes pincées, hybride entre la harpe et le luth.', 'image' => 'https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Tambour parlant', 'description' => 'Percussion capable d\'imiter les tonalités de la langue fon, utilisé pour communiquer.', 'image' => 'https://images.unsplash.com/photo-1487180144351-b8472da7d491?auto=format&fit=crop&w=600&q=60'],
                    ['nom' => 'Sanza (Kalimba)', 'description' => 'Piano à pouces avec des lamelles métalliques sur une caisse de résonance.', 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=60'],
                ];
            @endphp

            @foreach($instruments as $instrument)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-xl transition">
                    <div class="relative h-40 bg-gradient-to-br from-green-200 to-green-300">
                        <img src="{{ $instrument['image'] }}" alt="{{ $instrument['nom'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $instrument['nom'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $instrument['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Danses traditionnelles -->
    <section id="danses" class="scroll-mt-20">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Danses traditionnelles</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Chaque danse raconte une histoire, célèbre une tradition ou honore les ancêtres.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @php
                $danses = [
                    [
                        'nom' => 'Danse Agbadja',
                        'description' => 'Danse royale élégante et majestueuse, exécutée lors des cérémonies officielles. Les danseurs portent des tenues traditionnelles richement décorées.',
                        'contexte' => 'Cérémonies royales, funérailles',
                        'video' => asset('videos/arriere_hero.mp4'),
                        'poster' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=1200&q=60'
                    ],
                    [
                        'nom' => 'Danse du Zangbeto',
                        'description' => 'Spectacle mystique où les gardiens de la nuit (masques tournoyants en raphia) dansent pour protéger la communauté.',
                        'contexte' => 'Rituels vodoun, patrouilles nocturnes',
                        'video' => asset('videos/riz.mp4'),
                        'poster' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=60'
                    ],
                    [
                        'nom' => 'Danse Gèlèdè',
                        'description' => 'Danse masquée célébrant les mères et la fertilité. Les masques colorés représentent des personnages comiques ou spirituels.',
                        'contexte' => 'Fêtes des mères, cérémonies communautaires',
                        'video' => 'https://cdn.coverr.co/videos/coverr-african-dance-1051/1080p.mp4',
                        'poster' => 'https://images.unsplash.com/photo-1509099836639-18ba02e2e1ba?auto=format&fit=crop&w=1200&q=60'
                    ],
                    [
                        'nom' => 'Danse Tchinkounmè',
                        'description' => 'Danse guerrière des chasseurs, mêlant acrobaties et pas énergiques au rythme des tambours.',
                        'contexte' => 'Initiations, fêtes de chasse',
                        'video' => 'https://cdn.coverr.co/videos/coverr-culture-drumline-1362/1080p.mp4',
                        'poster' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1200&q=60'
                    ],
                ];
            @endphp

            @foreach($danses as $danse)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="relative">
                        <video class="w-full h-64 object-cover" controls preload="none" poster="{{ $danse['poster'] }}">
                            <source src="{{ $danse['video'] }}" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $danse['nom'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $danse['description'] }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $danse['contexte'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Artistes célèbres -->
    <section id="artistes" class="scroll-mt-20 bg-gradient-to-br from-gray-50 to-green-50 rounded-3xl p-10">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Artistes béninois célèbres</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Les voix et talents qui ont porté la musique béninoise à travers le monde.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $artistes = [
                    [
                        'nom' => 'Angélique Kidjo',
                        'titre' => 'Icône mondiale',
                        'description' => 'Chanteuse de renommée internationale, 5 fois lauréate des Grammy Awards. Ambassadrice de la culture africaine.',
                        'style' => 'World Music, Afrobeat, Jazz',
                        'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=60'
                    ],
                    [
                        'nom' => 'Gnonnas Pedro',
                        'titre' => 'Légende de l\'Afrobeat',
                        'description' => 'Pionnier de l\'Afrobeat béninois, célèbre pour son titre "Feso Jaiye". Guitariste et compositeur prolifique.',
                        'style' => 'Afrobeat, Highlife',
                        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=60'
                    ],
                    [
                        'nom' => 'Zeynab Abib',
                        'titre' => 'Reine du Wassangari',
                        'description' => 'Chanteuse du Nord-Bénin, spécialisée dans le Wassangari, musique traditionnelle des peuples Bariba et Peuls.',
                        'style' => 'Wassangari, Musique traditionnelle',
                        'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=600&q=60'
                    ],
                    [
                        'nom' => 'Sagbohan Danialou',
                        'titre' => 'Maître du Sakpata',
                        'description' => 'Chanteur vodoun, gardien des chants sacrés. Ses performances sont autant spirituelles que musicales.',
                        'style' => 'Musique vodoun, Chants sacrés',
                        'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=60'
                    ],
                    [
                        'nom' => 'Blaaz',
                        'titre' => 'Étoile montante',
                        'description' => 'Artiste contemporain mêlant rap, afrobeat et sonorités traditionnelles. Représentant de la nouvelle génération.',
                        'style' => 'Afrobeat, Rap, Fusion',
                        'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=60'
                    ],
                    [
                        'nom' => 'Sessimè',
                        'titre' => 'Chanteuse engagée',
                        'description' => 'Voix puissante et engagée, défenseure des droits des femmes à travers ses textes et mélodies.',
                        'style' => 'Soul, Afro-soul',
                        'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=60'
                    ],
                ];
            @endphp

            @foreach($artistes as $artiste)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
                    <img src="{{ $artiste['image'] }}" alt="{{ $artiste['nom'] }}" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">{{ $artiste['nom'] }}</h3>
                        <p class="text-sm text-green-600 font-semibold mb-2">{{ $artiste['titre'] }}</p>
                        <p class="text-gray-600 text-sm mb-3">{{ $artiste['description'] }}</p>
                        <div class="text-xs text-gray-500 italic">{{ $artiste['style'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section Vidéos -->
    <section id="videos" class="scroll-mt-20">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Découvrez en vidéo</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Immergez-vous dans l'univers musical et chorégraphique béninois.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <video class="w-full h-64 object-cover" controls poster="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1200&q=60">
                    <source src="{{ asset('videos/arriere_hero.mp4') }}" type="video/mp4">
                </video>
                <div class="p-4">
                    <h3 class="font-bold text-lg">Orchestre traditionnel béninois</h3>
                    <p class="text-sm text-gray-600 mt-2">Performance live mêlant percussions, chants et danses.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <video class="w-full h-64 object-cover" controls poster="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=1200&q=60">
                    <source src="{{ asset('videos/riz.mp4') }}" type="video/mp4">
                </video>
                <div class="p-4">
                    <h3 class="font-bold text-lg">Atelier de fabrication d'instruments</h3>
                    <p class="text-sm text-gray-600 mt-2">Découvrez comment sont fabriqués les djembés et balafons.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to action -->
    <section class="relative rounded-3xl overflow-hidden min-h-[550px] flex items-center">
        <!-- Image de fond -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1600&q=80" alt="Musique" class="w-full h-full object-cover">
        </div>
        
        <!-- Overlay vert -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-700/85 via-green-600/80 to-green-800/85"></div>
        
        <div class="relative py-16 px-12 text-center text-white w-full">
            <div class="max-w-4xl mx-auto">
                <div class="inline-block mb-4">
                    <span class="text-6xl">🎵</span>
                </div>
                <h2 class="text-4xl font-extrabold mb-6 drop-shadow-lg">Vivez l'expérience musicale béninoise</h2>
                <p class="text-xl mb-10 leading-relaxed drop-shadow-md">Assistez aux festivals, ateliers et concerts pour découvrir ces traditions vivantes de vos propres yeux et oreilles. Plongez dans l'authenticité de notre patrimoine culturel.</p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('evenements') }}" class="group px-10 py-4 bg-green-600 text-white rounded-full font-bold shadow-xl hover:bg-green-700 hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Voir les événements
                    </a>
                    <a href="{{ route('contact') }}" class="group px-10 py-4 bg-green-700 text-white rounded-full font-bold shadow-xl hover:bg-green-800 hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
