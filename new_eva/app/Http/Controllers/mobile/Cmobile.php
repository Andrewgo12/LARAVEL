<?php


/**
 * Controlador Cmobile - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cmobile extends Controller
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
use App\Models\Mmobile;

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

        return view('laravel.mobile.list', $data);
    }

    /* Sistema HUV */
    public function sync(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::sync($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sync: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function offline(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::offline($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en offline: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function push(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::push($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en push: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function auth(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::auth($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en auth: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function equipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::equipos($data);

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
            $result = Mmobile::ordenes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ordenes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mantenimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::mantenimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mantenimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mmobile::reportes($data);

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
            $result = Mmobile::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
