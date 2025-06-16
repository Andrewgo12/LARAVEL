<?php

namespace App\Http\Controllers\orden;

use App\Http\Controllers\Controller;
use App\Models\Mestados;
use Illuminate\Http\JsonResponse;

class EstadosController extends Controller
{
    private Mestados $Mestados;
    
    public function __construct()
    {
        $this->Mestados = new Mestados();
    }

    public function getAll(): JsonResponse
    {
        return response()->json($this->Mestados->getAll());
    }
    
    public function getUsed(): JsonResponse
    {
        return response()->json($this->Mestados->getUsed());
    }
}