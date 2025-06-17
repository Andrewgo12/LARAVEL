<?php


/**
 * Controlador Cbackup - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cbackup extends Controller
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
use App\Models\Mbackup;

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

        return view('laravel.backup.list', $data);
    }

    /* Sistema HUV */
    public function crear(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup::crear($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en crear: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function restaurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup::restaurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en restaurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function programar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup::programar($data);

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
            $result = Mbackup::automatico($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en automatico: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function manual(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup::manual($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en manual: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function verificar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup::verificar($data);

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
            $result = Mbackup::limpiar($data);

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
            $result = Mbackup::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function historial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mbackup::historial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en historial: ' . $e->getMessage()], 500);
        }
    }

}

}
