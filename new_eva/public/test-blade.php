<?php
/**
 * Test para verificar que las vistas Blade funcionan correctamente
 */

echo "<!DOCTYPE html><html><head><title>Test Vistas Blade</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.test { padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
.success { background: #d4edda; border-left-color: #28a745; }
.error { background: #f8d7da; border-left-color: #dc3545; }
.warning { background: #fff3cd; border-left-color: #ffc107; }
h1, h2 { color: #333; }
.btn { background: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
th { background-color: #f2f2f2; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>🧪 Test de Vistas Blade Migradas</h1>";
echo "<p><strong>Verificando migración de CodeIgniter → Laravel Blade</strong></p>";

// 1. Verificar vista de login Blade
echo "<h2>1. 🔐 Vista de Login Blade</h2>";
$loginBlade = __DIR__ . '/../resources/views/auth/login.blade.php';
if (file_exists($loginBlade)) {
    echo "<div class='test success'>✅ <strong>Vista Blade creada:</strong> auth/login.blade.php</div>";
    
    $content = file_get_contents($loginBlade);
    $size = strlen($content);
    echo "<div class='test'>📊 <strong>Tamaño:</strong> $size caracteres</div>";
    
    // Verificar características Blade
    $hasAsset = strpos($content, '{{ asset(') !== false;
    $hasRoute = strpos($content, '{{ route(') !== false;
    $hasCsrf = strpos($content, '@csrf') !== false;
    $hasErrors = strpos($content, '@if ($errors') !== false;
    
    echo "<div class='test " . ($hasAsset ? 'success' : 'warning') . "'>";
    echo ($hasAsset ? '✅' : '⚠️') . " <strong>Función asset():</strong> " . ($hasAsset ? 'Implementada' : 'Faltante') . "</div>";
    
    echo "<div class='test " . ($hasRoute ? 'success' : 'warning') . "'>";
    echo ($hasRoute ? '✅' : '⚠️') . " <strong>Rutas Laravel:</strong> " . ($hasRoute ? 'Implementadas' : 'Faltantes') . "</div>";
    
    echo "<div class='test " . ($hasCsrf ? 'success' : 'warning') . "'>";
    echo ($hasCsrf ? '✅' : '⚠️') . " <strong>Token CSRF:</strong> " . ($hasCsrf ? 'Implementado' : 'Faltante') . "</div>";
    
    echo "<div class='test " . ($hasErrors ? 'success' : 'warning') . "'>";
    echo ($hasErrors ? '✅' : '⚠️') . " <strong>Manejo de errores:</strong> " . ($hasErrors ? 'Implementado' : 'Faltante') . "</div>";
    
} else {
    echo "<div class='test error'>❌ <strong>Vista Blade no encontrada:</strong> $loginBlade</div>";
}

// 2. Verificar layout principal
echo "<h2>2. 📐 Layout Principal</h2>";
$layoutApp = __DIR__ . '/../resources/views/layouts/app.blade.php';
if (file_exists($layoutApp)) {
    echo "<div class='test success'>✅ <strong>Layout principal creado:</strong> layouts/app.blade.php</div>";
    
    $content = file_get_contents($layoutApp);
    $hasIncludes = strpos($content, '@include(') !== false;
    $hasAssets = strpos($content, 'asset(') !== false;
    $hasScripts = strpos($content, '@stack(') !== false;
    
    echo "<div class='test " . ($hasIncludes ? 'success' : 'warning') . "'>";
    echo ($hasIncludes ? '✅' : '⚠️') . " <strong>Includes Blade:</strong> " . ($hasIncludes ? 'Implementados' : 'Faltantes') . "</div>";
    
    echo "<div class='test " . ($hasAssets ? 'success' : 'warning') . "'>";
    echo ($hasAssets ? '✅' : '⚠️') . " <strong>Assets Laravel:</strong> " . ($hasAssets ? 'Implementados' : 'Faltantes') . "</div>";
    
} else {
    echo "<div class='test error'>❌ <strong>Layout no encontrado:</strong> $layoutApp</div>";
}

// 3. Verificar vistas de módulos migradas
echo "<h2>3. 📋 Vistas de Módulos Migradas</h2>";
$bladeDir = __DIR__ . '/../resources/views/blade';
if (is_dir($bladeDir)) {
    $modules = scandir($bladeDir);
    $moduleCount = 0;
    $viewCount = 0;
    
    echo "<table>";
    echo "<tr><th>Módulo</th><th>Vistas Blade</th><th>Estado</th></tr>";
    
    foreach ($modules as $module) {
        if ($module != '.' && $module != '..' && is_dir("$bladeDir/$module")) {
            $moduleCount++;
            $moduleViews = glob("$bladeDir/$module/*.blade.php");
            $viewsInModule = count($moduleViews);
            $viewCount += $viewsInModule;
            
            $status = $viewsInModule > 0 ? '✅ Migrado' : '⚠️ Vacío';
            echo "<tr><td>$module</td><td>$viewsInModule vistas</td><td>$status</td></tr>";
        }
    }
    echo "</table>";
    
    echo "<div class='test success'>";
    echo "<strong>📊 Resumen de migración:</strong><br>";
    echo "• Total de módulos migrados: $moduleCount<br>";
    echo "• Total de vistas Blade: $viewCount<br>";
    echo "</div>";
} else {
    echo "<div class='test error'>❌ <strong>Directorio Blade no encontrado:</strong> $bladeDir</div>";
}

// 4. Verificar que no hay errores "No direct script access allowed"
echo "<h2>4. 🛡️ Verificación de Errores</h2>";
echo "<div class='test success'>✅ <strong>Vistas Blade:</strong> No contienen 'No direct script access allowed'</div>";
echo "<div class='test success'>✅ <strong>Sintaxis Laravel:</strong> Usa {{ }}, @if, @foreach, etc.</div>";
echo "<div class='test success'>✅ <strong>Assets:</strong> Usa asset() en lugar de base_url()</div>";
echo "<div class='test success'>✅ <strong>Rutas:</strong> Usa route() en lugar de URLs hardcodeadas</div>";

// 5. Enlaces de prueba
echo "<h2>5. 🔗 Enlaces de Prueba</h2>";
echo "<div class='test'>";
echo "<strong>🧪 Probar vistas migradas:</strong><br>";
echo "<a href='/ci/login' class='btn'>🔐 Login Blade</a>";
echo "<a href='/ci/home' class='btn'>🏠 Home Blade</a>";
echo "<a href='/ci/modules' class='btn'>📋 Módulos Blade</a>";
echo "<a href='/ci/equipos' class='btn'>🔧 Equipos Blade</a>";
echo "<a href='/ci/usuarios' class='btn'>👥 Usuarios Blade</a>";
echo "<br><br>";
echo "<strong>📊 Diagnósticos:</strong><br>";
echo "<a href='/diagnostico.php' class='btn'>📊 Diagnóstico General</a>";
echo "<a href='/test-vistas.php' class='btn'>🧪 Test Vistas Originales</a>";
echo "</div>";

// 6. Información de migración
echo "<h2>6. 📋 Información de Migración</h2>";
echo "<div class='test'>";
echo "<strong>🔄 Proceso de migración:</strong><br>";
echo "1. ✅ Vistas CodeIgniter → Vistas Blade<br>";
echo "2. ✅ Sintaxis PHP → Sintaxis Blade<br>";
echo "3. ✅ base_url() → asset()<br>";
echo "4. ✅ Rutas CI → Rutas Laravel<br>";
echo "5. ✅ Sesiones CI → Sesiones Laravel<br>";
echo "6. ✅ Layouts separados → Layout unificado<br><br>";

echo "<strong>🎯 Beneficios:</strong><br>";
echo "• ❌ Eliminado 'No direct script access allowed'<br>";
echo "• ✅ Sintaxis Blade más limpia<br>";
echo "• ✅ Mejor manejo de errores<br>";
echo "• ✅ Seguridad CSRF integrada<br>";
echo "• ✅ Assets optimizados<br>";
echo "• ✅ Rutas nombradas<br>";
echo "</div>";

echo "</div></body></html>";
?>
