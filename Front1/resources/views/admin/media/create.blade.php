@extends('layouts.admin')

@section('title', 'Créer un Média')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Créer un nouveau média</h1>

        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6 mb-6">
                <!-- Type de média -->
                <div>
                    <label for="id_type_media" class="block text-sm font-medium text-gray-700 mb-2">Type de média *</label>
                    <select name="id_type_media" id="id_type_media" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un type...</option>
                        @foreach($typeMedia as $type)
                            <option value="{{ $type->id_type_media }}" {{ old('id_type_media') == $type->id_type_media ? 'selected' : '' }}>
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
                           value="{{ old('nom_fichier') }}"
                           placeholder="Ex: photo-culture-benin">
                    @error('nom_fichier')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fichier -->
                <div>
                    <label for="chemin_fichier" class="block text-sm font-medium text-gray-700 mb-2">Fichier *</label>
                    <input type="file" name="chemin_fichier" id="chemin_fichier" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           accept="image/*,video/*,audio/*,.pdf,.doc,.docx">
                    @error('chemin_fichier')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés : images, vidéos, audio, PDF, Word</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Description du média...">{{ old('description') }}</textarea>
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
                <a href="{{ route('admin.media.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Créer le média
                </button>
            </div>
        </form>
    </div>
</div>
@endsection