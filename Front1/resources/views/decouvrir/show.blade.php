@extends('layouts.app')

@section('title', $title ?? 'Découvrir')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(($slug ?? '') === 'art-et-artisanat')
    <header class="mb-10">
      <div class="relative overflow-hidden rounded-2xl text-white">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
          <source src="{{ asset('videos/arriere_hero.mp4') }}" type="video/mp4">
          <img src="{{ asset('images/hero.jpg') }}" alt="Art & Artisanat" class="w-full h-full object-cover">
        </video>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/55 to-black/35"></div>
        <div class="relative px-6 py-12 text-center md:px-12">
          <h1 class="text-3xl md:text-4xl font-extrabold">Art & Artisanat</h1>
          <p class="mt-3 text-base md:text-lg max-w-4xl mx-auto">Découvrez les savoir-faire, artistes et artisans du Bénin : traditions, pratiques contemporaines, musique, vidéos et ressources pour en savoir plus.</p>

          <nav class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="#arts-traditionnels" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Arts traditionnels</a>
            <a href="#textile" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Artisanat du textile</a>
            <a href="#artisanat-regional" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Artisanat régional</a>
            <a href="#musique-instruments" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Art musical</a>
            <a href="#art-contemporain" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Art contemporain</a>
            <a href="#boutique" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Boutique</a>
            <a href="#portraits" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Portraits d'artisans</a>
            <a href="#videos-ateliers" class="text-sm px-3 py-2 bg-white/15 border border-white/20 rounded-full hover:bg-white/25">Vidéos & Ateliers</a>
          </nav>
        </div>
      </div>
    </header>

    <main class="space-y-12">
      <!-- 1. Arts traditionnels -->
      <section id="arts-traditionnels" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Arts traditionnels</h2>
        <p class="mt-2 text-gray-600">Masques, sculptures et bronzes qui racontent l'histoire et la spiritualité du Bénin.</p>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Masques du Danhomè" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Masques du Danhomè</h3>
              <p class="text-sm text-gray-600 mt-2">Signification, cérémonies et typologies des masques.</p>
            </div>
          </article>

          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Sculptures en bois" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Sculptures en bois</h3>
              <p class="text-sm text-gray-600 mt-2">Figures royales, fétiches et techniques de sculpture.</p>
            </div>
          </article>

          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Bronzes d'Abomey" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Bronzes d'Abomey</h3>
              <p class="text-sm text-gray-600 mt-2">Histoire des bronzes royaux et leurs procédés (cire perdue).</p>
            </div>
          </article>

          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Objets royaux" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Objets royaux et historiques</h3>
              <p class="text-sm text-gray-600 mt-2">Conservation et symbolique des objets royaux.</p>
            </div>
          </article>
        </div>

        <div class="mt-4 text-sm text-gray-700">➡️ Photos + explications culturelles</div>
      </section>

      <!-- 2. Textile -->
      <section id="textile" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Artisanat du textile</h2>
        <p class="mt-2 text-gray-600">Kanvo, pagne tissé, batik et tenues traditionnelles (Kaba, Agbada) — perles et accessoires.</p>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="bg-gray-50 p-4 rounded">
            <h3 class="font-semibold">Kanvo (pagne tissé)</h3>
            <p class="text-sm text-gray-600 mt-2">Technique, matériaux et motifs régionaux.</p>
          </div>
          <div class="bg-gray-50 p-4 rounded">
            <h3 class="font-semibold">Batik béninois</h3>
            <p class="text-sm text-gray-600 mt-2">Processus de teinture et motifs traditionnels.</p>
          </div>
        </div>

        <div class="mt-4 text-sm text-gray-700">➡️ Fiches d’artisans + étapes de fabrication</div>
      </section>

      <!-- 3. Artisanat régional -->
      <section id="artisanat-regional" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Artisanat régional</h2>
        <p class="mt-2 text-gray-600">Ce que chaque région met en valeur :</p>
        <ul class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3 text-gray-700">
          <li><strong>Abomey</strong> → sculptures, art royal</li>
          <li><strong>Ouidah</strong> → art vodoun</li>
          <li><strong>Porto-Novo</strong> → artisanat Yoruba</li>
          <li><strong>Nord du Bénin</strong> → calebasses sculptées, cuir, bijoux</li>
        </ul>
      </section>

      <!-- 4. Art musical -->
      <section id="musique-instruments" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Art musical et instruments</h2>
        <p class="mt-2 text-gray-600">Tambours, flûtes, balafon, gankéké et autres instruments traditionnels.</p>

        <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="text-center">
            <img src="{{ asset('images/hero.jpg') }}" class="w-full h-28 object-cover rounded" alt="Tambours">
            <div class="mt-2 text-sm">Tambours (Talking drum, djembé…)</div>
          </div>
          <div class="text-center">
            <img src="{{ asset('images/hero.jpg') }}" class="w-full h-28 object-cover rounded" alt="Flûtes">
            <div class="mt-2 text-sm">Flûtes traditionnelles</div>
          </div>
          <div class="text-center">
            <img src="{{ asset('images/hero.jpg') }}" class="w-full h-28 object-cover rounded" alt="Balafon">
            <div class="mt-2 text-sm">Balafon</div>
          </div>
          <div class="text-center">
            <img src="{{ asset('images/hero.jpg') }}" class="w-full h-28 object-cover rounded" alt="Gong">
            <div class="mt-2 text-sm">Gong (gankéké)</div>
          </div>
        </div>

        <div class="mt-4 text-sm text-gray-700">➡️ Peut être relié à la page Musique</div>
      </section>

      <!-- 5. Art contemporain -->
      <section id="art-contemporain" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Art contemporain</h2>
        <p class="mt-2 text-gray-600">Peintres, photographes, sculpteurs modernes, design et mode béninoise.</p>
        <div class="mt-4 text-sm text-gray-700">➡️ Portraits d’artistes actuels</div>
      </section>

      <!-- 6. Boutique -->
      <section id="boutique" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Espace Boutique (optionnel)</h2>
        <p class="mt-2 text-gray-600">Exposition des œuvres, vente en ligne, commandes personnalisées.</p>
      </section>

      <!-- 7. Portraits d'artisans -->
      <section id="portraits" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Portraits d’Artisans</h2>
        <p class="mt-2 text-gray-600">Mettre en avant le nom de l’artisan, son atelier, son histoire, ses œuvres.</p>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
          <a href="{{ route('artisans') }}" class="block bg-gray-50 rounded p-4 text-center">Voir les artisans</a>
        </div>
      </section>

      <!-- 8. Vidéos & Ateliers -->
      <section id="videos-ateliers" class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold">Vidéos & Ateliers</h2>
        <p class="mt-2 text-gray-600">Démonstrations : fabrication du kanvo, sculpture sur bois, reportages culturels.</p>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Vidéo kanvo" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Démonstration : Kanvo</h3>
            </div>
          </article>
          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Sculpture" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Sculpture en direct</h3>
            </div>
          </article>
          <article class="bg-gray-50 rounded overflow-hidden">
            <img src="{{ asset('images/hero.jpg') }}" alt="Reportage" class="w-full h-40 object-cover">
            <div class="p-4">
              <h3 class="font-semibold">Reportages culturels</h3>
            </div>
          </article>
        </div>
      </section>
    </main>

    @else
      <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-extrabold text-gray-900">{{ $title }}</h1>
        <p class="mt-4 text-gray-600">Page de découverte temporaire pour "{{ $title }}" — contenu à venir. Vous pouvez retourner à la <a href="{{ route('accueil') }}" class="text-yellow-600 hover:underline">page d'accueil</a> ou explorer d'autres sections.</p>

        <div class="mt-6">
          <a href="{{ route('accueil') }}" class="inline-block px-4 py-2 rounded bg-yellow-500 text-white">Retour à l'accueil</a>
        </div>
      </div>
    @endif
  </div>
@endsection
