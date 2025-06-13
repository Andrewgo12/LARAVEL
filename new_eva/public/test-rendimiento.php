<?php
/**
 * PRUEBAS DE RENDIMIENTO Y CARGA - SISTEMA HUV
 * Pruebas de velocidad, memoria y capacidad de respuesta
 */

set_time_limit(300); // 5 minutos para las pruebas

echo "<!DOCTYPE html><html><head><title>Pruebas de Rendimiento - Sistema HUV</title>";
echo "<meta http-equiv='refresh' content='30'>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
.container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.test { padding: 15px; margin: 10px 0; border-radius: 5px; }
.excellent { background: #d4edda; border-left: 4px solid #28a745; color: #155724; }
.good { background: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460; }
.warning { background: #fff3cd; border-left: 4px solid #ffc107; color: #856404; }
.poor { background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; }
h1, h2 { color: #333; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
th { background-color: #f2f2f2; }
.metric { display: inline-block; background: #007bff; color: white; padding: 5px 10px; border-radius: 15px; margin: 2px; font-size: 0.9em; }
.progress { background: #e9ecef; border-radius: 10px; height: 20px; margin: 10px 0; }
.progress-bar { background: #28a745; height: 100%; border-radius: 10px; transition: width 0.3s ease; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>⚡ PRUEBAS DE RENDIMIENTO - SISTEMA HUV</h1>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . " | <strong>Actualización automática:</strong> 30s</p>";

$startTime = microtime(true);

// 1. Métricas del sistema
echo "<h2>1. 📊 Métricas del Sistema</h2>";

$memoryUsage = memory_get_usage(true);
$memoryPeak = memory_get_peak_usage(true);
$memoryLimit = ini_get('memory_limit');

echo "<div class='test good'>";
echo "<strong>💾 Uso de Memoria:</strong><br>";
echo "<span class='metric'>Actual: " . round($memoryUsage / 1024 / 1024, 2) . " MB</span>";
echo "<span class='metric'>Pico: " . round($memoryPeak / 1024 / 1024, 2) . " MB</span>";
echo "<span class='metric'>Límite: $memoryLimit</span>";
echo "</div>";

$loadAverage = sys_getloadavg();
if ($loadAverage !== false) {
    echo "<div class='test good'>";
    echo "<strong>⚙️ Carga del Sistema:</strong><br>";
    echo "<span class='metric'>1 min: " . round($loadAverage[0], 2) . "</span>";
    echo "<span class='metric'>5 min: " . round($loadAverage[1], 2) . "</span>";
    echo "<span class='metric'>15 min: " . round($loadAverage[2], 2) . "</span>";
    echo "</div>";
}

// 2. Pruebas de conexión a base de datos
echo "<h2>2. 🗄️ Rendimiento de Base de Datos</h2>";

try {
    $dbStartTime = microtime(true);
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=gestionthuv", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbConnectTime = round((microtime(true) - $dbStartTime) * 1000, 2);
    
    $class = $dbConnectTime < 100 ? 'excellent' : ($dbConnectTime < 500 ? 'good' : 'warning');
    echo "<div class='test $class'>";
    echo "<strong>🔌 Conexión a BD:</strong> {$dbConnectTime}ms";
    echo "</div>";
    
    // Prueba de consulta simple
    $queryStartTime = microtime(true);
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
    $userCount = $stmt->fetchColumn();
    $queryTime = round((microtime(true) - $queryStartTime) * 1000, 2);
    
    $class = $queryTime < 50 ? 'excellent' : ($queryTime < 200 ? 'good' : 'warning');
    echo "<div class='test $class'>";
    echo "<strong>📊 Consulta simple:</strong> {$queryTime}ms ($userCount usuarios)";
    echo "</div>";
    
    // Prueba de consulta compleja
    $complexStartTime = microtime(true);
    $stmt = $pdo->query("
        SELECT e.id, e.name, s.nombre as servicio, a.nombre as area 
        FROM equipos e 
        LEFT JOIN servicios s ON e.servicio_id = s.id 
        LEFT JOIN areas a ON e.area_id = a.id 
        LIMIT 100
    ");
    $results = $stmt->fetchAll();
    $complexTime = round((microtime(true) - $complexStartTime) * 1000, 2);
    
    $class = $complexTime < 200 ? 'excellent' : ($complexTime < 1000 ? 'good' : 'warning');
    echo "<div class='test $class'>";
    echo "<strong>🔍 Consulta compleja:</strong> {$complexTime}ms (" . count($results) . " registros)";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div class='test poor'>❌ <strong>Error de BD:</strong> " . $e->getMessage() . "</div>";
}

// 3. Pruebas de carga de rutas
echo "<h2>3. 🛣️ Rendimiento de Rutas</h2>";

$routes = [
    '/huv/login' => 'Login',
    '/huv/dashboard' => 'Dashboard',
    '/huv/equipos' => 'Equipos',
    '/huv/usuarios' => 'Usuarios'
];

echo "<table>";
echo "<tr><th>Ruta</th><th>Tiempo (ms)</th><th>Estado</th><th>Evaluación</th></tr>";

foreach ($routes as $route => $name) {
    $routeStartTime = microtime(true);
    
    $url = "http://" . $_SERVER['HTTP_HOST'] . $route;
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 10,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    $routeTime = round((microtime(true) - $routeStartTime) * 1000, 2);
    
    $status = $response !== false ? "✅ OK" : "❌ ERROR";
    
    if ($routeTime < 500) {
        $evaluation = "🟢 Excelente";
        $class = "excellent";
    } elseif ($routeTime < 1500) {
        $evaluation = "🟡 Bueno";
        $class = "good";
    } elseif ($routeTime < 3000) {
        $evaluation = "🟠 Lento";
        $class = "warning";
    } else {
        $evaluation = "🔴 Muy lento";
        $class = "poor";
    }
    
    echo "<tr class='$class'>";
    echo "<td>$name</td>";
    echo "<td>{$routeTime}ms</td>";
    echo "<td>$status</td>";
    echo "<td>$evaluation</td>";
    echo "</tr>";
}
echo "</table>";

// 4. Prueba de carga múltiple
echo "<h2>4. 🔄 Prueba de Carga Múltiple</h2>";

$iterations = 10;
$totalTime = 0;
$successCount = 0;

echo "<div class='test good'>";
echo "<strong>Ejecutando $iterations peticiones al login...</strong><br>";

for ($i = 1; $i <= $iterations; $i++) {
    $iterStartTime = microtime(true);
    
    $url = "http://" . $_SERVER['HTTP_HOST'] . "/huv/login";
    $response = @file_get_contents($url, false, stream_context_create([
        'http' => ['timeout' => 5, 'ignore_errors' => true]
    ]));
    
    $iterTime = microtime(true) - $iterStartTime;
    $totalTime += $iterTime;
    
    if ($response !== false) {
        $successCount++;
    }
    
    echo "Petición $i: " . round($iterTime * 1000, 2) . "ms ";
    if ($i % 5 == 0) echo "<br>";
}

$avgTime = round(($totalTime / $iterations) * 1000, 2);
$successRate = round(($successCount / $iterations) * 100, 1);

echo "<br><br>";
echo "<span class='metric'>Tiempo promedio: {$avgTime}ms</span>";
echo "<span class='metric'>Tasa de éxito: {$successRate}%</span>";
echo "<span class='metric'>Peticiones exitosas: $successCount/$iterations</span>";
echo "</div>";

// 5. Análisis de archivos
echo "<h2>5. 📁 Análisis de Archivos</h2>";

$criticalFiles = [
    '../resources/views/laravel' => 'Vistas Laravel',
    '../app/Http/Controllers' => 'Controladores',
    '../public/assets' => 'Assets públicos',
    '../storage' => 'Almacenamiento'
];

echo "<table>";
echo "<tr><th>Directorio</th><th>Archivos</th><th>Tamaño</th><th>Estado</th></tr>";

foreach ($criticalFiles as $path => $name) {
    if (is_dir($path)) {
        $fileCount = 0;
        $totalSize = 0;
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $fileCount++;
                $totalSize += $file->getSize();
            }
        }
        
        $sizeFormatted = $totalSize > 1024*1024 ? 
            round($totalSize / 1024 / 1024, 2) . " MB" : 
            round($totalSize / 1024, 2) . " KB";
        
        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td>$fileCount</td>";
        echo "<td>$sizeFormatted</td>";
        echo "<td>✅ OK</td>";
        echo "</tr>";
    } else {
        echo "<tr class='poor'>";
        echo "<td>$name</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>❌ No encontrado</td>";
        echo "</tr>";
    }
}
echo "</table>";

// 6. Resumen de rendimiento
echo "<h2>6. 📈 Resumen de Rendimiento</h2>";

$totalTestTime = round((microtime(true) - $startTime) * 1000, 2);

echo "<div class='test excellent'>";
echo "<h3>🎯 Métricas Finales</h3>";
echo "<span class='metric'>Tiempo total de pruebas: {$totalTestTime}ms</span>";
echo "<span class='metric'>Memoria pico: " . round($memoryPeak / 1024 / 1024, 2) . " MB</span>";
echo "<span class='metric'>Conexión BD: {$dbConnectTime}ms</span>";
echo "<span class='metric'>Tiempo promedio rutas: {$avgTime}ms</span>";
echo "<span class='metric'>Tasa de éxito: {$successRate}%</span>";
echo "</div>";

// Evaluación general
if ($avgTime < 1000 && $successRate > 95 && $dbConnectTime < 200) {
    echo "<div class='test excellent'>";
    echo "<h3>🎉 RENDIMIENTO EXCELENTE</h3>";
    echo "<p>✅ El sistema responde rápidamente</p>";
    echo "<p>✅ Base de datos optimizada</p>";
    echo "<p>✅ Alta disponibilidad</p>";
    echo "</div>";
} elseif ($avgTime < 2000 && $successRate > 90) {
    echo "<div class='test good'>";
    echo "<h3>👍 RENDIMIENTO BUENO</h3>";
    echo "<p>✅ Sistema funcional</p>";
    echo "<p>⚠️ Algunas optimizaciones posibles</p>";
    echo "</div>";
} else {
    echo "<div class='test warning'>";
    echo "<h3>⚠️ RENDIMIENTO MEJORABLE</h3>";
    echo "<p>⚠️ Sistema lento</p>";
    echo "<p>🔧 Requiere optimización</p>";
    echo "</div>";
}

echo "<p><strong>Próxima actualización:</strong> " . date('H:i:s', time() + 30) . "</p>";

echo "</div></body></html>";
?>
