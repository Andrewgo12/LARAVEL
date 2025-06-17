<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Macciones;

/**
 * Controlador Cacciones - Sistema HUV
 * Gestiona las acciones del sistema
 */
class Cacciones extends Controller
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
     * Vista principal de acciones
     */
    public function index()
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        $data = [
            'permisos' => $this->permisos,
            'acciones' => Session::get('acciones', [])
        ];

        return view('laravel.acciones.list', $data);
    }

    /* Sistema HUV */
    public function getAll(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Macciones::getAll($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getAll: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getByUser(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Macciones::getByUser($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getByUser: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function edit(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Macciones::edit($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en edit: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function add(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $data['created_at'] = now();
            $data['usuario_id'] = Session::get('id');

            $result = Macciones::add($data);

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
    public function delete(Request $request): JsonResponse
    {
        try {
            $id = $request->input('id');
            $result = Macciones::remove($id);

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
    public function updatePermisos(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Macciones::updatePermisos($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en updatePermisos: ' . $e->getMessage()], 500);
        }
    }
}
