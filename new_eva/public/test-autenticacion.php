<?php
/**
 * PRUEBAS ESPECÍFICAS DE AUTENTICACIÓN - SISTEMA HUV
 * Pruebas detalladas del sistema de login y autenticación
 */

session_start();

echo "<!DOCTYPE html><html><head><title>Pruebas de Autenticación - Sistema HUV</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
.container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
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
</style></head><body>";

echo "<div class='container'>";
echo "<h1>🔐 PRUEBAS DE AUTENTICACIÓN - SISTEMA HUV</h1>";
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
    // 1. Verificar estructura de tabla usuarios
    echo "<h2>1. 📋 Estructura de Tabla Usuarios</h2>";
    
    try {
        $stmt = $pdo->query("DESCRIBE usuarios");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<div class='test pass'>✅ <strong>Tabla usuarios encontrada</strong></div>";
        
        echo "<table>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Verificar campos críticos
        $requiredFields = ['id', 'email', 'password', 'nombre', 'estado', 'rol_id'];
        $missingFields = [];
        $existingFields = array_column($columns, 'Field');
        
        foreach ($requiredFields as $field) {
            if (!in_array($field, $existingFields)) {
                $missingFields[] = $field;
            }
        }
        
        if (empty($missingFields)) {
            echo "<div class='test pass'>✅ <strong>Todos los campos requeridos están presentes</strong></div>";
        } else {
            echo "<div class='test fail'>❌ <strong>Campos faltantes:</strong> " . implode(', ', $missingFields) . "</div>";
        }
        
    } catch (PDOException $e) {
        echo "<div class='test fail'>❌ <strong>Error al verificar estructura:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 2. Verificar usuarios existentes
    echo "<h2>2. 👥 Usuarios Existentes</h2>";
    
    try {
        $stmt = $pdo->query("SELECT id, nombre, email, estado, rol_id FROM usuarios LIMIT 10");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            echo "<div class='test pass'>✅ <strong>Usuarios encontrados:</strong> " . count($users) . "</div>";
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Estado</th><th>Rol ID</th></tr>";
            foreach ($users as $user) {
                $statusClass = $user['estado'] == 1 ? 'pass' : 'warning';
                echo "<tr class='$statusClass'>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['nombre'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . ($user['estado'] == 1 ? 'Activo' : 'Inactivo') . "</td>";
                echo "<td>" . $user['rol_id'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='test warning'>⚠️ <strong>No se encontraron usuarios en la base de datos</strong></div>";
        }
        
    } catch (PDOException $e) {
        echo "<div class='test fail'>❌ <strong>Error al consultar usuarios:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 3. Verificar usuario de prueba
    echo "<h2>3. 🧪 Usuario de Prueba</h2>";
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute(['admin@huv.com']);
        $testUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($testUser) {
            echo "<div class='test pass'>✅ <strong>Usuario de prueba encontrado:</strong> admin@huv.com</div>";
            echo "<div class='test info'>";
            echo "<strong>Detalles del usuario:</strong><br>";
            echo "ID: " . $testUser['id'] . "<br>";
            echo "Nombre: " . $testUser['nombre'] . "<br>";
            echo "Email: " . $testUser['email'] . "<br>";
            echo "Estado: " . ($testUser['estado'] == 1 ? 'Activo' : 'Inactivo') . "<br>";
            echo "Rol ID: " . $testUser['rol_id'] . "<br>";
            echo "</div>";
        } else {
            echo "<div class='test warning'>⚠️ <strong>Usuario de prueba no encontrado</strong></div>";
            echo "<div class='test info'>Creando usuario de prueba...</div>";
            
            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, estado, rol_id, sede_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute(['Usuario Prueba', 'admin@huv.com', 'password', 1, 1, 1]);
                echo "<div class='test pass'>✅ <strong>Usuario de prueba creado exitosamente</strong></div>";
            } catch (PDOException $e) {
                echo "<div class='test fail'>❌ <strong>Error al crear usuario de prueba:</strong> " . $e->getMessage() . "</div>";
            }
        }
        
    } catch (PDOException $e) {
        echo "<div class='test fail'>❌ <strong>Error al verificar usuario de prueba:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 4. Probar autenticación
    echo "<h2>4. 🔑 Pruebas de Autenticación</h2>";
    
    // Simular proceso de autenticación
    $testCredentials = [
        ['admin@huv.com', 'password', 'Usuario válido'],
        ['admin@huv.com', 'wrongpassword', 'Contraseña incorrecta'],
        ['noexiste@huv.com', 'password', 'Usuario inexistente']
    ];
    
    foreach ($testCredentials as $cred) {
        $email = $cred[0];
        $password = $cred[1];
        $description = $cred[2];
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                $result = "Usuario no encontrado";
                $class = "fail";
            } elseif ($user['estado'] != 1) {
                $result = "Usuario inactivo";
                $class = "warning";
            } elseif (sha1($password) === $user['password'] || $password === $user['password']) {
                $result = "Autenticación exitosa";
                $class = "pass";
            } else {
                $result = "Contraseña incorrecta";
                $class = "fail";
            }
            
            echo "<div class='test $class'>";
            echo "<strong>$description:</strong> $result<br>";
            echo "Email: $email | Password: $password";
            echo "</div>";
            
        } catch (PDOException $e) {
            echo "<div class='test fail'>❌ <strong>Error en autenticación:</strong> " . $e->getMessage() . "</div>";
        }
    }
    
    // 5. Verificar roles y permisos
    echo "<h2>5. 🛡️ Roles y Permisos</h2>";
    
    try {
        $stmt = $pdo->query("SELECT * FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($roles) > 0) {
            echo "<div class='test pass'>✅ <strong>Roles encontrados:</strong> " . count($roles) . "</div>";
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th></tr>";
            foreach ($roles as $role) {
                echo "<tr>";
                echo "<td>" . $role['id'] . "</td>";
                echo "<td>" . $role['nombre'] . "</td>";
                echo "<td>" . ($role['descripcion'] ?? 'N/A') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='test warning'>⚠️ <strong>No se encontraron roles en la base de datos</strong></div>";
        }
        
    } catch (PDOException $e) {
        echo "<div class='test fail'>❌ <strong>Error al consultar roles:</strong> " . $e->getMessage() . "</div>";
    }
    
    // 6. Prueba de sesión
    echo "<h2>6. 🔄 Pruebas de Sesión</h2>";
    
    // Verificar que las sesiones funcionan
    if (session_status() === PHP_SESSION_ACTIVE) {
        echo "<div class='test pass'>✅ <strong>Sesiones PHP activas</strong></div>";
        
        // Simular datos de sesión
        $_SESSION['test_login'] = true;
        $_SESSION['test_user_id'] = 1;
        $_SESSION['test_timestamp'] = time();
        
        if (isset($_SESSION['test_login'])) {
            echo "<div class='test pass'>✅ <strong>Escritura de sesión exitosa</strong></div>";
        } else {
            echo "<div class='test fail'>❌ <strong>Error en escritura de sesión</strong></div>";
        }
        
        // Limpiar sesión de prueba
        unset($_SESSION['test_login'], $_SESSION['test_user_id'], $_SESSION['test_timestamp']);
        
    } else {
        echo "<div class='test fail'>❌ <strong>Sesiones PHP no están activas</strong></div>";
    }
}

// 7. Enlaces de prueba
echo "<h2>7. 🚀 Pruebas en Vivo</h2>";
echo "<div class='test info'>";
echo "<strong>Probar autenticación en el sistema:</strong><br><br>";
echo "<a href='/huv/login' class='btn'>🔐 Ir al Login</a>";
echo "<a href='/huv/dashboard' class='btn'>🏠 Dashboard (requiere login)</a>";
echo "<br><br>";
echo "<strong>Credenciales de prueba:</strong><br>";
echo "Email: admin@huv.com<br>";
echo "Contraseña: password";
echo "</div>";

echo "</div></body></html>";
?>
