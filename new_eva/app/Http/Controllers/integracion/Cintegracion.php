<?php


/**
 * Controlador Cintegracion - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cintegracion extends Controller
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
namespace App\Http\Controllers\Integracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mintegracion;

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

        return view('laravel.integracion.list', $data);
    }

    /* Sistema HUV */
    public function apis(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::apis($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en apis: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function webservices(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::webservices($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en webservices: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function conectores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::conectores($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en conectores: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function sincronizacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::sincronizacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en sincronizacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function mapeo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::mapeo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en mapeo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function transformacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::transformacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en transformacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function validacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::validacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en validacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function logs(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::logs($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en logs: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function configurar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mintegracion::configurar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en configurar: ' . $e->getMessage()], 500);
        }
    }

}

}
