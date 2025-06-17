<?php


/**
 * Controlador Cconfiguracion_sistema - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cconfiguracion_sistema extends Controller
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
namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mconfiguracion_sistema;

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

        return view('laravel.configuracion_sistema.list', $data);
    }

    /* Sistema HUV */
    public function parametros(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::parametros($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en parametros: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function variables(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::variables($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en variables: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function constantes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::constantes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en constantes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function rutas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::rutas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en rutas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function permisos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::permisos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en permisos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function roles(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::roles($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en roles: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function modulos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::modulos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en modulos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function funcionalidades(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::funcionalidades($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en funcionalidades: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function actualizaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mconfiguracion_sistema::actualizaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en actualizaciones: ' . $e->getMessage()], 500);
        }
    }

}

}
