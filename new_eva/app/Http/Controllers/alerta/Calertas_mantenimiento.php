<?php


/**
 * Controlador Calertas_mantenimiento - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Calertas_mantenimiento extends Controller
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
use App\Models\Malertas_mantenimiento;

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

        return view('laravel.alertas_mantenimiento.list', $data);
    }

    /* Sistema HUV */
    public function vencimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::vencimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en vencimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function retrasos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::retrasos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en retrasos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function pendientes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::pendientes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en pendientes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function criticas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::criticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en criticas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function notificar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::notificar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en notificar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function escalar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::escalar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en escalar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function resolver(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::resolver($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en resolver: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function historial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Malertas_mantenimiento::historial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en historial: ' . $e->getMessage()], 500);
        }
    }

}

}
