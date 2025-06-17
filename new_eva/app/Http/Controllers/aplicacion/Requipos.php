<?php

namespace App\Http\Controllers\aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador REST API de Equipos - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * API RESTful para la gestión de equipos médicos:
 * - GET: Obtener listado de equipos con información completa
 * - POST: Crear nuevos equipos
 * - PUT: Actualizar equipos existentes
 * - DELETE: Eliminar equipos
 *
 * Proporciona endpoints para comunicación externa con sistemas de terceros
 * que necesitan acceder a la información de equipos médicos del hospital.
 * Incluye datos de equipos, servicios, sedes y áreas.
 *
 * Configurado con CORS para permitir acceso desde aplicaciones externas.
 * Filtra equipos por tipo_id = 1 (equipos médicos).
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Requipos extends Controller
{
    /**
     * Constructor - Sin middleware de autenticación para API externa
     */
    public function __construct()
    {
        // Sin middleware de autenticación para permitir acceso externo
    }

    /**
     * Enrutador principal de comunicación REST
     * Distribuye las peticiones según el método HTTP
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function comunicacion(Request $request, $id = 0)
    {
        $method = strtolower($request->method());
        return $this->{"comunicacion_$method"}($request, $id);
    }

    /**
     * Obtener listado de equipos médicos (GET)
     * Retorna información completa de equipos con servicios, sedes y áreas
     * Configurado con CORS para acceso externo
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function comunicacion_get(Request $request, $id = 0): JsonResponse
    {
        // Configurar CORS para acceso externo
        header('Access-Control-Allow-Origin: *');

        try {
            $datos = $this->getEquiposData();
            return response()->json($datos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener equipos'], 500);
        }
    }
    
    /**
     * Crear nuevo equipo médico (POST)
     * Inserta un nuevo equipo en la base de datos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function comunicacion_post(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $this->createEquipoData($input);
            return response()->json(['Equipo insertado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al insertar equipo'], 500);
        }
    }

    /**
     * Actualizar equipo médico existente (PUT)
     * Modifica los datos de un equipo específico
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function comunicacion_put(Request $request, $id): JsonResponse
    {
        try {
            $input = $request->all();
            $this->updateEquipoData($id, $input);
            return response()->json(['Equipo actualizado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar equipo'], 500);
        }
    }

    /**
     * Eliminar equipo médico (DELETE)
     * Elimina físicamente un equipo de la base de datos
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function comunicacion_delete(Request $request, $id): JsonResponse
    {
        try {
            $this->deleteEquipoData($id);
            return response()->json(['Equipo eliminado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar equipo'], 500);
        }
    }

    // Private methods for database operations

    /**
     * Obtener datos de equipos médicos con información relacionada
     * Reemplaza la consulta SQL directa del método original
     *
     * @return \Illuminate\Support\Collection
     */
    private function getEquiposData()
    {
        $query = "
            SELECT
                e.name AS nombre,
                e.marca AS marca,
                e.modelo AS modelo,
                e.code AS codigo,
                e.serial AS serie,
                s.name AS servicio,
                sed.name AS sede,
                a.name AS area
            FROM
                equipos e
            LEFT JOIN servicios s ON
                s.id = e.servicio_id
            LEFT JOIN sedes sed ON
                sed.id = s.sede_id
            LEFT JOIN areas a ON
                e.area_id = a.id
            WHERE
                e.tipo_id = 1
        ";

        return DB::select($query);
    }

    /**
     * Crear un nuevo equipo en la base de datos
     * Reemplaza la inserción directa del método original
     *
     * @param array $input
     * @return bool
     */
    private function createEquipoData($input)
    {
        return DB::table('equipos')->insert($input);
    }

    /**
     * Actualizar un equipo existente en la base de datos
     * Reemplaza la actualización directa del método original
     *
     * @param int $id
     * @param array $input
     * @return int
     */
    private function updateEquipoData($id, $input)
    {
        return DB::table('equipos')->where('id', $id)->update($input);
    }

    /**
     * Eliminar un equipo de la base de datos
     * Reemplaza la eliminación directa del método original
     *
     * @param int $id
     * @return int
     */
    private function deleteEquipoData($id)
    {
        return DB::table('equipos')->where('id', $id)->delete();
    }
}

