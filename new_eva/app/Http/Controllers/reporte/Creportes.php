<?php


/**
 * Controlador Creportes - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Creportes extends Controller
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
use App\Models\Mreportes;

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

        return view('laravel.reportes.list', $data);
    }

    /* Sistema HUV */
    public function equipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::equipos($data);

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
            $result = Mreportes::mantenimientos($data);

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
            $result = Mreportes::ordenes($data);

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
            $result = Mreportes::usuarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en usuarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function inventario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::inventario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en inventario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function garantias(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::garantias($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en garantias: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function calibraciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::calibraciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en calibraciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function preventivos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::preventivos($data);

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
            $result = Mreportes::correctivos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en correctivos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportPDF(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::exportPDF($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportPDF: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportExcel(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::exportExcel($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportExcel: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportCSV(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::exportCSV($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportCSV: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::programar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function enviarEmail(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes::enviarEmail($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en enviarEmail: ' . $e->getMessage()], 500);
        }
    }

}

}
