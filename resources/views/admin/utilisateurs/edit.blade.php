@extends('layouts.admin')

@section('title', 'Modifier l\'Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier l'utilisateur</h1>

        <form action="{{ route('admin.utilisateurs.update', $utilisateur) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('prenom', $utilisateur->prenom) }}">
                    @error('prenom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" name="nom" id="nom" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('nom', $utilisateur->nom) }}">
                    @error('nom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('email', $utilisateur->email) }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="mot_de_passe" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Laisser vide pour ne pas modifier">
                    @error('mot_de_passe')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sexe -->
                <div>
                    <label for="sexe" class="block text-sm font-medium text-gray-700 mb-2">Sexe *</label>
                    <select name="sexe" id="sexe" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez...</option>
                        <option value="M" {{ old('sexe', $utilisateur->sexe) == 'M' ? 'selected' : '' }}>Homme</option>
                        <option value="F" {{ old('sexe', $utilisateur->sexe) == 'F' ? 'selected' : '' }}>Femme</option>
                    </select>
                    @error('sexe')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de naissance -->
                <div>
                    <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-2">Date de naissance *</label>
                    <input type="date" name="date_naissance" id="date_naissance" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('date_naissance', $utilisateur->date_naissance->format('Y-m-d')) }}">
                    @error('date_naissance')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rôle -->
                <div>
                    <label for="id_role" class="block text-sm font-medium text-gray-700 mb-2">Rôle *</label>
                    <select name="id_role" id="id_role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un rôle...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}" {{ old('id_role', $utilisateur->id_role) == $role->id_role ? 'selected' : '' }}>
                                {{ $role->nom_role }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Langue -->
                <div>
                    <label for="id_langue" class="block text-sm font-medium text-gray-700 mb-2">Langue *</label>
                    <select name="id_langue" id="id_langue" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez une langue...</option>
                        @foreach($langues as $langue)
                            <option value="{{ $langue->id_langue }}" {{ old('id_langue', $utilisateur->id_langue) == $langue->id_langue ? 'selected' : '' }}>
                                {{ $langue->nom_langue }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_langue')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                    <select name="statut" id="statut" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="actif" {{ old('statut', $utilisateur->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('statut', $utilisateur->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('statut')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.utilisateurs.show', $utilisateur) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Modifier l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection