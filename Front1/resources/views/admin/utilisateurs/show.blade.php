<x-app-layout>
    <x-slot name="title">Détails de l'Utilisateur</x-slot>
    <x-slot name="subtitle">Informations de {{ $utilisateur->prenom }} {{ $utilisateur->nom }}</x-slot>

    <x-slot name="actions">
        <a href="{{ route('admin.utilisateurs.edit', $utilisateur) }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Modifier
        </a>
    </x-slot>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/50 overflow-hidden">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <span class="text-white text-2xl font-bold">
                        {{ strtoupper(substr($utilisateur->prenom, 0, 1)) }}{{ strtoupper(substr($utilisateur->nom, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</h1>
                    <p class="text-blue-100">{{ $utilisateur->email }}</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm text-white">
                            {{ $utilisateur->role->nom_role }}
                        </span>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm text-white">
                            {{ $utilisateur->statut }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations personnelles -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informations personnelles</h3>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Nom complet</span>
                        <span class="font-medium">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Email</span>
                        <span class="font-medium">{{ $utilisateur->email }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Sexe</span>
                        <span class="font-medium">{{ $utilisateur->sexe == 'M' ? 'Masculin' : 'Féminin' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Date de naissance</span>
                        <span class="font-medium">{{ $utilisateur->date_naissance->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Âge</span>
                        <span class="font-medium">{{ $utilisateur->date_naissance->age }} ans</span>
                    </div>
                </div>

                <!-- Informations du compte -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informations du compte</h3>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Rôle</span>
                        <span class="font-medium">{{ $utilisateur->role->nom_role }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Langue préférée</span>
                        <span class="font-medium">{{ $utilisateur->langue->nom_langue }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Statut</span>
                        <span class="font-medium capitalize">{{ $utilisateur->statut }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Date d'inscription</span>
                        <span class="font-medium">{{ $utilisateur->date_inscription->format('d/m/Y à H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Dernière modification</span>
                        <span class="font-medium">{{ $utilisateur->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $utilisateur->contenus()->count() }}</p>
                    <p class="text-sm text-blue-800">Contenus créés</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $utilisateur->commentaires()->count() }}</p>
                    <p class="text-sm text-green-800">Commentaires</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ $utilisateur->contenusModeres()->count() }}</p>
                    <p class="text-sm text-purple-800">Contenus modérés</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>