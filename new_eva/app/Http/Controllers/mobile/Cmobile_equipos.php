<?php


/**
 * Controlador Cmobile_equipos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cmobile_equipos extends Controller
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
use App\Models\Mmobile_equipos;

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

        return view('laravel.mobile_equipos.list', $data);
    }

    /* Sistema HUV */
    public function listar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::listar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en listar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function buscar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::buscar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en buscar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function escanear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::escanear($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en escanear: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function detalles(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::detalles($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en detalles: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function historial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::historial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en historial: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function fotos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::fotos($data);

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
            $result = Mmobile_equipos::ubicacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ubicacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function estado(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::estado($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en estado: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sync(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile_equipos::sync($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sync: ' . $e->getMessage()], 500);
        }
    }

}

}
