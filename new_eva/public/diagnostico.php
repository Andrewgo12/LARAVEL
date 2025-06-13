<?php
/**
 * Página de diagnóstico del Sistema HUV
 */

echo "<!DOCTYPE html><html><head><title>Diagnóstico Sistema HUV</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.status { padding: 10px; margin: 10px 0; border-radius: 5px; }
.ok { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
.error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
.warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
.info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
h1, h2 { color: #333; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
th { background-color: #f2f2f2; }
.btn { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px; }
.btn:hover { background: #0056b3; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>🏥 Diagnóstico del Sistema HUV</h1>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";

// 1. Verificar PHP
echo "<h2>1. 🐘 Información de PHP</h2>";
echo "<div class='status ok'>";
echo "<strong>✅ PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>✅ Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>✅ Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>✅ Script Path:</strong> " . __FILE__ . "<br>";
echo "</div>";

// 2. Verificar archivos Laravel
echo "<h2>2. 📁 Archivos de Laravel</h2>";
$laravelFiles = [
    'vendor/autoload.php' => 'Autoloader de Composer',
    'bootstrap/app.php' => 'Bootstrap de Laravel',
    'app/Http/Controllers/CodeIgniterController.php' => 'Controlador Principal',
    'routes/web.php' => 'Rutas Web',
    '.env' => 'Configuración de Entorno'
];

foreach ($laravelFiles as $file => $desc) {
    $exists = file_exists("../$file");
    $class = $exists ? 'ok' : 'error';
    $icon = $exists ? '✅' : '❌';
    echo "<div class='status $class'>$icon <strong>$desc:</strong> $file " . ($exists ? '(Existe)' : '(No encontrado)') . "</div>";
}

// 3. Verificar vistas de CodeIgniter
echo "<h2>3. 👁️ Vistas de CodeIgniter</h2>";
$viewsDir = '../resources/views';
if (is_dir($viewsDir)) {
    echo "<div class='status ok'>✅ <strong>Directorio de vistas encontrado:</strong> $viewsDir</div>";

    $modules = scandir($viewsDir);
    $moduleCount = 0;
    $viewCount = 0;

    echo "<table>";
    echo "<tr><th>Módulo</th><th>Vistas</th><th>Estado</th></tr>";

    foreach ($modules as $module) {
        if ($module != '.' && $module != '..' && is_dir("$viewsDir/$module")) {
            $moduleCount++;
            $moduleViews = glob("$viewsDir/$module/*.php");
            $viewsInModule = count($moduleViews);
            $viewCount += $viewsInModule;

            $status = $viewsInModule > 0 ? '✅ Activo' : '⚠️ Vacío';
            echo "<tr><td>$module</td><td>$viewsInModule vistas</td><td>$status</td></tr>";
        }
    }
    echo "</table>";

    echo "<div class='status info'>";
    echo "<strong>📊 Resumen:</strong><br>";
    echo "• Total de módulos: $moduleCount<br>";
    echo "• Total de vistas: $viewCount<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ <strong>Directorio de vistas no encontrado:</strong> $viewsDir</div>";
}

// 4. Verificar base de datos
echo "<h2>4. 🗄️ Base de Datos MySQL</h2>";
try {
    $host = '127.0.0.1';
    $dbname = 'gestionthuv';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<div class='status ok'>✅ <strong>Conexión exitosa a MySQL</strong></div>";
    echo "<div class='status info'>";
    echo "<strong>Host:</strong> $host<br>";
    echo "<strong>Base de datos:</strong> $dbname<br>";
    echo "<strong>Usuario:</strong> $username<br>";
    echo "</div>";

    // Verificar tablas
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<div class='status info'>";
    echo "<strong>📋 Tablas encontradas:</strong> " . count($tables) . "<br>";
    if (in_array('usuarios', $tables)) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
        $userCount = $stmt->fetchColumn();
        echo "<strong>👥 Usuarios registrados:</strong> $userCount<br>";

        // Mostrar algunos usuarios de ejemplo
        $stmt = $pdo->query("SELECT nombre, email FROM usuarios LIMIT 3");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<strong>👤 Usuarios disponibles:</strong><br>";
        foreach ($users as $user) {
            echo "• {$user['nombre']} ({$user['email']})<br>";
        }
    }
    if (in_array('equipos', $tables)) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM equipos");
        $equiposCount = $stmt->fetchColumn();
        echo "<strong>🔧 Equipos registrados:</strong> $equiposCount<br>";
    }
    echo "</div>";

} catch (PDOException $e) {
    echo "<div class='status error'>❌ <strong>Error de conexión a MySQL:</strong> " . $e->getMessage() . "</div>";
    echo "<div class='status warning'>⚠️ <strong>Solución:</strong> Verificar que XAMPP MySQL esté corriendo</div>";
}

// 5. URLs de prueba
echo "<h2>5. 🔗 URLs de Prueba</h2>";
$baseUrl = "http://" . $_SERVER['HTTP_HOST'];
$testUrls = [
    "$baseUrl/" => "Laravel Principal",
    "$baseUrl/ci/login" => "Login HUV",
    "$baseUrl/ci/home" => "Dashboard HUV",
    "$baseUrl/ci/modules" => "Módulos HUV",
    "$baseUrl/ci/equipos" => "Módulo Equipos",
    "$baseUrl/ci/usuarios" => "Módulo Usuarios"
];

echo "<table>";
echo "<tr><th>URL</th><th>Descripción</th><th>Acción</th></tr>";
foreach ($testUrls as $url => $desc) {
    echo "<tr>";
    echo "<td><code>$url</code></td>";
    echo "<td>$desc</td>";
    echo "<td><a href='$url' class='btn' target='_blank'>🔗 Probar</a></td>";
    echo "</tr>";
}
echo "</table>";

// 6. Información del sistema
echo "<h2>6. ⚙️ Información del Sistema</h2>";
echo "<div class='status info'>";
echo "<strong>🖥️ Sistema Operativo:</strong> " . php_uname() . "<br>";
echo "<strong>📂 Directorio actual:</strong> " . getcwd() . "<br>";
echo "<strong>🕒 Zona horaria:</strong> " . date_default_timezone_get() . "<br>";
echo "<strong>💾 Memoria PHP:</strong> " . ini_get('memory_limit') . "<br>";
echo "<strong>⏱️ Tiempo máximo:</strong> " . ini_get('max_execution_time') . "s<br>";
echo "</div>";

// 7. Extensiones PHP necesarias
echo "<h2>7. 🔌 Extensiones PHP</h2>";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json'];
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    $class = $loaded ? 'ok' : 'error';
    $icon = $loaded ? '✅' : '❌';
    echo "<div class='status $class'>$icon <strong>$ext:</strong> " . ($loaded ? 'Cargada' : 'No disponible') . "</div>";
}

// 8. Acciones recomendadas
echo "<h2>8. 🎯 Acciones Recomendadas</h2>";
echo "<div class='status info'>";
echo "<strong>Para usar el sistema:</strong><br>";
echo "1. <a href='$baseUrl/ci/login' class='btn'>🔐 Ir al Login</a><br><br>";
echo "2. <strong>Credenciales:</strong><br>";
echo "   • Email: admin@huv.com<br>";
echo "   • Contraseña: password<br><br>";
echo "3. <a href='$baseUrl/ci/modules' class='btn'>📋 Ver Todos los Módulos</a><br>";
echo "</div>";

echo "<div class='status warning'>";
echo "<strong>⚠️ Si hay problemas:</strong><br>";
echo "• Verificar que XAMPP Apache y MySQL estén corriendo<br>";
echo "• Ejecutar: <code>composer install</code><br>";
echo "• Ejecutar: <code>php -S 127.0.0.1:8000 -t public</code><br>";
echo "</div>";

echo "</div></body></html>";
?>
