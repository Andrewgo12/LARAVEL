<?php

namespace App\Http\Controllers\orden;

use App\Http\Controllers\Controller;
use App\Models\Mtrabajos;
use Illuminate\Http\JsonResponse;

class TrabajosController extends Controller
{
    private Mtrabajos $Mtrabajos;
    
    public function __construct()
    {
        $this->Mtrabajos = new Mtrabajos();
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json($this->Mtrabajos->getAll());
    }
}