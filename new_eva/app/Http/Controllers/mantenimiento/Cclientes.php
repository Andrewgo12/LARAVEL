<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Controlador de Clientes de Mantenimiento - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de clientes del sistema de mantenimiento:
 * - CRUD de clientes (crear, leer, actualizar, eliminar)
 * - Vista principal con DataTables server-side processing
 * - Búsqueda por nombre, apellido y teléfono
 * - Eliminación lógica (cambio de estado)
 * - API endpoints para integración con frontend
 * - Modales para agregar, editar y mostrar detalles
 *
 * Los clientes representan las personas o entidades que solicitan
 * servicios de mantenimiento para equipos médicos del hospital.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Cclientes extends Controller
{
    private $permisos;

    /**
     * Constructor - Configurar middleware de autenticación y permisos
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permisos = app('backend_lib')->control();
    }
    
    /**
     * Mostrar vista principal de clientes
     * Incluye DataTable, modales y verificación de permisos
     *
     * @return View
     */
    public function index(): View
    {
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'clientes.list')
            ->nest('modal_add', 'clientes.modal_add')
            ->nest('modal_edit', 'clientes.modal_edit')
            ->nest('modal_show', 'clientes.modal_show')
            ->nest('footer', 'layouts.footer');
    }
    
    /**
     * Obtener clientes con paginación server-side para DataTables
     * Incluye búsqueda por nombre, apellido y teléfono
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get_server_side(Request $request): JsonResponse
    {
        $vector = $this->getClientesServerSideData($request->all());

        $respuesta = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $vector['num_filas_limit'],
            'recordsFiltered' => $vector['num_filas'],
            'data' => $vector['datos']
        ];

        return response()->json($respuesta);
    }
    
    /**
     * Crear un nuevo cliente
     * Inserta los datos del cliente en la base de datos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $this->addClienteData($request->all());
        return response()->json(['success' => true]);
    }

    /**
     * Actualizar un cliente existente
     * Modifica los datos del cliente en la base de datos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $this->updateClienteData($request->all());
        return response()->json(['success' => true]);
    }

    /**
     * Eliminar un cliente (eliminación lógica)
     * Cambia el estado a 0 en lugar de eliminar físicamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $array = ['estado' => 0];
        $this->deleteClienteData($request->all(), $array);
        return response()->json(['success' => true]);
    }

    /**
     * Mostrar detalles de un cliente específico
     * Vista modal con información completa del cliente
     *
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        $result = $this->getOneClienteData($request->input('id'));
        $param = [
            'cliente' => $result
        ];

        return view('clientes.detail', $param);
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener clientes con paginación server-side
     * Reemplaza el método get_server_side del modelo Mclientes
     *
     * @param array $param
     * @return array
     */
    private function getClientesServerSideData($param)
    {
        if ($param['length'] < 0) {
            $param['length'] = 999999999;
        }

        // Construir condiciones de búsqueda
        $searchValue = $param['search']['value'] ?? '';

        $query = DB::table('clientes')
            ->select('*')
            ->where('estado', '!=', 0)
            ->where(function($q) use ($searchValue) {
                $q->where('nombre', 'like', "%{$searchValue}%")
                  ->orWhere('telefono', 'like', "%{$searchValue}%")
                  ->orWhere('apellido', 'like', "%{$searchValue}%");
            });

        // Obtener datos con límite
        $datos = $query->limit($param['length'])
                      ->offset($param['start'])
                      ->get();

        $num_filas_limit = $datos->count();

        // Obtener total sin límite
        $num_filas = DB::table('clientes')
            ->where('estado', '!=', 0)
            ->where(function($q) use ($searchValue) {
                $q->where('nombre', 'like', "%{$searchValue}%")
                  ->orWhere('telefono', 'like', "%{$searchValue}%")
                  ->orWhere('apellido', 'like', "%{$searchValue}%");
            })
            ->count();

        return [
            'datos' => $datos,
            'num_filas_limit' => $num_filas_limit,
            'num_filas' => $num_filas
        ];
    }

    /**
     * Crear un nuevo cliente
     * Reemplaza el método add del modelo Mclientes
     *
     * @param array $param
     * @return bool
     */
    private function addClienteData($param)
    {
        return DB::table('clientes')->insert($param);
    }

    /**
     * Actualizar un cliente existente
     * Reemplaza el método update del modelo Mclientes
     *
     * @param array $param
     * @return int
     */
    private function updateClienteData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('clientes')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Eliminar un cliente (eliminación lógica)
     * Reemplaza el método delete del modelo Mclientes
     *
     * @param array $param
     * @param array $array
     * @return int
     */
    private function deleteClienteData($param, $array)
    {
        return DB::table('clientes')
            ->where('id', $param['id'])
            ->update($array);
    }

    /**
     * Obtener un cliente específico por ID
     * Reemplaza el método getOne del modelo Mclientes
     *
     * @param int $id
     * @return object|null
     */
    private function getOneClienteData($id)
    {
        return DB::table('clientes')
            ->where('id', $id)
            ->first();
    }
}