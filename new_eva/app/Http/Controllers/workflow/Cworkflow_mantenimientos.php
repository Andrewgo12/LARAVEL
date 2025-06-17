<?php


/**
 * Controlador Cworkflow_mantenimientos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cworkflow_mantenimientos extends Controller
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
use App\Models\Mworkflow_mantenimientos;

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

        return view('laravel.workflow_mantenimientos.list', $data);
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::programar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function asignar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::asignar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en asignar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function ejecutar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::ejecutar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ejecutar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function validar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::validar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en validar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cerrar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::cerrar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cerrar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::reportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en reportar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function seguimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::seguimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en seguimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mejoras(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::mejoras($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mejoras: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mworkflow_mantenimientos::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
