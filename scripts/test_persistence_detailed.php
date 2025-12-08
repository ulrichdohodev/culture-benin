<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\TypeMedia;
use App\Models\Utilisateur;
use App\Models\Role;
use App\Models\Langue;

echo "=== TEST DE PERSISTANCE VIA MODÈLES ===\n\n";

// 1. Tester l'insertion directe d'une Region
echo "1. TEST Region (insertion directe):\n";
try {
    $region = Region::create([
        'nom_region' => 'Test Region ' . uniqid(),
        'description' => 'Region de test pour vérification'
    ]);
    echo "   ✓ Region créée: id={$region->id_region}, nom={$region->nom_region}\n";
    
    // Vérifier si elle existe en DB
    $found = Region::find($region->id_region);
    echo "   ✓ Vérification: trouvée en DB\n";
} catch (\Exception $e) {
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 2. Tester l'insertion directe d'un TypeMedia
echo "\n2. TEST TypeMedia (insertion directe):\n";
try {
    $typeMedia = TypeMedia::create([
        'nom_type_media' => 'Test TypeMedia ' . uniqid(),
        'description' => 'TypeMedia de test'
    ]);
    echo "   ✓ TypeMedia créé: id={$typeMedia->id_type_media}, nom={$typeMedia->nom_type_media}\n";
    
    $found = TypeMedia::find($typeMedia->id_type_media);
    echo "   ✓ Vérification: trouvé en DB\n";
} catch (\Exception $e) {
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 3. Vérifier les colonnes réelles en DB
echo "\n3. VÉRIFICATION DES COLONNES EN BD:\n";
try {
    $typeMediaColumns = DB::getSchemaBuilder()->getColumnListing('type_media');
    echo "   Colonnes de type_media: " . implode(', ', $typeMediaColumns) . "\n";
    
    $regionColumns = DB::getSchemaBuilder()->getColumnListing('regions');
    echo "   Colonnes de regions: " . implode(', ', $regionColumns) . "\n";
} catch (\Exception $e) {
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 4. Compter les enregistrements totaux
echo "\n4. COMPTAGES FINAUX:\n";
try {
    echo "   regions.count = " . Region::count() . "\n";
    echo "   type_media.count = " . TypeMedia::count() . "\n";
    echo "   utilisateurs.count = " . Utilisateur::count() . "\n";
} catch (\Exception $e) {
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

echo "\n=== TESTS TERMINÉS ===\n";
