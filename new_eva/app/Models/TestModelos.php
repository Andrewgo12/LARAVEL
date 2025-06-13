<?php
// Archivo de pruebas automáticas para modelos
// Ejecuta este archivo con PHPUnit o inclúyelo en tu framework de pruebas

// Carga el framework de pruebas si es necesario
// require 'vendor/autoload.php';

// Lista de modelos a probar
glob_models = [
    'Macciones', 'Madquisiciones', 'Marchivos', 'Mareas', 'Mavances_correctivos', 'Mbajas', 'Mcalibraciones',
    'Mcambios_hdv', 'Mcambios_ubicaciones', 'Mcapacitaciones', 'Mcategorias', 'Mcbiomedicas', 'Mcentros',
    'Mcierres', 'Mclientes', 'Mcontactos', 'Mcontingencias', 'Mcorrectivos_generales', 'Mcorrectivos_generales_archivos',
    'Mcriesgos', 'Mdiagnosticos', 'Mempresas', 'Mequipos', 'Mequipos_ind', 'Mequipo_archivos', 'Mequipo_contactos',
    'Mequipo_especificaciones', 'Mequipo_repuestos', 'Mespecificaciones', 'Mestadoequipos', 'Mestados', 'Mfrecuencias',
    'Mfuentes', 'Mguias', 'Minvimas', 'Mmanuales', 'Mmodulos', 'Mmovimientos', 'Mobservaciones', 'Mordenes',
    'Mordenes_compra', 'Mpaises', 'Mperiodos_garantias', 'Mpermisos', 'Mpisos', 'Mplanes', 'Mpreventivos',
    'Mpropietarios', 'Mproveedores_mantenimiento', 'Mrepuestos', 'Mrepuestos_pendientes', 'Mrepuestos_ti', 'Msedes',
    'Mservicios', 'Mtecnicos', 'Mtecnologias', 'Mtipos_compra', 'Mtipos_estados', 'Mtipos_fallas', 'Mtrabajos',
    'Mupload', 'Musuarios', 'Musuarios_zonas', 'Mzonas'
];

foreach ($glob_models as $model) {
    $file = __DIR__ . "/$model.php";
    if (!file_exists($file)) {
        echo "[FALTA] $model.php\n";
        continue;
    }
    require_once $file;
    if (!class_exists($model)) {
        echo "[ERROR] Clase $model no encontrada en $model.php\n";
        continue;
    }
    try {
        $obj = new $model();
        echo "[OK] $model instanciado correctamente\n";
    } catch (Exception $e) {
        echo "[ERROR] $model: " . $e->getMessage() . "\n";
    }
}
