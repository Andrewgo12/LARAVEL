<?php

namespace App\Http\Controllers\correctivo_general;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Mequipos;
use App\Models\Mcorrectivos_generales;
use App\Models\Mcorrectivos_generales_archivos;
use App\Models\Mordenes;
use App\Models\Mpreventivos;
use App\Models\Mavances_correctivos;
use App\Models\Mservicios;
use App\Models\Mzonas;
use App\Models\Mequipo_repuestos;
use App\Models\Mcambios_hdv;
use App\Models\Mrepuestos_ti;
use App\Models\Mrepuestos_pendientes;

/**
 * Controlador de Correctivos Generales - Migrado completamente a Laravel 11
 * Sistema HUV - Hospital Universitario del Valle
 *
 * Gestiona el ciclo completo de mantenimientos correctivos generales:
 * - Creación y seguimiento de correctivos
 * - Gestión de repuestos instalados y pendientes
 * - Avances y archivos de correctivos
 * - Notificaciones por email
 * - Historial de cambios y exportación
 */
class CcorrectivosGeneralesController extends Controller
{
    protected $mequipos;
    protected $mcorrectivos_generales;
    protected $mcorrectivos_generales_archivos;
    protected $mordenes;
    protected $mpreventivos;
    protected $mavances_correctivos;
    protected $mservicios;
    protected $mzonas;
    protected $mequipo_repuestos;
    protected $mcambios_hdv;
    protected $mrepuestos_ti;
    protected $mrepuestos_pendientes;

    public function __construct()
    {
        $this->mequipos = new Mequipos();
        $this->mcorrectivos_generales = new Mcorrectivos_generales();
        $this->mcorrectivos_generales_archivos = new Mcorrectivos_generales_archivos();
        $this->mordenes = new Mordenes();
        $this->mpreventivos = new Mpreventivos();
        $this->mavances_correctivos = new Mavances_correctivos();
        $this->mservicios = new Mservicios();
        $this->mzonas = new Mzonas();
        $this->mequipo_repuestos = new Mequipo_repuestos();
        $this->mcambios_hdv = new Mcambios_hdv();
        $this->mrepuestos_ti = new Mrepuestos_ti();
        $this->mrepuestos_pendientes = new Mrepuestos_pendientes();
    }
    
