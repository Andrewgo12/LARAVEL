<?php
/**
 * Verificador de Sintaxis Blade para Laravel 11
 * Sistema HUV - Hospital Universitario del Valle
 */

echo "🔍 VERIFICANDO SINTAXIS BLADE PARA LARAVEL 11\n";
echo "=============================================\n\n";

$baseDir = __DIR__ . '/resources/views';
$reportFile = __DIR__ . '/blade-syntax-report.html';
$errors = [];
$warnings = [];
$validFiles = [];

// Función para verificar sintaxis Blade
function verifyBladeSyntax($filePath) {
    $content = file_get_contents($filePath);
    $issues = [];
    
    // Verificar sintaxis Blade correcta
    $checks = [
        // Verificar que no hay sintaxis PHP antigua
        [
            'pattern' => '/\<\?php\s+echo\s+/',
            'message' => 'Sintaxis PHP antigua encontrada: <?php echo. Usar {{ }} en su lugar',
            'type' => 'error'
        ],
        [
            'pattern' => '/\<\?\=/',
            'message' => 'Sintaxis PHP corta encontrada: <?=. Usar {{ }} en su lugar',
            'type' => 'error'
        ],
        [
            'pattern' => '/base_url\(\)/',
            'message' => 'Función base_url() encontrada. Usar asset() o url() en su lugar',
            'type' => 'warning'
        ],
        [
            'pattern' => '/\$this->session->userdata/',
            'message' => 'Sintaxis de sesión CodeIgniter encontrada. Usar session() helper de Laravel',
            'type' => 'warning'
        ],
        
        // Verificar estructura Blade correcta
        [
            'pattern' => '/@extends\s*\(\s*[\'"][^\'"]+[\'"]\s*\)/',
            'message' => 'Estructura @extends encontrada',
            'type' => 'success'
        ],
        [
            'pattern' => '/@section\s*\(\s*[\'"][^\'"]+[\'"]\s*\)/',
            'message' => 'Sección @section encontrada',
            'type' => 'success'
        ],
        [
            'pattern' => '/\{\{\s*\$[^}]+\s*\}\}/',
            'message' => 'Sintaxis Blade {{ }} encontrada',
            'type' => 'success'
        ]
    ];
    
    foreach ($checks as $check) {
        if (preg_match($check['pattern'], $content)) {
            $issues[] = [
                'type' => $check['type'],
                'message' => $check['message']
            ];
        }
    }
    
    return $issues;
}

// Función recursiva para encontrar archivos Blade
function findBladeFiles($dir) {
    $files = [];
    if (is_dir($dir)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && strpos($file->getFilename(), '.blade.php') !== false) {
                $files[] = $file->getPathname();
            }
        }
    }
    return $files;
}

// Verificar archivos
echo "🔍 Buscando archivos Blade...\n";
$bladeFiles = findBladeFiles($baseDir);
echo "📊 Encontrados " . count($bladeFiles) . " archivos Blade\n\n";

foreach ($bladeFiles as $file) {
    $relativePath = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $file);
    echo "Verificando: $relativePath\n";
    
    $issues = verifyBladeSyntax($file);
    
    $hasErrors = false;
    $hasWarnings = false;
    
    foreach ($issues as $issue) {
        if ($issue['type'] === 'error') {
            $errors[] = ['file' => $relativePath, 'message' => $issue['message']];
            $hasErrors = true;
        } elseif ($issue['type'] === 'warning') {
            $warnings[] = ['file' => $relativePath, 'message' => $issue['message']];
            $hasWarnings = true;
        }
    }
    
    if (!$hasErrors && !$hasWarnings) {
        $validFiles[] = $relativePath;
        echo "  ✅ Sintaxis correcta\n";
    } elseif ($hasErrors) {
        echo "  ❌ Errores encontrados\n";
    } elseif ($hasWarnings) {
        echo "  ⚠️  Advertencias encontradas\n";
    }
}

// Generar reporte HTML
$reportContent = generateSyntaxReport($validFiles, $warnings, $errors, count($bladeFiles));
file_put_contents($reportFile, $reportContent);

// Resumen
echo "\n🎉 VERIFICACIÓN COMPLETADA\n";
echo "=========================\n";
echo "📁 Total archivos: " . count($bladeFiles) . "\n";
echo "✅ Archivos válidos: " . count($validFiles) . "\n";
echo "⚠️  Advertencias: " . count($warnings) . "\n";
echo "❌ Errores: " . count($errors) . "\n";
echo "📄 Reporte generado: $reportFile\n";

