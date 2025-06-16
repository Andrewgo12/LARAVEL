<?php

namespace App\Http\Controllers\correctivo_general;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mtipos_fallas;
use Illuminate\Http\JsonResponse;

class Ctipos_fallas extends Controller
{
    private Mtipos_fallas $Mtipos_fallas;
    
    public function __construct()
    {
        $this->Mtipos_fallas = new Mtipos_fallas();
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json($this->Mtipos_fallas->get());
    }
}


