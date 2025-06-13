<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Controlador de Módulos del Sistema HUV
 * Maneja todos los módulos especializados del sistema
 */
class ModulosController extends Controller
{
    /**
     * Manejar rutas dinámicas de todos los módulos
     */
    public function handleModule($module, $method = null, $param = null)
    {
        // Verificar autenticación
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Limpiar nombre del módulo
        $moduleName = $this->cleanModuleName($module);

        // Determinar vista a cargar
        $viewPath = $this->determineViewPath($moduleName, $method);

        // Obtener datos específicos del módulo
        $data = $this->getModuleData($moduleName, $method, $param);

        // Renderizar vista
        return $this->renderModuleView($viewPath, $data);
    }

    /**
     * Módulo de Equipos Biomédicos
     */
    public function equipos($method = null, $param = null)
    {
        $data = [
            'equipos' => $this->getEquipos(),
            'servicios' => $this->getServicios(),
            'areas' => $this->getAreas(),
            'estadoequipos' => $this->getEstadoEquipos(),
            'marcas' => $this->getMarcas(),
            'tecnologias' => $this->getTecnologias()
        ];

        return $this->renderModuleView('equipos.list', $data);
    }

    /**
     * Módulo de Usuarios
     */
    public function usuarios($method = null, $param = null)
    {
        $data = [
            'usuarios' => $this->getUsuarios(),
            'roles' => $this->getRoles(),
            'servicios' => $this->getServicios(),
            'sedes' => $this->getSedes()
        ];

        return $this->renderModuleView('usuarios.list', $data);
    }

    /**
     * Módulo de Órdenes de Trabajo
     */
    public function ordenes($method = null, $param = null)
    {
        $data = [
            'ordenes' => $this->getOrdenes(),
            'equipos' => $this->getEquipos(),
            'tecnicos' => $this->getTecnicos(),
            'tipos_orden' => $this->getTiposOrden()
        ];

        return $this->renderModuleView('ordenes.list', $data);
    }

    /**
     * Módulo de Mantenimientos Preventivos
     */
    public function preventivos($method = null, $param = null)
    {
        $data = [
            'preventivos' => $this->getPreventivos(),
            'equipos' => $this->getEquipos(),
            'tecnicos' => $this->getTecnicos(),
            'frecuencias' => $this->getFrecuencias()
        ];

        return $this->renderModuleView('preventivos.list', $data);
    }

    /**
     * Módulo de Calibraciones
     */
    public function calibraciones($method = null, $param = null)
    {
        $data = [
            'calibraciones' => $this->getCalibraciones(),
            'equipos' => $this->getEquipos(),
            'patrones' => $this->getPatrones(),
            'laboratorios' => $this->getLaboratorios()
        ];

        return $this->renderModuleView('calibraciones.list', $data);
    }

    /**
     * Módulo de Repuestos
     */
    public function repuestos($method = null, $param = null)
    {
        $data = [
            'repuestos' => $this->getRepuestos(),
            'equipos' => $this->getEquipos(),
            'proveedores' => $this->getProveedores(),
            'categorias' => $this->getCategoriasRepuestos()
        ];

        return $this->renderModuleView('repuestos.list', $data);
    }

    /**
     * Renderizar vista de módulo con layout
     */
    private function renderModuleView($viewName, $data = [])
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
                'version' => '2.5.0',
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
     * Limpiar nombre del módulo
     */
    private function cleanModuleName($module)
    {
        // Quitar prefijo 'C' si existe (Cequipos -> equipos)
        if (strlen($module) > 1 && $module[0] === 'C' && ctype_upper($module[1])) {
            return strtolower(substr($module, 1));
        }
        return strtolower($module);
    }

