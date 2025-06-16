<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mequipos;
use App\Models\Mcambios_hdv;
use Illuminate\Http\JsonResponse;

class Ccambios_hdv extends Controller
{
    private $Mequipos;
    private $Mcambios_hdv;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mcambios_hdv = new Mcambios_hdv();
    }
    
    public function index()
    {
        // Implementar según necesidad
    }
    
    public function get_from_device(Request $request)
    {
        return view("equipos.historial.detail", [
            "cambios_hdv" => $this->Mcambios_hdv->get_from_device($request->all())
        ]);
    }
    
    public function getOne(Request $request): JsonResponse
    {
        // return response()->json($this->Mbajas->getOne($request->all()));
        return response()->json([]);
    }
}

