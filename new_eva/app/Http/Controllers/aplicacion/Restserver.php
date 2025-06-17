<?php

namespace App\Http\Controllers\Aplicacion;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Mequipos;

/**
 * REST Server - Convertido a Laravel
 */
class Restserver extends Controller
{
    public function __construct()
    {
        // Constructor Laravel
    }

    public function test(): JsonResponse
    {
        try {
            $array = Mequipos::getSome();
            return response()->json($array, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener datos'], 500);
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            $data = "algo";
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en servidor'], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $data = "algo";
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en servidor'], 500);
        }
    }
}
