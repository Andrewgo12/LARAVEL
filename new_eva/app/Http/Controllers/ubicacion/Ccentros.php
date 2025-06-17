<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador de Centros - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de centros de costo:
 * - Listado y consulta de centros activos
 * - Obtención de información específica de centros
 * - API endpoints para integración con frontend
 * - Gestión de centros para ubicación de equipos y servicios
 *
 * Los centros son unidades organizacionales que agrupan servicios y equipos
 * dentro del hospital, facilitando la gestión administrativa y operativa.
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Ccentros extends Controller
{
    /**
     * Constructor - Configurar middleware de autenticación
     */
    public function __construct()
    {
        // Middleware de autenticación para proteger todas las rutas
        $this->middleware('auth');
    }

    /**
     * Mostrar vista principal de centros
     * Configura el controlador actual en sesión y muestra la interfaz de gestión
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            // Configurar controlador actual en sesión para navegación
            Session::put('controlador', request()->segment(2));

            // Verificar autenticación
            if (!Session::has('login')) {
                return redirect()->route('ci.login');
            }

            // Verificar permisos de acceso
            $acciones = Session::get('acciones', []);
            foreach ($acciones as $accion) {
                if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "centros") {
                    if (isset($accion->leer) && $accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }

            // Obtener datos para la vista
            $data = [
                'centros' => $this->getAllCentrosData(),
                'centros_activos' => $this->getActiveCentrosData(),
                'total_centros' => $this->getTotalCentrosCount(),
                'acciones' => $acciones,
                'title' => 'Gestión de Centros de Costo'
            ];

            return view('centros.index', $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar centros: ' . $e->getMessage());
        }
    }

    /**
     * Obtener todos los centros activos (API endpoint)
     * Método refactorizado para compatibilidad con frontend
     * Retorna solo centros con status = 1 ordenados alfabéticamente
     *
     * @return JsonResponse
     */
    public function ServiceGetAll(): JsonResponse
    {
        try {
            $centros = $this->getAllCentrosData();

            return response()->json([
                'success' => true,
                'data' => $centros,
                'total' => count($centros),
                'message' => 'Centros obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener centros: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Obtener un centro específico por ID (API endpoint)
     * Método refactorizado para compatibilidad con frontend
     * Incluye validación de entrada y manejo de errores
     *
     * @param int $id ID del centro
     * @return JsonResponse
     */
    public function ServiceGetOne($id): JsonResponse
    {
        try {
            // Validar ID de entrada
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de centro inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $centro = $this->getOneCentroData($id);

            if (!$centro) {
                return response()->json([
                    'success' => false,
                    'message' => 'Centro no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $centro,
                'message' => 'Centro obtenido exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el centro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los centros (método alternativo)
     * Endpoint adicional para compatibilidad con diferentes partes del sistema
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $centros = $this->getAllCentrosData();
            return response()->json($centros);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener centros: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener centros por sede específica
     * Filtra centros que pertenecen a una sede determinada
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getBySede(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'sede_id' => 'required|integer|exists:sedes,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sede inválida',
                    'errors' => $validator->errors()
                ], 422);
            }

            $centros = $this->getCentrosBySedeData($request->input('sede_id'));

            return response()->json([
                'success' => true,
                'data' => $centros,
                'total' => count($centros),
                'message' => 'Centros obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener centros por sede: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar centros por nombre
     * Permite búsqueda parcial de centros por nombre
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Término de búsqueda inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $searchTerm = $request->input('q');
            $centros = $this->searchCentrosData($searchTerm);

            return response()->json([
                'success' => true,
                'data' => $centros,
                'total' => count($centros),
                'search_term' => $searchTerm,
                'message' => 'Búsqueda completada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de centros
     * Proporciona información estadística sobre los centros
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total_centros' => $this->getTotalCentrosCount(),
                'centros_activos' => $this->getActiveCentrosCount(),
                'centros_inactivos' => $this->getInactiveCentrosCount(),
                'centros_con_servicios' => $this->getCentrosWithServicesCount(),
                'centros_con_equipos' => $this->getCentrosWithEquiposCount()
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
     * Obtener todos los centros activos ordenados por nombre
     * Reemplaza el método getAllCentros del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllCentrosData()
    {
        return DB::table('centros')
            ->select('centros.*')
            ->where('centros.status', 1)
            ->orderBy('centros.name', 'asc')
            ->get();
    }

    /**
     * Obtener un centro específico por ID
     * Reemplaza el método getOneCentro del modelo CodeIgniter
     *
     * @param int $id
     * @return object|null
     */
    private function getOneCentroData($id)
    {
        return DB::table('centros')
            ->select('centros.*')
            ->where('centros.id', $id)
            ->first();
    }

    /**
     * Obtener centros activos (método auxiliar)
     *
     * @return \Illuminate\Support\Collection
     */
    private function getActiveCentrosData()
    {
        return DB::table('centros')
            ->select('centros.*')
            ->where('centros.status', 1)
            ->orderBy('centros.name', 'asc')
            ->get();
    }

    /**
     * Obtener centros por sede específica
     *
     * @param int $sedeId
     * @return \Illuminate\Support\Collection
     */
    private function getCentrosBySedeData($sedeId)
    {
        return DB::table('centros')
            ->select('centros.*')
            ->where('centros.status', 1)
            ->where('centros.sede_id', $sedeId)
            ->orderBy('centros.name', 'asc')
            ->get();
    }

    /**
     * Buscar centros por nombre
     *
     * @param string $searchTerm
     * @return \Illuminate\Support\Collection
     */
    private function searchCentrosData($searchTerm)
    {
        return DB::table('centros')
            ->select('centros.*')
            ->where('centros.status', 1)
            ->where('centros.name', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('centros.name', 'asc')
            ->get();
    }

    /**
     * Contar total de centros
     *
     * @return int
     */
    private function getTotalCentrosCount()
    {
        return DB::table('centros')->count();
    }

    /**
     * Contar centros activos
     *
     * @return int
     */
    private function getActiveCentrosCount()
    {
        return DB::table('centros')
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar centros inactivos
     *
     * @return int
     */
    private function getInactiveCentrosCount()
    {
        return DB::table('centros')
            ->where('status', 0)
            ->count();
    }

    /**
     * Contar centros que tienen servicios asociados
     *
     * @return int
     */
    private function getCentrosWithServicesCount()
    {
        return DB::table('centros')
            ->join('servicios', 'servicios.centro_id', '=', 'centros.id')
            ->where('centros.status', 1)
            ->where('servicios.status', 1)
            ->distinct('centros.id')
            ->count('centros.id');
    }

    /**
     * Contar centros que tienen equipos asociados
     *
     * @return int
     */
    private function getCentrosWithEquiposCount()
    {
        return DB::table('centros')
            ->join('servicios', 'servicios.centro_id', '=', 'centros.id')
            ->join('equipos', 'equipos.servicio_id', '=', 'servicios.id')
            ->where('centros.status', 1)
            ->where('servicios.status', 1)
            ->distinct('centros.id')
            ->count('centros.id');
    }
}