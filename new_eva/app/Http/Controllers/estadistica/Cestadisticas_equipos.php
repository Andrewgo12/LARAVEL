<?php


/**
 * Controlador Cestadisticas_equipos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cestadisticas_equipos extends Controller
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
use App\Models\Mestadisticas_equipos;

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

        return view('laravel.estadisticas_equipos.list', $data);
    }

    /* Sistema HUV */
    public function disponibilidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::disponibilidad($data);

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
            $result = Mestadisticas_equipos::confiabilidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en confiabilidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mantenibilidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::mantenibilidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mantenibilidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function fallas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::fallas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en fallas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tiempos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::tiempos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tiempos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function costos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::costos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en costos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tendencias(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::tendencias($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tendencias: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function comparativos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::comparativos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en comparativos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function proyecciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_equipos::proyecciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en proyecciones: ' . $e->getMessage()], 500);
        }
    }

}

}
