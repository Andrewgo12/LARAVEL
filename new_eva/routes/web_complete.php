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
        Route::get('/', [Equipos_ind\Cequipos_ind::class, 'index'])->name('equipos_ind.equipos_ind.index');
        Route::post('/getServerSide', [Equipos_ind\Cequipos_ind::class, 'getServerSide'])->name('equipos_ind.equipos_ind.getServerSide');
        Route::post('/getOne', [Equipos_ind\Cequipos_ind::class, 'getOne'])->name('equipos_ind.equipos_ind.getOne');
        Route::post('/add', [Equipos_ind\Cequipos_ind::class, 'add'])->name('equipos_ind.equipos_ind.add');
        Route::post('/update', [Equipos_ind\Cequipos_ind::class, 'update'])->name('equipos_ind.equipos_ind.update');
        Route::post('/delete', [Equipos_ind\Cequipos_ind::class, 'delete'])->name('equipos_ind.equipos_ind.delete');
        Route::post('/copy', [Equipos_ind\Cequipos_ind::class, 'copy'])->name('equipos_ind.equipos_ind.copy');
        Route::get('/getServicios', [Equipos_ind\Cequipos_ind::class, 'getServicios'])->name('equipos_ind.equipos_ind.getServicios');
        Route::get('/getAreas', [Equipos_ind\Cequipos_ind::class, 'getAreas'])->name('equipos_ind.equipos_ind.getAreas');
        Route::post('/uploadImage', [Equipos_ind\Cequipos_ind::class, 'uploadImage'])->name('equipos_ind.equipos_ind.uploadImage');
        Route::post('/uploadFile', [Equipos_ind\Cequipos_ind::class, 'uploadFile'])->name('equipos_ind.equipos_ind.uploadFile');
    });

});

// Rutas para especificacion
Route::prefix('especificacion')->group(function () {
    // Cespecificaciones
    Route::prefix('especificaciones')->group(function () {
        Route::get('/', [Especificacion\Cespecificaciones::class, 'index'])->name('especificacion.especificaciones.index');
        Route::post('/getServerSide', [Especificacion\Cespecificaciones::class, 'getServerSide'])->name('especificacion.especificaciones.getServerSide');
        Route::post('/getOne', [Especificacion\Cespecificaciones::class, 'getOne'])->name('especificacion.especificaciones.getOne');
        Route::post('/add', [Especificacion\Cespecificaciones::class, 'add'])->name('especificacion.especificaciones.add');
        Route::post('/update', [Especificacion\Cespecificaciones::class, 'update'])->name('especificacion.especificaciones.update');
        Route::post('/delete', [Especificacion\Cespecificaciones::class, 'delete'])->name('especificacion.especificaciones.delete');
    });

});

// Rutas para estadistica
Route::prefix('estadistica')->group(function () {
    // Cestadisticas
    Route::prefix('estadisticas')->group(function () {
        Route::get('/', [Estadistica\Cestadisticas::class, 'index'])->name('estadistica.estadisticas.index');
        Route::post('/getServerSide', [Estadistica\Cestadisticas::class, 'getServerSide'])->name('estadistica.estadisticas.getServerSide');
        Route::post('/getOne', [Estadistica\Cestadisticas::class, 'getOne'])->name('estadistica.estadisticas.getOne');
        Route::post('/add', [Estadistica\Cestadisticas::class, 'add'])->name('estadistica.estadisticas.add');
        Route::post('/update', [Estadistica\Cestadisticas::class, 'update'])->name('estadistica.estadisticas.update');
        Route::post('/delete', [Estadistica\Cestadisticas::class, 'delete'])->name('estadistica.estadisticas.delete');
    });

    // Cestadisticas_equipos
    Route::prefix('estadisticas_equipos')->group(function () {
        Route::get('/', [Estadistica\Cestadisticas_equipos::class, 'index'])->name('estadistica.estadisticas_equipos.index');
        Route::post('/getServerSide', [Estadistica\Cestadisticas_equipos::class, 'getServerSide'])->name('estadistica.estadisticas_equipos.getServerSide');
        Route::post('/getOne', [Estadistica\Cestadisticas_equipos::class, 'getOne'])->name('estadistica.estadisticas_equipos.getOne');
        Route::post('/add', [Estadistica\Cestadisticas_equipos::class, 'add'])->name('estadistica.estadisticas_equipos.add');
        Route::post('/update', [Estadistica\Cestadisticas_equipos::class, 'update'])->name('estadistica.estadisticas_equipos.update');
        Route::post('/delete', [Estadistica\Cestadisticas_equipos::class, 'delete'])->name('estadistica.estadisticas_equipos.delete');
        Route::post('/copy', [Estadistica\Cestadisticas_equipos::class, 'copy'])->name('estadistica.estadisticas_equipos.copy');
        Route::get('/getServicios', [Estadistica\Cestadisticas_equipos::class, 'getServicios'])->name('estadistica.estadisticas_equipos.getServicios');
        Route::get('/getAreas', [Estadistica\Cestadisticas_equipos::class, 'getAreas'])->name('estadistica.estadisticas_equipos.getAreas');
        Route::post('/uploadImage', [Estadistica\Cestadisticas_equipos::class, 'uploadImage'])->name('estadistica.estadisticas_equipos.uploadImage');
        Route::post('/uploadFile', [Estadistica\Cestadisticas_equipos::class, 'uploadFile'])->name('estadistica.estadisticas_equipos.uploadFile');
    });

    // Cestadisticas_mantenimientos
    Route::prefix('estadisticas_mantenimientos')->group(function () {
        Route::get('/', [Estadistica\Cestadisticas_mantenimientos::class, 'index'])->name('estadistica.estadisticas_mantenimientos.index');
        Route::post('/getServerSide', [Estadistica\Cestadisticas_mantenimientos::class, 'getServerSide'])->name('estadistica.estadisticas_mantenimientos.getServerSide');
        Route::post('/getOne', [Estadistica\Cestadisticas_mantenimientos::class, 'getOne'])->name('estadistica.estadisticas_mantenimientos.getOne');
        Route::post('/add', [Estadistica\Cestadisticas_mantenimientos::class, 'add'])->name('estadistica.estadisticas_mantenimientos.add');
        Route::post('/update', [Estadistica\Cestadisticas_mantenimientos::class, 'update'])->name('estadistica.estadisticas_mantenimientos.update');
        Route::post('/delete', [Estadistica\Cestadisticas_mantenimientos::class, 'delete'])->name('estadistica.estadisticas_mantenimientos.delete');
    });

});

// Rutas para estado
Route::prefix('estado')->group(function () {
    // Cestados
    Route::prefix('estados')->group(function () {
        Route::get('/', [Estado\Cestados::class, 'index'])->name('estado.estados.index');
        Route::post('/getServerSide', [Estado\Cestados::class, 'getServerSide'])->name('estado.estados.getServerSide');
        Route::post('/getOne', [Estado\Cestados::class, 'getOne'])->name('estado.estados.getOne');
        Route::post('/add', [Estado\Cestados::class, 'add'])->name('estado.estados.add');
        Route::post('/update', [Estado\Cestados::class, 'update'])->name('estado.estados.update');
        Route::post('/delete', [Estado\Cestados::class, 'delete'])->name('estado.estados.delete');
    });

});

// Rutas para frecuencia
Route::prefix('frecuencia')->group(function () {
    // Cfrecuencias
    Route::prefix('frecuencias')->group(function () {
        Route::get('/', [Frecuencia\Cfrecuencias::class, 'index'])->name('frecuencia.frecuencias.index');
        Route::post('/getServerSide', [Frecuencia\Cfrecuencias::class, 'getServerSide'])->name('frecuencia.frecuencias.getServerSide');
        Route::post('/getOne', [Frecuencia\Cfrecuencias::class, 'getOne'])->name('frecuencia.frecuencias.getOne');
        Route::post('/add', [Frecuencia\Cfrecuencias::class, 'add'])->name('frecuencia.frecuencias.add');
        Route::post('/update', [Frecuencia\Cfrecuencias::class, 'update'])->name('frecuencia.frecuencias.update');
        Route::post('/delete', [Frecuencia\Cfrecuencias::class, 'delete'])->name('frecuencia.frecuencias.delete');
    });

});

