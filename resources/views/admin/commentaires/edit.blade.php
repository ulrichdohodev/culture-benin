@extends('layouts.admin')

@section('title', 'Modifier le Commentaire')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier le commentaire</h1>

        <form action="{{ route('admin.commentaires.update', $commentaire) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 mb-6">
                <!-- Utilisateur -->
                <div>
                    <label for="id_utilisateur" class="block text-sm font-medium text-gray-700 mb-2">Utilisateur *</label>
                    <select name="id_utilisateur" id="id_utilisateur" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un utilisateur...</option>
                        @foreach($utilisateurs as $utilisateur)
                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_utilisateur', $commentaire->id_utilisateur) == $utilisateur->id_utilisateur ? 'selected' : '' }}>
                                {{ $utilisateur->prenom }} {{ $utilisateur->nom }} ({{ $utilisateur->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_utilisateur')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu -->
                <div>
                    <label for="id_contenu" class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                    <select name="id_contenu" id="id_contenu" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un contenu...</option>
                        @foreach($contenus as $contenu)
                            <option value="{{ $contenu->id_contenu }}" {{ old('id_contenu', $commentaire->id_contenu) == $contenu->id_contenu ? 'selected' : '' }}>
                                {{ $contenu->titre }} ({{ $contenu->typeContenu->nom_contenu }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_contenu')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commentaire -->
                <div>
                    <label for="contenu_commentaire" class="block text-sm font-medium text-gray-700 mb-2">Commentaire *</label>
                    <textarea name="contenu_commentaire" id="contenu_commentaire" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('contenu_commentaire', $commentaire->contenu_commentaire) }}</textarea>
                    @error('contenu_commentaire')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut d'approbation -->
                <div class="flex items-center">
                    <input type="checkbox" name="est_approuve" id="est_approuve" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                           {{ old('est_approuve', $commentaire->est_approuve) ? 'checked' : '' }}>
                    <label for="est_approuve" class="ml-2 text-sm text-gray-700">Commentaire approuvé</label>
                    @error('est_approuve')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.commentaires.show', $commentaire) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Modifier le commentaire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection