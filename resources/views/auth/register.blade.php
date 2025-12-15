<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- En-tête -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-lg overflow-hidden bg-white/10">
                <img src="{{ asset('images/logo.png') }}" alt="Culture Bénin" class="w-full h-full object-cover">
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Inscription</h2>
            <p class="mt-2 text-gray-600">Rejoignez la communauté Culture Bénin</p>
        </div>

        <!-- Grille Nom/Prénom -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom
                </label>
                <input 
                    id="nom" 
                    name="nom" 
                    type="text" 
                    required 
                    autofocus
                    value="{{ old('nom') }}"
                    class="w-full px-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    placeholder="Votre nom"
                >
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <!-- Prénom -->
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                    Prénom
                </label>
                <input 
                    id="prenom" 
                    name="prenom" 
                    type="text" 
                    required 
                    value="{{ old('prenom') }}"
                    class="w-full px-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    placeholder="Votre prénom"
                >
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Adresse email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    value="{{ old('email') }}"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    placeholder="votre@email.com"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Grille Sexe/Date de naissance -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Sexe -->
            <div>
                <label for="sexe" class="block text-sm font-medium text-gray-700 mb-2">
                    Sexe
                </label>
                <select 
                    id="sexe" 
                    name="sexe" 
                    required
                    class="w-full px-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                >
                    <option value="">Sélectionnez</option>
                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Homme</option>
                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Femme</option>
                </select>
                <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
            </div>

            <!-- Date de naissance -->
            <div>
                <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-2">
                    Date de naissance
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input 
                        id="date_naissance" 
                        name="date_naissance" 
                        type="date" 
                        required 
                        value="{{ old('date_naissance') }}"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    >
                </div>
                <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
            </div>
        </div>

        <!-- Langue -->
        <div>
            <label for="id_langue" class="block text-sm font-medium text-gray-700 mb-2">
                Langue préférée
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                </div>
                <select 
                    id="id_langue" 
                    name="id_langue" 
                    required
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                >
                    <option value="">Choisissez une langue</option>
                    @foreach(\App\Models\Langue::all() as $langue)
                        <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
                            {{ $langue->nom_langue }}
                        </option>
                    @endforeach
                </select>
            </div>
            <x-input-error :messages="$errors->get('id_langue')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    placeholder="Créez un mot de passe"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation mot de passe -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Confirmer le mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    required 
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    placeholder="Confirmez votre mot de passe"
                >
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Bouton d'inscription -->
        <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:scale-[1.02]">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Créer mon compte
        </button>

        <!-- Lien vers la connexion -->
        <div class="text-center pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-200 ml-1">
                    Se connecter
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>