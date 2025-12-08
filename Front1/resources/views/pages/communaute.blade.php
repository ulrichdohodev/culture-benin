@extends('layouts.app')

@section('title', 'Communauté - Culture Bénin')

@section('content')

<!-- Hero -->
<section class="relative bg-gray-900">
    <img src="{{ asset('images/hero.jpg') }}" alt="Communauté" class="absolute inset-0 w-full h-full object-cover opacity-30">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center text-white">
            <h1 class="text-4xl sm:text-5xl font-extrabold">Présentation de la Communauté</h1>
            <p class="mt-4 text-lg max-w-2xl mx-auto">Rejoignez une communauté dédiée à la valorisation de la culture béninoise : partage, entraide, événements et créations autour de notre patrimoine.</p>

            <div class="mt-8 flex justify-center gap-4">
                @guest
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 rounded-md bg-amber-500 text-white font-semibold">Rejoindre</a>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 rounded-md bg-white/10 text-white font-medium">S'inscrire</a>
                @else
                <a href="{{ route('communaute') }}" class="inline-flex items-center px-6 py-3 rounded-md bg-amber-500 text-white font-semibold">Mon espace</a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Main layout -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

  <!-- Discussions récentes -->
  <section class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start justify-between">
      <div>
        <h2 class="text-2xl font-semibold">2️⃣ Espace d’échanges</h2>
        <p class="mt-2 text-gray-600">Discussions sur les arts, partage de photos, questions/réponses sur traditions et festivals.</p>
      </div>
      <div class="text-sm text-gray-500">Categories: Musique · Artisanat · Gastronomie</div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      @if(isset($featured) && $featured->count())
        @foreach($featured->take(4) as $post)
        <article class="p-4 border rounded hover:shadow">
          <div class="flex items-start gap-3">
            <div class="w-12 h-12 bg-amber-100 rounded flex items-center justify-center text-amber-600 font-bold">{{ strtoupper(substr($post->titre ?? 'P',0,1)) }}</div>
            <div>
              <a href="{{ url('/contenu/'.$post->id) }}" class="font-semibold text-gray-900">{{ \Illuminate\Support\Str::limit($post->titre ?? 'Publication', 60) }}</a>
              <div class="text-sm text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit(strip_tags($post->description ?? $post->texte ?? ''), 120) }}</div>
              <div class="mt-2 text-xs text-gray-400">{{ $post->typeContenu->nom_contenu ?? 'Contenu' }} · {{ $post->created_at ? $post->created_at->diffForHumans() : '' }}</div>
            </div>
          </div>
        </article>
        @endforeach
      @else
        @for($i=0;$i<4;$i++)
        <article class="p-4 border rounded hover:shadow">
          <div class="flex items-start gap-3">
            <div class="w-12 h-12 bg-amber-100 rounded flex items-center justify-center text-amber-600 font-bold">P{{ $i+1 }}</div>
            <div>
              <a href="#" class="font-semibold text-gray-900">Titre de la discussion {{ $i+1 }}</a>
              <div class="text-sm text-gray-500 mt-1">Court extrait du message ou question posée par un membre — échanges et réponses attendues.</div>
              <div class="mt-2 text-xs text-gray-400">Musique · 12 réponses · il y a 2 jours</div>
            </div>
          </div>
        </article>
        @endfor
      @endif
    </div>
  </section>

  <!-- Artisans de la semaine -->
  <section class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold">3️⃣ Artisans de la semaine</h2>
    <p class="mt-2 text-gray-600">Portraits rapides d'artisans actifs et remarqués par la communauté.</p>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
      @if(isset($artisans) && $artisans->count())
        @foreach($artisans->take(3) as $artisan)
        <a href="{{ route('artisans') }}" class="block bg-gray-50 rounded p-4 text-center hover:shadow">
          <img src="{{ $artisan->image ?? asset('images/hero.jpg') }}" alt="{{ $artisan->nom ?? 'Artisan' }}" class="w-32 h-32 object-cover rounded-full mx-auto">
          <div class="mt-3 font-semibold">{{ $artisan->nom ?? ($artisan->full_name ?? 'Artisan') }}</div>
          <div class="text-sm text-gray-500">{{ $artisan->metier ?? $artisan->role ?? '' }} · {{ $artisan->region ?? '' }}</div>
        </a>
        @endforeach
      @else
        @for($i=0;$i<3;$i++)
        <a href="{{ route('artisans') }}" class="block bg-gray-50 rounded p-4 text-center hover:shadow">
          <img src="{{ asset('images/hero.jpg') }}" alt="Artisan" class="w-32 h-32 object-cover rounded-full mx-auto">
          <div class="mt-3 font-semibold">Artisan {{ $i+1 }}</div>
          <div class="text-sm text-gray-500">Tisserand · Abomey</div>
        </a>
        @endfor
      @endif
    </div>
  </section>

  <!-- Contributions en vedette -->
  <section class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold">4️⃣ Contributions en vedette</h2>
    <p class="mt-2 text-gray-600">Articles, témoignages et récits mis en avant par l'équipe.</p>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
      @if(isset($featured) && $featured->count())
        @foreach($featured->take(3) as $item)
        <article class="bg-gray-50 rounded overflow-hidden">
          <img src="{{ $item->poster_url ?? asset('images/hero.jpg') }}" alt="{{ $item->titre ?? 'Article' }}" class="w-full h-40 object-cover">
          <div class="p-4">
            <h3 class="font-semibold">{{ $item->titre ?? 'Publication' }}</h3>
            <p class="text-sm text-gray-500 mt-2">{{ \Illuminate\Support\Str::limit(strip_tags($item->description ?? $item->texte ?? ''), 120) }}</p>
          </div>
        </article>
        @endforeach
      @else
        @for($i=0;$i<3;$i++)
        <article class="bg-gray-50 rounded overflow-hidden">
          <img src="{{ asset('images/hero.jpg') }}" alt="Article" class="w-full h-40 object-cover">
          <div class="p-4">
            <h3 class="font-semibold">Titre d'article {{ $i+1 }}</h3>
            <p class="text-sm text-gray-500 mt-2">Extrait du récit ou témoignage partagé par un membre.</p>
          </div>
        </article>
        @endfor
      @endif
    </div>
  </section>

  <!-- Activités & Groupes -->
  <section class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold">5️⃣ Activités de la communauté</h2>
    <p class="mt-2 text-gray-600">Groupes d’intérêt, événements participatifs, concours photo et sorties culturelles.</p>

    <div class="mt-4 flex gap-3 flex-wrap">
      <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded">Vodoun</span>
      <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded">Danse</span>
      <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded">Textile</span>
      <span class="px-3 py-1 bg-sky-100 text-sky-700 rounded">Tourisme</span>
    </div>
  </section>

  <!-- Newsletter & Réseaux sociaux -->
  <section class="bg-white rounded-lg shadow p-6">
    <div class="md:flex md:items-center md:justify-between">
      <div>
        <h2 class="text-2xl font-semibold">6️⃣ Newsletter & Réseaux sociaux</h2>
        <p class="mt-2 text-gray-600">Abonnez-vous pour recevoir les nouveautés et événements culturels.</p>
      </div>

      <div class="mt-4 md:mt-0 flex items-center gap-3">
        <input id="newsletter-email" type="email" placeholder="Votre adresse email" class="px-4 py-2 border rounded w-64" />
        <button id="newsletter-cta" class="px-4 py-2 rounded bg-amber-500 text-white">S'abonner</button>
        <div class="ml-4 flex gap-2">
          <a href="#" class="w-9 h-9 bg-blue-600 text-white rounded flex items-center justify-center">f</a>
          <a href="#" class="w-9 h-9 bg-pink-500 text-white rounded flex items-center justify-center">IG</a>
          <a href="#" class="w-9 h-9 bg-sky-500 text-white rounded flex items-center justify-center">T</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Règles & Charte -->
  <section class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold">7️⃣ Règles & Charte de la communauté</h2>
    <ul class="mt-3 list-disc ml-5 text-gray-700">
      <li>Respect des traditions et des personnes.</li>
      <li>Ne pas diffuser de contenu offensant.</li>
      <li>Valoriser les créateurs locaux et citer les sources.</li>
    </ul>
    <div class="mt-4 text-sm text-gray-600">🌟 Bonus: système de likes, badges et vérification possible pour artisans.</div>
  </section>

</div>

@push('scripts')
<script>
document.getElementById('newsletter-cta')?.addEventListener('click', async function(){
  const input = document.getElementById('newsletter-email');
  if(!input || !input.value || !/.+@.+\..+/.test(input.value)){
    return alert('Veuillez entrer une adresse email valide.');
  }

  try{
    const res = await fetch('{{ route('newsletter.subscribe') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ email: input.value })
    });

    if(res.ok){
      alert('Merci ! Vous êtes inscrit(e).');
      input.value = '';
    } else {
      const json = await res.json().catch(()=>({}));
      alert('Erreur lors de l inscription. Réessayez plus tard.');
      console.error('Subscribe failed', json);
    }
  }catch(err){
    console.error(err);
    alert('Erreur réseau.');
  }
});
</script>
@endpush

@endsection
