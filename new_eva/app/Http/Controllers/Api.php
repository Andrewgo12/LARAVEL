<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Mmanuales;

class Api extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'API HUV funcionando correctamente']);
    }

    public function getManuals(): JsonResponse
    {
        try {
            $manuales = Mmanuales::getAll();
            return response()->json($manuales, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener manuales'], 500);
        }
    }

    public function getManual($id): JsonResponse
    {
        try {
            $manual = Mmanuales::getOne($id);
            if ($manual) {
                return response()->json($manual, 200);
            } else {
                return response()->json(['error' => 'No se encontró el manual'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el manual'], 500);
        }
    }
}
