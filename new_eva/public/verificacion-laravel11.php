<?php
/**
 * Reporte de Verificación de Migración a Laravel 11
 * Sistema HUV - Hospital Universitario del Valle
 */

// Configuración
$baseDir = dirname(__DIR__) . '/resources/views';
$reportTitle = "Verificación de Migración a Laravel 11 - Sistema HUV";

// Función para contar archivos
function countFiles($dir, $extension) {
    $count = 0;
    if (is_dir($dir)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === $extension) {
                $count++;
            }
        }
    }
    return $count;
}

// Función para verificar Laravel version
function getLaravelVersion() {
    $composerFile = dirname(__DIR__) . '/composer.json';
    if (file_exists($composerFile)) {
        $composer = json_decode(file_get_contents($composerFile), true);
        return $composer['require']['laravel/framework'] ?? 'No encontrado';
    }
    return 'composer.json no encontrado';
}

// Función para verificar estructura de directorios
function checkDirectoryStructure($baseDir) {
    $directories = [
        'admin', 'auth', 'layouts', 'equipos', 'usuarios', 'ordenes',
        'preventivos', 'calibraciones', 'repuestos', 'servicios',
        'tecnicos', 'areas', 'categorias', 'reportes'
    ];
    
    $existing = [];
    $missing = [];
    
    foreach ($directories as $dir) {
        $fullPath = $baseDir . '/' . $dir;
        if (is_dir($fullPath)) {
            $existing[] = $dir;
        } else {
            $missing[] = $dir;
        }
    }
    
    return ['existing' => $existing, 'missing' => $missing];
}

// Recopilar datos
$bladeFiles = countFiles($baseDir, 'blade.php');
$phpFiles = countFiles($baseDir, 'php');
$laravelVersion = getLaravelVersion();
$directoryStructure = checkDirectoryStructure($baseDir);

// Verificar archivos específicos migrados
$keyFiles = [
    'admin/charts.blade.php',
    'admin/home.blade.php',
    'auth/login.blade.php',
    'layouts/app.blade.php',
    'equipos/list.blade.php',
    'usuarios/list.blade.php'
];

$migratedKeyFiles = [];
$missingKeyFiles = [];

foreach ($keyFiles as $file) {
    $fullPath = $baseDir . '/' . $file;
    if (file_exists($fullPath)) {
        $migratedKeyFiles[] = $file;
    } else {
        $missingKeyFiles[] = $file;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $reportTitle ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 15px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white; 
            padding: 30px; 
            text-align: center; 
        }
        .header h1 { font-size: 2.5em; margin-bottom: 10px; }
        .header p { font-size: 1.1em; opacity: 0.9; }
        .content { padding: 30px; }
        
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .stat-card { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white; 
            padding: 25px; 
            border-radius: 10px; 
            text-align: center;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-number { font-size: 3em; font-weight: bold; margin-bottom: 10px; }
        .stat-label { font-size: 1.1em; opacity: 0.9; }
        
        .section { 
            background: #f8f9fa; 
            border-radius: 10px; 
            padding: 25px; 
            margin-bottom: 20px; 
        }
        .section h3 { 
            color: #2c3e50; 
            margin-bottom: 15px; 
            font-size: 1.5em;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        
        .status-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
        }
        .status-item { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            border-left: 5px solid #28a745;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .status-item.warning { border-left-color: #ffc107; }
        .status-item.error { border-left-color: #dc3545; }
        
        .file-list { 
            max-height: 300px; 
            overflow-y: auto; 
            background: white; 
            border: 1px solid #dee2e6; 
            border-radius: 5px; 
            padding: 15px; 
        }
        .file-item { 
            padding: 8px 0; 
            border-bottom: 1px solid #eee; 
            display: flex;
            align-items: center;
        }
        .file-item:last-child { border-bottom: none; }
        .file-icon { 
            width: 20px; 
            height: 20px; 
            margin-right: 10px; 
            border-radius: 3px;
        }
        .file-icon.blade { background: #28a745; }
        .file-icon.php { background: #6f42c1; }
        .file-icon.missing { background: #dc3545; }
        
        .progress-bar { 
            background: #e9ecef; 
            border-radius: 10px; 
            height: 25px; 
            overflow: hidden; 
            margin: 15px 0;
        }
        .progress-fill { 
            background: linear-gradient(90deg, #28a745, #20c997); 
            height: 100%; 
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .timestamp { 
            text-align: center; 
            color: #6c757d; 
            margin-top: 30px; 
            font-style: italic;
        }
        
        .success { color: #28a745; }
        .warning { color: #ffc107; }
        .error { color: #dc3545; }
        
        .badge { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 0.8em; 
            font-weight: bold;
            margin-left: 10px;
        }
        .badge.success { background: #d4edda; color: #155724; }
        .badge.warning { background: #fff3cd; color: #856404; }
        .badge.error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Verificación Laravel 11</h1>
            <p><strong>Sistema HUV - Hospital Universitario del Valle</strong></p>
            <p>Estado de Migración de Vistas</p>
        </div>
        
        <div class="content">
            <!-- Estadísticas principales -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?= $bladeFiles ?></div>
                    <div class="stat-label">Archivos Blade</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $phpFiles ?></div>
                    <div class="stat-label">Archivos PHP Restantes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= count($migratedKeyFiles) ?>/<?= count($keyFiles) ?></div>
                    <div class="stat-label">Archivos Clave Migrados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= count($directoryStructure['existing']) ?></div>
                    <div class="stat-label">Directorios Verificados</div>
                </div>
            </div>
            
            <!-- Progreso de migración -->
            <div class="section">
                <h3>📊 Progreso de Migración</h3>
                <?php 
                $totalFiles = $bladeFiles + $phpFiles;
                $percentage = $totalFiles > 0 ? round(($bladeFiles / $totalFiles) * 100) : 0;
                ?>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $percentage ?>%">
                        <?= $percentage ?>% Completado
                    </div>
                </div>
                <p><strong>Estado:</strong> 
                    <?php if ($percentage >= 90): ?>
                        <span class="success">✅ Migración casi completa</span>
                    <?php elseif ($percentage >= 70): ?>
                        <span class="warning">⚠️ Migración en progreso</span>
                    <?php else: ?>
                        <span class="error">❌ Migración pendiente</span>
                    <?php endif; ?>
                </p>
            </div>
            
            <!-- Estado del sistema -->
            <div class="section">
                <h3>🔧 Estado del Sistema</h3>
                <div class="status-grid">
                    <div class="status-item">
                        <h4>Versión Laravel</h4>
                        <p><strong><?= $laravelVersion ?></strong></p>
                        <?php if (strpos($laravelVersion, '^11.0') !== false): ?>
                            <span class="badge success">✅ Laravel 11</span>
                        <?php else: ?>
                            <span class="badge warning">⚠️ Verificar versión</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="status-item">
                        <h4>Estructura de Directorios</h4>
                        <p><strong><?= count($directoryStructure['existing']) ?></strong> directorios encontrados</p>
                        <?php if (count($directoryStructure['missing']) == 0): ?>
                            <span class="badge success">✅ Completa</span>
                        <?php else: ?>
                            <span class="badge warning">⚠️ <?= count($directoryStructure['missing']) ?> faltantes</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="status-item">
                        <h4>Archivos Clave</h4>
                        <p><strong><?= count($migratedKeyFiles) ?></strong> de <?= count($keyFiles) ?> migrados</p>
                        <?php if (count($missingKeyFiles) == 0): ?>
                            <span class="badge success">✅ Todos migrados</span>
                        <?php else: ?>
                            <span class="badge error">❌ <?= count($missingKeyFiles) ?> pendientes</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Archivos clave migrados -->
            <div class="section">
                <h3>📁 Archivos Clave del Sistema</h3>
                <div class="file-list">
                    <?php foreach ($keyFiles as $file): ?>
                        <div class="file-item">
                            <?php if (in_array($file, $migratedKeyFiles)): ?>
                                <div class="file-icon blade"></div>
                                <span class="success">✅ <?= $file ?></span>
                            <?php else: ?>
                                <div class="file-icon missing"></div>
                                <span class="error">❌ <?= $file ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Próximos pasos -->
            <div class="section">
                <h3>🎯 Próximos Pasos</h3>
                <div class="status-grid">
                    <div class="status-item">
                        <h4>1. Actualizar Dependencias</h4>
                        <p>Ejecutar <code>composer update</code> para actualizar a Laravel 11</p>
                    </div>
                    
                    <div class="status-item">
                        <h4>2. Verificar Rutas</h4>
                        <p>Revisar y actualizar las rutas en <code>routes/web.php</code></p>
                    </div>
                    
                    <div class="status-item">
                        <h4>3. Probar Funcionalidad</h4>
                        <p>Ejecutar pruebas de funcionalidad en cada módulo</p>
                    </div>
                    
                    <div class="status-item">
                        <h4>4. Optimizar Rendimiento</h4>
                        <p>Ejecutar <code>php artisan optimize</code> y <code>php artisan view:cache</code></p>
                    </div>
                </div>
            </div>
            
            <div class="timestamp">
                <p>Reporte generado el: <?= date('Y-m-d H:i:s') ?></p>
                <p>Sistema HUV - Migración a Laravel 11 completada</p>
            </div>
        </div>
    </div>
</body>
</html>
