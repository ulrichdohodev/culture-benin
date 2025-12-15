@extends('layouts.app')

@section('title', $artisan['nom'] ?? 'Artisan')

@section('content')
<x-page-header :title="$artisan['nom'] ?? 'Artisan'" :subtitle="$artisan['metier'] ?? ''" />

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="md:flex gap-6">
            <div class="md:w-1/3">
                <img src="{{ $artisan['image'] ?? 'https://images.unsplash.com/photo-1520975915143-8d5c2f0a2f8b?auto=format&fit=crop&w=800&q=60' }}" alt="{{ $artisan['nom'] ?? '' }}" class="w-full h-64 object-cover rounded">
                <p class="mt-3 text-sm text-gray-600">Région : <span class="font-medium">{{ $artisan['region'] ?? '' }}</span></p>
                <p class="text-sm text-gray-600">Contact : <span class="font-medium">{{ $artisan['telephone'] ?? '' }}</span></p>
            </div>
            <div class="md:flex-1">
                <h2 class="text-2xl font-bold">{{ $artisan['nom'] ?? '' }}</h2>
                <p class="text-sm text-gray-500">{{ $artisan['metier'] ?? '' }}</p>
                <div class="mt-4 text-gray-700">{{ $artisan['description'] ?? 'Artisan expérimenté dans son domaine.' }}</div>

                <div class="mt-6">
                    <a href="#" class="px-4 py-2 bg-green-600 text-white rounded">Contacter</a>
                    <a href="{{ route('artisans') }}" class="ml-2 px-4 py-2 border rounded">Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
