<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador de Categorías de Mantenimiento - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de categorías de mantenimiento:
 * - CRUD de categorías (crear, leer, actualizar, eliminar)
 * - Vista principal con DataTables server-side processing
 * - Validación de unicidad de nombres y descripciones
 * - Eliminación lógica (cambio de estado)
 * - API endpoints para integración con frontend
 * - Modales para agregar, editar y mostrar detalles
 *
 * Las categorías clasifican los diferentes tipos de mantenimiento
 * que se pueden realizar en los equipos médicos del hospital.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Ccategorias extends Controller
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
     * Mostrar vista principal de categorías
     * Incluye DataTable, modales y verificación de permisos
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Session::has('login')) {
            return redirect('auth');
        }

        $data = [
            'permisos' => $this->permisos
        ];

        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'categorias.list', $data)
            ->nest('modal_add', 'categorias.modal_add')
            ->nest('modal_edit', 'categorias.modal_edit')
            ->nest('modal_show', 'categorias.modal_show')
            ->nest('footer', 'layouts.footer');
    }
    
    /**
     * Obtener todas las categorías activas
     * API endpoint para poblar selectores y listas
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return response()->json($this->getCategoriasData());
    }

    /**
     * Obtener categorías con paginación server-side para DataTables
     * Incluye búsqueda y filtrado
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get_server_side(Request $request): JsonResponse
    {
        $vector = $this->getCategoriasServerSideData($request->all());

        $respuesta = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $vector['num_filas_limit'],
            'recordsFiltered' => $vector['num_filas'],
            'data' => $vector['datos']
        ];

        return response()->json($respuesta);
    }
    
    /**
     * Crear una nueva categoría
     * Valida unicidad de nombre y descripción
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:categorias,nombre',
            'descripcion' => 'required|unique:categorias,descripcion',
        ]);

        if (!$validator->fails()) {
            $this->addCategoriaData($request->all());
            return response()->json(1);
        } else {
            $error = [
                'nombre' => $validator->errors()->first('nombre'),
                'descripcion' => $validator->errors()->first('descripcion'),
            ];

            return response()->json($error);
        }
    }
    
    /**
     * Actualizar una categoría existente
     * Valida unicidad de nombre dinámicamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $categoriaActual = $this->getOneCategoriaData($request->input('id'));

        $rules = [
            'descripcion' => 'required',
        ];

        if ($request->input('nombre') == $categoriaActual->nombre) {
            $rules['nombre'] = 'required';
        } else {
            $rules['nombre'] = 'required|unique:categorias,nombre';
        }

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $this->updateCategoriaData($request->all());
            return response()->json(1);
        } else {
            $error = [
                'nombre' => $validator->errors()->first('nombre'),
                'descripcion' => $validator->errors()->first('descripcion')
            ];

            return response()->json($error);
        }
    }
    
    /**
     * Eliminar una categoría (eliminación lógica)
     * Cambia el estado a 0 en lugar de eliminar físicamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $array = ['estado' => 0];
        $this->deleteCategoriaData($request->all(), $array);
        return response()->json(['success' => true]);
    }

    /**
     * Mostrar detalles de una categoría específica
     * Vista modal con información completa
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $result = $this->getOneCategoriaData($request->input('id'));
        $param = [
            'categoria' => $result
        ];

        return view('categorias.detail', $param);
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener todas las categorías activas
     * Reemplaza el método get del modelo Mcategorias
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCategoriasData()
    {
        return DB::table('categorias')
            ->select('*')
            ->where('estado', '!=', 0)
            ->get();
    }

    /**
     * Obtener categorías con paginación server-side
     * Reemplaza el método get_server_side del modelo Mcategorias
     *
     * @param array $param
     * @return array
     */
    private function getCategoriasServerSideData($param)
    {
        if ($param['length'] < 0) {
            $param['length'] = 999999999;
        }

        // Construir condiciones de búsqueda
        $searchValue = $param['search']['value'] ?? '';
        $nombreFilter = $param['Snombre'] ?? '';

        $query = DB::table('categorias')
            ->select('*')
            ->where('estado', '!=', 0)
            ->where('nombre', 'like', "%{$nombreFilter}%")
            ->where(function($q) use ($searchValue) {
                $q->where('nombre', 'like', "%{$searchValue}%")
                  ->orWhere('descripcion', 'like', "%{$searchValue}%");
            });

        // Obtener datos con límite
        $datos = $query->limit($param['length'])
                      ->offset($param['start'])
                      ->get();

        $num_filas_limit = $datos->count();

        // Obtener total sin límite
        $num_filas = DB::table('categorias')
            ->where('estado', '!=', 0)
            ->where('nombre', 'like', "%{$nombreFilter}%")
            ->where(function($q) use ($searchValue) {
                $q->where('nombre', 'like', "%{$searchValue}%")
                  ->orWhere('descripcion', 'like', "%{$searchValue}%");
            })
            ->count();

        return [
            'datos' => $datos,
            'num_filas_limit' => $num_filas_limit,
            'num_filas' => $num_filas
        ];
    }

    /**
     * Obtener una categoría específica por ID
     * Reemplaza el método getOne del modelo Mcategorias
     *
     * @param int $id
     * @return object|null
     */
    private function getOneCategoriaData($id)
    {
        return DB::table('categorias')
            ->where('id', $id)
            ->first();
    }

    /**
     * Crear una nueva categoría
     * Reemplaza el método add del modelo Mcategorias
     *
     * @param array $param
     * @return bool
     */
    private function addCategoriaData($param)
    {
        return DB::table('categorias')->insert($param);
    }

    /**
     * Actualizar una categoría existente
     * Reemplaza el método update del modelo Mcategorias
     *
     * @param array $param
     * @return int
     */
    private function updateCategoriaData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('categorias')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Eliminar una categoría (eliminación lógica)
     * Reemplaza el método delete del modelo Mcategorias
     *
     * @param array $param
     * @param array $array
     * @return int
     */
    private function deleteCategoriaData($param, $array)
    {
        return DB::table('categorias')
            ->where('id', $param['id'])
            ->update($array);
    }
}