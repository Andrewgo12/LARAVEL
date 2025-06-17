<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Administrador\Cacciones;
use App\Http\Controllers\Administrador\Ccentros;
use App\Http\Controllers\Administrador\Ccuentas;
use App\Http\Controllers\Administrador\Cempresas;
use App\Http\Controllers\Administrador\Cpermisos;
use App\Http\Controllers\Administrador\Croles;
use App\Http\Controllers\Administrador\Csedes;
use App\Http\Controllers\Administrador\Cusuarios;
use App\Http\Controllers\Administrador\Czonas;
use App\Http\Controllers\Adquisicion\Cadquisiciones;
use App\Http\Controllers\Alerta\Calertas;
use App\Http\Controllers\Alerta\Calertas_inventario;
use App\Http\Controllers\Alerta\Calertas_mantenimiento;
use App\Http\Controllers\Api\Capi;
use App\Http\Controllers\Api\Capi_equipos;
use App\Http\Controllers\Api\Capi_mantenimientos;
use App\Http\Controllers\Aplicacion\Requipos;
use App\Http\Controllers\Aplicacion\Restserver;
use App\Http\Controllers\Aplicacion\Rpaises;
use App\Http\Controllers\Archivo\Carchivos;
use App\Http\Controllers\Auditoria\Cauditoria;
use App\Http\Controllers\Auditoria\Cauditoria_sistema;
use App\Http\Controllers\Auditoria\Cauditoria_usuarios;
use App\Http\Controllers\Avances_correctivos\Cavances_correctivos;
use App\Http\Controllers\Backup\Cbackup;
use App\Http\Controllers\Backup\Cbackup_archivos;
use App\Http\Controllers\Backup\Cbackup_bd;
use App\Http\Controllers\Baja\Cbajas;
use App\Http\Controllers\Calibracion\Ccalibraciones;
use App\Http\Controllers\Cambios_hdv\Ccambios_hdv;
use App\Http\Controllers\Cambios_ubicaciones\Ccambios_ubicaciones;
use App\Http\Controllers\Capacitacion\Ccapacitaciones;
use App\Http\Controllers\Categoria\Ccategorias;
use App\Http\Controllers\Cbiomedica\Ccbiomedicas;
use App\Http\Controllers\Cierre\Ccierres;
use App\Http\Controllers\Cliente\Cclientes;
use App\Http\Controllers\Configuracion\Cconfiguracion;
use App\Http\Controllers\Configuracion\Cconfiguracion_email;
use App\Http\Controllers\Configuracion\Cconfiguracion_sistema;
use App\Http\Controllers\Contacto\Ccontactos;
use App\Http\Controllers\Contingencia\Ccontingencias;
use App\Http\Controllers\Correctivo\Ccorrectivos_generales;
use App\Http\Controllers\Correctivo_general\Cavances_correctivos;
use App\Http\Controllers\Correctivo_general\Ccierres;
use App\Http\Controllers\Correctivo_general\Ccorrectivos_generales;
use App\Http\Controllers\Correctivo_general\Ctipos_fallas;
use App\Http\Controllers\Dashboard\Cdashboard;
use App\Http\Controllers\Dashboard\Cdashboard_ejecutivo;
use App\Http\Controllers\Dashboard\Cdashboard_operativo;
use App\Http\Controllers\Diagnostico\Cdiagnosticos;
use App\Http\Controllers\Equipo\Cbajas;
use App\Http\Controllers\Equipo\Ccambios_hdv;
use App\Http\Controllers\Equipo\Ccontingencias;
use App\Http\Controllers\Equipo\Cequipos;
use App\Http\Controllers\Equipo\Cinvimas;
use App\Http\Controllers\Equipos_ind\Cequipos_ind;
use App\Http\Controllers\Especificacion\Cespecificaciones;
use App\Http\Controllers\Estadistica\Cestadisticas;
use App\Http\Controllers\Estadistica\Cestadisticas_equipos;
use App\Http\Controllers\Estadistica\Cestadisticas_mantenimientos;
use App\Http\Controllers\Estado\Cestados;
use App\Http\Controllers\Frecuencia\Cfrecuencias;
use App\Http\Controllers\Fuente\Cfuentes;
use App\Http\Controllers\Guia\Cguias;
use App\Http\Controllers\Integracion\Cintegracion;
use App\Http\Controllers\Integracion\Cintegracion_cmms;
use App\Http\Controllers\Integracion\Cintegracion_erp;
use App\Http\Controllers\Invima\Cinvimas;
use App\Http\Controllers\Mantenimiento\Ccategorias;
use App\Http\Controllers\Mantenimiento\Cclientes;
use App\Http\Controllers\Mantenimiento\Cplanes;
use App\Http\Controllers\Mantenimiento\Cproveedores_mantenimiento;
use App\Http\Controllers\Manual\Cmanuales;
use App\Http\Controllers\Mobile\Cmobile;
use App\Http\Controllers\Mobile\Cmobile_equipos;
use App\Http\Controllers\Mobile\Cmobile_ordenes;
use App\Http\Controllers\Modulo\Cmodulos;
use App\Http\Controllers\Movimiento\Cmovimientos;
use App\Http\Controllers\Notificacion\Cnotificaciones;
use App\Http\Controllers\Notificacion\Cnotificaciones_email;
use App\Http\Controllers\Notificacion\Cnotificaciones_sms;
use App\Http\Controllers\Observacion\Cobservaciones;
use App\Http\Controllers\Orden\Cestados;
use App\Http\Controllers\Orden\Cordenes;
use App\Http\Controllers\Orden\Ctrabajos;
use App\Http\Controllers\Ordenes_compra\Cordenes_compra;
use App\Http\Controllers\Pais\Cpaises;
use App\Http\Controllers\Periodos_garantias\Cperiodos_garantias;
use App\Http\Controllers\Plan\Cplanes;
use App\Http\Controllers\Preventivo\Cpreventivos;
use App\Http\Controllers\Propietario\Cpropietarios;
use App\Http\Controllers\Proveedores_mantenimiento\Cproveedores_mantenimiento;
use App\Http\Controllers\Reporte\Creportes;
use App\Http\Controllers\Reporte\Creportes_equipos;
use App\Http\Controllers\Reporte\Creportes_inventario;
use App\Http\Controllers\Reporte\Creportes_mantenimientos;
use App\Http\Controllers\Repuesto\Crepuestos;
use App\Http\Controllers\Repuesto\Crepuestos_pendientes;
use App\Http\Controllers\Repuesto\Crepuestos_ti;
use App\Http\Controllers\Riesgo\Criesgos;
use App\Http\Controllers\Tecnico\Ctecnicos;
use App\Http\Controllers\Tecnologia\Ctecnologias;
use App\Http\Controllers\Tipos_compra\Ctipos_compra;
use App\Http\Controllers\Tipos_fallas\Ctipos_fallas;
use App\Http\Controllers\Trabajo\Ctrabajos;
use App\Http\Controllers\Ubicacion\Careas;
use App\Http\Controllers\Ubicacion\Ccambios_ubicaciones;
use App\Http\Controllers\Ubicacion\Ccentros;
use App\Http\Controllers\Ubicacion\Ccontactos;
use App\Http\Controllers\Ubicacion\Cestadoequipos;
use App\Http\Controllers\Ubicacion\Cpisos;
use App\Http\Controllers\Ubicacion\Csedes;
use App\Http\Controllers\Ubicacion\Cservicios;
use App\Http\Controllers\Ubicacion\Forbidden;
use App\Http\Controllers\Upload\Cupload;
use App\Http\Controllers\Usuarios_zonas\Cusuarios_zonas;
use App\Http\Controllers\Workflow\Cworkflow;
use App\Http\Controllers\Workflow\Cworkflow_mantenimientos;
use App\Http\Controllers\Workflow\Cworkflow_ordenes;
use App\Http\Controllers\Zona\Czonas;

/*
|--------------------------------------------------------------------------
| Sistema HUV - Rutas Completas
|--------------------------------------------------------------------------
| Rutas para TODOS los 147 controladores del sistema
| Convertido completamente de CodeIgniter a Laravel
*/

// Ruta principal
Route::get('/', function () {
    return redirect()->route('huv.login');
});

// Autenticación
Route::get('/login', [App\Http\Controllers\HuvController::class, 'login'])->name('huv.login');
Route::post('/authenticate', [App\Http\Controllers\HuvController::class, 'authenticate'])->name('huv.authenticate');
Route::get('/logout', [App\Http\Controllers\HuvController::class, 'logout'])->name('huv.logout');
Route::get('/dashboard', [App\Http\Controllers\HuvController::class, 'dashboard'])->name('huv.dashboard');
Route::get('/forbidden', [App\Http\Controllers\HuvController::class, 'forbidden'])->name('huv.forbidden');

