<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Msedes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SedesController extends Controller
{
    private $servicios;
    private Msedes $Msedes;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->Msedes = new Msedes();
    }
    
    public function index()
    {
        session(['controlador' => request()->segment(2)]);
    }

    /* Refactoring */
    public function ServiceGetAll(): JsonResponse
    {
        return response()->json($this->Msedes->getAllServices());
    }
    
    public function ServiceGetOne($id): JsonResponse
    {
        return response()->json($this->Msedes->getOneService($id));
    }

    public function getAll(): JsonResponse
    {
        return response()->json($this->Msedes->getAll());
    }
    
    public function cambiar_sesion_sede(Request $request)
    {
        session(['sede_id' => $request->input('sede_seleccionada')]);
    }
}