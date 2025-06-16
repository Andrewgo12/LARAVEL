<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mproveedores_mantenimiento;
use Illuminate\Http\JsonResponse;

class ProveedoresMantenimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }
    }
    
    public function get()
    {
        // return response()->json(app(Mproveedores_mantenimiento::class)->get());
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json(app(Mproveedores_mantenimiento::class)->getAll());
    }
    
    public function getOne(Request $request): JsonResponse
    {
        // return response()->json(app(Mproveedores_mantenimiento::class)->getOne($request->all()));
        return response()->json([]);
    }
    
    public function add(Request $request): JsonResponse
    {
        // Implementación pendiente
        return response()->json(['success' => true]);
    }
    
    public function update(Request $request): JsonResponse
    {
        // Implementación pendiente
        return response()->json(['success' => true]);
    }
    
    public function delete(Request $request): JsonResponse
    {
        // app(Mproveedores_mantenimiento::class)->delete($request->all());
        return response()->json(['success' => true]);
    }
    
    public function show(Request $request): JsonResponse
    {
        // Implementación pendiente
        return response()->json([]);
    }
}