<?php

namespace App\Http\Controllers\preventivo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Mequipos;
use App\Models\Mpreventivos;
use App\Models\Mcorrectivos_generales;
use App\Models\Mservicios;
use App\Models\Mzonas;
use App\Models\Mobservaciones;
use App\Models\Mcambios_hdv;

/**
 * Controlador de Mantenimientos Preventivos - Migrado completamente a Laravel 11
 * Sistema HUV - Hospital Universitario del Valle
 *
 * Gestiona el ciclo completo de mantenimientos preventivos:
 * - Programación y ejecución de mantenimientos
 * - Gestión de repuestos pendientes
 * - Notificaciones por email
 * - Historial de cambios y observaciones
 * - Exportación de reportes
 */
class CpreventivosController extends Controller
{
    protected $mequipos;
    protected $mpreventivos;
    protected $mcorrectivos_generales;
    protected $mservicios;
    protected $mzonas;
    protected $mobservaciones;
    protected $mcambios_hdv;

    public function __construct()
    {
        $this->mequipos = new Mequipos();
        $this->mpreventivos = new Mpreventivos();
        $this->mcorrectivos_generales = new Mcorrectivos_generales();
        $this->mservicios = new Mservicios();
        $this->mzonas = new Mzonas();
        $this->mobservaciones = new Mobservaciones();
        $this->mcambios_hdv = new Mcambios_hdv();
    }
    /**
     * Mostrar vista principal de preventivos
     */
    public function index(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        // Verificar permisos
        if (!$this->hasPermission('preventivos', 'leer')) {
            return redirect()->route('forbidden');
        }

        try {
            $data = [
                'user' => $this->getCurrentUser(),
                'permisos' => $this->getPermissions(),
                'stats' => $this->getPreventivosStats()
            ];

            Session::put('controlador', 'preventivos');

            return view('preventivos.index', $data);

        } catch (\Exception $e) {
            Log::error('Error en index de preventivos: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar preventivos']);
        }
    }

    /**
     * Obtener preventivos con filtros
     */
    public function get(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $preventivos = $this->mpreventivos->get($data);

            return response()->json([
                'success' => true,
                'data' => $preventivos,
                'count' => count($preventivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en get preventivos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener preventivos'
            ], 500);
        }
    }

    /**
     * Obtener todos los preventivos
     */
    public function getAll(): JsonResponse
    {
        try {
            $preventivos = $this->mpreventivos->getAll();

            return response()->json([
                'success' => true,
                'data' => $preventivos,
                'count' => count($preventivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getAll preventivos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener todos los preventivos'
            ], 500);
        }
    }

    /**
     * Obtener un preventivo específico
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:preventivos,id'
            ]);

            $preventivo = $this->mpreventivos->getOne($data);

            if (!$preventivo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preventivo no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $preventivo
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOne preventivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener preventivo'
            ], 500);
        }
    }

    /**
     * Obtener último preventivo de un equipo
     */
    public function getLast(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'equipo_id' => 'required|integer|exists:equipos,id'
            ]);

            $preventivo = $this->mpreventivos->getLast($data);

            return response()->json([
                'success' => true,
                'data' => $preventivo
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getLast preventivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener último preventivo'
            ], 500);
        }
    }

    /**
     * Crear nuevo mantenimiento preventivo
     */
    public function add(Request $request): JsonResponse
    {
        try {
            // Validaciones
            $validator = Validator::make($request->all(), [
                'equipo_id' => 'required|integer|exists:equipos,id',
                'description' => 'required|string|min:5|max:500',
                'fecha_ejecucion' => 'required|date',
                'observaciones' => 'nullable|string|max:1000',
                'repuesto_id' => 'nullable|integer|exists:repuestos,id',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
                'tipo_mantenimiento' => 'nullable|string|in:preventivo,correctivo,calibracion',
                'estado' => 'nullable|string|in:programado,ejecutado,pendiente'
            ], [
                'equipo_id.required' => 'El equipo es obligatorio',
                'equipo_id.exists' => 'El equipo seleccionado no existe',
                'description.required' => 'La descripción es obligatoria',
                'description.min' => 'La descripción debe tener al menos 5 caracteres',
                'fecha_ejecucion.required' => 'La fecha de ejecución es obligatoria',
                'fecha_ejecucion.date' => 'La fecha de ejecución debe ser válida',
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

            $data = $request->all();
            $data['usuario_id'] = Session::get('id');
            $data['fecha_creacion'] = now();

            // Manejo de archivo
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_preventivo_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_preventivos');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $data["file"] = $filename;
            }

            // Manejo de repuesto pendiente
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

            // Crear el preventivo
            $ultimoId = $this->mpreventivos->add($data);
            $preventivoCreado = $this->mpreventivos->getOne(["id" => $ultimoId]);

            // Actualizar historial de la hoja de vida
            $descripcionHistorial = "Se agrega el preventivo con código = " . $preventivoCreado->description . " por " . Session::get('nombre') . " " . Session::get('apellido');
            $vectorCambiosHdv = [
                "descripcion" => $descripcionHistorial,
                "usuario_id" => Session::get("id"),
                "equipo_id" => $data["equipo_id"],
                "fecha" => now()
            ];
            $this->mcambios_hdv->add($vectorCambiosHdv);

            DB::commit();

            Log::info('Preventivo creado exitosamente', [
                'preventivo_id' => $ultimoId,
                'equipo_id' => $data["equipo_id"],
                'usuario_id' => Session::get("id")
            ]);

            $vectorRespuesta = [
                "preventivo_id" => $ultimoId,
                "equipo_id" => $data["equipo_id"],
                "success" => true,
                "message" => "Preventivo creado exitosamente"
            ];

            if (!empty($data["repuesto_id"])) {
                $vectorRespuesta["repuesto_pendiente"] = $data["repuesto_id"];
            }

            return response()->json($vectorRespuesta);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear preventivo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear preventivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Enviar email de notificación de preventivo
     */
    public function sendEmailPreventivo(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'equipo_id' => 'required|integer|exists:equipos,id',
                'preventivo_id' => 'required|integer|exists:preventivos,id'
            ]);

            // Obtener datos necesarios
            $equipo = $this->mequipos->getOne(["id" => $data["equipo_id"]]);
            $preventivo = $this->mpreventivos->getOne(["id" => $data["preventivo_id"]]);

            if (!$equipo || !$preventivo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipo o preventivo no encontrado'
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
                "preventivo" => $preventivo,
                "correos" => $correos,
                "servicio" => $servicio,
                "fecha_envio" => now()->format('d/m/Y H:i:s'),
                "usuario_notificador" => $this->getCurrentUser()
            ];

            // Enviar email
            Mail::send('preventivos.email.email_add_preventivo', $vectorCorreo, function ($message) use ($destinatarios, $preventivo) {
                $message->from(config('mail.from.address', 'evagestionahuv@gmail.com'), 'Mantenimiento Preventivo HUV');
                $message->to($destinatarios);
                $message->subject("Notificación de repuesto pendiente - ID preventivo: " . $preventivo->id);

                // Adjuntar archivo si existe
                if (!empty($preventivo->file)) {
                    $filePath = public_path("assets/upload_preventivos/" . $preventivo->file);
                    if (File::exists($filePath)) {
                        $message->attach($filePath);
                    }
                }
            });

            Log::info('Email de preventivo enviado', [
                'preventivo_id' => $data["preventivo_id"],
                'equipo_id' => $data["equipo_id"],
                'destinatarios' => count($destinatarios)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente',
                'destinatarios' => count($destinatarios)
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar email de preventivo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar mantenimiento preventivo
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $preventivoId = $data["id"] ?? null;

            if (!$preventivoId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de preventivo requerido'
                ], 400);
            }

            // Validaciones
            $validator = Validator::make($data, [
                'id' => 'required|integer|exists:preventivos,id',
                'description' => 'nullable|string|min:5|max:500',
                'fecha_ejecucion' => 'nullable|date',
                'observaciones' => 'nullable|string|max:1000',
                'repuesto_id' => 'nullable|integer|exists:repuestos,id',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
                'estado' => 'nullable|string|in:programado,ejecutado,pendiente'
            ], [
                'description.min' => 'La descripción debe tener al menos 5 caracteres',
                'fecha_ejecucion.date' => 'La fecha de ejecución debe ser válida',
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

            // Obtener preventivo actual
            $preventivo = $this->mpreventivos->getOne(['id' => $preventivoId]);
            if (!$preventivo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preventivo no encontrado'
                ], 404);
            }

            $fileAnterior = $preventivo->file;
            unset($data["repuesto_pendiente"]);

            // Manejo de archivo
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_preventivo_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

                // Asegurar que el directorio existe
                $uploadPath = public_path('assets/upload_preventivos');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);
                $data["file"] = $filename;
            }

            $data['updated_at'] = now();

            // Actualizar preventivo
            if ($this->mpreventivos->update($data)) {
                // Actualizar historial de la hoja de vida
                $descripcionHistorial = "Se actualiza el preventivo con código = " . $preventivo->description . " por " . Session::get('nombre') . " " . Session::get('apellido');
                $vectorCambiosHdv = [
                    "descripcion" => $descripcionHistorial,
                    "usuario_id" => Session::get("id"),
                    "equipo_id" => $preventivo->equipo_id,
                    "fecha" => now()
                ];
                $this->mcambios_hdv->add($vectorCambiosHdv);

                // Eliminar archivo anterior si se subió uno nuevo
                if (isset($data["file"]) && $data["file"] != $fileAnterior && !empty($fileAnterior)) {
                    $oldFilePath = public_path("assets/upload_preventivos/" . $fileAnterior);
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }
            } else {
                // Si falló la actualización, eliminar el archivo nuevo
                if (isset($data["file"])) {
                    $newFilePath = public_path("assets/upload_preventivos/" . $data["file"]);
                    if (File::exists($newFilePath)) {
                        File::delete($newFilePath);
                    }
                }
                throw new \Exception('Error al actualizar el preventivo en la base de datos');
            }

            // Verificar cambio en repuesto
            $cambio = "no";
            $repuestoIdActual = $data["repuesto_id"] ?? null;
            $repuestoIdAntiguo = $preventivo->repuesto_id;

            if ($repuestoIdActual != $repuestoIdAntiguo && !empty($repuestoIdActual)) {
                $cambio = "si";
            }

            DB::commit();

            Log::info('Preventivo actualizado exitosamente', [
                'preventivo_id' => $preventivoId,
                'equipo_id' => $preventivo->equipo_id,
                'usuario_id' => Session::get("id")
            ]);

            $vectorRespuesta = [
                "success" => true,
                "message" => "Preventivo actualizado exitosamente",
                "equipo_id" => $preventivo->equipo_id,
                "preventivo_id" => $preventivoId,
                "cambio" => $cambio,
                "actual" => $repuestoIdActual,
                "antiguo" => $repuestoIdAntiguo
            ];

            return response()->json($vectorRespuesta);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar preventivo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar preventivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar mantenimiento preventivo
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:preventivos,id',
                'equipo_id' => 'required|integer|exists:equipos,id'
            ]);

            DB::beginTransaction();

            // Obtener preventivo antes de eliminar
            $preventivo = $this->mpreventivos->getOne(["id" => $data["id"]]);
            if (!$preventivo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preventivo no encontrado'
                ], 404);
            }

            $file = $preventivo->file;
            $equipoId = $data["equipo_id"];

            // Eliminar preventivo
            if ($this->mpreventivos->delete($data)) {
                // Actualizar historial de la hoja de vida
                $descripcionHistorial = "Se elimina el preventivo con código = " . $preventivo->description . " por " . Session::get('nombre') . " " . Session::get('apellido');
                $vectorCambiosHdv = [
                    "descripcion" => $descripcionHistorial,
                    "usuario_id" => Session::get("id"),
                    "equipo_id" => $preventivo->equipo_id,
                    "fecha" => now()
                ];
                $this->mcambios_hdv->add($vectorCambiosHdv);

                // Eliminar archivo asociado
                if (!empty($file)) {
                    $filePath = public_path("assets/upload_preventivos/" . $file);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }

                // Verificar y actualizar estado de repuestos pendientes del equipo
                $cantidadCorrectivosGenerales = $this->mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipoId)->total ?? 0;
                $cantidadPreventivos = $this->mpreventivos->cuenta_registros_repuestos_pendientes($equipoId)->total ?? 0;
                $suma = $cantidadPreventivos + $cantidadCorrectivosGenerales;

                if ($suma > 0) {
                    $this->mequipos->repuesto_pendiente_true($equipoId);
                } else {
                    $this->mequipos->repuesto_pendiente_false($equipoId);
                }

                DB::commit();

                Log::info('Preventivo eliminado exitosamente', [
                    'preventivo_id' => $data["id"],
                    'equipo_id' => $equipoId,
                    'usuario_id' => Session::get("id")
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Preventivo eliminado correctamente',
                    'repuestos_pendientes' => $suma
                ]);
            }

            throw new \Exception('Error al eliminar el preventivo de la base de datos');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar preventivo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el preventivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar vista de detalles de preventivos
     */
    public function show(): View|RedirectResponse
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        try {
            $preventivos = $this->mpreventivos->getPreventivos();

            $data = [
                'preventivos' => $preventivos,
                'user' => $this->getCurrentUser(),
                'permisos' => $this->getPermissions(),
                'total_preventivos' => count($preventivos)
            ];

            return view("preventivos.detail", $data);

        } catch (\Exception $e) {
            Log::error('Error en show preventivos: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar detalles de preventivos']);
        }
    }

    /**
     * Exportar preventivos a Excel
     */
    public function exportarExcel()
    {
        try {
            $preventivos = $this->mpreventivos->getMantenimientosAll();

            $headers = [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename=PreventivosEB_' . date('Y-m-d_H-i-s') . '.xls',
                'Cache-Control' => 'max-age=0',
            ];

            // Generar contenido HTML para Excel
            $content = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $content .= '<table border="1">';
            $content .= '<thead><tr style="background-color: #f0f0f0; font-weight: bold;">';
            $content .= '<th>Fecha de ejecución</th><th>Código preventivo</th><th>Marca</th><th>Código</th>';
            $content .= '<th>Serie</th><th>Nombre</th><th>ID</th><th>Sede</th><th>Servicio</th><th>Área</th>';
            $content .= '<th>Archivo</th><th>Observaciones</th><th>Propiedad</th><th>Estado del equipo</th>';
            $content .= '<th>Proveedor mantenimiento</th><th>Codificación</th>';
            $content .= '</tr></thead><tbody style="text-align: left">';

            foreach ($preventivos as $preventivo) {
                $content .= '<tr>';
                $content .= '<td>' . ($preventivo->fecha_ejecucion ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->codigo ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->marca ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->code ?? '') . '</td>';
                $content .= '<td>SN: ' . ($preventivo->serial ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->name ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->id ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->sede ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->ubicacion ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->area ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->archivomtto ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->observacion_mtto ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->propiedad ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->estado_equipo ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->proveedor_mantenimiento ?? '') . '</td>';
                $content .= '<td>' . ($preventivo->codificacion ?? '') . '</td>';
                $content .= '</tr>';
            }

            $content .= '</tbody></table>';

            Log::info('Exportación de preventivos realizada', [
                'total_registros' => count($preventivos),
                'usuario_id' => Session::get('id')
            ]);

            return Response::make($content, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error al exportar preventivos: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al exportar preventivos']);
        }
    }
    /**
     * Obtener fechas válidas para ejecución de preventivos
     */
    public function getFechasValidasEjecucion(): JsonResponse
    {
        try {
            $fechas = $this->mpreventivos->get_fechas_validas_ejecucion();

            return response()->json([
                'success' => true,
                'data' => $fechas,
                'count' => count($fechas)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getFechasValidasEjecucion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener fechas válidas'
            ], 500);
        }
    }

    /**
     * Agregar nota/observación a un preventivo
     */
    public function addNota(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'preventivo_id' => 'required|integer|exists:preventivos,id',
                'observacion' => 'required|string|min:5|max:1000',
                'tipo_observacion' => 'nullable|string|in:general,tecnica,administrativa'
            ], [
                'preventivo_id.required' => 'El ID del preventivo es obligatorio',
                'preventivo_id.exists' => 'El preventivo seleccionado no existe',
                'observacion.required' => 'La observación es obligatoria',
                'observacion.min' => 'La observación debe tener al menos 5 caracteres'
            ]);

            $data["usuario_id"] = Session::get("id");
            $data["fecha_observacion"] = now();

            $observacionId = $this->mobservaciones->add($data);

            Log::info('Nota agregada a preventivo', [
                'preventivo_id' => $data["preventivo_id"],
                'observacion_id' => $observacionId,
                'usuario_id' => Session::get("id")
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nota agregada exitosamente',
                'data' => [
                    'preventivo_id' => $data["preventivo_id"],
                    'observacion_id' => $observacionId
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al agregar nota: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar nota'
            ], 500);
        }
    }

    /**
     * Obtener notas de un preventivo específico
     */
    public function getNotasFromPreventivo(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'preventivo_id' => 'required|integer|exists:preventivos,id'
            ]);

            $notas = $this->mobservaciones->get_notas_from_preventivo($data);

            return response()->json([
                'success' => true,
                'data' => $notas,
                'count' => count($notas)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getNotasFromPreventivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener notas del preventivo'
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

    private function getPreventivosStats(): array
    {
        try {
            return [
                'total' => $this->mpreventivos->getTotalCount(),
                'ejecutados' => $this->mpreventivos->getExecutedCount(),
                'pendientes' => $this->mpreventivos->getPendingCount(),
                'programados' => $this->mpreventivos->getScheduledCount(),
                'con_repuestos_pendientes' => $this->mpreventivos->getWithPendingPartsCount()
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas de preventivos: ' . $e->getMessage());
            return [
                'total' => 0,
                'ejecutados' => 0,
                'pendientes' => 0,
                'programados' => 0,
                'con_repuestos_pendientes' => 0
            ];
        }
    }

    /**
     * Obtener preventivos por equipo
     */
    public function getByEquipo(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'equipo_id' => 'required|integer|exists:equipos,id'
            ]);

            $preventivos = $this->mpreventivos->getByEquipo($data);

            return response()->json([
                'success' => true,
                'data' => $preventivos,
                'count' => count($preventivos)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getByEquipo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener preventivos por equipo'
            ], 500);
        }
    }

    /**
     * Obtener preventivos por rango de fechas
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);

            $preventivos = $this->mpreventivos->getByDateRange($data);

            return response()->json([
                'success' => true,
                'data' => $preventivos,
                'count' => count($preventivos),
                'range' => [
                    'inicio' => $data['fecha_inicio'],
                    'fin' => $data['fecha_fin']
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getByDateRange: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener preventivos por rango de fechas'
            ], 500);
        }
    }
}