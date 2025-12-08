<?php
// Audit des colonnes en BD
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    echo "Fichier .env non trouvé.\n";
    exit(1);
}

$env = parse_ini_file($envFile);
$host = $env['DB_HOST'] ?? 'localhost';
$db   = $env['DB_DATABASE'] ?? '';
$user = $env['DB_USERNAME'] ?? '';
$pass = $env['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== AUDIT DES COLONNES EN BD ===\n\n";
    
    $tables = ['regions', 'type_media', 'utilisateurs', 'contenus', 'roles', 'langues'];
    
    foreach ($tables as $table) {
        echo "Table: {$table}\n";
        try {
            $stmt = $pdo->query("SHOW COLUMNS FROM {$table}");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($columns as $col) {
                echo "  - {$col['Field']} ({$col['Type']})\n";
            }
        } catch (\PDOException $e) {
            echo "  ✗ Table non trouvée\n";
        }
        echo "\n";
    }
    
} catch (\PDOException $e) {
    echo "Erreur de connexion BD: " . $e->getMessage() . "\n";
}