// Rutas para Auth
Route::prefix('Auth')->group(function () {
    // AuthenticatedSessionController
    Route::prefix('authenticatedsessionontroller')->group(function () {
        Route::get('/', [Auth\AuthenticatedSessionController::class, 'index'])->name('Auth.authenticatedsessionontroller.index');
        Route::post('/getServerSide', [Auth\AuthenticatedSessionController::class, 'getServerSide'])->name('Auth.authenticatedsessionontroller.getServerSide');
        Route::post('/getOne', [Auth\AuthenticatedSessionController::class, 'getOne'])->name('Auth.authenticatedsessionontroller.getOne');
        Route::post('/add', [Auth\AuthenticatedSessionController::class, 'add'])->name('Auth.authenticatedsessionontroller.add');
        Route::post('/update', [Auth\AuthenticatedSessionController::class, 'update'])->name('Auth.authenticatedsessionontroller.update');
        Route::post('/delete', [Auth\AuthenticatedSessionController::class, 'delete'])->name('Auth.authenticatedsessionontroller.delete');
    });

    // ConfirmablePasswordController
    Route::prefix('onfirmablepasswordontroller')->group(function () {
        Route::get('/', [Auth\ConfirmablePasswordController::class, 'index'])->name('Auth.onfirmablepasswordontroller.index');
        Route::post('/getServerSide', [Auth\ConfirmablePasswordController::class, 'getServerSide'])->name('Auth.onfirmablepasswordontroller.getServerSide');
        Route::post('/getOne', [Auth\ConfirmablePasswordController::class, 'getOne'])->name('Auth.onfirmablepasswordontroller.getOne');
        Route::post('/add', [Auth\ConfirmablePasswordController::class, 'add'])->name('Auth.onfirmablepasswordontroller.add');
        Route::post('/update', [Auth\ConfirmablePasswordController::class, 'update'])->name('Auth.onfirmablepasswordontroller.update');
        Route::post('/delete', [Auth\ConfirmablePasswordController::class, 'delete'])->name('Auth.onfirmablepasswordontroller.delete');
    });

    // EmailVerificationNotificationController
    Route::prefix('emailverificationnotificationontroller')->group(function () {
        Route::get('/', [Auth\EmailVerificationNotificationController::class, 'index'])->name('Auth.emailverificationnotificationontroller.index');
        Route::post('/getServerSide', [Auth\EmailVerificationNotificationController::class, 'getServerSide'])->name('Auth.emailverificationnotificationontroller.getServerSide');
        Route::post('/getOne', [Auth\EmailVerificationNotificationController::class, 'getOne'])->name('Auth.emailverificationnotificationontroller.getOne');
        Route::post('/add', [Auth\EmailVerificationNotificationController::class, 'add'])->name('Auth.emailverificationnotificationontroller.add');
        Route::post('/update', [Auth\EmailVerificationNotificationController::class, 'update'])->name('Auth.emailverificationnotificationontroller.update');
        Route::post('/delete', [Auth\EmailVerificationNotificationController::class, 'delete'])->name('Auth.emailverificationnotificationontroller.delete');
    });

    // EmailVerificationPromptController
    Route::prefix('emailverificationpromptontroller')->group(function () {
        Route::get('/', [Auth\EmailVerificationPromptController::class, 'index'])->name('Auth.emailverificationpromptontroller.index');
        Route::post('/getServerSide', [Auth\EmailVerificationPromptController::class, 'getServerSide'])->name('Auth.emailverificationpromptontroller.getServerSide');
        Route::post('/getOne', [Auth\EmailVerificationPromptController::class, 'getOne'])->name('Auth.emailverificationpromptontroller.getOne');
        Route::post('/add', [Auth\EmailVerificationPromptController::class, 'add'])->name('Auth.emailverificationpromptontroller.add');
        Route::post('/update', [Auth\EmailVerificationPromptController::class, 'update'])->name('Auth.emailverificationpromptontroller.update');
        Route::post('/delete', [Auth\EmailVerificationPromptController::class, 'delete'])->name('Auth.emailverificationpromptontroller.delete');
    });

    // NewPasswordController
    Route::prefix('newpasswordontroller')->group(function () {
        Route::get('/', [Auth\NewPasswordController::class, 'index'])->name('Auth.newpasswordontroller.index');
        Route::post('/getServerSide', [Auth\NewPasswordController::class, 'getServerSide'])->name('Auth.newpasswordontroller.getServerSide');
        Route::post('/getOne', [Auth\NewPasswordController::class, 'getOne'])->name('Auth.newpasswordontroller.getOne');
        Route::post('/add', [Auth\NewPasswordController::class, 'add'])->name('Auth.newpasswordontroller.add');
        Route::post('/update', [Auth\NewPasswordController::class, 'update'])->name('Auth.newpasswordontroller.update');
        Route::post('/delete', [Auth\NewPasswordController::class, 'delete'])->name('Auth.newpasswordontroller.delete');
    });

    // PasswordResetLinkController
    Route::prefix('passwordresetlinkontroller')->group(function () {
        Route::get('/', [Auth\PasswordResetLinkController::class, 'index'])->name('Auth.passwordresetlinkontroller.index');
        Route::post('/getServerSide', [Auth\PasswordResetLinkController::class, 'getServerSide'])->name('Auth.passwordresetlinkontroller.getServerSide');
        Route::post('/getOne', [Auth\PasswordResetLinkController::class, 'getOne'])->name('Auth.passwordresetlinkontroller.getOne');
        Route::post('/add', [Auth\PasswordResetLinkController::class, 'add'])->name('Auth.passwordresetlinkontroller.add');
        Route::post('/update', [Auth\PasswordResetLinkController::class, 'update'])->name('Auth.passwordresetlinkontroller.update');
        Route::post('/delete', [Auth\PasswordResetLinkController::class, 'delete'])->name('Auth.passwordresetlinkontroller.delete');
    });

    // RegisteredUserController
    Route::prefix('registereduserontroller')->group(function () {
        Route::get('/', [Auth\RegisteredUserController::class, 'index'])->name('Auth.registereduserontroller.index');
        Route::post('/getServerSide', [Auth\RegisteredUserController::class, 'getServerSide'])->name('Auth.registereduserontroller.getServerSide');
        Route::post('/getOne', [Auth\RegisteredUserController::class, 'getOne'])->name('Auth.registereduserontroller.getOne');
        Route::post('/add', [Auth\RegisteredUserController::class, 'add'])->name('Auth.registereduserontroller.add');
        Route::post('/update', [Auth\RegisteredUserController::class, 'update'])->name('Auth.registereduserontroller.update');
        Route::post('/delete', [Auth\RegisteredUserController::class, 'delete'])->name('Auth.registereduserontroller.delete');
    });

    // VerifyEmailController
    Route::prefix('verifyemailontroller')->group(function () {
        Route::get('/', [Auth\VerifyEmailController::class, 'index'])->name('Auth.verifyemailontroller.index');
        Route::post('/getServerSide', [Auth\VerifyEmailController::class, 'getServerSide'])->name('Auth.verifyemailontroller.getServerSide');
        Route::post('/getOne', [Auth\VerifyEmailController::class, 'getOne'])->name('Auth.verifyemailontroller.getOne');
        Route::post('/add', [Auth\VerifyEmailController::class, 'add'])->name('Auth.verifyemailontroller.add');
        Route::post('/update', [Auth\VerifyEmailController::class, 'update'])->name('Auth.verifyemailontroller.update');
        Route::post('/delete', [Auth\VerifyEmailController::class, 'delete'])->name('Auth.verifyemailontroller.delete');
    });
});

// Rutas para Settings
Route::prefix('Settings')->group(function () {
    // PasswordController
    Route::prefix('passwordontroller')->group(function () {
        Route::get('/', [Settings\PasswordController::class, 'index'])->name('Settings.passwordontroller.index');
        Route::post('/getServerSide', [Settings\PasswordController::class, 'getServerSide'])->name('Settings.passwordontroller.getServerSide');
        Route::post('/getOne', [Settings\PasswordController::class, 'getOne'])->name('Settings.passwordontroller.getOne');
        Route::post('/add', [Settings\PasswordController::class, 'add'])->name('Settings.passwordontroller.add');
        Route::post('/update', [Settings\PasswordController::class, 'update'])->name('Settings.passwordontroller.update');
        Route::post('/delete', [Settings\PasswordController::class, 'delete'])->name('Settings.passwordontroller.delete');
    });

    // ProfileController
    Route::prefix('profileontroller')->group(function () {
        Route::get('/', [Settings\ProfileController::class, 'index'])->name('Settings.profileontroller.index');
        Route::post('/getServerSide', [Settings\ProfileController::class, 'getServerSide'])->name('Settings.profileontroller.getServerSide');
        Route::post('/getOne', [Settings\ProfileController::class, 'getOne'])->name('Settings.profileontroller.getOne');
        Route::post('/add', [Settings\ProfileController::class, 'add'])->name('Settings.profileontroller.add');
        Route::post('/update', [Settings\ProfileController::class, 'update'])->name('Settings.profileontroller.update');
        Route::post('/delete', [Settings\ProfileController::class, 'delete'])->name('Settings.profileontroller.delete');
    });
});

