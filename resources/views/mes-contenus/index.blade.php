@extends('layouts.guest')

@section('content')
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-extrabold text-amber-700">Mes contenus</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('accueil') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">Retour à l'accueil</a>
                <a href="{{ route('contenus.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Créer un contenu</a>
            </div>
        </div>

        @php
            $userVideos = collect();
            if(auth()->check()){
                try {
                    $userVideos = \App\Models\Media::where('uploader_id', auth()->id())
                        ->where('mime', 'like', 'video%')
                        ->orderBy('created_at', 'desc')
                        ->get();
                } catch (Exception $e) {
                    $userVideos = collect();
                }
            }
        @endphp

        @if($userVideos->isNotEmpty())
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-amber-800 mb-3">Vos vidéos uploadées</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($userVideos as $uMedia)
                        <div class="bg-white border rounded-lg p-3">
                            <video controls class="w-full rounded mb-2">
                                <source src="{{ asset('storage/' . ($uMedia->fichier ?? $uMedia->chemin ?? '')) }}" type="{{ $uMedia->mime ?? 'video/mp4' }}">
                                Votre navigateur ne supporte pas la lecture vidéo.
                            </video>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <div class="truncate">{{ $uMedia->titre ?? basename($uMedia->fichier ?? $uMedia->chemin ?? '') }}</div>
                                <div>
                                    <button type="button" class="media-delete-btn p-2 text-red-600 rounded hover:bg-red-50" data-url="{{ route('media.user.destroy', $uMedia) }}" aria-label="Supprimer la vidéo">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 100 2h14a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 6a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($contenus->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-amber-300 p-4 rounded">
                <p class="text-amber-800">Vous n'avez pas encore publié de contenu. Commencez par <a href="{{ route('contenus.create') }}" class="underline font-medium">proposer un contenu</a>.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($contenus as $contenu)
                    <article class="bg-gradient-to-br from-amber-50 to-white border border-amber-100 rounded-xl shadow-md p-6">
                        <h3 class="text-xl font-semibold text-amber-800 mb-2">{{ $contenu->titre }}</h3>

                        {{-- Video preview(s) if present and supported by DB schema --}}
                        @if(!empty($mediasSupported) && $mediasSupported && $contenu->medias && $contenu->medias->isNotEmpty())
                            <div class="mb-4">
                                @foreach($contenu->medias as $media)
                                    @php
                                        $mediaMime = $media->mime ?? $media->type_fichier ?? '';
                                        $path = $media->fichier ?? $media->chemin ?? null;
                                    @endphp

                                    @if($path && strpos($mediaMime, 'video') === 0)
                                        <div class="mb-3">
                                            <video controls class="w-full rounded">
                                                <source src="{{ asset('storage/' . $path) }}" type="{{ $mediaMime ?: 'video/mp4' }}">
                                                Votre navigateur ne supporte pas la lecture vidéo.
                                            </video>
                                            <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
                                                <div class="">{{ $media->titre ?? basename($path) }}</div>
                                                <div class="flex items-center gap-2">
                                                    {{-- Delete button for the uploader --}}
                                                    @if(auth()->check() && auth()->id() === $media->uploader_id)
                                                        <button type="button" class="media-delete-btn p-2 text-red-600 rounded hover:bg-red-50" data-url="{{ route('media.user.destroy', $media) }}" aria-label="Supprimer la vidéo">
                                                            <span class="sr-only">Supprimer la vidéo</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 100 2h14a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 6a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" /></svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <p class="text-sm text-gray-500 mb-3">@if($contenu->region) Région : {{ $contenu->region->nom_region }} @endif @if($contenu->typeContenu) • Type : {{ $contenu->typeContenu->nom_type }} @endif</p>
                        <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($contenu->texte), 220) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div>Statut : {{ ucfirst($contenu->statut ?? '—') }} @if(($contenu->statut ?? '') !== 'valide') <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">En attente de validation</span> @endif</div>
                            <div>{{ optional($contenu->date_creation)->format('d/m/Y') ?? '' }}</div>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                <a href="{{ route('admin.contenus.show', $contenu) }}" class="inline-flex items-center px-3 py-1 bg-amber-600 text-white rounded hover:bg-amber-700">Voir</a>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button" class="contenu-delete-btn p-2 bg-red-600 text-white rounded hover:bg-red-700" data-url="{{ route('mes-contenus.destroy', $contenu) }}" data-id="{{ $contenu->id_contenu }}" aria-label="Supprimer le contenu">
                                    <span class="sr-only">Supprimer</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 100 2h14a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 6a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $contenus->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
(function(){
    const csrf = '{{ csrf_token() }}';

    function showToast(message, type='success'){
        const id = 'toast-' + Date.now();
        const el = document.createElement('div');
        el.id = id;
        el.className = 'fixed right-4 bottom-6 z-50 px-4 py-2 rounded shadow-lg text-white ' + (type==='error' ? 'bg-red-600' : 'bg-green-600');
        el.textContent = message;
        document.body.appendChild(el);
        setTimeout(()=>{ el.classList.add('opacity-0'); }, 3000);
        setTimeout(()=>{ el.remove(); }, 3600);
    }

    function removeCardById(id){
        const btn = document.querySelector('[data-id="'+id+'"]');
        if(!btn) return;
        const article = btn.closest('article');
        if(!article) return;
        article.style.transition = 'opacity 350ms, transform 350ms';
        article.style.opacity = '0';
        article.style.transform = 'translateY(-8px)';
        setTimeout(()=> article.remove(), 380);
    }

    // Handle contenu delete
    document.querySelectorAll('.contenu-delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e){
            if(!confirm('Supprimer ce contenu ? Cette action est irréversible.')) return;
            const url = this.dataset.url;
            const id = this.dataset.id;
            const old = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Suppression...';

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            }).then(r => r.json())
            .then(json => {
                if(json && json.success){
                    showToast(json.message || 'Contenu supprimé.');
                    removeCardById(id);
                } else {
                    showToast('Erreur lors de la suppression.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = old;
                }
            }).catch(err => {
                showToast('Erreur réseau.', 'error');
                btn.disabled = false;
                btn.innerHTML = old;
            });
        });
    });

    // Handle media delete
    document.querySelectorAll('.media-delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e){
            if(!confirm('Supprimer cette vidéo ?')) return;
            const url = this.dataset.url;
            const old = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Suppression...';

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            }).then(r => r.json())
            .then(json => {
                if(json && json.success){
                    showToast(json.message || 'Vidéo supprimée.');
                    // remove the video container (try common wrapper selectors)
                    const container = btn.closest('div.mb-3') || btn.closest('div.bg-white') || btn.closest('div');
                    if(container){
                        container.style.transition = 'opacity 300ms, height 300ms';
                        container.style.opacity = '0';
                        setTimeout(()=> container.remove(), 320);
                    }
                } else {
                    showToast('Erreur lors de la suppression.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = old;
                }
            }).catch(err => {
                showToast('Erreur réseau.', 'error');
                btn.disabled = false;
                btn.innerHTML = old;
            });
        });
    });

})();
</script>
@endpush
