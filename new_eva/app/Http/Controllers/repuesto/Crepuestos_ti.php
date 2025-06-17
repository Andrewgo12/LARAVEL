<?php


/**
 * Controlador Crepuestos_ti - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Crepuestos_ti extends Controller
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
namespace App\Http\Controllers\Repuesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mrepuestos_ti;

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

        return view('laravel.repuestos_ti.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mrepuestos_ti::getServerSide($params);

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
            $item = Mrepuestos_ti::getOne($id);
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

            $result = Mrepuestos_ti::add($data);

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

            $result = Mrepuestos_ti::edit($data);

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
            $result = Mrepuestos_ti::remove($id);

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
    public function getInventario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::getInventario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getInventario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addMovimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::addMovimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addMovimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getMovimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::getMovimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getMovimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateStock(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::updateStock($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateStock: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getProveedores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::getProveedores($data);

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
            $result = Mrepuestos_ti::addProveedor($data);

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
            $result = Mrepuestos_ti::updateProveedor($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateProveedor: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteProveedor(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::deleteProveedor($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteProveedor: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getReportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::getReportes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getReportes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportPDF(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mrepuestos_ti::exportPDF($data);

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
            $result = Mrepuestos_ti::exportExcel($data);

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
            $result = Mrepuestos_ti::getEstadisticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEstadisticas: ' . $e->getMessage()], 500);
        }
    }

}

}
