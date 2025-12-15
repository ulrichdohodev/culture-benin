@extends('layouts.app')

@section('title', $event['title'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="relative h-96">
                <img src="{{ asset($event['img']) }}" alt="{{ $event['title'] }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-8 left-8 right-8 text-white">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-green-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                            Accès Premium
                        </span>
                    </div>
                    <h1 class="text-5xl font-bold mb-4">{{ $event['title'] }}</h1>
                    <div class="flex items-center gap-6 text-lg">
                        <span class="flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $event['date'] }}
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $event['lieu'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">À propos de l'événement</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $event['details'] }}</p>
                </div>

                <!-- Programme -->
                @if(isset($event['programme']))
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Programme</h2>
                    <div class="space-y-4">
                        @foreach($event['programme'] as $item)
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg hover:bg-green-50 transition">
                                <div class="w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                                <p class="text-gray-700">{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Informations pratiques -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations pratiques</h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Horaires</p>
                                <p class="text-gray-600">Ouverture des portes : 1h avant le début du programme</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Tarif</p>
                                <p class="text-gray-600">{{ number_format($event['price'], 0, ',', ' ') }} FCFA - Accès complet à l'événement</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Contact</p>
                                <p class="text-gray-600">Pour toute information : contact@culture-benin.org</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Carte d'information -->
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
                    <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold text-green-800">Accès confirmé</span>
                        </div>
                        <p class="text-sm text-green-700">Vous avez un accès complet à cet événement</p>
                    </div>

                    <h3 class="font-bold text-gray-900 mb-4">Détails</h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-gray-500 mb-1">Date</p>
                            <p class="font-semibold text-gray-900">{{ $event['date'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Lieu</p>
                            <p class="font-semibold text-gray-900">{{ $event['lieu'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Catégorie</p>
                            <p class="font-semibold text-gray-900">Événement culturel</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('accueil') }}" 
                           class="block w-full text-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
