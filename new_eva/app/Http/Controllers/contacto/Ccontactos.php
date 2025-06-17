<?php

namespace App\Http\Controllers\contacto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;

/**
 * Controlador de Contactos - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de contactos del sistema:
 * - CRUD de contactos (proveedores, técnicos, empresas, etc.)
 * - Gestión de tipos de contactos
 * - Listado y consulta de contactos activos
 * - API endpoints para integración con frontend
 * - Gestión de proveedores de mantenimiento
 * - Integración con ubicaciones (pisos, zonas, centros)
 *
 * Los contactos son entidades fundamentales que representan personas o empresas
 * que interactúan con el hospital en diferentes capacidades (proveedores,
 * técnicos de mantenimiento, empresas de servicios, etc.).
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Ccontactos extends Controller
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
     * Mostrar vista principal de contactos
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

            // Verificar permisos de acceso al módulo de contactos
            foreach ($acciones as $accion) {
                if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "contactos") {
                    if (isset($accion->leer) && $accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }

            // Obtener datos para la vista
            $data = [
                'contactos' => $this->getContactosData(),
                'tipos_contactos' => $this->getTcontactosData(),
                'proveedores' => $this->getProveedoresData(),
                'total_contactos' => $this->getTotalContactosCount(),
                'contactos_activos' => $this->getActiveContactosCount(),
                'acciones' => $acciones,
                'title' => 'Gestión de Contactos'
            ];

            return view('contactos.index', $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar contactos: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener datos para DataTable de contactos
     * Incluye información de tipos de contactos con joins
     *
     * @return JsonResponse
     */
    public function get_datatable(): JsonResponse
    {
        try {
            $contactos = $this->getDatatableData();

            return response()->json([
                'success' => true,
                'data' => $contactos,
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
     * Obtener todos los contactos activos
     * Solo retorna contactos con status = 1
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        try {
            $contactos = $this->getContactosData();
            return response()->json($contactos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener contactos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un contacto específico por ID
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
                    'message' => 'ID de contacto inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $contacto = $this->getOneContactoData($request->all());

            if (!$contacto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contacto no encontrado'
                ], 404);
            }

            return response()->json($contacto);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el contacto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener contactos que son proveedores
     * Filtra contactos con tcontacto_id = 3
     *
     * @return JsonResponse
     */
    public function getProveedores(): JsonResponse
    {
        try {
            $proveedores = $this->getProveedoresData();
            return response()->json($proveedores);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener proveedores: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los tipos de contactos
     * Retorna la lista completa de tipos de contactos disponibles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTcontactos(Request $request): JsonResponse
    {
        try {
            $tipos = $this->getTcontactosData();
            return response()->json($tipos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tipos de contactos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un contacto existente
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
                'id' => 'required|integer|exists:contacto,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'respuesta' => 2,
                    'message' => 'ID de contacto inválido',
                    'informacion' => $validator->errors()->first()
                ], 422);
            }

            $data = $request->all();
            $contacto = $this->getOneContactoData($data);

            if (!$contacto) {
                return response()->json([
                    'success' => false,
                    'respuesta' => 2,
                    'message' => 'Contacto no encontrado',
                    'informacion' => 'El contacto especificado no existe'
                ], 404);
            }

            // Configurar reglas de validación dinámicas
            $rules = [
                'tcontacto_id' => 'required|integer|exists:tcontacto,id',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255'
            ];

            if ($contacto->name == $data['name']) {
                $rules['name'] = 'required|min:3|max:255';
            } else {
                $rules['name'] = 'required|min:3|max:255|unique:contacto,name';
            }

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {
                $data['updated_at'] = Carbon::now();
                $this->updateContactoData($data);

                return response()->json([
                    'success' => true,
                    'respuesta' => 1,
                    'message' => 'Contacto actualizado exitosamente',
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
                'informacion' => 'Error al actualizar contacto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Crear un nuevo contacto
     * Incluye validación de unicidad de nombre y campos requeridos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            // Remover ID si está presente para evitar conflictos
            if (isset($data["id"])) {
                unset($data["id"]);
            }

            $validator = Validator::make($data, [
                'name' => 'required|min:3|max:255|unique:contacto,name',
                'tcontacto_id' => 'required|integer|exists:tcontacto,id',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255'
            ]);

            if ($validator->passes()) {
                $data['status'] = 1; // Estado activo por defecto
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();

                $this->addContactoData($data);

                return response()->json([
                    'success' => true,
                    'respuesta' => 1,
                    'message' => 'Contacto creado exitosamente',
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
                'informacion' => 'Error al crear contacto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Desactivar un contacto (eliminación lógica)
     * Cambia el status a 2 (inactivo) en lugar de eliminar físicamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:contacto,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de contacto inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data["status"] = 2; // Marcar como inactivo
            $data['updated_at'] = Carbon::now();

            $this->deleteContactoData($data);

            return response()->json([
                'success' => true,
                'message' => 'Contacto desactivado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar contacto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los pisos activos
     * Endpoint para integración con ubicaciones
     *
     * @return JsonResponse
     */
    public function getPisos(): JsonResponse
    {
        try {
            $pisos = $this->getPisosData();
            return response()->json($pisos);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pisos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las zonas activas
     * Endpoint para integración con ubicaciones
     *
     * @return JsonResponse
     */
    public function getZonas(): JsonResponse
    {
        try {
            $zonas = $this->getZonasData();
            return response()->json($zonas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener zonas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los centros activos
     * Endpoint para integración con ubicaciones
     *
     * @return JsonResponse
     */
    public function getCentros(): JsonResponse
    {
        try {
            $centros = $this->getCentrosData();
            return response()->json($centros);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener centros: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener proveedores de mantenimiento
     * Retorna lista de responsables únicos de planes de mantenimiento
     *
     * @return JsonResponse
     */
    public function getProveedoresMantenimiento(): JsonResponse
    {
        try {
            $proveedores = $this->getProveedoresMantenimientoData();
            return response()->json($proveedores);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener proveedores de mantenimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar contactos por nombre
     * Permite búsqueda parcial de contactos por nombre
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
            $contactos = $this->searchContactosData($searchTerm);

            return response()->json([
                'success' => true,
                'data' => $contactos,
                'total' => count($contactos),
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
     * Obtener estadísticas de contactos
     * Proporciona información estadística sobre los contactos
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total_contactos' => $this->getTotalContactosCount(),
                'contactos_activos' => $this->getActiveContactosCount(),
                'contactos_inactivos' => $this->getInactiveContactosCount(),
                'total_proveedores' => $this->getProveedoresCount(),
                'contactos_por_tipo' => $this->getContactosPorTipoData()
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
     * Obtener datos para DataTable con información de tipos de contactos
     * Reemplaza el método get_datatable del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getDatatableData()
    {
        return DB::table('contacto')
            ->leftJoin('tcontacto', 'tcontacto.id', '=', 'contacto.tcontacto_id')
            ->select('contacto.*', 'tcontacto.description as tcontacto')
            ->where('contacto.status', 1)
            ->orderBy('contacto.name', 'asc')
            ->get();
    }

    /**
     * Obtener todos los contactos activos
     * Reemplaza el método get del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getContactosData()
    {
        return DB::table('contacto')
            ->leftJoin('tcontacto', 'tcontacto.id', '=', 'contacto.tcontacto_id')
            ->select('contacto.*', 'tcontacto.description as tcontacto')
            ->where('contacto.status', 1)
            ->orderBy('contacto.name', 'asc')
            ->get();
    }

    /**
     * Obtener un contacto específico por ID
     * Reemplaza el método getOne del modelo CodeIgniter
     *
     * @param array $param
     * @return object|null
     */
    private function getOneContactoData($param)
    {
        return DB::table('contacto')
            ->where('id', $param['id'])
            ->first();
    }

    /**
     * Obtener contactos que son proveedores
     * Reemplaza el método getProveedores del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getProveedoresData()
    {
        return DB::table('contacto')
            ->select('contacto.*')
            ->where('contacto.tcontacto_id', 3)
            ->orderBy('contacto.name', 'asc')
            ->get();
    }

    /**
     * Obtener todos los tipos de contactos
     * Reemplaza el método getTcontactos del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getTcontactosData()
    {
        return DB::table('tcontacto')
            ->orderBy('description', 'asc')
            ->get();
    }

    /**
     * Crear un nuevo contacto
     * Reemplaza el método add del modelo CodeIgniter
     *
     * @param array $param
     * @return bool
     */
    private function addContactoData($param)
    {
        return DB::table('contacto')->insert($param);
    }

    /**
     * Actualizar un contacto existente
     * Reemplaza el método update del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function updateContactoData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('contacto')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Desactivar un contacto (eliminación lógica)
     * Reemplaza el método delete del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function deleteContactoData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('contacto')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Obtener proveedores de mantenimiento
     * Reemplaza el método getProveedoresMantenimiento del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getProveedoresMantenimientoData()
    {
        return DB::table('planes_mantenimientos')
            ->select('responsable')
            ->distinct()
            ->orderBy('responsable', 'asc')
            ->get();
    }

    /**
     * Obtener todos los pisos activos
     * Reemplaza el método get del modelo Mpisos
     *
     * @return \Illuminate\Support\Collection
     */
    private function getPisosData()
    {
        return DB::table('pisos')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener todas las zonas activas
     * Reemplaza el método get del modelo Mzonas
     *
     * @return \Illuminate\Support\Collection
     */
    private function getZonasData()
    {
        return DB::table('zonas')
            ->where('status', '!=', 0)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Obtener todos los centros activos
     * Reemplaza el método get del modelo Mcentros
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCentrosData()
    {
        return DB::table('centros')
            ->select('centros.*')
            ->where('centros.status', 1)
            ->orderBy('centros.name', 'asc')
            ->get();
    }

    /**
     * Buscar contactos por nombre
     *
     * @param string $searchTerm
     * @return \Illuminate\Support\Collection
     */
    private function searchContactosData($searchTerm)
    {
        return DB::table('contacto')
            ->leftJoin('tcontacto', 'tcontacto.id', '=', 'contacto.tcontacto_id')
            ->select('contacto.*', 'tcontacto.description as tcontacto')
            ->where('contacto.status', 1)
            ->where('contacto.name', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('contacto.name', 'asc')
            ->get();
    }

    /**
     * Contar total de contactos
     *
     * @return int
     */
    private function getTotalContactosCount()
    {
        return DB::table('contacto')->count();
    }

    /**
     * Contar contactos activos
     *
     * @return int
     */
    private function getActiveContactosCount()
    {
        return DB::table('contacto')
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar contactos inactivos
     *
     * @return int
     */
    private function getInactiveContactosCount()
    {
        return DB::table('contacto')
            ->where('status', 2)
            ->count();
    }

    /**
     * Contar proveedores
     *
     * @return int
     */
    private function getProveedoresCount()
    {
        return DB::table('contacto')
            ->where('tcontacto_id', 3)
            ->where('status', 1)
            ->count();
    }

    /**
     * Obtener contactos agrupados por tipo
     *
     * @return \Illuminate\Support\Collection
     */
    private function getContactosPorTipoData()
    {
        return DB::table('contacto')
            ->leftJoin('tcontacto', 'tcontacto.id', '=', 'contacto.tcontacto_id')
            ->select('tcontacto.description as tipo', DB::raw('COUNT(*) as cantidad'))
            ->where('contacto.status', 1)
            ->groupBy('tcontacto.id', 'tcontacto.description')
            ->orderBy('cantidad', 'desc')
            ->get();
    }
}

