<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Services\BackendLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/**
 * Controlador de Estados de Equipos - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de estados de equipos médicos:
 * - CRUD de estados de equipos (funcionalidad y disponibilidad)
 * - Listado y consulta de estados activos y utilizados
 * - Gestión de tipos de estados (funcionalidad/disponibilidad)
 * - API endpoints para integración con frontend
 * - Reportes y estadísticas de estados de equipos
 * - Control de permisos y acceso por roles
 *
 * Los estados de equipos permiten clasificar el estado operativo y de disponibilidad
 * de los equipos médicos, facilitando el control y seguimiento del inventario.
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cestadoequipos extends Controller
{
    private $permisos;

    /**
     * Constructor - Configurar middleware y permisos
     *
     * @param BackendLibrary $backendLib Servicio de control de permisos
     */
    public function __construct(BackendLibrary $backendLib)
    {
        // Middleware de autenticación para proteger todas las rutas
        $this->middleware('auth');

        // Inicializar control de permisos
        $this->permisos = $backendLib->control();
    }
    
    /**
     * Mostrar vista principal de estados de equipos
     * Configura el controlador actual en sesión y muestra la interfaz de gestión
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            // Verificar autenticación
            if (!Session::has('login')) {
                return redirect()->route('ci.login');
            }

            // Configurar controlador actual en sesión para navegación
            Session::put('controlador', request()->segment(2));

            // Obtener acciones del usuario desde la sesión
            $acciones = Session::get('acciones', []);

            // Verificar permisos de acceso al módulo de estado equipos
            foreach ($acciones as $accion) {
                if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "estado equipos") {
                    if (isset($accion->leer) && $accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }

            // Obtener datos para la vista
            $data = [
                'estados' => $this->getEstadosData(),
                'estados_funcionalidad' => $this->getFuncionalidadData(),
                'estados_disponibilidad' => $this->getDisponibilidadData(),
                'tipos_estados' => $this->getTipoEstadoData(),
                'total_estados' => $this->getTotalEstadosCount(),
                'estados_usados' => $this->getUsadosData(),
                'acciones' => $acciones,
                'permisos' => $this->permisos,
                'title' => 'Gestión de Estados de Equipos'
            ];

            return view('estadoequipos.index', $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar estados de equipos: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener datos para DataTable de estados de equipos
     * Incluye información de tipos de estados con joins
     *
     * @return JsonResponse
     */
    public function get_datatable(): JsonResponse
    {
        try {
            $estados = $this->getDatatableData();

            return response()->json([
                'success' => true,
                'data' => $estados,
                'message' => 'Datos obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Obtener todos los estados activos
     * Solo retorna estados con status = 1
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        try {
            $estados = $this->getEstadosData();
            return response()->json($estados);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estados: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estados que están siendo utilizados por equipos
     * Retorna solo estados que tienen equipos asociados
     *
     * @return JsonResponse
     */
    public function get_usados(): JsonResponse
    {
        try {
            $estados = $this->getUsadosData();
            return response()->json($estados);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estados usados: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un estado específico por ID
     * Incluye validación de entrada
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de estado inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $estado = $this->getOneEstadoData($request->all());

            if (!$estado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado no encontrado'
                ], 404);
            }

            return response()->json($estado);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el estado: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar un estado de equipo existente
     * Incluye validación de unicidad de nombre y manejo de errores
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar que el ID esté presente
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:estadoequipos,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'respuesta' => 2,
                    'message' => 'ID de estado inválido',
                    'informacion' => $validator->errors()->first()
                ], 422);
            }

            $estado = $this->getOneEstadoData($request->all());

            if (!$estado) {
                return response()->json([
                    'success' => false,
                    'respuesta' => 2,
                    'message' => 'Estado no encontrado',
                    'informacion' => 'El estado especificado no existe'
                ], 404);
            }

            // Configurar reglas de validación dinámicas
            $rules = [
                'tipoestado_id' => 'required|integer|exists:tipos_estados,id'
            ];

            if ($estado->name == $request->input('name')) {
                $rules['name'] = 'required|min:3|max:255';
            } else {
                $rules['name'] = 'required|min:3|max:255|unique:estadoequipos,name';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                $data = $request->all();
                $data['updated_at'] = Carbon::now();

                $this->updateEstadoData($data);

                return response()->json([
                    'success' => true,
                    'respuesta' => 1,
                    'message' => 'Estado actualizado exitosamente',
                    'informacion' => ""
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'respuesta' => 2,
                    'message' => 'Error de validación',
                    'informacion' => $validator->errors()->first()
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'respuesta' => 2,
                'message' => 'Error del sistema',
                'informacion' => 'Error al actualizar estado: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Crear un nuevo estado de equipo
     * Incluye validación de unicidad de nombre y campos requeridos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            // Remover ID si está presente para evitar conflictos
            if ($request->has('id')) {
                $request->request->remove('id');
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:255|unique:estadoequipos,name',
                'tipoestado_id' => 'required|integer|exists:tipos_estados,id'
            ]);

            if ($validator->passes()) {
                $data = $request->all();
                $data['status'] = 1; // Estado activo por defecto
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();

                $this->addEstadoData($data);

                return response()->json([
                    'success' => true,
                    'respuesta' => 1,
                    'message' => 'Estado creado exitosamente',
                    'informacion' => ""
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'respuesta' => 2,
                    'message' => 'Error de validación',
                    'informacion' => $validator->errors()->first()
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'respuesta' => 2,
                'message' => 'Error del sistema',
                'informacion' => 'Error al crear estado: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Desactivar un estado de equipo (eliminación lógica)
     * Cambia el status a 2 (inactivo) en lugar de eliminar físicamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:estadoequipos,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de estado inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['status'] = 2; // Marcar como inactivo
            $data['updated_at'] = Carbon::now();

            $this->deleteEstadoData($data);

            return response()->json([
                'success' => true,
                'message' => 'Estado desactivado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activar un estado de equipo
     * Cambia el status a 1 (activo)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function active(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:estadoequipos,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de estado inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['status'] = 1; // Marcar como activo
            $data['updated_at'] = Carbon::now();

            $this->activeEstadoData($data);

            return response()->json([
                'success' => true,
                'message' => 'Estado activado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al activar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estados de funcionalidad
     * Retorna estados con tipoestado_id = 1
     *
     * @return JsonResponse
     */
    public function getFuncionalidad(): JsonResponse
    {
        try {
            $estados = $this->getFuncionalidadData();
            return response()->json($estados);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estados de funcionalidad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estados de disponibilidad
     * Retorna estados con tipoestado_id = 2
     *
     * @return JsonResponse
     */
    public function getDisponibilidad(): JsonResponse
    {
        try {
            $estados = $this->getDisponibilidadData();
            return response()->json($estados);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estados de disponibilidad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los tipos de estados
     * Retorna la lista completa de tipos de estados disponibles
     *
     * @return JsonResponse
     */
    public function getTipoEstado(): JsonResponse
    {
        try {
            $tipos = $this->getTipoEstadoData();
            return response()->json($tipos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tipos de estados: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de estados de equipos
     * Proporciona información estadística sobre los estados
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total_estados' => $this->getTotalEstadosCount(),
                'estados_activos' => $this->getActiveEstadosCount(),
                'estados_inactivos' => $this->getInactiveEstadosCount(),
                'estados_funcionalidad' => $this->getFuncionalidadCount(),
                'estados_disponibilidad' => $this->getDisponibilidadCount(),
                'estados_usados' => $this->getUsadosCount()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Estadísticas obtenidas exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener datos para DataTable con información de tipos de estados
     * Reemplaza el método get_datatable del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getDatatableData()
    {
        return DB::table('estadoequipos as ee')
            ->leftJoin('tipos_estados as te', 'te.id', '=', 'ee.tipoestado_id')
            ->select('ee.*', 'te.nombre as tipo')
            ->get();
    }

    /**
     * Obtener todos los estados activos
     * Reemplaza el método get del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getEstadosData()
    {
        return DB::table('estadoequipos')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener estados que están siendo utilizados por equipos
     * Reemplaza el método get_usados del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getUsadosData()
    {
        return DB::table('equipos')
            ->leftJoin('estadoequipos', 'equipos.estadoequipo_id', '=', 'estadoequipos.id')
            ->select('equipos.estadoequipo_id as id', 'estadoequipos.name as name')
            ->distinct()
            ->groupBy('estadoequipos.name')
            ->orderBy('estadoequipos.name', 'asc')
            ->get();
    }

    /**
     * Obtener un estado específico por ID
     * Reemplaza el método getOne del modelo CodeIgniter
     *
     * @param array $param
     * @return object|null
     */
    private function getOneEstadoData($param)
    {
        return DB::table('estadoequipos')
            ->where('id', $param['id'])
            ->first();
    }

    /**
     * Crear un nuevo estado de equipo
     * Reemplaza el método add del modelo CodeIgniter
     *
     * @param array $param
     * @return bool
     */
    private function addEstadoData($param)
    {
        return DB::table('estadoequipos')->insert($param);
    }

    /**
     * Actualizar un estado de equipo existente
     * Reemplaza el método update del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function updateEstadoData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('estadoequipos')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Desactivar un estado de equipo (eliminación lógica)
     * Reemplaza el método delete del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function deleteEstadoData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('estadoequipos')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Activar un estado de equipo
     * Reemplaza el método active del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function activeEstadoData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('estadoequipos')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Obtener estados de funcionalidad
     * Reemplaza el método getFuncionalidad del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFuncionalidadData()
    {
        return DB::table('estadoequipos')
            ->where('tipoestado_id', 1)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener estados de disponibilidad
     * Reemplaza el método getDisponibilidad del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getDisponibilidadData()
    {
        return DB::table('estadoequipos')
            ->where('tipoestado_id', 2)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener todos los tipos de estados
     * Reemplaza el método get del modelo Mtipos_estados
     *
     * @return \Illuminate\Support\Collection
     */
    private function getTipoEstadoData()
    {
        return DB::table('tipos_estados')
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Contar total de estados
     *
     * @return int
     */
    private function getTotalEstadosCount()
    {
        return DB::table('estadoequipos')->count();
    }

    /**
     * Contar estados activos
     *
     * @return int
     */
    private function getActiveEstadosCount()
    {
        return DB::table('estadoequipos')
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar estados inactivos
     *
     * @return int
     */
    private function getInactiveEstadosCount()
    {
        return DB::table('estadoequipos')
            ->where('status', 2)
            ->count();
    }

    /**
     * Contar estados de funcionalidad
     *
     * @return int
     */
    private function getFuncionalidadCount()
    {
        return DB::table('estadoequipos')
            ->where('tipoestado_id', 1)
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar estados de disponibilidad
     *
     * @return int
     */
    private function getDisponibilidadCount()
    {
        return DB::table('estadoequipos')
            ->where('tipoestado_id', 2)
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar estados que están siendo utilizados
     *
     * @return int
     */
    private function getUsadosCount()
    {
        return DB::table('equipos')
            ->leftJoin('estadoequipos', 'equipos.estadoequipo_id', '=', 'estadoequipos.id')
            ->distinct('equipos.estadoequipo_id')
            ->count('equipos.estadoequipo_id');
    }
}