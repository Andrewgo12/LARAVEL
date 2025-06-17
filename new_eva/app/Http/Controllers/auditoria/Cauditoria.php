<?php


/**
 * Controlador Cauditoria - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cauditoria extends Controller
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
namespace App\Http\Controllers\Auditoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mauditoria;

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

        return view('laravel.auditoria.list', $data);
    }

    /* Sistema HUV */
    public function logs(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::logs($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en logs: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function accesos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::accesos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en accesos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cambios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::cambios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cambios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function errores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::errores($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en errores: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguridad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::seguridad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguridad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function usuarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::usuarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en usuarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sistema(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::sistema($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sistema: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria::reportes($data);

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
            $result = Mauditoria::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