// Rutas para fuente
Route::prefix('fuente')->group(function () {
    // Cfuentes
    Route::prefix('fuentes')->group(function () {
        Route::get('/', [Fuente\Cfuentes::class, 'index'])->name('fuente.fuentes.index');
        Route::post('/getServerSide', [Fuente\Cfuentes::class, 'getServerSide'])->name('fuente.fuentes.getServerSide');
        Route::post('/getOne', [Fuente\Cfuentes::class, 'getOne'])->name('fuente.fuentes.getOne');
        Route::post('/add', [Fuente\Cfuentes::class, 'add'])->name('fuente.fuentes.add');
        Route::post('/update', [Fuente\Cfuentes::class, 'update'])->name('fuente.fuentes.update');
        Route::post('/delete', [Fuente\Cfuentes::class, 'delete'])->name('fuente.fuentes.delete');
    });

});

// Rutas para guia
Route::prefix('guia')->group(function () {
    // Cguias
    Route::prefix('guias')->group(function () {
        Route::get('/', [Guia\Cguias::class, 'index'])->name('guia.guias.index');
        Route::post('/getServerSide', [Guia\Cguias::class, 'getServerSide'])->name('guia.guias.getServerSide');
        Route::post('/getOne', [Guia\Cguias::class, 'getOne'])->name('guia.guias.getOne');
        Route::post('/add', [Guia\Cguias::class, 'add'])->name('guia.guias.add');
        Route::post('/update', [Guia\Cguias::class, 'update'])->name('guia.guias.update');
        Route::post('/delete', [Guia\Cguias::class, 'delete'])->name('guia.guias.delete');
    });

});

// Rutas para integracion
Route::prefix('integracion')->group(function () {
    // Cintegracion
    Route::prefix('integracion')->group(function () {
        Route::get('/', [Integracion\Cintegracion::class, 'index'])->name('integracion.integracion.index');
        Route::post('/getServerSide', [Integracion\Cintegracion::class, 'getServerSide'])->name('integracion.integracion.getServerSide');
        Route::post('/getOne', [Integracion\Cintegracion::class, 'getOne'])->name('integracion.integracion.getOne');
        Route::post('/add', [Integracion\Cintegracion::class, 'add'])->name('integracion.integracion.add');
        Route::post('/update', [Integracion\Cintegracion::class, 'update'])->name('integracion.integracion.update');
        Route::post('/delete', [Integracion\Cintegracion::class, 'delete'])->name('integracion.integracion.delete');
    });

    // Cintegracion_cmms
    Route::prefix('integracion_cmms')->group(function () {
        Route::get('/', [Integracion\Cintegracion_cmms::class, 'index'])->name('integracion.integracion_cmms.index');
        Route::post('/getServerSide', [Integracion\Cintegracion_cmms::class, 'getServerSide'])->name('integracion.integracion_cmms.getServerSide');
        Route::post('/getOne', [Integracion\Cintegracion_cmms::class, 'getOne'])->name('integracion.integracion_cmms.getOne');
        Route::post('/add', [Integracion\Cintegracion_cmms::class, 'add'])->name('integracion.integracion_cmms.add');
        Route::post('/update', [Integracion\Cintegracion_cmms::class, 'update'])->name('integracion.integracion_cmms.update');
        Route::post('/delete', [Integracion\Cintegracion_cmms::class, 'delete'])->name('integracion.integracion_cmms.delete');
    });

    // Cintegracion_erp
    Route::prefix('integracion_erp')->group(function () {
        Route::get('/', [Integracion\Cintegracion_erp::class, 'index'])->name('integracion.integracion_erp.index');
        Route::post('/getServerSide', [Integracion\Cintegracion_erp::class, 'getServerSide'])->name('integracion.integracion_erp.getServerSide');
        Route::post('/getOne', [Integracion\Cintegracion_erp::class, 'getOne'])->name('integracion.integracion_erp.getOne');
        Route::post('/add', [Integracion\Cintegracion_erp::class, 'add'])->name('integracion.integracion_erp.add');
        Route::post('/update', [Integracion\Cintegracion_erp::class, 'update'])->name('integracion.integracion_erp.update');
        Route::post('/delete', [Integracion\Cintegracion_erp::class, 'delete'])->name('integracion.integracion_erp.delete');
    });

});

// Rutas para invima
Route::prefix('invima')->group(function () {
    // Cinvimas
    Route::prefix('invimas')->group(function () {
        Route::get('/', [Invima\Cinvimas::class, 'index'])->name('invima.invimas.index');
        Route::post('/getServerSide', [Invima\Cinvimas::class, 'getServerSide'])->name('invima.invimas.getServerSide');
        Route::post('/getOne', [Invima\Cinvimas::class, 'getOne'])->name('invima.invimas.getOne');
        Route::post('/add', [Invima\Cinvimas::class, 'add'])->name('invima.invimas.add');
        Route::post('/update', [Invima\Cinvimas::class, 'update'])->name('invima.invimas.update');
        Route::post('/delete', [Invima\Cinvimas::class, 'delete'])->name('invima.invimas.delete');
    });

});

// Rutas para mantenimiento
Route::prefix('mantenimiento')->group(function () {
    // Ccategorias
    Route::prefix('categorias')->group(function () {
        Route::get('/', [Mantenimiento\Ccategorias::class, 'index'])->name('mantenimiento.categorias.index');
        Route::post('/getServerSide', [Mantenimiento\Ccategorias::class, 'getServerSide'])->name('mantenimiento.categorias.getServerSide');
        Route::post('/getOne', [Mantenimiento\Ccategorias::class, 'getOne'])->name('mantenimiento.categorias.getOne');
        Route::post('/add', [Mantenimiento\Ccategorias::class, 'add'])->name('mantenimiento.categorias.add');
        Route::post('/update', [Mantenimiento\Ccategorias::class, 'update'])->name('mantenimiento.categorias.update');
        Route::post('/delete', [Mantenimiento\Ccategorias::class, 'delete'])->name('mantenimiento.categorias.delete');
    });

    // Cclientes
    Route::prefix('clientes')->group(function () {
        Route::get('/', [Mantenimiento\Cclientes::class, 'index'])->name('mantenimiento.clientes.index');
        Route::post('/getServerSide', [Mantenimiento\Cclientes::class, 'getServerSide'])->name('mantenimiento.clientes.getServerSide');
        Route::post('/getOne', [Mantenimiento\Cclientes::class, 'getOne'])->name('mantenimiento.clientes.getOne');
        Route::post('/add', [Mantenimiento\Cclientes::class, 'add'])->name('mantenimiento.clientes.add');
        Route::post('/update', [Mantenimiento\Cclientes::class, 'update'])->name('mantenimiento.clientes.update');
        Route::post('/delete', [Mantenimiento\Cclientes::class, 'delete'])->name('mantenimiento.clientes.delete');
    });

    // Cplanes
    Route::prefix('planes')->group(function () {
        Route::get('/', [Mantenimiento\Cplanes::class, 'index'])->name('mantenimiento.planes.index');
        Route::post('/getServerSide', [Mantenimiento\Cplanes::class, 'getServerSide'])->name('mantenimiento.planes.getServerSide');
        Route::post('/getOne', [Mantenimiento\Cplanes::class, 'getOne'])->name('mantenimiento.planes.getOne');
        Route::post('/add', [Mantenimiento\Cplanes::class, 'add'])->name('mantenimiento.planes.add');
        Route::post('/update', [Mantenimiento\Cplanes::class, 'update'])->name('mantenimiento.planes.update');
        Route::post('/delete', [Mantenimiento\Cplanes::class, 'delete'])->name('mantenimiento.planes.delete');
    });

    // Cproveedores_mantenimiento
    Route::prefix('proveedores_mantenimiento')->group(function () {
        Route::get('/', [Mantenimiento\Cproveedores_mantenimiento::class, 'index'])->name('mantenimiento.proveedores_mantenimiento.index');
        Route::post('/getServerSide', [Mantenimiento\Cproveedores_mantenimiento::class, 'getServerSide'])->name('mantenimiento.proveedores_mantenimiento.getServerSide');
        Route::post('/getOne', [Mantenimiento\Cproveedores_mantenimiento::class, 'getOne'])->name('mantenimiento.proveedores_mantenimiento.getOne');
        Route::post('/add', [Mantenimiento\Cproveedores_mantenimiento::class, 'add'])->name('mantenimiento.proveedores_mantenimiento.add');
        Route::post('/update', [Mantenimiento\Cproveedores_mantenimiento::class, 'update'])->name('mantenimiento.proveedores_mantenimiento.update');
        Route::post('/delete', [Mantenimiento\Cproveedores_mantenimiento::class, 'delete'])->name('mantenimiento.proveedores_mantenimiento.delete');
    });

});

