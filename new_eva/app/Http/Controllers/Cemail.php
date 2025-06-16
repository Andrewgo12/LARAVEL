<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Mequipos;
use App\Models\Mobservaciones;
use App\Models\Mservicios;
use App\Models\Mzonas;
use App\Models\Mordenes;
use App\Models\Mempresas;
use App\Models\Musuarios;
use App\Models\Mtrabajos;
use App\Models\Mtecnicos;

class CemailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function email_asignar_empresa(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            $mordenes = app(Mordenes::class);
            $mempresas = app(Mempresas::class);
            $musuarios = app(Musuarios::class);
            $mequipos = app(Mequipos::class);

            $orden = $mordenes->getOne(["id" => $data["orden_id"]]);
            $empresa_id = $orden->empresa_id;
            $empresa = $mempresas->getOne(["id" => $empresa_id]);
            $correos_empresa = $mempresas->getEmailUsuariosEmpresa(["id_empresa" => $empresa_id]);
            $reportante = $musuarios->getOne($orden->reportante_id);

            $vector = [
                "orden" => $orden,
                "empresa" => $empresa,
                "correos_empresa" => $correos_empresa,
                "reportante" => $reportante
            ];

            if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
                $vector["equipo"] = $mequipos->getOne(["id" => $orden->equipo_id]);
            }

            // Construir lista de destinatarios
            $to = [];
            $limite = $correos_empresa["cantidad"];
            $control = true;

            if ($limite == 1) {
                $to[] = $correos_empresa["correos_empresa"][0]->email;
            } elseif ($limite > 1) {
                foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
                    $to[] = $correo_empresa->email;
                }
            } else {
                $control = false;
            }

            if ($control && !empty($to)) {
                Mail::send('ordenes.tikect_email', $vector, function ($message) use ($to, $reportante, $orden) {
                    $message->from('evagestionahuv@gmail.com', 'Electromedicina HUV');
                    $message->to($to);
                    $message->cc($reportante->email);
                    $message->subject('Asignación de orden exitosa. Ticket Nro ' . $orden->id);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Email enviado correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron destinatarios válidos'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email asignar empresa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage()
            ], 500);
        }
    }
    public function email_asignar_trabajo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            $mordenes = app(Mordenes::class);
            $mtrabajos = app(Mtrabajos::class);
            $mtecnicos = app(Mtecnicos::class);
            $mempresas = app(Mempresas::class);
            $musuarios = app(Musuarios::class);
            $mequipos = app(Mequipos::class);

            $orden = $mordenes->getOne(["id" => $data["orden_id"]]);
            $trabajo = $mtrabajos->getOne(["id" => $orden->trabajo_id]);
            $tecnico = $mtecnicos->getOne(["id" => $orden->tecnico_id]);
            $empresa_id = 4; // Mantenimiento industrial administrativo
            $empresa = $mempresas->getOne(["id" => $empresa_id]);
            $correos_empresa = $mempresas->getEmailUsuariosEmpresa(["id_empresa" => $empresa_id]);
            $reportante = $musuarios->getOne($orden->reportante_id);

            $vector = [
                "orden" => $orden,
                "empresa" => $empresa,
                "trabajo" => $trabajo,
                "tecnico" => $tecnico,
                "correos_empresa" => $correos_empresa,
                "reportante" => $reportante
            ];

            if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
                $vector["equipo"] = $mequipos->getOne(["id" => $orden->equipo_id]);
            }

            // Construir lista de destinatarios
            $to = [];
            $limite = $correos_empresa["cantidad"];
            $control = true;

            if ($limite == 1) {
                $to[] = $correos_empresa["correos_empresa"][0]->email;
            } elseif ($limite > 1) {
                foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
                    $to[] = $correo_empresa->email;
                }
            } else {
                $control = false;
            }

            if ($control && !empty($to)) {
                Mail::send('ordenes.tikect_email', $vector, function ($message) use ($to, $reportante, $orden) {
                    $message->from('evagestionahuv@gmail.com', 'Electromedicina HUV');
                    $message->to($to);
                    $message->cc($reportante->email);
                    $message->subject('Asignación de orden exitosa. Ticket Nro ' . $orden->id);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Email enviado correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron destinatarios válidos'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email asignar trabajo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function send_email_observacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            $mequipos = app(Mequipos::class);
            $mobservaciones = app(Mobservaciones::class);
            $mservicios = app(Mservicios::class);
            $mzonas = app(Mzonas::class);

            $equipo = $mequipos->getOne(["id" => $data["equipo_id"]]);
            $observacion = $mobservaciones->getOne(["id" => $data["observacion_id"]]);
            $servicio = $mservicios->getOne(["id" => $equipo->servicio_id]);
            $correos = $mzonas->get_emails_with_service(["servicio_id" => $servicio->id]);

            // Construir lista de destinatarios
            $to = [];
            $limite = $correos["cantidad"];
            $control = true;

            if ($limite == 1) {
                $to[] = $correos["correos"][0]->correo_usuario;
            } elseif ($limite > 1) {
                foreach ($correos["correos"] as $correo) {
                    $to[] = $correo->correo_usuario;
                }
            } else {
                $control = false;
            }

            if ($control && !empty($to)) {
                $vector_correo = [
                    "equipo" => $equipo,
                    "observacion" => $observacion,
                    "correos" => $correos,
                    "servicio" => $servicio
                ];

                Mail::send('equipos.email.email_add_observacion', $vector_correo, function ($message) use ($to, $equipo) {
                    $message->from('evagestionahuv@gmail.com', 'Repuesto pendiente HUV');
                    $message->to($to);
                    $message->subject("Notificación de repuesto pendiente del equipo con Id: " . $equipo->id);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Email de observación enviado correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron destinatarios válidos para el servicio'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email observación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage()
            ], 500);
        }
    }
}