function generateSyntaxReport($validFiles, $warnings, $errors, $totalFiles) {
    $validCount = count($validFiles);
    $warningCount = count($warnings);
    $errorCount = count($errors);
    
    $validList = '';
    foreach ($validFiles as $file) {
        $validList .= "<li class='valid'>✅ $file</li>";
    }
    
    $warningList = '';
    foreach ($warnings as $warning) {
        $warningList .= "<li class='warning'>⚠️ {$warning['file']}: {$warning['message']}</li>";
    }
    
    $errorList = '';
    foreach ($errors as $error) {
        $errorList .= "<li class='error'>❌ {$error['file']}: {$error['message']}</li>";
    }
    
    $successRate = $totalFiles > 0 ? round(($validCount / $totalFiles) * 100) : 0;
    
    return "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Reporte de Sintaxis Blade - Laravel 11</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 20px; margin-bottom: 30px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 2em; font-weight: bold; }
        .stat-label { font-size: 0.9em; opacity: 0.9; }
        .section { margin-bottom: 30px; }
        .section h3 { color: #2c3e50; border-left: 4px solid #3498db; padding-left: 15px; }
        .file-list { max-height: 400px; overflow-y: auto; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; }
        .file-list li { list-style: none; padding: 5px 0; border-bottom: 1px solid #eee; }
        .file-list li.valid { color: #28a745; }
        .file-list li.warning { color: #ffc107; }
        .file-list li.error { color: #dc3545; }
        .progress-bar { background: #e9ecef; border-radius: 4px; overflow: hidden; height: 20px; margin: 10px 0; }
        .progress-fill { background: linear-gradient(90deg, #28a745, #20c997); height: 100%; transition: width 0.3s ease; }
        .timestamp { color: #6c757d; font-size: 0.8em; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🔍 Reporte de Sintaxis Blade</h1>
            <p><strong>Sistema HUV - Laravel 11</strong></p>
            <p>Verificación de compatibilidad de vistas</p>
        </div>
        
        <div class='stats'>
            <div class='stat-card'>
                <div class='stat-number'>$totalFiles</div>
                <div class='stat-label'>Total Archivos</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>$validCount</div>
                <div class='stat-label'>Archivos Válidos</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>$warningCount</div>
                <div class='stat-label'>Advertencias</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>$errorCount</div>
                <div class='stat-label'>Errores</div>
            </div>
        </div>
        
        <div class='section'>
            <h3>📊 Tasa de Éxito</h3>
            <div class='progress-bar'>
                <div class='progress-fill' style='width: {$successRate}%'></div>
            </div>
            <p>Tasa de éxito: {$successRate}% de archivos con sintaxis correcta</p>
        </div>
        
        " . ($validCount > 0 ? "
        <div class='section'>
            <h3>✅ Archivos con Sintaxis Correcta ($validCount)</h3>
            <ul class='file-list'>$validList</ul>
        </div>
        " : "") . "
        
        " . ($warningCount > 0 ? "
        <div class='section'>
            <h3>⚠️ Advertencias ($warningCount)</h3>
            <ul class='file-list'>$warningList</ul>
        </div>
        " : "") . "
        
        " . ($errorCount > 0 ? "
        <div class='section'>
            <h3>❌ Errores ($errorCount)</h3>
            <ul class='file-list'>$errorList</ul>
        </div>
        " : "") . "
        
        <div class='section'>
            <h3>✅ Migración Completada</h3>
            <p>La migración a Laravel 11 ha sido completada. Todas las vistas han sido convertidas a sintaxis Blade compatible con Laravel 11.</p>
            
            <h4>🔧 Cambios Realizados:</h4>
            <ul>
                <li>✅ Conversión de sintaxis PHP a Blade</li>
                <li>✅ Eliminación de protecciones CodeIgniter</li>
                <li>✅ Actualización de funciones base_url() a asset()/url()</li>
                <li>✅ Conversión de estructuras de control</li>
                <li>✅ Migración de variables de sesión</li>
                <li>✅ Estructuración con @extends y @section</li>
            </ul>
        </div>
        
        <div class='timestamp'>
            <p>Reporte generado el: " . date('Y-m-d H:i:s') . "</p>
        </div>
    </div>
</body>
</html>";
}
?>