// Rutas para manual
Route::prefix('manual')->group(function () {
    // Cmanuales
    Route::prefix('manuales')->group(function () {
        Route::get('/', [Manual\Cmanuales::class, 'index'])->name('manual.manuales.index');
        Route::post('/getServerSide', [Manual\Cmanuales::class, 'getServerSide'])->name('manual.manuales.getServerSide');
        Route::post('/getOne', [Manual\Cmanuales::class, 'getOne'])->name('manual.manuales.getOne');
        Route::post('/add', [Manual\Cmanuales::class, 'add'])->name('manual.manuales.add');
        Route::post('/update', [Manual\Cmanuales::class, 'update'])->name('manual.manuales.update');
        Route::post('/delete', [Manual\Cmanuales::class, 'delete'])->name('manual.manuales.delete');
    });

});

// Rutas para mobile
Route::prefix('mobile')->group(function () {
    // Cmobile
    Route::prefix('mobile')->group(function () {
        Route::get('/', [Mobile\Cmobile::class, 'index'])->name('mobile.mobile.index');
        Route::post('/getServerSide', [Mobile\Cmobile::class, 'getServerSide'])->name('mobile.mobile.getServerSide');
        Route::post('/getOne', [Mobile\Cmobile::class, 'getOne'])->name('mobile.mobile.getOne');
        Route::post('/add', [Mobile\Cmobile::class, 'add'])->name('mobile.mobile.add');
        Route::post('/update', [Mobile\Cmobile::class, 'update'])->name('mobile.mobile.update');
        Route::post('/delete', [Mobile\Cmobile::class, 'delete'])->name('mobile.mobile.delete');
    });

    // Cmobile_equipos
    Route::prefix('mobile_equipos')->group(function () {
        Route::get('/', [Mobile\Cmobile_equipos::class, 'index'])->name('mobile.mobile_equipos.index');
        Route::post('/getServerSide', [Mobile\Cmobile_equipos::class, 'getServerSide'])->name('mobile.mobile_equipos.getServerSide');
        Route::post('/getOne', [Mobile\Cmobile_equipos::class, 'getOne'])->name('mobile.mobile_equipos.getOne');
        Route::post('/add', [Mobile\Cmobile_equipos::class, 'add'])->name('mobile.mobile_equipos.add');
        Route::post('/update', [Mobile\Cmobile_equipos::class, 'update'])->name('mobile.mobile_equipos.update');
        Route::post('/delete', [Mobile\Cmobile_equipos::class, 'delete'])->name('mobile.mobile_equipos.delete');
        Route::post('/copy', [Mobile\Cmobile_equipos::class, 'copy'])->name('mobile.mobile_equipos.copy');
        Route::get('/getServicios', [Mobile\Cmobile_equipos::class, 'getServicios'])->name('mobile.mobile_equipos.getServicios');
        Route::get('/getAreas', [Mobile\Cmobile_equipos::class, 'getAreas'])->name('mobile.mobile_equipos.getAreas');
        Route::post('/uploadImage', [Mobile\Cmobile_equipos::class, 'uploadImage'])->name('mobile.mobile_equipos.uploadImage');
        Route::post('/uploadFile', [Mobile\Cmobile_equipos::class, 'uploadFile'])->name('mobile.mobile_equipos.uploadFile');
    });

    // Cmobile_ordenes
    Route::prefix('mobile_ordenes')->group(function () {
        Route::get('/', [Mobile\Cmobile_ordenes::class, 'index'])->name('mobile.mobile_ordenes.index');
        Route::post('/getServerSide', [Mobile\Cmobile_ordenes::class, 'getServerSide'])->name('mobile.mobile_ordenes.getServerSide');
        Route::post('/getOne', [Mobile\Cmobile_ordenes::class, 'getOne'])->name('mobile.mobile_ordenes.getOne');
        Route::post('/add', [Mobile\Cmobile_ordenes::class, 'add'])->name('mobile.mobile_ordenes.add');
        Route::post('/update', [Mobile\Cmobile_ordenes::class, 'update'])->name('mobile.mobile_ordenes.update');
        Route::post('/delete', [Mobile\Cmobile_ordenes::class, 'delete'])->name('mobile.mobile_ordenes.delete');
        Route::get('/listActive', [Mobile\Cmobile_ordenes::class, 'listActive'])->name('mobile.mobile_ordenes.listActive');
        Route::get('/listClosed', [Mobile\Cmobile_ordenes::class, 'listClosed'])->name('mobile.mobile_ordenes.listClosed');
        Route::post('/asignarTecnico', [Mobile\Cmobile_ordenes::class, 'asignarTecnico'])->name('mobile.mobile_ordenes.asignarTecnico');
        Route::post('/cerrarOrden', [Mobile\Cmobile_ordenes::class, 'cerrarOrden'])->name('mobile.mobile_ordenes.cerrarOrden');
    });

});

// Rutas para modulo
Route::prefix('modulo')->group(function () {
    // Cmodulos
    Route::prefix('modulos')->group(function () {
        Route::get('/', [Modulo\Cmodulos::class, 'index'])->name('modulo.modulos.index');
        Route::post('/getServerSide', [Modulo\Cmodulos::class, 'getServerSide'])->name('modulo.modulos.getServerSide');
        Route::post('/getOne', [Modulo\Cmodulos::class, 'getOne'])->name('modulo.modulos.getOne');
        Route::post('/add', [Modulo\Cmodulos::class, 'add'])->name('modulo.modulos.add');
        Route::post('/update', [Modulo\Cmodulos::class, 'update'])->name('modulo.modulos.update');
        Route::post('/delete', [Modulo\Cmodulos::class, 'delete'])->name('modulo.modulos.delete');
    });

});

// Rutas para movimiento
Route::prefix('movimiento')->group(function () {
    // Cmovimientos
    Route::prefix('movimientos')->group(function () {
        Route::get('/', [Movimiento\Cmovimientos::class, 'index'])->name('movimiento.movimientos.index');
        Route::post('/getServerSide', [Movimiento\Cmovimientos::class, 'getServerSide'])->name('movimiento.movimientos.getServerSide');
        Route::post('/getOne', [Movimiento\Cmovimientos::class, 'getOne'])->name('movimiento.movimientos.getOne');
        Route::post('/add', [Movimiento\Cmovimientos::class, 'add'])->name('movimiento.movimientos.add');
        Route::post('/update', [Movimiento\Cmovimientos::class, 'update'])->name('movimiento.movimientos.update');
        Route::post('/delete', [Movimiento\Cmovimientos::class, 'delete'])->name('movimiento.movimientos.delete');
    });

});

// Rutas para notificacion
Route::prefix('notificacion')->group(function () {
    // Cnotificaciones
    Route::prefix('notificaciones')->group(function () {
        Route::get('/', [Notificacion\Cnotificaciones::class, 'index'])->name('notificacion.notificaciones.index');
        Route::post('/getServerSide', [Notificacion\Cnotificaciones::class, 'getServerSide'])->name('notificacion.notificaciones.getServerSide');
        Route::post('/getOne', [Notificacion\Cnotificaciones::class, 'getOne'])->name('notificacion.notificaciones.getOne');
        Route::post('/add', [Notificacion\Cnotificaciones::class, 'add'])->name('notificacion.notificaciones.add');
        Route::post('/update', [Notificacion\Cnotificaciones::class, 'update'])->name('notificacion.notificaciones.update');
        Route::post('/delete', [Notificacion\Cnotificaciones::class, 'delete'])->name('notificacion.notificaciones.delete');
    });

    // Cnotificaciones_email
    Route::prefix('notificaciones_email')->group(function () {
        Route::get('/', [Notificacion\Cnotificaciones_email::class, 'index'])->name('notificacion.notificaciones_email.index');
        Route::post('/getServerSide', [Notificacion\Cnotificaciones_email::class, 'getServerSide'])->name('notificacion.notificaciones_email.getServerSide');
        Route::post('/getOne', [Notificacion\Cnotificaciones_email::class, 'getOne'])->name('notificacion.notificaciones_email.getOne');
        Route::post('/add', [Notificacion\Cnotificaciones_email::class, 'add'])->name('notificacion.notificaciones_email.add');
        Route::post('/update', [Notificacion\Cnotificaciones_email::class, 'update'])->name('notificacion.notificaciones_email.update');
        Route::post('/delete', [Notificacion\Cnotificaciones_email::class, 'delete'])->name('notificacion.notificaciones_email.delete');
    });

    // Cnotificaciones_sms
    Route::prefix('notificaciones_sms')->group(function () {
        Route::get('/', [Notificacion\Cnotificaciones_sms::class, 'index'])->name('notificacion.notificaciones_sms.index');
        Route::post('/getServerSide', [Notificacion\Cnotificaciones_sms::class, 'getServerSide'])->name('notificacion.notificaciones_sms.getServerSide');
        Route::post('/getOne', [Notificacion\Cnotificaciones_sms::class, 'getOne'])->name('notificacion.notificaciones_sms.getOne');
        Route::post('/add', [Notificacion\Cnotificaciones_sms::class, 'add'])->name('notificacion.notificaciones_sms.add');
        Route::post('/update', [Notificacion\Cnotificaciones_sms::class, 'update'])->name('notificacion.notificaciones_sms.update');
        Route::post('/delete', [Notificacion\Cnotificaciones_sms::class, 'delete'])->name('notificacion.notificaciones_sms.delete');
    });

});

