<?php


/**
 * Controlador Cnotificaciones_email - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cnotificaciones_email extends Controller
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
use App\Models\Mnotificaciones_email;

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

        return view('laravel.notificaciones_email.list', $data);
    }

    /* Sistema HUV */
    public function enviar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_email::enviar($data);

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
            $result = Mnotificaciones_email::programar($data);

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
            $result = Mnotificaciones_email::plantillas($data);

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
            $result = Mnotificaciones_email::destinatarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en destinatarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function adjuntos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_email::adjuntos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en adjuntos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_email::seguimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function rebotes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_email::rebotes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en rebotes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function estadisticas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones_email::estadisticas($data);

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
            $result = Mnotificaciones_email::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
