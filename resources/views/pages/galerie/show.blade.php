@extends('layouts.app')

@section('title', 'Média')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center">
    <h2 class="text-xl font-semibold mb-3">Affichage du média</h2>
    <p class="mb-4">Les vues publiques des médias ont été centralisées dans la gestion des médias.</p>
    <a href="{{ route('admin.media.show', $media->id_media ?? $media->id) }}" class="px-4 py-2 bg-green-600 text-white rounded">Voir dans la gestion</a>
</div>

@endsection
