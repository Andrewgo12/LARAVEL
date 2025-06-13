<?php
/**
 * Script de prueba para verificar las vistas corregidas del sistema HUV
 * Este script verifica la sintaxis y estructura de las vistas principales
 */

echo "=== PRUEBA DE VISTAS CORREGIDAS - SISTEMA HUV ===\n\n";

// Función para verificar si un archivo existe y es legible
function verificarArchivo($ruta) {
    if (file_exists($ruta)) {
        echo "✓ Archivo encontrado: $ruta\n";
        return true;
    } else {
        echo "✗ Archivo NO encontrado: $ruta\n";
        return false;
    }
}

// Función para verificar sintaxis Blade básica
function verificarSintaxisBlade($ruta) {
    if (!file_exists($ruta)) {
        return false;
    }
    
    $contenido = file_get_contents($ruta);
    $errores = [];
    
    // Verificar sintaxis PHP mixta (debería estar convertida a Blade)
    if (preg_match('/\<\?php.*?\?\>/', $contenido)) {
        $errores[] = "Contiene sintaxis PHP mixta que debería ser Blade";
    }
    
    // Verificar sintaxis asset() correcta
    if (preg_match('/asset\(\s*[\'\"]\s*[\'\"]\s*\)/', $contenido)) {
        $errores[] = "Contiene asset('') vacío";
    }
    
    // Verificar espacios faltantes en atributos HTML
    if (preg_match('/[a-zA-Z]"[a-zA-Z]/', $contenido)) {
        $errores[] = "Posibles espacios faltantes en atributos HTML";
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

// Lista de archivos a verificar
$archivos_verificar = [
    'resources/views/auth/login.blade.php',
    'resources/views/layouts/app.blade.php',
    'resources/views/app.blade.php',
    'resources/views/blade/layouts/header.blade.php',
    'resources/views/blade/layouts/aside.blade.php',
    'resources/views/blade/layouts/footer.blade.php'
];

echo "1. VERIFICANDO EXISTENCIA DE ARCHIVOS:\n";
echo "=====================================\n";
$archivos_existentes = 0;
foreach ($archivos_verificar as $archivo) {
    if (verificarArchivo($archivo)) {
        $archivos_existentes++;
    }
}

echo "\n2. VERIFICANDO SINTAXIS BLADE:\n";
echo "==============================\n";
$archivos_correctos = 0;
foreach ($archivos_verificar as $archivo) {
    if (verificarSintaxisBlade($archivo)) {
        $archivos_correctos++;
    }
}

echo "\n3. VERIFICANDO VISTAS ESPECÍFICAS:\n";
echo "==================================\n";

// Verificar vista de login
if (file_exists('resources/views/auth/login.blade.php')) {
    $login_content = file_get_contents('resources/views/auth/login.blade.php');
    if (strpos($login_content, 'placeholder="Email" name="Email"') !== false) {
        echo "✓ Vista de login: Espacios en atributos corregidos\n";
    } else {
        echo "✗ Vista de login: Espacios en atributos NO corregidos\n";
    }
    
    if (strpos($login_content, '{{ route(') !== false) {
        echo "✓ Vista de login: Rutas usando sintaxis Blade\n";
    } else {
        echo "✗ Vista de login: Rutas NO usando sintaxis Blade\n";
    }
}

// Verificar layout principal
if (file_exists('resources/views/layouts/app.blade.php')) {
    $layout_content = file_get_contents('resources/views/layouts/app.blade.php');
    if (strpos($layout_content, '@yield(\'content\')') !== false) {
        echo "✓ Layout principal: Usando @yield para contenido\n";
    } else {
        echo "✗ Layout principal: NO usando @yield para contenido\n";
    }
    
    if (strpos($layout_content, 'session(') !== false) {
        echo "✓ Layout principal: Variables de sesión usando helper session()\n";
    } else {
        echo "✗ Layout principal: Variables de sesión NO usando helper session()\n";
    }
}

// Verificar header
if (file_exists('resources/views/blade/layouts/header.blade.php')) {
    $header_content = file_get_contents('resources/views/blade/layouts/header.blade.php');
    if (strpos($header_content, '@if(request()->segment(') !== false) {
        echo "✓ Header: Condiciones convertidas a sintaxis Blade\n";
    } else {
        echo "✗ Header: Condiciones NO convertidas a sintaxis Blade\n";
    }
    
    if (strpos($header_content, 'asset(\'css/') !== false) {
        echo "✓ Header: Assets usando rutas correctas\n";
    } else {
        echo "✗ Header: Assets NO usando rutas correctas\n";
    }
}

echo "\n4. RESUMEN DE RESULTADOS:\n";
echo "=========================\n";
echo "Archivos encontrados: $archivos_existentes/" . count($archivos_verificar) . "\n";
echo "Archivos con sintaxis correcta: $archivos_correctos/" . count($archivos_verificar) . "\n";

$porcentaje_exito = ($archivos_correctos / count($archivos_verificar)) * 100;
echo "Porcentaje de éxito: " . round($porcentaje_exito, 2) . "%\n";

if ($porcentaje_exito >= 80) {
    echo "\n🎉 RESULTADO: Las vistas han sido corregidas exitosamente!\n";
} elseif ($porcentaje_exito >= 60) {
    echo "\n⚠️  RESULTADO: Las vistas han sido parcialmente corregidas. Revisar errores restantes.\n";
} else {
    echo "\n❌ RESULTADO: Las vistas necesitan más correcciones.\n";
}

echo "\n5. RECOMENDACIONES:\n";
echo "===================\n";
echo "- Ejecutar 'php artisan view:clear' para limpiar cache de vistas\n";
echo "- Verificar que todas las rutas estén definidas en web.php\n";
echo "- Probar la carga de cada vista en el navegador\n";
echo "- Revisar logs de Laravel para errores adicionales\n";

echo "\n=== FIN DE LA PRUEBA ===\n";
?>