// Rutas para observacion
Route::prefix('observacion')->group(function () {
    // Cobservaciones
    Route::prefix('observaciones')->group(function () {
        Route::get('/', [Observacion\Cobservaciones::class, 'index'])->name('observacion.observaciones.index');
        Route::post('/getServerSide', [Observacion\Cobservaciones::class, 'getServerSide'])->name('observacion.observaciones.getServerSide');
        Route::post('/getOne', [Observacion\Cobservaciones::class, 'getOne'])->name('observacion.observaciones.getOne');
        Route::post('/add', [Observacion\Cobservaciones::class, 'add'])->name('observacion.observaciones.add');
        Route::post('/update', [Observacion\Cobservaciones::class, 'update'])->name('observacion.observaciones.update');
        Route::post('/delete', [Observacion\Cobservaciones::class, 'delete'])->name('observacion.observaciones.delete');
    });

});

// Rutas para orden
Route::prefix('orden')->group(function () {
    // Cestados
    Route::prefix('estados')->group(function () {
        Route::get('/', [Orden\Cestados::class, 'index'])->name('orden.estados.index');
        Route::post('/getServerSide', [Orden\Cestados::class, 'getServerSide'])->name('orden.estados.getServerSide');
        Route::post('/getOne', [Orden\Cestados::class, 'getOne'])->name('orden.estados.getOne');
        Route::post('/add', [Orden\Cestados::class, 'add'])->name('orden.estados.add');
        Route::post('/update', [Orden\Cestados::class, 'update'])->name('orden.estados.update');
        Route::post('/delete', [Orden\Cestados::class, 'delete'])->name('orden.estados.delete');
    });

    // Cordenes
    Route::prefix('ordenes')->group(function () {
        Route::get('/', [Orden\Cordenes::class, 'index'])->name('orden.ordenes.index');
        Route::post('/getServerSide', [Orden\Cordenes::class, 'getServerSide'])->name('orden.ordenes.getServerSide');
        Route::post('/getOne', [Orden\Cordenes::class, 'getOne'])->name('orden.ordenes.getOne');
        Route::post('/add', [Orden\Cordenes::class, 'add'])->name('orden.ordenes.add');
        Route::post('/update', [Orden\Cordenes::class, 'update'])->name('orden.ordenes.update');
        Route::post('/delete', [Orden\Cordenes::class, 'delete'])->name('orden.ordenes.delete');
        Route::get('/listActive', [Orden\Cordenes::class, 'listActive'])->name('orden.ordenes.listActive');
        Route::get('/listClosed', [Orden\Cordenes::class, 'listClosed'])->name('orden.ordenes.listClosed');
        Route::post('/asignarTecnico', [Orden\Cordenes::class, 'asignarTecnico'])->name('orden.ordenes.asignarTecnico');
        Route::post('/cerrarOrden', [Orden\Cordenes::class, 'cerrarOrden'])->name('orden.ordenes.cerrarOrden');
    });

    // Ctrabajos
    Route::prefix('trabajos')->group(function () {
        Route::get('/', [Orden\Ctrabajos::class, 'index'])->name('orden.trabajos.index');
        Route::post('/getServerSide', [Orden\Ctrabajos::class, 'getServerSide'])->name('orden.trabajos.getServerSide');
        Route::post('/getOne', [Orden\Ctrabajos::class, 'getOne'])->name('orden.trabajos.getOne');
        Route::post('/add', [Orden\Ctrabajos::class, 'add'])->name('orden.trabajos.add');
        Route::post('/update', [Orden\Ctrabajos::class, 'update'])->name('orden.trabajos.update');
        Route::post('/delete', [Orden\Ctrabajos::class, 'delete'])->name('orden.trabajos.delete');
    });

});

// Rutas para ordenes_compra
Route::prefix('ordenes_compra')->group(function () {
    // Cordenes_compra
    Route::prefix('ordenes_compra')->group(function () {
        Route::get('/', [Ordenes_compra\Cordenes_compra::class, 'index'])->name('ordenes_compra.ordenes_compra.index');
        Route::post('/getServerSide', [Ordenes_compra\Cordenes_compra::class, 'getServerSide'])->name('ordenes_compra.ordenes_compra.getServerSide');
        Route::post('/getOne', [Ordenes_compra\Cordenes_compra::class, 'getOne'])->name('ordenes_compra.ordenes_compra.getOne');
        Route::post('/add', [Ordenes_compra\Cordenes_compra::class, 'add'])->name('ordenes_compra.ordenes_compra.add');
        Route::post('/update', [Ordenes_compra\Cordenes_compra::class, 'update'])->name('ordenes_compra.ordenes_compra.update');
        Route::post('/delete', [Ordenes_compra\Cordenes_compra::class, 'delete'])->name('ordenes_compra.ordenes_compra.delete');
        Route::get('/listActive', [Ordenes_compra\Cordenes_compra::class, 'listActive'])->name('ordenes_compra.ordenes_compra.listActive');
        Route::get('/listClosed', [Ordenes_compra\Cordenes_compra::class, 'listClosed'])->name('ordenes_compra.ordenes_compra.listClosed');
        Route::post('/asignarTecnico', [Ordenes_compra\Cordenes_compra::class, 'asignarTecnico'])->name('ordenes_compra.ordenes_compra.asignarTecnico');
        Route::post('/cerrarOrden', [Ordenes_compra\Cordenes_compra::class, 'cerrarOrden'])->name('ordenes_compra.ordenes_compra.cerrarOrden');
    });

});

// Rutas para pais
Route::prefix('pais')->group(function () {
    // Cpaises
    Route::prefix('paises')->group(function () {
        Route::get('/', [Pais\Cpaises::class, 'index'])->name('pais.paises.index');
        Route::post('/getServerSide', [Pais\Cpaises::class, 'getServerSide'])->name('pais.paises.getServerSide');
        Route::post('/getOne', [Pais\Cpaises::class, 'getOne'])->name('pais.paises.getOne');
        Route::post('/add', [Pais\Cpaises::class, 'add'])->name('pais.paises.add');
        Route::post('/update', [Pais\Cpaises::class, 'update'])->name('pais.paises.update');
        Route::post('/delete', [Pais\Cpaises::class, 'delete'])->name('pais.paises.delete');
    });

});

// Rutas para periodos_garantias
Route::prefix('periodos_garantias')->group(function () {
    // Cperiodos_garantias
    Route::prefix('periodos_garantias')->group(function () {
        Route::get('/', [Periodos_garantias\Cperiodos_garantias::class, 'index'])->name('periodos_garantias.periodos_garantias.index');
        Route::post('/getServerSide', [Periodos_garantias\Cperiodos_garantias::class, 'getServerSide'])->name('periodos_garantias.periodos_garantias.getServerSide');
        Route::post('/getOne', [Periodos_garantias\Cperiodos_garantias::class, 'getOne'])->name('periodos_garantias.periodos_garantias.getOne');
        Route::post('/add', [Periodos_garantias\Cperiodos_garantias::class, 'add'])->name('periodos_garantias.periodos_garantias.add');
        Route::post('/update', [Periodos_garantias\Cperiodos_garantias::class, 'update'])->name('periodos_garantias.periodos_garantias.update');
        Route::post('/delete', [Periodos_garantias\Cperiodos_garantias::class, 'delete'])->name('periodos_garantias.periodos_garantias.delete');
    });

});

// Rutas para plan
Route::prefix('plan')->group(function () {
    // Cplanes
    Route::prefix('planes')->group(function () {
        Route::get('/', [Plan\Cplanes::class, 'index'])->name('plan.planes.index');
        Route::post('/getServerSide', [Plan\Cplanes::class, 'getServerSide'])->name('plan.planes.getServerSide');
        Route::post('/getOne', [Plan\Cplanes::class, 'getOne'])->name('plan.planes.getOne');
        Route::post('/add', [Plan\Cplanes::class, 'add'])->name('plan.planes.add');
        Route::post('/update', [Plan\Cplanes::class, 'update'])->name('plan.planes.update');
        Route::post('/delete', [Plan\Cplanes::class, 'delete'])->name('plan.planes.delete');
    });

});

