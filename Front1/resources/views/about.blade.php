@extends('layouts.app')

@section('title','À propos')

@section('content')
    <section class="bg-emerald-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white">À propos de Culture Bénin</h1>
                    <p class="mt-4 text-gray-100 max-w-xl">Nous préservons et mettons en valeur le patrimoine culturel vivant du Bénin — savoir-faire, musiques, danses, gastronomie et événements. Notre objectif est de rapprocher les communautés locales et les visiteurs par des contenus authentiques et des initiatives participatives.</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ url('/communaute') }}" class="inline-flex items-center px-4 py-2 rounded bg-green-600 text-white font-semibold">Rejoindre la communauté</a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 rounded border border-gray-200 text-gray-700">Contact</a>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ asset('images/about-hero.jpg') }}" alt="Culture Bénin" class="w-full h-64 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-[#fbfbf9]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">
                <h2 class="text-2xl font-semibold">Notre mission</h2>
                <p class="mt-3 text-gray-700">Culture Bénin vise à préserver, valoriser et partager le patrimoine culturel du Bénin via des contenus multimédias, des ateliers, des événements et une communauté active d'acteurs et de passionnés.</p>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <h3 class="font-semibold">Visites & Galeries</h3>
                        <p class="text-sm text-gray-600">Expériences immersives et galeries pour découvrir les pratiques et les artisans.</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-semibold">Ateliers</h3>
                        <p class="text-sm text-gray-600">Rencontres, formations et sessions pratiques avec les artisans locaux.</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-semibold">Ressources</h3>
                        <p class="text-sm text-gray-600">Articles, interviews et contenus éducatifs pour tous les publics.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-[#fbfbf9]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-extrabold">Quelques chiffres</h3>
                <p class="text-gray-600 mt-2">Données live depuis la base (chargées à l'affichage)</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="cb-stat-card bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Contenus</div>
                    <div id="stat-contenus" class="mt-2 text-2xl font-bold">0</div>
                </div>
                <div class="cb-stat-card bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Régions</div>
                    <div id="stat-regions" class="mt-2 text-2xl font-bold">0</div>
                </div>
                <div class="cb-stat-card bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Langues</div>
                    <div id="stat-langues" class="mt-2 text-2xl font-bold">0</div>
                </div>
                <div class="cb-stat-card bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Utilisateurs</div>
                    <div id="stat-utilisateurs" class="mt-2 text-2xl font-bold">0</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-extrabold">L'équipe</h3>
                <p class="text-gray-600 mt-2">Quelques membres qui travaillent derrière Culture Bénin.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <article class="bg-white p-6 rounded-lg shadow text-center">
                    <img src="{{ asset('images/team-alice.jpg') }}" alt="" class="w-24 h-24 rounded-full mx-auto object-cover">
                    <h4 class="mt-4 font-semibold">A. Bankole</h4>
                    <p class="text-sm text-gray-600">Coordination & patrimoine</p>
                </article>
                <article class="bg-white p-6 rounded-lg shadow text-center">
                    <img src="{{ asset('images/team-benin.jpg') }}" alt="" class="w-24 h-24 rounded-full mx-auto object-cover">
                    <h4 class="mt-4 font-semibold">M. Kpatcha</h4>
                    <p class="text-sm text-gray-600">Contenus & rédaction</p>
                </article>
                <article class="bg-white p-6 rounded-lg shadow text-center">
                    <img src="{{ asset('images/team-celeste.jpg') }}" alt="" class="w-24 h-24 rounded-full mx-auto object-cover">
                    <h4 class="mt-4 font-semibold">S. Djima</h4>
                    <p class="text-sm text-gray-600">Développement & technique</p>
                </article>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
// Fetch /stats and populate counters (once when section is visible)
(function(){
    const heading = document.querySelector('section.py-12.bg-gray-50');
    if(!heading) return;
    let done = false;
    const animate = (el, to) => {
        return new Promise(resolve=>{
            const start = Number(el.textContent.replace(/\\s|\\u202F|\\u00A0/g,'') ) || 0;
            const dur = 900; const t0 = performance.now();
            const step = (t) => {
                const p = Math.min(1,(t-t0)/dur);
                const val = Math.round(start + (to-start) * p);
                el.textContent = val.toLocaleString();
                if(p<1) requestAnimationFrame(step); else resolve();
            };
            requestAnimationFrame(step);
        });
    };

    const obs = new IntersectionObserver((entries, o)=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting && !done){
                done = true;
                fetch('{{ route('stats') }}', {credentials:'same-origin'}).then(r=>r.json()).then(data=>{
                    ['contenus','regions','langues','utilisateurs'].forEach(k=>{
                        const mapping = {contenus:'stat-contenus', regions:'stat-regions', langues:'stat-langues', utilisateurs:'stat-utilisateurs'};
                        const el = document.getElementById(mapping[k]);
                        if(el) animate(el, Number(data[k]||0));
                    });
                }).catch(()=>{});
                o.disconnect();
            }
        });
    }, {threshold:0.2});
    obs.observe(heading);
})();
</script>
@endpush
