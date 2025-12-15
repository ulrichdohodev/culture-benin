@extends('layouts.app')

@section('title','Uploader désactivé')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center">
    <h2 class="text-xl font-semibold mb-3">Upload désactivé</h2>
    <p class="mb-4">La fonctionnalité d'upload public a été désactivée. Utilisez la page de gestion des médias.</p>
    <a href="{{ route('admin.media.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Aller à la gestion des médias</a>
</div>

@endsection