// Rutas para administrador
Route::prefix('administrador')->group(function () {
    // Cacciones
    Route::prefix('acciones')->group(function () {
        Route::get('/', [Administrador\Cacciones::class, 'index'])->name('administrador.acciones.index');
        Route::post('/getServerSide', [Administrador\Cacciones::class, 'getServerSide'])->name('administrador.acciones.getServerSide');
        Route::post('/getOne', [Administrador\Cacciones::class, 'getOne'])->name('administrador.acciones.getOne');
        Route::post('/add', [Administrador\Cacciones::class, 'add'])->name('administrador.acciones.add');
        Route::post('/update', [Administrador\Cacciones::class, 'update'])->name('administrador.acciones.update');
        Route::post('/delete', [Administrador\Cacciones::class, 'delete'])->name('administrador.acciones.delete');
    });

    // Ccentros
    Route::prefix('centros')->group(function () {
        Route::get('/', [Administrador\Ccentros::class, 'index'])->name('administrador.centros.index');
        Route::post('/getServerSide', [Administrador\Ccentros::class, 'getServerSide'])->name('administrador.centros.getServerSide');
        Route::post('/getOne', [Administrador\Ccentros::class, 'getOne'])->name('administrador.centros.getOne');
        Route::post('/add', [Administrador\Ccentros::class, 'add'])->name('administrador.centros.add');
        Route::post('/update', [Administrador\Ccentros::class, 'update'])->name('administrador.centros.update');
        Route::post('/delete', [Administrador\Ccentros::class, 'delete'])->name('administrador.centros.delete');
    });

    // Ccuentas
    Route::prefix('cuentas')->group(function () {
        Route::get('/', [Administrador\Ccuentas::class, 'index'])->name('administrador.cuentas.index');
        Route::post('/getServerSide', [Administrador\Ccuentas::class, 'getServerSide'])->name('administrador.cuentas.getServerSide');
        Route::post('/getOne', [Administrador\Ccuentas::class, 'getOne'])->name('administrador.cuentas.getOne');
        Route::post('/add', [Administrador\Ccuentas::class, 'add'])->name('administrador.cuentas.add');
        Route::post('/update', [Administrador\Ccuentas::class, 'update'])->name('administrador.cuentas.update');
        Route::post('/delete', [Administrador\Ccuentas::class, 'delete'])->name('administrador.cuentas.delete');
    });

    // Cempresas
    Route::prefix('empresas')->group(function () {
        Route::get('/', [Administrador\Cempresas::class, 'index'])->name('administrador.empresas.index');
        Route::post('/getServerSide', [Administrador\Cempresas::class, 'getServerSide'])->name('administrador.empresas.getServerSide');
        Route::post('/getOne', [Administrador\Cempresas::class, 'getOne'])->name('administrador.empresas.getOne');
        Route::post('/add', [Administrador\Cempresas::class, 'add'])->name('administrador.empresas.add');
        Route::post('/update', [Administrador\Cempresas::class, 'update'])->name('administrador.empresas.update');
        Route::post('/delete', [Administrador\Cempresas::class, 'delete'])->name('administrador.empresas.delete');
    });

    // Cpermisos
    Route::prefix('permisos')->group(function () {
        Route::get('/', [Administrador\Cpermisos::class, 'index'])->name('administrador.permisos.index');
        Route::post('/getServerSide', [Administrador\Cpermisos::class, 'getServerSide'])->name('administrador.permisos.getServerSide');
        Route::post('/getOne', [Administrador\Cpermisos::class, 'getOne'])->name('administrador.permisos.getOne');
        Route::post('/add', [Administrador\Cpermisos::class, 'add'])->name('administrador.permisos.add');
        Route::post('/update', [Administrador\Cpermisos::class, 'update'])->name('administrador.permisos.update');
        Route::post('/delete', [Administrador\Cpermisos::class, 'delete'])->name('administrador.permisos.delete');
    });

    // Croles
    Route::prefix('roles')->group(function () {
        Route::get('/', [Administrador\Croles::class, 'index'])->name('administrador.roles.index');
        Route::post('/getServerSide', [Administrador\Croles::class, 'getServerSide'])->name('administrador.roles.getServerSide');
        Route::post('/getOne', [Administrador\Croles::class, 'getOne'])->name('administrador.roles.getOne');
        Route::post('/add', [Administrador\Croles::class, 'add'])->name('administrador.roles.add');
        Route::post('/update', [Administrador\Croles::class, 'update'])->name('administrador.roles.update');
        Route::post('/delete', [Administrador\Croles::class, 'delete'])->name('administrador.roles.delete');
    });

    // Csedes
    Route::prefix('sedes')->group(function () {
        Route::get('/', [Administrador\Csedes::class, 'index'])->name('administrador.sedes.index');
        Route::post('/getServerSide', [Administrador\Csedes::class, 'getServerSide'])->name('administrador.sedes.getServerSide');
        Route::post('/getOne', [Administrador\Csedes::class, 'getOne'])->name('administrador.sedes.getOne');
        Route::post('/add', [Administrador\Csedes::class, 'add'])->name('administrador.sedes.add');
        Route::post('/update', [Administrador\Csedes::class, 'update'])->name('administrador.sedes.update');
        Route::post('/delete', [Administrador\Csedes::class, 'delete'])->name('administrador.sedes.delete');
    });

    // Cusuarios
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [Administrador\Cusuarios::class, 'index'])->name('administrador.usuarios.index');
        Route::post('/getServerSide', [Administrador\Cusuarios::class, 'getServerSide'])->name('administrador.usuarios.getServerSide');
        Route::post('/getOne', [Administrador\Cusuarios::class, 'getOne'])->name('administrador.usuarios.getOne');
        Route::post('/add', [Administrador\Cusuarios::class, 'add'])->name('administrador.usuarios.add');
        Route::post('/update', [Administrador\Cusuarios::class, 'update'])->name('administrador.usuarios.update');
        Route::post('/delete', [Administrador\Cusuarios::class, 'delete'])->name('administrador.usuarios.delete');
        Route::post('/activate', [Administrador\Cusuarios::class, 'activate'])->name('administrador.usuarios.activate');
        Route::post('/cambiarSede', [Administrador\Cusuarios::class, 'cambiarSede'])->name('administrador.usuarios.cambiarSede');
        Route::post('/resetPassword', [Administrador\Cusuarios::class, 'resetPassword'])->name('administrador.usuarios.resetPassword');
    });

    // Czonas
    Route::prefix('zonas')->group(function () {
        Route::get('/', [Administrador\Czonas::class, 'index'])->name('administrador.zonas.index');
        Route::post('/getServerSide', [Administrador\Czonas::class, 'getServerSide'])->name('administrador.zonas.getServerSide');
        Route::post('/getOne', [Administrador\Czonas::class, 'getOne'])->name('administrador.zonas.getOne');
        Route::post('/add', [Administrador\Czonas::class, 'add'])->name('administrador.zonas.add');
        Route::post('/update', [Administrador\Czonas::class, 'update'])->name('administrador.zonas.update');
        Route::post('/delete', [Administrador\Czonas::class, 'delete'])->name('administrador.zonas.delete');
    });
});

// Rutas para adquisicion
Route::prefix('adquisicion')->group(function () {
    // Cadquisiciones
    Route::prefix('adquisiciones')->group(function () {
        Route::get('/', [Adquisicion\Cadquisiciones::class, 'index'])->name('adquisicion.adquisiciones.index');
        Route::post('/getServerSide', [Adquisicion\Cadquisiciones::class, 'getServerSide'])->name('adquisicion.adquisiciones.getServerSide');
        Route::post('/getOne', [Adquisicion\Cadquisiciones::class, 'getOne'])->name('adquisicion.adquisiciones.getOne');
        Route::post('/add', [Adquisicion\Cadquisiciones::class, 'add'])->name('adquisicion.adquisiciones.add');
        Route::post('/update', [Adquisicion\Cadquisiciones::class, 'update'])->name('adquisicion.adquisiciones.update');
        Route::post('/delete', [Adquisicion\Cadquisiciones::class, 'delete'])->name('adquisicion.adquisiciones.delete');
    });
});

