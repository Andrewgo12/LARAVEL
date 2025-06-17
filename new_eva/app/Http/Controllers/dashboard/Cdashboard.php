<?php


/**
 * Controlador Cdashboard - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cdashboard extends Controller
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
use App\Models\Mdashboard;

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

        return view('laravel.dashboard.list', $data);
    }

    /* Sistema HUV */
    public function widgets(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::widgets($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en widgets: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function kpis(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::kpis($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en kpis: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function graficos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::graficos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en graficos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function notificaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::notificaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en notificaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function resumen(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::resumen($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en resumen: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tendencias(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::tendencias($data);

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
            $result = Mdashboard::comparativos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en comparativos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function personalizar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mdashboard::personalizar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en personalizar: ' . $e->getMessage()], 500);
        }
    }

}

}
