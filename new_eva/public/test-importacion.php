<?php
/**
 * PRUEBAS DE IMPORTACIÓN DE DATOS - SISTEMA HUV
 * Pruebas de carga de datos, CSV, Excel y migración
 */

echo "<!DOCTYPE html><html><head><title>Pruebas de Importación - Sistema HUV</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
.container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.test { padding: 15px; margin: 10px 0; border-radius: 5px; }
.pass { background: #d4edda; border-left: 4px solid #28a745; color: #155724; }
.fail { background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; }
.warning { background: #fff3cd; border-left: 4px solid #ffc107; color: #856404; }
.info { background: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460; }
h1, h2 { color: #333; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
th { background-color: #f2f2f2; }
.btn { background: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
.sample-data { background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 0.9em; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>📥 PRUEBAS DE IMPORTACIÓN - SISTEMA HUV</h1>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=gestionthuv", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbConnected = true;
} catch (PDOException $e) {
    $dbConnected = false;
    echo "<div class='test fail'>❌ <strong>Error de conexión a BD:</strong> " . $e->getMessage() . "</div>";
}

if ($dbConnected) {
    // 1. Verificar capacidad de inserción masiva
    echo "<h2>1. 📊 Capacidad de Inserción Masiva</h2>";
    
    try {
        // Crear tabla temporal para pruebas
        $pdo->exec("CREATE TEMPORARY TABLE test_import (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100),
            email VARCHAR(100),
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        echo "<div class='test pass'>✅ <strong>Tabla temporal creada</strong></div>";
        
        // Inserción masiva de datos de prueba
        $startTime = microtime(true);
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("INSERT INTO test_import (nombre, email) VALUES (?, ?)");
        
        for ($i = 1; $i <= 1000; $i++) {
            $stmt->execute([
                "Usuario Test $i",
                "test$i@huv.com"
            ]);
        }
        
        $pdo->commit();
        $insertTime = round((microtime(true) - $startTime) * 1000, 2);
        
        echo "<div class='test pass'>✅ <strong>Inserción masiva exitosa:</strong> 1000 registros en {$insertTime}ms</div>";
        
        // Verificar datos insertados
        $stmt = $pdo->query("SELECT COUNT(*) FROM test_import");
        $count = $stmt->fetchColumn();
        
        echo "<div class='test info'><strong>Registros insertados:</strong> $count</div>";
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<div class='test fail'>❌ <strong>Error en inserción masiva:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 2. Simulación de importación CSV
    echo "<h2>2. 📄 Simulación de Importación CSV</h2>";
    
    // Crear datos CSV de ejemplo
    $csvData = [
        ['nombre', 'email', 'telefono', 'servicio'],
        ['Juan Pérez', 'juan.perez@huv.com', '123456789', 'Cardiología'],
        ['María García', 'maria.garcia@huv.com', '987654321', 'Neurología'],
        ['Carlos López', 'carlos.lopez@huv.com', '456789123', 'Pediatría'],
        ['Ana Martínez', 'ana.martinez@huv.com', '789123456', 'Ginecología'],
        ['Luis Rodríguez', 'luis.rodriguez@huv.com', '321654987', 'Urgencias']
    ];
    
    echo "<div class='test info'>";
    echo "<strong>Datos CSV de ejemplo:</strong>";
    echo "<div class='sample-data'>";
    foreach ($csvData as $row) {
        echo implode(',', $row) . "<br>";
    }
    echo "</div>";
    echo "</div>";
    
    try {
        // Simular procesamiento de CSV
        $startTime = microtime(true);
        $processedRows = 0;
        $errors = [];
        
        // Crear tabla temporal para CSV
        $pdo->exec("CREATE TEMPORARY TABLE csv_import (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100),
            email VARCHAR(100),
            telefono VARCHAR(20),
            servicio VARCHAR(50)
        )");
        
        $stmt = $pdo->prepare("INSERT INTO csv_import (nombre, email, telefono, servicio) VALUES (?, ?, ?, ?)");
        
        // Procesar cada fila (saltando el header)
        for ($i = 1; $i < count($csvData); $i++) {
            $row = $csvData[$i];
            
            // Validaciones básicas
            if (empty($row[0]) || empty($row[1])) {
                $errors[] = "Fila $i: Nombre o email vacío";
                continue;
            }
            
            if (!filter_var($row[1], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Fila $i: Email inválido";
                continue;
            }
            
            try {
                $stmt->execute([$row[0], $row[1], $row[2], $row[3]]);
                $processedRows++;
            } catch (PDOException $e) {
                $errors[] = "Fila $i: Error de BD - " . $e->getMessage();
            }
        }
        
        $processTime = round((microtime(true) - $startTime) * 1000, 2);
        
        echo "<div class='test pass'>";
        echo "✅ <strong>Procesamiento CSV completado:</strong><br>";
        echo "• Filas procesadas: $processedRows<br>";
        echo "• Errores: " . count($errors) . "<br>";
        echo "• Tiempo: {$processTime}ms";
        echo "</div>";
        
        if (!empty($errors)) {
            echo "<div class='test warning'>";
            echo "<strong>⚠️ Errores encontrados:</strong><br>";
            foreach ($errors as $error) {
                echo "• $error<br>";
            }
            echo "</div>";
        }
        
    } catch (PDOException $e) {
        echo "<div class='test fail'>❌ <strong>Error en procesamiento CSV:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 3. Prueba de validación de datos
    echo "<h2>3. ✅ Pruebas de Validación</h2>";
    
    $validationTests = [
        ['test@huv.com', 'Email válido', true],
        ['invalid-email', 'Email inválido', false],
        ['123456789', 'Teléfono válido', true],
        ['abc', 'Teléfono inválido', false],
        ['Juan Pérez', 'Nombre válido', true],
        ['', 'Nombre vacío', false]
    ];
    
    echo "<table>";
    echo "<tr><th>Valor</th><th>Tipo</th><th>Resultado</th><th>Estado</th></tr>";
    
    foreach ($validationTests as $test) {
        $value = $test[0];
        $type = $test[1];
        $expected = $test[2];
        
        // Aplicar validaciones
        if (strpos($type, 'Email') !== false) {
            $isValid = filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
        } elseif (strpos($type, 'Teléfono') !== false) {
            $isValid = preg_match('/^\d{9,15}$/', $value);
        } elseif (strpos($type, 'Nombre') !== false) {
            $isValid = !empty(trim($value)) && strlen($value) >= 2;
        } else {
            $isValid = !empty($value);
        }
        
        $result = $isValid ? 'Válido' : 'Inválido';
        $status = ($isValid === $expected) ? '✅ OK' : '❌ ERROR';
        $class = ($isValid === $expected) ? 'pass' : 'fail';
        
        echo "<tr class='$class'>";
        echo "<td>$value</td>";
        echo "<td>$type</td>";
        echo "<td>$result</td>";
        echo "<td>$status</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 4. Prueba de integridad referencial
    echo "<h2>4. 🔗 Integridad Referencial</h2>";
    
    try {
        // Verificar relaciones entre tablas
        $queries = [
            "SELECT COUNT(*) as count FROM usuarios u LEFT JOIN roles r ON u.rol_id = r.id WHERE r.id IS NULL AND u.rol_id IS NOT NULL" => "Usuarios sin rol válido",
            "SELECT COUNT(*) as count FROM equipos e LEFT JOIN servicios s ON e.servicio_id = s.id WHERE s.id IS NULL AND e.servicio_id IS NOT NULL" => "Equipos sin servicio válido",
            "SELECT COUNT(*) as count FROM equipos e LEFT JOIN areas a ON e.area_id = a.id WHERE a.id IS NULL AND e.area_id IS NOT NULL" => "Equipos sin área válida"
        ];
        
        foreach ($queries as $query => $description) {
            try {
                $stmt = $pdo->query($query);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $result['count'];
                
                if ($count == 0) {
                    echo "<div class='test pass'>✅ <strong>$description:</strong> Sin problemas</div>";
                } else {
                    echo "<div class='test warning'>⚠️ <strong>$description:</strong> $count registros problemáticos</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='test fail'>❌ <strong>Error en $description:</strong> " . $e->getMessage() . "</div>";
            }
        }
        
    } catch (Exception $e) {
        echo "<div class='test fail'>❌ <strong>Error en verificación de integridad:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 5. Prueba de backup y restauración
    echo "<h2>5. 💾 Simulación de Backup</h2>";
    
    try {
        // Simular creación de backup
        $backupStartTime = microtime(true);
        
        $tables = ['usuarios', 'equipos', 'servicios', 'areas'];
        $backupData = [];
        
        foreach ($tables as $table) {
            try {
                $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
                $count = $stmt->fetchColumn();
                $backupData[$table] = $count;
            } catch (PDOException $e) {
                $backupData[$table] = "Error: " . $e->getMessage();
            }
        }
        
        $backupTime = round((microtime(true) - $backupStartTime) * 1000, 2);
        
        echo "<div class='test pass'>";
        echo "✅ <strong>Simulación de backup completada:</strong> {$backupTime}ms<br>";
        echo "<strong>Registros por tabla:</strong><br>";
        foreach ($backupData as $table => $count) {
            echo "• $table: $count registros<br>";
        }
        echo "</div>";
        
    } catch (Exception $e) {
        echo "<div class='test fail'>❌ <strong>Error en backup:</strong> " . $e->getMessage() . "</div>";
    }
}

// 6. Recomendaciones de importación
echo "<h2>6. 💡 Recomendaciones de Importación</h2>";

echo "<div class='test info'>";
echo "<h3>📋 Mejores Prácticas:</h3>";
echo "<ul>";
echo "<li>✅ Usar transacciones para importaciones grandes</li>";
echo "<li>✅ Validar datos antes de insertar</li>";
echo "<li>✅ Procesar en lotes de 1000-5000 registros</li>";
echo "<li>✅ Mantener logs de errores detallados</li>";
echo "<li>✅ Hacer backup antes de importaciones masivas</li>";
echo "<li>✅ Verificar integridad referencial</li>";
echo "<li>✅ Usar prepared statements para seguridad</li>";
echo "</ul>";
echo "</div>";

echo "<div class='test warning'>";
echo "<h3>⚠️ Consideraciones:</h3>";
echo "<ul>";
echo "<li>⚠️ Archivos CSV grandes pueden consumir mucha memoria</li>";
echo "<li>⚠️ Validar formato de fechas y números</li>";
echo "<li>⚠️ Manejar caracteres especiales y encoding</li>";
echo "<li>⚠️ Considerar timeout para importaciones largas</li>";
echo "</ul>";
echo "</div>";

// 7. Enlaces útiles
echo "<h2>7. 🔗 Enlaces Útiles</h2>";
echo "<div class='test info'>";
echo "<strong>Herramientas del sistema:</strong><br>";
echo "<a href='/huv/login' class='btn'>🔐 Login</a>";
echo "<a href='/test-suite-completo.php' class='btn'>🧪 Suite Completa</a>";
echo "<a href='/test-rendimiento.php' class='btn'>⚡ Rendimiento</a>";
echo "<a href='/verificacion-final.php' class='btn'>📊 Verificación</a>";
echo "</div>";

echo "</div></body></html>";
?>