// Rutas para alerta
Route::prefix('alerta')->group(function () {
    // Calertas
    Route::prefix('alertas')->group(function () {
        Route::get('/', [Alerta\Calertas::class, 'index'])->name('alerta.alertas.index');
        Route::post('/getServerSide', [Alerta\Calertas::class, 'getServerSide'])->name('alerta.alertas.getServerSide');
        Route::post('/getOne', [Alerta\Calertas::class, 'getOne'])->name('alerta.alertas.getOne');
        Route::post('/add', [Alerta\Calertas::class, 'add'])->name('alerta.alertas.add');
        Route::post('/update', [Alerta\Calertas::class, 'update'])->name('alerta.alertas.update');
        Route::post('/delete', [Alerta\Calertas::class, 'delete'])->name('alerta.alertas.delete');
    });

    // Calertas_inventario
    Route::prefix('alertas_inventario')->group(function () {
        Route::get('/', [Alerta\Calertas_inventario::class, 'index'])->name('alerta.alertas_inventario.index');
        Route::post('/getServerSide', [Alerta\Calertas_inventario::class, 'getServerSide'])->name('alerta.alertas_inventario.getServerSide');
        Route::post('/getOne', [Alerta\Calertas_inventario::class, 'getOne'])->name('alerta.alertas_inventario.getOne');
        Route::post('/add', [Alerta\Calertas_inventario::class, 'add'])->name('alerta.alertas_inventario.add');
        Route::post('/update', [Alerta\Calertas_inventario::class, 'update'])->name('alerta.alertas_inventario.update');
        Route::post('/delete', [Alerta\Calertas_inventario::class, 'delete'])->name('alerta.alertas_inventario.delete');
    });

    // Calertas_mantenimiento
    Route::prefix('alertas_mantenimiento')->group(function () {
        Route::get('/', [Alerta\Calertas_mantenimiento::class, 'index'])->name('alerta.alertas_mantenimiento.index');
        Route::post('/getServerSide', [Alerta\Calertas_mantenimiento::class, 'getServerSide'])->name('alerta.alertas_mantenimiento.getServerSide');
        Route::post('/getOne', [Alerta\Calertas_mantenimiento::class, 'getOne'])->name('alerta.alertas_mantenimiento.getOne');
        Route::post('/add', [Alerta\Calertas_mantenimiento::class, 'add'])->name('alerta.alertas_mantenimiento.add');
        Route::post('/update', [Alerta\Calertas_mantenimiento::class, 'update'])->name('alerta.alertas_mantenimiento.update');
        Route::post('/delete', [Alerta\Calertas_mantenimiento::class, 'delete'])->name('alerta.alertas_mantenimiento.delete');
    });
});

// Rutas para api
Route::prefix('api')->group(function () {
    // Capi
    Route::prefix('api')->group(function () {
        Route::get('/', [Api\Capi::class, 'index'])->name('api.api.index');
        Route::post('/getServerSide', [Api\Capi::class, 'getServerSide'])->name('api.api.getServerSide');
        Route::post('/getOne', [Api\Capi::class, 'getOne'])->name('api.api.getOne');
        Route::post('/add', [Api\Capi::class, 'add'])->name('api.api.add');
        Route::post('/update', [Api\Capi::class, 'update'])->name('api.api.update');
        Route::post('/delete', [Api\Capi::class, 'delete'])->name('api.api.delete');
    });

    // Capi_equipos
    Route::prefix('api_equipos')->group(function () {
        Route::get('/', [Api\Capi_equipos::class, 'index'])->name('api.api_equipos.index');
        Route::post('/getServerSide', [Api\Capi_equipos::class, 'getServerSide'])->name('api.api_equipos.getServerSide');
        Route::post('/getOne', [Api\Capi_equipos::class, 'getOne'])->name('api.api_equipos.getOne');
        Route::post('/add', [Api\Capi_equipos::class, 'add'])->name('api.api_equipos.add');
        Route::post('/update', [Api\Capi_equipos::class, 'update'])->name('api.api_equipos.update');
        Route::post('/delete', [Api\Capi_equipos::class, 'delete'])->name('api.api_equipos.delete');
        Route::post('/copy', [Api\Capi_equipos::class, 'copy'])->name('api.api_equipos.copy');
        Route::get('/getServicios', [Api\Capi_equipos::class, 'getServicios'])->name('api.api_equipos.getServicios');
        Route::get('/getAreas', [Api\Capi_equipos::class, 'getAreas'])->name('api.api_equipos.getAreas');
        Route::post('/uploadImage', [Api\Capi_equipos::class, 'uploadImage'])->name('api.api_equipos.uploadImage');
        Route::post('/uploadFile', [Api\Capi_equipos::class, 'uploadFile'])->name('api.api_equipos.uploadFile');
    });

    // Capi_mantenimientos
    Route::prefix('api_mantenimientos')->group(function () {
        Route::get('/', [Api\Capi_mantenimientos::class, 'index'])->name('api.api_mantenimientos.index');
        Route::post('/getServerSide', [Api\Capi_mantenimientos::class, 'getServerSide'])->name('api.api_mantenimientos.getServerSide');
        Route::post('/getOne', [Api\Capi_mantenimientos::class, 'getOne'])->name('api.api_mantenimientos.getOne');
        Route::post('/add', [Api\Capi_mantenimientos::class, 'add'])->name('api.api_mantenimientos.add');
        Route::post('/update', [Api\Capi_mantenimientos::class, 'update'])->name('api.api_mantenimientos.update');
        Route::post('/delete', [Api\Capi_mantenimientos::class, 'delete'])->name('api.api_mantenimientos.delete');
    });
});

// Rutas para aplicacion
Route::prefix('aplicacion')->group(function () {
    // Requipos
    Route::prefix('requipos')->group(function () {
        Route::get('/', [Aplicacion\Requipos::class, 'index'])->name('aplicacion.requipos.index');
        Route::post('/getServerSide', [Aplicacion\Requipos::class, 'getServerSide'])->name('aplicacion.requipos.getServerSide');
        Route::post('/getOne', [Aplicacion\Requipos::class, 'getOne'])->name('aplicacion.requipos.getOne');
        Route::post('/add', [Aplicacion\Requipos::class, 'add'])->name('aplicacion.requipos.add');
        Route::post('/update', [Aplicacion\Requipos::class, 'update'])->name('aplicacion.requipos.update');
        Route::post('/delete', [Aplicacion\Requipos::class, 'delete'])->name('aplicacion.requipos.delete');
        Route::post('/copy', [Aplicacion\Requipos::class, 'copy'])->name('aplicacion.requipos.copy');
        Route::get('/getServicios', [Aplicacion\Requipos::class, 'getServicios'])->name('aplicacion.requipos.getServicios');
        Route::get('/getAreas', [Aplicacion\Requipos::class, 'getAreas'])->name('aplicacion.requipos.getAreas');
        Route::post('/uploadImage', [Aplicacion\Requipos::class, 'uploadImage'])->name('aplicacion.requipos.uploadImage');
        Route::post('/uploadFile', [Aplicacion\Requipos::class, 'uploadFile'])->name('aplicacion.requipos.uploadFile');
    });

    // Restserver
    Route::prefix('restserver')->group(function () {
        Route::get('/', [Aplicacion\Restserver::class, 'index'])->name('aplicacion.restserver.index');
        Route::post('/getServerSide', [Aplicacion\Restserver::class, 'getServerSide'])->name('aplicacion.restserver.getServerSide');
        Route::post('/getOne', [Aplicacion\Restserver::class, 'getOne'])->name('aplicacion.restserver.getOne');
        Route::post('/add', [Aplicacion\Restserver::class, 'add'])->name('aplicacion.restserver.add');
        Route::post('/update', [Aplicacion\Restserver::class, 'update'])->name('aplicacion.restserver.update');
        Route::post('/delete', [Aplicacion\Restserver::class, 'delete'])->name('aplicacion.restserver.delete');
    });

    // Rpaises
    Route::prefix('rpaises')->group(function () {
        Route::get('/', [Aplicacion\Rpaises::class, 'index'])->name('aplicacion.rpaises.index');
        Route::post('/getServerSide', [Aplicacion\Rpaises::class, 'getServerSide'])->name('aplicacion.rpaises.getServerSide');
        Route::post('/getOne', [Aplicacion\Rpaises::class, 'getOne'])->name('aplicacion.rpaises.getOne');
        Route::post('/add', [Aplicacion\Rpaises::class, 'add'])->name('aplicacion.rpaises.add');
        Route::post('/update', [Aplicacion\Rpaises::class, 'update'])->name('aplicacion.rpaises.update');
        Route::post('/delete', [Aplicacion\Rpaises::class, 'delete'])->name('aplicacion.rpaises.delete');
    });
});

