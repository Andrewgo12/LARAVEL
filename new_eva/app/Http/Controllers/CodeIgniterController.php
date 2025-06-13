<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CodeIgniterController extends Controller
{
    /**
     * Controlador para usar las vistas originales de CodeIgniter sin modificarlas
     */

    public function __construct()
    {
        // Definir constantes de CodeIgniter al inicializar el controlador
        $this->defineCodeIgniterConstants();
    }

    /**
     * Definir todas las constantes necesarias para CodeIgniter
     */
    private function defineCodeIgniterConstants()
    {
        if (!defined('BASEPATH')) {
            define('BASEPATH', __DIR__ . '/../../');
        }
        if (!defined('APPPATH')) {
            define('APPPATH', __DIR__ . '/../../app/');
        }
        if (!defined('VIEWPATH')) {
            define('VIEWPATH', resource_path('views/'));
        }
        if (!defined('FCPATH')) {
            define('FCPATH', public_path() . '/');
        }
        if (!defined('SYSDIR')) {
            define('SYSDIR', 'system');
        }
        if (!defined('EXT')) {
            define('EXT', '.php');
        }
        if (!defined('SELF')) {
            define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
        }
        if (!defined('CI_VERSION')) {
            define('CI_VERSION', '3.1.11');
        }

        // Variables globales de CodeIgniter
        $GLOBALS['CFG'] = new \stdClass();
        $GLOBALS['UNI'] = new \stdClass();
        $GLOBALS['SEC'] = new \stdClass();
    }

    /**
     * Configurar entorno de CodeIgniter para las vistas
     */
    private function setupCodeIgniterEnvironment()
    {
        // URL base
        $GLOBALS['ci_base_url'] = url('/ci') . '/';

        // Simular objeto $this para las vistas (CodeIgniter instance)
        if (!isset($GLOBALS['CI'])) {
            $ci = new \stdClass();

            // Simular session
            $ci->session = new \stdClass();
            $ci->session->userdata = function($key) {
                return Session::get($key);
            };

            // Simular uri
            $ci->uri = new \stdClass();
            $ci->uri->segment = function($n) {
                $segments = explode('/', request()->path());
                return isset($segments[$n-1]) ? $segments[$n-1] : '';
            };

            // Simular load
            $ci->load = new \stdClass();
            $ci->load->view = function($view, $data = [], $return = false) {
                // Implementación básica
                return '';
            };

            $GLOBALS['CI'] = $ci;
        }
    }

    public function index()
    {
        // Redirigir al login (equivalente al controlador Cauth)
        return $this->login();
    }

    public function login()
    {
        // Usar la vista Blade migrada (sin errores "No direct script access allowed")
        return view('auth.login');
    }

    /**
     * Método para renderizar vistas de CodeIgniter con funciones helper simuladas
     */
    private function renderCodeIgniterView($viewName, $data = [])
    {
        // Simular funciones de CodeIgniter
        $this->setupCodeIgniterEnvironment();

        // Función helper base_url()
        if (!function_exists('base_url')) {
            function base_url($uri = '') {
                return url('/ci') . '/' . $uri;
            }
        }

        // Capturar el contenido de la vista PHP
        ob_start();

        // Extraer variables para la vista
        extract($data);

        // Incluir la vista original
        $viewPath = resource_path('views/' . $viewName . '.php');
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<h1>Vista no encontrada: $viewName</h1>";
            echo "<p>Ruta buscada: $viewPath</p>";
        }

        $content = ob_get_clean();

        return response($content);
    }

    public function authenticate(Request $request)
    {
        $email = $request->input('Email');
        $password = $request->input('pass');

        try {
            // Buscar usuario en la base de datos MySQL (tabla usuarios de CodeIgniter)
            $user = DB::table('usuarios')->where('email', $email)->first();

            // Verificar contraseña (tanto hash como texto plano para compatibilidad)
            $passwordMatch = false;
            if ($user) {
                if (Hash::check($password, $user->password)) {
                    $passwordMatch = true;
                } elseif ($user->password === $password) {
                    // Compatibilidad con contraseñas en texto plano del sistema original
                    $passwordMatch = true;
                }
            }

            if ($user && $passwordMatch) {
                // Simular sesión de CodeIgniter exactamente como el original
                Session::put([
                    'id' => $user->id,
                    'nombre' => $user->nombre, // Campo correcto de la tabla usuarios
                    'email' => $user->email,
                    'login' => true,
                    'rol_id' => $user->rol_id ?? 1, // Usar rol del usuario o por defecto
                    'sede_id' => $user->sede_id ?? 1, // Usar sede del usuario o por defecto
                    'acciones' => $this->getDefaultActions(), // Acciones por defecto
                    'controlador' => 'Home', // Controlador por defecto
                ]);

                return redirect()->route('ci.home');
            } else {
                // Redirigir de vuelta al login con error
                return redirect()->route('ci.login')->with('error', 'Credenciales incorrectas');
            }
        } catch (\Exception $e) {
            return redirect()->route('ci.login')->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    public function home()
    {
        // Verificar si está logueado
        if (!Session::get('login')) {
            return redirect()->route('ci.login');
        }

        // Obtener datos para la vista home
        $data = [
            'guias' => $this->getGuias(),
        ];

        // Usar vista Blade migrada con layout
        return $this->renderBladeViewWithLayout('admin.home', $data);
    }

    public function dashboard()
    {
        // Verificar si está logueado
        if (!Session::get('login')) {
            return redirect()->route('ci.login');
        }

        // Para el dashboard, usar la vista de home ya que dashboard.php es una página de error
        return $this->home();
    }

    public function showModules()
    {
        // Verificar si está logueado
        if (!Session::get('login')) {
            return redirect()->route('ci.login');
        }

        // Simular sesión de CodeIgniter
        $this->simulateCodeIgniterSession();

        // Mostrar página con todos los módulos disponibles
        return $this->renderBladeViewWithLayout('admin.modules_index', []);
    }

    /**
     * Renderizar vista Blade con layout completo (SIN errores "No direct script access allowed")
     */
    private function renderBladeViewWithLayout($viewName, $data = [])
    {
        // Configurar datos de sesión para las vistas
        $layoutData = [
            'user' => [
                'id' => Session::get('id'),
                'nombre' => Session::get('nombre'),
                'email' => Session::get('email'),
            ],
            'session_data' => [
                'login' => Session::get('login'),
                'rol_id' => Session::get('rol_id'),
                'sede_id' => Session::get('sede_id'),
                'acciones' => Session::get('acciones'),
                'controlador' => Session::get('controlador'),
            ]
        ];

        // Combinar datos del layout con datos específicos de la vista
        $allData = array_merge($layoutData, $data);

        // Renderizar vista Blade con layout
        return view('layouts.app')->with([
            'content' => view("blade.$viewName", $allData)->render(),
            'user' => $layoutData['user'],
            'session_data' => $layoutData['session_data']
        ]);
    }

    /**
     * Renderizar vista con layout completo de CodeIgniter
     */
    private function renderCodeIgniterViewWithLayout($viewName, $data = [])
    {
        // Configurar entorno de CodeIgniter
        $this->setupCodeIgniterEnvironment();

        // Función helper base_url()
        if (!function_exists('base_url')) {
            function base_url($uri = '') {
                return url('/ci') . '/' . $uri;
            }
        }

        // Capturar el contenido completo
        ob_start();

        // Extraer variables para la vista
        extract($data);

        // Incluir header
        $headerPath = resource_path('views/layouts/header.php');
        if (file_exists($headerPath)) {
            include $headerPath;
        }

        // Incluir aside/menu
        $asidePath = resource_path('views/layouts/aside.php');
        if (file_exists($asidePath)) {
            include $asidePath;
        }

        // Incluir contenido principal
        $viewPath = resource_path('views/' . $viewName . '.php');
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<div class='content-wrapper'><h1>Vista no encontrada: $viewName</h1></div>";
        }

        // Incluir footer
        $footerPath = resource_path('views/layouts/footer.php');
        if (file_exists($footerPath)) {
            include $footerPath;
        }

        $content = ob_get_clean();

        return response($content);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('ci.login');
    }

    /**
     * Simular sesión de CodeIgniter para las vistas
     */
    private function simulateCodeIgniterSession()
    {
        // Simular datos de sesión que esperan las vistas originales
        if (!Session::has('acciones')) {
            Session::put('acciones', $this->getDefaultActions());
        }
        if (!Session::has('controlador')) {
            Session::put('controlador', 'Home');
        }
    }

    /**
     * Obtener acciones por defecto para simular permisos
     */
    private function getDefaultActions()
    {
        // Simular estructura de permisos de CodeIgniter
        $actions = [];
        for ($i = 0; $i < 25; $i++) {
            $actions[$i] = (object)[
                'insertar' => 1,
                'editar' => 1,
                'eliminar' => 1,
                'consultar' => 1
            ];
        }
        return $actions;
    }

    /**
     * Obtener guías para la vista home
     */
    private function getGuias()
    {
        // Simular datos de guías - en una implementación real vendrían de la BD
        return [
            (object)[
                'id' => 1,
                'name' => 'Guía de Equipos Biomédicos',
                'file' => 'guia_biomedicos.pdf',
                'totalQuery' => 15
            ],
            (object)[
                'id' => 2,
                'name' => 'Manual de Mantenimiento',
                'file' => 'manual_mantenimiento.pdf',
                'totalQuery' => 8
            ],
            (object)[
                'id' => 3,
                'name' => 'Protocolo de Calibración',
                'file' => 'protocolo_calibracion.pdf',
                'totalQuery' => 12
            ]
        ];
    }

    private function getDashboardStats()
    {
        try {
            return [
                'total_users' => DB::table('users')->count(),
                'total_sessions' => DB::table('sessions')->count(),
                'database_status' => 'Conectado',
                'last_login' => now()->format('Y-m-d H:i:s')
            ];
        } catch (\Exception $e) {
            return [
                'total_users' => 0,
                'total_sessions' => 0,
                'database_status' => 'Error: ' . $e->getMessage(),
                'last_login' => 'N/A'
            ];
        }
    }

    /**
     * API endpoints para compatibilidad con CodeIgniter
     */
    public function api($endpoint = null)
    {
        switch ($endpoint) {
            case 'users':
                return response()->json(DB::table('users')->get());

            case 'stats':
                return response()->json($this->getDashboardStats());

            default:
                return response()->json(['error' => 'Endpoint no encontrado'], 404);
        }
    }

    /**
     * Manejar rutas dinámicas de CodeIgniter - TODOS LOS MÓDULOS
     */
    public function handleRoute($controller = null, $method = null, $param = null)
    {
        // Verificar si está logueado para rutas protegidas
        if (!Session::get('login') && $controller !== 'Cauth') {
            return redirect()->route('ci.login');
        }

        // Simular sesión de CodeIgniter
        $this->simulateCodeIgniterSession();

        // Lista completa de todos los módulos del sistema HUV
        $modules = [
            'usuarios', 'Cusuarios',
            'tecnicos', 'Ctecnicos',
            'servicios', 'Cservicios',
            'repuestos_pendientes', 'Crepuestos_pendientes',
            'repuestos', 'Crepuestos',
            'reportes_preventivos', 'Creportes_preventivos',
            'reportes', 'Creportes',
            'propietarios', 'Cpropietarios',
            'preventivos', 'Cpreventivos',
            'permisos', 'Cpermisos',
            'ordenes_compra', 'Cordenes_compra',
            'ordenes', 'Cordenes',
            'manuales', 'Cmanuales',
            'mantenimientos', 'Cmantenimientos',
            'invimas', 'Cinvimas',
            'guias', 'Cguias',
            'estadoequipos', 'Cestadoequipos',
            'equipos_industriales', 'Cequipos_industriales', 'Cequipos_ind',
            'equipos', 'Cequipos',
            'detalle', 'Cdetalle',
            'correctivos_generales', 'Ccorrectivos_generales',
            'contingencias', 'Ccontingencias',
            'contactos', 'Ccontactos',
            'categorias', 'Ccategorias',
            'capacitaciones', 'Ccapacitaciones',
            'cambios_ubicaciones', 'Ccambios_ubicaciones',
            'calibraciones', 'Ccalibraciones',
            'bajas', 'Cbajas',
            'avances_correctivos', 'Cavances_correctivos',
            'areas', 'Careas',
            'archivos', 'Carchivos',
            'admin', 'Cadmin'
        ];

        // Manejar controladores especiales
        switch ($controller) {
            case 'Cauth':
                return $this->handleAuth($method);

            case 'Home':
                return $this->home();

            case 'Dashboard':
                return $this->dashboard();

            default:
                // Manejar cualquier módulo automáticamente
                return $this->handleGenericModule($controller, $method, $param);
        }
    }

    private function handleAuth($method)
    {
        switch ($method) {
            case 'ingresar':
                return $this->authenticate(request());

            case 'logout':
                return $this->logout();

            default:
                return $this->login();
        }
    }

    /**
     * Manejar cualquier módulo automáticamente usando sus vistas originales
     */
    private function handleGenericModule($controller, $method = null, $param = null)
    {
        // Limpiar nombre del controlador (quitar prefijo C si existe)
        $moduleName = $this->cleanControllerName($controller);

        // Determinar la vista a cargar basada en el método
        $viewPath = $this->determineViewPath($moduleName, $method);

        // Obtener datos específicos del módulo
        $data = $this->getModuleData($moduleName, $method, $param);

        // Renderizar la vista Blade migrada (sin errores "No direct script access allowed")
        return $this->renderBladeViewWithLayout($viewPath, $data);
    }

    /**
     * Limpiar nombre del controlador
     */
    private function cleanControllerName($controller)
    {
        // Quitar prefijo 'C' si existe (Cequipos -> equipos)
        if (strlen($controller) > 1 && $controller[0] === 'C' && ctype_upper($controller[1])) {
            return strtolower(substr($controller, 1));
        }
        return strtolower($controller);
    }

    /**
     * Determinar la ruta de la vista basada en el módulo y método
     */
    private function determineViewPath($moduleName, $method)
    {
        // Mapeo de métodos comunes a vistas
        $methodViewMap = [
            'index' => 'list',
            'list' => 'list',
            'add' => 'modal_add',
            'edit' => 'modal_edit',
            'show' => 'modal_show',
            'detail' => 'detail',
            'delete' => 'modal_delete',
            null => 'list' // Vista por defecto
        ];

        $viewFile = $methodViewMap[$method] ?? 'list';
        $viewPath = $moduleName . '/' . $viewFile;

        // Verificar si la vista existe, si no, usar list como fallback
        $fullPath = resource_path('views/' . $viewPath . '.php');
        if (!file_exists($fullPath)) {
            $viewPath = $moduleName . '/list';
            $fullPath = resource_path('views/' . $viewPath . '.php');

            // Si tampoco existe list.php, buscar la primera vista disponible
            if (!file_exists($fullPath)) {
                $viewPath = $this->findFirstAvailableView($moduleName);
            }
        }

        return $viewPath;
    }

    /**
     * Encontrar la primera vista disponible en un módulo
     */
    private function findFirstAvailableView($moduleName)
    {
        $moduleDir = resource_path('views/' . $moduleName);

        if (is_dir($moduleDir)) {
            $files = scandir($moduleDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    return $moduleName . '/' . pathinfo($file, PATHINFO_FILENAME);
                }
            }
        }

        // Si no se encuentra nada, retornar una vista de error personalizada
        return 'admin/dashboard'; // Vista de fallback
    }

    /**
     * Obtener datos específicos para cada módulo
     */
    private function getModuleData($moduleName, $method, $param)
    {
        $data = [
            'module_name' => $moduleName,
            'method' => $method,
            'param' => $param,
            'base_url' => url('/ci') . '/',
        ];

        // Datos específicos por módulo
        switch ($moduleName) {
            case 'usuarios':
                $data['usuarios'] = DB::table('users')->get();
                break;

            case 'equipos':
                $data['equipos'] = $this->getEquiposData();
                break;

            case 'ordenes':
                $data['ordenes'] = $this->getOrdenesData();
                break;

            case 'repuestos':
                $data['repuestos'] = $this->getRepuestosData();
                break;

            case 'preventivos':
                $data['preventivos'] = $this->getPreventivosData();
                break;

            case 'calibraciones':
                $data['calibraciones'] = $this->getCalibracionesData();
                break;

            case 'guias':
                $data['guias'] = $this->getGuias();
                break;

            default:
                // Datos genéricos para módulos no específicos
                $data['items'] = [];
                $data['message'] = "Módulo $moduleName cargado con vista original";
        }

        return $data;
    }

    /**
     * Métodos para obtener datos específicos de cada módulo
     */
    private function getEquiposData()
    {
        // Simular datos de equipos - en implementación real vendrían de BD
        return [
            (object)[
                'id' => 1,
                'nombre' => 'Monitor de Signos Vitales',
                'marca' => 'Philips',
                'modelo' => 'IntelliVue MP70',
                'serie' => 'DE12345',
                'ubicacion' => 'UCI - Cama 1',
                'estado' => 'Operativo'
            ],
            (object)[
                'id' => 2,
                'nombre' => 'Ventilador Mecánico',
                'marca' => 'Dräger',
                'modelo' => 'Evita V500',
                'serie' => 'VE67890',
                'ubicacion' => 'UCI - Cama 3',
                'estado' => 'Mantenimiento'
            ]
        ];
    }

    private function getOrdenesData()
    {
        return [
            (object)[
                'id' => 1,
                'numero' => 'ORD-2025-001',
                'equipo' => 'Monitor de Signos Vitales',
                'tipo' => 'Correctivo',
                'estado' => 'Abierta',
                'fecha_creacion' => '2025-01-13',
                'tecnico' => 'Juan Pérez'
            ],
            (object)[
                'id' => 2,
                'numero' => 'ORD-2025-002',
                'equipo' => 'Ventilador Mecánico',
                'tipo' => 'Preventivo',
                'estado' => 'En Proceso',
                'fecha_creacion' => '2025-01-12',
                'tecnico' => 'María García'
            ]
        ];
    }

    private function getRepuestosData()
    {
        return [
            (object)[
                'id' => 1,
                'nombre' => 'Sensor de Presión',
                'codigo' => 'SP-001',
                'stock' => 15,
                'precio' => 250000,
                'proveedor' => 'Philips Healthcare'
            ],
            (object)[
                'id' => 2,
                'nombre' => 'Filtro HEPA',
                'codigo' => 'FH-002',
                'stock' => 8,
                'precio' => 180000,
                'proveedor' => 'Dräger Medical'
            ]
        ];
    }

    private function getPreventivosData()
    {
        return [
            (object)[
                'id' => 1,
                'equipo' => 'Monitor de Signos Vitales',
                'tipo' => 'Calibración',
                'frecuencia' => 'Mensual',
                'ultimo_mantenimiento' => '2024-12-13',
                'proximo_mantenimiento' => '2025-02-13',
                'estado' => 'Programado'
            ],
            (object)[
                'id' => 2,
                'equipo' => 'Ventilador Mecánico',
                'tipo' => 'Limpieza Profunda',
                'frecuencia' => 'Trimestral',
                'ultimo_mantenimiento' => '2024-10-15',
                'proximo_mantenimiento' => '2025-01-15',
                'estado' => 'Vencido'
            ]
        ];
    }

    private function getCalibracionesData()
    {
        return [
            (object)[
                'id' => 1,
                'equipo' => 'Monitor de Signos Vitales',
                'parametro' => 'Presión Arterial',
                'valor_referencia' => '120/80 mmHg',
                'valor_medido' => '119/81 mmHg',
                'desviacion' => '±1 mmHg',
                'estado' => 'Aprobado',
                'fecha' => '2025-01-10'
            ],
            (object)[
                'id' => 2,
                'equipo' => 'Ventilador Mecánico',
                'parametro' => 'Volumen Tidal',
                'valor_referencia' => '500 ml',
                'valor_medido' => '498 ml',
                'desviacion' => '±2 ml',
                'estado' => 'Aprobado',
                'fecha' => '2025-01-08'
            ]
        ];
    }
}
