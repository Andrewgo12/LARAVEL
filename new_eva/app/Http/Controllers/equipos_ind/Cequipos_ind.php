<?php


/**
 * Controlador Cequipos_ind - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cequipos_ind extends Controller
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
namespace App\Http\Controllers\Equipos_ind;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mequipos_ind;

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

        return view('laravel.equipos_ind.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mequipos_ind::getServerSide($params);

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
            $item = Mequipos_ind::getOne($id);
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

            $result = Mequipos_ind::add($data);

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

            $result = Mequipos_ind::edit($data);

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
    public function copy(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::copy($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en copy: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function delete(Request $request): JsonResponse
    {
        try {
            $id = $request->input('id');
            $result = Mequipos_ind::remove($id);

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
    public function getServicios(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getServicios($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getServicios: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getAreas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getAreas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getAreas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getEstadoEquipos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getEstadoEquipos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEstadoEquipos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::uploadImage($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadImage: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::uploadFile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadFile: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function downloadFile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::downloadFile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en downloadFile: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getEspecificaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getEspecificaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getEspecificaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addEspecificacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addEspecificacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addEspecificacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateEspecificacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::updateEspecificacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateEspecificacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteEspecificacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::deleteEspecificacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteEspecificacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getRepuestos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getRepuestos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getRepuestos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addRepuesto(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addRepuesto($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addRepuesto: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateRepuesto(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::updateRepuesto($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateRepuesto: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteRepuesto(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::deleteRepuesto($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteRepuesto: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getContactos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getContactos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getContactos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addContacto(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addContacto($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addContacto: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateContacto(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::updateContacto($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateContacto: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteContacto(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::deleteContacto($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteContacto: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getArchivos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getArchivos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getArchivos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addArchivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addArchivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addArchivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteArchivo(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::deleteArchivo($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteArchivo: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getObservaciones(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getObservaciones($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getObservaciones: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addObservacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addObservacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addObservacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateObservacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::updateObservacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateObservacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteObservacion(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::deleteObservacion($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteObservacion: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getGarantias(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getGarantias($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getGarantias: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function updateGarantia(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::updateGarantia($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updateGarantia: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getBajas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getBajas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getBajas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addBaja(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addBaja($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addBaja: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getMovimientos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getMovimientos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getMovimientos: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function addMovimiento(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::addMovimiento($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en addMovimiento: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getHistorial(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mequipos_ind::getHistorial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getHistorial: ' . $e->getMessage()], 500);
        }
    }

}

}
