@extends('layouts.app')

@section('title', $item['titre'] ?? 'Détail')

@section('content')
<x-page-header :title="$item['titre']" :subtitle="$item['artisan'] . ' — ' . $item['region']" />

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <img src="{{ $item['image'] }}" alt="{{ $item['titre'] }}" class="w-full h-64 object-cover">
        <div class="p-6">
            <h2 class="text-2xl font-bold">{{ $item['titre'] }}</h2>
            <p class="text-sm text-gray-600">{{ $item['region'] }}</p>
            <div class="mt-4 text-gray-700">Prix estimé : {{ number_format($item['prix'],0,',',' ') }} FCFA</div>

            <div class="mt-6">
                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded">Contacter l'artisan</a>
                <a href="{{ route('explorer') }}" class="ml-2 px-4 py-2 border rounded">Retour</a>
            </div>
        </div>
    </div>
</div>

@endsection