// Rutas para archivo
Route::prefix('archivo')->group(function () {
    // Carchivos
    Route::prefix('archivos')->group(function () {
        Route::get('/', [Archivo\Carchivos::class, 'index'])->name('archivo.archivos.index');
        Route::post('/getServerSide', [Archivo\Carchivos::class, 'getServerSide'])->name('archivo.archivos.getServerSide');
        Route::post('/getOne', [Archivo\Carchivos::class, 'getOne'])->name('archivo.archivos.getOne');
        Route::post('/add', [Archivo\Carchivos::class, 'add'])->name('archivo.archivos.add');
        Route::post('/update', [Archivo\Carchivos::class, 'update'])->name('archivo.archivos.update');
        Route::post('/delete', [Archivo\Carchivos::class, 'delete'])->name('archivo.archivos.delete');
    });
});

// Rutas para auditoria
Route::prefix('auditoria')->group(function () {
    // Cauditoria
    Route::prefix('auditoria')->group(function () {
        Route::get('/', [Auditoria\Cauditoria::class, 'index'])->name('auditoria.auditoria.index');
        Route::post('/getServerSide', [Auditoria\Cauditoria::class, 'getServerSide'])->name('auditoria.auditoria.getServerSide');
        Route::post('/getOne', [Auditoria\Cauditoria::class, 'getOne'])->name('auditoria.auditoria.getOne');
        Route::post('/add', [Auditoria\Cauditoria::class, 'add'])->name('auditoria.auditoria.add');
        Route::post('/update', [Auditoria\Cauditoria::class, 'update'])->name('auditoria.auditoria.update');
        Route::post('/delete', [Auditoria\Cauditoria::class, 'delete'])->name('auditoria.auditoria.delete');
    });

    // Cauditoria_sistema
    Route::prefix('auditoria_sistema')->group(function () {
        Route::get('/', [Auditoria\Cauditoria_sistema::class, 'index'])->name('auditoria.auditoria_sistema.index');
        Route::post('/getServerSide', [Auditoria\Cauditoria_sistema::class, 'getServerSide'])->name('auditoria.auditoria_sistema.getServerSide');
        Route::post('/getOne', [Auditoria\Cauditoria_sistema::class, 'getOne'])->name('auditoria.auditoria_sistema.getOne');
        Route::post('/add', [Auditoria\Cauditoria_sistema::class, 'add'])->name('auditoria.auditoria_sistema.add');
        Route::post('/update', [Auditoria\Cauditoria_sistema::class, 'update'])->name('auditoria.auditoria_sistema.update');
        Route::post('/delete', [Auditoria\Cauditoria_sistema::class, 'delete'])->name('auditoria.auditoria_sistema.delete');
    });

    // Cauditoria_usuarios
    Route::prefix('auditoria_usuarios')->group(function () {
        Route::get('/', [Auditoria\Cauditoria_usuarios::class, 'index'])->name('auditoria.auditoria_usuarios.index');
        Route::post('/getServerSide', [Auditoria\Cauditoria_usuarios::class, 'getServerSide'])->name('auditoria.auditoria_usuarios.getServerSide');
        Route::post('/getOne', [Auditoria\Cauditoria_usuarios::class, 'getOne'])->name('auditoria.auditoria_usuarios.getOne');
        Route::post('/add', [Auditoria\Cauditoria_usuarios::class, 'add'])->name('auditoria.auditoria_usuarios.add');
        Route::post('/update', [Auditoria\Cauditoria_usuarios::class, 'update'])->name('auditoria.auditoria_usuarios.update');
        Route::post('/delete', [Auditoria\Cauditoria_usuarios::class, 'delete'])->name('auditoria.auditoria_usuarios.delete');
        Route::post('/activate', [Auditoria\Cauditoria_usuarios::class, 'activate'])->name('auditoria.auditoria_usuarios.activate');
        Route::post('/cambiarSede', [Auditoria\Cauditoria_usuarios::class, 'cambiarSede'])->name('auditoria.auditoria_usuarios.cambiarSede');
        Route::post('/resetPassword', [Auditoria\Cauditoria_usuarios::class, 'resetPassword'])->name('auditoria.auditoria_usuarios.resetPassword');
    });
});

// Rutas para avances_correctivos
Route::prefix('avances_correctivos')->group(function () {
    // Cavances_correctivos
    Route::prefix('avances_correctivos')->group(function () {
        Route::get('/', [Avances_correctivos\Cavances_correctivos::class, 'index'])->name('avances_correctivos.avances_correctivos.index');
        Route::post('/getServerSide', [Avances_correctivos\Cavances_correctivos::class, 'getServerSide'])->name('avances_correctivos.avances_correctivos.getServerSide');
        Route::post('/getOne', [Avances_correctivos\Cavances_correctivos::class, 'getOne'])->name('avances_correctivos.avances_correctivos.getOne');
        Route::post('/add', [Avances_correctivos\Cavances_correctivos::class, 'add'])->name('avances_correctivos.avances_correctivos.add');
        Route::post('/update', [Avances_correctivos\Cavances_correctivos::class, 'update'])->name('avances_correctivos.avances_correctivos.update');
        Route::post('/delete', [Avances_correctivos\Cavances_correctivos::class, 'delete'])->name('avances_correctivos.avances_correctivos.delete');
    });
});

// Rutas para backup
Route::prefix('backup')->group(function () {
    // Cbackup
    Route::prefix('backup')->group(function () {
        Route::get('/', [Backup\Cbackup::class, 'index'])->name('backup.backup.index');
        Route::post('/getServerSide', [Backup\Cbackup::class, 'getServerSide'])->name('backup.backup.getServerSide');
        Route::post('/getOne', [Backup\Cbackup::class, 'getOne'])->name('backup.backup.getOne');
        Route::post('/add', [Backup\Cbackup::class, 'add'])->name('backup.backup.add');
        Route::post('/update', [Backup\Cbackup::class, 'update'])->name('backup.backup.update');
        Route::post('/delete', [Backup\Cbackup::class, 'delete'])->name('backup.backup.delete');
    });

    // Cbackup_archivos
    Route::prefix('backup_archivos')->group(function () {
        Route::get('/', [Backup\Cbackup_archivos::class, 'index'])->name('backup.backup_archivos.index');
        Route::post('/getServerSide', [Backup\Cbackup_archivos::class, 'getServerSide'])->name('backup.backup_archivos.getServerSide');
        Route::post('/getOne', [Backup\Cbackup_archivos::class, 'getOne'])->name('backup.backup_archivos.getOne');
        Route::post('/add', [Backup\Cbackup_archivos::class, 'add'])->name('backup.backup_archivos.add');
        Route::post('/update', [Backup\Cbackup_archivos::class, 'update'])->name('backup.backup_archivos.update');
        Route::post('/delete', [Backup\Cbackup_archivos::class, 'delete'])->name('backup.backup_archivos.delete');
    });

    // Cbackup_bd
    Route::prefix('backup_bd')->group(function () {
        Route::get('/', [Backup\Cbackup_bd::class, 'index'])->name('backup.backup_bd.index');
        Route::post('/getServerSide', [Backup\Cbackup_bd::class, 'getServerSide'])->name('backup.backup_bd.getServerSide');
        Route::post('/getOne', [Backup\Cbackup_bd::class, 'getOne'])->name('backup.backup_bd.getOne');
        Route::post('/add', [Backup\Cbackup_bd::class, 'add'])->name('backup.backup_bd.add');
        Route::post('/update', [Backup\Cbackup_bd::class, 'update'])->name('backup.backup_bd.update');
        Route::post('/delete', [Backup\Cbackup_bd::class, 'delete'])->name('backup.backup_bd.delete');
    });
});

// Rutas para baja
Route::prefix('baja')->group(function () {
    // Cbajas
    Route::prefix('bajas')->group(function () {
        Route::get('/', [Baja\Cbajas::class, 'index'])->name('baja.bajas.index');
        Route::post('/getServerSide', [Baja\Cbajas::class, 'getServerSide'])->name('baja.bajas.getServerSide');
        Route::post('/getOne', [Baja\Cbajas::class, 'getOne'])->name('baja.bajas.getOne');
        Route::post('/add', [Baja\Cbajas::class, 'add'])->name('baja.bajas.add');
        Route::post('/update', [Baja\Cbajas::class, 'update'])->name('baja.bajas.update');
        Route::post('/delete', [Baja\Cbajas::class, 'delete'])->name('baja.bajas.delete');
    });
});

