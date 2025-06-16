<?php

namespace App\Http\Controllers\orden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Mordenes;
use App\Models\Mequipos;
use App\Models\Mdiagnosticos;
use App\Models\Mcierres;
use App\Models\Musuarios;
use App\Models\Mrepuestos_ti;
use App\Models\Mempresas;
use App\Models\Mzonas;
use App\Models\Mavances_correctivos;
use App\Models\Mcambios_hdv;
use App\Models\Mcorrectivos_generales;
use App\Models\Mpreventivos;
use App\Models\Mobservaciones;

/**
 * Controlador de Órdenes de Trabajo - Migrado completamente a Laravel 11
 * Sistema HUV - Hospital Universitario del Valle
 *
 * Gestiona el ciclo completo de órdenes de trabajo:
 * - Creación y asignación de tickets
 * - Diagnósticos y reparaciones
 * - Seguimiento y cierre de órdenes
 * - Notificaciones por email
 * - Gestión de repuestos y archivos
 */
class Cordenes extends Controller
{
    protected $mordenes;
    protected $mequipos;
    protected $musuarios;
    protected $mrepuestos_ti;
    protected $mempresas;
    protected $mcambios_hdv;
    protected $permisos;

    public function __construct()
    {
        $this->mordenes = new Mordenes();
        $this->mequipos = new Mequipos();
        $this->musuarios = new Musuarios();
        $this->mrepuestos_ti = new Mrepuestos_ti();
        $this->mempresas = new Mempresas();
        $this->mcambios_hdv = new Mcambios_hdv();
        $this->permisos = [];
    }
    /**
     * Mostrar lista de órdenes propias del usuario
     */
    public function index(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Verificar permisos
        if (!$this->hasPermission('tickets propios', 'leer')) {
            return redirect()->route('forbidden');
        }

        try {
            $data = [
                'permisos' => $this->getPermissions(),
                'user' => $this->getCurrentUser(),
                'stats' => $this->getOrderStats()
            ];

            Session::put("editar_orden", "no");
            Session::put('controlador', 'ordenes');

            return view('ordenes.list', $data);

        } catch (\Exception $e) {
            Log::error('Error en index de órdenes: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar las órdenes']);
        }
    }
    /**
     * Mostrar lista de órdenes activas
     */
    public function listActive(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Verificar permisos
        if (!$this->hasPermission('tickets activos', 'leer')) {
            return redirect()->route('forbidden');
        }

        try {
            $data = [
                'permisos' => $this->getPermissions(),
                'user' => $this->getCurrentUser(),
                'stats' => $this->getActiveOrderStats()
            ];

            Session::put("editar_orden", "si");
            Session::put('controlador', 'ordenes_activas');

            return view('ordenes.list_active', $data);

        } catch (\Exception $e) {
            Log::error('Error en listActive: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar órdenes activas']);
        }
    }

    /**
     * Mostrar lista de órdenes cerradas
     */
    public function listClosed(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Verificar permisos
        if (!$this->hasPermission('tickets cerrados', 'leer')) {
            return redirect()->route('forbidden');
        }

        try {
            $data = [
                'permisos' => $this->getPermissions(),
                'user' => $this->getCurrentUser(),
                'stats' => $this->getClosedOrderStats()
            ];

            Session::put("editar_orden", "no");
            Session::put('controlador', 'ordenes_cerradas');

            return view('ordenes.list_closed', $data);

        } catch (\Exception $e) {
            Log::error('Error en listClosed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar órdenes cerradas']);
        }
    }
    /**
     * Obtener órdenes por dispositivo/equipo
     */
    public function getByDevice(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'equipo_id' => 'required|integer|exists:equipos,id'
            ]);

            $ordenes = $this->mordenes->getByDevice($data);

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'count' => count($ordenes)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getByDevice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes por dispositivo'
            ], 500);
        }
    }

    /**
     * Obtener órdenes propias del usuario actual
     */
    public function getOwn(): JsonResponse
    {
        try {
            $ordenes = $this->mordenes->getOwn();

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'count' => count($ordenes)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOwn: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes propias'
            ], 500);
        }
    }

    /**
     * Obtener una orden específica
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:ordenes,id'
            ]);

            $orden = $this->mordenes->getOne($data);

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $orden
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOne: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener orden'
            ], 500);
        }
    }

    /**
     * Obtener una orden con sus repuestos
     */
    public function getOneWithRepuestos(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:ordenes,id'
            ]);

            $orden = $this->mordenes->getOne($data);
            $repuestos = $this->mrepuestos_ti->get($data);

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'orden' => $orden,
                    'repuestos' => $repuestos
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOneWithRepuestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener orden con repuestos'
            ], 500);
        }
    }
    /**
     * Obtener órdenes activas con filtros de fecha
     */
    public function getActive(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            // Procesar rango de fechas
            if (isset($data["rango_fechas"])) {
                $fecha = explode(" - ", $data["rango_fechas"]);
                if (isset($fecha[1])) {
                    unset($data["rango_fechas"]);
                    $data["inicial"] = $fecha[0];
                    $data["final"] = $fecha[1];
                } else {
                    $data["inicial"] = now()->format("Y-m-d");
                    $data["final"] = now()->format("Y-m-d");
                }
            } else {
                $data["inicial"] = now()->format("Y-m-d");
                $data["final"] = now()->format("Y-m-d");
            }

            $ordenes = $this->mordenes->getActive($data);

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'count' => count($ordenes),
                'filters' => [
                    'fecha_inicial' => $data["inicial"],
                    'fecha_final' => $data["final"]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getActive: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes activas'
            ], 500);
        }
    }

    /**
     * Obtener órdenes asignadas a un usuario
     */
    public function getAsignadas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            // Validar user_id
            if (!isset($data["user_id"])) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de usuario requerido'
                ], 400);
            }

            // Procesar rango de fechas
            if (isset($data["rango_fechas"])) {
                $fecha = explode(" - ", $data["rango_fechas"]);
                if (isset($fecha[1])) {
                    unset($data["rango_fechas"]);
                    $data["inicial"] = $fecha[0];
                    $data["final"] = $fecha[1];
                } else {
                    $data["inicial"] = now()->format("Y-m-d");
                    $data["final"] = now()->format("Y-m-d");
                }
            } else {
                $data["inicial"] = now()->format("Y-m-d");
                $data["final"] = now()->format("Y-m-d");
            }

            // Obtener empresa del usuario
            $usuario = $this->musuarios->getOne(['id' => $data["user_id"]]);
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            $idEmpresa = $usuario->id_empresa;
            $ordenes = $this->mordenes->getAsignadas($idEmpresa, $data);

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'count' => count($ordenes),
                'empresa_id' => $idEmpresa
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getAsignadas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes asignadas'
            ], 500);
        }
    }

    /**
     * Obtener órdenes cerradas
     */
    public function getClosed(): JsonResponse
    {
        try {
            $ordenes = $this->mordenes->getClosed();

            return response()->json([
                'success' => true,
                'data' => $ordenes,
                'count' => count($ordenes)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getClosed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes cerradas'
            ], 500);
        }
    }

    /**
     * Buscar equipos por serie
     */
    public function getLikeSerie(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'serie' => 'required|string|min:2'
            ]);

            $equipos = $this->mequipos->getLikeSerie($data);

            return response()->json([
                'success' => true,
                'data' => $equipos,
                'count' => count($equipos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getLikeSerie: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar equipos por serie'
            ], 500);
        }
    }

    /**
     * Buscar equipos por código
     */
    public function getLikeCodigo(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'codigo' => 'required|string|min:2'
            ]);

            $equipos = $this->mequipos->getLikeCodigo($data);

            return response()->json([
                'success' => true,
                'data' => $equipos,
                'count' => count($equipos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getLikeCodigo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar equipos por código'
            ], 500);
        }
    }

    /**
     * Obtener repuestos de una orden
     */
    public function getRepuestos(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'orden_id' => 'required|integer|exists:ordenes,id'
            ]);

            $repuestos = $this->mrepuestos_ti->get($data);

            return response()->json([
                'success' => true,
                'data' => $repuestos,
                'count' => count($repuestos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getRepuestos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener repuestos'
            ], 500);
        }
    }
    /**
     * Crear nueva orden de trabajo
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            // Validaciones
            $rules = [
                'descripcion' => 'required|string|min:30|max:1000',
                'asunto' => 'required|string|min:10|max:200',
                'empresa_id' => 'required|integer|exists:empresas,id',
                'prioridad' => 'nullable|integer|in:1,2,3,4,5',
                'tipo_orden' => 'nullable|string|in:correctivo,preventivo,calibracion'
            ];

            // Validar equipo si no se proporciona ID
            if (empty($data["equipo_id"])) {
                $rules['nombre_equipo'] = 'required|string|min:5|max:100';
                $rules['marca_equipo'] = 'required|string|min:2|max:50';
                $rules['modelo_equipo'] = 'nullable|string|max:50';
                $rules['serie_equipo'] = 'nullable|string|max:50';
                $data["equipo_id"] = null;
            } else {
                $rules['equipo_id'] = 'required|integer|exists:equipos,id';
            }

            // Validar archivo si se envía
            if ($request->hasFile('image')) {
                $rules['image'] = 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'; // 10MB max
            }

            $validator = Validator::make($data, $rules, [
                'descripcion.required' => 'La descripción es obligatoria',
                'descripcion.min' => 'La descripción debe tener al menos 30 caracteres',
                'asunto.required' => 'El asunto es obligatorio',
                'asunto.min' => 'El asunto debe tener al menos 10 caracteres',
                'empresa_id.required' => 'La empresa es obligatoria',
                'empresa_id.exists' => 'La empresa seleccionada no existe',
                'nombre_equipo.required' => 'El nombre del equipo es obligatorio cuando no se selecciona un equipo existente',
                'marca_equipo.required' => 'La marca del equipo es obligatoria',
                'image.mimes' => 'El archivo debe ser una imagen o documento válido',
                'image.max' => 'El archivo no debe superar los 10MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Preparar datos para inserción
            $data["reportante_id"] = Session::get("id");
            $data["fecha_inicio"] = now();
            $data["estado_id"] = 1; // Estado inicial: Creada

            // Guardar empresa_id en sesión para el email
            Session::put("empresa_id", $data["empresa_id"]);

            // Limpiar datos innecesarios
            unset($data["seleccionado"], $data["seleccion_reportante"]);

            // Manejo de archivo
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_correctivos_generales');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $data["image"] = $filename;
            }

            // Crear la orden
            $ordenId = $this->mordenes->add($data);
            $ordenCreada = $this->mordenes->getOne(["id" => $ordenId]);

            // Registrar en historial de cambios
            $descripcionHistorial = "Se crea Ticket con ID = " . $ordenCreada->id . " por " . Session::get('nombre') . " " . Session::get('apellido');
            $vectorCambiosHdv = [
                "descripcion" => $descripcionHistorial,
                "usuario_id" => Session::get("id"),
                "equipo_id" => $ordenCreada->equipo_id,
                "fecha" => now()
            ];

            $this->mcambios_hdv->add($vectorCambiosHdv);

            DB::commit();

            Log::info('Orden creada exitosamente', [
                'orden_id' => $ordenId,
                'reportante_id' => Session::get("id"),
                'empresa_id' => $data["empresa_id"]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Orden creada exitosamente',
                'data' => [
                    'orden_id' => $ordenId,
                    'ticket_number' => $ordenCreada->id
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear orden: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la orden',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualización general de orden
     */
    public function updateGeneral(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:ordenes,id',
                'asunto' => 'nullable|string|max:200',
                'descripcion' => 'nullable|string|max:1000',
                'prioridad' => 'nullable|integer|in:1,2,3,4,5',
                'estado_id' => 'nullable|integer|exists:estados,id'
            ]);

            DB::beginTransaction();

            $data['updated_at'] = now();
            $this->mordenes->update($data);

            DB::commit();

            Log::info('Orden actualizada', [
                'orden_id' => $data['id'],
                'updated_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar orden: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar orden'
            ], 500);
        }
    }

    /**
     * Métodos auxiliares para verificación de permisos y datos del usuario
     */
    private function hasPermission(string $modulo, string $accion): bool
    {
        $acciones = Session::get("acciones", []);

        foreach ($acciones as $accionObj) {
            if ($accionObj->modulo == $modulo) {
                return $accionObj->$accion == 1;
            }
        }

        return false;
    }

    private function getCurrentUser(): array
    {
        return [
            'id' => Session::get('id'),
            'nombre' => Session::get('nombre'),
            'apellido' => Session::get('apellido'),
            'email' => Session::get('email'),
            'rol_id' => Session::get('rol_id'),
            'sede_id' => Session::get('sede_id')
        ];
    }

    private function getPermissions(): array
    {
        return Session::get('acciones', []);
    }

    private function getOrderStats(): array
    {
        try {
            return [
                'total' => $this->mordenes->getTotalCount(),
                'activas' => $this->mordenes->getActiveCount(),
                'cerradas' => $this->mordenes->getClosedCount(),
                'propias' => $this->mordenes->getOwnCount()
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas: ' . $e->getMessage());
            return ['total' => 0, 'activas' => 0, 'cerradas' => 0, 'propias' => 0];
        }
    }

    private function getActiveOrderStats(): array
    {
        try {
            return [
                'pendientes' => $this->mordenes->getPendingCount(),
                'en_proceso' => $this->mordenes->getInProcessCount(),
                'diagnosticadas' => $this->mordenes->getDiagnosedCount()
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas activas: ' . $e->getMessage());
            return ['pendientes' => 0, 'en_proceso' => 0, 'diagnosticadas' => 0];
        }
    }

    private function getClosedOrderStats(): array
    {
        try {
            return [
                'cerradas_hoy' => $this->mordenes->getClosedTodayCount(),
                'cerradas_semana' => $this->mordenes->getClosedWeekCount(),
                'cerradas_mes' => $this->mordenes->getClosedMonthCount()
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas cerradas: ' . $e->getMessage());
            return ['cerradas_hoy' => 0, 'cerradas_semana' => 0, 'cerradas_mes' => 0];
        }
    }
    /**
     * Enviar email de notificación de creación de orden
     */
    public function emailAddOrden(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:ordenes,id'
            ]);

            $empresaId = Session::get("empresa_id");

            if (!$empresaId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró información de la empresa'
                ], 400);
            }

            // Obtener datos necesarios
            $empresa = $this->mordenes->getOneEmpresa($empresaId);
            $datosUsuarios = $this->mordenes->getUsuarioEmpresa($empresaId);
            $countUsuarios = $this->mordenes->getCount($empresaId);
            $orden = $this->mordenes->getOne($data);

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            // Preparar datos para el email
            $vectorOrden = [
                "empresa" => $empresa,
                "orden" => $orden,
                "fecha_envio" => now()->format('d/m/Y H:i:s'),
                "usuario_reportante" => $this->getCurrentUser()
            ];

            // Agregar información del equipo si existe
            if ($orden->equipo_id && $orden->equipo_id != 0) {
                $equipo = $this->mequipos->getOne(["id" => $orden->equipo_id]);
                $vectorOrden["equipo"] = $equipo;
            }

            // Construir lista de destinatarios
            $destinatarios = [];
            if ($datosUsuarios && $countUsuarios > 0) {
                for ($i = 0; $i < $countUsuarios; $i++) {
                    if (!empty($datosUsuarios[$i]->email_empresa)) {
                        $destinatarios[] = trim($datosUsuarios[$i]->email_empresa);
                    }
                }
            }

            if (empty($destinatarios)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron destinatarios para el email'
                ], 400);
            }

            // Enviar email
            Mail::send('ordenes.email_creacion', $vectorOrden, function ($message) use ($destinatarios, $orden, $data) {
                $message->from(config('mail.from.address', 'evagestionahuv@gmail.com'), 'Electromedicina HUV');
                $message->to($destinatarios);

                // Copia al reportante si tiene email
                if (!empty($orden->email)) {
                    $message->cc($orden->email);
                }

                $message->subject('Creación de Ticket Nro ' . $data["id"] . ' - ' . $orden->asunto);

                // Adjuntar imagen si existe
                if (!empty($orden->image)) {
                    $imagePath = public_path("assets/upload_correctivos_generales/" . $orden->image);
                    if (File::exists($imagePath)) {
                        $message->attach($imagePath);
                    }
                }

                // Adjuntar template si existe
                $templatePath = public_path("assets/template/3.jpg");
                if (File::exists($templatePath)) {
                    $message->attach($templatePath);
                }
            });

            Log::info('Email de creación de orden enviado', [
                'orden_id' => $data["id"],
                'destinatarios' => count($destinatarios),
                'empresa_id' => $empresaId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente',
                'destinatarios' => count($destinatarios)
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar email de creación: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar email: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Actualizar diagnóstico de orden
     */
    public function updateDiagnoseOrden(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $ordenId = $data["id"] ?? null;

            if (!$ordenId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de orden requerido'
                ], 400);
            }

            // Validaciones
            $rules = [
                'id' => 'required|integer|exists:ordenes,id',
                'diagnostico' => 'required|string|min:12|max:2000',
                'retro_diagnostico' => 'required|string|min:4|max:500',
                'fecha_diagnostico' => 'nullable|date',
                'hora_diagnostico' => 'nullable|date_format:H:i',
                'repuestos' => 'nullable|array',
                'repuestos.*' => 'nullable|string|max:200',
                'file_diagnostico' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
            ];

            $validator = Validator::make($data, $rules, [
                'diagnostico.required' => 'El diagnóstico es obligatorio',
                'diagnostico.min' => 'El diagnóstico debe tener al menos 12 caracteres',
                'retro_diagnostico.required' => 'La retroalimentación del diagnóstico es obligatoria',
                'retro_diagnostico.min' => 'La retroalimentación debe tener al menos 4 caracteres',
                'file_diagnostico.mimes' => 'El archivo debe ser una imagen o documento válido',
                'file_diagnostico.max' => 'El archivo no debe superar los 10MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Verificar que la orden existe y puede ser diagnosticada
            $orden = $this->mordenes->getOne(['id' => $ordenId]);
            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            // Procesar repuestos si se proporcionan
            if (isset($data["repuestos"]) && is_array($data["repuestos"])) {
                foreach ($data["repuestos"] as $repuesto) {
                    if (!empty(trim($repuesto))) {
                        $vectorIngreso = [
                            "name" => trim($repuesto),
                            "orden_id" => $ordenId,
                            "fecha_solicitud" => now(),
                            "estado" => 'solicitado'
                        ];
                        $this->mrepuestos_ti->add($vectorIngreso);
                    }
                }
                unset($data["repuestos"]);
            }

            // Manejo de archivo de diagnóstico
            if ($request->hasFile('file_diagnostico')) {
                $file = $request->file('file_diagnostico');
                $filename = time() . '_diagnostico_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_correctivos_generales');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $data["file_diagnostico"] = $filename;
            }

            // Procesar fecha y hora de diagnóstico
            if (isset($data["fecha_diagnostico"])) {
                if (isset($data["hora_diagnostico"])) {
                    $data["fecha_diagnostico"] = $data["fecha_diagnostico"] . " " . $data["hora_diagnostico"];
                    unset($data["hora_diagnostico"]);
                }
            } else {
                $data["fecha_diagnostico"] = now();
                unset($data["hora_diagnostico"]);
            }

            // Establecer técnico y estado
            $data["tecnico_diagnostico"] = Session::get("id");
            $data["estado_id"] = 3; // Estado: Diagnosticada
            $data["updated_at"] = now();

            // Actualizar la orden
            $this->mordenes->update($data);

            // Registrar en historial
            $descripcionHistorial = "Diagnóstico realizado por " . Session::get('nombre') . " " . Session::get('apellido');
            $vectorCambiosHdv = [
                "descripcion" => $descripcionHistorial,
                "usuario_id" => Session::get("id"),
                "equipo_id" => $orden->equipo_id,
                "fecha" => now()
            ];
            $this->mcambios_hdv->add($vectorCambiosHdv);

            DB::commit();

            Log::info('Diagnóstico actualizado exitosamente', [
                'orden_id' => $ordenId,
                'tecnico_id' => Session::get("id")
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Diagnóstico actualizado exitosamente',
                'data' => [
                    'orden_id' => $ordenId,
                    'estado' => 'diagnosticada'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar diagnóstico: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar diagnóstico',
                'error' => $e->getMessage()
            ], 500);
        }
    }
  public function update_diagnose_orden_email()
  {
    $orden = $this->Mordenes->getOne(array("id" => $_POST["id"]));
    $empresa_id = $orden->empresa_id;
    $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
    $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id));
    $reportante = $this->Musuarios->getOne($orden->reportante_id);
    $asignado = $this->Musuarios->getOne($orden->asignado_id);
    $usuario_actual = $this->Musuarios->getOne($this->session->userdata("id"));
    $repuestos = $this->Mrepuestos_ti->get(array("id" => $orden->id));
    $vector = array(
      "orden" => $orden,
      "empresa" => $empresa,
      "correos_empresa" => $correos_empresa,
      "reportante" => $reportante,
      "asignado" => $asignado,
      "usuario_actual" => $usuario_actual,
      "repuestos" => $repuestos
    );
    if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
      $vector["equipo"] = $this->Mequipos->getOne(array("id" => $orden->equipo_id));
    }
    $to = "";
    $contador = 0;
    $limite = $correos_empresa["cantidad"];
    $control = TRUE;
    if ($limite == 1) {
      $to .= $correos_empresa["correos_empresa"][0]->email;
    } elseif ($limite > 1) {
      foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
        $contador = $contador + 1;
        if ($contador != $limite) {
          $to .= $correo_empresa->email . ",";
        } else {
          $to .= $correo_empresa->email;
        }
      }
    } else {
      $control = !$control;
    }
    if ($control) {

      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'evagestionahuv@gmail.com',
        'smtp_pass' => 'ronrokgffjiurzio',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );
      $this->email->initialize($configGmail);
      $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
      $this->email->to($to);
      $this->email->cc($reportante->email);
      $this->email->subject('Diagnostico Ticket Nro. ' . $_POST["id"]);
      if ($orden->file_diagnostico != NULL && $orden->file_diagnostico != "") {
        $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_diagnostico, 'inline');
      }
      $msj = $this->load->view("ordenes/diagnostico_email", $vector, TRUE);

      $this->email->message($msj);
      $this->email->send();
    }
  }
    /**
     * Actualizar archivo de diagnóstico de orden
     */
    public function updateArchivoDiagnoseOrden(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:ordenes,id',
                'file_diagnostico' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
            ]);

            $ordenId = $data["id"];

            if ($request->hasFile('file_diagnostico')) {
                $file = $request->file('file_diagnostico');
                $filename = time() . '_diagnostico_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_correctivos_generales');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);

                // Actualizar solo el archivo
                $updateData = [
                    "id" => $ordenId,
                    "file_diagnostico" => $filename,
                    "updated_at" => now()
                ];

                $this->mordenes->update($updateData);

                Log::info('Archivo de diagnóstico actualizado', [
                    'orden_id' => $ordenId,
                    'filename' => $filename,
                    'updated_by' => Session::get('id')
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Archivo de diagnóstico actualizado exitosamente',
                    'data' => [
                        'orden_id' => $ordenId,
                        'filename' => $filename
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se proporcionó archivo'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error al actualizar archivo de diagnóstico: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar archivo de diagnóstico'
            ], 500);
        }
    }
}