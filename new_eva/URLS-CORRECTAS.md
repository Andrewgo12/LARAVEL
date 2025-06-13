# 🔗 URLs CORRECTAS DEL SISTEMA HUV

## ❌ URLS INCORRECTAS (Causan "No direct script access allowed")

```
❌ http://localhost/resources/views/Vlogin.php
❌ http://localhost/application/views/Vlogin.php  
❌ http://localhost/views/Vlogin.php
❌ http://localhost/Proyecto/LARAVEL/new_eva/resources/views/Vlogin.php
❌ Cualquier acceso directo a archivos .php de vistas
```

## ✅ URLS CORRECTAS (A través del controlador)

### 🚀 OPCIÓN 1: Servidor Laravel (Recomendado)
```
✅ http://127.0.0.1:8000/ci/login           - Login principal
✅ http://127.0.0.1:8000/ci/home            - Dashboard
✅ http://127.0.0.1:8000/ci/modules         - Todos los módulos
✅ http://127.0.0.1:8000/ci/equipos         - Módulo equipos
✅ http://127.0.0.1:8000/ci/usuarios        - Módulo usuarios
✅ http://127.0.0.1:8000/ci/ordenes         - Módulo órdenes
```

### 🌐 OPCIÓN 2: XAMPP Apache
```
✅ http://localhost/Proyecto/LARAVEL/new_eva/
✅ http://localhost/Proyecto/LARAVEL/new_eva/index.php
✅ http://localhost/Proyecto/LARAVEL/new_eva/index.php/inicio
```

## 🔧 CÓMO INICIAR EL SISTEMA

### Método 1: Scripts Automáticos
```bash
# Doble clic en:
start-servers.bat
```

### Método 2: Manual
```bash
# Terminal 1: Servidor Laravel
php -S 127.0.0.1:8000 -t public

# Terminal 2: Servidor Vite (opcional)
npm run dev
```

### Método 3: XAMPP Apache
```bash
1. Abrir XAMPP Control Panel
2. Iniciar Apache y MySQL
3. Ir a: http://localhost/Proyecto/LARAVEL/new_eva/
```

## 👤 CREDENCIALES DE ACCESO

```
🔐 USUARIO DE PRUEBA:
Email: admin@huv.com
Contraseña: password

🔐 USUARIOS REALES DEL SISTEMA:
Email: jsebastiangb.12@gmail.com (Administrador)
Email: administrador131@gmail.com (administrador)
Email: electromedicina2huv@gmail.com (Juan Sebastian)
Nota: Contraseñas originales del sistema (hasheadas)
```

## 📋 MAPEO DE RUTAS CODEIGNITER → LARAVEL

| CodeIgniter Original | Laravel Nuevo |
|---------------------|---------------|
| `/index.php/Cauth` | `/ci/login` |
| `/index.php/Home` | `/ci/home` |
| `/index.php/Dashboard` | `/ci/dashboard` |
| `/index.php/Cequipos` | `/ci/equipos` |
| `/index.php/Cusuarios` | `/ci/usuarios` |
| `/index.php/Cordenes` | `/ci/ordenes` |
| `/index.php/Cpreventivos` | `/ci/preventivos` |
| `/index.php/Ccalibraciones` | `/ci/calibraciones` |
| `/index.php/Crepuestos` | `/ci/repuestos` |

## 🛠️ SOLUCIÓN DE PROBLEMAS

### Error: "No direct script access allowed"
**Causa:** Estás accediendo directamente a archivos PHP de vistas
**Solución:** Usa las URLs del controlador (✅ URLs CORRECTAS)

### Error: "ERR_CONNECTION_REFUSED"
**Causa:** El servidor no está corriendo
**Solución:** 
```bash
# Ejecutar:
start-servers.bat
# O manualmente:
php -S 127.0.0.1:8000 -t public
```

### Error: Página no se encuentra
**Causa:** URL incorrecta o servidor detenido
**Solución:** Verificar que uses las URLs correctas y el servidor esté activo

## 🎯 FLUJO DE ACCESO CORRECTO

1. **Iniciar servidores:** `start-servers.bat`
2. **Abrir navegador:** http://127.0.0.1:8000/ci/login
3. **Hacer login:** admin@huv.com / password
4. **Navegar por módulos:** http://127.0.0.1:8000/ci/modules

## 📞 VERIFICACIÓN RÁPIDA

### ✅ Sistema funcionando correctamente:
- Login carga sin errores
- Dashboard muestra información
- Módulos son accesibles
- Base de datos conecta

### ❌ Sistema con problemas:
- Error "No direct script access allowed"
- Error "ERR_CONNECTION_REFUSED"  
- Páginas en blanco
- Error 404

---

**💡 Recuerda:** Siempre accede a través del controlador principal, nunca directamente a los archivos PHP de las vistas.
