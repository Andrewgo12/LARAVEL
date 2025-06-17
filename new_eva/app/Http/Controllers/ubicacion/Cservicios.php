<?php


/**
 * Controlador Cservicios - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cservicios extends Controller
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
namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mservicios;

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

        return view('laravel.servicios.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mservicios::getServerSide($params);

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
            $item = Mservicios::getOne($id);
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

            $result = Mservicios::add($data);

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

            $result = Mservicios::edit($data);

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
            $result = Mservicios::remove($id);

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
    public function getAll(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mservicios::getAll($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getAll: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getPisos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mservicios::getPisos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getPisos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addPiso(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mservicios::addPiso($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addPiso: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updatePiso(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mservicios::updatePiso($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updatePiso: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deletePiso(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mservicios::deletePiso($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deletePiso: ' . $e->getMessage()], 500);
        }
    }

}

}
