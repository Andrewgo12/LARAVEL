<?php

namespace App\Http\Controllers\aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador REST API de Países - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * API RESTful para la gestión de países:
 * - GET: Obtener listado de países o país específico por ID
 * - POST: Crear nuevos países
 * - PUT: Actualizar países existentes
 * - DELETE: Eliminar países
 *
 * Proporciona endpoints para comunicación externa con sistemas de terceros
 * que necesitan acceder a la información de países para formularios,
 * direcciones, ubicaciones geográficas, etc.
 *
 * Configurado sin autenticación para permitir acceso desde aplicaciones externas.
 * Maneja operaciones CRUD completas sobre la tabla 'paises'.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Rpaises extends Controller
{
    /**
     * Constructor - Sin middleware de autenticación para API externa
     */
    public function __construct()
    {
        // Sin middleware de autenticación para permitir acceso externo
    }

    /**
     * Obtener países (GET)
     * Retorna todos los países o un país específico por ID
     *
     * @param int $id ID del país (opcional, 0 para obtener todos)
     * @return JsonResponse
     */
    public function comunicacion_get($id = 0): JsonResponse
    {
        try {
            if ($id != 0) {
                $data = $this->getPaisData($id);
            } else {
                $data = $this->getAllPaisesData();
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener países'], 500);
        }
    }

    /**
     * Crear nuevo país (POST)
     * Inserta un nuevo país en la base de datos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function comunicacion_post(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $this->createPaisData($input);
            return response()->json(['Pais insertado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al insertar país'], 500);
        }
    }

    /**
     * Actualizar país existente (PUT)
     * Modifica los datos de un país específico
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function comunicacion_put(Request $request, $id): JsonResponse
    {
        try {
            $input = $request->all();
            $this->updatePaisData($id, $input);
            return response()->json(['Pais actualizado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar país'], 500);
        }
    }

    /**
     * Eliminar país (DELETE)
     * Elimina físicamente un país de la base de datos
     *
     * @param int $id
     * @return JsonResponse
     */
    public function comunicacion_delete($id): JsonResponse
    {
        try {
            $this->deletePaisData($id);
            return response()->json(['pais eliminado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar país'], 500);
        }
    }

    // Private methods for database operations

    /**
     * Obtener todos los países
     * Reemplaza la consulta directa del método original
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllPaisesData()
    {
        return DB::table('paises')->get();
    }

    /**
     * Obtener un país específico por ID
     * Reemplaza la consulta directa del método original
     *
     * @param int $id
     * @return object|null
     */
    private function getPaisData($id)
    {
        return DB::table('paises')->where('id', $id)->first();
    }

    /**
     * Crear un nuevo país en la base de datos
     * Reemplaza la inserción directa del método original
     *
     * @param array $input
     * @return bool
     */
    private function createPaisData($input)
    {
        return DB::table('paises')->insert($input);
    }

    /**
     * Actualizar un país existente en la base de datos
     * Reemplaza la actualización directa del método original
     *
     * @param int $id
     * @param array $input
     * @return int
     */
    private function updatePaisData($id, $input)
    {
        return DB::table('paises')->where('id', $id)->update($input);
    }

    /**
     * Eliminar un país de la base de datos
     * Reemplaza la eliminación directa del método original
     *
     * @param int $id
     * @return int
     */
    private function deletePaisData($id)
    {
        return DB::table('paises')->where('id', $id)->delete();
    }
}

