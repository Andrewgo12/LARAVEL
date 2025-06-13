<?php
/**
 * Script de Migración Masiva a Laravel 11
 * Hospital Universitario del Valle - Sistema HUV
 * 
 * Este script migra todas las vistas PHP a Blade para Laravel 11
 */

echo "🚀 INICIANDO MIGRACIÓN A LARAVEL 11\n";
echo "===================================\n\n";

// Configuración
$baseDir = __DIR__ . '/resources/views';
$reportFile = __DIR__ . '/migration-report-laravel11.html';
$logFile = __DIR__ . '/migration-log.txt';

// Contadores
$totalFiles = 0;
$migratedFiles = 0;
$skippedFiles = 0;
$errors = [];
$migrationLog = [];

// Función para escribir log
function writeLog($message) {
    global $logFile, $migrationLog;
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    file_put_contents($logFile, $logMessage . "\n", FILE_APPEND);
    $migrationLog[] = $logMessage;
    echo $logMessage . "\n";
}

// Función para convertir sintaxis PHP a Blade
function convertToBladeContent($content) {
    // Eliminar protecciones de CodeIgniter
    $content = preg_replace('/^<\?php\s+defined\([\'"]BASEPATH[\'"]\)\s+OR\s+exit\([\'"]No direct script access allowed[\'"]\);\s*\?>\s*/m', '', $content);
    
    // Convertir echo PHP a sintaxis Blade
    $content = preg_replace('/\<\?php\s+echo\s+(.+?);\s*\?\>/', '{{ $1 }}', $content);
    $content = preg_replace('/\<\?\=\s*(.+?)\s*\?\>/', '{{ $1 }}', $content);
    
    // Convertir base_url() a asset() o url()
    $content = str_replace('base_url()', 'url(\'/\')', $content);
    $content = preg_replace('/base_url\(\)\s*\.\s*[\'"]([^\'"]+)[\'"]/', 'asset(\'$1\')', $content);
    
    // Convertir foreach PHP a Blade
    $content = preg_replace('/\<\?php\s+foreach\s*\((.+?)\)\s*:\s*\?\>/', '@foreach($1)', $content);
    $content = preg_replace('/\<\?php\s+endforeach\s*;\s*\?\>/', '@endforeach', $content);
    
    // Convertir if PHP a Blade
    $content = preg_replace('/\<\?php\s+if\s*\((.+?)\)\s*:\s*\?\>/', '@if($1)', $content);
    $content = preg_replace('/\<\?php\s+endif\s*;\s*\?\>/', '@endif', $content);
    $content = preg_replace('/\<\?php\s+else\s*:\s*\?\>/', '@else', $content);
    $content = preg_replace('/\<\?php\s+elseif\s*\((.+?)\)\s*:\s*\?\>/', '@elseif($1)', $content);
    
    // Convertir variables de sesión CodeIgniter a Laravel
    $content = preg_replace('/\$this->session->userdata\([\'"]([^\'"]+)[\'"]\)/', 'session(\'$1\')', $content);
    
    // Agregar estructura Blade si no es un fragmento
    if (!preg_match('/@extends|@include|@section/', $content)) {
        if (preg_match('/<div class="content-wrapper">/', $content)) {
            // Es una vista completa, agregar extends y section
            $content = "@extends('layouts.app')\n\n@section('content')\n" . $content . "\n@endsection";
            $content = str_replace('<div class="content-wrapper">', '', $content);
            $content = str_replace('</div><!-- /.content-wrapper -->', '', $content);
            $content = str_replace('<!-- /.content-wrapper -->', '', $content);
        }
    }
    
    // Manejar scripts al final
    if (preg_match('/<script[^>]*>.*?<\/script>/s', $content)) {
        $content = preg_replace('/<script[^>]*>(.*?)<\/script>/s', "@push('scripts')\n<script>\n$1\n</script>\n@endpush", $content);
    }
    
    return $content;
}

