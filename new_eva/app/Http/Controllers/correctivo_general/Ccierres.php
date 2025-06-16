<?php

namespace App\Http\Controllers\correctivo_general;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mcierres;
use Illuminate\Http\JsonResponse;

class Ccierres extends Controller
{
    private $Mcierres;
    
    public function __construct()
    {
        $this->Mcierres = new Mcierres();
    }
    
    public function get()
    {
        // Implementar según necesidad
    }
    
    public function getUsed(): JsonResponse
    {
        return response()->json($this->Mcierres->getUsed());
    }
}