    /**
     * Determinar ruta de vista
     */
    private function determineViewPath($moduleName, $method)
    {
        $methodViewMap = [
            'index' => 'list',
            'list' => 'list',
            'add' => 'modal_add',
            'edit' => 'modal_edit',
            'show' => 'modal_show',
            'detail' => 'detail',
            'delete' => 'modal_delete',
            null => 'list'
        ];

        $viewFile = $methodViewMap[$method] ?? 'list';
        $viewPath = $moduleName . '.' . $viewFile;

        // Verificar si la vista existe
        $fullPath = resource_path('views/blade/' . str_replace('.', '/', $viewPath) . '.blade.php');
        if (!file_exists($fullPath)) {
            $viewPath = $moduleName . '.list';
            $fullPath = resource_path('views/blade/' . str_replace('.', '/', $viewPath) . '.blade.php');

            if (!file_exists($fullPath)) {
                $viewPath = $this->findFirstAvailableView($moduleName);
            }
        }

        return $viewPath;
    }

    /**
     * Encontrar primera vista disponible
     */
    private function findFirstAvailableView($moduleName)
    {
        $moduleDir = resource_path('views/blade/' . $moduleName);

        if (is_dir($moduleDir)) {
            $files = scandir($moduleDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    return $moduleName . '.' . pathinfo($file, PATHINFO_FILENAME);
                }
            }
        }

        return 'admin.dashboard'; // Vista de fallback
    }

    /**
     * Obtener datos específicos del módulo
     */
    private function getModuleData($moduleName, $method, $param)
    {
        $data = [
            'module_name' => $moduleName,
            'method' => $method,
            'param' => $param,
            'base_url' => url('/huv') . '/',
        ];

        // Datos específicos por módulo
        switch ($moduleName) {
            case 'equipos':
                $data = array_merge($data, [
                    'equipos' => $this->getEquipos(),
                    'servicios' => $this->getServicios(),
                    'areas' => $this->getAreas()
                ]);
                break;

            case 'usuarios':
                $data = array_merge($data, [
                    'usuarios' => $this->getUsuarios(),
                    'roles' => $this->getRoles()
                ]);
                break;

            default:
                $data['items'] = [];
                $data['message'] = "Módulo $moduleName cargado con vista original";
        }

        return $data;
    }

    // ========================================
    // MÉTODOS PARA OBTENER DATOS DE LA BD
    // ========================================

    private function getEquipos()
    {
        try {
            return DB::table('equipos')
                ->select('equipos.*', 'servicios.nombre as servicio_nombre', 'areas.nombre as area_nombre', 'estadoequipos.nombre as estado_nombre')
                ->join('servicios', 'equipos.servicio_id', '=', 'servicios.id')
                ->join('areas', 'equipos.area_id', '=', 'areas.id')
                ->join('estadoequipos', 'equipos.estadoequipo_id', '=', 'estadoequipos.id')
                ->where('equipos.status', 1)
                ->orderBy('equipos.name')
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getUsuarios()
    {
        try {
            return DB::table('usuarios')
                ->select('usuarios.*', 'roles.nombre as rol_nombre', 'servicios.nombre as servicio_nombre')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->leftJoin('servicios', 'usuarios.servicio_id', '=', 'servicios.id')
                ->where('usuarios.estado', 1)
                ->orderBy('usuarios.nombre')
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getOrdenes()
    {
        try {
            return DB::table('ordenes')
                ->select('ordenes.*', 'equipos.name as equipo_nombre', 'usuarios.nombre as tecnico_nombre')
                ->join('equipos', 'ordenes.equipo_id', '=', 'equipos.id')
                ->leftJoin('usuarios', 'ordenes.tecnico_id', '=', 'usuarios.id')
                ->orderBy('ordenes.fecha_creacion', 'desc')
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getServicios()
    {
        try {
            return DB::table('servicios')->orderBy('nombre')->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getAreas()
    {
        try {
            return DB::table('areas')->orderBy('nombre')->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getEstadoEquipos()
    {
        try {
            return DB::table('estadoequipos')->orderBy('nombre')->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getRoles()
    {
        try {
            return DB::table('roles')->orderBy('nombre')->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }
