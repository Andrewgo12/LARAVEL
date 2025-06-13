<?php
/**
 * Sistema HUV - Hospital Universitario del Valle
 * Punto de entrada principal para XAMPP
 */

// Definir constantes de Laravel
define('LARAVEL_START', microtime(true));

// Verificar si tenemos los archivos de Laravel
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    // Cargar Laravel
    require_once __DIR__.'/vendor/autoload.php';

    $app = require_once __DIR__.'/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $request = Illuminate\Http\Request::capture();

    $response = $kernel->handle($request);

    $response->send();

    $kernel->terminate($request, $response);
} else {
    // Si no hay Laravel, mostrar página de error
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema HUV - Error de Configuración</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                color: white;
            }
            .container {
                text-align: center;
                background: rgba(255,255,255,0.1);
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                backdrop-filter: blur(10px);
                max-width: 600px;
            }
            .logo {
                font-size: 3em;
                font-weight: bold;
                margin-bottom: 20px;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            }
            .error {
                background: rgba(220, 53, 69, 0.2);
                border: 1px solid rgba(220, 53, 69, 0.5);
                padding: 20px;
                border-radius: 10px;
                margin: 20px 0;
            }
            .solution {
                background: rgba(40, 167, 69, 0.2);
                border: 1px solid rgba(40, 167, 69, 0.5);
                padding: 20px;
                border-radius: 10px;
                margin: 20px 0;
                text-align: left;
            }
            code {
                background: rgba(0,0,0,0.3);
                padding: 2px 6px;
                border-radius: 4px;
                font-family: 'Courier New', monospace;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">🏥 HUV</div>
            <h1>Sistema Hospital Universitario del Valle</h1>

            <div class="error">
                <h3>❌ Error de Configuración</h3>
                <p>No se encontraron los archivos de Laravel necesarios.</p>
                <p><strong>Archivo faltante:</strong> <code>vendor/autoload.php</code></p>
            </div>

            <div class="solution">
                <h3>🔧 Solución:</h3>
                <p><strong>1. Instalar dependencias:</strong></p>
                <p><code>composer install</code></p>

                <p><strong>2. Instalar dependencias de Node:</strong></p>
                <p><code>npm install</code></p>

                <p><strong>3. Compilar assets:</strong></p>
                <p><code>npm run build</code></p>

                <p><strong>4. Configurar permisos (si es necesario):</strong></p>
                <p><code>chmod -R 755 storage bootstrap/cache</code></p>
            </div>

            <div style="margin-top: 30px; font-size: 0.9em; opacity: 0.8;">
                <p><strong>Ruta del proyecto:</strong></p>
                <p><code><?= __DIR__ ?></code></p>

                <p><strong>Servidor web:</strong></p>
                <p><code><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido' ?></code></p>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}
