<?php


/**
 * Controlador Cavances_correctivos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cavances_correctivos extends Controller
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
namespace App\Http\Controllers\Avances_correctivos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mavances_correctivos;

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

        return view('laravel.avances_correctivos.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mavances_correctivos::getServerSide($params);

            $response = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $result['num_filas'],
                'recordsFiltered' => $result['num_filas'],
                'data' => $result['datos']
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en servidor: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $id = $request->input('id');
            $item = Mavances_correctivos::getOne($id);
            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener registro: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function add(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $data['created_at'] = now();
            $data['usuario_id'] = Session::get('id');

            $result = Mavances_correctivos::add($data);

            if ($result) {
                return response()->json(['success' => true, 'message' => 'Registro agregado exitosamente'], 201);
            } else {
                return response()->json(['error' => 'No se pudo agregar el registro'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function update(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $data['updated_at'] = now();

            $result = Mavances_correctivos::edit($data);

            if ($result) {
                return response()->json(['success' => true, 'message' => 'Registro actualizado exitosamente'], 200);
            } else {
                return response()->json(['error' => 'No se pudo actualizar el registro'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function delete(Request $request): JsonResponse
    {
        try {
            $id = $request->input('id');
            $result = Mavances_correctivos::remove($id);

            if ($result) {
                return response()->json(['success' => true, 'message' => 'Registro eliminado exitosamente'], 200);
            } else {
                return response()->json(['error' => 'No se pudo eliminar el registro'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getByCorrectivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mavances_correctivos::getByCorrectivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getByCorrectivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadArchivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mavances_correctivos::uploadArchivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadArchivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteArchivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mavances_correctivos::deleteArchivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteArchivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getHistorial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mavances_correctivos::getHistorial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getHistorial: ' . $e->getMessage()], 500);
        }
    }

}

}
