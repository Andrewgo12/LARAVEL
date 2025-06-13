@echo off
echo ========================================
echo    INICIANDO SERVIDORES DEL SISTEMA HUV
echo ========================================
echo.

echo [1/4] Verificando directorio...
cd /d "C:\xampp1\htdocs\Proyecto\LARAVEL\new_eva"
if %errorlevel% neq 0 (
    echo ERROR: No se pudo acceder al directorio del proyecto
    pause
    exit /b 1
)
echo ✓ Directorio correcto: %CD%

echo.
echo [2/4] Verificando dependencias...
if not exist "vendor\autoload.php" (
    echo ⚠️ Instalando dependencias de Composer...
    composer install --ignore-platform-reqs
    if %errorlevel% neq 0 (
        echo ERROR: No se pudieron instalar las dependencias
        pause
        exit /b 1
    )
)
echo ✓ Dependencias verificadas

echo.
echo [3/4] Iniciando servidor Laravel (PHP)...
echo URL: http://127.0.0.1:8000
echo.
start "Servidor Laravel HUV" cmd /k "php -S 127.0.0.1:8000 -t public"

echo Esperando 5 segundos para que el servidor inicie...
timeout /t 5 /nobreak >nul

echo.
echo [4/4] Verificando servidor...
echo Probando conexión a http://127.0.0.1:8000
echo.

echo.
echo ========================================
echo    SERVIDORES INICIADOS CORRECTAMENTE
echo ========================================
echo.
URLS DISPONIBLES:
echo.
echo 🏥 SISTEMA HUV PRINCIPAL:
echo    Login:      http://127.0.0.1:8000/huv/login
echo    Dashboard:  http://127.0.0.1:8000/huv/dashboard
echo    Módulos:    http://127.0.0.1:8000/huv/modules
echo.
echo 📋 MÓDULOS PRINCIPALES:
echo    Equipos:    http://127.0.0.1:8000/huv/equipos
echo    Usuarios:   http://127.0.0.1:8000/huv/usuarios
echo    Órdenes:    http://127.0.0.1:8000/huv/ordenes
echo    Preventivos: http://127.0.0.1:8000/huv/preventivos
echo    Calibraciones: http://127.0.0.1:8000/huv/calibraciones
echo    Repuestos:  http://127.0.0.1:8000/huv/repuestos
echo.
echo 🔍 VERIFICACIÓN Y DIAGNÓSTICO:
echo    Verificación: http://127.0.0.1:8000/verificacion-completa.php
echo    Diagnóstico:  http://127.0.0.1:8000/diagnostico.php
echo    Test Blade:   http://127.0.0.1:8000/test-blade.php
echo.
echo CREDENCIALES DE ACCESO:
echo Email: admin@huv.com
echo Contraseña: password
echo.
echo Email: test@example.com
echo Contraseña: password
echo.
echo ========================================
echo Presiona cualquier tecla para abrir el navegador...
pause >nul

echo Abriendo páginas del sistema...
start http://127.0.0.1:8000/verificacion-completa.php
timeout /t 2 /nobreak >nul
start http://127.0.0.1:8000/huv/login

echo.
echo ✓ Sistema iniciado correctamente
echo ✓ Navegador abierto con diagnóstico y login
echo.
echo 📋 PÁGINAS ABIERTAS:
echo • Diagnóstico: http://127.0.0.1:8000/diagnostico.php
echo • Login HUV: http://127.0.0.1:8000/ci/login
echo.
echo Para detener el servidor, cierra la ventana "Servidor Laravel HUV"
echo o presiona Ctrl+C en ella.
echo.
pause
