@extends('layouts.app')

@section('title', 'Mon Dashboard - Culture Bénin')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Mon Dashboard</h1>
        <p class="text-gray-600">Gérez vos événements, vos plats et vos paramètres</p>
    </div>

    <!-- Navigation + contenu -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6" x-data="{ activeTab: 'events' }">
        <!-- Menu vertical -->
        <aside class="bg-white rounded-lg shadow-sm border p-4 space-y-2 lg:sticky lg:top-24 lg:h-fit">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Menu</h2>
            <button @click="activeTab = 'events'" :class="activeTab === 'events' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg border font-semibold text-left transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Événements payés</span>
            </button>
            <button @click="activeTab = 'dishes'" :class="activeTab === 'dishes' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg border font-semibold text-left transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <span>Plats payés</span>
            </button>
            <button @click="activeTab = 'settings'" :class="activeTab === 'settings' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg border font-semibold text-left transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Paramètres</span>
            </button>
        </aside>

        <!-- Contenu -->
        <div class="lg:col-span-3 space-y-6">
        <!-- Contenu Onglet Événements -->
        <div x-show="activeTab === 'events'" x-transition class="bg-white rounded-lg shadow p-6">
            @if($paidEvents && count($paidEvents) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($paidEvents as $event)
                        <div class="bg-white border border-green-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                                <h3 class="text-xl font-bold text-white">{{ $event['title'] ?? 'Événement' }}</h3>
                                <p class="text-green-100 text-sm">{{ $event['date'] ?? 'Date non disponible' }}</p>
                            </div>
                            <div class="p-6">
                                <div class="mb-4">
                                    <p class="text-gray-600 text-sm mb-2"><strong>Lieu:</strong> {{ $event['lieu'] ?? 'Non spécifié' }}</p>
                                    <p class="text-gray-600 text-sm mb-2"><strong>Montant payé:</strong> {{ number_format($event['amount'] ?? 0, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-gray-600 text-sm"><strong>Date de paiement:</strong> {{ isset($event['paid_date']) ? date('d/m/Y', strtotime($event['paid_date'])) : 'Non disponible' }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="flex-1 px-4 py-2 bg-green-600 text-white rounded font-semibold text-sm hover:bg-green-700 transition">
                                        Détails
                                    </button>
                                    <button class="flex-1 px-4 py-2 border border-green-600 text-green-600 rounded font-semibold text-sm hover:bg-green-50 transition">
                                        Ticket
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun événement payé</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore acheté de billet pour un événement</p>
                    <a href="{{ route('decouvrir.show', 'evenements') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Découvrir les événements
                    </a>
                </div>
            @endif
        </div>

        <!-- Contenu Onglet Plats -->
        <div x-show="activeTab === 'dishes'" x-transition class="bg-white rounded-lg shadow p-6">
            @if($paidDishes && count($paidDishes) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($paidDishes as $dish)
                        <div class="bg-white border border-orange-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                                <h3 class="text-xl font-bold text-white">{{ $dish['title'] ?? 'Plat' }}</h3>
                                <p class="text-orange-100 text-sm">{{ $dish['region'] ?? 'Région non spécifiée' }}</p>
                            </div>
                            <div class="p-6">
                                <div class="mb-4">
                                    <p class="text-gray-600 text-sm mb-2"><strong>Description:</strong> {{ $dish['desc'] ?? 'Non disponible' }}</p>
                                    <p class="text-gray-600 text-sm mb-2"><strong>Montant payé:</strong> {{ number_format($dish['amount'] ?? 0, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-gray-600 text-sm"><strong>Date de paiement:</strong> {{ isset($dish['paid_date']) ? date('d/m/Y', strtotime($dish['paid_date'])) : 'Non disponible' }}</p>
                                </div>
                                <button class="w-full px-4 py-2 bg-orange-500 text-white rounded font-semibold text-sm hover:bg-orange-600 transition">
                                    Voir la recette complète
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun plat acheté</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore commandé de plat</p>
                    <a href="{{ route('decouvrir.show', 'gastronomie') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Découvrir la gastronomie
                    </a>
                </div>
            @endif
        </div>

        <!-- Contenu Onglet Paramètres -->
        <div x-show="activeTab === 'settings'" x-transition class="bg-white rounded-lg shadow p-6">
            <div class="max-w-2xl">
                <!-- Section Profil -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Profil</h2>
                    <div class="flex items-center gap-6 mb-8">
                        <div>
                            @if($user->photo)
                                <img src="{{ route('profile.photo', ['filename' => basename($user->photo)]) }}" alt="Photo de profil" class="w-20 h-20 rounded-full object-cover border-4 border-green-600" />
                            @else
                                <div class="w-20 h-20 rounded-full bg-green-600 text-white flex items-center justify-center text-3xl font-bold">{{ strtoupper(substr($user->prenom ?? '', 0, 1)) }}</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-green-600 hover:text-green-700 font-semibold mt-2 inline-block">Modifier le profil</a>
                        </div>
                    </div>
                </div>

                <!-- Section Informations Personnelles -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations Personnelles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom</label>
                            <p class="text-gray-600 px-4 py-2 bg-gray-50 rounded">{{ $user->prenom ?? 'Non renseigné' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
                            <p class="text-gray-600 px-4 py-2 bg-gray-50 rounded">{{ $user->nom ?? 'Non renseigné' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <p class="text-gray-600 px-4 py-2 bg-gray-50 rounded">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                            <p class="text-gray-600 px-4 py-2 bg-gray-50 rounded">{{ $user->phone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center mt-6 px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Modifier les informations
                    </a>
                </div>

                <!-- Section Sécurité -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Sécurité</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900">Mot de passe</h3>
                                <p class="text-gray-600 text-sm">Modifiez votre mot de passe régulièrement</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="px-4 py-2 border border-green-600 text-green-600 rounded font-semibold hover:bg-green-50 transition">
                                Changer
                            </a>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900">Authentification à deux facteurs</h3>
                                <p class="text-gray-600 text-sm">Renforcez la sécurité de votre compte</p>
                            </div>
                            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded font-semibold hover:bg-gray-100 transition">
                                Configurer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section Déconnexion -->
                <div class="pt-8 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
