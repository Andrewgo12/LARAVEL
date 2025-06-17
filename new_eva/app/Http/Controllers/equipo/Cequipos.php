<?php


/**
 * Controlador Cequipos - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cequipos extends Controller
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
namespace App\Http\Controllers\Equipo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mequipos;

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

        return view('laravel.equipos.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Mequipos::getServerSide($params);

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
            $item = Mequipos::getOne($id);
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

            $result = Mequipos::add($data);

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

            $result = Mequipos::edit($data);

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
            $result = Mequipos::copy($data);

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
            $result = Mequipos::remove($id);

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
            $result = Mequipos::getServicios($data);

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
            $result = Mequipos::getAreas($data);

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
            $result = Mequipos::getEstadoEquipos($data);

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
            $result = Mequipos::uploadImage($data);

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
            $result = Mequipos::uploadFile($data);

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
            $result = Mequipos::downloadFile($data);

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
            $result = Mequipos::getEspecificaciones($data);

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
            $result = Mequipos::addEspecificacion($data);

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
            $result = Mequipos::updateEspecificacion($data);

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
            $result = Mequipos::deleteEspecificacion($data);

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
            $result = Mequipos::getRepuestos($data);

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
            $result = Mequipos::addRepuesto($data);

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
            $result = Mequipos::updateRepuesto($data);

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
            $result = Mequipos::deleteRepuesto($data);

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
            $result = Mequipos::getContactos($data);

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
            $result = Mequipos::addContacto($data);

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
            $result = Mequipos::updateContacto($data);

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
            $result = Mequipos::deleteContacto($data);

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
            $result = Mequipos::getArchivos($data);

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
            $result = Mequipos::addArchivo($data);

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
            $result = Mequipos::deleteArchivo($data);

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
            $result = Mequipos::getObservaciones($data);

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
            $result = Mequipos::addObservacion($data);

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
            $result = Mequipos::updateObservacion($data);

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
            $result = Mequipos::deleteObservacion($data);

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
            $result = Mequipos::getGarantias($data);

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
            $result = Mequipos::updateGarantia($data);

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
            $result = Mequipos::getBajas($data);

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
            $result = Mequipos::addBaja($data);

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
            $result = Mequipos::getMovimientos($data);

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
            $result = Mequipos::addMovimiento($data);

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
            $result = Mequipos::getHistorial($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getHistorial: ' . $e->getMessage()], 500);
        }
    }

}

}
