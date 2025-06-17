<?php

namespace App\Http\Controllers\Aplicacion;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * API REST para países - Convertido a Laravel
 */
class Rpaises extends Controller
{
    public function __construct()
    {
        // Constructor Laravel
    }

    /**
     * Obtener países (GET)
     */
    public function comunicacion(Request $request, $id = null): JsonResponse
    {
        try {
            if ($id && $id != 0) {
                $data = DB::table('paises')->where('id', $id)->first();
                if (!$data) {
                    return response()->json(['error' => 'País no encontrado'], 404);
                }
            } else {
                $data = DB::table('paises')->get();
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener países: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Crear país (POST)
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            DB::table('paises')->insert($input);

            return response()->json(['message' => 'País insertado exitosamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear país: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar país (PUT)
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $input = $request->all();
            DB::table('paises')->where('id', $id)->update($input);

            return response()->json(['message' => 'País actualizado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar país: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar país (DELETE)
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::table('paises')->where('id', $id)->delete();

            return response()->json(['message' => 'País eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar país: ' . $e->getMessage()], 500);
        }
    }
}
