<?php


/**
 * Controlador Capi_mantenimientos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Capi_mantenimientos extends Controller
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
use App\Models\Mapi_mantenimientos;

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

        return view('laravel.api_mantenimientos.list', $data);
    }

    /* Sistema HUV */
    public function listar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_mantenimientos::listar($data);

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
            $result = Mapi_mantenimientos::obtener($data);

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
            $result = Mapi_mantenimientos::crear($data);

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
            $result = Mapi_mantenimientos::actualizar($data);

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
            $result = Mapi_mantenimientos::eliminar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en eliminar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_mantenimientos::programar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function ejecutar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_mantenimientos::ejecutar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ejecutar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_mantenimientos::reportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en reportar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function validar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mapi_mantenimientos::validar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en validar: ' . $e->getMessage()], 500);
        }
    }

}

}
