@extends('layouts.admin')

@section('title', 'Modifier le Média')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier le média</h1>

        <form action="{{ route('admin.media.update', $media) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 mb-6">
                <!-- Type de média -->
                <div>
                    <label for="id_type_media" class="block text-sm font-medium text-gray-700 mb-2">Type de média *</label>
                    <select name="id_type_media" id="id_type_media" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un type...</option>
                        @foreach($typeMedia as $type)
                            <option value="{{ $type->id_type_media }}" {{ old('id_type_media', $media->id_type_media) == $type->id_type_media ? 'selected' : '' }}>
                                {{ $type->nom_type_media }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_type_media')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom du fichier -->
                <div>
                    <label for="nom_fichier" class="block text-sm font-medium text-gray-700 mb-2">Nom du fichier *</label>
                    <input type="text" name="nom_fichier" id="nom_fichier" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('nom_fichier', $media->nom_fichier) }}">
                    @error('nom_fichier')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fichier actuel -->
                @if($media->chemin_fichier)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fichier actuel</label>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $media->nom_fichier }}</p>
                            <p class="text-xs text-gray-500">{{ $media->type_fichier }} • {{ number_format($media->taille / 1024, 2) }} KB</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Nouveau fichier -->
                <div>
                    <label for="chemin_fichier" class="block text-sm font-medium text-gray-700 mb-2">Nouveau fichier</label>
                    <input type="file" name="chemin_fichier" id="chemin_fichier"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           accept="image/*,video/*,audio/*,.pdf,.doc,.docx">
                    @error('chemin_fichier')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Laisser vide pour conserver le fichier actuel</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $media->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut actif (non applicable) -->
                <div>
                    <p class="text-sm text-gray-600">Statut géré automatiquement</p>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.media.show', $media) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Modifier le média
                </button>
            </div>
        </form>
    </div>
</div>
@endsection