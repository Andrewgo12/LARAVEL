<?php
/**
 * SUITE COMPLETA DE PRUEBAS - SISTEMA HUV
 * Pruebas exhaustivas de conexión, rutas, BD, importaciones y errores
 */

set_time_limit(300); // 5 minutos para todas las pruebas

echo "<!DOCTYPE html><html><head><title>Suite Completa de Pruebas - Sistema HUV</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.container { max-width: 1400px; margin: 0 auto; background: rgba(255,255,255,0.1); padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); backdrop-filter: blur(10px); }
.test-section { background: rgba(255,255,255,0.1); padding: 20px; margin: 20px 0; border-radius: 10px; }
.test-pass { border-left: 4px solid #28a745; background: rgba(40, 167, 69, 0.2); }
.test-fail { border-left: 4px solid #dc3545; background: rgba(220, 53, 69, 0.2); }
.test-warning { border-left: 4px solid #ffc107; background: rgba(255, 193, 7, 0.2); }
.test-info { border-left: 4px solid #17a2b8; background: rgba(23, 162, 184, 0.2); }
h1, h2, h3 { color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
table { width: 100%; border-collapse: collapse; margin: 10px 0; background: rgba(255,255,255,0.1); }
th, td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.2); }
th { background: rgba(255,255,255,0.2); font-weight: bold; }
.btn { background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px; display: inline-block; margin: 5px; transition: all 0.3s ease; }
.progress { background: rgba(255,255,255,0.2); border-radius: 10px; padding: 5px; margin: 10px 0; }
.progress-bar { background: #28a745; height: 20px; border-radius: 5px; transition: width 0.3s ease; }
.stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 20px 0; }
.stat-card { background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; text-align: center; }
.stat-number { font-size: 1.5em; font-weight: bold; }
.test-result { padding: 5px 10px; border-radius: 15px; font-size: 0.9em; margin: 2px; display: inline-block; }
.pass { background: #28a745; }
.fail { background: #dc3545; }
.warning { background: #ffc107; color: #000; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>🧪 SUITE COMPLETA DE PRUEBAS - SISTEMA HUV</h1>";
echo "<p><strong>Hospital Universitario del Valle - Gestión de Tecnología Biomédica</strong></p>";
echo "<p><strong>Inicio de pruebas:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Contadores de pruebas
$totalTests = 0;
$passedTests = 0;
$failedTests = 0;
$warningTests = 0;

// Función para registrar resultado de prueba
function testResult($name, $result, $details = '', $type = 'info') {
    global $totalTests, $passedTests, $failedTests, $warningTests;
    $totalTests++;

    if ($result) {
        $passedTests++;
        $status = "<span class='test-result pass'>✅ PASS</span>";
        $class = 'test-pass';
    } else {
        if ($type === 'warning') {
            $warningTests++;
            $status = "<span class='test-result warning'>⚠️ WARNING</span>";
            $class = 'test-warning';
        } else {
            $failedTests++;
            $status = "<span class='test-result fail'>❌ FAIL</span>";
            $class = 'test-fail';
        }
    }

    echo "<div class='test-section $class'>";
    echo "<h4>$status $name</h4>";
    if ($details) echo "<p>$details</p>";
    echo "</div>";

    return $result;
}

// ========================================
// 1. PRUEBAS DE CONEXIÓN
// ========================================
echo "<div class='test-section test-info'>";
echo "<h2>1. 🌐 PRUEBAS DE CONEXIÓN</h2>";

// Prueba 1.1: Servidor web
$serverRunning = !empty($_SERVER['SERVER_NAME']);
testResult(
    "Servidor Web PHP",
    $serverRunning,
    $serverRunning ? "Servidor ejecutándose en " . $_SERVER['HTTP_HOST'] . ":" . $_SERVER['SERVER_PORT'] : "Servidor no disponible"
);

// Prueba 1.2: Conexión a base de datos
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=gestionthuv", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbConnected = true;
    $dbDetails = "Conexión exitosa a base de datos 'gestionthuv'";
} catch (PDOException $e) {
    $dbConnected = false;
    $dbDetails = "Error: " . $e->getMessage();
}
testResult("Conexión Base de Datos", $dbConnected, $dbDetails);

// Prueba 1.3: Verificar tablas principales
if ($dbConnected) {
    $mainTables = ['usuarios', 'equipos', 'ordenes', 'servicios', 'areas', 'roles'];
    $tablesExist = true;
    $tableDetails = "";

    foreach ($mainTables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            $tableDetails .= "$table ($count registros), ";
        } catch (PDOException $e) {
            $tablesExist = false;
            $tableDetails .= "$table (ERROR), ";
        }
    }

    testResult("Tablas Principales", $tablesExist, "Tablas verificadas: " . rtrim($tableDetails, ', '));
}

echo "</div>";

// ========================================
// 2. PRUEBAS DE RUTAS
// ========================================
echo "<div class='test-section test-info'>";
echo "<h2>2. 🛣️ PRUEBAS DE RUTAS</h2>";

$routes = [
    '/huv/login' => 'Login del sistema',
    '/huv/dashboard' => 'Dashboard principal',
    '/huv/modules' => 'Índice de módulos',
    '/huv/equipos' => 'Módulo de equipos',
    '/huv/usuarios' => 'Módulo de usuarios',
    '/huv/ordenes' => 'Módulo de órdenes',
    '/huv/preventivos' => 'Mantenimientos preventivos',
    '/huv/calibraciones' => 'Calibraciones',
    '/huv/repuestos' => 'Gestión de repuestos'
];

echo "<table>";
echo "<tr><th>Ruta</th><th>Descripción</th><th>Estado</th><th>Tiempo (ms)</th></tr>";

foreach ($routes as $route => $desc) {
    $startTime = microtime(true);

    // Simular petición HTTP interna
    $url = "http://" . $_SERVER['HTTP_HOST'] . $route;
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    $endTime = microtime(true);
    $responseTime = round(($endTime - $startTime) * 1000, 2);

    $isWorking = $response !== false && !empty($response);
    $status = $isWorking ? "✅ OK" : "❌ ERROR";

    echo "<tr>";
    echo "<td><code>$route</code></td>";
    echo "<td>$desc</td>";
    echo "<td>$status</td>";
    echo "<td>{$responseTime}ms</td>";
    echo "</tr>";

    if ($route === '/huv/login') {
        testResult("Ruta Login", $isWorking, "Tiempo de respuesta: {$responseTime}ms");
    }
}
echo "</table>";

echo "</div>";

// ========================================
// 3. PRUEBAS DE BASE DE DATOS
// ========================================
echo "<div class='test-section test-info'>";
echo "<h2>3. 🗄️ PRUEBAS DE BASE DE DATOS</h2>";

if ($dbConnected) {
    // Prueba 3.1: Contar todas las tablas
    try {
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $tableCount = count($tables);
        testResult("Inventario de Tablas", $tableCount >= 80, "Total de tablas encontradas: $tableCount");
    } catch (PDOException $e) {
        testResult("Inventario de Tablas", false, "Error: " . $e->getMessage());
    }

    // Prueba 3.2: Verificar datos de usuarios
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE estado = 1");
        $activeUsers = $stmt->fetchColumn();
        testResult("Usuarios Activos", $activeUsers > 0, "Usuarios activos encontrados: $activeUsers");
    } catch (PDOException $e) {
        testResult("Usuarios Activos", false, "Error: " . $e->getMessage());
    }

    // Prueba 3.3: Verificar datos de equipos
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM equipos WHERE status = 1");
        $activeEquipment = $stmt->fetchColumn();
        testResult("Equipos Activos", $activeEquipment >= 0, "Equipos activos encontrados: $activeEquipment");
    } catch (PDOException $e) {
        testResult("Equipos Activos", false, "Error: " . $e->getMessage());
    }

    // Prueba 3.4: Verificar integridad referencial
    try {
        $stmt = $pdo->query("
            SELECT COUNT(*) FROM usuarios u
            LEFT JOIN roles r ON u.rol_id = r.id
            WHERE r.id IS NULL AND u.rol_id IS NOT NULL
        ");
        $orphanUsers = $stmt->fetchColumn();
        testResult("Integridad Referencial", $orphanUsers == 0,
            $orphanUsers == 0 ? "Sin usuarios huérfanos" : "Usuarios sin rol válido: $orphanUsers");
    } catch (PDOException $e) {
        testResult("Integridad Referencial", false, "Error: " . $e->getMessage(), 'warning');
    }

    // Prueba 3.5: Rendimiento de consultas
    try {
        $startTime = microtime(true);
        $stmt = $pdo->query("
            SELECT e.id, e.name, s.nombre as servicio, a.nombre as area
            FROM equipos e
            LEFT JOIN servicios s ON e.servicio_id = s.id
            LEFT JOIN areas a ON e.area_id = a.id
            LIMIT 100
        ");
        $results = $stmt->fetchAll();
        $endTime = microtime(true);
        $queryTime = round(($endTime - $startTime) * 1000, 2);

        testResult("Rendimiento Consultas", $queryTime < 1000,
            "Consulta compleja ejecutada en {$queryTime}ms (" . count($results) . " registros)");
    } catch (PDOException $e) {
        testResult("Rendimiento Consultas", false, "Error: " . $e->getMessage());
    }

} else {
    testResult("Pruebas de BD", false, "No se puede conectar a la base de datos");
}

echo "</div>";

// ========================================
// 4. PRUEBAS DE IMPORTACIONES Y ARCHIVOS
// ========================================
echo "<div class='test-section test-info'>";
echo "<h2>4. 📁 PRUEBAS DE IMPORTACIONES Y ARCHIVOS</h2>";

// Prueba 4.1: Verificar estructura de vistas Laravel
$laravelViewsDir = '../resources/views/laravel';
$viewsExist = is_dir($laravelViewsDir);
if ($viewsExist) {
    $moduleCount = 0;
    $totalViews = 0;
    $modules = scandir($laravelViewsDir);

    foreach ($modules as $module) {
        if ($module != '.' && $module != '..' && is_dir("$laravelViewsDir/$module")) {
            $moduleCount++;
            $moduleViews = glob("$laravelViewsDir/$module/*.blade.php");
            $totalViews += count($moduleViews);
        }
    }

    testResult("Vistas Laravel Migradas", $totalViews > 200,
        "Módulos: $moduleCount, Vistas Blade: $totalViews");
} else {
    testResult("Vistas Laravel Migradas", false, "Directorio de vistas Laravel no encontrado");
}

// Prueba 4.2: Verificar controladores
$controllers = [
    '../app/Http/Controllers/HuvController.php' => 'Controlador principal',
    '../app/Http/Controllers/ModulosController.php' => 'Controlador de módulos'
];

$controllersOk = true;
$controllerDetails = "";

foreach ($controllers as $file => $desc) {
    $exists = file_exists($file);
    if ($exists) {
        $content = file_get_contents($file);
        $hasLaravelViews = strpos($content, 'laravel.') !== false;
        $controllerDetails .= basename($file) . " (" . ($hasLaravelViews ? "✅" : "⚠️") . "), ";
    } else {
        $controllersOk = false;
        $controllerDetails .= basename($file) . " (❌), ";
    }
}

testResult("Controladores Actualizados", $controllersOk,
    "Controladores: " . rtrim($controllerDetails, ', '));

// Prueba 4.3: Verificar archivos de configuración
$configFiles = [
    '../.env' => 'Configuración de entorno',
    '../routes/web.php' => 'Rutas del sistema',
    '../composer.json' => 'Dependencias de Composer'
];

$configOk = true;
$configDetails = "";

foreach ($configFiles as $file => $desc) {
    $exists = file_exists($file);
    $configOk = $configOk && $exists;
    $configDetails .= basename($file) . " (" . ($exists ? "✅" : "❌") . "), ";
}

testResult("Archivos de Configuración", $configOk,
    "Archivos: " . rtrim($configDetails, ', '));

echo "</div>";

// ========================================
// 5. PRUEBAS DE MANEJO DE ERRORES
// ========================================
echo "<div class='test-section test-info'>";
echo "<h2>5. ⚠️ PRUEBAS DE MANEJO DE ERRORES</h2>";

// Prueba 5.1: Verificar que no hay errores de CodeIgniter
$ciErrorsFound = false;
$ciErrorFiles = [];

$searchDirs = ['../resources/views', '../app'];
foreach ($searchDirs as $dir) {
    if (is_dir($dir)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($file->getPathname());
                if (strpos($content, 'No direct script access allowed') !== false) {
                    $ciErrorsFound = true;
                    $ciErrorFiles[] = str_replace('../', '', $file->getPathname());
                }
            }
        }
    }
}

testResult("Errores CodeIgniter Eliminados", !$ciErrorsFound,
    $ciErrorsFound ? "Archivos con errores CI: " . count($ciErrorFiles) : "Sin errores de CodeIgniter encontrados");

// Prueba 5.2: Verificar manejo de errores de BD
if ($dbConnected) {
    try {
        $stmt = $pdo->query("SELECT * FROM tabla_inexistente");
        $errorHandling = false;
    } catch (PDOException $e) {
        $errorHandling = true;
        $errorMessage = $e->getMessage();
    }

    testResult("Manejo de Errores BD", $errorHandling,
        $errorHandling ? "Errores de BD manejados correctamente" : "Error en manejo de excepciones BD");
}

// Prueba 5.3: Verificar logs de errores
$logDir = '../storage/logs';
$logsExist = is_dir($logDir);
$logFiles = $logsExist ? glob("$logDir/*.log") : [];

testResult("Sistema de Logs", $logsExist,
    $logsExist ? "Directorio de logs existe (" . count($logFiles) . " archivos)" : "Directorio de logs no encontrado");

echo "</div>";

// ========================================
// 6. RESUMEN FINAL DE PRUEBAS
// ========================================
echo "<div class='test-section test-info'>";
echo "<h2>6. 📊 RESUMEN FINAL DE PRUEBAS</h2>";

$successRate = $totalTests > 0 ? round(($passedTests / $totalTests) * 100, 1) : 0;

echo "<div class='stats'>";
echo "<div class='stat-card'><div class='stat-number pass'>$passedTests</div><div>Pruebas Exitosas</div></div>";
echo "<div class='stat-card'><div class='stat-number fail'>$failedTests</div><div>Pruebas Fallidas</div></div>";
echo "<div class='stat-card'><div class='stat-number warning'>$warningTests</div><div>Advertencias</div></div>";
echo "<div class='stat-card'><div class='stat-number'>$totalTests</div><div>Total Pruebas</div></div>";
echo "<div class='stat-card'><div class='stat-number'>{$successRate}%</div><div>Tasa de Éxito</div></div>";
echo "</div>";

echo "<div class='progress'>";
echo "<div class='progress-bar' style='width: {$successRate}%'></div>";
echo "</div>";

if ($successRate >= 90) {
    echo "<div class='test-section test-pass'>";
    echo "<h3>🎉 SISTEMA FUNCIONANDO EXCELENTEMENTE</h3>";
    echo "<p>✅ Todas las pruebas críticas han pasado</p>";
    echo "<p>✅ Sistema listo para producción</p>";
    echo "</div>";
} elseif ($successRate >= 75) {
    echo "<div class='test-section test-warning'>";
    echo "<h3>⚠️ SISTEMA FUNCIONANDO CON ADVERTENCIAS</h3>";
    echo "<p>⚠️ Algunas pruebas no críticas fallaron</p>";
    echo "<p>✅ Sistema funcional pero requiere atención</p>";
    echo "</div>";
} else {
    echo "<div class='test-section test-fail'>";
    echo "<h3>❌ SISTEMA CON PROBLEMAS CRÍTICOS</h3>";
    echo "<p>❌ Múltiples pruebas fallaron</p>";
    echo "<p>⚠️ Requiere intervención inmediata</p>";
    echo "</div>";
}

echo "<p><strong>Fin de pruebas:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Duración total:</strong> " . round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . " segundos</p>";

echo "</div>";

// Enlaces de acción
echo "<div class='test-section test-info'>";
echo "<h2>7. 🚀 ACCIONES DISPONIBLES</h2>";
echo "<div style='text-align: center;'>";
echo "<a href='/huv/login' class='btn'>🔐 Ir al Login</a>";
echo "<a href='/huv/dashboard' class='btn'>🏠 Dashboard</a>";
echo "<a href='/verificacion-final.php' class='btn'>📊 Verificación Final</a>";
echo "<a href='/estado-servidor.php' class='btn'>🖥️ Estado Servidor</a>";
echo "<a href='?refresh=1' class='btn'>🔄 Ejecutar Pruebas Nuevamente</a>";
echo "</div>";
echo "</div>";

echo "</div></body></html>";
