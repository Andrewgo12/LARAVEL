<?php
// Pruebas automáticas para librerías personalizadas
// Ejecuta este archivo con PHPUnit o inclúyelo en tu framework de pruebas

$libraries = [
    'Backend_lib', 'Ci_smarty', 'Excel', 'Format', 'REST_Controller'
];

foreach ($libraries as $lib) {
    $file = __DIR__ . "/../libraries/$lib.php";
    if (!file_exists($file)) {
        echo "[FALTA] $lib.php\n";
        continue;
    }
    require_once $file;
    if (!class_exists($lib)) {
        echo "[ERROR] Clase $lib no encontrada en $lib.php\n";
        continue;
    }
    try {
        $obj = new $lib();
        echo "[OK] $lib instanciada correctamente\n";
    } catch (Exception $e) {
        echo "[ERROR] $lib: " . $e->getMessage() . "\n";
    }
}