// Rutas para preventivo
Route::prefix('preventivo')->group(function () {
    // Cpreventivos
    Route::prefix('preventivos')->group(function () {
        Route::get('/', [Preventivo\Cpreventivos::class, 'index'])->name('preventivo.preventivos.index');
        Route::post('/getServerSide', [Preventivo\Cpreventivos::class, 'getServerSide'])->name('preventivo.preventivos.getServerSide');
        Route::post('/getOne', [Preventivo\Cpreventivos::class, 'getOne'])->name('preventivo.preventivos.getOne');
        Route::post('/add', [Preventivo\Cpreventivos::class, 'add'])->name('preventivo.preventivos.add');
        Route::post('/update', [Preventivo\Cpreventivos::class, 'update'])->name('preventivo.preventivos.update');
        Route::post('/delete', [Preventivo\Cpreventivos::class, 'delete'])->name('preventivo.preventivos.delete');
    });

});

// Rutas para propietario
Route::prefix('propietario')->group(function () {
    // Cpropietarios
    Route::prefix('propietarios')->group(function () {
        Route::get('/', [Propietario\Cpropietarios::class, 'index'])->name('propietario.propietarios.index');
        Route::post('/getServerSide', [Propietario\Cpropietarios::class, 'getServerSide'])->name('propietario.propietarios.getServerSide');
        Route::post('/getOne', [Propietario\Cpropietarios::class, 'getOne'])->name('propietario.propietarios.getOne');
        Route::post('/add', [Propietario\Cpropietarios::class, 'add'])->name('propietario.propietarios.add');
        Route::post('/update', [Propietario\Cpropietarios::class, 'update'])->name('propietario.propietarios.update');
        Route::post('/delete', [Propietario\Cpropietarios::class, 'delete'])->name('propietario.propietarios.delete');
    });

});

// Rutas para proveedores_mantenimiento
Route::prefix('proveedores_mantenimiento')->group(function () {
    // Cproveedores_mantenimiento
    Route::prefix('proveedores_mantenimiento')->group(function () {
        Route::get('/', [Proveedores_mantenimiento\Cproveedores_mantenimiento::class, 'index'])->name('proveedores_mantenimiento.proveedores_mantenimiento.index');
        Route::post('/getServerSide', [Proveedores_mantenimiento\Cproveedores_mantenimiento::class, 'getServerSide'])->name('proveedores_mantenimiento.proveedores_mantenimiento.getServerSide');
        Route::post('/getOne', [Proveedores_mantenimiento\Cproveedores_mantenimiento::class, 'getOne'])->name('proveedores_mantenimiento.proveedores_mantenimiento.getOne');
        Route::post('/add', [Proveedores_mantenimiento\Cproveedores_mantenimiento::class, 'add'])->name('proveedores_mantenimiento.proveedores_mantenimiento.add');
        Route::post('/update', [Proveedores_mantenimiento\Cproveedores_mantenimiento::class, 'update'])->name('proveedores_mantenimiento.proveedores_mantenimiento.update');
        Route::post('/delete', [Proveedores_mantenimiento\Cproveedores_mantenimiento::class, 'delete'])->name('proveedores_mantenimiento.proveedores_mantenimiento.delete');
    });

});

// Rutas para reporte
Route::prefix('reporte')->group(function () {
    // Creportes
    Route::prefix('reportes')->group(function () {
        Route::get('/', [Reporte\Creportes::class, 'index'])->name('reporte.reportes.index');
        Route::post('/getServerSide', [Reporte\Creportes::class, 'getServerSide'])->name('reporte.reportes.getServerSide');
        Route::post('/getOne', [Reporte\Creportes::class, 'getOne'])->name('reporte.reportes.getOne');
        Route::post('/add', [Reporte\Creportes::class, 'add'])->name('reporte.reportes.add');
        Route::post('/update', [Reporte\Creportes::class, 'update'])->name('reporte.reportes.update');
        Route::post('/delete', [Reporte\Creportes::class, 'delete'])->name('reporte.reportes.delete');
        Route::get('/exportPDF', [Reporte\Creportes::class, 'exportPDF'])->name('reporte.reportes.exportPDF');
        Route::get('/exportExcel', [Reporte\Creportes::class, 'exportExcel'])->name('reporte.reportes.exportExcel');
    });

    // Creportes_equipos
    Route::prefix('reportes_equipos')->group(function () {
        Route::get('/', [Reporte\Creportes_equipos::class, 'index'])->name('reporte.reportes_equipos.index');
        Route::post('/getServerSide', [Reporte\Creportes_equipos::class, 'getServerSide'])->name('reporte.reportes_equipos.getServerSide');
        Route::post('/getOne', [Reporte\Creportes_equipos::class, 'getOne'])->name('reporte.reportes_equipos.getOne');
        Route::post('/add', [Reporte\Creportes_equipos::class, 'add'])->name('reporte.reportes_equipos.add');
        Route::post('/update', [Reporte\Creportes_equipos::class, 'update'])->name('reporte.reportes_equipos.update');
        Route::post('/delete', [Reporte\Creportes_equipos::class, 'delete'])->name('reporte.reportes_equipos.delete');
        Route::post('/copy', [Reporte\Creportes_equipos::class, 'copy'])->name('reporte.reportes_equipos.copy');
        Route::get('/getServicios', [Reporte\Creportes_equipos::class, 'getServicios'])->name('reporte.reportes_equipos.getServicios');
        Route::get('/getAreas', [Reporte\Creportes_equipos::class, 'getAreas'])->name('reporte.reportes_equipos.getAreas');
        Route::post('/uploadImage', [Reporte\Creportes_equipos::class, 'uploadImage'])->name('reporte.reportes_equipos.uploadImage');
        Route::post('/uploadFile', [Reporte\Creportes_equipos::class, 'uploadFile'])->name('reporte.reportes_equipos.uploadFile');
        Route::get('/exportPDF', [Reporte\Creportes_equipos::class, 'exportPDF'])->name('reporte.reportes_equipos.exportPDF');
        Route::get('/exportExcel', [Reporte\Creportes_equipos::class, 'exportExcel'])->name('reporte.reportes_equipos.exportExcel');
    });

    // Creportes_inventario
    Route::prefix('reportes_inventario')->group(function () {
        Route::get('/', [Reporte\Creportes_inventario::class, 'index'])->name('reporte.reportes_inventario.index');
        Route::post('/getServerSide', [Reporte\Creportes_inventario::class, 'getServerSide'])->name('reporte.reportes_inventario.getServerSide');
        Route::post('/getOne', [Reporte\Creportes_inventario::class, 'getOne'])->name('reporte.reportes_inventario.getOne');
        Route::post('/add', [Reporte\Creportes_inventario::class, 'add'])->name('reporte.reportes_inventario.add');
        Route::post('/update', [Reporte\Creportes_inventario::class, 'update'])->name('reporte.reportes_inventario.update');
        Route::post('/delete', [Reporte\Creportes_inventario::class, 'delete'])->name('reporte.reportes_inventario.delete');
        Route::get('/exportPDF', [Reporte\Creportes_inventario::class, 'exportPDF'])->name('reporte.reportes_inventario.exportPDF');
        Route::get('/exportExcel', [Reporte\Creportes_inventario::class, 'exportExcel'])->name('reporte.reportes_inventario.exportExcel');
    });

    // Creportes_mantenimientos
    Route::prefix('reportes_mantenimientos')->group(function () {
        Route::get('/', [Reporte\Creportes_mantenimientos::class, 'index'])->name('reporte.reportes_mantenimientos.index');
        Route::post('/getServerSide', [Reporte\Creportes_mantenimientos::class, 'getServerSide'])->name('reporte.reportes_mantenimientos.getServerSide');
        Route::post('/getOne', [Reporte\Creportes_mantenimientos::class, 'getOne'])->name('reporte.reportes_mantenimientos.getOne');
        Route::post('/add', [Reporte\Creportes_mantenimientos::class, 'add'])->name('reporte.reportes_mantenimientos.add');
        Route::post('/update', [Reporte\Creportes_mantenimientos::class, 'update'])->name('reporte.reportes_mantenimientos.update');
        Route::post('/delete', [Reporte\Creportes_mantenimientos::class, 'delete'])->name('reporte.reportes_mantenimientos.delete');
        Route::get('/exportPDF', [Reporte\Creportes_mantenimientos::class, 'exportPDF'])->name('reporte.reportes_mantenimientos.exportPDF');
        Route::get('/exportExcel', [Reporte\Creportes_mantenimientos::class, 'exportExcel'])->name('reporte.reportes_mantenimientos.exportExcel');
    });

});