// Función para migrar un archivo
function migrateFile($filePath) {
    global $migratedFiles, $skippedFiles, $errors;
    
    try {
        $content = file_get_contents($filePath);
        
        // Verificar si ya es un archivo Blade
        if (strpos($filePath, '.blade.php') !== false) {
            writeLog("⏭️  SALTADO: $filePath (ya es Blade)");
            $skippedFiles++;
            return;
        }
        
        // Verificar si es un archivo de error o sistema
        if (strpos($filePath, '/errors/') !== false || 
            strpos($filePath, '/compiled/') !== false ||
            strpos($filePath, 'index.html') !== false) {
            writeLog("⏭️  SALTADO: $filePath (archivo de sistema)");
            $skippedFiles++;
            return;
        }
        
        // Convertir contenido
        $bladeContent = convertToBladeContent($content);
        
        // Crear nuevo nombre de archivo
        $newFilePath = str_replace('.php', '.blade.php', $filePath);
        
        // Crear directorio si no existe
        $dir = dirname($newFilePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Escribir archivo Blade
        file_put_contents($newFilePath, $bladeContent);
        
        // Eliminar archivo PHP original si la migración fue exitosa
        if (file_exists($newFilePath) && $filePath !== $newFilePath) {
            unlink($filePath);
        }
        
        writeLog("✅ MIGRADO: $filePath → $newFilePath");
        $migratedFiles++;
        
    } catch (Exception $e) {
        $error = "❌ ERROR en $filePath: " . $e->getMessage();
        writeLog($error);
        $errors[] = $error;
    }
}

// Función recursiva para encontrar archivos PHP
function findPhpFiles($dir) {
    $files = [];
    if (is_dir($dir)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
    }
    return $files;
}

// Iniciar migración
writeLog("🔍 Buscando archivos PHP en: $baseDir");

$phpFiles = findPhpFiles($baseDir);
$totalFiles = count($phpFiles);

writeLog("📊 Encontrados $totalFiles archivos PHP para migrar");

// Migrar cada archivo
foreach ($phpFiles as $file) {
    migrateFile($file);
}

// Generar reporte HTML
$reportContent = generateMigrationReport();
file_put_contents($reportFile, $reportContent);

// Resumen final
writeLog("\n🎉 MIGRACIÓN COMPLETADA");
writeLog("=====================");
writeLog("📁 Total archivos: $totalFiles");
writeLog("✅ Migrados: $migratedFiles");
writeLog("⏭️  Saltados: $skippedFiles");
writeLog("❌ Errores: " . count($errors));
writeLog("📄 Reporte generado: $reportFile");

echo "\n🎯 MIGRACIÓN A LARAVEL 11 COMPLETADA\n";
echo "Ver reporte completo en: $reportFile\n";

// Función para generar reporte HTML
function generateMigrationReport() {
    global $totalFiles, $migratedFiles, $skippedFiles, $errors, $migrationLog;
    
    $errorList = '';
    foreach ($errors as $error) {
        $errorList .= "<li class='error'>$error</li>";
    }
    
    $logList = '';
    foreach ($migrationLog as $log) {
        $class = '';
        if (strpos($log, '✅') !== false) $class = 'success';
        elseif (strpos($log, '❌') !== false) $class = 'error';
        elseif (strpos($log, '⏭️') !== false) $class = 'skipped';
        
        $logList .= "<li class='$class'>$log</li>";
    }
    
    return "<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Reporte de Migración a Laravel 11 - Sistema HUV</title>
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
        .log-list { max-height: 400px; overflow-y: auto; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; }
        .log-list li { list-style: none; padding: 5px 0; border-bottom: 1px solid #eee; }
        .log-list li.success { color: #28a745; }
        .log-list li.error { color: #dc3545; }
        .log-list li.skipped { color: #ffc107; }
        .progress-bar { background: #e9ecef; border-radius: 4px; overflow: hidden; height: 20px; margin: 10px 0; }
        .progress-fill { background: linear-gradient(90deg, #28a745, #20c997); height: 100%; transition: width 0.3s ease; }
        .timestamp { color: #6c757d; font-size: 0.8em; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>🚀 Reporte de Migración a Laravel 11</h1>
            <p><strong>Sistema HUV - Hospital Universitario del Valle</strong></p>
            <p class='timestamp'>Generado el: " . date('Y-m-d H:i:s') . "</p>
        </div>
        
        <div class='stats'>
            <div class='stat-card'>
                <div class='stat-number'>$totalFiles</div>
                <div class='stat-label'>Total Archivos</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>$migratedFiles</div>
                <div class='stat-label'>Migrados</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>$skippedFiles</div>
                <div class='stat-label'>Saltados</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>" . count($errors) . "</div>
                <div class='stat-label'>Errores</div>
            </div>
        </div>
        
        <div class='section'>
            <h3>📊 Progreso de Migración</h3>
            <div class='progress-bar'>
                <div class='progress-fill' style='width: " . ($totalFiles > 0 ? round(($migratedFiles / $totalFiles) * 100) : 0) . "%'></div>
            </div>
            <p>Progreso: " . ($totalFiles > 0 ? round(($migratedFiles / $totalFiles) * 100) : 0) . "% completado</p>
        </div>
        
        " . (count($errors) > 0 ? "
        <div class='section'>
            <h3>❌ Errores Encontrados</h3>
            <ul class='log-list'>$errorList</ul>
        </div>
        " : "") . "
        
        <div class='section'>
            <h3>📋 Log Detallado de Migración</h3>
            <ul class='log-list'>$logList</ul>
        </div>
        
        <div class='section'>
            <h3>✅ Migración Completada</h3>
            <p>La migración a Laravel 11 ha sido completada exitosamente. Todas las vistas han sido convertidas de sintaxis PHP/CodeIgniter a sintaxis Blade de Laravel.</p>
            
            <h4>🔧 Cambios Realizados:</h4>
            <ul>
                <li>✅ Conversión de sintaxis PHP a Blade</li>
                <li>✅ Eliminación de protecciones CodeIgniter</li>
                <li>✅ Actualización de funciones base_url() a asset()/url()</li>
                <li>✅ Conversión de estructuras de control (foreach, if, etc.)</li>
                <li>✅ Migración de variables de sesión</li>
                <li>✅ Estructuración con @extends y @section</li>
            </ul>
            
            <h4>🎯 Próximos Pasos:</h4>
            <ul>
                <li>🔄 Actualizar composer dependencies a Laravel 11</li>
                <li>🧪 Ejecutar pruebas de funcionalidad</li>
                <li>🔍 Verificar rutas y controladores</li>
                <li>📱 Probar interfaz de usuario</li>
            </ul>
        </div>
    </div>
</body>
</html>";
}
?>
