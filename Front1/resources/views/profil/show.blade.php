@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-gray-100 overflow-hidden flex items-center justify-center">
                @if(!empty($utilisateur->photo))
                    <img src="{{ asset('storage/' . $utilisateur->photo) }}" alt="Photo de profil" class="object-cover w-full h-full" />
                @else
                    <span class="text-xl text-gray-400">{{ strtoupper(substr($utilisateur->prenom ?? ($utilisateur->name ?? ''),0,1)) }}</span>
                @endif
            </div>

            <div class="flex-1">
                <h1 class="text-2xl font-semibold">{{ ($utilisateur->prenom ?? '') . ' ' . ($utilisateur->nom ?? '') }}</h1>
                <p class="text-sm text-gray-500">{{ $utilisateur->role?->nom_role ?? '' }}</p>
                <div class="mt-3 text-sm text-gray-600">
                    <div><strong>Email :</strong> {{ $utilisateur->email ?? $utilisateur->courriel ?? '—' }}</div>
                    <div><strong>Téléphone :</strong> {{ $utilisateur->telephone ?? $utilisateur->tel ?? '—' }}</div>
                </div>
            </div>

            <div class="text-right">
                @auth
                    @if(auth()->id() === ($utilisateur->id ?? null))
                        <a href="{{ route('profile.edit') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md">Modifier mon profil</a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="font-semibold text-lg">Infos personnelles</h3>
                <div class="text-sm text-gray-700">
                    <div><strong>Nom :</strong> {{ $utilisateur->nom ?? '—' }}</div>
                    <div><strong>Prénom :</strong> {{ $utilisateur->prenom ?? '—' }}</div>
                    <div><strong>Email :</strong> {{ $utilisateur->email ?? '—' }}</div>
                    <div><strong>Téléphone :</strong> {{ $utilisateur->telephone ?? '—' }}</div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="font-semibold text-lg">Coordonnées</h3>
                <div class="text-sm text-gray-700">
                    <div><strong>Adresse :</strong> {{ $utilisateur->adresse ?? '—' }}</div>
                    <div><strong>Ville :</strong> {{ $utilisateur->ville ?? '—' }}</div>
                    <div><strong>Pays :</strong> {{ $utilisateur->pays ?? '—' }}</div>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-lg">Statut du compte</h3>
                <div class="text-sm text-gray-700">
                    <div>Membre depuis : {{ optional($utilisateur->date_inscription)->format('d/m/Y') ?? (optional($utilisateur->created_at)->format('d/m/Y') ?? '—') }}</div>
                    <div>Dernier accès : {{ optional($utilisateur->dernier_acces)->format('d/m/Y H:i') ?? (optional($utilisateur->last_login)->format('d/m/Y H:i') ?? '—') }}</div>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-lg">Actions</h3>
                <div class="mt-2 flex flex-col gap-2">
                    @auth
                        @if(auth()->id() === ($utilisateur->id ?? null))
                            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifier mes informations</a>
                            <a href="{{ route('profile.edit') }}#password" class="px-4 py-2 bg-gray-700 text-white rounded">Changer le mot de passe</a>

                            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Confirmer la suppression de votre compte ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Supprimer le compte</button>
                            </form>
                        @else
                            <span class="text-sm text-gray-600">Aucune action disponible pour ce profil.</span>
                        @endif
                    @else
                        <span class="text-sm text-gray-600">Connectez-vous pour interagir avec ce profil.</span>
                    @endauth
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-lg">Préférences</h3>
            <div class="text-sm text-gray-700 mt-2">
                <div><strong>Notifications :</strong> —</div>
                <div><strong>Langues :</strong> {{ $utilisateur->langue_preferee ?? '—' }}</div>
                <div><strong>Thème :</strong> {{ $utilisateur->theme ?? 'Par défaut' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

