<?php


/**
 * Controlador Cpreventivos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cpreventivos extends Controller
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
namespace App\Http\Controllers\Preventivo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mpreventivos;

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

        return view('laravel.preventivos.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mpreventivos::getServerSide($params);

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
            $item = Mpreventivos::getOne($id);
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

            $result = Mpreventivos::add($data);

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

            $result = Mpreventivos::edit($data);

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
            $result = Mpreventivos::remove($id);

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
            $result = Mpreventivos::ejecutar($data);

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
            $result = Mpreventivos::getCalendario($data);

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
            $result = Mpreventivos::getProgramacion($data);

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
            $result = Mpreventivos::addProgramacion($data);

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
            $result = Mpreventivos::updateProgramacion($data);

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
            $result = Mpreventivos::deleteProgramacion($data);

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
            $result = Mpreventivos::getHistorial($data);

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
            $result = Mpreventivos::addEjecucion($data);

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
            $result = Mpreventivos::updateEjecucion($data);

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
            $result = Mpreventivos::uploadArchivo($data);

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
            $result = Mpreventivos::deleteArchivo($data);

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
            $result = Mpreventivos::getReportes($data);

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
            $result = Mpreventivos::exportPDF($data);

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
            $result = Mpreventivos::exportExcel($data);

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
            $result = Mpreventivos::getEstadisticas($data);

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
            $result = Mpreventivos::addObservacion($data);

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
            $result = Mpreventivos::getObservaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getObservaciones: ' . $e->getMessage()], 500);
        }
    }

}

}
