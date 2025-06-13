<?php
// Pruebas automáticas para controladores
// Ejecuta este archivo con PHPUnit o inclúyelo en tu framework de pruebas

$controllers = [
    'Api', 'Cauth', 'Ccharts', 'Cemail', 'Cmodulos', 'cupload', 'Dashboard', 'Forbidden', 'Home', 'Testing', 'Welcome', 'Zip'
];

foreach ($controllers as $ctrl) {
    $file = __DIR__ . "/../controllers/$ctrl.php";
    if (!file_exists($file)) {
        echo "[FALTA] $ctrl.php\n";
        continue;
    }
    require_once $file;
    if (!class_exists($ctrl)) {
        echo "[ERROR] Clase $ctrl no encontrada en $ctrl.php\n";
        continue;
    }
    try {
        $obj = new $ctrl();
        echo "[OK] $ctrl instanciado correctamente\n";
    } catch (Exception $e) {
        echo "[ERROR] $ctrl: " . $e->getMessage() . "\n";
    }
}
