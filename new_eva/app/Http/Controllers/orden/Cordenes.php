<?php


/**
 * Controlador Cordenes - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cordenes extends Controller
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
namespace App\Http\Controllers\Orden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mordenes;

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

        return view('laravel.ordenes.list', $data);
    }

    /* Sistema HUV */
    public function listActive(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::listActive($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en listActive: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function listClosed(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::listClosed($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en listClosed: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mordenes::getServerSide($params);

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
            $item = Mordenes::getOne($id);
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

            $result = Mordenes::add($data);

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

            $result = Mordenes::edit($data);

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
            $result = Mordenes::remove($id);

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
    public function asignarTecnico(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::asignarTecnico($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en asignarTecnico: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addDiagnostico(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::addDiagnostico($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addDiagnostico: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cerrarOrden(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::cerrarOrden($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cerrarOrden: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function reabrirOrden(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::reabrirOrden($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en reabrirOrden: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getTimeline(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::getTimeline($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getTimeline: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addAvance(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::addAvance($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addAvance: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateAvance(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::updateAvance($data);

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
            $result = Mordenes::deleteAvance($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteAvance: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadArchivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::uploadArchivo($data);

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
            $result = Mordenes::deleteArchivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteArchivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addComentario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::addComentario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addComentario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getComentarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::getComentarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getComentarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function exportPDF(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::exportPDF($data);

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
            $result = Mordenes::exportExcel($data);

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
            $result = Mordenes::getEstadisticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEstadisticas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getReportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::getReportes($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getReportes: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function solicitudCierre(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::solicitudCierre($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en solicitudCierre: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function aprobarCierre(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mordenes::aprobarCierre($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en aprobarCierre: ' . $e->getMessage()], 500);
        }
    }

}

}
