@extends('layouts.app')

@section('title','Événements')

@section('content')
<x-page-header title="Événements à venir" subtitle="Retrouvez les principaux rendez-vous culturels." />

@php
    $events = [
        [
            'titre' => 'Fête du Vodoun - Ouidah',
            'date' => now()->addWeeks(2)->format('d/m/Y'),
            'lieu' => 'Ouidah',
            'description' => 'Processions, danses et rituels autour des divinités vodoun.',
            'video' => asset('videos/arriere_hero.mp4'),
            'poster' => 'https://images.unsplash.com/photo-1521295121783-8a321d551ad2?auto=format&fit=crop&w=1200&q=60',
        ],
        [
            'titre' => 'Festival International du Théâtre du Bénin (FITHEB)',
            'date' => now()->addWeeks(4)->format('d/m/Y'),
            'lieu' => 'Cotonou',
            'description' => 'Troupes africaines et béninoises, spectacles de rue et ateliers.',
            'video' => asset('videos/riz.mp4'),
            'poster' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&q=60',
        ],
        [
            'titre' => 'Festival Gèlèdè de Kétou',
            'date' => now()->addWeeks(6)->format('d/m/Y'),
            'lieu' => 'Kétou',
            'description' => 'Masques gèlèdè, chants et danses célébrant les mères et la communauté.',
            'video' => 'https://cdn.coverr.co/videos/coverr-african-dance-1051/1080p.mp4',
            'poster' => 'https://images.unsplash.com/photo-1509099836639-18ba02e2e1ba?auto=format&fit=crop&w=1200&q=60',
        ],
        [
            'titre' => 'Festival de la Recade',
            'date' => now()->addWeeks(8)->format('d/m/Y'),
            'lieu' => 'Porto-Novo',
            'description' => 'Expositions d’artisanat royal et parades culturelles.',
            'video' => 'https://cdn.coverr.co/videos/coverr-culture-drumline-1362/1080p.mp4',
            'poster' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=60',
        ],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($events as $evt)
        <article class="bg-white rounded-lg shadow overflow-hidden">
            <div class="relative">
                <video class="w-full h-56 object-cover" controls preload="none" poster="{{ $evt['poster'] }}">
                    <source src="{{ $evt['video'] }}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg">{{ $evt['titre'] }}</h3>
                <p class="text-sm text-gray-600">{{ $evt['date'] }} — {{ $evt['lieu'] }}</p>
                <p class="mt-2 text-gray-700">{{ $evt['description'] }}</p>
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-2 bg-green-50 text-green-700 rounded border border-green-200 text-sm">Visionnez la vidéo ci-dessus</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>

@endsection
