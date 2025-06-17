<?php


/**
 * Controlador Cbackup_archivos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cbackup_archivos extends Controller
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
namespace App\Http\Controllers\Backup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mbackup_archivos;

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

        return view('laravel.backup_archivos.list', $data);
    }

    /* Sistema HUV */
    public function respaldar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::respaldar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en respaldar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function restaurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::restaurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en restaurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sincronizar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::sincronizar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sincronizar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::programar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en programar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function automatico(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::automatico($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en automatico: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function selectivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::selectivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en selectivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function verificar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::verificar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en verificar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function limpiar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::limpiar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en limpiar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_archivos::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
