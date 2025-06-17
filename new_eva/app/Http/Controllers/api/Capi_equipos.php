<?php


/**
 * Controlador Capi_equipos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Capi_equipos extends Controller
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
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mapi_equipos;

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

        return view('laravel.api_equipos.list', $data);
    }

    /* Sistema HUV */
    public function listar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::listar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en listar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function obtener(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::obtener($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en obtener: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function crear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::crear($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en crear: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function actualizar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::actualizar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en actualizar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function eliminar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::eliminar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en eliminar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function buscar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::buscar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en buscar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function filtrar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::filtrar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en filtrar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::exportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function validar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_equipos::validar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en validar: ' . $e->getMessage()], 500);
        }
    }

}

}