// Rutas para repuesto
Route::prefix('repuesto')->group(function () {
    // Crepuestos
    Route::prefix('repuestos')->group(function () {
        Route::get('/', [Repuesto\Crepuestos::class, 'index'])->name('repuesto.repuestos.index');
        Route::post('/getServerSide', [Repuesto\Crepuestos::class, 'getServerSide'])->name('repuesto.repuestos.getServerSide');
        Route::post('/getOne', [Repuesto\Crepuestos::class, 'getOne'])->name('repuesto.repuestos.getOne');
        Route::post('/add', [Repuesto\Crepuestos::class, 'add'])->name('repuesto.repuestos.add');
        Route::post('/update', [Repuesto\Crepuestos::class, 'update'])->name('repuesto.repuestos.update');
        Route::post('/delete', [Repuesto\Crepuestos::class, 'delete'])->name('repuesto.repuestos.delete');
    });

    // Crepuestos_pendientes
    Route::prefix('repuestos_pendientes')->group(function () {
        Route::get('/', [Repuesto\Crepuestos_pendientes::class, 'index'])->name('repuesto.repuestos_pendientes.index');
        Route::post('/getServerSide', [Repuesto\Crepuestos_pendientes::class, 'getServerSide'])->name('repuesto.repuestos_pendientes.getServerSide');
        Route::post('/getOne', [Repuesto\Crepuestos_pendientes::class, 'getOne'])->name('repuesto.repuestos_pendientes.getOne');
        Route::post('/add', [Repuesto\Crepuestos_pendientes::class, 'add'])->name('repuesto.repuestos_pendientes.add');
        Route::post('/update', [Repuesto\Crepuestos_pendientes::class, 'update'])->name('repuesto.repuestos_pendientes.update');
        Route::post('/delete', [Repuesto\Crepuestos_pendientes::class, 'delete'])->name('repuesto.repuestos_pendientes.delete');
    });

    // Crepuestos_ti
    Route::prefix('repuestos_ti')->group(function () {
        Route::get('/', [Repuesto\Crepuestos_ti::class, 'index'])->name('repuesto.repuestos_ti.index');
        Route::post('/getServerSide', [Repuesto\Crepuestos_ti::class, 'getServerSide'])->name('repuesto.repuestos_ti.getServerSide');
        Route::post('/getOne', [Repuesto\Crepuestos_ti::class, 'getOne'])->name('repuesto.repuestos_ti.getOne');
        Route::post('/add', [Repuesto\Crepuestos_ti::class, 'add'])->name('repuesto.repuestos_ti.add');
        Route::post('/update', [Repuesto\Crepuestos_ti::class, 'update'])->name('repuesto.repuestos_ti.update');
        Route::post('/delete', [Repuesto\Crepuestos_ti::class, 'delete'])->name('repuesto.repuestos_ti.delete');
    });

});

// Rutas para riesgo
Route::prefix('riesgo')->group(function () {
    // Criesgos
    Route::prefix('riesgos')->group(function () {
        Route::get('/', [Riesgo\Criesgos::class, 'index'])->name('riesgo.riesgos.index');
        Route::post('/getServerSide', [Riesgo\Criesgos::class, 'getServerSide'])->name('riesgo.riesgos.getServerSide');
        Route::post('/getOne', [Riesgo\Criesgos::class, 'getOne'])->name('riesgo.riesgos.getOne');
        Route::post('/add', [Riesgo\Criesgos::class, 'add'])->name('riesgo.riesgos.add');
        Route::post('/update', [Riesgo\Criesgos::class, 'update'])->name('riesgo.riesgos.update');
        Route::post('/delete', [Riesgo\Criesgos::class, 'delete'])->name('riesgo.riesgos.delete');
    });

});

// Rutas para tecnico
Route::prefix('tecnico')->group(function () {
    // Ctecnicos
    Route::prefix('tecnicos')->group(function () {
        Route::get('/', [Tecnico\Ctecnicos::class, 'index'])->name('tecnico.tecnicos.index');
        Route::post('/getServerSide', [Tecnico\Ctecnicos::class, 'getServerSide'])->name('tecnico.tecnicos.getServerSide');
        Route::post('/getOne', [Tecnico\Ctecnicos::class, 'getOne'])->name('tecnico.tecnicos.getOne');
        Route::post('/add', [Tecnico\Ctecnicos::class, 'add'])->name('tecnico.tecnicos.add');
        Route::post('/update', [Tecnico\Ctecnicos::class, 'update'])->name('tecnico.tecnicos.update');
        Route::post('/delete', [Tecnico\Ctecnicos::class, 'delete'])->name('tecnico.tecnicos.delete');
    });

});

// Rutas para tecnologia
Route::prefix('tecnologia')->group(function () {
    // Ctecnologias
    Route::prefix('tecnologias')->group(function () {
        Route::get('/', [Tecnologia\Ctecnologias::class, 'index'])->name('tecnologia.tecnologias.index');
        Route::post('/getServerSide', [Tecnologia\Ctecnologias::class, 'getServerSide'])->name('tecnologia.tecnologias.getServerSide');
        Route::post('/getOne', [Tecnologia\Ctecnologias::class, 'getOne'])->name('tecnologia.tecnologias.getOne');
        Route::post('/add', [Tecnologia\Ctecnologias::class, 'add'])->name('tecnologia.tecnologias.add');
        Route::post('/update', [Tecnologia\Ctecnologias::class, 'update'])->name('tecnologia.tecnologias.update');
        Route::post('/delete', [Tecnologia\Ctecnologias::class, 'delete'])->name('tecnologia.tecnologias.delete');
    });

});

// Rutas para tipos_compra
Route::prefix('tipos_compra')->group(function () {
    // Ctipos_compra
    Route::prefix('tipos_compra')->group(function () {
        Route::get('/', [Tipos_compra\Ctipos_compra::class, 'index'])->name('tipos_compra.tipos_compra.index');
        Route::post('/getServerSide', [Tipos_compra\Ctipos_compra::class, 'getServerSide'])->name('tipos_compra.tipos_compra.getServerSide');
        Route::post('/getOne', [Tipos_compra\Ctipos_compra::class, 'getOne'])->name('tipos_compra.tipos_compra.getOne');
        Route::post('/add', [Tipos_compra\Ctipos_compra::class, 'add'])->name('tipos_compra.tipos_compra.add');
        Route::post('/update', [Tipos_compra\Ctipos_compra::class, 'update'])->name('tipos_compra.tipos_compra.update');
        Route::post('/delete', [Tipos_compra\Ctipos_compra::class, 'delete'])->name('tipos_compra.tipos_compra.delete');
    });

});

// Rutas para tipos_fallas
Route::prefix('tipos_fallas')->group(function () {
    // Ctipos_fallas
    Route::prefix('tipos_fallas')->group(function () {
        Route::get('/', [Tipos_fallas\Ctipos_fallas::class, 'index'])->name('tipos_fallas.tipos_fallas.index');
        Route::post('/getServerSide', [Tipos_fallas\Ctipos_fallas::class, 'getServerSide'])->name('tipos_fallas.tipos_fallas.getServerSide');
        Route::post('/getOne', [Tipos_fallas\Ctipos_fallas::class, 'getOne'])->name('tipos_fallas.tipos_fallas.getOne');
        Route::post('/add', [Tipos_fallas\Ctipos_fallas::class, 'add'])->name('tipos_fallas.tipos_fallas.add');
        Route::post('/update', [Tipos_fallas\Ctipos_fallas::class, 'update'])->name('tipos_fallas.tipos_fallas.update');
        Route::post('/delete', [Tipos_fallas\Ctipos_fallas::class, 'delete'])->name('tipos_fallas.tipos_fallas.delete');
    });

});

// Rutas para trabajo
Route::prefix('trabajo')->group(function () {
    // Ctrabajos
    Route::prefix('trabajos')->group(function () {
        Route::get('/', [Trabajo\Ctrabajos::class, 'index'])->name('trabajo.trabajos.index');
        Route::post('/getServerSide', [Trabajo\Ctrabajos::class, 'getServerSide'])->name('trabajo.trabajos.getServerSide');
        Route::post('/getOne', [Trabajo\Ctrabajos::class, 'getOne'])->name('trabajo.trabajos.getOne');
        Route::post('/add', [Trabajo\Ctrabajos::class, 'add'])->name('trabajo.trabajos.add');
        Route::post('/update', [Trabajo\Ctrabajos::class, 'update'])->name('trabajo.trabajos.update');
        Route::post('/delete', [Trabajo\Ctrabajos::class, 'delete'])->name('trabajo.trabajos.delete');
    });

});