// Rutas para calibracion
Route::prefix('calibracion')->group(function () {
    // Ccalibraciones
    Route::prefix('calibraciones')->group(function () {
        Route::get('/', [Calibracion\Ccalibraciones::class, 'index'])->name('calibracion.calibraciones.index');
        Route::post('/getServerSide', [Calibracion\Ccalibraciones::class, 'getServerSide'])->name('calibracion.calibraciones.getServerSide');
        Route::post('/getOne', [Calibracion\Ccalibraciones::class, 'getOne'])->name('calibracion.calibraciones.getOne');
        Route::post('/add', [Calibracion\Ccalibraciones::class, 'add'])->name('calibracion.calibraciones.add');
        Route::post('/update', [Calibracion\Ccalibraciones::class, 'update'])->name('calibracion.calibraciones.update');
        Route::post('/delete', [Calibracion\Ccalibraciones::class, 'delete'])->name('calibracion.calibraciones.delete');
    });
});

// Rutas para cambios_hdv
Route::prefix('cambios_hdv')->group(function () {
    // Ccambios_hdv
    Route::prefix('cambios_hdv')->group(function () {
        Route::get('/', [Cambios_hdv\Ccambios_hdv::class, 'index'])->name('cambios_hdv.cambios_hdv.index');
        Route::post('/getServerSide', [Cambios_hdv\Ccambios_hdv::class, 'getServerSide'])->name('cambios_hdv.cambios_hdv.getServerSide');
        Route::post('/getOne', [Cambios_hdv\Ccambios_hdv::class, 'getOne'])->name('cambios_hdv.cambios_hdv.getOne');
        Route::post('/add', [Cambios_hdv\Ccambios_hdv::class, 'add'])->name('cambios_hdv.cambios_hdv.add');
        Route::post('/update', [Cambios_hdv\Ccambios_hdv::class, 'update'])->name('cambios_hdv.cambios_hdv.update');
        Route::post('/delete', [Cambios_hdv\Ccambios_hdv::class, 'delete'])->name('cambios_hdv.cambios_hdv.delete');
    });
});

// Rutas para cambios_ubicaciones
Route::prefix('cambios_ubicaciones')->group(function () {
    // Ccambios_ubicaciones
    Route::prefix('cambios_ubicaciones')->group(function () {
        Route::get('/', [Cambios_ubicaciones\Ccambios_ubicaciones::class, 'index'])->name('cambios_ubicaciones.cambios_ubicaciones.index');
        Route::post('/getServerSide', [Cambios_ubicaciones\Ccambios_ubicaciones::class, 'getServerSide'])->name('cambios_ubicaciones.cambios_ubicaciones.getServerSide');
        Route::post('/getOne', [Cambios_ubicaciones\Ccambios_ubicaciones::class, 'getOne'])->name('cambios_ubicaciones.cambios_ubicaciones.getOne');
        Route::post('/add', [Cambios_ubicaciones\Ccambios_ubicaciones::class, 'add'])->name('cambios_ubicaciones.cambios_ubicaciones.add');
        Route::post('/update', [Cambios_ubicaciones\Ccambios_ubicaciones::class, 'update'])->name('cambios_ubicaciones.cambios_ubicaciones.update');
        Route::post('/delete', [Cambios_ubicaciones\Ccambios_ubicaciones::class, 'delete'])->name('cambios_ubicaciones.cambios_ubicaciones.delete');
    });
});

// Rutas para capacitacion
Route::prefix('capacitacion')->group(function () {
    // Ccapacitaciones
    Route::prefix('capacitaciones')->group(function () {
        Route::get('/', [Capacitacion\Ccapacitaciones::class, 'index'])->name('capacitacion.capacitaciones.index');
        Route::post('/getServerSide', [Capacitacion\Ccapacitaciones::class, 'getServerSide'])->name('capacitacion.capacitaciones.getServerSide');
        Route::post('/getOne', [Capacitacion\Ccapacitaciones::class, 'getOne'])->name('capacitacion.capacitaciones.getOne');
        Route::post('/add', [Capacitacion\Ccapacitaciones::class, 'add'])->name('capacitacion.capacitaciones.add');
        Route::post('/update', [Capacitacion\Ccapacitaciones::class, 'update'])->name('capacitacion.capacitaciones.update');
        Route::post('/delete', [Capacitacion\Ccapacitaciones::class, 'delete'])->name('capacitacion.capacitaciones.delete');
    });
});

// Rutas para categoria
Route::prefix('categoria')->group(function () {
    // Ccategorias
    Route::prefix('categorias')->group(function () {
        Route::get('/', [Categoria\Ccategorias::class, 'index'])->name('categoria.categorias.index');
        Route::post('/getServerSide', [Categoria\Ccategorias::class, 'getServerSide'])->name('categoria.categorias.getServerSide');
        Route::post('/getOne', [Categoria\Ccategorias::class, 'getOne'])->name('categoria.categorias.getOne');
        Route::post('/add', [Categoria\Ccategorias::class, 'add'])->name('categoria.categorias.add');
        Route::post('/update', [Categoria\Ccategorias::class, 'update'])->name('categoria.categorias.update');
        Route::post('/delete', [Categoria\Ccategorias::class, 'delete'])->name('categoria.categorias.delete');
    });
});

// Rutas para cbiomedica
Route::prefix('cbiomedica')->group(function () {
    // Ccbiomedicas
    Route::prefix('cbiomedicas')->group(function () {
        Route::get('/', [Cbiomedica\Ccbiomedicas::class, 'index'])->name('cbiomedica.cbiomedicas.index');
        Route::post('/getServerSide', [Cbiomedica\Ccbiomedicas::class, 'getServerSide'])->name('cbiomedica.cbiomedicas.getServerSide');
        Route::post('/getOne', [Cbiomedica\Ccbiomedicas::class, 'getOne'])->name('cbiomedica.cbiomedicas.getOne');
        Route::post('/add', [Cbiomedica\Ccbiomedicas::class, 'add'])->name('cbiomedica.cbiomedicas.add');
        Route::post('/update', [Cbiomedica\Ccbiomedicas::class, 'update'])->name('cbiomedica.cbiomedicas.update');
        Route::post('/delete', [Cbiomedica\Ccbiomedicas::class, 'delete'])->name('cbiomedica.cbiomedicas.delete');
    });
});

// Rutas para cierre
Route::prefix('cierre')->group(function () {
    // Ccierres
    Route::prefix('cierres')->group(function () {
        Route::get('/', [Cierre\Ccierres::class, 'index'])->name('cierre.cierres.index');
        Route::post('/getServerSide', [Cierre\Ccierres::class, 'getServerSide'])->name('cierre.cierres.getServerSide');
        Route::post('/getOne', [Cierre\Ccierres::class, 'getOne'])->name('cierre.cierres.getOne');
        Route::post('/add', [Cierre\Ccierres::class, 'add'])->name('cierre.cierres.add');
        Route::post('/update', [Cierre\Ccierres::class, 'update'])->name('cierre.cierres.update');
        Route::post('/delete', [Cierre\Ccierres::class, 'delete'])->name('cierre.cierres.delete');
    });
});

// Rutas para cliente
Route::prefix('cliente')->group(function () {
    // Cclientes
    Route::prefix('clientes')->group(function () {
        Route::get('/', [Cliente\Cclientes::class, 'index'])->name('cliente.clientes.index');
        Route::post('/getServerSide', [Cliente\Cclientes::class, 'getServerSide'])->name('cliente.clientes.getServerSide');
        Route::post('/getOne', [Cliente\Cclientes::class, 'getOne'])->name('cliente.clientes.getOne');
        Route::post('/add', [Cliente\Cclientes::class, 'add'])->name('cliente.clientes.add');
        Route::post('/update', [Cliente\Cclientes::class, 'update'])->name('cliente.clientes.update');
        Route::post('/delete', [Cliente\Cclientes::class, 'delete'])->name('cliente.clientes.delete');
    });
});

