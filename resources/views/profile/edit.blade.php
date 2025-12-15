@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Mon profil</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom', auth()->user()->prenom ?? auth()->user()->name) }}" class="mt-1 block w-full border-gray-200 rounded-md" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom ?? '') }}" class="mt-1 block w-full border-gray-200 rounded-md" />
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full border-gray-200 rounded-md" />
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', auth()->user()->telephone) }}" class="mt-1 block w-full border-gray-200 rounded-md" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Photo de profil (optionnel)</label>
                    <input type="file" name="photo" class="mt-1 block w-full" accept="image/*" />
                </div>
            </div>

            <!-- Affichage de la photo actuelle -->
            @if(auth()->user()->photo)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Votre photo actuelle</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ route('profile.photo', ['filename' => basename(auth()->user()->photo)]) }}" alt="Photo de profil" class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300" onerror="this.style.display='none'" />
                        <div>
                            <p class="text-sm text-gray-600">Votre photo de profil actuelle</p>
                            <p class="text-xs text-gray-500 mt-1">Téléchargez une nouvelle image pour la remplacer</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" name="adresse" value="{{ old('adresse', auth()->user()->adresse) }}" class="mt-1 block w-full border-gray-200 rounded-md" />
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ville</label>
                    <input type="text" name="ville" value="{{ old('ville', auth()->user()->ville) }}" class="mt-1 block w-full border-gray-200 rounded-md" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pays</label>
                    <input type="text" name="pays" value="{{ old('pays', auth()->user()->pays) }}" class="mt-1 block w-full border-gray-200 rounded-md" />
                </div>
            </div>

            <div class="mt-6 border-t pt-4">
                <h2 class="text-lg font-medium">Changer le mot de passe</h2>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4" id="password">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="mt-1 block w-full border-gray-200 rounded-md" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                        <input type="password" name="password" class="mt-1 block w-full border-gray-200 rounded-md" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmer le nouveau</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-200 rounded-md" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
                <a href="{{ route('dashboard') }}" class="text-gray-600">Annuler</a>
            </div>
        </form>

        <div class="mt-6 border-t pt-4">
            <h2 class="text-lg font-medium">Supprimer le compte</h2>
            <p class="text-sm text-gray-600 mt-2">La suppression est irréversible. Vos contenus pourront être supprimés.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" class="mt-3" onsubmit="return confirm('Confirmer la suppression de votre compte ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Supprimer mon compte</button>
            </form>
        </div>
    </div>
</div>
@endsection

