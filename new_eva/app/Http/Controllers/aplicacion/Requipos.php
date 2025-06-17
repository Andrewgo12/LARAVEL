<?php

namespace App\Http\Controllers\Aplicacion;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Mequipos;

/**
 * API REST para equipos - Convertido a Laravel
 */
class Requipos extends Controller
{
    public function __construct()
    {
        // Constructor Laravel
    }

    /**
     * Obtener equipos (GET)
     */
    public function comunicacion(Request $request, $id = null): JsonResponse
    {
        try {
            if ($id) {
                $data = DB::table('equipos')->where('id', $id)->first();
                if (!$data) {
                    return response()->json(['error' => 'Equipo no encontrado'], 404);
                }
            } else {
                $data = DB::select("
                    SELECT
                        e.name AS nombre,
                        e.marca AS marca,
                        e.modelo AS modelo,
                        e.code AS codigo,
                        e.serial AS serie,
                        s.name AS servicio,
                        sed.name AS sede,
                        a.name AS area
                    FROM
                        equipos e
                    LEFT JOIN servicios s ON s.id = e.servicio_id
                    LEFT JOIN sedes sed ON sed.id = s.sede_id
                    LEFT JOIN areas a ON e.area_id = a.id
                    WHERE
                        e.tipo_id = 1
                ");
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener equipos: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Crear equipo (POST)
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            DB::table('equipos')->insert($input);

            return response()->json(['message' => 'Equipo insertado exitosamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear equipo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar equipo (PUT)
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $input = $request->all();
            DB::table('equipos')->where('id', $id)->update($input);

            return response()->json(['message' => 'Equipo actualizado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar equipo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar equipo (DELETE)
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::table('equipos')->where('id', $id)->delete();

            return response()->json(['message' => 'Equipo eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar equipo: ' . $e->getMessage()], 500);
        }
    }
}
