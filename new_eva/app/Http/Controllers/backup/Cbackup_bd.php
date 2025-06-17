<?php


/**
 * Controlador Cbackup_bd - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cbackup_bd extends Controller
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
use App\Models\Mbackup_bd;

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

        return view('laravel.backup_bd.list', $data);
    }

    /* Sistema HUV */
    public function exportar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::exportar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function importar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::importar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en importar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::programar($data);

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
            $result = Mbackup_bd::automatico($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en automatico: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function incremental(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::incremental($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en incremental: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function completo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::completo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en completo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function verificar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::verificar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en verificar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function restaurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::restaurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en restaurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup_bd::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
