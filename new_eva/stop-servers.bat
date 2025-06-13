@echo off
echo ========================================
echo    DETENIENDO SERVIDORES DEL SISTEMA HUV
echo ========================================
echo.

echo [1/2] Deteniendo servidor Laravel (PHP)...
taskkill /f /im php.exe 2>nul
if %errorlevel% equ 0 (
    echo ✓ Servidor Laravel detenido
) else (
    echo ℹ️ Servidor Laravel no estaba corriendo
)

echo.
echo [2/2] Deteniendo servidor Vite (Node.js)...
taskkill /f /im node.exe 2>nul
if %errorlevel% equ 0 (
    echo ✓ Servidor Vite detenido
) else (
    echo ℹ️ Servidor Vite no estaba corriendo
)

echo.
echo ========================================
echo    SERVIDORES DETENIDOS
echo ========================================
echo.
echo Para reiniciar los servidores, ejecuta:
echo start-servers.bat
echo.
pause
