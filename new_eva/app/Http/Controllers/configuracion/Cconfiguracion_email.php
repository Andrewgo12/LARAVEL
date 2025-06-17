<?php


/**
 * Controlador Cconfiguracion_email - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cconfiguracion_email extends Controller
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
use App\Models\Mconfiguracion_email;

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

        return view('laravel.configuracion_email.list', $data);
    }

    /* Sistema HUV */
    public function smtp(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::smtp($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en smtp: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function plantillas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::plantillas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en plantillas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function notificaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::notificaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en notificaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programadas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::programadas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programadas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function masivas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::masivas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en masivas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function test(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::test($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en test: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function logs(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::logs($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en logs: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_email::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
