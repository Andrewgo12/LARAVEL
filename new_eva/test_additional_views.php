<?php
/**
 * Script de prueba adicional para verificar más vistas del sistema HUV
 */

echo "=== PRUEBA ADICIONAL DE VISTAS - SISTEMA HUV ===\n\n";

// Función para verificar sintaxis mixta PHP/HTML
function verificarSintaxisMixta($ruta) {
    if (!file_exists($ruta)) {
        return false;
    }
    
    $contenido = file_get_contents($ruta);
    $errores = [];
    
    // Verificar sintaxis PHP mixta
    if (preg_match('/\$this->session->userdata/', $contenido)) {
        $errores[] = "Usa \$this->session->userdata() en lugar de session()";
    }
    
    if (preg_match('/\$this->uri->segment/', $contenido)) {
        $errores[] = "Usa \$this->uri->segment() en lugar de request()->segment()";
    }
    
    if (preg_match('/base_url\(\)/', $contenido)) {
        $errores[] = "Usa base_url() en lugar de url() o asset()";
    }
    
    if (preg_match('/\<\?php.*foreach.*\?\>/', $contenido)) {
        $errores[] = "Usa foreach PHP en lugar de @foreach Blade";
    }
    
    if (preg_match('/\<\?php.*if.*\?\>/', $contenido)) {
        $errores[] = "Usa if PHP en lugar de @if Blade";
    }
    
    if (empty($errores)) {
        echo "✓ Sintaxis correcta: $ruta\n";
        return true;
    } else {
        echo "✗ Errores en $ruta:\n";
        foreach ($errores as $error) {
            echo "  - $error\n";
        }
        return false;
    }
}

// Lista de vistas adicionales importantes
$vistas_adicionales = [
    'resources/views/equipos/list.php',
    'resources/views/equipos/modal_add.php',
    'resources/views/ordenes/list.php',
    'resources/views/admin/dashboard.php',
    'resources/views/usuarios/list.php',
    'resources/views/reportes/list.php'
];

echo "1. VERIFICANDO VISTAS ADICIONALES:\n";
echo "===================================\n";

$vistas_encontradas = 0;
$vistas_corregidas = 0;

foreach ($vistas_adicionales as $vista) {
    if (file_exists($vista)) {
        echo "✓ Encontrada: $vista\n";
        $vistas_encontradas++;
        
        if (verificarSintaxisMixta($vista)) {
            $vistas_corregidas++;
        }
    } else {
        echo "✗ No encontrada: $vista\n";
    }
}

echo "\n2. VERIFICANDO VISTAS DE MODALES:\n";
echo "=================================\n";

$modales = glob('resources/views/*/modal_*.php');
$modales_corregidos = 0;

foreach (array_slice($modales, 0, 5) as $modal) { // Solo los primeros 5 para no saturar
    if (verificarSintaxisMixta($modal)) {
        $modales_corregidos++;
    }
}

echo "\n3. VERIFICANDO VISTAS DE LISTADOS:\n";
echo "==================================\n";

$listados = glob('resources/views/*/list.php');
$listados_corregidos = 0;

foreach (array_slice($listados, 0, 5) as $listado) { // Solo los primeros 5
    if (verificarSintaxisMixta($listado)) {
        $listados_corregidos++;
    }
}

echo "\n4. RESUMEN GENERAL:\n";
echo "===================\n";
echo "Vistas adicionales encontradas: $vistas_encontradas/" . count($vistas_adicionales) . "\n";
echo "Vistas adicionales corregidas: $vistas_corregidas/$vistas_encontradas\n";

if ($vistas_encontradas > 0) {
    $porcentaje_adicional = ($vistas_corregidas / $vistas_encontradas) * 100;
    echo "Porcentaje de corrección adicional: " . round($porcentaje_adicional, 2) . "%\n";
}

echo "\n5. PRÓXIMOS PASOS RECOMENDADOS:\n";
echo "===============================\n";
echo "- Convertir vistas .php restantes a .blade.php\n";
echo "- Actualizar rutas en web.php para usar las nuevas vistas\n";
echo "- Probar funcionalidad completa del sistema\n";
echo "- Verificar que todos los modales funcionen correctamente\n";
echo "- Revisar y corregir vistas de reportes y administración\n";

echo "\n=== FIN DE LA PRUEBA ADICIONAL ===\n";
?>
