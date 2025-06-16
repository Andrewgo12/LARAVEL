<?php

namespace App\Http\Controllers;

use App\Models\Mmanuales;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    private Mmanuales $Mmanuales;
    
    public function __construct()
    {
        $this->Mmanuales = new Mmanuales();
    }
    
    public function index()
    {
        // Método vacío mantenido para compatibilidad
    }
    
    public function get_manuals(): JsonResponse
    {
        $manuales = $this->Mmanuales->getAll();
        return response()->json($manuales, 200);
    }
    
    public function get_manual($id): JsonResponse
    {
        $manual = $this->Mmanuales->getOne($id);
        
        if ($manual) {
            return response()->json($manual, 200);
        } else {
            return response()->json(['error' => 'No se encontró el manual'], 404);
        }
    }
}