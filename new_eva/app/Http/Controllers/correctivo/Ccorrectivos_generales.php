<?php


/**
 * Controlador Ccorrectivos_generales - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Ccorrectivos_generales extends Controller
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
namespace App\Http\Controllers\Correctivo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mcorrectivos_generales;

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

        return view('laravel.correctivos_generales.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mcorrectivos_generales::getServerSide($params);

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
            $item = Mcorrectivos_generales::getOne($id);
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

            $result = Mcorrectivos_generales::add($data);

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

            $result = Mcorrectivos_generales::edit($data);

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
            $result = Mcorrectivos_generales::remove($id);

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
            $result = Mcorrectivos_generales::ejecutar($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en ejecutar: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getHistorial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::getHistorial($data);

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
            $result = Mcorrectivos_generales::addEjecucion($data);

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
            $result = Mcorrectivos_generales::updateEjecucion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateEjecucion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadArchivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::uploadArchivo($data);

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
            $result = Mcorrectivos_generales::deleteArchivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteArchivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getReportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::getReportes($data);

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
            $result = Mcorrectivos_generales::exportPDF($data);

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
            $result = Mcorrectivos_generales::exportExcel($data);

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
            $result = Mcorrectivos_generales::getEstadisticas($data);

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
            $result = Mcorrectivos_generales::addObservacion($data);

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
            $result = Mcorrectivos_generales::getObservaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getObservaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addAvance(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::addAvance($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addAvance: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getAvances(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::getAvances($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getAvances: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateAvance(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::updateAvance($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateAvance: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteAvance(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mcorrectivos_generales::deleteAvance($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteAvance: ' . $e->getMessage()], 500);
        }
    }

}

}
