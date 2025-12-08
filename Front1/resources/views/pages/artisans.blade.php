@extends('layouts.app')

@section('title','Artisans')

@section('content')
<x-page-header title="Artisans et savoir-faire" subtitle="Découvrez des artisans locaux, leurs spécialités et comment les contacter." />

@php
    $artisans = [
        ['nom'=>'Adjani K.','metier'=>'Tisserand traditionnel','region'=>'Parakou','telephone'=>'+229 90000001','image'=>'https://images.unsplash.com/photo-1520975915143-8d5c2f0a2f8b?auto=format&fit=crop&w=800&q=60'],
        ['nom'=>'Fatoumata S.','metier'=>'Sculptrice sur bois','region'=>'Abomey','telephone'=>'+229 90000002','image'=>'https://images.unsplash.com/photo-1543866763-9e1a5f8f7a3c?auto=format&fit=crop&w=800&q=60'],
        ['nom'=>'Mahoudo D.','metier'=>'Forgeron','region'=>'Cotonou','telephone'=>'+229 90000003','image'=>'https://images.unsplash.com/photo-1505765056983-6c9b6a9f5d65?auto=format&fit=crop&w=800&q=60'],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($artisans as $artisan)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <img src="{{ $artisan['image'] }}" alt="{{ $artisan['nom'] }}" class="w-full h-40 object-cover">
            <div class="p-4">
                <h3 class="font-semibold">{{ $artisan['nom'] }}</h3>
                <p class="text-sm text-gray-600">{{ $artisan['metier'] }} — {{ $artisan['region'] }}</p>
                <p class="mt-3 text-sm">Contact : <span class="font-medium">{{ $artisan['telephone'] }}</span></p>
                <div class="mt-4 flex items-center gap-2">
                    <a href="{{ route('artisans.show', Str::slug($artisan['nom'])) }}" class="px-3 py-2 bg-green-600 text-white rounded">Voir profil</a>
                    <a href="tel:{{ preg_replace('/\s+|[^0-9+]/','',$artisan['telephone']) }}" class="px-3 py-2 border rounded text-gray-700">Contacter</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
