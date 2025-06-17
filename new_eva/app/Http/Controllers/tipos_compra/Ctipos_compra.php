<?php

namespace App\Http\Controllers\tipos_compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Controlador de Tipos de Compra - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión de tipos de compra para órdenes de adquisición:
 * - API endpoint para obtener todos los tipos de compra
 * - Integración con frontend para selects de tipos de compra
 * - Soporte para clasificación de órdenes de compra
 *
 * Los tipos de compra clasifican las diferentes modalidades de adquisición
 * de equipos médicos según la normativa de contratación pública.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Ctipos_compra extends Controller
{
    /**
     * Constructor - Configurar middleware de autenticación
     */
    public function __construct()
    {
        // Middleware de autenticación para proteger todas las rutas
        $this->middleware('auth');
    }

    /**
     * Obtener todos los tipos de compra
     * API endpoint que retorna la lista completa de tipos de compra ordenados alfabéticamente
     * Mantiene compatibilidad total con el frontend existente
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return response()->json($this->getAllTiposCompraData());
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener todos los tipos de compra ordenados alfabéticamente
     * Reemplaza el método getAll del modelo Mtipos_compra de CodeIgniter
     * Mantiene exactamente la misma estructura de datos de salida
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllTiposCompraData()
    {
        return DB::table('tipos_compra')
            ->select('*')
            ->orderBy('tipo_compra', 'asc')
            ->get();
    }
}