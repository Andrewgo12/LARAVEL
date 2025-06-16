<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View as ViewContract;
use Carbon\Carbon;

/**
 * Controlador Principal del Sistema HUV - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja todos los módulos del sistema:
 * - 86 tablas en base de datos
 * - 254 vistas Blade migradas
 * - 40+ módulos especializados
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class HuvController extends Controller
{
    /**
     * Constructor - Configurar entorno del sistema
     */
    public function __construct()
    {
        // Configurar datos globales del sistema
        View::share('sistema', [
            'nombre' => 'Sistema HUV',
            'version' => '3.0.0', // Actualizado para Laravel 11
            'hospital' => 'Hospital Universitario del Valle',
            'modulo' => 'Gestión de Tecnología Biomédica',
            'laravel_version' => app()->version()
        ]);
    }

    /**
     * Página principal - Redirige al login
     */
    public function index()
    {
        return redirect()->route('huv.login');
    }

    /**
     * Vista de login del sistema
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Autenticación de usuarios
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'pass' => 'required'
        ]);

        $email = $request->input('Email');
        $password = $request->input('pass');

        try {
            // Buscar usuario en tabla usuarios (estructura real de la BD)
            $user = DB::table('usuarios')->where('email', $email)->first();

            if (!$user) {
                return back()->withErrors(['error' => 'Usuario no encontrado']);
            }

            // Verificar contraseña (hash SHA1 del sistema original)
            $passwordMatch = false;
            if (sha1($password) === $user->password || $password === $user->password) {
                $passwordMatch = true;
            }

            if ($passwordMatch && $user->estado == 1) {
                // Obtener datos adicionales del usuario
                $rol = DB::table('roles')->where('id', $user->rol_id)->first();
                $servicio = DB::table('servicios')->where('id', $user->servicio_id)->first();
                $sede = DB::table('sedes')->where('id', $user->sede_id)->first();

                // Crear sesión completa del usuario
                Session::put([
                    'id' => $user->id,
                    'nombre' => $user->nombre,
                    'apellido' => $user->apellido,
                    'email' => $user->email,
                    'username' => $user->username,
                    'telefono' => $user->telefono,
                    'login' => true,
                    'rol_id' => $user->rol_id,
                    'rol_nombre' => $rol->nombre ?? 'Usuario',
                    'servicio_id' => $user->servicio_id,
                    'servicio_nombre' => $servicio->nombre ?? 'Sin servicio',
                    'sede_id' => $user->sede_id,
                    'sede_nombre' => $sede->nombre ?? 'Sede principal',
                    'centro_id' => $user->centro_id,
                    'zona_id' => $user->zona_id,
                    'empresa_id' => $user->id_empresa,
                    'anio_plan' => $user->anio_plan,
                    'acciones' => $this->getUserPermissions($user->rol_id),
                    'controlador' => 'Home',
                    'fecha_login' => now()
                ]);

                return redirect()->route('huv.dashboard');
            } else {
                return back()->withErrors(['error' => 'Credenciales incorrectas o usuario inactivo']);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error del sistema: ' . $e->getMessage()]);
        }
    }

    /**
     * Dashboard principal del sistema
     */
    public function dashboard()
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Obtener estadísticas del dashboard
        $data = [
            'guias' => $this->getGuiasRapidas(),
            'estadisticas' => $this->getDashboardStats(),
            'equipos_criticos' => $this->getEquiposCriticos(),
            'ordenes_pendientes' => $this->getOrdenesPendientes(),
            'mantenimientos_proximos' => $this->getMantenimientosProximos()
        ];

        return $this->renderView('admin.home', $data);
    }

    /**
     * Mostrar todos los módulos disponibles
     */
    public function modules()
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        $data = [
            'modulos' => $this->getAllModules(),
            'permisos' => Session::get('acciones', [])
        ];

        return $this->renderView('admin.modules_index', $data);
    }

    /**
     * Logout del sistema
     */
    public function logout()
    {
        // Log de cierre de sesión para auditoría
        if (Session::get('login')) {
            Log::info('Usuario cerró sesión', [
                'user_id' => Session::get('id'),
                'email' => Session::get('email'),
                'fecha_logout' => now()
            ]);
        }

        Session::flush();
        return redirect()->route('huv.login')->with('success', 'Sesión cerrada correctamente');
    }

    /**
     * Verificar si el usuario está autenticado
     */
    private function checkAuth()
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }
        return null;
    }

    /**
     * Obtener información del usuario actual
     */
    public function getCurrentUser()
    {
        return [
            'id' => Session::get('id'),
            'nombre' => Session::get('nombre'),
            'apellido' => Session::get('apellido'),
            'email' => Session::get('email'),
            'rol_id' => Session::get('rol_id'),
            'rol_nombre' => Session::get('rol_nombre'),
            'servicio_id' => Session::get('servicio_id'),
            'servicio_nombre' => Session::get('servicio_nombre'),
            'sede_id' => Session::get('sede_id'),
            'sede_nombre' => Session::get('sede_nombre')
        ];
    }

    /**
     * Renderizar vista con layout del sistema
     */
    private function renderView($viewName, $data = [])
    {
        // Datos del usuario para el layout
        $layoutData = [
            'user' => [
                'id' => Session::get('id'),
                'nombre' => Session::get('nombre'),
                'apellido' => Session::get('apellido'),
                'email' => Session::get('email'),
                'rol' => Session::get('rol_nombre'),
                'servicio' => Session::get('servicio_nombre'),
                'sede' => Session::get('sede_nombre')
            ],
            'session_data' => Session::all(),
            'sistema' => [
                'nombre' => 'Sistema HUV',
                'version' => '3.0.0',
                'hospital' => 'Hospital Universitario del Valle'
            ]
        ];

        // Combinar datos
        $allData = array_merge($layoutData, $data);

        // Renderizar con layout usando vistas Laravel migradas
        return view('layouts.app')->with([
            'content' => view("laravel.$viewName", $allData)->render(),
            'user' => $layoutData['user'],
            'session_data' => $layoutData['session_data'],
            'sistema' => $layoutData['sistema']
        ]);
    }

    /**
     * Obtener permisos del usuario según su rol
     */
    private function getUserPermissions($rolId)
    {
        try {
            $permisos = DB::table('permisos')
                ->where('rol_id', $rolId)
                ->get();

            $acciones = [];
            foreach ($permisos as $permiso) {
                $acciones[$permiso->modulo_id] = (object)[
                    'insertar' => $permiso->insertar ?? 1,
                    'editar' => $permiso->editar ?? 1,
                    'eliminar' => $permiso->eliminar ?? 1,
                    'consultar' => $permiso->consultar ?? 1
                ];
            }

            // Si no hay permisos específicos, dar permisos completos
            if (empty($acciones)) {
                for ($i = 0; $i < 30; $i++) {
                    $acciones[$i] = (object)[
                        'insertar' => 1,
                        'editar' => 1,
                        'eliminar' => 1,
                        'consultar' => 1
                    ];
                }
            }

            return $acciones;
        } catch (\Exception $e) {
            // Permisos por defecto en caso de error
            $acciones = [];
            for ($i = 0; $i < 30; $i++) {
                $acciones[$i] = (object)[
                    'insertar' => 1,
                    'editar' => 1,
                    'eliminar' => 1,
                    'consultar' => 1
                ];
            }
            return $acciones;
        }
    }

    /**
     * Obtener guías rápidas para el dashboard
     */
    private function getGuiasRapidas()
    {
        try {
            return DB::table('guias_rapidas')
                ->select('id', 'name', 'file', 'totalQuery')
                ->where('status', 1)
                ->orderBy('name')
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Obtener estadísticas del dashboard
     */
    private function getDashboardStats()
    {
        try {
            return [
                'total_equipos' => DB::table('equipos')->where('status', 1)->count(),
                'equipos_operativos' => DB::table('equipos')
                    ->join('estadoequipos', 'equipos.estadoequipo_id', '=', 'estadoequipos.id')
                    ->where('equipos.status', 1)
                    ->where('estadoequipos.nombre', 'LIKE', '%operativo%')
                    ->count(),
                'ordenes_abiertas' => DB::table('ordenes')->where('estado', 'abierta')->count(),
                'mantenimientos_mes' => DB::table('mantenimiento')
                    ->whereMonth('fecha_programada', date('m'))
                    ->whereYear('fecha_programada', date('Y'))
                    ->count(),
                'calibraciones_pendientes' => DB::table('calibracion')
                    ->where('estado', 'pendiente')
                    ->count(),
                'usuarios_activos' => DB::table('usuarios')->where('estado', 1)->count(),
                'servicios_total' => DB::table('servicios')->count(),
                'areas_total' => DB::table('areas')->count()
            ];
        } catch (\Exception $e) {
            return [
                'total_equipos' => 0,
                'equipos_operativos' => 0,
                'ordenes_abiertas' => 0,
                'mantenimientos_mes' => 0,
                'calibraciones_pendientes' => 0,
                'usuarios_activos' => 0,
                'servicios_total' => 0,
                'areas_total' => 0
            ];
        }
    }

    /**
     * Obtener equipos críticos para el dashboard
     */
    private function getEquiposCriticos()
    {
        try {
            return DB::table('equipos')
                ->select('equipos.*', 'servicios.nombre as servicio_nombre', 'estadoequipos.nombre as estado_nombre')
                ->join('servicios', 'equipos.servicio_id', '=', 'servicios.id')
                ->join('estadoequipos', 'equipos.estadoequipo_id', '=', 'estadoequipos.id')
                ->where('equipos.status', 1)
                ->where(function($query) {
                    $query->where('estadoequipos.nombre', 'LIKE', '%critico%')
                          ->orWhere('estadoequipos.nombre', 'LIKE', '%fuera%')
                          ->orWhere('estadoequipos.nombre', 'LIKE', '%mantenimiento%');
                })
                ->orderBy('equipos.name')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Obtener órdenes pendientes para el dashboard
     */
    private function getOrdenesPendientes()
    {
        try {
            return DB::table('ordenes')
                ->select('ordenes.*', 'equipos.name as equipo_nombre', 'usuarios.nombre as tecnico_nombre')
                ->join('equipos', 'ordenes.equipo_id', '=', 'equipos.id')
                ->leftJoin('usuarios', 'ordenes.tecnico_id', '=', 'usuarios.id')
                ->whereIn('ordenes.estado', ['abierta', 'pendiente', 'en_proceso'])
                ->orderBy('ordenes.fecha_creacion', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Obtener mantenimientos próximos para el dashboard
     */
    private function getMantenimientosProximos()
    {
        try {
            $fechaLimite = date('Y-m-d', strtotime('+30 days'));

            return DB::table('equipos')
                ->select('equipos.*', 'servicios.nombre as servicio_nombre', 'planes_mantenimientos.mes1', 'planes_mantenimientos.mes2')
                ->join('servicios', 'equipos.servicio_id', '=', 'servicios.id')
                ->join('planes_mantenimientos', 'equipos.id', '=', 'planes_mantenimientos.equipo_id')
                ->where('equipos.status', 1)
                ->where('planes_mantenimientos.anio', date('Y'))
                ->where(function($query) {
                    $mesActual = date('n');
                    $query->where('planes_mantenimientos.mes1', '>=', $mesActual)
                          ->orWhere('planes_mantenimientos.mes2', '>=', $mesActual);
                })
                ->orderBy('planes_mantenimientos.mes1')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Obtener todos los módulos disponibles
     */
    private function getAllModules()
    {
        try {
            $modulos = [
                [
                    'id' => 1,
                    'nombre' => 'Equipos Biomédicos',
                    'descripcion' => 'Gestión de equipos biomédicos',
                    'url' => 'equipos',
                    'icono' => 'fa-heartbeat',
                    'activo' => 1
                ],
                [
                    'id' => 2,
                    'nombre' => 'Usuarios',
                    'descripcion' => 'Gestión de usuarios del sistema',
                    'url' => 'usuarios',
                    'icono' => 'fa-users',
                    'activo' => 1
                ],
                [
                    'id' => 3,
                    'nombre' => 'Órdenes de Trabajo',
                    'descripcion' => 'Gestión de órdenes de trabajo',
                    'url' => 'ordenes',
                    'icono' => 'fa-clipboard',
                    'activo' => 1
                ],
                [
                    'id' => 4,
                    'nombre' => 'Mantenimientos Preventivos',
                    'descripcion' => 'Gestión de mantenimientos preventivos',
                    'url' => 'preventivos',
                    'icono' => 'fa-wrench',
                    'activo' => 1
                ],
                [
                    'id' => 5,
                    'nombre' => 'Calibraciones',
                    'descripcion' => 'Gestión de calibraciones',
                    'url' => 'calibraciones',
                    'icono' => 'fa-balance-scale',
                    'activo' => 1
                ],
                [
                    'id' => 6,
                    'nombre' => 'Repuestos',
                    'descripcion' => 'Gestión de repuestos',
                    'url' => 'repuestos',
                    'icono' => 'fa-cogs',
                    'activo' => 1
                ],
                [
                    'id' => 7,
                    'nombre' => 'Servicios',
                    'descripcion' => 'Gestión de servicios hospitalarios',
                    'url' => 'servicios',
                    'icono' => 'fa-hospital-o',
                    'activo' => 1
                ],
                [
                    'id' => 8,
                    'nombre' => 'Áreas',
                    'descripcion' => 'Gestión de áreas',
                    'url' => 'areas',
                    'icono' => 'fa-map-marker',
                    'activo' => 1
                ],
                [
                    'id' => 9,
                    'nombre' => 'Reportes',
                    'descripcion' => 'Generación de reportes',
                    'url' => 'reportes',
                    'icono' => 'fa-file-text',
                    'activo' => 1
                ],
                [
                    'id' => 10,
                    'nombre' => 'Configuración',
                    'descripcion' => 'Configuración del sistema',
                    'url' => 'configuracion',
                    'icono' => 'fa-gear',
                    'activo' => 1
                ]
            ];

            return collect($modulos);
        } catch (\Exception $e) {
            return collect([]);
        }
    }
}
