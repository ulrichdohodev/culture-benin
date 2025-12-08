<?php

use Illuminate\Support\Facades\Route;

Route::get('/evenements/{slug}', function ($slug) {
    // For now use static mapping similar to pages/evenements
    $events = [
        ['slug' => 'fete-du-tissage-parakou', 'titre' => 'Fête du Tissage - Parakou', 'date' => now()->addWeeks(1)->format('d/m/Y'), 'lieu'=>'Parakou', 'description'=>'Démonstrations et ateliers', 'image'=>'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=60'],
        ['slug' => 'salon-des-arts-abomey', 'titre' => 'Salon des Arts d’Abomey', 'date' => now()->addWeeks(3)->format('d/m/Y'), 'lieu'=>'Abomey', 'description'=>'Expositions et conférences', 'image'=>'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?auto=format&fit=crop&w=1200&q=60'],
    ];

    $evt = collect($events)->firstWhere('slug', $slug);
    if (!$evt) abort(404);

    return view('pages.evenements.show', ['evt' => $evt]);
})->middleware(['auth'])->name('evenements.show');
