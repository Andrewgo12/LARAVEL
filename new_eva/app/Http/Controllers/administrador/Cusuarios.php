<?php


/**
 * Controlador Cusuarios - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cusuarios extends Controller
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
namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Musuarios;

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

        return view('laravel.usuarios.list', $data);
    }

    /* Sistema HUV */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $params = $request->all();
            $result = Musuarios::getServerSide($params);

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
            $item = Musuarios::getOne($id);
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

            $result = Musuarios::add($data);

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

            $result = Musuarios::edit($data);

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
            $result = Musuarios::remove($id);

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
    public function activate(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::activate($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en activate: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cambiarSede(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::cambiarSede($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cambiarSede: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function cambiarAnio(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::cambiarAnio($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en cambiarAnio: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getUsuariosPorEmpresa(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::getUsuariosPorEmpresa($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getUsuariosPorEmpresa: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getRoles(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::getRoles($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getRoles: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function resetPassword(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::resetPassword($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en resetPassword: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getUsuariosZonas(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::getUsuariosZonas($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getUsuariosZonas: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteUsuarioZona(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Musuarios::deleteUsuarioZona($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteUsuarioZona: ' . $e->getMessage()], 500);
        }
    }

}

}
