@extends('layouts.guest')

@section('content')
    <div>
        <h2 class="text-3xl font-bold mb-6">Proposer un contenu</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contenus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="titre" class="mt-1 block w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Importer une vidéo (optionnel)</label>
                <input type="file" name="video" accept="video/*" class="mt-1 block w-full text-sm text-gray-700" />
                <p class="text-xs text-gray-500 mt-1">Formats acceptés : mp4, mov, webm. Taille maximale dépend de la configuration serveur.</p>
            </div>

            <!-- Prévisualisation vidéo côté client -->
            <div id="video-preview-container" class="mt-3" style="display:none;">
                <label class="block text-sm font-medium text-gray-700">Aperçu vidéo</label>
                <div class="mt-2 bg-gray-50 border rounded p-3">
                    <video id="video-preview" controls class="w-full h-auto rounded-md bg-black" style="max-height:360px;"></video>
                    <div id="video-preview-info" class="text-sm text-gray-600 mt-2"></div>
                    <div class="mt-3">
                        <button type="button" id="video-remove-btn" class="inline-block px-3 py-1 border rounded text-sm text-gray-700 hover:bg-gray-100">Retirer la vidéo</button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Texte</label>
                <textarea name="texte" rows="6" class="mt-1 block w-full border rounded p-2" required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Région</label>
                    <select name="id_region" class="mt-1 block w-full border rounded p-2">
                        @foreach($regions as $region)
                            <option value="{{ $region->id_region }}">{{ $region->nom_region }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Langue</label>
                    <select name="id_langue" class="mt-1 block w-full border rounded p-2">
                        @foreach($langues as $langue)
                            <option value="{{ $langue->id_langue }}">{{ $langue->nom_langue }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="id_type_contenu" class="mt-1 block w-full border rounded p-2">
                        @foreach($typeContenus as $type)
                            <option value="{{ $type->id_type_contenu }}">{{ data_get($type, 'nom_type') ?? data_get($type, 'nom_contenu') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3">
                    <button type="submit" name="action" value="publish" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg">Publier</button>
                    <a href="{{ route('mes-contenus') }}" class="inline-block px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Annuler</a>
                </div>
            </div>
        
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                const input = document.querySelector('input[name="video"]');
                const previewContainer = document.getElementById('video-preview-container');
                const previewVideo = document.getElementById('video-preview');
                const previewInfo = document.getElementById('video-preview-info');
                const removeBtn = document.getElementById('video-remove-btn');

                function humanFileSize(bytes) {
                    const i = bytes === 0 ? 0 : Math.floor(Math.log(bytes) / Math.log(1024));
                    return (bytes / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB'][i];
                }

                if(!input) return;

                input.addEventListener('change', function(){
                    const file = this.files && this.files[0];
                    if(!file) {
                        previewContainer.style.display = 'none';
                        return;
                    }

                    if(!file.type.startsWith('video/')){
                        alert('Le fichier sélectionné n\'est pas une vidéo valide.');
                        this.value = '';
                        previewContainer.style.display = 'none';
                        return;
                    }

                    try {
                        const url = URL.createObjectURL(file);
                        previewVideo.src = url;
                        previewVideo.load();
                        previewInfo.textContent = file.name + ' — ' + humanFileSize(file.size);
                        previewContainer.style.display = 'block';
                    } catch (e) {
                        console.error(e);
                    }
                });

                removeBtn && removeBtn.addEventListener('click', function(){
                    input.value = '';
                    previewVideo.pause();
                    previewVideo.removeAttribute('src');
                    previewContainer.style.display = 'none';
                });
            });
        </script>
        @endpush
        </form>
    </div>
@endsection
