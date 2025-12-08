<?php
// script qui crée des enregistrements tests et affiche des comptages
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Démarrage du script de test de persistance...\n";

$now = date('Y-m-d H:i:s');

// Insérer une region test
try {
    $regionId = DB::table('regions')->insertGetId([
        'nom_region' => 'Region Test ' . uniqid(),
        'description' => 'Enregistrement de test',
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    echo "Region insérée id={$regionId}\n";
} catch (\Exception $e) {
    echo "Erreur insertion region: " . $e->getMessage() . "\n";
}

// Insérer un type_media test
try {
    $typeMediaId = DB::table('type_media')->insertGetId([
        'nom_media' => 'TypeMedia Test ' . uniqid(),
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    echo "TypeMedia inséré id={$typeMediaId}\n";
} catch (\Exception $e) {
    echo "Erreur insertion type_media: " . $e->getMessage() . "\n";
}

// Compter les enregistrements
try {
    $regionsCount = DB::table('regions')->count();
    $typeMediaCount = DB::table('type_media')->count();
    echo "regions.count={$regionsCount}\n";
    echo "type_media.count={$typeMediaCount}\n";
} catch (\Exception $e) {
    echo "Erreur comptage: " . $e->getMessage() . "\n";
}

echo "Script terminé.\n";
