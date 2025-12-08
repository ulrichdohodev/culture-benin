@extends('layouts.app')

@section('title', $evt['titre'] ?? 'Événement')

@section('content')
<x-page-header :title="$evt['titre']" :subtitle="$evt['lieu'] . ' — ' . $evt['date']" />

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <img src="{{ $evt['image'] }}" alt="{{ $evt['titre'] }}" class="w-full h-64 object-cover">
        <div class="p-6">
            <h2 class="text-2xl font-bold">{{ $evt['titre'] }}</h2>
            <p class="text-sm text-gray-600">{{ $evt['date'] }} — {{ $evt['lieu'] }}</p>
            <div class="mt-4 text-gray-700">{{ $evt['description'] }}</div>

            <div class="mt-6 flex gap-3">
                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded">S'inscrire</a>
                <a href="{{ route('evenements') }}" class="px-4 py-2 border rounded">Retour</a>
            </div>
        </div>
    </div>
</div>

@endsection
