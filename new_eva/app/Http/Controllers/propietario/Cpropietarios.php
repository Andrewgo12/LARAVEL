<?php

namespace App\Http\Controllers\propietario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Controlador de Propietarios - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de propietarios de equipos médicos:
 * - CRUD de propietarios (empresas, instituciones, entidades)
 * - Gestión de logos e imágenes corporativas
 * - Listado y consulta de propietarios activos
 * - API endpoints para integración con frontend
 * - Control de activación/desactivación de propietarios
 * - Validación de unicidad de nombres
 *
 * Los propietarios representan las entidades que poseen equipos médicos
 * dentro del hospital, facilitando el control de inventario y responsabilidades.
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cpropietarios extends Controller
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
     * Mostrar vista principal de propietarios
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
            Session::put('controlador', 'propietarios');

            // Obtener acciones del usuario desde la sesión
            $acciones = Session::get('acciones', []);

            // Verificar permisos de acceso al módulo de propietarios
            if ($acciones) {
                foreach ($acciones as $accion) {
                    if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "propietarios") {
                        if (isset($accion->leer) && $accion->leer != 1) {
                            return redirect()->route('forbidden');
                        }
                    }
                }
            }

            // Obtener datos para la vista
            $data = [
                "propietarios" => $this->getAllPropietariosData(),
                "total_propietarios" => $this->getTotalPropietariosCount(),
                "propietarios_activos" => $this->getActivePropietariosCount(),
                "acciones" => $acciones,
                "title" => "Gestión de Propietarios"
            ];

            return view("propietarios.list", $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar propietarios: ' . $e->getMessage());
        }
    }
    /**
     * Obtener todos los propietarios
     * API endpoint que retorna la lista completa de propietarios ordenados por nombre
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $propietarios = $this->getAllPropietariosData();
            return response()->json($propietarios);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener propietarios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un propietario específico por ID
     * Incluye validación de entrada y manejo de errores
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
                    'message' => 'ID de propietario inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $propietario = $this->getOnePropietarioData($request->all());

            if (!$propietario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Propietario no encontrado'
                ], 404);
            }

            return response()->json($propietario);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el propietario: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Crear un nuevo propietario
     * Incluye validación de unicidad de nombre, manejo de logos y campos requeridos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            $rules = [
                'nombre' => 'required|min:4|max:255|unique:propietarios,nombre',
                'logo' => 'nullable|image|mimes:gif,jpg,jpeg,png|max:2048'
            ];

            $validator = Validator::make($data, $rules, [
                'nombre.required' => 'El nombre del propietario es requerido',
                'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
                'nombre.max' => 'El nombre no puede exceder 255 caracteres',
                'nombre.unique' => 'Ya existe un propietario con este nombre',
                'logo.image' => 'El archivo debe ser una imagen',
                'logo.mimes' => 'Solo se permiten archivos de imagen (gif, jpg, jpeg, png)',
                'logo.max' => 'El archivo no puede ser mayor a 2MB'
            ]);

            if ($validator->passes()) {
                // Manejo de archivo de logo
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                    $uploadPath = public_path('assets/upload_imagenes');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $file->move($uploadPath, $filename);
                    $data["logo"] = $filename;
                }

                $data['status'] = 1; // Estado activo por defecto
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();

                if ($this->addPropietarioData($data)) {
                    $vector_respuesta = [
                        "success" => true,
                        "caso" => 1,
                        "mensaje" => "Propietario agregado correctamente"
                    ];
                } else {
                    // Si falla la inserción, eliminar el archivo subido
                    if (isset($data["logo"])) {
                        $filePath = public_path("assets/upload_imagenes/" . $data["logo"]);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    $vector_respuesta = [
                        "success" => false,
                        "caso" => 2,
                        "informacion_error" => "Error al guardar el propietario"
                    ];
                }
            } else {
                $vector_respuesta = [
                    "success" => false,
                    "caso" => 2,
                    "informacion_error" => $validator->errors()->first()
                ];
            }

            return response()->json($vector_respuesta);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "caso" => 2,
                "informacion_error" => "Error del sistema: " . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Actualizar un propietario existente
     * Incluye validación de unicidad de nombre, manejo de logos y manejo de errores
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar que el ID esté presente
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:propietarios,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'caso' => 2,
                    'informacion_error' => 'ID de propietario inválido'
                ], 422);
            }

            $data = $request->all();
            $propietario = $this->getOnePropietarioData($data);

            if (!$propietario) {
                return response()->json([
                    'success' => false,
                    'caso' => 2,
                    'informacion_error' => 'Propietario no encontrado'
                ], 404);
            }

            // Configurar reglas de validación dinámicas
            $rules = [
                'logo' => 'nullable|image|mimes:gif,jpg,jpeg,png|max:2048'
            ];

            if ($propietario->nombre == $data['nombre']) {
                $rules['nombre'] = 'required|min:4|max:255';
            } else {
                $rules['nombre'] = 'required|min:4|max:255|unique:propietarios,nombre';
            }

            $validator = Validator::make($data, $rules, [
                'nombre.required' => 'El nombre del propietario es requerido',
                'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
                'nombre.max' => 'El nombre no puede exceder 255 caracteres',
                'nombre.unique' => 'Ya existe un propietario con este nombre',
                'logo.image' => 'El archivo debe ser una imagen',
                'logo.mimes' => 'Solo se permiten archivos de imagen (gif, jpg, jpeg, png)',
                'logo.max' => 'El archivo no puede ser mayor a 2MB'
            ]);

            if ($validator->passes()) {
                // Manejo de archivo de logo
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');

                    // Eliminar logo anterior si existe
                    if ($propietario->logo && file_exists(public_path("assets/upload_imagenes/" . $propietario->logo))) {
                        unlink(public_path("assets/upload_imagenes/" . $propietario->logo));
                    }

                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                    $uploadPath = public_path('assets/upload_imagenes');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $file->move($uploadPath, $filename);
                    $data["logo"] = $filename;
                }

                $data['updated_at'] = Carbon::now();

                if ($this->updatePropietarioData($data)) {
                    $vector_respuesta = [
                        "success" => true,
                        "caso" => 1,
                        "mensaje" => "Propietario actualizado correctamente"
                    ];
                } else {
                    $vector_respuesta = [
                        "success" => false,
                        "caso" => 2,
                        "informacion_error" => "Error al actualizar el propietario"
                    ];
                }
            } else {
                $vector_respuesta = [
                    "success" => false,
                    "caso" => 2,
                    "informacion_error" => $validator->errors()->first()
                ];
            }

            return response()->json($vector_respuesta);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "caso" => 2,
                "informacion_error" => "Error del sistema: " . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Desactivar un propietario (eliminación lógica)
     * Cambia el status a 0 (inactivo) en lugar de eliminar físicamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:propietarios,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de propietario inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['status'] = 0; // Marcar como inactivo
            $data['updated_at'] = Carbon::now();

            if ($this->deletePropietarioData($data)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Propietario desactivado correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar el propietario'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activar un propietario
     * Cambia el status a 1 (activo)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function activate(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:propietarios,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de propietario inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['status'] = 1; // Marcar como activo
            $data['updated_at'] = Carbon::now();

            if ($this->activatePropietarioData($data)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Propietario activado correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al activar el propietario'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar propietarios por nombre
     * Permite búsqueda parcial de propietarios por nombre
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
            $propietarios = $this->searchPropietariosData($searchTerm);

            return response()->json([
                'success' => true,
                'data' => $propietarios,
                'total' => count($propietarios),
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
     * Obtener estadísticas de propietarios
     * Proporciona información estadística sobre los propietarios
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total_propietarios' => $this->getTotalPropietariosCount(),
                'propietarios_activos' => $this->getActivePropietariosCount(),
                'propietarios_inactivos' => $this->getInactivePropietariosCount(),
                'propietarios_con_logo' => $this->getPropietariosWithLogoCount()
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
     * Obtener todos los propietarios ordenados por nombre
     * Reemplaza el método getAll del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllPropietariosData()
    {
        return DB::table('propietarios')
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Obtener un propietario específico por ID
     * Reemplaza el método getOne del modelo CodeIgniter
     *
     * @param array $param
     * @return object|null
     */
    private function getOnePropietarioData($param)
    {
        return DB::table('propietarios')
            ->where('id', $param['id'])
            ->first();
    }

    /**
     * Crear un nuevo propietario
     * Reemplaza el método add del modelo CodeIgniter
     *
     * @param array $param
     * @return bool
     */
    private function addPropietarioData($param)
    {
        return DB::table('propietarios')->insert($param);
    }

    /**
     * Actualizar un propietario existente
     * Reemplaza el método update del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function updatePropietarioData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('propietarios')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Desactivar un propietario (eliminación lógica)
     * Reemplaza el método delete del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function deletePropietarioData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('propietarios')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Activar un propietario
     * Reemplaza el método activate del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function activatePropietarioData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('propietarios')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Buscar propietarios por nombre
     *
     * @param string $searchTerm
     * @return \Illuminate\Support\Collection
     */
    private function searchPropietariosData($searchTerm)
    {
        return DB::table('propietarios')
            ->where('nombre', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Contar total de propietarios
     *
     * @return int
     */
    private function getTotalPropietariosCount()
    {
        return DB::table('propietarios')->count();
    }

    /**
     * Contar propietarios activos
     *
     * @return int
     */
    private function getActivePropietariosCount()
    {
        return DB::table('propietarios')
            ->where('status', 1)
            ->count();
    }

    /**
     * Contar propietarios inactivos
     *
     * @return int
     */
    private function getInactivePropietariosCount()
    {
        return DB::table('propietarios')
            ->where('status', 0)
            ->count();
    }

    /**
     * Contar propietarios que tienen logo
     *
     * @return int
     */
    private function getPropietariosWithLogoCount()
    {
        return DB::table('propietarios')
            ->whereNotNull('logo')
            ->where('logo', '!=', '')
            ->count();
    }
}
