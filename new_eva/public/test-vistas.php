<?php
/**
 * Test específico para verificar que las vistas de CodeIgniter cargan sin "No direct script access allowed"
 */

// Definir constantes de CodeIgniter
if (!defined('BASEPATH')) {
    define('BASEPATH', __DIR__ . '/../');
}
if (!defined('APPPATH')) {
    define('APPPATH', __DIR__ . '/../app/');
}
if (!defined('VIEWPATH')) {
    define('VIEWPATH', __DIR__ . '/../resources/views/');
}
if (!defined('FCPATH')) {
    define('FCPATH', __DIR__ . '/');
}

// Función helper base_url()
if (!function_exists('base_url')) {
    function base_url($uri = '') {
        return 'http://127.0.0.1:8000/ci/' . $uri;
    }
}

echo "<!DOCTYPE html><html><head><title>Test Vistas CodeIgniter</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.test { padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
.success { background: #d4edda; border-left-color: #28a745; }
.error { background: #f8d7da; border-left-color: #dc3545; }
.warning { background: #fff3cd; border-left-color: #ffc107; }
.view-content { background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0; max-height: 200px; overflow-y: auto; }
h1, h2 { color: #333; }
.btn { background: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>🧪 Test de Vistas CodeIgniter</h1>";
echo "<p><strong>Objetivo:</strong> Verificar que las vistas cargan sin 'No direct script access allowed'</p>";

// Test 1: Vista de Login
echo "<h2>1. 🔐 Test Vista Login (Vlogin.php)</h2>";
$loginPath = __DIR__ . '/../resources/views/Vlogin.php';
if (file_exists($loginPath)) {
    echo "<div class='test success'>✅ <strong>Archivo encontrado:</strong> $loginPath</div>";
    
    try {
        ob_start();
        include $loginPath;
        $content = ob_get_clean();
        
        if (strpos($content, 'No direct script access allowed') !== false) {
            echo "<div class='test error'>❌ <strong>ERROR:</strong> Vista muestra 'No direct script access allowed'</div>";
        } else {
            echo "<div class='test success'>✅ <strong>ÉXITO:</strong> Vista carga correctamente sin errores</div>";
            echo "<div class='test'>📊 <strong>Contenido capturado:</strong> " . strlen($content) . " caracteres</div>";
            
            if (strlen($content) > 100) {
                echo "<div class='view-content'>";
                echo "<strong>Vista renderizada (primeros 500 caracteres):</strong><br>";
                echo "<code>" . htmlspecialchars(substr($content, 0, 500)) . "...</code>";
                echo "</div>";
            }
        }
    } catch (Exception $e) {
        echo "<div class='test error'>❌ <strong>ERROR al cargar vista:</strong> " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='test error'>❌ <strong>Archivo no encontrado:</strong> $loginPath</div>";
}

// Test 2: Vista de Admin Home
echo "<h2>2. 🏠 Test Vista Admin Home</h2>";
$homePath = __DIR__ . '/../resources/views/admin/home.php';
if (file_exists($homePath)) {
    echo "<div class='test success'>✅ <strong>Archivo encontrado:</strong> $homePath</div>";
    
    try {
        ob_start();
        include $homePath;
        $content = ob_get_clean();
        
        if (strpos($content, 'No direct script access allowed') !== false) {
            echo "<div class='test error'>❌ <strong>ERROR:</strong> Vista muestra 'No direct script access allowed'</div>";
        } else {
            echo "<div class='test success'>✅ <strong>ÉXITO:</strong> Vista carga correctamente sin errores</div>";
            echo "<div class='test'>📊 <strong>Contenido capturado:</strong> " . strlen($content) . " caracteres</div>";
        }
    } catch (Exception $e) {
        echo "<div class='test error'>❌ <strong>ERROR al cargar vista:</strong> " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='test error'>❌ <strong>Archivo no encontrado:</strong> $homePath</div>";
}

// Test 3: Vista de Equipos
echo "<h2>3. 🔧 Test Vista Equipos</h2>";
$equiposPath = __DIR__ . '/../resources/views/equipos';
if (is_dir($equiposPath)) {
    $equiposFiles = glob($equiposPath . '/*.php');
    echo "<div class='test success'>✅ <strong>Directorio encontrado:</strong> " . count($equiposFiles) . " archivos PHP</div>";
    
    if (count($equiposFiles) > 0) {
        $testFile = $equiposFiles[0]; // Probar el primer archivo
        $fileName = basename($testFile);
        echo "<div class='test'>🧪 <strong>Probando archivo:</strong> $fileName</div>";
        
        try {
            ob_start();
            include $testFile;
            $content = ob_get_clean();
            
            if (strpos($content, 'No direct script access allowed') !== false) {
                echo "<div class='test error'>❌ <strong>ERROR:</strong> Vista muestra 'No direct script access allowed'</div>";
            } else {
                echo "<div class='test success'>✅ <strong>ÉXITO:</strong> Vista carga correctamente sin errores</div>";
                echo "<div class='test'>📊 <strong>Contenido capturado:</strong> " . strlen($content) . " caracteres</div>";
            }
        } catch (Exception $e) {
            echo "<div class='test error'>❌ <strong>ERROR al cargar vista:</strong> " . $e->getMessage() . "</div>";
        }
    }
} else {
    echo "<div class='test error'>❌ <strong>Directorio no encontrado:</strong> $equiposPath</div>";
}

// Test 4: Constantes definidas
echo "<h2>4. 🔧 Test Constantes CodeIgniter</h2>";
$constants = ['BASEPATH', 'APPPATH', 'VIEWPATH', 'FCPATH'];
foreach ($constants as $const) {
    if (defined($const)) {
        echo "<div class='test success'>✅ <strong>$const:</strong> " . constant($const) . "</div>";
    } else {
        echo "<div class='test error'>❌ <strong>$const:</strong> No definida</div>";
    }
}

// Test 5: Función base_url
echo "<h2>5. 🌐 Test Función base_url()</h2>";
if (function_exists('base_url')) {
    echo "<div class='test success'>✅ <strong>Función base_url() disponible</strong></div>";
    echo "<div class='test'>🔗 <strong>base_url():</strong> " . base_url() . "</div>";
    echo "<div class='test'>🔗 <strong>base_url('login'):</strong> " . base_url('login') . "</div>";
} else {
    echo "<div class='test error'>❌ <strong>Función base_url() no disponible</strong></div>";
}

// Resumen y enlaces
echo "<h2>6. 🎯 Resumen y Acciones</h2>";
echo "<div class='test'>";
echo "<strong>✅ Si todos los tests son exitosos:</strong> Las vistas de CodeIgniter cargarán sin errores<br>";
echo "<strong>❌ Si hay errores:</strong> Revisar la definición de constantes en el controlador<br><br>";
echo "<strong>🔗 Enlaces de prueba:</strong><br>";
echo "<a href='/ci/login' class='btn'>🔐 Probar Login Real</a>";
echo "<a href='/ci/home' class='btn'>🏠 Probar Home Real</a>";
echo "<a href='/ci/equipos' class='btn'>🔧 Probar Equipos Real</a>";
echo "<a href='/diagnostico.php' class='btn'>📊 Diagnóstico Completo</a>";
echo "</div>";

echo "</div></body></html>";
?>
