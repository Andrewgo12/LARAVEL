<?php


/**
 * Controlador Ccuentas - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Ccuentas extends Controller
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
namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mcuentas;

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

        return view('laravel.cuentas.list', $data);
    }

    /* Sistema HUV */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcuentas::updateProfile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateProfile: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcuentas::changePassword($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en changePassword: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadAvatar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcuentas::uploadAvatar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadAvatar: ' . $e->getMessage()], 500);
        }
    }

}

}
