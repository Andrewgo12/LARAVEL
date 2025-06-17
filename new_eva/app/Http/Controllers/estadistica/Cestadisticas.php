<?php


/**
 * Controlador Cestadisticas - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cestadisticas extends Controller
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
namespace App\Http\Controllers\Estadistica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mestadisticas;

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

        return view('laravel.estadisticas.list', $data);
    }

    /* Sistema HUV */
    public function dashboard(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::dashboard($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en dashboard: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function equipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::equipos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en equipos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mantenimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::mantenimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mantenimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function ordenes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::ordenes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ordenes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function usuarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::usuarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en usuarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function costos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::costos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en costos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function eficiencia(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::eficiencia($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en eficiencia: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function disponibilidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::disponibilidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en disponibilidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function confiabilidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::confiabilidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en confiabilidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function kpis(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas::kpis($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en kpis: ' . $e->getMessage()], 500);
        }
    }

}

}