// Rutas para configuracion
Route::prefix('configuracion')->group(function () {
    // Cconfiguracion
    Route::prefix('configuracion')->group(function () {
        Route::get('/', [Configuracion\Cconfiguracion::class, 'index'])->name('configuracion.configuracion.index');
        Route::post('/getServerSide', [Configuracion\Cconfiguracion::class, 'getServerSide'])->name('configuracion.configuracion.getServerSide');
        Route::post('/getOne', [Configuracion\Cconfiguracion::class, 'getOne'])->name('configuracion.configuracion.getOne');
        Route::post('/add', [Configuracion\Cconfiguracion::class, 'add'])->name('configuracion.configuracion.add');
        Route::post('/update', [Configuracion\Cconfiguracion::class, 'update'])->name('configuracion.configuracion.update');
        Route::post('/delete', [Configuracion\Cconfiguracion::class, 'delete'])->name('configuracion.configuracion.delete');
    });

    // Cconfiguracion_email
    Route::prefix('configuracion_email')->group(function () {
        Route::get('/', [Configuracion\Cconfiguracion_email::class, 'index'])->name('configuracion.configuracion_email.index');
        Route::post('/getServerSide', [Configuracion\Cconfiguracion_email::class, 'getServerSide'])->name('configuracion.configuracion_email.getServerSide');
        Route::post('/getOne', [Configuracion\Cconfiguracion_email::class, 'getOne'])->name('configuracion.configuracion_email.getOne');
        Route::post('/add', [Configuracion\Cconfiguracion_email::class, 'add'])->name('configuracion.configuracion_email.add');
        Route::post('/update', [Configuracion\Cconfiguracion_email::class, 'update'])->name('configuracion.configuracion_email.update');
        Route::post('/delete', [Configuracion\Cconfiguracion_email::class, 'delete'])->name('configuracion.configuracion_email.delete');
    });

    // Cconfiguracion_sistema
    Route::prefix('configuracion_sistema')->group(function () {
        Route::get('/', [Configuracion\Cconfiguracion_sistema::class, 'index'])->name('configuracion.configuracion_sistema.index');
        Route::post('/getServerSide', [Configuracion\Cconfiguracion_sistema::class, 'getServerSide'])->name('configuracion.configuracion_sistema.getServerSide');
        Route::post('/getOne', [Configuracion\Cconfiguracion_sistema::class, 'getOne'])->name('configuracion.configuracion_sistema.getOne');
        Route::post('/add', [Configuracion\Cconfiguracion_sistema::class, 'add'])->name('configuracion.configuracion_sistema.add');
        Route::post('/update', [Configuracion\Cconfiguracion_sistema::class, 'update'])->name('configuracion.configuracion_sistema.update');
        Route::post('/delete', [Configuracion\Cconfiguracion_sistema::class, 'delete'])->name('configuracion.configuracion_sistema.delete');
    });
});

// Rutas para contacto
Route::prefix('contacto')->group(function () {
    // Ccontactos
    Route::prefix('contactos')->group(function () {
        Route::get('/', [Contacto\Ccontactos::class, 'index'])->name('contacto.contactos.index');
        Route::post('/getServerSide', [Contacto\Ccontactos::class, 'getServerSide'])->name('contacto.contactos.getServerSide');
        Route::post('/getOne', [Contacto\Ccontactos::class, 'getOne'])->name('contacto.contactos.getOne');
        Route::post('/add', [Contacto\Ccontactos::class, 'add'])->name('contacto.contactos.add');
        Route::post('/update', [Contacto\Ccontactos::class, 'update'])->name('contacto.contactos.update');
        Route::post('/delete', [Contacto\Ccontactos::class, 'delete'])->name('contacto.contactos.delete');
    });
});

// Rutas para contingencia
Route::prefix('contingencia')->group(function () {
    // Ccontingencias
    Route::prefix('contingencias')->group(function () {
        Route::get('/', [Contingencia\Ccontingencias::class, 'index'])->name('contingencia.contingencias.index');
        Route::post('/getServerSide', [Contingencia\Ccontingencias::class, 'getServerSide'])->name('contingencia.contingencias.getServerSide');
        Route::post('/getOne', [Contingencia\Ccontingencias::class, 'getOne'])->name('contingencia.contingencias.getOne');
        Route::post('/add', [Contingencia\Ccontingencias::class, 'add'])->name('contingencia.contingencias.add');
        Route::post('/update', [Contingencia\Ccontingencias::class, 'update'])->name('contingencia.contingencias.update');
        Route::post('/delete', [Contingencia\Ccontingencias::class, 'delete'])->name('contingencia.contingencias.delete');
    });
});

// Rutas para correctivo
Route::prefix('correctivo')->group(function () {
    // Ccorrectivos_generales
    Route::prefix('correctivos_generales')->group(function () {
        Route::get('/', [Correctivo\Ccorrectivos_generales::class, 'index'])->name('correctivo.correctivos_generales.index');
        Route::post('/getServerSide', [Correctivo\Ccorrectivos_generales::class, 'getServerSide'])->name('correctivo.correctivos_generales.getServerSide');
        Route::post('/getOne', [Correctivo\Ccorrectivos_generales::class, 'getOne'])->name('correctivo.correctivos_generales.getOne');
        Route::post('/add', [Correctivo\Ccorrectivos_generales::class, 'add'])->name('correctivo.correctivos_generales.add');
        Route::post('/update', [Correctivo\Ccorrectivos_generales::class, 'update'])->name('correctivo.correctivos_generales.update');
        Route::post('/delete', [Correctivo\Ccorrectivos_generales::class, 'delete'])->name('correctivo.correctivos_generales.delete');
    });
});

// Rutas para correctivo_general
Route::prefix('correctivo_general')->group(function () {
    // Cavances_correctivos
    Route::prefix('avances_correctivos')->group(function () {
        Route::get('/', [Correctivo_general\Cavances_correctivos::class, 'index'])->name('correctivo_general.avances_correctivos.index');
        Route::post('/getServerSide', [Correctivo_general\Cavances_correctivos::class, 'getServerSide'])->name('correctivo_general.avances_correctivos.getServerSide');
        Route::post('/getOne', [Correctivo_general\Cavances_correctivos::class, 'getOne'])->name('correctivo_general.avances_correctivos.getOne');
        Route::post('/add', [Correctivo_general\Cavances_correctivos::class, 'add'])->name('correctivo_general.avances_correctivos.add');
        Route::post('/update', [Correctivo_general\Cavances_correctivos::class, 'update'])->name('correctivo_general.avances_correctivos.update');
        Route::post('/delete', [Correctivo_general\Cavances_correctivos::class, 'delete'])->name('correctivo_general.avances_correctivos.delete');
    });

    // Ccierres
    Route::prefix('cierres')->group(function () {
        Route::get('/', [Correctivo_general\Ccierres::class, 'index'])->name('correctivo_general.cierres.index');
        Route::post('/getServerSide', [Correctivo_general\Ccierres::class, 'getServerSide'])->name('correctivo_general.cierres.getServerSide');
        Route::post('/getOne', [Correctivo_general\Ccierres::class, 'getOne'])->name('correctivo_general.cierres.getOne');
        Route::post('/add', [Correctivo_general\Ccierres::class, 'add'])->name('correctivo_general.cierres.add');
        Route::post('/update', [Correctivo_general\Ccierres::class, 'update'])->name('correctivo_general.cierres.update');
        Route::post('/delete', [Correctivo_general\Ccierres::class, 'delete'])->name('correctivo_general.cierres.delete');
    });

    // Ccorrectivos_generales
    Route::prefix('correctivos_generales')->group(function () {
        Route::get('/', [Correctivo_general\Ccorrectivos_generales::class, 'index'])->name('correctivo_general.correctivos_generales.index');
        Route::post('/getServerSide', [Correctivo_general\Ccorrectivos_generales::class, 'getServerSide'])->name('correctivo_general.correctivos_generales.getServerSide');
        Route::post('/getOne', [Correctivo_general\Ccorrectivos_generales::class, 'getOne'])->name('correctivo_general.correctivos_generales.getOne');
        Route::post('/add', [Correctivo_general\Ccorrectivos_generales::class, 'add'])->name('correctivo_general.correctivos_generales.add');
        Route::post('/update', [Correctivo_general\Ccorrectivos_generales::class, 'update'])->name('correctivo_general.correctivos_generales.update');
        Route::post('/delete', [Correctivo_general\Ccorrectivos_generales::class, 'delete'])->name('correctivo_general.correctivos_generales.delete');
    });

    // Ctipos_fallas
    Route::prefix('tipos_fallas')->group(function () {
        Route::get('/', [Correctivo_general\Ctipos_fallas::class, 'index'])->name('correctivo_general.tipos_fallas.index');
        Route::post('/getServerSide', [Correctivo_general\Ctipos_fallas::class, 'getServerSide'])->name('correctivo_general.tipos_fallas.getServerSide');
        Route::post('/getOne', [Correctivo_general\Ctipos_fallas::class, 'getOne'])->name('correctivo_general.tipos_fallas.getOne');
        Route::post('/add', [Correctivo_general\Ctipos_fallas::class, 'add'])->name('correctivo_general.tipos_fallas.add');
        Route::post('/update', [Correctivo_general\Ctipos_fallas::class, 'update'])->name('correctivo_general.tipos_fallas.update');
        Route::post('/delete', [Correctivo_general\Ctipos_fallas::class, 'delete'])->name('correctivo_general.tipos_fallas.delete');
    });
});

