<?php
// Vérifie que les noms de route utilisés dans les vues existent dans la liste des routes
$routesJson = shell_exec('php artisan route:list --json --no-ansi');
$routes = json_decode($routesJson, true);
$names = [];
if (is_array($routes)) {
    foreach ($routes as $r) {
        if (!empty($r['name'])) $names[$r['name']] = true;
    }
}
$used = [];
$dir = new RecursiveDirectoryIterator(__DIR__ . '/../resources/views');
$it = new RecursiveIteratorIterator($dir);
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    $path = $file->getPathname();
    if (substr($path, -10) !== '.blade.php') continue;
    $content = file_get_contents($path);
    if (preg_match_all("/route\s*\(\s*['\"]([^'\"]+)['\"]/", $content, $m, PREG_OFFSET_CAPTURE)) {
        foreach ($m[1] as $match) {
            $name = $match[0];
            $pos = $match[1];
            // évite les cas de $request->route('token') ou ->route('...') (faux positifs)
            $before = substr($content, max(0, $pos - 10), 10);
            if (preg_match('/->route|\\$[a-zA-Z0-9_]+->route$/', $before)) {
                continue;
            }
            $used[$name] = $path;
        }
    }
}
$used = array_unique($used);
$missing = [];
foreach ($used as $name => $file) {
    if (!isset($names[$name])) $missing[$name] = $file;
}
if (empty($used)) {
    echo "Aucun nom de route trouvé dans les vues.\n";
    exit(0);
}
if (empty($missing)) {
    echo "OK: toutes les routes référencées dans les vues existent.\n";
    exit(0);
}
echo "ROUTES MANQUANTES:\n";
foreach ($missing as $n => $f) {
    echo $n . ' — ' . $f . "\n";
}
