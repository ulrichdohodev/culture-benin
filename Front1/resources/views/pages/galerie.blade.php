@extends('layouts.app')

@section('title','Galerie supprimée')

@section('content')
<div class="max-w-4xl mx-auto p-6 text-center">
    <h1 class="text-2xl font-semibold mb-4">Page Galerie retirée</h1>
    <p class="mb-4">La page de galerie publique a été remplacée par la page de gestion des médias.</p>
    <a href="{{ route('admin.media.index') }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded">Accéder à la gestion des médias</a>
</div>

@endsection