// Rutas para ubicacion
Route::prefix('ubicacion')->group(function () {
    // Careas
    Route::prefix('areas')->group(function () {
        Route::get('/', [Ubicacion\Careas::class, 'index'])->name('ubicacion.areas.index');
        Route::post('/getServerSide', [Ubicacion\Careas::class, 'getServerSide'])->name('ubicacion.areas.getServerSide');
        Route::post('/getOne', [Ubicacion\Careas::class, 'getOne'])->name('ubicacion.areas.getOne');
        Route::post('/add', [Ubicacion\Careas::class, 'add'])->name('ubicacion.areas.add');
        Route::post('/update', [Ubicacion\Careas::class, 'update'])->name('ubicacion.areas.update');
        Route::post('/delete', [Ubicacion\Careas::class, 'delete'])->name('ubicacion.areas.delete');
    });

    // Ccambios_ubicaciones
    Route::prefix('cambios_ubicaciones')->group(function () {
        Route::get('/', [Ubicacion\Ccambios_ubicaciones::class, 'index'])->name('ubicacion.cambios_ubicaciones.index');
        Route::post('/getServerSide', [Ubicacion\Ccambios_ubicaciones::class, 'getServerSide'])->name('ubicacion.cambios_ubicaciones.getServerSide');
        Route::post('/getOne', [Ubicacion\Ccambios_ubicaciones::class, 'getOne'])->name('ubicacion.cambios_ubicaciones.getOne');
        Route::post('/add', [Ubicacion\Ccambios_ubicaciones::class, 'add'])->name('ubicacion.cambios_ubicaciones.add');
        Route::post('/update', [Ubicacion\Ccambios_ubicaciones::class, 'update'])->name('ubicacion.cambios_ubicaciones.update');
        Route::post('/delete', [Ubicacion\Ccambios_ubicaciones::class, 'delete'])->name('ubicacion.cambios_ubicaciones.delete');
    });

    // Ccentros
    Route::prefix('centros')->group(function () {
        Route::get('/', [Ubicacion\Ccentros::class, 'index'])->name('ubicacion.centros.index');
        Route::post('/getServerSide', [Ubicacion\Ccentros::class, 'getServerSide'])->name('ubicacion.centros.getServerSide');
        Route::post('/getOne', [Ubicacion\Ccentros::class, 'getOne'])->name('ubicacion.centros.getOne');
        Route::post('/add', [Ubicacion\Ccentros::class, 'add'])->name('ubicacion.centros.add');
        Route::post('/update', [Ubicacion\Ccentros::class, 'update'])->name('ubicacion.centros.update');
        Route::post('/delete', [Ubicacion\Ccentros::class, 'delete'])->name('ubicacion.centros.delete');
    });

    // Ccontactos
    Route::prefix('contactos')->group(function () {
        Route::get('/', [Ubicacion\Ccontactos::class, 'index'])->name('ubicacion.contactos.index');
        Route::post('/getServerSide', [Ubicacion\Ccontactos::class, 'getServerSide'])->name('ubicacion.contactos.getServerSide');
        Route::post('/getOne', [Ubicacion\Ccontactos::class, 'getOne'])->name('ubicacion.contactos.getOne');
        Route::post('/add', [Ubicacion\Ccontactos::class, 'add'])->name('ubicacion.contactos.add');
        Route::post('/update', [Ubicacion\Ccontactos::class, 'update'])->name('ubicacion.contactos.update');
        Route::post('/delete', [Ubicacion\Ccontactos::class, 'delete'])->name('ubicacion.contactos.delete');
    });

    // Cestadoequipos
    Route::prefix('estadoequipos')->group(function () {
        Route::get('/', [Ubicacion\Cestadoequipos::class, 'index'])->name('ubicacion.estadoequipos.index');
        Route::post('/getServerSide', [Ubicacion\Cestadoequipos::class, 'getServerSide'])->name('ubicacion.estadoequipos.getServerSide');
        Route::post('/getOne', [Ubicacion\Cestadoequipos::class, 'getOne'])->name('ubicacion.estadoequipos.getOne');
        Route::post('/add', [Ubicacion\Cestadoequipos::class, 'add'])->name('ubicacion.estadoequipos.add');
        Route::post('/update', [Ubicacion\Cestadoequipos::class, 'update'])->name('ubicacion.estadoequipos.update');
        Route::post('/delete', [Ubicacion\Cestadoequipos::class, 'delete'])->name('ubicacion.estadoequipos.delete');
        Route::post('/copy', [Ubicacion\Cestadoequipos::class, 'copy'])->name('ubicacion.estadoequipos.copy');
        Route::get('/getServicios', [Ubicacion\Cestadoequipos::class, 'getServicios'])->name('ubicacion.estadoequipos.getServicios');
        Route::get('/getAreas', [Ubicacion\Cestadoequipos::class, 'getAreas'])->name('ubicacion.estadoequipos.getAreas');
        Route::post('/uploadImage', [Ubicacion\Cestadoequipos::class, 'uploadImage'])->name('ubicacion.estadoequipos.uploadImage');
        Route::post('/uploadFile', [Ubicacion\Cestadoequipos::class, 'uploadFile'])->name('ubicacion.estadoequipos.uploadFile');
    });

    // Cpisos
    Route::prefix('pisos')->group(function () {
        Route::get('/', [Ubicacion\Cpisos::class, 'index'])->name('ubicacion.pisos.index');
        Route::post('/getServerSide', [Ubicacion\Cpisos::class, 'getServerSide'])->name('ubicacion.pisos.getServerSide');
        Route::post('/getOne', [Ubicacion\Cpisos::class, 'getOne'])->name('ubicacion.pisos.getOne');
        Route::post('/add', [Ubicacion\Cpisos::class, 'add'])->name('ubicacion.pisos.add');
        Route::post('/update', [Ubicacion\Cpisos::class, 'update'])->name('ubicacion.pisos.update');
        Route::post('/delete', [Ubicacion\Cpisos::class, 'delete'])->name('ubicacion.pisos.delete');
    });

    // Csedes
    Route::prefix('sedes')->group(function () {
        Route::get('/', [Ubicacion\Csedes::class, 'index'])->name('ubicacion.sedes.index');
        Route::post('/getServerSide', [Ubicacion\Csedes::class, 'getServerSide'])->name('ubicacion.sedes.getServerSide');
        Route::post('/getOne', [Ubicacion\Csedes::class, 'getOne'])->name('ubicacion.sedes.getOne');
        Route::post('/add', [Ubicacion\Csedes::class, 'add'])->name('ubicacion.sedes.add');
        Route::post('/update', [Ubicacion\Csedes::class, 'update'])->name('ubicacion.sedes.update');
        Route::post('/delete', [Ubicacion\Csedes::class, 'delete'])->name('ubicacion.sedes.delete');
    });

    // Cservicios
    Route::prefix('servicios')->group(function () {
        Route::get('/', [Ubicacion\Cservicios::class, 'index'])->name('ubicacion.servicios.index');
        Route::post('/getServerSide', [Ubicacion\Cservicios::class, 'getServerSide'])->name('ubicacion.servicios.getServerSide');
        Route::post('/getOne', [Ubicacion\Cservicios::class, 'getOne'])->name('ubicacion.servicios.getOne');
        Route::post('/add', [Ubicacion\Cservicios::class, 'add'])->name('ubicacion.servicios.add');
        Route::post('/update', [Ubicacion\Cservicios::class, 'update'])->name('ubicacion.servicios.update');
        Route::post('/delete', [Ubicacion\Cservicios::class, 'delete'])->name('ubicacion.servicios.delete');
    });

    // Forbidden
    Route::prefix('forbidden')->group(function () {
        Route::get('/', [Ubicacion\Forbidden::class, 'index'])->name('ubicacion.forbidden.index');
        Route::post('/getServerSide', [Ubicacion\Forbidden::class, 'getServerSide'])->name('ubicacion.forbidden.getServerSide');
        Route::post('/getOne', [Ubicacion\Forbidden::class, 'getOne'])->name('ubicacion.forbidden.getOne');
        Route::post('/add', [Ubicacion\Forbidden::class, 'add'])->name('ubicacion.forbidden.add');
        Route::post('/update', [Ubicacion\Forbidden::class, 'update'])->name('ubicacion.forbidden.update');
        Route::post('/delete', [Ubicacion\Forbidden::class, 'delete'])->name('ubicacion.forbidden.delete');
    });

});

