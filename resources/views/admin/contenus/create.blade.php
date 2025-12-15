<x-app-layout>
    <x-slot name="title">Créer un Contenu</x-slot>
    <x-slot name="subtitle">Ajouter un nouveau contenu culturel</x-slot>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/50 p-6">
        <form action="{{ route('admin.contenus.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Titre -->
                <div>
                    <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input type="text" name="titre" id="titre" value="{{ old('titre') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Texte -->
                <div>
                    <label for="texte" class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                    <textarea name="texte" id="texte" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('texte') }}</textarea>
                    @error('texte')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Région -->
                    <div>
                        <label for="id_region" class="block text-sm font-medium text-gray-700 mb-2">Région *</label>
                        <select name="id_region" id="id_region" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionnez une région</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id_region }}" {{ old('id_region') == $region->id_region ? 'selected' : '' }}>
                                    {{ $region->nom_region }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_region')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Langue -->
                    <div>
                        <label for="id_langue" class="block text-sm font-medium text-gray-700 mb-2">Langue *</label>
                        <select name="id_langue" id="id_langue" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionnez une langue</option>
                            @foreach($langues as $langue)
                                <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
                                    {{ $langue->nom_langue }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_langue')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type de contenu -->
                    <div>
                        <label for="id_type_contenu" class="block text-sm font-medium text-gray-700 mb-2">Type de contenu *</label>
                        <select name="id_type_contenu" id="id_type_contenu" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionnez un type</option>
                            @foreach($typeContenus as $type)
                                <option value="{{ $type->id_type_contenu }}" {{ old('id_type_contenu') == $type->id_type_contenu ? 'selected' : '' }}>
                                    {{ $type->nom_contenu }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_type_contenu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Auteur -->
                    <div>
                        <label for="id_auteur" class="block text-sm font-medium text-gray-700 mb-2">Auteur *</label>
                        <select name="id_auteur" id="id_auteur" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionnez un auteur</option>
                            @foreach($auteurs as $auteur)
                                <option value="{{ $auteur->id_utilisateur }}" {{ old('id_auteur') == $auteur->id_utilisateur ? 'selected' : '' }}>
                                    {{ $auteur->prenom }} {{ $auteur->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_auteur')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="md:col-span-2">
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                        <select name="statut" id="statut" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                            <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="valide" {{ old('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                            <option value="rejete" {{ old('statut') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                        @error('statut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.contenus.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    Créer le contenu
                </button>
            </div>
        </form>
    </div>
</x-app-layout>