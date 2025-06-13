@echo off
echo ========================================
echo 🚀 SISTEMA HUV v4.0 - INICIO AUTOMÁTICO
echo ========================================
echo.
echo 🏥 Hospital Universitario del Valle
echo 📋 Sistema de Gestión de Tecnología Biomédica
echo 🔄 Migración completa CodeIgniter → Laravel
echo ✅ Sin errores "No direct script access allowed"
echo.

REM Cambiar al directorio del proyecto
cd /d "C:\xampp1\htdocs\Proyecto\LARAVEL\new_eva"

REM Verificar que estamos en el directorio correcto
if not exist "artisan" (
    echo ❌ Error: No se encontró el archivo artisan
    echo    Verifica que estés en el directorio correcto del proyecto Laravel
    pause
    exit /b 1
)

echo ✅ Proyecto Laravel detectado correctamente
echo.

echo [1/4] 🔍 Verificando servicios...

REM Verificar si MySQL está ejecutándose
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✅ MySQL está ejecutándose
) else (
    echo ⚠️  MySQL no detectado, intentando iniciar XAMPP...
    if exist "C:\xampp1\xampp_start.exe" (
        start "" "C:\xampp1\xampp_start.exe"
        timeout /t 3 /nobreak >nul
    )
)

echo.
echo [2/4] 🗄️  Verificando base de datos...

REM Verificar conexión a la base de datos
C:\xampp1\mysql\bin\mysql.exe -u root -e "USE gestionthuv; SELECT 'Conexión exitosa' as status;" 2>nul
if %errorlevel% equ 0 (
    echo ✅ Base de datos 'gestionthuv' conectada correctamente
) else (
    echo ❌ Error: No se puede conectar a la base de datos 'gestionthuv'
    echo    Verifica que MySQL esté ejecutándose y la base de datos exista
    pause
    exit /b 1
)

echo.
echo [3/4] 🚀 Iniciando servidor Laravel...

REM Matar procesos PHP existentes en el puerto 8000
for /f "tokens=5" %%a in ('netstat -aon ^| find ":8000" ^| find "LISTENING"') do (
    echo Deteniendo proceso existente en puerto 8000...
    taskkill /F /PID %%a >nul 2>&1
)

REM Iniciar servidor Laravel en segundo plano
echo Iniciando servidor en http://127.0.0.1:8000...
start /B php -S 127.0.0.1:8000 -t public

REM Esperar a que el servidor inicie
timeout /t 3 /nobreak >nul

REM Verificar que el servidor está ejecutándose
netstat -an | find ":8000" | find "LISTENING" >nul
if %errorlevel% equ 0 (
    echo ✅ Servidor Laravel iniciado correctamente
) else (
    echo ❌ Error: No se pudo iniciar el servidor Laravel
    pause
    exit /b 1
)

echo.
echo [4/4] 🌐 Abriendo sistema en navegador...

echo.
echo ========================================
echo 🎉 SISTEMA HUV INICIADO CORRECTAMENTE
echo ========================================
echo.
echo 🔗 URLS DISPONIBLES:
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
echo    Verificación: http://127.0.0.1:8000/verificacion-final.php
echo    Diagnóstico:  http://127.0.0.1:8000/diagnostico.php
echo.
echo 👤 CREDENCIALES DE ACCESO:
echo    Email: admin@huv.com
echo    Contraseña: password
echo.
echo ========================================

REM Abrir páginas principales
echo Abriendo verificación del sistema...
start http://127.0.0.1:8000/verificacion-final.php
timeout /t 2 /nobreak >nul

echo Abriendo login del sistema HUV...
start http://127.0.0.1:8000/huv/login

echo.
echo ✅ Sistema HUV v4.0 iniciado correctamente
echo 🔄 Migración CodeIgniter → Laravel completada
echo ❌ Sin errores "No direct script access allowed"
echo.
echo Presiona cualquier tecla para cerrar esta ventana...
echo (El servidor seguirá ejecutándose en segundo plano)
pause >nul
