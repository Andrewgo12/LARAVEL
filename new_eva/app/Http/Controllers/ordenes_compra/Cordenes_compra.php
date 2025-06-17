<?php


/**
 * Controlador Cordenes_compra - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cordenes_compra extends Controller
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
namespace App\Http\Controllers\Ordenes_compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mordenes_compra;

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

        return view('laravel.ordenes_compra.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mordenes_compra::getServerSide($params);

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
            $item = Mordenes_compra::getOne($id);
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

            $result = Mordenes_compra::add($data);

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

            $result = Mordenes_compra::edit($data);

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
            $result = Mordenes_compra::remove($id);

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
    public function aprobar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::aprobar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en aprobar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function rechazar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::rechazar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en rechazar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getProveedores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::getProveedores($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getProveedores: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addProveedor(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::addProveedor($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addProveedor: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateProveedor(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::updateProveedor($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateProveedor: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getHistorial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::getHistorial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getHistorial: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportPDF(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::exportPDF($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportPDF: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportExcel(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::exportExcel($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en exportExcel: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getEstadisticas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes_compra::getEstadisticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEstadisticas: ' . $e->getMessage()], 500);
        }
    }

}

}
