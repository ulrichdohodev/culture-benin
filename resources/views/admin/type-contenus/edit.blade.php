@extends('layouts.admin')

@section('title', 'Modifier le Type de Contenu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier le type de contenu</h1>

        <form action="{{ route('admin.type-contenus.update', $typeContenu) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 mb-6">
                <!-- Nom -->
                <div>
                    <label for="nom_contenu" class="block text-sm font-medium text-gray-700 mb-2">Nom du type *</label>
                    <input type="text" name="nom_contenu" id="nom_contenu" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('nom_contenu', $typeContenu->nom_contenu) }}">
                    @error('nom_contenu')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $typeContenu->description) }}</textarea>
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
                <a href="{{ route('admin.type-contenus.show', $typeContenu) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Modifier le type
                </button>
            </div>
        </form>
    </div>
</div>
@endsection