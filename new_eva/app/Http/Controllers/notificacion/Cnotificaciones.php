<?php


/**
 * Controlador Cnotificaciones - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cnotificaciones extends Controller
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
use App\Models\Mnotificaciones;

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

        return view('laravel.notificaciones.list', $data);
    }

    /* Sistema HUV */
    public function crear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::crear($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en crear: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function enviar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::enviar($data);

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
            $result = Mnotificaciones::programar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function masivas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::masivas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en masivas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function personalizadas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::personalizadas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en personalizadas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function plantillas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::plantillas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en plantillas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function historial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::historial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en historial: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function estadisticas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mnotificaciones::estadisticas($data);

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
            $result = Mnotificaciones::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
