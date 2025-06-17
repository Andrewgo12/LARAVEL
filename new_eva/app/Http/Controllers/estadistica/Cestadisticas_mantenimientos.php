<?php


/**
 * Controlador Cestadisticas_mantenimientos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cestadisticas_mantenimientos extends Controller
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
use App\Models\Mestadisticas_mantenimientos;

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

        return view('laravel.estadisticas_mantenimientos.list', $data);
    }

    /* Sistema HUV */
    public function cumplimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::cumplimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cumplimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function eficiencia(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::eficiencia($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en eficiencia: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function costos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::costos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en costos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tiempos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::tiempos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tiempos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function recursos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::recursos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en recursos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function calidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::calidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en calidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function satisfaccion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::satisfaccion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en satisfaccion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mejoras(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::mejoras($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mejoras: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function benchmarking(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mestadisticas_mantenimientos::benchmarking($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en benchmarking: ' . $e->getMessage()], 500);
        }
    }

}

}
