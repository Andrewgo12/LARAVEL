<?php


/**
 * Controlador Cdashboard_ejecutivo - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cdashboard_ejecutivo extends Controller
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
use App\Models\Mdashboard_ejecutivo;

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

        return view('laravel.dashboard_ejecutivo.list', $data);
    }

    /* Sistema HUV */
    public function resumen(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::resumen($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en resumen: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function kpis(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::kpis($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en kpis: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function costos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::costos($data);

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
            $result = Mdashboard_ejecutivo::eficiencia($data);

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
            $result = Mdashboard_ejecutivo::disponibilidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en disponibilidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tendencias(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::tendencias($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tendencias: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function proyecciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::proyecciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en proyecciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard_ejecutivo::reportes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en reportes: ' . $e->getMessage()], 500);
        }
    }

}

}
