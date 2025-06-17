<?php


/**
 * Controlador Ctecnicos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Ctecnicos extends Controller
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
namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mtecnicos;

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

        return view('laravel.tecnicos.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mtecnicos::getServerSide($params);

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
            $item = Mtecnicos::getOne($id);
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

            $result = Mtecnicos::add($data);

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

            $result = Mtecnicos::edit($data);

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
            $result = Mtecnicos::remove($id);

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
            $result = Mtecnicos::getAll($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getAll: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getEspecialidades(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::getEspecialidades($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEspecialidades: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addEspecialidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::addEspecialidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addEspecialidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateEspecialidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::updateEspecialidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateEspecialidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteEspecialidad(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::deleteEspecialidad($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteEspecialidad: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getHorarios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::getHorarios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getHorarios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addHorario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::addHorario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addHorario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateHorario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::updateHorario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateHorario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteHorario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::deleteHorario($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteHorario: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getReportes(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mtecnicos::getReportes($data);

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
            $result = Mtecnicos::exportPDF($data);

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
            $result = Mtecnicos::exportExcel($data);

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
            $result = Mtecnicos::getEstadisticas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEstadisticas: ' . $e->getMessage()], 500);
        }
    }

}

}
