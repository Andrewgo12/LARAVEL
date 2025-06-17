<?php


/**
 * Controlador Cworkflow_ordenes - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cworkflow_ordenes extends Controller
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
namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mworkflow_ordenes;

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

        return view('laravel.workflow_ordenes.list', $data);
    }

    /* Sistema HUV */
    public function crear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::crear($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en crear: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function asignar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::asignar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en asignar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function aprobar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::aprobar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en aprobar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function ejecutar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::ejecutar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ejecutar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cerrar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::cerrar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cerrar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function escalar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::escalar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en escalar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function notificar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::notificar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en notificar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::seguimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_ordenes::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
