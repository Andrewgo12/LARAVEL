<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// Rutas de prueba para verificar la base de datos
Route::get('/test-db', [App\Http\Controllers\TestController::class, 'testDatabase'])->name('test-db');
Route::get('/create-test-users', [App\Http\Controllers\TestController::class, 'createTestUsers'])->name('create-test-users');

// ========================================
// RUTAS DEL SISTEMA HUV - HOSPITAL UNIVERSITARIO DEL VALLE
// Sistema de Gestión de Tecnología Biomédica
// 86 tablas BD | 254 vistas Blade | 40+ módulos
// ========================================

Route::prefix('huv')->group(function () {
    // Rutas principales del sistema
    Route::get('/', [App\Http\Controllers\HuvController::class, 'index'])->name('huv.index');
    Route::get('/login', [App\Http\Controllers\HuvController::class, 'login'])->name('huv.login');
    Route::post('/authenticate', [App\Http\Controllers\HuvController::class, 'authenticate'])->name('huv.authenticate');
    Route::get('/dashboard', [App\Http\Controllers\HuvController::class, 'dashboard'])->name('huv.dashboard');
    Route::get('/modules', [App\Http\Controllers\HuvController::class, 'modules'])->name('huv.modules');
    Route::get('/logout', [App\Http\Controllers\HuvController::class, 'logout'])->name('huv.logout');


    // ========================================
    // MÓDULOS PRINCIPALES DEL SISTEMA HUV
    // ========================================

    // Módulos principales con controlador específico
    Route::get('/equipos/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'equipos'])->name('huv.equipos');
    Route::post('/equipos/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'equipos']);

    Route::get('/usuarios/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'usuarios'])->name('huv.usuarios');
    Route::post('/usuarios/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'usuarios']);

    Route::get('/ordenes/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'ordenes'])->name('huv.ordenes');
    Route::post('/ordenes/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'ordenes']);

    Route::get('/preventivos/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'preventivos'])->name('huv.preventivos');
    Route::post('/preventivos/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'preventivos']);

    Route::get('/calibraciones/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'calibraciones'])->name('huv.calibraciones');
    Route::post('/calibraciones/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'calibraciones']);

    Route::get('/repuestos/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'repuestos'])->name('huv.repuestos');
    Route::post('/repuestos/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'repuestos']);

    // ========================================
    // MÓDULOS ADICIONALES (Manejo genérico)
    // ========================================

    // Rutas para todos los demás módulos
    Route::get('/{module}/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'handleModule'])->name('huv.module');
    Route::post('/{module}/{method?}/{param?}', [App\Http\Controllers\ModulosController::class, 'handleModule']);
});

// ========================================
// RUTAS DE COMPATIBILIDAD Y ACCESO DIRECTO
// ========================================

// Rutas de acceso directo al sistema
Route::get('/huv', function() { return redirect()->route('huv.dashboard'); });
Route::get('/sistema', function() { return redirect()->route('huv.dashboard'); });

// Compatibilidad con rutas antiguas de CodeIgniter
Route::prefix('ci')->group(function () {
    Route::get('/', function() { return redirect()->route('huv.login'); });
    Route::get('/login', function() { return redirect()->route('huv.login'); });
    Route::post('/Clogin/ingresar', function() { return redirect()->route('huv.authenticate'); });
    Route::get('/Cauth/logout', function() { return redirect()->route('huv.logout'); });
    Route::get('/home', function() { return redirect()->route('huv.dashboard'); });
    Route::get('/dashboard', function() { return redirect()->route('huv.dashboard'); });
    Route::get('/modules', function() { return redirect()->route('huv.modules'); });

    // Redirecciones de módulos antiguos
    Route::get('/equipos', function() { return redirect()->route('huv.equipos'); });
    Route::get('/usuarios', function() { return redirect()->route('huv.usuarios'); });
    Route::get('/ordenes', function() { return redirect()->route('huv.ordenes'); });
    Route::get('/preventivos', function() { return redirect()->route('huv.preventivos'); });
    Route::get('/calibraciones', function() { return redirect()->route('huv.calibraciones'); });
    Route::get('/repuestos', function() { return redirect()->route('huv.repuestos'); });

    // Redirección genérica para otros módulos
    Route::get('/{module}', function($module) {
        return redirect()->route('huv.module', ['module' => $module]);
    });
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

