<?php


/**
 * Controlador Creportes_equipos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Creportes_equipos extends Controller
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
use App\Models\Mreportes_equipos;

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

        return view('laravel.reportes_equipos.list', $data);
    }

    /* Sistema HUV */
    public function porServicio(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porServicio($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porServicio: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porArea(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porArea($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porArea: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porEstado(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porEstado($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porEstado: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porMarca(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porMarca($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porMarca: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porModelo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porModelo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porModelo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porTecnologia(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porTecnologia($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porTecnologia: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function porGarantia(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::porGarantia($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en porGarantia: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::exportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function graficar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_equipos::graficar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en graficar: ' . $e->getMessage()], 500);
        }
    }

}

}
