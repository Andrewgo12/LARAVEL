<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mservicios;
use App\Models\Mpisos;
use App\Models\Mzonas;
use App\Models\Mcentros;
use App\Services\BackendLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/**
 * Controlador de Servicios - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de servicios hospitalarios:
 * - CRUD completo de servicios (crear, leer, actualizar, eliminar)
 * - Gestión de ubicaciones (pisos, zonas, centros)
 * - Consultas por sede y ubicación
 * - Integración con áreas y equipos
 * - DataTable server-side para listados
 * - Control de permisos y accesos
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cservicios extends Controller
{
    protected ?array $servicios;
    protected Mservicios $mservicios;
    protected Mpisos $mpisos;
    protected Mzonas $mzonas;
    protected Mcentros $mcentros;
    protected ?array $permisos;

    /**
     * Constructor - Inicializar dependencias con tipado fuerte
     *
     * @param BackendLibrary $backendLib
     */
    public function __construct(BackendLibrary $backendLib)
    {
        $this->servicios = null;
        $this->mservicios = new Mservicios();
        $this->mpisos = new Mpisos();
        $this->mzonas = new Mzonas();
        $this->mcentros = new Mcentros();
        $this->permisos = $backendLib->control();
    }
    
    /**
     * Mostrar listado principal de servicios
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Verificar autenticación
        if (!Session::has('login')) {
            return redirect('Cauth');
        }

        // Configurar controlador actual en sesión
        $acciones = Session::get('acciones', []);
        Session::put('controlador', request()->segment(2));

        // Verificar permisos de lectura
        foreach ($acciones as $accion) {
            if ($accion->modulo == "servicios") {
                if ($accion->leer != 1) {
                    return redirect('Home');
                }
            }
        }

        try {
            return view('layouts.header')
                ->nest('aside', 'layouts.aside')
                ->nest('content', 'servicios.list')
                ->nest('modal_add', 'servicios.modal_add')
                ->nest('modal_edit', 'servicios.modal_edit')
                ->nest('footer', 'layouts.footer');

        } catch (\Exception $e) {
            return redirect('Home')->with('error', 'Error al cargar servicios: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener todos los servicios con información completa
     *
     * @return JsonResponse
     */
    public function ServiceGetAll(): JsonResponse
    {
        try {
            $servicios = $this->mservicios->getAllServices();
            return response()->json($servicios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un servicio específico por ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function ServiceGetOne(int $id): JsonResponse
    {
        try {
            // Validar ID
            if ($id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de servicio inválido'
                ], 422);
            }

            $servicio = $this->mservicios->getOneService($id);
            return response()->json($servicio);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el servicio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener servicios por sede
     *
     * @param int $id
     * @return JsonResponse
     */
    public function ServiceGetBySede(int $id): JsonResponse
    {
        try {
            // Validar ID de sede
            if ($id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de sede inválido'
                ], 422);
            }

            $servicios = $this->mservicios->getBySede($id);
            return response()->json($servicios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicios por sede: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Crear nuevo servicio
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:4|max:255|unique:servicios,name',
                'piso_id' => 'nullable|integer|exists:pisos,id',
                'zona_id' => 'nullable|integer|exists:zonas,id',
                'centro_id' => 'nullable|integer|exists:centros,id',
                'sede_id' => 'nullable|integer|exists:sedes,id',
                'description' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Preparar datos con timestamps
            $data = $request->all();
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $data['status'] = 1; // Activo por defecto

            $result = $this->mservicios->add($data);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Servicio creado exitosamente',
                    'result' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el servicio'
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
     * Eliminar servicio (soft delete)
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            // Validar ID
            if ($id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de servicio inválido'
                ], 422);
            }

            $result = $this->mservicios->delete(['id' => $id]);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Servicio eliminado exitosamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el servicio'
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
     * Obtener servicios para DataTable
     *
     * @return JsonResponse
     */
    public function get_datatable(): JsonResponse
    {
        try {
            $servicios = $this->mservicios->get_datatable();
            return response()->json($servicios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos para tabla: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los servicios básicos
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        try {
            $servicios = $this->mservicios->get();
            return response()->json($servicios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un servicio específico
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:servicios,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de servicio inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $servicio = $this->mservicios->getOne($request->all());
            return response()->json($servicio);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el servicio: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener información de ubicación de un servicio
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUbicacion(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:servicios,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de servicio inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $ubicacion = $this->mservicios->getUbicacion($request->all());
            return response()->json($ubicacion);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ubicación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar servicio existente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar que existe el ID
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:servicios,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de servicio inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Obtener servicio actual
            $servicio = $this->mservicios->getOne($request->all());

            if (!$servicio) {
                return response()->json([
                    'success' => false,
                    'message' => 'Servicio no encontrado'
                ], 404);
            }

            // Reglas de validación dinámicas
            $rules = [
                'piso_id' => 'nullable|integer|exists:pisos,id',
                'zona_id' => 'nullable|integer|exists:zonas,id',
                'centro_id' => 'nullable|integer|exists:centros,id',
                'sede_id' => 'nullable|integer|exists:sedes,id',
                'description' => 'nullable|string|max:500'
            ];

            // Validar unicidad del nombre solo si cambió
            if ($servicio->name == $request->input('name')) {
                $rules['name'] = 'required|string|min:3|max:255';
            } else {
                $rules['name'] = 'required|string|min:3|max:255|unique:servicios,name';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Preparar datos con timestamp de actualización
            $data = $request->all();
            $data['updated_at'] = Carbon::now();

            $this->mservicios->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Servicio actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener todos los pisos disponibles
     *
     * @return JsonResponse
     */
    public function getPisos(): JsonResponse
    {
        try {
            $pisos = $this->mpisos->get();
            return response()->json($pisos);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener pisos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las zonas disponibles
     *
     * @return JsonResponse
     */
    public function getZonas(): JsonResponse
    {
        try {
            $zonas = $this->mzonas->get();
            return response()->json($zonas);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener zonas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los centros disponibles
     *
     * @return JsonResponse
     */
    public function getCentros(): JsonResponse
    {
        try {
            $centros = $this->mcentros->get();
            return response()->json($centros);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener centros: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener servicios filtrados por sede
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFromSede(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'sede_id' => 'required|integer|exists:sedes,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de sede inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $servicios = $this->mservicios->getFromSede($request->all());
            return response()->json($servicios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicios por sede: ' . $e->getMessage()
            ], 500);
        }
    }
}