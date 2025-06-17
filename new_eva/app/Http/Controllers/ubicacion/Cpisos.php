<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador de Pisos - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de pisos del hospital:
 * - Listado y consulta de pisos activos
 * - Obtención de información específica de pisos
 * - API endpoints para integración con frontend
 * - Gestión de pisos para ubicación de servicios y equipos
 * - Búsqueda y filtrado de pisos
 *
 * Los pisos son niveles físicos del hospital donde se ubican los servicios
 * y equipos médicos, facilitando la organización espacial y logística.
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cpisos extends Controller
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
     * Mostrar vista principal de pisos
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

            // Verificar permisos de acceso al módulo de pisos
            foreach ($acciones as $accion) {
                if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "pisos") {
                    if (isset($accion->leer) && $accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }

            // Obtener datos para la vista
            $data = [
                'pisos' => $this->getAllPisosData(),
                'pisos_activos' => $this->getActivePisosData(),
                'total_pisos' => $this->getTotalPisosCount(),
                'pisos_con_servicios' => $this->getPisosWithServicesCount(),
                'acciones' => $acciones,
                'title' => 'Gestión de Pisos'
            ];

            return view('pisos.index', $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar pisos: ' . $e->getMessage());
        }
    }

    /**
     * Obtener todos los pisos activos (API endpoint)
     * Método refactorizado para compatibilidad con frontend
     * Retorna solo pisos con status = 1 ordenados alfabéticamente
     *
     * @return JsonResponse
     */
    public function ServiceGetAll(): JsonResponse
    {
        try {
            $pisos = $this->getAllPisosData();

            return response()->json([
                'success' => true,
                'data' => $pisos,
                'total' => count($pisos),
                'message' => 'Pisos obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pisos: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Obtener todos los pisos (método alternativo)
     * Endpoint adicional para compatibilidad con diferentes partes del sistema
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $pisos = $this->getAllPisosData();
            return response()->json($pisos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pisos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un piso específico por ID
     * Incluye validación de entrada y manejo de errores
     *
     * @param int $id ID del piso
     * @return JsonResponse
     */
    public function getOne($id): JsonResponse
    {
        try {
            // Validar ID de entrada
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de piso inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $piso = $this->getOnePisoData($id);

            if (!$piso) {
                return response()->json([
                    'success' => false,
                    'message' => 'Piso no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $piso,
                'message' => 'Piso obtenido exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el piso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener pisos por sede específica
     * Filtra pisos que pertenecen a una sede determinada
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

            $pisos = $this->getPisosBySedeData($request->input('sede_id'));

            return response()->json([
                'success' => true,
                'data' => $pisos,
                'total' => count($pisos),
                'message' => 'Pisos obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pisos por sede: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar pisos por nombre
     * Permite búsqueda parcial de pisos por nombre
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
            $pisos = $this->searchPisosData($searchTerm);

            return response()->json([
                'success' => true,
                'data' => $pisos,
                'total' => count($pisos),
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
     * Obtener pisos con información de servicios asociados
     * Incluye conteo de servicios por piso
     *
     * @return JsonResponse
     */
    public function getWithServices(): JsonResponse
    {
        try {
            $pisos = $this->getPisosWithServicesData();

            return response()->json([
                'success' => true,
                'data' => $pisos,
                'total' => count($pisos),
                'message' => 'Pisos con servicios obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pisos con servicios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de pisos
     * Proporciona información estadística sobre los pisos
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total_pisos' => $this->getTotalPisosCount(),
                'pisos_activos' => $this->getActivePisosCount(),
                'pisos_inactivos' => $this->getInactivePisosCount(),
                'pisos_con_servicios' => $this->getPisosWithServicesCount(),
                'pisos_con_equipos' => $this->getPisosWithEquiposCount()
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
     * Obtener todos los pisos activos ordenados por nombre
     * Reemplaza el método getAllPisos del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllPisosData()
    {
        return DB::table('pisos')
            ->select('pisos.*')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener un piso específico por ID
     *
     * @param int $id
     * @return object|null
     */
    private function getOnePisoData($id)
    {
        return DB::table('pisos')
            ->select('pisos.*')
            ->where('pisos.id', $id)
            ->where('status', 1)
            ->first();
    }

    /**
     * Obtener pisos activos (método auxiliar)
     *
     * @return \Illuminate\Support\Collection
     */
    private function getActivePisosData()
    {
        return DB::table('pisos')
            ->select('pisos.*')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener pisos por sede específica
     *
     * @param int $sedeId
     * @return \Illuminate\Support\Collection
     */
    private function getPisosBySedeData($sedeId)
    {
        return DB::table('pisos')
            ->select('pisos.*')
            ->where('pisos.status', 1)
            ->where('pisos.sede_id', $sedeId)
            ->orderBy('pisos.name', 'asc')
            ->get();
    }

    /**
     * Buscar pisos por nombre
     *
     * @param string $searchTerm
     * @return \Illuminate\Support\Collection
     */
    private function searchPisosData($searchTerm)
    {
        return DB::table('pisos')
            ->select('pisos.*')
            ->where('pisos.status', 1)
            ->where('pisos.name', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('pisos.name', 'asc')
            ->get();
    }

    /**
     * Obtener pisos con información de servicios asociados
     *
     * @return \Illuminate\Support\Collection
     */
    private function getPisosWithServicesData()
    {
        return DB::table('pisos')
            ->select([
                'pisos.*',
                DB::raw('(SELECT COUNT(*) FROM servicios WHERE servicios.piso_id = pisos.id AND servicios.status = 1) as cantidad_servicios'),
                DB::raw('(SELECT COUNT(*) FROM equipos e INNER JOIN servicios s ON e.servicio_id = s.id WHERE s.piso_id = pisos.id AND s.status = 1) as cantidad_equipos')
            ])
            ->where('pisos.status', 1)
            ->orderBy('pisos.name', 'asc')
            ->get();
    }

    /**
     * Contar total de pisos
     *
     * @return int
     */
    private function getTotalPisosCount()
    {
        return DB::table('pisos')->count();
    }

    /**
     * Contar pisos activos
     *
     * @return int
     */
    private function getActivePisosCount()
    {
        return DB::table('pisos')
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar pisos inactivos
     *
     * @return int
     */
    private function getInactivePisosCount()
    {
        return DB::table('pisos')
            ->where('status', 0)
            ->count();
    }

    /**
     * Contar pisos que tienen servicios asociados
     *
     * @return int
     */
    private function getPisosWithServicesCount()
    {
        return DB::table('pisos')
            ->join('servicios', 'servicios.piso_id', '=', 'pisos.id')
            ->where('pisos.status', 1)
            ->where('servicios.status', 1)
            ->distinct('pisos.id')
            ->count('pisos.id');
    }

    /**
     * Contar pisos que tienen equipos asociados
     *
     * @return int
     */
    private function getPisosWithEquiposCount()
    {
        return DB::table('pisos')
            ->join('servicios', 'servicios.piso_id', '=', 'pisos.id')
            ->join('equipos', 'equipos.servicio_id', '=', 'servicios.id')
            ->where('pisos.status', 1)
            ->where('servicios.status', 1)
            ->distinct('pisos.id')
            ->count('pisos.id');
    }
}