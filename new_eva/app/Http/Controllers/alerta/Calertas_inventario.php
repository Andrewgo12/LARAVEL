<?php


/**
 * Controlador Calertas_inventario - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Calertas_inventario extends Controller
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
namespace App\Http\Controllers\Alerta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Malertas_inventario;

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

        return view('laravel.alertas_inventario.list', $data);
    }

    /* Sistema HUV */
    public function stockMinimo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::stockMinimo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en stockMinimo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function stockMaximo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::stockMaximo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en stockMaximo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function vencimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::vencimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en vencimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function obsoletos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::obsoletos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en obsoletos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function criticos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::criticos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en criticos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function notificar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::notificar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en notificar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function acciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_inventario::acciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en acciones: ' . $e->getMessage()], 500);
        }
    }

}

}
