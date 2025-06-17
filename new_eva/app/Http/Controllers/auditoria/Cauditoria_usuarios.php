<?php


/**
 * Controlador Cauditoria_usuarios - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cauditoria_usuarios extends Controller
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
use App\Models\Mauditoria_usuarios;

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

        return view('laravel.auditoria_usuarios.list', $data);
    }

    /* Sistema HUV */
    public function accesos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::accesos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en accesos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sesiones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::sesiones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sesiones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function actividades(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::actividades($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en actividades: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function permisos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::permisos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en permisos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cambios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::cambios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cambios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function intentos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::intentos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en intentos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function bloqueos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::bloqueos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en bloqueos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::reportes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en reportes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function alertas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mauditoria_usuarios::alertas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en alertas: ' . $e->getMessage()], 500);
        }
    }

}

}
