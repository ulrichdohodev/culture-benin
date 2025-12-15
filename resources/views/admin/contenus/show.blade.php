@extends('layouts.admin')

@section('title', 'Détails du Contenu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Détails du contenu</h1>
            <div class="flex space-x-2">
                @if(($contenu->statut ?? '') === 'en_attente' && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
                    <form method="POST" action="{{ route('admin.contenus.valider', $contenu) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200" onclick="return confirm('Valider ce contenu ?')">Valider</button>
                    </form>

                    <form method="POST" action="{{ route('admin.contenus.rejeter', $contenu) }}">
                        @csrf
                        <div class="mb-2">
                            <label for="motif_rejet" class="block text-sm font-medium text-gray-600">Motif de rejet (optionnel)</label>
                            <textarea name="motif_rejet" id="motif_rejet" rows="3" class="mt-1 block w-full rounded border-gray-300" placeholder="Expliquez brièvement pourquoi ce contenu est rejeté..."></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200" onclick="return confirm('Rejeter ce contenu ?')">Rejeter</button>
                    </form>
                @endif

                <a href="{{ route('admin.contenus.edit', $contenu) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Modifier
                </a>
                <a href="{{ route('admin.contenus.index') }}" 
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
                    <label class="block text-sm font-medium text-gray-600">Titre</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $contenu->titre }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Auteur</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contenu->auteur->prenom ?? '' }} {{ $contenu->auteur->nom ?? '' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Région</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contenu->region->nom_region }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Langue</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contenu->langue->nom_langue }}</p>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Métadonnées</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Type de contenu</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contenu->typeContenu->nom_contenu }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Statut</label>
                    <span class="mt-1 inline-flex px-2 py-1 text-xs rounded-full 
                                {{ $contenu->statut == 'valide' ? 'bg-green-100 text-green-800' : 
                                    ($contenu->statut == 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $contenu->statut }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de création</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contenu->date_creation->format('d/m/Y à H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Dernière modification</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $contenu->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Contenu -->
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contenu</h3>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="prose max-w-none">
                    {!! nl2br(e($contenu->texte)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection