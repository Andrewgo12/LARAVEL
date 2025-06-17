<?php


/**
 * Controlador Cauditoria_sistema - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cauditoria_sistema extends Controller
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
use App\Models\Mauditoria_sistema;

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

        return view('laravel.auditoria_sistema.list', $data);
    }

    /* Sistema HUV */
    public function eventos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::eventos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en eventos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function errores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::errores($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en errores: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function rendimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::rendimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en rendimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function recursos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::recursos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en recursos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguridad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::seguridad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguridad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function integridad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::integridad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en integridad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function disponibilidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::disponibilidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en disponibilidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function monitoreo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::monitoreo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en monitoreo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_sistema::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

}

}
