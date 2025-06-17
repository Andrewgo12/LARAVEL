<?php


/**
 * Controlador Creportes_inventario - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Creportes_inventario extends Controller
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
use App\Models\Mreportes_inventario;

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

        return view('laravel.reportes_inventario.list', $data);
    }

    /* Sistema HUV */
    public function stock(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::stock($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en stock: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function movimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::movimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en movimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function valorizado(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::valorizado($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en valorizado: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function rotacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::rotacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en rotacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function obsoletos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::obsoletos($data);

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
            $result = Mreportes_inventario::criticos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en criticos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function proveedores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::proveedores($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en proveedores: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::exportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mreportes_inventario::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

}

}
