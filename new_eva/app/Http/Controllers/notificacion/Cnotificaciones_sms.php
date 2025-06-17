<?php


/**
 * Controlador Cnotificaciones_sms - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cnotificaciones_sms extends Controller
{
    /**
     * Permisos del controlador
     */
    protected $permisos = [];

    /**
     * Constructor del controlador
     */
    public function __construct()
    {
        $this->permisos = Session::get('permisos', []);
    }

    /**
namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mnotificaciones_sms;

/* Sistema HUV */
    public function index()
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        $data = [
            'permisos' => $this->permisos,
            'acciones' => Session::get('acciones', [])
        ];

        return view('laravel.notificaciones_sms.list', $data);
    }

    /* Sistema HUV */
    public function enviar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::enviar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en enviar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::programar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function plantillas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::plantillas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en plantillas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function destinatarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::destinatarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en destinatarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function masivos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::masivos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en masivos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::seguimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function estadisticas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::estadisticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en estadisticas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function creditos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_sms::creditos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en creditos: ' . $e->getMessage()], 500);
        }
    }

}

}
