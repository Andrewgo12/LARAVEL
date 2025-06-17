<?php


/**
 * Controlador Cmobile_ordenes - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cmobile_ordenes extends Controller
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
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mmobile_ordenes;

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

        return view('laravel.mobile_ordenes.list', $data);
    }

    /* Sistema HUV */
    public function listar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::listar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en listar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function crear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::crear($data);

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
            $result = Mmobile_ordenes::actualizar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en actualizar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cerrar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::cerrar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cerrar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function firmar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::firmar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en firmar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function fotos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::fotos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en fotos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function ubicacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::ubicacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ubicacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tiempo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::tiempo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tiempo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sync(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_ordenes::sync($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sync: ' . $e->getMessage()], 500);
        }
    }

}

}
