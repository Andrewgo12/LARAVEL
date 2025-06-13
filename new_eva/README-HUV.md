# Sistema HUV - Hospital Universitario del Valle

## 🏥 Descripción
Sistema integral de gestión hospitalaria con 40+ módulos especializados para equipos biomédicos, mantenimientos, calibraciones, órdenes de trabajo y más.

## 🚀 Inicio Rápido

### Opción 1: Scripts Automáticos (Recomendado)
```bash
# Iniciar servidores
start-servers.bat

# Detener servidores
stop-servers.bat
```

### Opción 2: Manual
```bash
# 1. Servidor Laravel
php -S 127.0.0.1:8000 -t public

# 2. Servidor Vite (en otra terminal)
npm run dev
```

## 🌐 URLs del Sistema

### 🏠 Acceso Principal
- **Login HUV:** http://127.0.0.1:8000/ci/login
- **Dashboard:** http://127.0.0.1:8000/ci/home
- **Todos los Módulos:** http://127.0.0.1:8000/ci/modules

### 🔧 Desarrollo y Testing
- **Laravel Principal:** http://127.0.0.1:8000
- **Vite (Hot Reload):** http://localhost:5173
- **Test Base de Datos:** http://127.0.0.1:8000/test-db

## 👤 Credenciales de Acceso

```
Email: admin@huv.com
Contraseña: password

Email: test@example.com
Contraseña: password
```

## 📋 Módulos Disponibles (40+)

### 🌟 Principales
- **Equipos Biomédicos** - `/ci/equipos`
- **Órdenes de Trabajo** - `/ci/ordenes`
- **Mantenimientos Preventivos** - `/ci/preventivos`
- **Calibraciones** - `/ci/calibraciones`
- **Repuestos** - `/ci/repuestos`
- **Usuarios** - `/ci/usuarios`

### 🏥 Gestión Hospitalaria
- **Técnicos** - `/ci/tecnicos`
- **Servicios** - `/ci/servicios`
- **Áreas** - `/ci/areas`
- **Categorías** - `/ci/categorias`
- **Contactos** - `/ci/contactos`
- **Propietarios** - `/ci/propietarios`

### 📊 Especializados
- **INVIMA** - `/ci/invimas`
- **Órdenes de Compra** - `/ci/ordenes_compra`
- **Manuales** - `/ci/manuales`
- **Guías Rápidas** - `/ci/guias`
- **Bajas de Equipos** - `/ci/bajas`
- **Archivos** - `/ci/archivos`
- **Reportes** - `/ci/reportes`

### ⚙️ Técnicos
- **Equipos Industriales** - `/ci/equipos_industriales`
- **Correctivos Generales** - `/ci/correctivos_generales`
- **Contingencias** - `/ci/contingencias`
- **Capacitaciones** - `/ci/capacitaciones`
- **Cambios de Ubicación** - `/ci/cambios_ubicaciones`
- **Avances Correctivos** - `/ci/avances_correctivos`

## 🗄️ Base de Datos

### Configuración MySQL
```
Host: 127.0.0.1
Puerto: 3306
Base de datos: veihuv
Usuario: root
Contraseña: (vacía)
```

### Verificar Conexión
```bash
# Comando MySQL
/c/xampp1/mysql/bin/mysql -u root veihuv -e "SHOW TABLES;"

# URL de prueba
http://127.0.0.1:8000/test-db
```

## 🎨 Características Técnicas

### ✅ Vistas Originales Preservadas
- **0 modificaciones** a las vistas de CodeIgniter
- **500+ vistas** disponibles
- **Estructura original** mantenida
- **AdminLTE** como interfaz

### ✅ Compatibilidad Total
- **Funciones helper** de CodeIgniter simuladas
- **Sesiones** compatibles
- **URLs originales** funcionando
- **Base de datos** MySQL integrada

### ✅ Arquitectura Híbrida
```
Laravel 11 (Framework base)
├── CodeIgniterController (Motor principal)
├── Simulación de funciones CI
├── 40+ Módulos automáticos
├── Vistas originales (sin cambios)
└── MySQL Database (veihuv)
```

## 🔧 Solución de Problemas

### Error: ERR_CONNECTION_REFUSED
```bash
# Reiniciar servidores
stop-servers.bat
start-servers.bat
```

### Error: Base de datos no conecta
```bash
# Verificar MySQL en XAMPP
# Iniciar Apache y MySQL en XAMPP Control Panel
```

### Error: Assets no cargan
```bash
# Recompilar assets
npm run build
```

### Error: Vistas no se encuentran
```bash
# Verificar estructura de carpetas
# Las vistas deben estar en: resources/views/
```

## 📁 Estructura del Proyecto

```
new_eva/
├── app/Http/Controllers/
│   └── CodeIgniterController.php    # Motor principal
├── resources/views/                  # 40+ módulos de vistas
│   ├── equipos/                     # 60+ vistas de equipos
│   ├── usuarios/                    # Gestión de usuarios
│   ├── ordenes/                     # Órdenes de trabajo
│   ├── preventivos/                 # Mantenimientos
│   ├── calibraciones/               # Calibraciones
│   ├── repuestos/                   # Repuestos
│   ├── layouts/                     # Header, footer, aside
│   └── [... 34+ módulos más]
├── routes/web.php                   # Rutas del sistema
├── database/                        # Configuración BD
├── start-servers.bat               # Script de inicio
├── stop-servers.bat                # Script de parada
└── README-HUV.md                   # Esta documentación
```

## 🎯 Comandos Útiles

```bash
# Desarrollo
npm run dev              # Servidor Vite con hot reload
npm run build           # Compilar para producción

# Laravel
php artisan serve       # Servidor Laravel alternativo
php artisan cache:clear # Limpiar caché

# Base de datos
php artisan migrate     # Ejecutar migraciones
php artisan tinker      # Consola interactiva
```

## 📞 Soporte

Para problemas técnicos:
1. Verificar que XAMPP esté corriendo (Apache + MySQL)
2. Ejecutar `start-servers.bat`
3. Verificar URLs en el navegador
4. Revisar logs en las ventanas de comando

---

**Sistema HUV v2.4.18 - Hospital Universitario del Valle**
*Desarrollado con Laravel 11 + CodeIgniter Legacy + MySQL*
