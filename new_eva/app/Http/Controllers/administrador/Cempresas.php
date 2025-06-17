<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mempresas;
use Illuminate\Http\JsonResponse;

class Cempresas extends Controller
{
    protected Mempresas $Mempresas;

    public function __construct()
    {
        $this->Mempresas = new Mempresas();
        // Eliminado: $this->permisos = app('backend_lib')->control(); // vestigio de CodeIgniter
    }

    public function index(): JsonResponse
    {
        // Devuelve todas las empresas o una vista si es necesario
        return response()->json($this->Mempresas->getAll());
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->all();

        $empresa = $this->Mempresas->create($data);

        return response()->json([
            'message' => 'Empresa creada exitosamente',
            'data' => $empresa,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $empresa = $this->Mempresas->find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $empresa->update($request->all());

        return response()->json([
            'message' => 'Empresa actualizada exitosamente',
            'data' => $empresa,
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $empresa = $this->Mempresas->find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $empresa->delete();

        return response()->json(['message' => 'Empresa eliminada exitosamente']);
    }

    public function getAll(): JsonResponse
    {
        return response()->json($this->Mempresas->getAll());
    }

    public function getOne(int $id): JsonResponse
    {
        $empresa = $this->Mempresas->find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json($empresa);
    }
}
