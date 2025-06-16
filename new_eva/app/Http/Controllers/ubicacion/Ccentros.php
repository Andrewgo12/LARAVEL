<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mcentros;
use Illuminate\Http\JsonResponse;

class CentrosController extends Controller
{
    private Mcentros $Mcentros;
    
    public function __construct()
    {
        $this->Mcentros = new Mcentros();
    }
    
    public function index()
    {
        // Implementación según necesidad
    }

    // Refactoring
    public function ServiceGetAll(): JsonResponse
    {
        return response()->json($this->Mcentros->getAllCentros());
    }
    
    public function ServiceGetOne($id): JsonResponse
    {
        return response()->json($this->Mcentros->getOneCentro($id));
    }
}