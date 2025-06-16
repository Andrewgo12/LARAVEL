<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Mmodulos;
use App\Models\Macciones;

class CmodulosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAll(): JsonResponse
    {
        $mmodulos = app(Mmodulos::class);
        return response()->json($mmodulos->getAll());
    }

    public function getWithAccount(): JsonResponse
    {
        $mmodulos = app(Mmodulos::class);
        return response()->json($mmodulos->getWithAccount());
    }

    public function setear_acciones(Request $request): JsonResponse
    {
        $macciones = app(Macciones::class);
        $macciones->setear_acciones($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Acciones configuradas correctamente'
        ]);
    }
}
