<?php


/**
 * Controlador Cintegracion_erp - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cintegracion_erp extends Controller
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
namespace App\Http\Controllers\Integracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mintegracion_erp;

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

        return view('laravel.integracion_erp.list', $data);
    }

    /* Sistema HUV */
    public function conectar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::conectar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en conectar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sincronizar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::sincronizar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sincronizar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function equipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::equipos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en equipos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function ordenes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::ordenes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ordenes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function inventario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::inventario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en inventario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function usuarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::usuarios($data);

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
            $result = Mintegracion_erp::costos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en costos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::reportes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en reportes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion_erp::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
