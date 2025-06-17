<?php

namespace App\Http\Controllers\aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

/**
 * Controlador REST Server - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Servidor REST API para proporcionar datos de equipos médicos:
 * - Endpoint de prueba para obtener equipos activos
 * - Endpoints de usuario y índice para funcionalidades futuras
 * - API sin autenticación para acceso externo
 *
 * Proporciona información de equipos médicos incluyendo:
 * - Datos básicos del equipo (nombre, marca, modelo, serie, código)
 * - Información de ubicación (servicio, área, sede)
 * - Filtrado por tipo de equipo médico (tipo_id = 1)
 * - Exclusión de equipos dados de baja (estadoequipo_id != 6)
 *
 * Configurado para permitir acceso desde aplicaciones externas
 * con soporte para CORS cuando sea necesario.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Restserver extends Controller
{
  /**
   * Constructor - Sin middleware de autenticación para API externa
   */
  public function __construct()
  {
    // Sin middleware de autenticación para permitir acceso externo
  }

  /**
   * Endpoint de prueba para obtener equipos médicos
   * Retorna listado de equipos activos con información de ubicación
   * Incluye comentarios para configuración CORS si es necesaria
   *
   * @return JsonResponse
   */
  public function test(): JsonResponse
  {
    try {
      $array = $this->getEquiposSomeData();
      // Configuración CORS comentada - descomentar si es necesaria
      //header("Access-Control-Origin: http://localhost:8100");
      //header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      return response()->json($array);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al obtener equipos'], 500);
    }
  }

  /**
   * Endpoint de usuario (placeholder)
   * Método preparado para funcionalidades futuras
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function user(Request $request): JsonResponse
  {
    $data = "algo";
    return response()->json($data);
  }

  /**
   * Endpoint de índice (placeholder)
   * Método preparado para funcionalidades futuras
   *
   * @return JsonResponse
   */
  public function indext(): JsonResponse
  {
    $data = "algo";
    return response()->json($data, 200);
  }

  // Private methods for database operations (replacing model calls)

  /**
   * Obtener algunos equipos médicos con información relacionada
   * Reemplaza el método get_some del modelo Mequipos
   * Mantiene exactamente la misma estructura de datos de salida
   *
   * @return \Illuminate\Support\Collection
   */
  private function getEquiposSomeData()
  {
    return DB::table('equipos as e')
      ->select([
        'e.name as nombre',
        'e.serial as serie',
        'e.code as codigo',
        'e.marca as marca',
        'e.modelo as modelo',
        's.name as servicio',
        'a.name as area',
        'sed.name as sede'
      ])
      ->leftJoin('servicios as s', 's.id', '=', 'e.servicio_id')
      ->leftJoin('areas as a', 'a.id', '=', 'e.area_id')
      ->leftJoin('sedes as sed', 'sed.id', '=', 's.sede_id')
      ->where('e.tipo_id', 1)
      ->where('e.estadoequipo_id', '!=', 6)
      ->get();
  }
}

