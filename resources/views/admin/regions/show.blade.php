@extends('layouts.admin')

@section('title', 'Détails de la Région')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Détails de la région</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.regions.edit', $region) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Modifier
                </a>
                <a href="{{ route('admin.regions.index') }}" 
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
                    <label class="block text-sm font-medium text-gray-600">Nom de la région</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $region->nom_region }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de création</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $region->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Description</h3>
                @if($region->description)
                    <p class="text-sm text-gray-900">{{ $region->description }}</p>
                @else
                    <p class="text-sm text-gray-500 italic">Aucune description disponible</p>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        <div class="mt-8 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-blue-600 text-2xl font-bold">{{ $region->contenus_count }}</div>
                    <div class="text-blue-800 text-sm">Contenus associés</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-green-600 text-2xl font-bold">{{ $region->parlers_count ?? 0 }}</div>
                    <div class="text-green-800 text-sm">Langues parlées</div>
                </div>
            </div>
        </div>

        <!-- Contenus récents -->
        @if($region->contenus_count > 0)
        <div class="mt-8 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contenus récents</h3>
            <div class="space-y-3">
                @foreach($region->contenus->take(5) as $contenu)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $contenu->titre }}</h4>
                        <p class="text-sm text-gray-600">{{ $contenu->typeContenu->nom_contenu }} • {{ $contenu->created_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                                {{ $contenu->statut == 'valide' ? 'bg-green-100 text-green-800' : 
                                    ($contenu->statut == 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $contenu->statut }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection