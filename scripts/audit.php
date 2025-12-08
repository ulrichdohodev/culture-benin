use Illuminate\Support\Facades\DB;

$tables = ['regions', 'type_media', 'utilisateurs', 'contenus', 'roles', 'langues'];

echo "=== AUDIT DES COLONNES EN BD ===\n\n";

foreach ($tables as $table) {
    echo "Table: {$table}\n";
    try {
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        echo "  Colonnes: " . implode(', ', $columns) . "\n";
    } catch (\Exception $e) {
        echo "  ✗ Erreur: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// Vérifier count
echo "=== COMPTAGES ===\n";
echo "regions: " . DB::table('regions')->count() . "\n";
echo "type_media: " . DB::table('type_media')->count() . "\n";
echo "utilisateurs: " . DB::table('utilisateurs')->count() . "\n";
