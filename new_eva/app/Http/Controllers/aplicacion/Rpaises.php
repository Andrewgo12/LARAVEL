<?php

namespace App\Http\Controllers\aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mpaises;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class Rpaises extends Controller
{
    private Mpaises $Mpaises;
    
    public function __construct()
    {
        $this->Mpaises = new Mpaises();
    }

    public function comunicacion_get($id = 0): JsonResponse
    {
        if ($id != 0) {
            $data = DB::table('paises')->where('id', $id)->first();
        } else {
            $data = DB::table('paises')->get();
        }

        return response()->json($data, 200);
    }

    public function comunicacion_post(Request $request): JsonResponse
    {
        $input = $request->all();
        DB::table('paises')->insert($input);

        return response()->json(['Pais insertado exitosamente.'], 200);
    }

    public function comunicacion_put(Request $request, $id): JsonResponse
    {
        $input = $request->all();
        DB::table('paises')->where('id', $id)->update($input);

        return response()->json(['Pais actualizado exitosamente.'], 200);
    }

    public function comunicacion_delete($id): JsonResponse
    {
        DB::table('paises')->where('id', $id)->delete();

        return response()->json(['pais eliminado exitosamente.'], 200);
    }
}

