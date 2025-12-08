<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Route temporaire pour audit
Route::get('/debug/audit', function () {
    $tables = ['regions', 'type_media', 'utilisateurs', 'contenus', 'roles', 'langues'];
    
    echo "<h2>Audit des colonnes en BD</h2>";
    
    foreach ($tables as $table) {
        echo "<h3>Table: {$table}</h3>";
        try {
            $columns = DB::getSchemaBuilder()->getColumnListing($table);
            echo "Colonnes: " . implode(', ', $columns) . "<br>";
            echo "Count: " . DB::table($table)->count() . "<br>";
        } catch (\Exception $e) {
            echo "Erreur: " . $e->getMessage() . "<br>";
        }
    }
    
    // Vérifier TypeMedia fillable et colonne
    echo "<h3>TypeMedia Model Check</h3>";
    $tm = new \App\Models\TypeMedia();
    echo "Fillable: " . implode(', ', $tm->getFillable()) . "<br>";
    
    // Essayer une insertion test
    echo "<h3>Test Insertion TypeMedia</h3>";
    try {
        $data = ['nom_type_media' => 'Test ' . uniqid()];
        $tm = \App\Models\TypeMedia::create($data);
        echo "✓ Créé: id={$tm->id_type_media}, nom={$tm->nom_type_media}<br>";
    } catch (\Exception $e) {
        echo "✗ Erreur: " . $e->getMessage() . "<br>";
    }
})->name('debug.audit');

// Route pour vérifier ce que retourne le contrôleur RegionController
Route::get('/debug/regions', function () {
    $controller = new \App\Http\Controllers\Admin\RegionController();
    
    echo "<h2>Test RegionController Index</h2>";
    
    // Récupérer les données comme le ferait le contrôleur
    $regions = \App\Models\Region::withCount('contenus')
        ->orderBy('nom_region')
        ->paginate(10);
    
    echo "Count total: " . $regions->total() . "<br>";
    echo "Items sur cette page: " . $regions->count() . "<br>";
    
    if ($regions->count() > 0) {
        echo "<h3>Premier item:</h3>";
        $first = $regions->first();
        echo "ID: {$first->id_region}<br>";
        echo "Nom: {$first->nom_region}<br>";
        echo "Description: {$first->description}<br>";
        echo "Contenus count: {$first->contenus_count}<br>";
    }
    
})->name('debug.regions');

// Route pour vérifier TypeMedia
Route::get('/debug/type-media', function () {
    echo "<h2>Test TypeMediaController Index</h2>";
    
    $typeMedia = \App\Models\TypeMedia::withCount('medias')
        ->orderBy('nom_type_media')
        ->paginate(10);
    
    echo "Count total: " . $typeMedia->total() . "<br>";
    echo "Items sur cette page: " . $typeMedia->count() . "<br>";
    
    if ($typeMedia->count() > 0) {
        echo "<h3>Premier item:</h3>";
        $first = $typeMedia->first();
        echo "ID: {$first->id_type_media}<br>";
        echo "Nom: {$first->nom_type_media}<br>";
        echo "Medias count: {$first->medias_count}<br>";
    }
    
})->name('debug.type-media');
