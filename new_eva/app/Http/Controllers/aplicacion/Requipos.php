<?php

namespace App\Http\Controllers\aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mequipos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class Requipos extends Controller
{
    private Mequipos $Mequipos;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
    }

    public function comunicacion(Request $request, $id = 0)
    {
        $method = strtolower($request->method());
        return $this->{"comunicacion_$method"}($request, $id);
    }

    public function comunicacion_get(Request $request, $id = 0): JsonResponse
    {
        header('Access-Control-Allow-Origin: *');
        
        $query = "
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
            LEFT JOIN servicios s ON
                s.id = e.servicio_id
            LEFT JOIN sedes sed ON
                sed.id = s.sede_id
            LEFT JOIN areas a ON
                e.area_id = a.id
            WHERE
                e.tipo_id = 1
        ";
        $datos = DB::select($query);

        return response()->json($datos, 200);
    }
    
    public function comunicacion_post(Request $request): JsonResponse
    {
        $input = $request->all();
        DB::table('equipos')->insert($input);

        return response()->json(['Equipo insertado exitosamente.'], 200);
    }
    
    public function comunicacion_put(Request $request, $id): JsonResponse
    {
        $input = $request->all();
        DB::table('equipos')->where('id', $id)->update($input);

        return response()->json(['Equipo actualizado exitosamente.'], 200);
    }
    
    public function comunicacion_delete(Request $request, $id): JsonResponse
    {
        DB::table('equipos')->where('id', $id)->delete();

        return response()->json(['Equipo eliminado exitosamente.'], 200);
    }
}

