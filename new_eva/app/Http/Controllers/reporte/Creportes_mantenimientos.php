<?php


/**
 * Controlador Creportes_mantenimientos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Creportes_mantenimientos extends Controller
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
namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mreportes_mantenimientos;

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

        return view('laravel.reportes_mantenimientos.list', $data);
    }

    /* Sistema HUV */
    public function preventivos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::preventivos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en preventivos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function correctivos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::correctivos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en correctivos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function calibraciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::calibraciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en calibraciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porPeriodo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::porPeriodo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porPeriodo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porTecnico(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::porTecnico($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porTecnico: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porEquipo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::porEquipo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porEquipo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function costos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::costos($data);

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
            $result = Mreportes_mantenimientos::eficiencia($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en eficiencia: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_mantenimientos::exportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportar: ' . $e->getMessage()], 500);
        }
    }

}

}
