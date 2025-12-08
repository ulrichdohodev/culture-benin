@extends('layouts.admin')

@section('title', 'Détails du Commentaire')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Détails du commentaire</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.commentaires.edit', $commentaire) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Modifier
                </a>
                <a href="{{ route('admin.commentaires.index') }}" 
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
                    <label class="block text-sm font-medium text-gray-600">Auteur</label>
                    <div class="mt-1 flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">
                                {{ strtoupper(substr($commentaire->utilisateur->prenom, 0, 1)) }}{{ strtoupper(substr($commentaire->utilisateur->nom, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $commentaire->utilisateur->prenom }} {{ $commentaire->utilisateur->nom }}</p>
                            <p class="text-xs text-gray-500">{{ $commentaire->utilisateur->email }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Contenu associé</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $commentaire->contenu->titre }}</p>
                    <p class="text-xs text-gray-500">{{ $commentaire->contenu->typeContenu->nom_contenu }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Statut</label>
                    <span class="mt-1 inline-flex px-2 py-1 text-xs rounded-full 
                        {{ $commentaire->est_approuve ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $commentaire->est_approuve ? 'Approuvé' : 'En attente' }}
                    </span>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Métadonnées</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de création</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $commentaire->created_at->format('d/m/Y à H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Dernière modification</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $commentaire->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Commentaire -->
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Commentaire</h3>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="prose max-w-none">
                    {!! nl2br(e($commentaire->contenu_commentaire)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection