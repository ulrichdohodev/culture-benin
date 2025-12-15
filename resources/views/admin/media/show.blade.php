@extends('layouts.admin')

@section('title', 'Détails du Média')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Détails du média</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.media.edit', $media) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Modifier
                </a>
                <a href="{{ route('admin.media.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Informations générales -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informations générales</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nom du fichier</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $media->nom_fichier }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Type de média</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $media->typeMedia->nom_type_media }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Type de fichier</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $media->type_fichier }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Taille</label>
                    <p class="mt-1 text-sm text-gray-900">{{ number_format($media->taille / 1024, 2) }} KB</p>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Métadonnées</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Statut</label>
                    <p class="mt-1 text-sm text-gray-700">N/A</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de création</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $media->created_at->format('d/m/Y à H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Dernière modification</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $media->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($media->description)
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-900">{{ $media->description }}</p>
            </div>
        </div>
        @endif

        <!-- Aperçu -->
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aperçu</h3>
            <div class="bg-gray-50 rounded-lg p-6 text-center">
                @if(str_starts_with($media->type_fichier, 'image/'))
                    <img src="{{ Storage::url($media->chemin_fichier) }}" alt="{{ $media->nom_fichier }}" 
                         class="max-w-full h-auto max-h-64 mx-auto rounded-lg shadow-sm">
                @elseif(str_starts_with($media->type_fichier, 'video/'))
                    <video controls class="max-w-full mx-auto rounded-lg shadow-sm">
                        <source src="{{ Storage::url($media->chemin_fichier) }}" type="{{ $media->type_fichier }}">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                @elseif(str_starts_with($media->type_fichier, 'audio/'))
                    <audio controls class="w-full">
                        <source src="{{ Storage::url($media->chemin_fichier) }}" type="{{ $media->type_fichier }}">
                        Votre navigateur ne supporte pas la lecture audio.
                    </audio>
                @else
                    <div class="flex flex-col items-center justify-center p-8">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-600">Aperçu non disponible pour ce type de fichier</p>
                        <a href="{{ Storage::url($media->chemin_fichier) }}" 
                           class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Télécharger le fichier
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection