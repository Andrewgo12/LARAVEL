@echo off
chcp 65001 >nul
echo ========================================
echo SISTEMA HUV v4.0 - INICIO AUTOMATICO
echo ========================================
echo.
echo Hospital Universitario del Valle
echo Sistema de Gestion de Tecnologia Biomedica
echo Migracion completa CodeIgniter - Laravel
echo Sin errores "No direct script access allowed"
echo.

cd /d "C:\xampp1\htdocs\Proyecto\LARAVEL\new_eva"

if not exist "artisan" (
    echo ERROR: No se encontro el archivo artisan
    pause
    exit /b 1
)

echo Proyecto Laravel detectado correctamente
echo.

echo [1/3] Verificando base de datos...
C:\xampp1\mysql\bin\mysql.exe -u root -e "USE gestionthuv; SELECT 'OK' as status;" 2>nul
if %errorlevel% equ 0 (
    echo Base de datos 'gestionthuv' conectada correctamente
) else (
    echo ERROR: No se puede conectar a la base de datos
    pause
    exit /b 1
)

echo.
echo [2/3] Iniciando servidor Laravel...

for /f "tokens=5" %%a in ('netstat -aon ^| find ":8000" ^| find "LISTENING"') do (
    taskkill /F /PID %%a >nul 2>&1
)

start /B php -S 127.0.0.1:8000 -t public
timeout /t 3 /nobreak >nul

echo Servidor iniciado en http://127.0.0.1:8000
echo.

echo [3/3] Abriendo sistema en navegador...
echo.

echo ========================================
echo SISTEMA HUV INICIADO CORRECTAMENTE
echo ========================================
echo.
echo URLS PRINCIPALES:
echo   Login:     http://127.0.0.1:8000/huv/login
echo   Dashboard: http://127.0.0.1:8000/huv/dashboard
echo   Equipos:   http://127.0.0.1:8000/huv/equipos
echo   Usuarios:  http://127.0.0.1:8000/huv/usuarios
echo.
echo VERIFICACION:
echo   http://127.0.0.1:8000/verificacion-final.php
echo.
echo CREDENCIALES:
echo   Email: admin@huv.com
echo   Password: password
echo.

start http://127.0.0.1:8000/verificacion-final.php
timeout /t 2 /nobreak >nul
start http://127.0.0.1:8000/huv/login

echo Sistema iniciado correctamente
echo Presiona cualquier tecla para cerrar...
pause >nul
