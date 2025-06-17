<?php


/**
 * Controlador Cdashboard_operativo - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cdashboard_operativo extends Controller
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
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mdashboard_operativo;

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

        return view('laravel.dashboard_operativo.list', $data);
    }

    /* Sistema HUV */
    public function ordenes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::ordenes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ordenes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mantenimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::mantenimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mantenimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function equipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::equipos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en equipos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function recursos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::recursos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en recursos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::programacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function pendientes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::pendientes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en pendientes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tiempo_real(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::tiempo_real($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tiempo_real: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function acciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_operativo::acciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en acciones: ' . $e->getMessage()], 500);
        }
    }

}

}
