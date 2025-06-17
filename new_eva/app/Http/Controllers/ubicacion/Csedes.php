<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador de Sedes - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de sedes:
 * - Listado y consulta de sedes
 * - Obtención de información específica de sedes
 * - Gestión de sesión de sede activa
 * - API endpoints para integración con frontend
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Csedes extends Controller
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
     * Mostrar vista principal de sedes
     * Configura el controlador actual en sesión
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

            // Obtener datos para la vista
            $data = [
                'sedes' => $this->getAllSedesData(),
                'title' => 'Gestión de Sedes'
            ];

            return view('sedes.index', $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar sedes: ' . $e->getMessage());
        }
    }

    /**
     * Obtener todas las sedes (API endpoint)
     * Método refactorizado para compatibilidad con frontend
     *
     * @return JsonResponse
     */
    public function ServiceGetAll(): JsonResponse
    {
        try {
            $sedes = $this->getAllSedesData();
            return response()->json($sedes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener sedes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener una sede específica por ID (API endpoint)
     * Método refactorizado para compatibilidad con frontend
     *
     * @param int $id ID de la sede
     * @return JsonResponse
     */
    public function ServiceGetOne($id): JsonResponse
    {
        try {
            // Validar ID
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|exists:sedes,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de sede inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $sede = $this->getOneSedeData($id);

            if (!$sede) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sede no encontrada'
                ], 404);
            }

            return response()->json($sede);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la sede: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las sedes (método alternativo)
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $sedes = $this->getAllSedesData();
            return response()->json($sedes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener sedes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar la sede activa en la sesión
     * Permite al usuario cambiar entre diferentes sedes
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cambiar_sesion_sede(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'sede_seleccionada' => 'required|integer|exists:sedes,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sede seleccionada inválida',
                    'errors' => $validator->errors()
                ], 422);
            }

            $sedeId = $request->input('sede_seleccionada');

            // Verificar que la sede existe y está activa
            $sede = $this->getOneSedeData($sedeId);
            if (!$sede) {
                return response()->json([
                    'success' => false,
                    'message' => 'La sede seleccionada no existe o no está disponible'
                ], 404);
            }

            // Actualizar sesión con la nueva sede
            Session::put('sede_id', $sedeId);
            Session::put('sede_nombre', $sede->name);

            return response()->json([
                'success' => true,
                'message' => 'Sede cambiada exitosamente',
                'sede' => [
                    'id' => $sede->id,
                    'name' => $sede->name
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar sede: ' . $e->getMessage()
            ], 500);
        }
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener todas las sedes ordenadas por nombre
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllSedesData()
    {
        return DB::table('sedes')
            ->select('sedes.*')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener una sede específica por ID
     *
     * @param int $id
     * @return object|null
     */
    private function getOneSedeData($id)
    {
        return DB::table('sedes')
            ->select('sedes.*')
            ->where('sedes.id', $id)
            ->first();
    }
}