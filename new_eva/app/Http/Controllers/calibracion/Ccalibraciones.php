<?php


/**
 * Controlador Ccalibraciones - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Ccalibraciones extends Controller
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
namespace App\Http\Controllers\Calibracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mcalibraciones;

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

        return view('laravel.calibraciones.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mcalibraciones::getServerSide($params);

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
            $item = Mcalibraciones::getOne($id);
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

            $result = Mcalibraciones::add($data);

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

            $result = Mcalibraciones::edit($data);

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
            $result = Mcalibraciones::remove($id);

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
    public function ejecutar(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::ejecutar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ejecutar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getCalendario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::getCalendario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getCalendario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getProgramacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::getProgramacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getProgramacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addProgramacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::addProgramacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addProgramacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateProgramacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::updateProgramacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateProgramacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteProgramacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::deleteProgramacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteProgramacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getHistorial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::getHistorial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getHistorial: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addEjecucion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::addEjecucion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addEjecucion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateEjecucion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::updateEjecucion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateEjecucion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadCertificado(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::uploadCertificado($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadCertificado: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteCertificado(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::deleteCertificado($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteCertificado: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getReportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::getReportes($data);

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
            $result = Mcalibraciones::exportPDF($data);

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
            $result = Mcalibraciones::exportExcel($data);

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
            $result = Mcalibraciones::getEstadisticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEstadisticas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addObservacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::addObservacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addObservacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getObservaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::getObservaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getObservaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getProveedores(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcalibraciones::getProveedores($data);

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
            $result = Mcalibraciones::addProveedor($data);

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
            $result = Mcalibraciones::updateProveedor($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateProveedor: ' . $e->getMessage()], 500);
        }
    }

}

}
