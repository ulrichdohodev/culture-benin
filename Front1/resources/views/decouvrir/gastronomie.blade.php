@extends('layouts.app')

@section('title', 'Gastronomie du Bénin')

@section('content')

<section class="relative overflow-hidden">
  <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline poster="{{ asset('images/hero.jpg') }}" aria-hidden="true">
    <source src="{{ asset('videos/arriere_hero.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <div class="absolute inset-0 bg-black/30"></div>

  <div class="relative max-w-7xl mx-auto px-4 min-h-screen flex items-center">
    <div class="w-full text-center z-20">
      <h1 class="text-5xl sm:text-6xl font-extrabold text-white drop-shadow-lg">Les saveurs du Bénin</h1>
      <p class="mt-4 text-lg max-w-3xl mx-auto text-gray-100/90 drop-shadow">Découvrez les plats traditionnels, ingrédients et boissons qui font la richesse culinaire du Bénin.</p>
    </div>
  </div>
</section>

<div class="max-w-7xl mx-auto px-4 py-12 space-y-12">

  <!-- Plats populaires -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Plats traditionnels</h2>
    <p class="text-gray-600 mt-2">Cliquez sur une carte pour voir la recette et commander.</p>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @php
        $plats = [
          ['slug'=>'amiwo','title'=>'Amiwo','img'=>asset('images/amiwo.jpg'),'price'=>2500],
          ['slug'=>'wassa-wassa','title'=>'Wassa-Wassa','img'=>asset('images/wassa.jpg'),'price'=>2000],
          ['slug'=>'to','title'=>'Tô / Pâte de maïs','img'=>asset('images/to.jpg'),'price'=>2200],
          ['slug'=>'sauce-gombo','title'=>'Sauce Gombo','img'=>asset('images/gombo.jpg'),'price'=>1800],
          ['slug'=>'atassi','title'=>'Atassi','img'=>asset('images/atassi.jpg'),'price'=>2400],
          ['slug'=>'akassa','title'=>'Gari','img'=>asset('images/gari.jpg'),'price'=>3000],
        ];
      @endphp

      @foreach($plats as $plat)
      <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-2xl transition-shadow duration-300 relative focus-within:ring-4 focus-within:ring-green-100">
        <div class="w-full h-40 overflow-hidden bg-gray-100">
          <img src="{{ $plat['img'] }}" alt="{{ $plat['title'] }}" class="w-full h-full object-cover transform transition-transform duration-400 hover:scale-105">
        </div>

        <div class="absolute top-3 right-3 bg-green-600 text-white px-3 py-1 rounded-md text-sm font-semibold shadow">{{ number_format($plat['price'],0,',',' ') }} FCFA</div>

        <div class="p-4 pt-5">
          <h3 class="font-semibold text-gray-800 text-lg">{{ $plat['title'] }}</h3>
          <p class="text-sm text-gray-600 mt-2">Description courte du plat {{ $plat['title'] }} — ingrédients et accompagnements typiques.</p>

          <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-500">Portion traditionnelle</div>
            <div class="flex items-center gap-2">
              <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded bg-green-600 text-white text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-200 add-to-cart" data-slug="{{ $plat['slug'] }}" data-title="{{ $plat['title'] }}" data-price="{{ $plat['price'] }}" aria-label="Ajouter {{ $plat['title'] }} au panier">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M16 11V7a1 1 0 00-1-1H6V5a3 3 0 00-3 3v6a3 3 0 003 3h8a3 3 0 003-3v-2a1 1 0 10-2 0v2a1 1 0 01-1 1H6a1 1 0 01-1-1V9h9a1 1 0 001-1z"/></svg>
                Ajouter
              </button>

              <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded border border-green-600 text-green-700 bg-white text-sm font-medium hover:bg-green-50 focus:outline-none view-recipe" data-title="{{ $plat['title'] }}" aria-label="Voir la recette de {{ $plat['title'] }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h8a2 2 0 012 2v4h2V5a4 4 0 00-4-4H4a4 4 0 00-4 4v10a2 2 0 002 2h6v-2H4a0 0 0 01-0-0V5z"/><path d="M14 9h-3a1 1 0 00-1 1v6h8v-6a1 1 0 00-1-1h-3z"/></svg>
                Découvrir
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- Soupes & sauces -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Soupes & Sauces</h2>
    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="p-4 bg-white rounded shadow">
        <h3 class="font-semibold">Sauce arachide</h3>
        <p class="text-sm text-gray-600 mt-2">Riche et onctueuse, préparée selon les régions avec parfois du poisson fumé.</p>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h3 class="font-semibold">Sauce tomate</h3>
        <p class="text-sm text-gray-600 mt-2">Base tomate, oignon, épices locales — accompagnement courant du riz et du tô.</p>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h3 class="font-semibold">Sauce légumes (feuilles)</h3>
        <p class="text-sm text-gray-600 mt-2">Feuilles locales (gboman...) mijotées avec ingrédients locaux.</p>
      </div>
    </div>
  </section>

  <!-- Ingrédients & épices -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Ingrédients locaux & épices</h2>
    <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
      <div class="bg-white rounded p-4 text-center">
        <div class="font-semibold">Piment béninois</div>
        <div class="text-sm text-gray-600 mt-1">Utilisé frais ou séché, central dans de nombreuses recettes.</div>
      </div>
      <div class="bg-white rounded p-4 text-center">
        <div class="font-semibold">Gombos</div>
        <div class="text-sm text-gray-600 mt-1">Épaississant naturel, saveur caractéristique.</div>
      </div>
      <div class="bg-white rounded p-4 text-center">
        <div class="font-semibold">Arachides</div>
        <div class="text-sm text-gray-600 mt-1">Base pour sauces, riches en protéines.</div>
      </div>
      <div class="bg-white rounded p-4 text-center">
        <div class="font-semibold">Maïs, manioc, igname</div>
        <div class="text-sm text-gray-600 mt-1">Céréales et tubercules essentiels de la base alimentaire.</div>
      </div>
    </div>
  </section>

  <!-- Boissons -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Boissons traditionnelles</h2>
    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="bg-white rounded p-4 border border-green-100">
        <h3 class="font-semibold">Tchakpalo</h3>
        <p class="text-sm text-gray-600 mt-2">Bière locale fermentée, souvent consommée lors de rencontres sociales.</p>
      </div>
      <div class="bg-white rounded p-4 border border-green-100">
        <h3 class="font-semibold">Sodabi</h3>
        <p class="text-sm text-gray-600 mt-2">Spiritueux de palme, employé lors de cérémonies et festivités.</p>
      </div>
    </div>
  </section>

  <!-- Recettes & ateliers -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Recettes & Ateliers</h2>
    <p class="text-gray-600 mt-2">Apprenez avec des recettes illustrées et vidéos.</p>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-white rounded p-4">
        <h4 class="font-semibold">Recette : Amiwo</h4>
        <p class="text-sm text-gray-600 mt-2">Étapes simplifiées pour préparer l'Amiwo chez vous.</p>
        <button class="mt-3 px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700 view-recipe">Voir la recette</button>
      </div>
      <div class="bg-white rounded p-4">
        <h4 class="font-semibold">Atelier : Tô & sauces</h4>
        <p class="text-sm text-gray-600 mt-2">Atelier en ligne / présentiel pour apprendre les bases.</p>
        <button class="mt-3 px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700">S'inscrire</button>
      </div>
      <div class="bg-white rounded p-4">
        <h4 class="font-semibold">Vidéos de préparation</h4>
        <p class="text-sm text-gray-600 mt-2">Courtes vidéos montrant les techniques et astuces locales.</p>
      </div>
    </div>
  </section>

  <!-- Regions & specialites -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Régions & spécialités</h2>
    <p class="text-gray-600 mt-2">Carte et spécialités locales.</p>
    <div class="mt-4 bg-white rounded p-6">
      <img src="{{ asset('images/map-placeholder.png') }}" alt="Carte du Bénin" class="w-full h-56 object-cover rounded">
      <div class="mt-3 text-sm text-gray-600">Nord: Wassa-wassa • Sud: Akassa • Centre: Pâte & sauces variées</div>
    </div>
  </section>

  <!-- Espace produit - commandes -->
  <section class="bg-green-50 rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Commander & Payer</h2>
    <p class="text-gray-600 mt-2">Sélectionnez des plats, ajoutez au panier et passez à la caisse.</p>

    <div class="mt-4 bg-white rounded p-6">
      <div id="cart" class="space-y-3">
        <div class="text-sm text-gray-600">Panier vide.</div>
      </div>

      <div class="mt-4 flex gap-3">
        <button id="checkout-btn" class="px-4 py-2 rounded bg-green-600 text-white" disabled>Passer à la caisse</button>
      </div>
    </div>
  </section>

</div>

<!-- Modal / scripts -->
@push('scripts')
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
  // KKiaPay configuration
  const kkiapayConfig = {
    key: '{{ env('KKIAPAY_PUBLIC_KEY') }}',
    callback: '{{ url('/kkiapay/callback') }}',
    sandbox: {{ env('KKIAPAY_SANDBOX', true) ? 'true' : 'false' }},
  };

  // Simple cart implementation
  const plats = {};
  document.querySelectorAll('.add-to-cart').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const slug = btn.dataset.slug;
      const title = btn.dataset.title;
      const price = Number(btn.dataset.price || 0);
      if(!plats[slug]) plats[slug] = {slug, title, price, qty:0};
      plats[slug].qty++;
      renderCart();
    });
  });

  function renderCart(){
    const cart = document.getElementById('cart');
    cart.innerHTML = '';
    const keys = Object.keys(plats);
    if(!keys.length){
      cart.innerHTML = '<div class="text-sm text-gray-600">Panier vide.</div>';
      document.getElementById('checkout-btn').disabled = true;
      return;
    }
    let total = 0;
    keys.forEach(k=>{
      const it = plats[k];
      total += it.price * it.qty;
      const row = document.createElement('div');
      row.className = 'flex items-center justify-between';
      row.innerHTML = `<div>${it.title} × ${it.qty}</div><div class="font-bold text-green-600">${it.price*it.qty} FCFA</div>`;
      cart.appendChild(row);
    });
    const line = document.createElement('div');
    line.className = 'mt-2 pt-2 border-t flex items-center justify-between';
    line.innerHTML = `<div class="font-semibold">Total</div><div class="font-bold text-lg text-green-600">${total} FCFA</div>`;
    cart.appendChild(line);
    document.getElementById('checkout-btn').disabled = false;
  }

  function startGastroPayment(total){
    if(!total || total <= 0){
      return alert('Votre panier est vide.');
    }
    if(typeof openKkiapayWidget !== 'function'){
      return alert('Le module de paiement KKiaPay ne s\'est pas chargé.');
    }
    const items = Object.values(plats).map(p=>({slug:p.slug,title:p.title,price:p.price,qty:p.qty}));
    openKkiapayWidget({
      amount: total,
      position: 'center',
      callback: kkiapayConfig.callback,
      data: JSON.stringify({ source: 'gastronomie', items }),
      theme: '#15803d',
      key: kkiapayConfig.key,
      sandbox: kkiapayConfig.sandbox,
    });
  }

  const checkoutBtn = document.getElementById('checkout-btn');
  checkoutBtn.addEventListener('click', ()=>{
    if(Object.keys(plats).length === 0){
      return alert('Votre panier est vide.');
    }
    const total = Object.values(plats).reduce((s,it)=>s + it.price*it.qty, 0);
    startGastroPayment(total);
  });
</script>
@endpush

@endsection