    /**
     * Mostrar vista principal de correctivos generales
     */
    public function index(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Verificar permisos
        if (!$this->hasPermission('correctivos_generales', 'leer')) {
            return redirect()->route('forbidden');
        }

        try {
            $data = [
                'user' => $this->getCurrentUser(),
                'permisos' => $this->getPermissions(),
                'stats' => $this->getCorrectivosStats()
            ];

            Session::put('controlador', 'correctivos_generales');

            return view('correctivos_generales.index', $data);

        } catch (\Exception $e) {
            Log::error('Error en index de correctivos generales: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar correctivos generales']);
        }
    }

    /**
     * Obtener correctivos generales con filtros
     */
    public function get(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $correctivos = $this->mcorrectivos_generales->get($data);

            return response()->json([
                'success' => true,
                'data' => $correctivos,
                'count' => count($correctivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en get correctivos generales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener correctivos generales'
            ], 500);
        }
    }

    /**
     * Obtener todos los correctivos generales
     */
    public function getAll(): JsonResponse
    {
        try {
            $correctivos = $this->mcorrectivos_generales->getAll();

            return response()->json([
                'success' => true,
                'data' => $correctivos,
                'count' => count($correctivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getAll correctivos generales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener todos los correctivos generales'
            ], 500);
        }
    }

    /**
     * Obtener un correctivo general específico
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:correctivos_generales,id'
            ]);

            $correctivo = $this->mcorrectivos_generales->getOne($data);

            if (!$correctivo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Correctivo general no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $correctivo
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOne correctivo general: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener correctivo general'
            ], 500);
        }
    }
    
    /**
     * Crear nuevo correctivo general
     */
    public function add(Request $request): JsonResponse
    {
        try {
            // Validaciones
            $validator = Validator::make($request->all(), [
                'equipo_id' => 'required|integer|exists:equipos,id',
                'titulo' => 'required|string|min:5|max:200',
                'descripcion' => 'nullable|string|max:2000',
                'fecha_inicio' => 'nullable|date',
                'hora_orden' => 'nullable|date_format:H:i',
                'fecha_diagnostico' => 'nullable|date',
                'hora_diagnostico' => 'nullable|date_format:H:i',
                'fecha_mantenimiento' => 'nullable|date',
                'hora_mantenimiento' => 'nullable|date_format:H:i',
                'repuesto_id' => 'nullable|integer|exists:repuestos,id',
                'repuesto_id_instalado' => 'nullable|integer|exists:repuestos,id',
                'cantidad_entregada' => 'nullable|integer|min:1',
                'fecha' => 'nullable|date',
                'observacion' => 'nullable|string|max:500',
                'lista_repuestos_pendientes' => 'nullable|array',
                'lista_repuestos_pendientes.*' => 'string|max:200',
                'descripcion_avance' => 'nullable|string|max:1000',
                'fecha_avance' => 'nullable|date',
                'titulo_avance' => 'nullable|string|max:200',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
                'file_repuesto_instalado' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
            ], [
                'equipo_id.required' => 'El equipo es obligatorio',
                'equipo_id.exists' => 'El equipo seleccionado no existe',
                'titulo.required' => 'El título es obligatorio',
                'titulo.min' => 'El título debe tener al menos 5 caracteres',
                'file.mimes' => 'El archivo debe ser una imagen o documento válido',
                'file.max' => 'El archivo no debe superar los 10MB',
                'file_repuesto_instalado.mimes' => 'El archivo de repuesto debe ser una imagen o documento válido',
                'file_repuesto_instalado.max' => 'El archivo de repuesto no debe superar los 10MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $data = $request->all();
            $data['usuario_id'] = Session::get('id');
            $data['fecha_creacion'] = now();

            // Extraer datos específicos
            $listaRepuestosPendientes = $data["lista_repuestos_pendientes"] ?? null;
            $titulo = $data["titulo"];
            unset($data["lista_repuestos_pendientes"], $data["titulo"]);

            // Manejo de archivo de repuesto instalado
            $fileRepuestoInstalado = null;
            if ($request->hasFile('file_repuesto_instalado')) {
                $file = $request->file('file_repuesto_instalado');
                $fileName = time() . '_repuesto_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_equipo_repuestos');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $fileRepuestoInstalado = $fileName;
            }

            // Procesar repuesto instalado
            if (!empty($data["repuesto_id_instalado"])) {
                $vectorRepuestoInstalado = [
                    "repuesto_id" => $data["repuesto_id_instalado"],
                    "equipo_id" => $data["equipo_id"],
                    "cantidad_entregada" => $data["cantidad_entregada"] ?? 1,
                    "fecha" => $data["fecha"] ?? now(),
                    "file" => $fileRepuestoInstalado,
                    "observacion" => $data["observacion"] ?? '',
                    "usuario_id" => Session::get("id"),
                    "created_at" => now(),
                    "updated_at" => now()
                ];
                $this->mequipo_repuestos->add($vectorRepuestoInstalado);
            }

            // Limpiar datos de repuesto instalado
            unset($data["repuesto_id_instalado"], $data["cantidad_entregada"], $data["fecha"], $data["observacion"]);

            // Manejo de archivo principal
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_correctivo_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_correctivos_generales');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $data["file"] = $fileName;
            }

            // Formateo de fechas
            if (isset($data["fecha_inicio"]) && isset($data["hora_orden"])) {
                $data["fecha_inicio"] = $data["fecha_inicio"] . " " . $data["hora_orden"];
                unset($data["hora_orden"]);
            }

            if (isset($data["fecha_diagnostico"]) && isset($data["hora_diagnostico"])) {
                $data["fecha_diagnostico"] = $data["fecha_diagnostico"] . " " . $data["hora_diagnostico"];
                unset($data["hora_diagnostico"]);
            }

            if (isset($data["fecha_mantenimiento"]) && isset($data["hora_mantenimiento"])) {
                $data["fecha_mantenimiento"] = $data["fecha_mantenimiento"] . " " . $data["hora_mantenimiento"];
                unset($data["hora_mantenimiento"]);
            }

            // Manejo de repuesto pendiente
            $vectorActualizacionEquipo = null;
            if (!empty($data["repuesto_id"])) {
                $data["repuesto_pendiente"] = "si";
                $vectorActualizacionEquipo = [
                    "id" => $data["equipo_id"],
                    "repuesto_pendiente" => "si",
                    "updated_at" => now()
                ];
                $this->mequipos->update($vectorActualizacionEquipo);
            } else {
                unset($data["repuesto_id"]);
                $data["repuesto_pendiente"] = "no";
            }

            // Lógica para ingresar avance
            $existeDescripcion = false;
            $vectorAvanceCorrectivo = null;

            if (!empty($data["descripcion_avance"])) {
                $existeDescripcion = true;
                $vectorAvanceCorrectivo = [
                    "description" => $data["descripcion_avance"],
                    "date" => $data["fecha_avance"] ?? now(),
                    "title" => $data["titulo_avance"] ?? 'Avance inicial',
                    "usuario_id" => Session::get("id"),
                    "file" => $data["file"] ?? '',
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }

            // Limpiar datos de avance
            unset($data["descripcion_avance"], $data["fecha_avance"], $data["titulo_avance"]);

            // Crear correctivo general
            $ultimoId = $this->mcorrectivos_generales->add($data);
            $correctivoCreado = $this->mcorrectivos_generales->getOne(["id" => $ultimoId]);

            // Agregar repuestos pendientes
            if ($listaRepuestosPendientes && is_array($listaRepuestosPendientes)) {
                foreach ($listaRepuestosPendientes as $repuestoPendiente) {
                    if (!empty(trim($repuestoPendiente))) {
                        $this->mrepuestos_pendientes->add([
                            "correctivo_general_id" => $ultimoId,
                            "name" => trim($repuestoPendiente),
                            "estado" => 'pendiente',
                            "created_at" => now(),
                            "updated_at" => now()
                        ]);
                    }
                }
            }

            // Agregar avance si existe
            if ($existeDescripcion && $vectorAvanceCorrectivo) {
                $vectorAvanceCorrectivo["correctivo_general_id"] = $ultimoId;
                $this->mavances_correctivos->add($vectorAvanceCorrectivo);
            }

            // Registrar en historial
            $descripcionHistorial = "Se agrega correctivo general con ID = " . $correctivoCreado->id . " por " . Session::get('nombre') . " " . Session::get('apellido');
            $vectorCambiosHdv = [
                "descripcion" => $descripcionHistorial,
                "usuario_id" => Session::get("id"),
                "equipo_id" => $correctivoCreado->equipo_id,
                "fecha" => now()
            ];
            $this->mcambios_hdv->add($vectorCambiosHdv);

            // Agregar archivo si existe
            if (isset($data["file"])) {
                $vectorArchivo = [
                    "file" => $data["file"],
                    "correctivo_general_id" => $ultimoId,
                    "titulo" => $titulo,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
                $this->mcorrectivos_generales_archivos->add($vectorArchivo);
            }

            DB::commit();

            Log::info('Correctivo general creado exitosamente', [
                'correctivo_id' => $ultimoId,
                'equipo_id' => $data["equipo_id"],
                'usuario_id' => Session::get("id")
            ]);

            // Preparar respuesta
            $vectorRespuesta = [
                "success" => true,
                "message" => "Correctivo general creado exitosamente",
                "correctivo_general_id" => $ultimoId,
                "equipo_id" => $data["equipo_id"]
            ];

            if ($vectorActualizacionEquipo) {
                $vectorRespuesta["repuesto_pendiente"] = $data["repuesto_id"] ?? null;
            }

            return response()->json($vectorRespuesta);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear correctivo general: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear correctivo general',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Enviar email de notificación de correctivo general
     */
    public function sendEmailCorrectivoGeneral(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'equipo_id' => 'required|integer|exists:equipos,id',
                'correctivo_general_id' => 'required|integer|exists:correctivos_generales,id'
            ]);

            // Obtener datos necesarios
            $equipo = $this->mequipos->getOne(["id" => $data["equipo_id"]]);
            $correctivoGeneral = $this->mcorrectivos_generales->getOne(["id" => $data["correctivo_general_id"]]);

            if (!$equipo || !$correctivoGeneral) {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipo o correctivo general no encontrado'
                ], 404);
            }

            $servicio = $this->mservicios->getOne(["id" => $equipo->servicio_id]);
            $correos = $this->mzonas->get_emails_with_service(["servicio_id" => $servicio->id]);

            // Construir lista de destinatarios
            $destinatarios = [];
            $limite = $correos["cantidad"] ?? 0;

            if ($limite == 1) {
                $destinatarios[] = $correos["correos"][0]->correo_usuario;
            } elseif ($limite > 1) {
                foreach ($correos["correos"] as $correo) {
                    if (!empty($correo->correo_usuario)) {
                        $destinatarios[] = trim($correo->correo_usuario);
                    }
                }
            }

            if (empty($destinatarios)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay correos válidos para enviar'
                ], 400);
            }

            // Preparar datos para el email
            $vectorCorreo = [
                "equipo" => $equipo,
                "correctivo_general" => $correctivoGeneral,
                "correos" => $correos,
                "servicio" => $servicio,
                "fecha_envio" => now()->format('d/m/Y H:i:s'),
                "usuario_notificador" => $this->getCurrentUser()
            ];

            // Enviar email
            Mail::send('correctivos_generales.email.email_add_correctivo_general', $vectorCorreo, function ($message) use ($destinatarios, $correctivoGeneral) {
                $message->from(config('mail.from.address', 'evagestionahuv@gmail.com'), 'Correctivo General HUV');
                $message->to($destinatarios);
                $message->subject("Notificación de repuesto pendiente - ID correctivo: " . $correctivoGeneral->id);

                // Adjuntar archivos si existen
                if (!empty($correctivoGeneral->file)) {
                    $filePath = public_path("assets/upload_correctivos_generales/" . $correctivoGeneral->file);
                    if (File::exists($filePath)) {
                        $message->attach($filePath);
                    }
                }
            });

            Log::info('Email de correctivo general enviado', [
                'correctivo_id' => $data["correctivo_general_id"],
                'equipo_id' => $data["equipo_id"],
                'destinatarios' => count($destinatarios)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente',
                'destinatarios' => count($destinatarios)
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar email de correctivo general: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar email: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar correctivo general
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $correctivoGeneralId = $data["id"] ?? null;

            if (!$correctivoGeneralId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de correctivo general requerido'
                ], 400);
            }

            // Validaciones
            $validator = Validator::make($data, [
                'id' => 'required|integer|exists:correctivos_generales,id',
                'titulo' => 'nullable|string|min:5|max:200',
                'descripcion' => 'nullable|string|max:2000',
                'fecha_inicio' => 'nullable|date',
                'hora_orden' => 'nullable|date_format:H:i',
                'fecha_diagnostico' => 'nullable|date',
                'hora_diagnostico' => 'nullable|date_format:H:i',
                'fecha_mantenimiento' => 'nullable|date',
                'hora_mantenimiento' => 'nullable|date_format:H:i',
                'repuesto_id' => 'nullable|integer|exists:repuestos,id',
                'lista_repuestos_pendientes' => 'nullable|array',
                'lista_repuestos_pendientes.*' => 'string|max:200',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
            ], [
                'titulo.min' => 'El título debe tener al menos 5 caracteres',
                'file.mimes' => 'El archivo debe ser una imagen o documento válido',
                'file.max' => 'El archivo no debe superar los 10MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Obtener correctivo actual
            $correctivoGeneralAntiguo = $this->mcorrectivos_generales->getOne(["id" => $correctivoGeneralId]);
            if (!$correctivoGeneralAntiguo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Correctivo general no encontrado'
                ], 404);
            }

            // Manejo de repuestos pendientes
            if (isset($data["lista_repuestos_pendientes"]) && is_array($data["lista_repuestos_pendientes"])) {
                foreach ($data["lista_repuestos_pendientes"] as $repuestoPendiente) {
                    if (!empty(trim($repuestoPendiente))) {
                        $this->mrepuestos_pendientes->add([
                            "correctivo_general_id" => $correctivoGeneralId,
                            "name" => trim($repuestoPendiente),
                            "estado" => 'pendiente',
                            "created_at" => now(),
                            "updated_at" => now()
                        ]);
                    }
                }
                unset($data["lista_repuestos_pendientes"]);
            }

            $titulo = $data["titulo"] ?? '';
            unset($data["titulo"]);

            // Formateo de fechas
            if (isset($data["fecha_inicio"]) && isset($data["hora_orden"])) {
                $data["fecha_inicio"] = $data["fecha_inicio"] . " " . $data["hora_orden"];
                unset($data["hora_orden"]);
            }

            if (isset($data["fecha_diagnostico"]) && isset($data["hora_diagnostico"])) {
                $data["fecha_diagnostico"] = $data["fecha_diagnostico"] . " " . $data["hora_diagnostico"];
                unset($data["hora_diagnostico"]);
            }

            if (isset($data["fecha_mantenimiento"]) && isset($data["hora_mantenimiento"])) {
                $data["fecha_mantenimiento"] = $data["fecha_mantenimiento"] . " " . $data["hora_mantenimiento"];
                unset($data["hora_mantenimiento"]);
            }

            unset($data["repuesto_pendiente"]);

            // Verificar cambios en repuesto pendiente
            $cambio = "no";
            $repuestoIdActual = $data["repuesto_id"] ?? null;
            $repuestoIdAntiguo = $correctivoGeneralAntiguo->repuesto_id;

            if ($repuestoIdActual != $repuestoIdAntiguo && !empty($repuestoIdActual)) {
                $cambio = "si";
            }

            $data['updated_at'] = now();

            // Actualizar correctivo
            $this->mcorrectivos_generales->update($data);

            // Registrar en historial
            $descripcionHistorial = "Se edita correctivo general con ID = " . $correctivoGeneralId . " por " . Session::get('nombre') . " " . Session::get('apellido');
            $vectorCambiosHdv = [
                "descripcion" => $descripcionHistorial,
                "usuario_id" => Session::get("id"),
                "equipo_id" => $data["equipo_id"],
                "fecha" => now()
            ];
            $this->mcambios_hdv->add($vectorCambiosHdv);

            // Manejo de archivo
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_correctivo_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_correctivos_generales');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);

                $vectorArchivo = [
                    "file" => $fileName,
                    "correctivo_general_id" => $correctivoGeneralId,
                    "titulo" => $titulo,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
                $this->mcorrectivos_generales_archivos->add($vectorArchivo);
            }

            DB::commit();

            Log::info('Correctivo general actualizado exitosamente', [
                'correctivo_id' => $correctivoGeneralId,
                'equipo_id' => $data["equipo_id"],
                'usuario_id' => Session::get("id")
            ]);

            // Preparar respuesta
            $vectorRespuesta = [
                "success" => true,
                "message" => "Correctivo general actualizado exitosamente",
                "equipo_id" => $data["equipo_id"],
                "correctivo_general_id" => $correctivoGeneralId,
                "cambio" => $cambio,
                "actual" => $repuestoIdActual,
                "antiguo" => $repuestoIdAntiguo
            ];

            return response()->json($vectorRespuesta);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar correctivo general: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar correctivo general',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar correctivo general
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:correctivos_generales,id',
                'equipo_id' => 'required|integer|exists:equipos,id'
            ]);

            DB::beginTransaction();

            // Obtener correctivo antes de eliminar
            $correctivoGeneral = $this->mcorrectivos_generales->getOne(["id" => $data["id"]]);
            if (!$correctivoGeneral) {
                return response()->json([
                    'success' => false,
                    'message' => 'Correctivo general no encontrado'
                ], 404);
            }

            $equipoId = $data["equipo_id"];

            // Eliminar archivos asociados
            $resultados = $this->mcorrectivos_generales_archivos->getAll($data);
            foreach ($resultados as $resultado) {
                if ($this->mcorrectivos_generales_archivos->delete($resultado->id)) {
                    $filePath = public_path('assets/upload_correctivos_generales/' . $resultado->file);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            // Eliminar correctivo general
            if ($this->mcorrectivos_generales->delete($data)) {
                // Registrar en historial
                $descripcionHistorial = "Se elimina correctivo general con ID = " . $correctivoGeneral->id . " por " . Session::get('nombre') . " " . Session::get('apellido');
                $vectorCambiosHdv = [
                    "descripcion" => $descripcionHistorial,
                    "usuario_id" => Session::get("id"),
                    "equipo_id" => $correctivoGeneral->equipo_id,
                    "fecha" => now()
                ];
                $this->mcambios_hdv->add($vectorCambiosHdv);

                // Actualizar estado de repuesto pendiente del equipo
                $cantidadCorrectivosGenerales = $this->mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipoId)->total ?? 0;
                $cantidadPreventivos = $this->mpreventivos->cuenta_registros_repuestos_pendientes($equipoId)->total ?? 0;
                $suma = $cantidadPreventivos + $cantidadCorrectivosGenerales;

                if ($suma > 0) {
                    $this->mequipos->repuesto_pendiente_true($equipoId);
                } else {
                    $this->mequipos->repuesto_pendiente_false($equipoId);
                }

                DB::commit();

                Log::info('Correctivo general eliminado exitosamente', [
                    'correctivo_id' => $data["id"],
                    'equipo_id' => $equipoId,
                    'usuario_id' => Session::get("id")
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Correctivo general eliminado correctamente',
                    'repuestos_pendientes' => $suma
                ]);
            }

            throw new \Exception('Error al eliminar el correctivo general de la base de datos');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar correctivo general: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el correctivo general',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mostrar vista de detalles de correctivos generales
     */
    public function show(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        try {
            $correctivos = $this->mcorrectivos_generales->getCorrectivosModal();

            $data = [
                'correctivos' => $correctivos,
                'user' => $this->getCurrentUser(),
                'permisos' => $this->getPermissions(),
                'total_correctivos' => count($correctivos)
            ];

            return view("correctivos_generales.detail", $data);

        } catch (\Exception $e) {
            Log::error('Error en show correctivos generales: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar detalles de correctivos generales']);
        }
    }

    /**
     * Mostrar un correctivo general específico
     */
    public function showOne(Request $request): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:correctivos_generales,id'
            ]);

            $data["correctivo_general_id"] = $data["id"];

            $correctivo = $this->mcorrectivos_generales->getOne($data);
            $avances = $this->mavances_correctivos->GetByDevice($data);
            $archivos = $this->mcorrectivos_generales_archivos->get($data);

            if (!$correctivo) {
                return redirect()->back()->withErrors(['error' => 'Correctivo general no encontrado']);
            }

            $vector = [
                "correctivo" => $correctivo,
                "avances" => $avances,
                "archivos" => $archivos,
                'user' => $this->getCurrentUser(),
                'permisos' => $this->getPermissions()
            ];

            return view("correctivos_generales.detail_single", $vector);

        } catch (\Exception $e) {
            Log::error('Error en showOne correctivo general: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar correctivo general']);
        }
    }

    /**
     * Mostrar vista de correctivos generales abiertos
     */
    public function showCorrectivosGeneralesAbiertos(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Verificar permisos
        if (!$this->hasPermission('correctivos_generales', 'leer')) {
            return redirect()->route('forbidden');
        }

        try {
            $data = [
                'user' => $this->getCurrentUser(),
                'permisos' => $this->getPermissions(),
                'stats' => $this->getCorrectivosStats()
            ];

            return view("correctivos_generales.detalle.detalle_correctivos_generales_abiertos", $data);

        } catch (\Exception $e) {
            Log::error('Error en showCorrectivosGeneralesAbiertos: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar correctivos generales abiertos']);
        }
    }
    
    /**
     * Obtener datos para DataTable server-side de correctivos generales abiertos
     */
    public function getDatatableServerSideCorrectivosGeneralesAbiertos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            if (isset($data['start'])) {
                $vector = $this->mcorrectivos_generales->get_correctivos_generales_abiertos_server_side($data);

                $respuesta = [
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => $vector['num_filas_limit'] ?? 0,
                    'recordsFiltered' => $vector['num_filas'] ?? 0,
                    'data' => $vector['datos'] ?? []
                ];

                return response()->json($respuesta);
            }

            return response()->json([
                'success' => false,
                'message' => 'Parámetros de DataTable no válidos'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error en getDatatableServerSideCorrectivosGeneralesAbiertos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos de DataTable'
            ], 500);
        }
    }

    /**
     * Obtener repuestos pendientes
     */
    public function getRepuestosPendientes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $listado = $this->mrepuestos_pendientes->getAll($data);

            return response()->json([
                'success' => true,
                'data' => $listado,
                'count' => count($listado)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getRepuestosPendientes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener repuestos pendientes'
            ], 500);
        }
    }

    /**
     * Cambiar estado de repuesto pendiente
     */
    public function toggleStateRepuestoPendiente(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:repuestos_pendientes,id'
            ]);

            $this->mrepuestos_pendientes->toggle_state_repuesto_pendiente($data);
            $repuestoPendiente = $this->mrepuestos_pendientes->getOne($data);

            Log::info('Estado de repuesto pendiente cambiado', [
                'repuesto_id' => $data['id'],
                'usuario_id' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'data' => $repuestoPendiente,
                'message' => 'Estado de repuesto actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error en toggleStateRepuestoPendiente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar estado del repuesto'
            ], 500);
        }
    }
    /**
     * Exportar correctivos generales a Excel
     */
    public function exportarExcel()
    {
        try {
            $correctivosGenerales = $this->mcorrectivos_generales->getCorrectivosModal();
            $tickets = $this->mordenes->getOrdenesForCorrectivos();

            $headers = [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename=CorrectivosEB_' . date('Y-m-d_H-i-s') . '.xls',
                'Cache-Control' => 'max-age=0',
            ];

            // Generar contenido HTML para Excel
            $content = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $content .= '<table border="1">';
            $content .= '<thead><tr style="background-color: #f0f0f0; font-weight: bold;">';
            $content .= '<th>Fuente</th><th>Responsable del mantenimiento</th><th>Equipo Id</th>';
            $content .= '<th>Fecha de creación</th><th>Código de orden</th><th>Descripción</th>';
            $content .= '<th>Codificación de cierre</th><th>Equipo</th><th>Código Equipo</th>';
            $content .= '<th>Marca</th><th>Modelo</th><th>Serie</th><th>Estado del equipo</th>';
            $content .= '<th>Sede</th><th>Servicio</th><th>Área</th><th>Archivo</th>';
            $content .= '<th>Fecha avance</th><th>Título Avance1</th><th>Descripción avance</th>';
            $content .= '<th>Fecha avance2</th><th>Título Avance2</th><th>Descripción avance2</th>';
            $content .= '<th>Fecha avance3</th><th>Título Avance3</th><th>Descripción avance3</th>';
            $content .= '<th>Retro de cierre</th><th>Descripción de Cierre</th><th>Fecha de Cierre</th>';
            $content .= '<th>Costo del equipo</th><th>Fecha fin</th><th>Repuesto instalado</th>';
            $content .= '</tr></thead><tbody style="text-align: left">';

            // Correctivos generales
            foreach ($correctivosGenerales as $correctivo) {
                $content .= '<tr>';
                $content .= '<td>Correctivos generales</td>';
                $content .= '<td>' . ($correctivo->responsable_mantenimiento ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->equipo_id ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->fecha_inicio ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->code_orden ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->orden ?? '') . '</td>';

                // Codificación de cierre
                if (!empty($correctivo->code_orden)) {
                    $content .= '<td>' . ($correctivo->descripcion_codificacion ?? '') . '</td>';
                } else {
                    $content .= '<td>Sin Info de orden de trabajo</td>';
                }

                $content .= '<td>' . ($correctivo->equipo ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->code ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->marca ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->modelo ?? '') . '</td>';
                $content .= '<td>SN: ' . ($correctivo->serial ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->estado_equipo ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->sede ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->ubicacion ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->area ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->archivo ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_fecha ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_titulo ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_descripcion ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_fecha2 ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_titulo2 ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_descripcion2 ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_fecha3 ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_titulo3 ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->avance_descripcion3 ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->codigo_correctivo ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->descripcion ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->fecha_ejecucion ?? '') . '</td>';
                $content .= '<td>' . ($correctivo->costo ?? '') . '</td>';
                $content .= '<td></td>';
                $content .= '<td></td>';
                $content .= '</tr>';
            }

            // Tickets
            foreach ($tickets as $ticket) {
                $content .= '<tr>';
                $fuente = 'Tickets';
                if (empty($ticket->equipo_id) || $ticket->equipo_id == 0) {
                    $fuente .= ' (Equipo ingresado de forma manual)';
                }
                $content .= '<td>' . $fuente . '</td>';
                $content .= '<td>' . ($ticket->responsable_mantenimiento ?? '') . '</td>';
                $content .= '<td>' . ($ticket->equipo_id ?? '') . '</td>';
                $content .= '<td>' . ($ticket->fecha_inicio ?? '') . '</td>';
                $content .= '<td>' . ($ticket->id ?? '') . '</td>';
                $content .= '<td>' . ($ticket->descripcion ?? '') . '</td>';

                // Codificación de cierre para tickets
                if (empty($ticket->codigo_cierre)) {
                    $content .= '<td>' . ($ticket->estado ?? '') . '</td>';
                } else {
                    $content .= '<td>(' . $ticket->codigo_cierre . ') ' . ($ticket->significado_cierre ?? '') . '</td>';
                }

                // Información del equipo
                if (empty($ticket->equipo_id) || $ticket->equipo_id == 0) {
                    // Sin equipo vinculado
                    $content .= '<td>' . ($ticket->nombre_equipo ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->codigo_equipo ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->marca_equipo ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->modelo_equipo ?? '') . '</td>';
                    $content .= '<td>SN: ' . ($ticket->serie_equipo ?? '') . '</td>';
                    $content .= '<td>No vinculado</td>';
                } else {
                    // Con equipo vinculado
                    $content .= '<td>' . ($ticket->equipo ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->code ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->marca ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->modelo ?? '') . '</td>';
                    $content .= '<td>SN: ' . ($ticket->serie ?? '') . '</td>';
                    $content .= '<td>' . ($ticket->estado_equipo ?? '') . '</td>';
                }

                $content .= '<td>' . ($ticket->sede ?? '') . '</td>';
                $content .= '<td>' . ($ticket->servicio ?? '') . '</td>';
                $content .= '<td>' . ($ticket->area ?? '') . '</td>';
                $content .= '<td></td>'; // Archivo
                $content .= '<td>' . ($ticket->avance_fecha ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_titulo ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_descripcion ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_fecha2 ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_titulo2 ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_descripcion2 ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_fecha3 ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_titulo3 ?? '') . '</td>';
                $content .= '<td>' . ($ticket->avance_descripcion3 ?? '') . '</td>';
                $content .= '<td>' . ($ticket->retro_cierre ?? '') . '</td>';
                $content .= '<td>' . ($ticket->reparacion ?? '') . '</td>';
                $content .= '<td>' . ($ticket->fecha_asignacion_cierre ?? '') . '</td>';
                $content .= '<td>' . ($ticket->costo ?? '') . '</td>';
                $content .= '<td>' . ($ticket->fecha_fin ?? '') . '</td>';

                $repuestoPendiente = '';
                if (($ticket->repuesto_pendiente_condicion ?? '') == 'no') {
                    $repuestoPendiente = $ticket->repuesto_pendiente ?? '';
                }
                $content .= '<td>' . $repuestoPendiente . '</td>';
                $content .= '</tr>';
            }

            $content .= '</tbody></table>';

            Log::info('Exportación de correctivos generales realizada', [
                'total_correctivos' => count($correctivosGenerales),
                'total_tickets' => count($tickets),
                'usuario_id' => Session::get('id')
            ]);

            return Response::make($content, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error al exportar correctivos generales: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al exportar correctivos generales']);
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

    private function getCorrectivosStats(): array
    {
        try {
            return [
                'total' => $this->mcorrectivos_generales->getTotalCount(),
                'abiertos' => $this->mcorrectivos_generales->getOpenCount(),
                'cerrados' => $this->mcorrectivos_generales->getClosedCount(),
                'con_repuestos_pendientes' => $this->mcorrectivos_generales->getWithPendingPartsCount(),
                'en_proceso' => $this->mcorrectivos_generales->getInProgressCount()
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas de correctivos: ' . $e->getMessage());
            return [
                'total' => 0,
                'abiertos' => 0,
                'cerrados' => 0,
                'con_repuestos_pendientes' => 0,
                'en_proceso' => 0
            ];
        }
    }

    /**
     * Obtener correctivos por equipo
     */
    public function getByEquipo(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'equipo_id' => 'required|integer|exists:equipos,id'
            ]);

            $correctivos = $this->mcorrectivos_generales->getByEquipo($data);

            return response()->json([
                'success' => true,
                'data' => $correctivos,
                'count' => count($correctivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getByEquipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener correctivos por equipo'
            ], 500);
        }
    }

    /**
     * Obtener avances de un correctivo
     */
    public function getAvances(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'correctivo_general_id' => 'required|integer|exists:correctivos_generales,id'
            ]);

            $avances = $this->mavances_correctivos->GetByDevice($data);

            return response()->json([
                'success' => true,
                'data' => $avances,
                'count' => count($avances)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getAvances: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener avances del correctivo'
            ], 500);
        }
    }

    /**
     * Obtener archivos de un correctivo
     */
    public function getArchivos(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'correctivo_general_id' => 'required|integer|exists:correctivos_generales,id'
            ]);

            $archivos = $this->mcorrectivos_generales_archivos->get($data);

            return response()->json([
                'success' => true,
                'data' => $archivos,
                'count' => count($archivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getArchivos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener archivos del correctivo'
            ], 500);
        }
    }
}
