<?php

namespace App\Http\Controllers\tipos_compra;

use App\Http\Controllers\Controller;
use App\Models\Mequipos;
use App\Models\Mtipos_compra;
use Illuminate\Http\JsonResponse;

class TiposCompraController extends Controller
{
    private Mequipos $Mequipos;
    private Mtipos_compra $Mtipos_compra;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mtipos_compra = new Mtipos_compra();
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json($this->Mtipos_compra->getAll());
    }
}