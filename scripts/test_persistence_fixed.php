<?php

// Initialiser Laravel correctement
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Region;
use App\Models\TypeMedia;

echo "=== TEST PERSISTANCE ===\n";

// 1. Créer une region
echo "\n1. Création d'une Region:\n";
try {
    $data = [
        'nom_region' => 'Region Test ' . uniqid(),
        'description' => 'Test de persistance'
    ];
    echo "   Données: " . json_encode($data) . "\n";
    
    $region = Region::create($data);
    echo "   ✓ Region créée: id={$region->id_region}, nom={$region->nom_region}\n";
    
    // Vérifier en DB
    $found = Region::find($region->id_region);
    if ($found) {
        echo "   ✓ Vérification en DB: trouvée\n";
    } else {
        echo "   ✗ ERREUR: région NOT found en DB!\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
}

// 2. Créer un TypeMedia
echo "\n2. Création d'un TypeMedia:\n";
try {
    $data = [
        'nom_type_media' => 'TypeMedia Test ' . uniqid(),
        'description' => 'Test'
    ];
    echo "   Données: " . json_encode($data) . "\n";
    
    $typeMedia = TypeMedia::create($data);
    echo "   ✓ TypeMedia créé: id={$typeMedia->id_type_media}, nom={$typeMedia->nom_type_media}\n";
    
    $found = TypeMedia::find($typeMedia->id_type_media);
    if ($found) {
        echo "   ✓ Vérification en DB: trouvé\n";
    } else {
        echo "   ✗ ERREUR: TypeMedia NOT found en DB!\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 3. Compter tous les enregistrements
echo "\n3. Comptages:\n";
try {
    echo "   regions: " . Region::count() . "\n";
    echo "   type_media: " . TypeMedia::count() . "\n";
} catch (\Exception $e) {
    echo "   Erreur: " . $e->getMessage() . "\n";
}

echo "\n=== FIN TEST ===\n";
