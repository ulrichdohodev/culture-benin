@extends('layouts.app')

@section('title', 'Mon Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Bienvenue, {{ Auth::user()->prenom }} !</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Mes contenus -->
            <div class="bg-blue-50 rounded-lg p-6 text-center">
                <div class="text-blue-600 text-3xl font-bold mb-2">{{ $userStats['mes_contenus'] }}</div>
                <div class="text-blue-800 font-medium">Mes contenus</div>
            </div>

            <!-- Contenus en attente -->
            <div class="bg-yellow-50 rounded-lg p-6 text-center">
                <div class="text-yellow-600 text-3xl font-bold mb-2">{{ $userStats['contenus_en_attente'] }}</div>
                <div class="text-yellow-800 font-medium">En attente</div>
            </div>

            <!-- Contenus approuvés -->
            <div class="bg-green-50 rounded-lg p-6 text-center">
                <div class="text-green-600 text-3xl font-bold mb-2">{{ $userStats['contenus_approuves'] }}</div>
                <div class="text-green-800 font-medium">Approuvés</div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('contenus.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-center font-medium">
                Créer un nouveau contenu
            </a>
            <a href="{{ route('mes-contenus') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200 text-center font-medium">
                Voir mes contenus
            </a>
        </div>

        <!-- Derniers contenus -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes derniers contenus</h3>
            @if($recentUserContenus->count() > 0)
            <div class="space-y-3">
                @foreach($recentUserContenus as $contenu)
                <div class="bg-white p-4 rounded-lg border">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $contenu->titre }}</h4>
                            <p class="text-sm text-gray-600">{{ $contenu->region->nom_region ?? 'N/A' }} • {{ $contenu->typeContenu->nom_contenu ?? 'N/A' }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                                     {{ $contenu->statut == 'valide' ? 'bg-green-100 text-green-800' : 
                               ($contenu->statut == 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                     {{ $contenu->statut }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Vous n'avez pas encore créé de contenu.</p>
            @endif
        </div>
    </div>
</div>
@endsection