<?php


/**
 * Controlador Cconfiguracion - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cconfiguracion extends Controller
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
namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mconfiguracion;

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

        return view('laravel.configuracion.list', $data);
    }

    /* Sistema HUV */
    public function general(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::general($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en general: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sistema(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::sistema($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sistema: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function email(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::email($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en email: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function backup(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::backup($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en backup: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguridad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::seguridad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguridad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function notificaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::notificaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en notificaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function integraciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::integraciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en integraciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function api(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::api($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en api: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function logs(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::logs($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en logs: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mantenimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion::mantenimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mantenimiento: ' . $e->getMessage()], 500);
        }
    }

}

}