// Rutas para dashboard
Route::prefix('dashboard')->group(function () {
    // Cdashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [Dashboard\Cdashboard::class, 'index'])->name('dashboard.dashboard.index');
        Route::post('/getServerSide', [Dashboard\Cdashboard::class, 'getServerSide'])->name('dashboard.dashboard.getServerSide');
        Route::post('/getOne', [Dashboard\Cdashboard::class, 'getOne'])->name('dashboard.dashboard.getOne');
        Route::post('/add', [Dashboard\Cdashboard::class, 'add'])->name('dashboard.dashboard.add');
        Route::post('/update', [Dashboard\Cdashboard::class, 'update'])->name('dashboard.dashboard.update');
        Route::post('/delete', [Dashboard\Cdashboard::class, 'delete'])->name('dashboard.dashboard.delete');
    });

    // Cdashboard_ejecutivo
    Route::prefix('dashboard_ejecutivo')->group(function () {
        Route::get('/', [Dashboard\Cdashboard_ejecutivo::class, 'index'])->name('dashboard.dashboard_ejecutivo.index');
        Route::post('/getServerSide', [Dashboard\Cdashboard_ejecutivo::class, 'getServerSide'])->name('dashboard.dashboard_ejecutivo.getServerSide');
        Route::post('/getOne', [Dashboard\Cdashboard_ejecutivo::class, 'getOne'])->name('dashboard.dashboard_ejecutivo.getOne');
        Route::post('/add', [Dashboard\Cdashboard_ejecutivo::class, 'add'])->name('dashboard.dashboard_ejecutivo.add');
        Route::post('/update', [Dashboard\Cdashboard_ejecutivo::class, 'update'])->name('dashboard.dashboard_ejecutivo.update');
        Route::post('/delete', [Dashboard\Cdashboard_ejecutivo::class, 'delete'])->name('dashboard.dashboard_ejecutivo.delete');
    });

    // Cdashboard_operativo
    Route::prefix('dashboard_operativo')->group(function () {
        Route::get('/', [Dashboard\Cdashboard_operativo::class, 'index'])->name('dashboard.dashboard_operativo.index');
        Route::post('/getServerSide', [Dashboard\Cdashboard_operativo::class, 'getServerSide'])->name('dashboard.dashboard_operativo.getServerSide');
        Route::post('/getOne', [Dashboard\Cdashboard_operativo::class, 'getOne'])->name('dashboard.dashboard_operativo.getOne');
        Route::post('/add', [Dashboard\Cdashboard_operativo::class, 'add'])->name('dashboard.dashboard_operativo.add');
        Route::post('/update', [Dashboard\Cdashboard_operativo::class, 'update'])->name('dashboard.dashboard_operativo.update');
        Route::post('/delete', [Dashboard\Cdashboard_operativo::class, 'delete'])->name('dashboard.dashboard_operativo.delete');
    });
});

// Rutas para diagnostico
Route::prefix('diagnostico')->group(function () {
    // Cdiagnosticos
    Route::prefix('diagnosticos')->group(function () {
        Route::get('/', [Diagnostico\Cdiagnosticos::class, 'index'])->name('diagnostico.diagnosticos.index');
        Route::post('/getServerSide', [Diagnostico\Cdiagnosticos::class, 'getServerSide'])->name('diagnostico.diagnosticos.getServerSide');
        Route::post('/getOne', [Diagnostico\Cdiagnosticos::class, 'getOne'])->name('diagnostico.diagnosticos.getOne');
        Route::post('/add', [Diagnostico\Cdiagnosticos::class, 'add'])->name('diagnostico.diagnosticos.add');
        Route::post('/update', [Diagnostico\Cdiagnosticos::class, 'update'])->name('diagnostico.diagnosticos.update');
        Route::post('/delete', [Diagnostico\Cdiagnosticos::class, 'delete'])->name('diagnostico.diagnosticos.delete');
    });
});

// Rutas para equipo
Route::prefix('equipo')->group(function () {
    // Cbajas
    Route::prefix('bajas')->group(function () {
        Route::get('/', [Equipo\Cbajas::class, 'index'])->name('equipo.bajas.index');
        Route::post('/getServerSide', [Equipo\Cbajas::class, 'getServerSide'])->name('equipo.bajas.getServerSide');
        Route::post('/getOne', [Equipo\Cbajas::class, 'getOne'])->name('equipo.bajas.getOne');
        Route::post('/add', [Equipo\Cbajas::class, 'add'])->name('equipo.bajas.add');
        Route::post('/update', [Equipo\Cbajas::class, 'update'])->name('equipo.bajas.update');
        Route::post('/delete', [Equipo\Cbajas::class, 'delete'])->name('equipo.bajas.delete');
    });

    // Ccambios_hdv
    Route::prefix('cambios_hdv')->group(function () {
        Route::get('/', [Equipo\Ccambios_hdv::class, 'index'])->name('equipo.cambios_hdv.index');
        Route::post('/getServerSide', [Equipo\Ccambios_hdv::class, 'getServerSide'])->name('equipo.cambios_hdv.getServerSide');
        Route::post('/getOne', [Equipo\Ccambios_hdv::class, 'getOne'])->name('equipo.cambios_hdv.getOne');
        Route::post('/add', [Equipo\Ccambios_hdv::class, 'add'])->name('equipo.cambios_hdv.add');
        Route::post('/update', [Equipo\Ccambios_hdv::class, 'update'])->name('equipo.cambios_hdv.update');
        Route::post('/delete', [Equipo\Ccambios_hdv::class, 'delete'])->name('equipo.cambios_hdv.delete');
    });

    // Ccontingencias
    Route::prefix('contingencias')->group(function () {
        Route::get('/', [Equipo\Ccontingencias::class, 'index'])->name('equipo.contingencias.index');
        Route::post('/getServerSide', [Equipo\Ccontingencias::class, 'getServerSide'])->name('equipo.contingencias.getServerSide');
        Route::post('/getOne', [Equipo\Ccontingencias::class, 'getOne'])->name('equipo.contingencias.getOne');
        Route::post('/add', [Equipo\Ccontingencias::class, 'add'])->name('equipo.contingencias.add');
        Route::post('/update', [Equipo\Ccontingencias::class, 'update'])->name('equipo.contingencias.update');
        Route::post('/delete', [Equipo\Ccontingencias::class, 'delete'])->name('equipo.contingencias.delete');
    });

    // Cequipos
    Route::prefix('equipos')->group(function () {
        Route::get('/', [Equipo\Cequipos::class, 'index'])->name('equipo.equipos.index');
        Route::post('/getServerSide', [Equipo\Cequipos::class, 'getServerSide'])->name('equipo.equipos.getServerSide');
        Route::post('/getOne', [Equipo\Cequipos::class, 'getOne'])->name('equipo.equipos.getOne');
        Route::post('/add', [Equipo\Cequipos::class, 'add'])->name('equipo.equipos.add');
        Route::post('/update', [Equipo\Cequipos::class, 'update'])->name('equipo.equipos.update');
        Route::post('/delete', [Equipo\Cequipos::class, 'delete'])->name('equipo.equipos.delete');
        Route::post('/copy', [Equipo\Cequipos::class, 'copy'])->name('equipo.equipos.copy');
        Route::get('/getServicios', [Equipo\Cequipos::class, 'getServicios'])->name('equipo.equipos.getServicios');
        Route::get('/getAreas', [Equipo\Cequipos::class, 'getAreas'])->name('equipo.equipos.getAreas');
        Route::post('/uploadImage', [Equipo\Cequipos::class, 'uploadImage'])->name('equipo.equipos.uploadImage');
        Route::post('/uploadFile', [Equipo\Cequipos::class, 'uploadFile'])->name('equipo.equipos.uploadFile');
    });

    // Cinvimas
    Route::prefix('invimas')->group(function () {
        Route::get('/', [Equipo\Cinvimas::class, 'index'])->name('equipo.invimas.index');
        Route::post('/getServerSide', [Equipo\Cinvimas::class, 'getServerSide'])->name('equipo.invimas.getServerSide');
        Route::post('/getOne', [Equipo\Cinvimas::class, 'getOne'])->name('equipo.invimas.getOne');
        Route::post('/add', [Equipo\Cinvimas::class, 'add'])->name('equipo.invimas.add');
        Route::post('/update', [Equipo\Cinvimas::class, 'update'])->name('equipo.invimas.update');
        Route::post('/delete', [Equipo\Cinvimas::class, 'delete'])->name('equipo.invimas.delete');
    });
});

// Rutas para equipos_ind
Route::prefix('equipos_ind')->group(function () {
    // Cequipos_ind
    Route::prefix('equipos_ind')->group(function () {
        Route::get('¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente.');