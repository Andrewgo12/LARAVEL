<?php


/**
 * Controlador Calertas - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Calertas extends Controller
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
use App\Models\Malertas;

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

        return view('laravel.alertas.list', $data);
    }

    /* Sistema HUV */
    public function crear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::crear($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en crear: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function activar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::activar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en activar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function desactivar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::desactivar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en desactivar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function historial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::historial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en historial: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function tipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::tipos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en tipos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function destinatarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::destinatarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en destinatarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function condiciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::condiciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en condiciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function acciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas::acciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en acciones: ' . $e->getMessage()], 500);
        }
    }

}

}