// Rutas para upload
Route::prefix('upload')->group(function () {
    // Cupload
    Route::prefix('upload')->group(function () {
        Route::get('/', [Upload\Cupload::class, 'index'])->name('upload.upload.index');
        Route::post('/getServerSide', [Upload\Cupload::class, 'getServerSide'])->name('upload.upload.getServerSide');
        Route::post('/getOne', [Upload\Cupload::class, 'getOne'])->name('upload.upload.getOne');
        Route::post('/add', [Upload\Cupload::class, 'add'])->name('upload.upload.add');
        Route::post('/update', [Upload\Cupload::class, 'update'])->name('upload.upload.update');
        Route::post('/delete', [Upload\Cupload::class, 'delete'])->name('upload.upload.delete');
        Route::post('/uploadFile', [Upload\Cupload::class, 'uploadFile'])->name('upload.upload.uploadFile');
        Route::post('/uploadImage', [Upload\Cupload::class, 'uploadImage'])->name('upload.upload.uploadImage');
        Route::get('/downloadFile/{id}', [Upload\Cupload::class, 'downloadFile'])->name('upload.upload.downloadFile');
    });

});

// Rutas para usuarios_zonas
Route::prefix('usuarios_zonas')->group(function () {
    // Cusuarios_zonas
    Route::prefix('usuarios_zonas')->group(function () {
        Route::get('/', [Usuarios_zonas\Cusuarios_zonas::class, 'index'])->name('usuarios_zonas.usuarios_zonas.index');
        Route::post('/getServerSide', [Usuarios_zonas\Cusuarios_zonas::class, 'getServerSide'])->name('usuarios_zonas.usuarios_zonas.getServerSide');
        Route::post('/getOne', [Usuarios_zonas\Cusuarios_zonas::class, 'getOne'])->name('usuarios_zonas.usuarios_zonas.getOne');
        Route::post('/add', [Usuarios_zonas\Cusuarios_zonas::class, 'add'])->name('usuarios_zonas.usuarios_zonas.add');
        Route::post('/update', [Usuarios_zonas\Cusuarios_zonas::class, 'update'])->name('usuarios_zonas.usuarios_zonas.update');
        Route::post('/delete', [Usuarios_zonas\Cusuarios_zonas::class, 'delete'])->name('usuarios_zonas.usuarios_zonas.delete');
        Route::post('/activate', [Usuarios_zonas\Cusuarios_zonas::class, 'activate'])->name('usuarios_zonas.usuarios_zonas.activate');
        Route::post('/cambiarSede', [Usuarios_zonas\Cusuarios_zonas::class, 'cambiarSede'])->name('usuarios_zonas.usuarios_zonas.cambiarSede');
        Route::post('/resetPassword', [Usuarios_zonas\Cusuarios_zonas::class, 'resetPassword'])->name('usuarios_zonas.usuarios_zonas.resetPassword');
    });

});

// Rutas para workflow
Route::prefix('workflow')->group(function () {
    // Cworkflow
    Route::prefix('workflow')->group(function () {
        Route::get('/', [Workflow\Cworkflow::class, 'index'])->name('workflow.workflow.index');
        Route::post('/getServerSide', [Workflow\Cworkflow::class, 'getServerSide'])->name('workflow.workflow.getServerSide');
        Route::post('/getOne', [Workflow\Cworkflow::class, 'getOne'])->name('workflow.workflow.getOne');
        Route::post('/add', [Workflow\Cworkflow::class, 'add'])->name('workflow.workflow.add');
        Route::post('/update', [Workflow\Cworkflow::class, 'update'])->name('workflow.workflow.update');
        Route::post('/delete', [Workflow\Cworkflow::class, 'delete'])->name('workflow.workflow.delete');
    });

    // Cworkflow_mantenimientos
    Route::prefix('workflow_mantenimientos')->group(function () {
        Route::get('/', [Workflow\Cworkflow_mantenimientos::class, 'index'])->name('workflow.workflow_mantenimientos.index');
        Route::post('/getServerSide', [Workflow\Cworkflow_mantenimientos::class, 'getServerSide'])->name('workflow.workflow_mantenimientos.getServerSide');
        Route::post('/getOne', [Workflow\Cworkflow_mantenimientos::class, 'getOne'])->name('workflow.workflow_mantenimientos.getOne');
        Route::post('/add', [Workflow\Cworkflow_mantenimientos::class, 'add'])->name('workflow.workflow_mantenimientos.add');
        Route::post('/update', [Workflow\Cworkflow_mantenimientos::class, 'update'])->name('workflow.workflow_mantenimientos.update');
        Route::post('/delete', [Workflow\Cworkflow_mantenimientos::class, 'delete'])->name('workflow.workflow_mantenimientos.delete');
    });

    // Cworkflow_ordenes
    Route::prefix('workflow_ordenes')->group(function () {
        Route::get('/', [Workflow\Cworkflow_ordenes::class, 'index'])->name('workflow.workflow_ordenes.index');
        Route::post('/getServerSide', [Workflow\Cworkflow_ordenes::class, 'getServerSide'])->name('workflow.workflow_ordenes.getServerSide');
        Route::post('/getOne', [Workflow\Cworkflow_ordenes::class, 'getOne'])->name('workflow.workflow_ordenes.getOne');
        Route::post('/add', [Workflow\Cworkflow_ordenes::class, 'add'])->name('workflow.workflow_ordenes.add');
        Route::post('/update', [Workflow\Cworkflow_ordenes::class, 'update'])->name('workflow.workflow_ordenes.update');
        Route::post('/delete', [Workflow\Cworkflow_ordenes::class, 'delete'])->name('workflow.workflow_ordenes.delete');
        Route::get('/listActive', [Workflow\Cworkflow_ordenes::class, 'listActive'])->name('workflow.workflow_ordenes.listActive');
        Route::get('/listClosed', [Workflow\Cworkflow_ordenes::class, 'listClosed'])->name('workflow.workflow_ordenes.listClosed');
        Route::post('/asignarTecnico', [Workflow\Cworkflow_ordenes::class, 'asignarTecnico'])->name('workflow.workflow_ordenes.asignarTecnico');
        Route::post('/cerrarOrden', [Workflow\Cworkflow_ordenes::class, 'cerrarOrden'])->name('workflow.workflow_ordenes.cerrarOrden');
    });

});

// Rutas para zona
Route::prefix('zona')->group(function () {
    // Czonas
    Route::prefix('zonas')->group(function () {
        Route::get('/', [Zona\Czonas::class, 'index'])->name('zona.zonas.index');
        Route::post('/getServerSide', [Zona\Czonas::class, 'getServerSide'])->name('zona.zonas.getServerSide');
        Route::post('/getOne', [Zona\Czonas::class, 'getOne'])->name('zona.zonas.getOne');
        Route::post('/add', [Zona\Czonas::class, 'add'])->name('zona.zonas.add');
        Route::post('/update', [Zona\Czonas::class, 'update'])->name('zona.zonas.update');
        Route::post('/delete', [Zona\Czonas::class, 'delete'])->name('zona.zonas.delete');
    });

});

// Rutas API
Route::prefix('api')->group(function () {
    Route::get('/equipos', [Api\Capi_equipos::class, 'listar']);
    Route::post('/equipos', [Api\Capi_equipos::class, 'crear']);
    Route::get('/equipos/{id}', [Api\Capi_equipos::class, 'obtener']);
    Route::put('/equipos/{id}', [Api\Capi_equipos::class, 'actualizar']);
    Route::delete('/equipos/{id}', [Api\Capi_equipos::class, 'eliminar']);

    Route::get('/mantenimientos', [Api\Capi_mantenimientos::class, 'listar']);
    Route::post('/mantenimientos', [Api\Capi_mantenimientos::class, 'crear']);
    Route::get('/mantenimientos/{id}', [Api\Capi_mantenimientos::class, 'obtener']);
});

// Rutas Mobile
Route::prefix('mobile')->group(function () {
    Route::post('/sync', [Mobile\Cmobile::class, 'sync']);
    Route::post('/auth', [Mobile\Cmobile::class, 'auth']);
    Route::get('/equipos', [Mobile\Cmobile_equipos::class, 'listar']);
    Route::get('/ordenes', [Mobile\Cmobile_ordenes::class, 'listar']);
});

// Archivos estáticos
Route::get('/assets/{path}', function ($path) {
    return response()->file(public_path('assets/' . $path));
})->where('path', '.*');

Route::get('/style/{path}', function ($path) {
    return response()->file(public_path('style/' . $path));
})->where('path', '.*');
