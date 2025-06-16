<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mcambios_ubicaciones;
use App\Models\Msedes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CambiosUbicacionesController extends Controller
{
    private Mcambios_ubicaciones $Mcambios_ubicaciones;
    private Msedes $Msedes;
    
    public function __construct()
    {
        $this->Mcambios_ubicaciones = new Mcambios_ubicaciones();
        $this->Msedes = new Msedes();
    }
    
    public function index()
    {
        // Implementación según necesidad
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json($this->Msedes->getAll());
    }
    
    public function show_cambios_ubicaciones(Request $request)
    {
        $cambios_ubicaciones = $this->Mcambios_ubicaciones->getAllByDevice($request->all());
        return view('cambios_ubicaciones.modal_detail', ['cambios_ubicaciones' => $cambios_ubicaciones]);
    }
}