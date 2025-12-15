<x-app-layout>
    <x-slot name="title">Détails de la Relation</x-slot>
    <x-slot name="subtitle">{{ $parler->region->nom_region }} - {{ $parler->langue->nom_langue }}</x-slot>

    <x-slot name="actions">
        <a href="{{ route('admin.parler.edit', $parler) }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
            Modifier
        </a>
    </x-slot>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/50 overflow-hidden">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-8">
            <div class="flex justify-between items-center">
                <div class="text-center flex-1">
                    <h1 class="text-2xl font-bold text-white">{{ $parler->region->nom_region }}</h1>
                    <div class="flex items-center justify-center space-x-4 mt-2 text-teal-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        <span class="text-lg">parle</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mt-2">{{ $parler->langue->nom_langue }}</h1>
                </div>
            </div>
        </div>

        <!-- Contenu -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informations détaillées -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations de la région -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                Région
                            </h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600">Nom</p>
                                    <a href="{{ route('admin.regions.show', $parler->region) }}" 
                                       class="font-medium text-blue-600 hover:text-blue-500">
                                        {{ $parler->region->nom_region }}
                                    </a>
                                </div>
                                
                                @if($parler->region->population)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Population</span>
                                    <span class="font-medium">{{ number_format($parler->region->population, 0, ',', ' ') }} hab.</span>
                                </div>
                                @endif
                                
                                @if($parler->region->superficie)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Superficie</span>
                                    <span class="font-medium">{{ number_format($parler->region->superficie, 0, ',', ' ') }} km²</span>
                                </div>
                                @endif
                                
                                @if($parler->region->localisation)
                                <div>
                                    <p class="text-sm text-gray-600">Localisation</p>
                                    <p class="font-medium">{{ $parler->region->localisation }}</p>
                                </div>
                                @endif
                                
                                <div class="flex justify-between pt-2 border-t border-gray-200">
                                    <span class="text-sm text-gray-600">Langues parlées</span>
                                    <span class="font-medium">{{ $parler->region ? $parler->region->langues()->count() : 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informations de la langue -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                Langue
                            </h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600">Nom</p>
                                    <a href="{{ route('admin.langues.show', $parler->langue) }}" 
                                       class="font-medium text-blue-600 hover:text-blue-500">
                                        {{ $parler->langue->nom_langue }}
                                    </a>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Code</span>
                                    <span class="font-medium">{{ $parler->langue->code_langue }}</span>
                                </div>
                                
                                @if($parler->langue->description)
                                <div>
                                    <p class="text-sm text-gray-600">Description</p>
                                    <p class="font-medium text-sm">{{ Str::limit($parler->langue->description, 100) }}</p>
                                </div>
                                @endif
                                
                                <div class="flex justify-between pt-2 border-t border-gray-200">
                                    <span class="text-sm text-gray-600">Régions où parlée</span>
                                    <span class="font-medium">{{ $parler->langue ? $parler->langue->regions()->count() : 0 }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Utilisateurs</span>
                                    <span class="font-medium">{{ $parler->langue ? $parler->langue->utilisateurs()->count() : 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenus associés -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contenus associés à cette relation</h3>
                        
                        @php
                            $contenusAssocies = \App\Models\Contenu::where('id_region', $parler->id_region)
                                ->where('id_langue', $parler->id_langue)
                                ->get();
                        @endphp
                        
                        @if($contenusAssocies->count() > 0)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="space-y-3">
                                @foreach($contenusAssocies->take(3) as $contenu)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate">{{ $contenu->titre }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs text-gray-500">{{ $contenu->typeContenu->nom_contenu }}</span>
                                            <span class="text-xs text-gray-400">•</span>
                                            <span class="text-xs text-gray-500">{{ $contenu->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $contenu->statut == 'valide' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $contenu->statut == 'en_attente' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ $contenu->statut }}
                                    </span>
                                </div>
                                @endforeach
                                
                                @if($contenusAssocies->count() > 3)
                                <div class="text-center pt-2">
                                    <a href="{{ route('admin.contenus.index') }}?region={{ $parler->id_region }}&langue={{ $parler->id_langue }}" 
                                       class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                        Voir les {{ $contenusAssocies->count() - 3 }} autres contenus →
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">Aucun contenu n'utilise cette combinaison région-langue</p>
                            <a href="{{ route('admin.contenus.create') }}?region={{ $parler->id_region }}&langue={{ $parler->id_langue }}" 
                               class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                                Créer un contenu
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Métadonnées -->
                <div class="space-y-6">
                    <!-- Informations de la relation -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Informations de la relation</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ID de la relation</span>
                                <span class="font-medium">{{ $parler->id }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Date de création</span>
                                <span class="font-medium">{{ $parler->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Dernière modification</span>
                                <span class="font-medium">{{ $parler->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">Actions rapides</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.contenus.create') }}?region={{ $parler->id_region }}&langue={{ $parler->id_langue }}" 
                               class="block text-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                                Créer un contenu
                            </a>
                            <a href="{{ route('admin.regions.show', $parler->region) }}" 
                               class="block text-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition duration-200">
                                Voir la région
                            </a>
                            <a href="{{ route('admin.langues.show', $parler->langue) }}" 
                               class="block text-center px-4 py-2 bg-yellow-600 text-white rounded-lg text-sm font-medium hover:bg-yellow-700 transition duration-200">
                                Voir la langue
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>