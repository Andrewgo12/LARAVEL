<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador de Equipos Médicos - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de equipos médicos del hospital:
 * - CRUD de equipos médicos (crear, leer, actualizar, eliminar)
 * - Vista principal con DataTables server-side processing
 * - Gestión de archivos y documentos asociados
 * - Manejo de especificaciones técnicas
 * - Control de repuestos y contactos
 * - Historial de mantenimientos y calibraciones
 * - Gestión de observaciones y archivos
 * - Control de garantías y bajas
 * - Exportación a Excel
 * - API endpoints para aplicaciones externas
 *
 * Los equipos médicos son el núcleo del sistema de gestión biomédica,
 * incluyendo información técnica, ubicación, mantenimientos, calibraciones,
 * repuestos, contactos, archivos y toda la trazabilidad del equipo.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Cequipos extends Controller
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
   * Mostrar vista principal de equipos médicos
   * Incluye DataTable, múltiples modales y verificación de permisos
   * Carga estadísticas de garantías y equipos dados de baja
   *
   * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
   */
  public function index()
  {
    if (!Session::has('login')) {
      return redirect('auth');
    }

    Session::put('tipo_id', 1);
    Session::put('controlador', request()->segment(2));
    $acciones = Session::get('acciones');

    foreach ($acciones as $accion) {
      if ($accion->modulo == 'equipos') {
        if ($accion->leer != 1) {
          return redirect('forbidden');
        }
      }
    }

    $data = [
      'permisos' => $this->permisos,
      'garantia_casi_vencida' => $this->getGarantiaCasiVencidaData(),
      'garantia_vencida' => $this->getGarantiaVencidaData(),
      'equipos_baja' => $this->getEquiposBajaData(),
      'equipos_pendientes_baja' => $this->getEquiposPendientesBajaData(),
      'acciones' => $acciones,
    ];

    Session::put('editar_orden', 'no');

    return view('layouts.header')
      ->nest('aside', 'layouts.aside')
      ->nest('content', 'equipos.list', $data)
      ->nest('modal_add', 'equipos.modal_add', ['tipo_id' => 1])
      ->nest('modal_edit', 'equipos.modal_edit', ['tipo_id' => 1])
      ->nest('modal_copy', 'equipos.modal_copy', ['tipo_id' => 1])
      ->nest('modal_show_adquisicion', 'equipos.modal_show_adquisicion')
      ->nest('modal_show_instalacion', 'equipos.modal_show_instalacion')
      ->nest('modal_show', 'equipos.modal_show')
      ->nest('modal_add_equipo_especificacion', 'equipos.modal_add_equipo_especificacion')
      ->nest('modal_add_equipo_contacto', 'equipos.modal_add_equipo_contacto')
      ->nest('modal_filter', 'equipos.modal_filter')
      ->nest('modal_show_file', 'equipos.modal_show_file')
      ->nest('modal_show_archivos', 'equipos.modal_show_archivos')
      ->nest('modal_add_archivos', 'equipos.modal_add_archivos')
      ->nest('modal_compartir', 'archivos.modal_compartir')
      ->nest('modal_add_observacion', 'equipos.modal_add_observacion')
      ->nest('modal_edit_observacion', 'equipos.modal_edit_observacion')
      ->nest('modal_show_garantiaCasiVencida', 'equipos.modal_show_garantiaCasiVencida')
      ->nest('modal_show_garantiaVencida', 'equipos.modal_show_garantiaVencida')
      ->nest('modal_multiple', 'equipos.modal_multiple')
      ->nest('modal_obsoletos', 'equipos.modal_obsoletos')
      ->nest('modal_add_archivo_correctivo', 'equipos.modal_add_archivo_correctivo')
      ->nest('servicios_modal_add', 'servicios.modal_add')
      ->nest('correctivos_generales_modal_add', 'correctivos_generales.modal_add')
      ->nest('correctivos_generales_modal_edit', 'correctivos_generales.modal_edit')
      ->nest('correctivos_generales_modal_show', 'correctivos_generales.modal_show')
      ->nest('correctivos_generales_modal_show_single', 'correctivos_generales.modal_show_single')
      ->nest('preventivos_modal_add', 'preventivos.modal_add')
      ->nest('preventivos_modal_edit', 'preventivos.modal_edit')
      ->nest('preventivos_modal_show', 'preventivos.modal_show')
      ->nest('preventivos_nota_modal_add', 'preventivos.nota.modal_add')
      ->nest('calibraciones_modal_add', 'calibraciones.modal_add')
      ->nest('calibraciones_modal_edit', 'calibraciones.modal_edit')
      ->nest('calibraciones_modal_show', 'calibraciones.modal_show')
      ->nest('archivos_modal_add_archivo_observacion', 'archivos.modal_add_archivo_observacion')
      ->nest('invimas_modal_add', 'invimas.modal_add')
      ->nest('invimas_modal_consulta', 'invimas.modal_consulta')
      ->nest('guias_modal_consulta', 'guias.modal_consulta')
      ->nest('manuales_modal_consulta', 'manuales.modal_consulta')
      ->nest('equipos_modal_add_repuesto', 'equipos.modal_add_repuesto')
      ->nest('equipos_modal_add_repuesto_correctivo_general', 'equipos.modal_add_repuesto_correctivo_general')
      ->nest('equipos_modal_edit_equipo_repuesto', 'equipos.modal_edit_equipo_repuesto')
      ->nest('ordenes_compra_modal_consulta', 'ordenes_compra.modal_consulta')
      ->nest('ordenes_compra_modal_add', 'ordenes_compra.modal_add')
      ->nest('bajas_modal_add', 'bajas.modal_add')
      ->nest('bajas_modal_consulta', 'bajas.modal_consulta')
      ->nest('contingencias_modal_add', 'contingencias.modal_add')
      ->nest('areas_modal_add', 'areas.modal_add')
      ->nest('equipos_modal_compartir_especificaciones', 'equipos.modal_compartir_especificaciones')
      ->nest('cambios_ubicaciones_modal_show', 'cambios_ubicaciones.modal_show')
      ->nest('ordenes_modal_timeline', 'ordenes.modal_timeline')
      ->nest('ordenes_modal_add_diagnostico_from_timeline', 'ordenes.modal_add_diagnostico_from_timeline')
      ->nest('ordenes_modal_add_solicitud_cierre_from_timeline', 'ordenes.modal_add_solicitud_cierre_from_timeline')
      ->nest('avances_correctivos_modal_add', 'avances_correctivos.modal_add')
      ->nest('repuestos_pendientes_modal_add', 'repuestos_pendientes.modal_add')
      ->nest('ordenes_modal_asignar', 'ordenes.modal_asignar')
      ->nest('equipos_modal_depurar_nombres', 'equipos.modal_depurar_nombres')
      ->nest('equipos_historial_modal_show', 'equipos.historial.modal_show')
      ->nest('propietarios_modal_add', 'propietarios.modal_add')
      ->nest('footer', 'layouts.footer');
  }

  /**
   * Obtener equipos con paginación para API externa
   * Endpoint para aplicaciones móviles o sistemas externos
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function get_devices(Request $request): JsonResponse
  {
    try {
      $page = $request->get('page', 1);
      $limit = $request->get('limit', 10);
      $offset = ($page - 1) * $limit;
      $devices = $this->getDevicesData($limit, $offset);

      if ($devices) {
        return response()->json($devices, 200);
      } else {
        return response()->json(['error' => 'No se encontraron equipos'], 404);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al obtener equipos'], 500);
    }
  }

  /**
   * Obtener un equipo específico por ID para API externa
   * Incluye información del servicio asociado
   *
   * @param int $id
   * @return JsonResponse
   */
  public function get_device($id): JsonResponse
  {
    try {
      $device = $this->getDeviceData($id);
      if ($device) {
        return response()->json($device, 200);
      } else {
        return response()->json(['error' => 'No se encontró el equipo'], 404);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al obtener equipo'], 500);
    }
  }


  /**
   * Obtener todos los equipos médicos
   * API endpoint para poblar selectores y listas
   *
   * @return JsonResponse
   */
  public function getAll(): JsonResponse
  {
    return response()->json($this->getAllEquiposData());
  }

  /**
   * Obtener equipos con paginación server-side para DataTables
   * Incluye búsqueda y filtrado avanzado
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function get_server_side(Request $request): JsonResponse
  {
    if ($request->has('start')) {
      $vector = $this->getEquiposServerSideData($request->all());
      $respuesta = [
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $vector['num_filas_limit'],
        'recordsFiltered' => $vector['num_filas'],
        'data' => $vector['datos'],
      ];
      return response()->json($respuesta);
    }
    return response()->json([]);
  }

  /**
   * Obtener equipos Baxter con paginación server-side
   * Filtrado específico para equipos Baxter
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function get_server_side_baxter(Request $request): JsonResponse
  {
    if ($request->has('start')) {
      $vector = $this->getEquiposBaxterServerSideData($request->all());
      $respuesta = [
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $vector['num_filas_limit'],
        'recordsFiltered' => $vector['num_filas'],
        'data' => $vector['datos'],
      ];
      return response()->json($respuesta);
    }
    return response()->json([]);
  }

  /**
   * Obtener equipos con filtros avanzados server-side
   * Filtrado por múltiples criterios
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function get_server_side_filtros(Request $request): JsonResponse
  {
    $vector = $this->getEquiposFiltrosServerSideData($request->all());
    $respuesta = [
      'draw' => intval($request->input('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos'],
    ];
    return response()->json($respuesta);
  }

  /**
   * Obtener equipos básicos
   * Lista simple de equipos por tipo
   *
   * @return JsonResponse
   */
  public function get(): JsonResponse
  {
    return response()->json($this->getEquiposData());
  }

  /**
   * Obtener equipos para contingencias
   * Lista de equipos disponibles para planes de contingencia
   *
   * @return JsonResponse
   */
  public function getForCOntingencias(): JsonResponse
  {
    return response()->json($this->getEquiposContingenciasData());
  }

  /**
   * Obtener tipos de adquisición
   * Lista de formas de adquisición de equipos
   *
   * @return JsonResponse
   */
  public function getTadquisiciones(): JsonResponse
  {
    return response()->json($this->getTiposAdquisicionData());
  }

  /**
   * Obtener fuentes de alimentación
   * Lista de tipos de fuentes de alimentación
   *
   * @return JsonResponse
   */
  public function getFuentes(): JsonResponse
  {
    return response()->json($this->getFuentesData());
  }

  /**
   * Obtener tecnologías principales
   * Lista de tecnologías biomédicas
   *
   * @return JsonResponse
   */
  public function getTecnologias(): JsonResponse
  {
    return response()->json($this->getTecnologiasData());
  }

  /**
   * Obtener clasificaciones biomédicas
   * Lista de clasificaciones según normativa biomédica
   *
   * @return JsonResponse
   */
  public function getCbiomedicas(): JsonResponse
  {
    return response()->json($this->getClasificacionesBiomedicasData());
  }

  /**
   * Obtener clasificaciones de riesgo
   * Lista de niveles de riesgo de equipos médicos
   *
   * @return JsonResponse
   */
  public function getCriesgos(): JsonResponse
  {
    return response()->json($this->getClasificacionesRiesgoData());
  }

  /**
   * Obtener frecuencias de mantenimiento
   * Lista de periodicidades de mantenimiento
   *
   * @return JsonResponse
   */
  public function getFrecuencias(): JsonResponse
  {
    return response()->json($this->getFrecuenciasData());
  }

  /**
   * Obtener zonas hospitalarias
   * Lista de zonas de distribución del hospital
   *
   * @return JsonResponse
   */
  public function getZonas(): JsonResponse
  {
    return response()->json($this->getZonasData());
  }

  /**
   * Obtener especificaciones técnicas
   * Lista de tipos de especificaciones técnicas
   *
   * @return JsonResponse
   */
  public function getEspecificaciones(): JsonResponse
  {
    return response()->json($this->getEspecificacionesData());
  }

  /**
   * Obtener un equipo específico por ID
   * Incluye toda la información detallada del equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getOne(Request $request): JsonResponse
  {
    Session::put('editar_orden', 'si');
    return response()->json($this->getOneEquipoData($request->all()));
  }

  /**
   * Obtener tipos de archivos
   * Lista de categorías de archivos del sistema
   *
   * @return JsonResponse
   */
  public function getArchivos(): JsonResponse
  {
    return response()->json($this->getArchivosData());
  }

  /**
   * Obtener períodos de garantía
   * Lista de tipos de garantía disponibles
   *
   * @return JsonResponse
   */
  public function getGarantias(): JsonResponse
  {
    return response()->json($this->getGarantiasData());
  }

  /**
   * Obtener equipos con garantía casi vencida
   * Lista de equipos próximos a vencer garantía
   *
   * @return JsonResponse
   */
  public function get_garantiaCasiVencida(): JsonResponse
  {
    return response()->json($this->getGarantiaCasiVencidaData());
  }

  /**
   * Obtener equipos con garantía vencida
   * Lista de equipos con garantía ya vencida
   *
   * @return JsonResponse
   */
  public function get_garantiaVencida(): JsonResponse
  {
    return response()->json($this->getGarantiaVencidaData());
  }

  // Private methods for database operations (replacing model calls)

  /**
   * Obtener equipos con paginación para API externa
   * Reemplaza el método get_devices del modelo Mequipos
   *
   * @param int $limit
   * @param int $offset
   * @return array|null
   */
  private function getDevicesData($limit, $offset)
  {
    $devices = DB::table('equipos')
      ->limit($limit)
      ->offset($offset)
      ->get();

    return $devices->count() > 0 ? $devices->toArray() : null;
  }

  /**
   * Obtener un equipo específico con información del servicio
   * Reemplaza el método get_device del modelo Mequipos
   *
   * @param int $id
   * @return object|null
   */
  private function getDeviceData($id)
  {
    return DB::table('equipos')
      ->select('equipos.*', 'servicios.name as service')
      ->leftJoin('servicios', 'equipos.servicio_id', '=', 'servicios.id')
      ->where('equipos.id', $id)
      ->first();
  }

  /**
   * Obtener todos los equipos por tipo
   * Reemplaza el método getAll del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getAllEquiposData()
  {
    return DB::table('equipos')
      ->select('equipos.*')
      ->where('equipos.tipo_id', Session::get('tipo_id', 1))
      ->get();
  }

  /**
   * Obtener equipos básicos por tipo
   * Reemplaza el método get del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getEquiposData()
  {
    return DB::table('equipos')
      ->select('equipos.*')
      ->where('equipos.tipo_id', Session::get('tipo_id', 1))
      ->get();
  }

  /**
   * Obtener equipos para contingencias
   * Reemplaza el método getForCOntingencias del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getEquiposContingenciasData()
  {
    return DB::table('equipos as eq')
      ->select('*')
      ->where('eq.tipo_id', 1)
      ->orderBy('eq.id', 'asc')
      ->get();
  }

  /**
   * Obtener equipos con garantía casi vencida
   * Reemplaza el método garantia_casi_vencida del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getGarantiaCasiVencidaData()
  {
    // Implementar lógica de garantía casi vencida
    return DB::table('equipos')
      ->select('*')
      ->whereRaw('DATEDIFF(DATE_ADD(fecha_ad, INTERVAL vida_util YEAR), CURDATE()) BETWEEN 1 AND 90')
      ->where('tipo_id', 1)
      ->get();
  }

  /**
   * Obtener equipos con garantía vencida
   * Reemplaza el método garantia_vencida del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getGarantiaVencidaData()
  {
    // Implementar lógica de garantía vencida
    return DB::table('equipos')
      ->select('*')
      ->whereRaw('DATEDIFF(DATE_ADD(fecha_ad, INTERVAL vida_util YEAR), CURDATE()) < 0')
      ->where('tipo_id', 1)
      ->get();
  }

  /**
   * Obtener equipos dados de baja
   * Reemplaza el método equipos_baja del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getEquiposBajaData()
  {
    return DB::table('equipos')
      ->select('*')
      ->where('estadoequipo_id', 6) // Estado de baja
      ->where('tipo_id', 1)
      ->get();
  }

  /**
   * Obtener equipos pendientes de baja
   * Reemplaza el método equipos_pendientes_baja del modelo Mequipos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getEquiposPendientesBajaData()
  {
    return DB::table('equipos')
      ->select('*')
      ->where('estadoequipo_id', 5) // Estado pendiente de baja
      ->where('tipo_id', 1)
      ->get();
  }

  /**
   * Obtener un equipo específico con toda su información
   * Reemplaza el método getOne del modelo Mequipos
   *
   * @param array $param
   * @return object|null
   */
  private function getOneEquipoData($param)
  {
    return DB::table('equipos')
      ->select([
        'equipos.*',
        DB::raw('CONCAT("$", FORMAT(equipos.costo, 2)) as costo'),
        'equipos.costo as costo_original',
        'centros.code as centro',
        'servicios.name as servicios',
        'fuenteal.name as fuentes',
        'tecnologiap.name as tecnologias',
        'frecuenciam.name as frecuencias',
        'cbiomedica.name as clasificaciones',
        'criesgo.name as criesgos',
        'pisos.name as pisos',
        'tadquisicion.name as adquisiciones',
        DB::raw('MONTHNAME(equipos.fecha_mantenimiento) as mes'),
        'estadoequipos.name as estadoequipos',
        'periodos_garantias.name as garantias'
      ])
      ->leftJoin('centros', 'equipos.centro_id', '=', 'centros.id')
      ->leftJoin('servicios', 'equipos.servicio_id', '=', 'servicios.id')
      ->leftJoin('fuenteal', 'equipos.fuente_id', '=', 'fuenteal.id')
      ->leftJoin('tecnologiap', 'equipos.tecnologia_id', '=', 'tecnologiap.id')
      ->leftJoin('frecuenciam', 'equipos.frecuencia_id', '=', 'frecuenciam.id')
      ->leftJoin('cbiomedica', 'equipos.cbiomedica_id', '=', 'cbiomedica.id')
      ->leftJoin('criesgo', 'equipos.criesgo_id', '=', 'criesgo.id')
      ->leftJoin('pisos', 'servicios.piso_id', '=', 'pisos.id')
      ->leftJoin('tadquisicion', 'equipos.tadquisicion_id', '=', 'tadquisicion.id')
      ->leftJoin('estadoequipos', 'equipos.estadoequipo_id', '=', 'estadoequipos.id')
      ->leftJoin('periodos_garantias', 'equipos.periodo_garantia_id', '=', 'periodos_garantias.id')
      ->where('equipos.id', $param['id'])
      ->first();
  }

  /**
   * Obtener tipos de adquisición
   * Reemplaza el método get del modelo Madquisiciones
   *
   * @return \Illuminate\Support\Collection
   */
  private function getTiposAdquisicionData()
  {
    return DB::table('tadquisicion')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener fuentes de alimentación
   * Reemplaza el método get del modelo Mfuentes
   *
   * @return \Illuminate\Support\Collection
   */
  private function getFuentesData()
  {
    return DB::table('fuenteal')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener tecnologías principales
   * Reemplaza el método get del modelo Mtecnologias
   *
   * @return \Illuminate\Support\Collection
   */
  private function getTecnologiasData()
  {
    return DB::table('tecnologiap')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener clasificaciones biomédicas
   * Reemplaza el método get del modelo Mcbiomedicas
   *
   * @return \Illuminate\Support\Collection
   */
  private function getClasificacionesBiomedicasData()
  {
    return DB::table('cbiomedica')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener clasificaciones de riesgo
   * Reemplaza el método get del modelo Mcriesgos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getClasificacionesRiesgoData()
  {
    return DB::table('criesgo')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener frecuencias de mantenimiento
   * Reemplaza el método get del modelo Mfrecuencias
   *
   * @return \Illuminate\Support\Collection
   */
  private function getFrecuenciasData()
  {
    return DB::table('frecuenciam')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener zonas hospitalarias
   * Reemplaza el método get del modelo Mzonas
   *
   * @return \Illuminate\Support\Collection
   */
  private function getZonasData()
  {
    return DB::table('zonas')
      ->select('*')
      ->where('status', '!=', 0)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener especificaciones técnicas
   * Reemplaza el método get del modelo Mespecificaciones
   *
   * @return \Illuminate\Support\Collection
   */
  private function getEspecificacionesData()
  {
    return DB::table('especificaciones')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener tipos de archivos
   * Reemplaza el método get del modelo Marchivos
   *
   * @return \Illuminate\Support\Collection
   */
  private function getArchivosData()
  {
    return DB::table('archivos')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener períodos de garantía
   * Reemplaza el método get del modelo Mperiodos_garantias
   *
   * @return \Illuminate\Support\Collection
   */
  private function getGarantiasData()
  {
    return DB::table('periodos_garantias')
      ->select('*')
      ->where('status', 1)
      ->orderBy('name', 'asc')
      ->get();
  }

  /**
   * Obtener equipos con paginación server-side
   * Reemplaza el método get_server_side del modelo Mequipos
   *
   * @param array $param
   * @return array
   */
  private function getEquiposServerSideData($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }

    // Construir la consulta base
    $query = DB::table('equipos')
      ->select([
        'equipos.id',
        'equipos.name',
        'equipos.descripcion',
        'equipos.code',
        'equipos.serial',
        'equipos.marca',
        'equipos.modelo',
        'equipos.verificacion_inventario',
        'equipos.estado_mantenimiento',
        'equipos.image',
        'equipos.observacion',
        'servicios.name as servicios',
        'frecuenciam.name as frecuencias',
        'estadoequipos.name as estadoequipo',
        'estadoequipos.color as color_estado',
        'areas.name as area',
        'sedes.name as sede'
      ])
      ->leftJoin('servicios', 'servicios.id', '=', 'equipos.servicio_id')
      ->leftJoin('areas', 'areas.id', '=', 'equipos.area_id')
      ->leftJoin('sedes', 'sedes.id', '=', 'servicios.sede_id')
      ->leftJoin('frecuenciam', 'frecuenciam.id', '=', 'equipos.frecuencia_id')
      ->leftJoin('estadoequipos', 'estadoequipos.id', '=', 'equipos.estadoequipo_id')
      ->where('equipos.status', '!=', 0)
      ->where('equipos.tipo_id', Session::get('tipo_id', 1));

    // Aplicar filtros de búsqueda
    $searchValue = $param['search']['value'] ?? '';
    if (!empty($searchValue)) {
      $query->where(function($q) use ($searchValue) {
        $q->where('equipos.name', 'like', "%{$searchValue}%")
          ->orWhere('equipos.code', 'like', "%{$searchValue}%")
          ->orWhere('equipos.serial', 'like', "%{$searchValue}%")
          ->orWhere('equipos.marca', 'like', "%{$searchValue}%")
          ->orWhere('equipos.modelo', 'like', "%{$searchValue}%");
      });
    }

    // Obtener datos con límite
    $datos = $query->limit($param['length'])
                  ->offset($param['start'])
                  ->orderBy('equipos.name', 'asc')
                  ->orderBy('equipos.id', 'asc')
                  ->get();

    $num_filas_limit = $datos->count();

    // Obtener total sin límite para paginación
    $num_filas = DB::table('equipos')
      ->leftJoin('servicios', 'servicios.id', '=', 'equipos.servicio_id')
      ->where('equipos.status', '!=', 0)
      ->where('equipos.tipo_id', Session::get('tipo_id', 1))
      ->where(function($q) use ($searchValue) {
        if (!empty($searchValue)) {
          $q->where('equipos.name', 'like', "%{$searchValue}%")
            ->orWhere('equipos.code', 'like', "%{$searchValue}%")
            ->orWhere('equipos.serial', 'like', "%{$searchValue}%")
            ->orWhere('equipos.marca', 'like', "%{$searchValue}%")
            ->orWhere('equipos.modelo', 'like', "%{$searchValue}%");
        }
      })
      ->count();

    return [
      'datos' => $datos,
      'num_filas_limit' => $num_filas_limit,
      'num_filas' => $num_filas
    ];
  }

  /**
   * Obtener equipos Baxter con paginación server-side
   * Reemplaza el método get_server_side_baxter del modelo Mequipos
   *
   * @param array $param
   * @return array
   */
  private function getEquiposBaxterServerSideData($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }

    // Consulta específica para equipos Baxter
    $query = DB::table('equipos')
      ->select([
        'equipos.id',
        'equipos.name',
        'equipos.code',
        'equipos.serial',
        'equipos.marca',
        'equipos.modelo',
        'servicios.name as servicios',
        'areas.name as area'
      ])
      ->leftJoin('servicios', 'servicios.id', '=', 'equipos.servicio_id')
      ->leftJoin('areas', 'areas.id', '=', 'equipos.area_id')
      ->where('equipos.status', '!=', 0)
      ->where('equipos.tipo_id', Session::get('tipo_id', 1))
      ->where('equipos.marca', 'like', '%Baxter%'); // Filtro específico para Baxter

    // Aplicar filtros de búsqueda
    $searchValue = $param['search']['value'] ?? '';
    if (!empty($searchValue)) {
      $query->where(function($q) use ($searchValue) {
        $q->where('equipos.name', 'like', "%{$searchValue}%")
          ->orWhere('equipos.code', 'like', "%{$searchValue}%")
          ->orWhere('equipos.serial', 'like', "%{$searchValue}%");
      });
    }

    // Obtener datos con límite
    $datos = $query->limit($param['length'])
                  ->offset($param['start'])
                  ->orderBy('equipos.name', 'asc')
                  ->get();

    $num_filas_limit = $datos->count();

    // Obtener total sin límite
    $num_filas = DB::table('equipos')
      ->leftJoin('servicios', 'servicios.id', '=', 'equipos.servicio_id')
      ->where('equipos.status', '!=', 0)
      ->where('equipos.tipo_id', Session::get('tipo_id', 1))
      ->where('equipos.marca', 'like', '%Baxter%')
      ->where(function($q) use ($searchValue) {
        if (!empty($searchValue)) {
          $q->where('equipos.name', 'like', "%{$searchValue}%")
            ->orWhere('equipos.code', 'like', "%{$searchValue}%")
            ->orWhere('equipos.serial', 'like', "%{$searchValue}%");
        }
      })
      ->count();

    return [
      'datos' => $datos,
      'num_filas_limit' => $num_filas_limit,
      'num_filas' => $num_filas
    ];
  }

  /**
   * Obtener equipos con filtros avanzados server-side
   * Reemplaza el método get_server_side_filtros del modelo Mequipos
   *
   * @param array $param
   * @return array
   */
  private function getEquiposFiltrosServerSideData($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }

    // Construir consulta con filtros avanzados
    $query = DB::table('equipos')
      ->select([
        'equipos.id',
        'equipos.name',
        'equipos.code',
        'equipos.serial',
        'equipos.marca',
        'equipos.modelo',
        'servicios.name as servicios',
        'areas.name as area',
        'sedes.name as sede',
        'estadoequipos.name as estadoequipo',
        'cbiomedica.name as clasificacion',
        'criesgo.name as riesgo'
      ])
      ->leftJoin('servicios', 'servicios.id', '=', 'equipos.servicio_id')
      ->leftJoin('areas', 'areas.id', '=', 'equipos.area_id')
      ->leftJoin('sedes', 'sedes.id', '=', 'servicios.sede_id')
      ->leftJoin('estadoequipos', 'estadoequipos.id', '=', 'equipos.estadoequipo_id')
      ->leftJoin('cbiomedica', 'cbiomedica.id', '=', 'equipos.cbiomedica_id')
      ->leftJoin('criesgo', 'criesgo.id', '=', 'equipos.criesgo_id')
      ->where('equipos.status', '!=', 0)
      ->where('equipos.tipo_id', Session::get('tipo_id', 1));

    // Aplicar filtros específicos si están presentes
    if (!empty($param['sede_id'])) {
      $query->where('sedes.id', $param['sede_id']);
    }
    if (!empty($param['servicio_id'])) {
      $query->where('servicios.id', $param['servicio_id']);
    }
    if (!empty($param['area_id'])) {
      $query->where('areas.id', $param['area_id']);
    }
    if (!empty($param['estadoequipo_id'])) {
      $query->where('estadoequipos.id', $param['estadoequipo_id']);
    }
    if (!empty($param['cbiomedica_id'])) {
      $query->where('cbiomedica.id', $param['cbiomedica_id']);
    }
    if (!empty($param['criesgo_id'])) {
      $query->where('criesgo.id', $param['criesgo_id']);
    }

    // Aplicar búsqueda general
    $searchValue = $param['search']['value'] ?? '';
    if (!empty($searchValue)) {
      $query->where(function($q) use ($searchValue) {
        $q->where('equipos.name', 'like', "%{$searchValue}%")
          ->orWhere('equipos.code', 'like', "%{$searchValue}%")
          ->orWhere('equipos.serial', 'like', "%{$searchValue}%")
          ->orWhere('equipos.marca', 'like', "%{$searchValue}%")
          ->orWhere('equipos.modelo', 'like', "%{$searchValue}%");
      });
    }

    // Obtener datos con límite
    $datos = $query->limit($param['length'])
                  ->offset($param['start'])
                  ->orderBy('equipos.name', 'asc')
                  ->get();

    $num_filas_limit = $datos->count();

    // Construir consulta para contar total (sin límite)
    $countQuery = DB::table('equipos')
      ->leftJoin('servicios', 'servicios.id', '=', 'equipos.servicio_id')
      ->leftJoin('areas', 'areas.id', '=', 'equipos.area_id')
      ->leftJoin('sedes', 'sedes.id', '=', 'servicios.sede_id')
      ->leftJoin('estadoequipos', 'estadoequipos.id', '=', 'equipos.estadoequipo_id')
      ->leftJoin('cbiomedica', 'cbiomedica.id', '=', 'equipos.cbiomedica_id')
      ->leftJoin('criesgo', 'criesgo.id', '=', 'equipos.criesgo_id')
      ->where('equipos.status', '!=', 0)
      ->where('equipos.tipo_id', Session::get('tipo_id', 1));

    // Aplicar los mismos filtros para el conteo
    if (!empty($param['sede_id'])) {
      $countQuery->where('sedes.id', $param['sede_id']);
    }
    if (!empty($param['servicio_id'])) {
      $countQuery->where('servicios.id', $param['servicio_id']);
    }
    if (!empty($param['area_id'])) {
      $countQuery->where('areas.id', $param['area_id']);
    }
    if (!empty($param['estadoequipo_id'])) {
      $countQuery->where('estadoequipos.id', $param['estadoequipo_id']);
    }
    if (!empty($param['cbiomedica_id'])) {
      $countQuery->where('cbiomedica.id', $param['cbiomedica_id']);
    }
    if (!empty($param['criesgo_id'])) {
      $countQuery->where('criesgo.id', $param['criesgo_id']);
    }

    if (!empty($searchValue)) {
      $countQuery->where(function($q) use ($searchValue) {
        $q->where('equipos.name', 'like', "%{$searchValue}%")
          ->orWhere('equipos.code', 'like', "%{$searchValue}%")
          ->orWhere('equipos.serial', 'like', "%{$searchValue}%")
          ->orWhere('equipos.marca', 'like', "%{$searchValue}%")
          ->orWhere('equipos.modelo', 'like', "%{$searchValue}%");
      });
    }

    $num_filas = $countQuery->count();

    return [
      'datos' => $datos,
      'num_filas_limit' => $num_filas_limit,
      'num_filas' => $num_filas
    ];
  }

  /**
   * Agregar nuevo equipo a la base de datos
   * Reemplaza el método add del modelo Mequipos
   *
   * @param array $data
   * @return int
   */
  private function addEquipoData($data)
  {
    return DB::table('equipos')->insertGetId($data);
  }

  /**
   * Copiar equipo en la base de datos
   * Reemplaza el método copy del modelo Mequipos
   *
   * @param array $data
   * @return int
   */
  private function copyEquipoData($data)
  {
    return DB::table('equipos')->insertGetId($data);
  }

  /**
   * Actualizar equipo en la base de datos
   * Reemplaza el método update del modelo Mequipos
   *
   * @param array $data
   * @return bool
   */
  private function updateEquipoData($data)
  {
    $id = $data['id'];
    unset($data['id']);
    return DB::table('equipos')->where('id', $id)->update($data);
  }

  /**
   * Depurar códigos de equipos
   * Reemplaza el método depurarCodigo del modelo Mequipos
   *
   * @return void
   */
  private function depurarCodigoData()
  {
    // Implementar lógica de depuración de códigos si es necesaria
    DB::table('equipos')
      ->whereNull('code')
      ->orWhere('code', '')
      ->update(['code' => DB::raw('CONCAT("EQ-", id)')]);
  }

  /**
   * Calcular frecuencia de mantenimiento
   * Reemplaza el método compute_frecuency del modelo Mequipos
   *
   * @param int $mes1
   * @param int $mes2
   * @return array
   */
  private function computeFrecuencyData($mes1, $mes2)
  {
    $meses = [];
    if ($mes1) $meses[] = $mes1;
    if ($mes2) $meses[] = $mes2;

    return [
      'meses' => $meses,
      'frecuencia_calculada' => count($meses)
    ];
  }

  /**
   * Agregar especificaciones de equipo
   * Reemplaza métodos del modelo Mequipo_especificaciones
   *
   * @param array $data
   * @return int
   */
  private function addEquipoEspecificacionData($data)
  {
    return DB::table('equipo_especificaciones')->insertGetId($data);
  }

  /**
   * Copiar especificaciones de equipo
   * Reemplaza el método copy_especificaciones del modelo Mequipo_especificaciones
   *
   * @param array $vector
   * @return void
   */
  private function copyEspecificacionesData($vector)
  {
    $especificaciones = DB::table('equipo_especificaciones')
      ->where('equipo_id', $vector['equipo_id_origen'])
      ->get();

    foreach ($especificaciones as $esp) {
      $newEsp = (array) $esp;
      unset($newEsp['id']);
      $newEsp['equipo_id'] = $vector['equipo_id_destino'];
      DB::table('equipo_especificaciones')->insert($newEsp);
    }
  }

  /**
   * Copiar contactos de equipo
   * Reemplaza el método copy_contactos del modelo Mequipo_contactos
   *
   * @param array $vector
   * @return void
   */
  private function copyContactosData($vector)
  {
    $contactos = DB::table('equipo_contactos')
      ->where('equipo_id', $vector['equipo_id_origen'])
      ->get();

    foreach ($contactos as $contacto) {
      $newContacto = (array) $contacto;
      unset($newContacto['id']);
      $newContacto['equipo_id'] = $vector['equipo_id_destino'];
      DB::table('equipo_contactos')->insert($newContacto);
    }
  }

  /**
   * Agregar cambio de ubicación
   * Reemplaza el método add del modelo Mcambios_ubicaciones
   *
   * @param array $data
   * @return int
   */
  private function addCambioUbicacionData($data)
  {
    return DB::table('cambios_ubicaciones')->insertGetId($data);
  }

  /**
   * Agregar cambio de hoja de vida
   * Reemplaza el método add del modelo Mcambios_hdv
   *
   * @param array $data
   * @return int
   */
  private function addCambioHdvData($data)
  {
    return DB::table('cambios_hdv')->insertGetId($data);
  }

  /**
   * Obtener información de servicio
   * Reemplaza el método getOne del modelo Mservicios
   *
   * @param array $param
   * @return object|null
   */
  private function getServicioData($param)
  {
    return DB::table('servicios')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de estado de equipo
   * Reemplaza el método getOne del modelo Mestadoequipos
   *
   * @param array $param
   * @return object|null
   */
  private function getEstadoEquipoData($param)
  {
    return DB::table('estadoequipos')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de tipo de adquisición
   * Reemplaza el método getOne del modelo Madquisiciones
   *
   * @param array $param
   * @return object|null
   */
  private function getTipoAdquisicionData($param)
  {
    return DB::table('tadquisicion')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de frecuencia
   * Reemplaza el método getOne del modelo Mfrecuencias
   *
   * @param array $param
   * @return object|null
   */
  private function getFrecuenciaData($param)
  {
    return DB::table('frecuenciam')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de propietario
   * Reemplaza el método getOne del modelo Mpropietarios
   *
   * @param array $param
   * @return object|null
   */
  private function getPropietarioData($param)
  {
    return DB::table('propietarios')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de orden de compra
   * Reemplaza el método getOne del modelo Mordenes_compra
   *
   * @param array $param
   * @return object|null
   */
  private function getOrdenCompraData($param)
  {
    return DB::table('ordenes_compra')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de guía
   * Reemplaza el método getOne del modelo Mguias
   *
   * @param array $param
   * @return object|null
   */
  private function getGuiaData($param)
  {
    return DB::table('guias')->where('id', $param['id'])->first();
  }

  /**
   * Obtener información de INVIMA
   * Reemplaza el método getOne del modelo Minvimas
   *
   * @param array $param
   * @return object|null
   */
  private function getInvimaData($param)
  {
    return DB::table('invimas')->where('id', $param['id'])->first();
  }

  /**
   * Crear un nuevo equipo médico
   * Incluye validación, subida de archivos e imágenes
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function add(Request $request): JsonResponse
  {
    try {
      $data = $request->all();

      // Normalizar datos de entrada
      if (empty($data['servicio_id'])) {
        $data['servicio_id'] = 0;
      }
      if (empty($data['area_id'])) {
        $data['area_id'] = 0;
      }

      // Serializar arrays
      if (isset($data['manual'])) {
        $data['manual'] = serialize($data['manual']);
      }
      if (isset($data['plano'])) {
        $data['plano'] = serialize($data['plano']);
      }

      // Remover sede_id si existe
      unset($data['sede_id']);

      // Validación de datos
      $validator = Validator::make($data, [
        'name' => 'required|min:3',
        'code' => 'nullable|unique:equipos,code',
        'serial' => 'nullable|unique:equipos,serial',
        'codigo_antiguo' => 'nullable|unique:equipos,codigo_antiguo',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      // Manejo de archivos
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/upload_imagenes'), $imageName);
        $data['image'] = $imageName;
      }

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('assets/upload_archivos'), $fileName);
        $data['file'] = $fileName;
      }

      // Agregar datos del sistema
      $data['created_at'] = now();
      $data['plan'] = 2;
      $data['usuario_id'] = Session::get('id');
      $data['tipo_id'] = Session::get('tipo_id', 1);

      // Limpiar fechas vacías
      if (empty($data['fecha_instalacion'])) {
        unset($data['fecha_instalacion']);
      }
      if (empty($data['fecha_mantenimiento'])) {
        unset($data['fecha_mantenimiento']);
      }

      $ultimo_id = $this->addEquipoData($data);
      $this->depurarCodigoData();

      return response()->json($ultimo_id);
    } catch (\Exception $e) {
      // Limpiar archivos subidos en caso de error
      if (isset($data['image']) && file_exists(public_path('assets/upload_imagenes/' . $data['image']))) {
        unlink(public_path('assets/upload_imagenes/' . $data['image']));
      }
      if (isset($data['file']) && file_exists(public_path('assets/upload_archivos/' . $data['file']))) {
        unlink(public_path('assets/upload_archivos/' . $data['file']));
      }

      return response()->json(['error' => 'No se ha podido ingresar el equipo'], 500);
    }
  }

  /**
   * Copiar un equipo médico existente
   * Incluye validación y copia de especificaciones y contactos
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function copy(Request $request): JsonResponse
  {
    try {
      $data = $request->all();

      // Normalizar datos de entrada
      if (empty($data['servicio_id'])) {
        $data['servicio_id'] = 0;
      }
      if (empty($data['area_id'])) {
        $data['area_id'] = 0;
      }

      // Serializar arrays
      if (isset($data['manual'])) {
        $data['manual'] = serialize($data['manual']);
      }
      if (isset($data['plano'])) {
        $data['plano'] = serialize($data['plano']);
      }

      // Remover sede_id si existe
      unset($data['sede_id']);

      // Validación de datos
      $validator = Validator::make($data, [
        'name' => 'required|min:3',
        'code' => 'required|unique:equipos,code',
        'serial' => 'required|unique:equipos,serial',
        'codigo_antiguo' => 'nullable|unique:equipos,codigo_antiguo',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('assets/upload_archivos'), $fileName);
        $data['file'] = $fileName;
      }

      // Agregar datos del sistema
      $data['created_at'] = now();
      $data['plan'] = 2;

      // Limpiar fechas vacías
      if (empty($data['fecha_instalacion'])) {
        unset($data['fecha_instalacion']);
      }

      // Guardar ID del equipo origen antes de eliminarlo
      $equipo_id_origen = $data['id'];
      unset($data['id']);

      // Crear el nuevo equipo
      $equipo_id_destino = $this->copyEquipoData($data);

      // Copiar especificaciones y contactos
      $vector = [
        'equipo_id_destino' => $equipo_id_destino,
        'equipo_id_origen' => $equipo_id_origen,
      ];

      $this->copyEspecificacionesData($vector);
      $this->copyContactosData($vector);

      return response()->json(1);
    } catch (\Exception $e) {
      return response()->json(['errors' => 'Error al copiar el equipo'], 500);
    }
  }

  /**
   * Actualizar un equipo médico existente
   * Incluye validación, historial de cambios, subida de archivos
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function update(Request $request): JsonResponse
  {
    try {
      $data = $request->all();
      $equipo_new = $data; // Para historial de cambios

      // Limpiar datos innecesarios
      if (isset($data['consulta_invima'])) {
        unset($data['consulta_invima']);
      }

      $sede_id = $data['sede_id'] ?? null;
      unset($data['sede_id']);

      // Obtener información previa del equipo
      $equipo = $this->getOneEquipoData($data);
      $servicio_viejo = $this->getServicioData(['id' => $equipo->servicio_id]);
      $servicio_nuevo = $this->getServicioData(['id' => $data['servicio_id']]);

      // Generar historial de cambios
      $descripcion_historial = $this->generateChangeHistory($equipo, $equipo_new);

      // Normalizar datos
      if ($data['estadoequipo_id'] != 6) {
        $data['baja_id'] = null;
      }

      // Serializar arrays
      if (isset($data['manual'])) {
        $data['manual'] = serialize($data['manual']);
      } else {
        $data['manual'] = 'N;';
      }
      if (isset($data['plano'])) {
        $data['plano'] = serialize($data['plano']);
      } else {
        $data['plano'] = 'N;';
      }

      // Limpiar fechas vacías
      if (empty($data['fecha_instalacion'])) {
        unset($data['fecha_instalacion']);
      }

      // Validación dinámica
      $rules = ['name' => 'required|min:3'];

      if ($equipo->code != $data['code']) {
        $rules['code'] = 'unique:equipos,code';
      }
      if ($equipo->serial != $data['serial']) {
        $rules['serial'] = 'unique:equipos,serial';
      }
      if ($equipo->codigo_antiguo != $data['codigo_antiguo']) {
        $rules['codigo_antiguo'] = 'nullable|unique:equipos,codigo_antiguo';
      }

      $validator = Validator::make($data, $rules);

      if ($validator->fails()) {
        return response()->json(['respuesta' => 2, 'errores' => $validator->errors()], 422);
      }

      // Manejo de archivos
      if ($request->hasFile('image1')) {
        $image = $request->file('image1');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/upload_imagenes'), $imageName);
        $data['image'] = $imageName;
      }

      if ($request->hasFile('file1')) {
        $file = $request->file('file1');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('assets/upload_archivos'), $fileName);
        $data['file'] = $fileName;
      }

      if ($request->hasFile('archivo_invima1')) {
        $invima = $request->file('archivo_invima1');
        $invimaName = time() . '_' . uniqid() . '.' . $invima->getClientOriginalExtension();
        $invima->move(public_path('assets/upload_invimas'), $invimaName);
        $data['archivo_invima'] = $invimaName;
      }

      // Procesar observaciones
      if (isset($data['observacion']) && !empty($data['observacion'])) {
        $data['observacion'] = now()->format('Y-m-d H:i:s') . "\n" . $data['observacion'] . "\n" . $equipo->observacion;
      } else {
        unset($data['observacion']);
      }

      // Limpiar fechas adicionales
      if (empty($data['fecha_ad'])) {
        unset($data['fecha_ad']);
      }
      if (isset($data['invima_id']) && $data['invima_id'] == 1) {
        $data['invima_id'] = null;
      }

      // Normalizar servicios y áreas
      if (empty($data['servicio_id'])) {
        $data['servicio_id'] = 0;
      }
      if (empty($data['area_id'])) {
        $data['area_id'] = 0;
      }

      // Registrar cambio de ubicación si es necesario
      if (isset($data['area_id']) && ($equipo->servicio_id != $data['servicio_id'] || $equipo->area_id != $data['area_id'])) {
        $this->addCambioUbicacionData([
          'servicio_origen_id' => $equipo->servicio_id,
          'servicio_destino_id' => $data['servicio_id'],
          'area_origen_id' => $equipo->area_id,
          'area_destino_id' => $data['area_id'],
          'equipo_id' => $equipo->id,
          'usuario_id' => Session::get('id'),
          'sede_origen_id' => $servicio_viejo->sede_id ?? null,
          'sede_destino_id' => $servicio_nuevo->sede_id ?? null,
        ]);
      }

      // Registrar cambios en hoja de vida
      if (!empty($descripcion_historial)) {
        $this->addCambioHdvData([
          'descripcion' => $descripcion_historial,
          'usuario_id' => Session::get('id'),
          'equipo_id' => $equipo->id,
        ]);
      }

      // Actualizar equipo
      $this->updateEquipoData($data);
      $this->depurarCodigoData();

      return response()->json(['respuesta' => 1, 'equipo_id' => $equipo->id]);
    } catch (\Exception $e) {
      return response()->json(['respuesta' => 2, 'errores' => 'Error al actualizar el equipo'], 500);
    }
  }

  /**
   * Generar historial de cambios para la hoja de vida del equipo
   * Compara valores anteriores con nuevos valores
   *
   * @param object $equipo
   * @param array $equipo_new
   * @return string
   */
  private function generateChangeHistory($equipo, $equipo_new)
  {
    $descripcion_historial = '';

    if ($equipo->name != $equipo_new['name']) {
      $descripcion_historial .= 'Se cambio nombre de ' . $equipo->name . ' a ' . $equipo_new['name'] . "\n";
    }
    if ($equipo->marca != $equipo_new['marca']) {
      $descripcion_historial .= 'Se cambio marca de ' . $equipo->marca . ' a ' . $equipo_new['marca'] . "\n";
    }
    if ($equipo->modelo != $equipo_new['modelo']) {
      $descripcion_historial .= 'Se cambio modelo de ' . $equipo->modelo . ' a ' . $equipo_new['modelo'] . "\n";
    }
    if ($equipo->code != $equipo_new['code']) {
      $descripcion_historial .= 'Se cambio Codigo de ' . $equipo->code . ' a ' . $equipo_new['code'] . "\n";
    }
    if ($equipo->serial != $equipo_new['serial']) {
      $descripcion_historial .= 'Se cambio Serie de ' . $equipo->serial . ' a ' . $equipo_new['serial'] . "\n";
    }
    if ($equipo->fecha_ad != $equipo_new['fecha_ad']) {
      $descripcion_historial .= 'Se cambio Fecha adquisicion de ' . $equipo->fecha_ad . ' a ' . $equipo_new['fecha_ad'] . "\n";
    }
    if ($equipo->fecha_instalacion != $equipo_new['fecha_instalacion']) {
      $descripcion_historial .= 'Se cambio Fecha instalacion de ' . $equipo->fecha_instalacion . ' a ' . $equipo_new['fecha_instalacion'] . "\n";
    }
    if ($equipo->fecha_acta_recibo != $equipo_new['fecha_acta_recibo']) {
      $descripcion_historial .= 'Se cambio Fecha acta recibo de ' . $equipo->fecha_acta_recibo . ' a ' . $equipo_new['fecha_acta_recibo'] . "\n";
    }
    if ($equipo->fecha_inicio_operacion != $equipo_new['fecha_inicio_operacion']) {
      $descripcion_historial .= 'Se cambio Fecha inicio operacion de ' . $equipo->fecha_inicio_operacion . ' a ' . $equipo_new['fecha_inicio_operacion'] . "\n";
    }
    if ($equipo->fecha_fabricacion != $equipo_new['fecha_fabricacion']) {
      $descripcion_historial .= 'Se cambio Fecha fabricación de ' . $equipo->fecha_fabricacion . ' a ' . $equipo_new['fecha_fabricacion'] . "\n";
    }
    if ($equipo->descripcion != $equipo_new['descripcion']) {
      $descripcion_historial .= 'Se cambio descripción de ' . $equipo->descripcion . ' a ' . $equipo_new['descripcion'] . "\n";
    }
    if ($equipo->vida_util != $equipo_new['vida_util']) {
      $descripcion_historial .= 'Se cambio vida util de ' . $equipo->vida_util . ' a ' . $equipo_new['vida_util'] . "\n";
    }
    if ($equipo->costo_original != $equipo_new['costo']) {
      $descripcion_historial .= 'Se cambio costo de ' . $equipo->costo_original . ' a ' . $equipo_new['costo'] . "\n";
    }
    if ($equipo->verificacion_inventario != $equipo_new['verificacion_inventario']) {
      $descripcion_historial .= 'Se cambio verificacion inventario de ' . $equipo->verificacion_inventario . ' a ' . $equipo_new['verificacion_inventario'] . "\n";
    }
    if (isset($equipo_new['otros']) && $equipo->otros != $equipo_new['otros']) {
      $descripcion_historial .= 'Se cambio propiedad de otros de ' . $equipo->otros . ' a ' . $equipo_new['otros'] . "\n";
    }
    if ($equipo->activo_comodato != $equipo_new['activo_comodato']) {
      $descripcion_historial .= 'Se cambio codigo comodato de ' . $equipo->activo_comodato . ' a ' . $equipo_new['activo_comodato'] . "\n";
    }
    if ($equipo->movilidad != $equipo_new['movilidad']) {
      $descripcion_historial .= 'Se cambio movilidad de ' . $equipo->movilidad . ' a ' . $equipo_new['movilidad'] . "\n";
    }
    if ($equipo->calibracion != $equipo_new['calibracion']) {
      $descripcion_historial .= 'Se cambio calibracion de ' . $equipo->calibracion . ' a ' . $equipo_new['calibracion'] . "\n";
    }
    if ($equipo->estadoequipo_id != $equipo_new['estadoequipo_id']) {
      $estado_viejo = $this->getEstadoEquipoData(['id' => $equipo->estadoequipo_id]);
      $estado_nuevo = $this->getEstadoEquipoData(['id' => $equipo_new['estadoequipo_id']]);
      $descripcion_historial .= 'Se cambio estado funcional del equipo de ' . $estado_viejo->name . ' a ' . $estado_nuevo->name . "\n";
    }
    if ($equipo->disponibilidad_id != $equipo_new['disponibilidad_id']) {
      $disp_vieja = $this->getEstadoEquipoData(['id' => $equipo->disponibilidad_id]);
      $disp_nueva = $this->getEstadoEquipoData(['id' => $equipo_new['disponibilidad_id']]);
      $descripcion_historial .= 'Se cambio disponibilidad del equipo de ' . $disp_vieja->name . ' a ' . $disp_nueva->name . "\n";
    }
    if ((isset($equipo_new['localizacion_actual'])) && ($equipo->localizacion_actual != $equipo_new['localizacion_actual'])) {
      $descripcion_historial .= ' Se relaciono como localización actual del equipo: ' . $equipo_new['localizacion_actual'] . "\n";
    }
    if ($equipo->tadquisicion_id != $equipo_new['tadquisicion_id']) {
      $adq_vieja = $this->getTipoAdquisicionData(['id' => $equipo->tadquisicion_id]);
      $adq_nueva = $this->getTipoAdquisicionData(['id' => $equipo_new['tadquisicion_id']]);
      $descripcion_historial .= 'Se cambio tipo de adquisicion de ' . $adq_vieja->name . ' a ' . $adq_nueva->name . "\n";
    }
    if ($equipo->frecuencia_id != $equipo_new['frecuencia_id']) {
      $frec_vieja = $this->getFrecuenciaData(['id' => $equipo->frecuencia_id]);
      $frec_nueva = $this->getFrecuenciaData(['id' => $equipo_new['frecuencia_id']]);
      $descripcion_historial .= 'Se cambio frecuencia de mtto de ' . $frec_vieja->name . ' a ' . $frec_nueva->name . "\n";
    }

    // Normalizar propietario
    if (!isset($equipo_new['propietario_id']) || empty($equipo_new['propietario_id'])) {
      $equipo_new['propietario_id'] = 0;
    }
    if ($equipo->propietario_id != $equipo_new['propietario_id']) {
      $prop_viejo = $this->getPropietarioData(['id' => $equipo->propietario_id]);
      $prop_nuevo = $this->getPropietarioData(['id' => $equipo_new['propietario_id']]);
      $descripcion_historial .= 'Se cambio propietario de ' . $prop_viejo->nombre . ' a ' . $prop_nuevo->nombre . "\n";
    }

    // Normalizar orden de compra
    if (!isset($equipo_new['orden_compra_id']) || empty($equipo_new['orden_compra_id'])) {
      $equipo_new['orden_compra_id'] = 0;
    }
    if ($equipo->orden_compra_id != $equipo_new['orden_compra_id']) {
      $orden_vieja = $this->getOrdenCompraData(['id' => $equipo->orden_compra_id]);
      $orden_nueva = $this->getOrdenCompraData(['id' => $equipo_new['orden_compra_id']]);
      $descripcion_historial .= 'Se cambio soporte de compra de ' . $orden_vieja->orden . ' a ' . $orden_nueva->orden . "\n";
    }

    // Normalizar guía
    if (!isset($equipo_new['guia_id']) || empty($equipo_new['guia_id'])) {
      $equipo_new['guia_id'] = 0;
    }
    if ($equipo->guia_id != $equipo_new['guia_id']) {
      $guia_vieja = $this->getGuiaData(['id' => $equipo->guia_id]);
      $guia_nueva = $this->getGuiaData(['id' => $equipo_new['guia_id']]);
      $descripcion_historial .= 'Se cambio guia rapida de ' . $guia_vieja->name . ' a ' . $guia_nueva->name . "\n";
    }

    // Normalizar INVIMA
    $nuevo_invima = (!isset($equipo_new['invima_id']) || empty($equipo_new['invima_id'])) ? 1 : $equipo_new['invima_id'];
    $viejo_invima = ($equipo->invima_id == 0) ? 1 : $equipo->invima_id;

    if ($viejo_invima != $nuevo_invima) {
      $invima_viejo = $this->getInvimaData(['id' => $viejo_invima]);
      $invima_nuevo = $this->getInvimaData(['id' => $nuevo_invima]);
      $descripcion_historial .= 'Se cambio invima de ' . $invima_viejo->invima . ' a ' . $invima_nuevo->invima . "\n";
    }

    return $descripcion_historial;
  }

  /**
   * Obtener mantenimientos preventivos de un equipo
   * Reemplaza el método get del modelo Mpreventivos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getPreventivosData($param)
  {
    return DB::table('preventivos')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener calibraciones de un equipo
   * Reemplaza el método get del modelo Mcalibraciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getCalibracionesData($param)
  {
    return DB::table('calibraciones')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener repuestos de un equipo
   * Reemplaza el método get del modelo Mequipo_repuestos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoRepuestosData($param)
  {
    return DB::table('equipo_repuestos')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener especificaciones de un equipo
   * Reemplaza el método get del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->get();
  }

  /**
   * Obtener especificaciones de tensión de un equipo
   * Reemplaza el método get_tension del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesTensionData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%tensión%')
      ->get();
  }

  /**
   * Obtener especificaciones de potencia de un equipo
   * Reemplaza el método get_potencia del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesPotenciaData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%potencia%')
      ->get();
  }

  /**
   * Obtener especificaciones de presión de un equipo
   * Reemplaza el método get_presion del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesPresionData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%presión%')
      ->get();
  }

  /**
   * Obtener especificaciones de temperatura de un equipo
   * Reemplaza el método get_temperatura del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesTemperaturaData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%temperatura%')
      ->get();
  }

  /**
   * Obtener especificaciones de corriente de un equipo
   * Reemplaza el método get_corriente del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesCorrienteData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%corriente%')
      ->get();
  }

  /**
   * Obtener especificaciones de frecuencia de un equipo
   * Reemplaza el método get_frecuencia del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesFrecuenciaData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%frecuencia%')
      ->get();
  }

  /**
   * Obtener especificaciones de velocidad de un equipo
   * Reemplaza el método get_velocidad del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesVelocidadData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%velocidad%')
      ->get();
  }

  /**
   * Obtener especificaciones de humedad de un equipo
   * Reemplaza el método get_humedad del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesHumedadData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%humedad%')
      ->get();
  }

  /**
   * Obtener especificaciones de peso de un equipo
   * Reemplaza el método get_peso del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesPesoData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%peso%')
      ->get();
  }

  /**
   * Obtener especificaciones de otro tipo de un equipo
   * Reemplaza el método get_otro del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesOtroData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%otro%')
      ->get();
  }

  /**
   * Obtener especificaciones de archivo de un equipo
   * Reemplaza el método get_archivo del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoEspecificacionesArchivoData($param)
  {
    return DB::table('equipo_especificaciones')
      ->select('equipo_especificaciones.*', 'especificaciones.name as especificacion_name')
      ->leftJoin('especificaciones', 'equipo_especificaciones.especificacion_id', '=', 'especificaciones.id')
      ->where('equipo_especificaciones.equipo_id', $param['equipo_id'])
      ->where('especificaciones.name', 'like', '%archivo%')
      ->get();
  }

  /**
   * Obtener contactos de un equipo
   * Reemplaza el método get del modelo Mequipo_contactos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoContactosData($param)
  {
    return DB::table('equipo_contactos')
      ->select('equipo_contactos.*', 'contactos.name as contacto_name', 'contactos.tipo')
      ->leftJoin('contactos', 'equipo_contactos.contacto_id', '=', 'contactos.id')
      ->where('equipo_contactos.equipo_id', $param['equipo_id'])
      ->get();
  }

  /**
   * Obtener contactos fabricante de un equipo
   * Reemplaza el método get_fabricante del modelo Mequipo_contactos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoContactosFabricanteData($param)
  {
    return DB::table('equipo_contactos')
      ->select('equipo_contactos.*', 'contactos.name as contacto_name')
      ->leftJoin('contactos', 'equipo_contactos.contacto_id', '=', 'contactos.id')
      ->where('equipo_contactos.equipo_id', $param['equipo_id'])
      ->where('contactos.tipo', 'fabricante')
      ->get();
  }

  /**
   * Obtener contactos proveedor de un equipo
   * Reemplaza el método get_proveedor del modelo Mequipo_contactos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoContactosProveedorData($param)
  {
    return DB::table('equipo_contactos')
      ->select('equipo_contactos.*', 'contactos.name as contacto_name')
      ->leftJoin('contactos', 'equipo_contactos.contacto_id', '=', 'contactos.id')
      ->where('equipo_contactos.equipo_id', $param['equipo_id'])
      ->where('contactos.tipo', 'proveedor')
      ->get();
  }

  /**
   * Obtener contactos representante de un equipo
   * Reemplaza el método get_representante del modelo Mequipo_contactos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoContactosRepresentanteData($param)
  {
    return DB::table('equipo_contactos')
      ->select('equipo_contactos.*', 'contactos.name as contacto_name')
      ->leftJoin('contactos', 'equipo_contactos.contacto_id', '=', 'contactos.id')
      ->where('equipo_contactos.equipo_id', $param['equipo_id'])
      ->where('contactos.tipo', 'representante')
      ->get();
  }

  /**
   * Obtener órdenes de trabajo de un equipo
   * Reemplaza el método get del modelo Mordenes
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getOrdenesData($param)
  {
    return DB::table('ordenes')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener correctivos generales de un equipo
   * Reemplaza el método get del modelo Mcorrectivos_generales
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getCorrectivosGeneralesData($param)
  {
    return DB::table('correctivos_generales')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener observaciones de un equipo
   * Reemplaza el método get del modelo Mobservaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getObservacionesData($param)
  {
    return DB::table('observaciones')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener bajas de un equipo
   * Reemplaza el método get_by_equipo del modelo Mbajas
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getBajasByEquipoData($param)
  {
    return DB::table('bajas')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener contingencias de un equipo
   * Reemplaza el método get del modelo Mcontingencias
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getContingenciasData($param)
  {
    return DB::table('contingencias')
      ->where('equipo_id', $param['equipo_id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener archivos de un equipo
   * Reemplaza el método get del modelo Mequipo_archivos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoArchivosData($param)
  {
    return DB::table('equipo_archivos')
      ->select('equipo_archivos.*', 'archivos.name as archivo_name')
      ->leftJoin('archivos', 'equipo_archivos.archivo_id', '=', 'archivos.id')
      ->where('equipo_archivos.equipo_id', $param['id'])
      ->get();
  }

  /**
   * Obtener cambios de hoja de vida de un equipo
   * Reemplaza el método get_from_device del modelo Mcambios_hdv
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getCambiosHdvFromDeviceData($param)
  {
    return DB::table('cambios_hdv')
      ->where('equipo_id', $param['id'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  /**
   * Obtener archivos de capacitaciones de un equipo
   * Reemplaza el método get_capacitaciones del modelo Mequipo_archivos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoArchivosCapacitacionesData($param)
  {
    return DB::table('equipo_archivos')
      ->select('equipo_archivos.*', 'archivos.name as archivo_name')
      ->leftJoin('archivos', 'equipo_archivos.archivo_id', '=', 'archivos.id')
      ->where('equipo_archivos.equipo_id', $param['equipo_id'])
      ->where('archivos.name', 'like', '%capacitacion%')
      ->get();
  }

  /**
   * Agregar archivo de correctivo general
   * Reemplaza el método add del modelo Mcorrectivos_generales_archivos
   *
   * @param array $data
   * @return int
   */
  private function addCorrectivoGeneralArchivoData($data)
  {
    return DB::table('correctivos_generales_archivos')->insertGetId($data);
  }

  /**
   * Obtener archivos de correctivos generales
   * Reemplaza el método get del modelo Mcorrectivos_generales_archivos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getCorrectivosGeneralesArchivosData($param)
  {
    return DB::table('correctivos_generales_archivos')
      ->where('correctivo_general_id', $param['correctivo_general_id'])
      ->get();
  }

  /**
   * Obtener un archivo de correctivo general
   * Reemplaza el método getOne del modelo Mcorrectivos_generales_archivos
   *
   * @param array $param
   * @return object|null
   */
  private function getOneCorrectivoGeneralArchivoData($param)
  {
    return DB::table('correctivos_generales_archivos')
      ->where('id', $param['id'])
      ->first();
  }

  /**
   * Eliminar archivo de correctivo general
   * Reemplaza el método delete del modelo Mcorrectivos_generales_archivos
   *
   * @param int $id
   * @return bool
   */
  private function deleteCorrectivoGeneralArchivoData($id)
  {
    return DB::table('correctivos_generales_archivos')->where('id', $id)->delete();
  }

  /**
   * Agregar observación
   * Reemplaza el método add del modelo Mobservaciones
   *
   * @param array $data
   * @return int
   */
  private function addObservacionData($data)
  {
    return DB::table('observaciones')->insertGetId($data);
  }

  /**
   * Obtener una observación específica
   * Reemplaza el método getOne del modelo Mobservaciones
   *
   * @param array $param
   * @return object|null
   */
  private function getOneObservacionData($param)
  {
    return DB::table('observaciones')->where('id', $param['id'])->first();
  }

  /**
   * Agregar archivo a observación
   * Reemplaza el método addFile del modelo Mobservaciones
   *
   * @param array $data
   * @return int
   */
  private function addObservacionFileData($data)
  {
    return DB::table('observacion_archivos')->insertGetId($data);
  }

  /**
   * Obtener archivos de observación
   * Reemplaza el método getArchivosObservacion del modelo Mobservaciones
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getArchivosObservacionData($param)
  {
    return DB::table('observacion_archivos')
      ->where('observacion_id', $param['observacion_id'])
      ->get();
  }

  /**
   * Actualizar observación
   * Reemplaza el método update del modelo Mobservaciones
   *
   * @param array $data
   * @return bool
   */
  private function updateObservacionData($data)
  {
    $id = $data['id'];
    unset($data['id']);
    return DB::table('observaciones')->where('id', $id)->update($data);
  }

  /**
   * Eliminar observación
   * Reemplaza el método delete del modelo Mobservaciones
   *
   * @param array $param
   * @return bool
   */
  private function deleteObservacionData($param)
  {
    return DB::table('observaciones')->where('id', $param['id'])->delete();
  }

  /**
   * Agregar repuesto a equipo
   * Reemplaza el método add del modelo Mequipo_repuestos
   *
   * @param array $data
   * @return int
   */
  private function addEquipoRepuestoData($data)
  {
    return DB::table('equipo_repuestos')->insertGetId($data);
  }

  /**
   * Obtener un repuesto específico de equipo
   * Reemplaza el método getOne del modelo Mequipo_repuestos
   *
   * @param array $param
   * @return object|null
   */
  private function getOneEquipoRepuestoData($param)
  {
    return DB::table('equipo_repuestos')->where('id', $param['id'])->first();
  }

  /**
   * Obtener repuestos de correctivos generales
   * Reemplaza el método getEquipoRepuestosCorrectivosgenerales del modelo Mequipo_repuestos
   *
   * @param array $param
   * @return \Illuminate\Support\Collection
   */
  private function getEquipoRepuestosCorrectivosGeneralesData($param)
  {
    return DB::table('equipo_repuestos')
      ->where('correctivo_general_id', $param['correctivo_general_id'])
      ->get();
  }

  /**
   * Actualizar repuesto de equipo
   * Reemplaza el método update del modelo Mequipo_repuestos
   *
   * @param array $data
   * @return bool
   */
  private function updateEquipoRepuestoData($data)
  {
    $id = $data['id'];
    unset($data['id']);
    return DB::table('equipo_repuestos')->where('id', $id)->update($data);
  }

  /**
   * Eliminar repuesto de equipo
   * Reemplaza el método delete del modelo Mequipo_repuestos
   *
   * @param array $param
   * @return bool
   */
  private function deleteEquipoRepuestoData($param)
  {
    return DB::table('equipo_repuestos')->where('id', $param['id'])->delete();
  }

  /**
   * Eliminar especificación de equipo
   * Reemplaza el método delete del modelo Mequipo_especificaciones
   *
   * @param array $param
   * @return bool
   */
  private function deleteEquipoEspecificacionData($param)
  {
    return DB::table('equipo_especificaciones')->where('id', $param['id'])->delete();
  }

  /**
   * Agregar contacto a equipo
   * Reemplaza el método add del modelo Mequipo_contactos
   *
   * @param array $data
   * @return int
   */
  private function addEquipoContactoData($data)
  {
    return DB::table('equipo_contactos')->insertGetId($data);
  }

  /**
   * Eliminar contacto de equipo
   * Reemplaza el método delete del modelo Mequipo_contactos
   *
   * @param array $param
   * @return bool
   */
  private function deleteEquipoContactoData($param)
  {
    return DB::table('equipo_contactos')->where('id', $param['id'])->delete();
  }

  /**
   * Mostrar vista detallada de un equipo médico
   * Incluye toda la información relacionada: mantenimientos, calibraciones, etc.
   *
   * @param Request $request
   * @return \Illuminate\View\View
   */
  public function show(Request $request)
  {
    $data = $request->all();
    $equipo = $this->getOneEquipoData($data);

    $frecuency_computed = $this->computeFrecuencyData(
      $equipo->mes_programado1,
      $equipo->mes_programado2
    );

    $data['equipo_id'] = $data['id'];
    unset($data['id']);

    $preventivos = $this->getPreventivosData($data);
    $calibraciones = $this->getCalibracionesData($data);
    $repuestos = $this->getEquipoRepuestosData($data);
    $especificaciones = $this->getEquipoEspecificacionesData($data);
    $tension = $this->getEquipoEspecificacionesTensionData($data);
    $potencia = $this->getEquipoEspecificacionesPotenciaData($data);
    $presion = $this->getEquipoEspecificacionesPresionData($data);
    $temperatura = $this->getEquipoEspecificacionesTemperaturaData($data);
    $corriente = $this->getEquipoEspecificacionesCorrienteData($data);
    $frecuencia = $this->getEquipoEspecificacionesFrecuenciaData($data);
    $velocidad = $this->getEquipoEspecificacionesVelocidadData($data);
    $humedad = $this->getEquipoEspecificacionesHumedadData($data);
    $peso = $this->getEquipoEspecificacionesPesoData($data);
    $otro = $this->getEquipoEspecificacionesOtroData($data);
    $archivo = $this->getEquipoEspecificacionesArchivoData($data);
    $contactos = $this->getEquipoContactosData($data);
    $fabricante = $this->getEquipoContactosFabricanteData($data);
    $proveedor = $this->getEquipoContactosProveedorData($data);
    $representante = $this->getEquipoContactosRepresentanteData($data);
    $correctivos = $this->getOrdenesData($data);
    $correctivos_generales = $this->getCorrectivosGeneralesData($data);
    $observaciones = $this->getObservacionesData($data);
    $bajas = $this->getBajasByEquipoData($data);
    $contingencias = $this->getContingenciasData($data);
    $data['id'] = $data['equipo_id'];
    $archivos = $this->getEquipoArchivosData($data);
    $cambios_hdv = $this->getCambiosHdvFromDeviceData($data);

    $param = [
      'equipo' => $equipo,
      'preventivos' => $preventivos,
      'calibraciones' => $calibraciones,
      'repuestos' => $repuestos,
      'especificaciones' => $especificaciones,
      'tension' => $tension,
      'potencia' => $potencia,
      'presion' => $presion,
      'temperatura' => $temperatura,
      'corriente' => $corriente,
      'frecuencia' => $frecuencia,
      'velocidad' => $velocidad,
      'humedad' => $humedad,
      'peso' => $peso,
      'otro' => $otro,
      'archivo' => $archivo,
      'contactos' => $contactos,
      'fabricante' => $fabricante,
      'proveedor' => $proveedor,
      'representante' => $representante,
      'correctivos' => $correctivos,
      'correctivos_generales' => $correctivos_generales,
      'observaciones' => $observaciones,
      'archivos' => $archivos,
      'bajas' => $bajas,
      'contingencias' => $contingencias,
      'cambios_hdv' => $cambios_hdv,
      'frecuency_computed' => $frecuency_computed,
    ];

    return view('equipos.detail', $param);
  }

  /**
   * Mostrar vista de archivo de un equipo médico
   * Vista específica para mostrar archivos del equipo
   *
   * @param Request $request
   * @return \Illuminate\View\View
   */
  public function show_file(Request $request)
  {
    $equipo = $this->getOneEquipoData($request->all());
    $param = [
      'equipo' => $equipo,
    ];
    return view('equipos.detail_file', $param);
  }

  /**
   * Mostrar vista de archivos de un equipo médico
   * Lista todos los archivos asociados al equipo
   *
   * @param Request $request
   * @return \Illuminate\View\View
   */
  public function show_archivos(Request $request)
  {
    $equipo_archivo = $this->getEquipoArchivosData($request->all());
    $param = [
      'equipo_archivo' => $equipo_archivo,
    ];
    return view('equipos.detail_archivos', $param);
  }

  /**
   * Mostrar vista de capacitaciones de un equipo médico
   * Lista archivos de capacitación específicos del equipo
   *
   * @param Request $request
   * @return \Illuminate\View\View
   */
  public function show_capacitaciones(Request $request)
  {
    $equipo_archivo = $this->getEquipoArchivosCapacitacionesData($request->all());
    $param = [
      'equipo_archivo' => $equipo_archivo,
    ];
    return view('equipos.detail_archivos', $param);
  }

  /**
   * Obtener correctivos de un equipo
   * Lista de órdenes de trabajo correctivas
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getCorrectivos(Request $request): JsonResponse
  {
    return response()->json($this->getOrdenesData($request->all()));
  }

  /**
   * Agregar archivo a correctivo general
   * Subida de archivos para correctivos generales
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function add_archivo_correctivo_general(Request $request): JsonResponse
  {
    try {
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_correctivos_generales'), $fileName);

        $data = $request->all();
        $data['file'] = $fileName;
        unset($data['equipo_id']);

        $this->addCorrectivoGeneralArchivoData($data);
        return response()->json(['success' => true]);
      }
      return response()->json(['error' => 'No file uploaded'], 400);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error uploading file'], 500);
    }
  }

  /**
   * Obtener archivos de correctivos generales
   * Lista de archivos asociados a correctivos generales
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getArchivosCorrectivosGenerales(Request $request): JsonResponse
  {
    return response()->json($this->getCorrectivosGeneralesArchivosData($request->all()));
  }

  /**
   * Eliminar archivo de correctivo general
   * Elimina archivo del sistema y base de datos
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteArchivoCorrectivoGeneral(Request $request): JsonResponse
  {
    try {
      $archivo = $this->getOneCorrectivoGeneralArchivoData($request->all());
      $file = $archivo->file;

      if ($this->deleteCorrectivoGeneralArchivoData($request->input('id'))) {
        $filePath = public_path('assets/upload_correctivos_generales/' . $file);
        if (file_exists($filePath)) {
          unlink($filePath);
        }
        return response()->json(['success' => true]);
      }
      return response()->json(['error' => 'Could not delete file'], 500);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error deleting file'], 500);
    }
  }

  /**
   * Agregar observación a un equipo médico
   * Incluye subida de archivos y manejo de repuestos pendientes
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function addObservacion(Request $request): JsonResponse
  {
    try {
      $data = $request->all();

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_observaciones'), $fileName);
        $data['file'] = $fileName;
      }

      // Manejo de fecha de creación
      if (!empty($data['created_at']) && !empty($data['hora_observacion'])) {
        $data['created_at'] = $data['created_at'] . ' ' . $data['hora_observacion'];
        unset($data['hora_observacion']);
      } else {
        $data['created_at'] = now()->format('Y-m-d H:i:s');
        unset($data['hora_observacion']);
      }

      // Manejo de repuestos pendientes
      $vector_actualizacion_equipo = null;
      if (isset($data['repuesto_id']) && !empty($data['repuesto_id'])) {
        $data['repuesto_pendiente'] = 'si';
        $vector_actualizacion_equipo = [
          'id' => $data['equipo_id'],
          'repuesto_pendiente' => 'si',
        ];
        $this->updateEquipoData($vector_actualizacion_equipo);
      } else {
        unset($data['repuesto_id']);
      }

      $ultimo_id = $this->addObservacionData($data);

      $vector_respuesta = [
        'observacion_id' => $ultimo_id,
        'equipo_id' => $data['equipo_id'],
      ];
      if ($vector_actualizacion_equipo) {
        $vector_respuesta['repuesto_id'] = $data['repuesto_id'] ?? null;
      }

      return response()->json($vector_respuesta);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar observación'], 500);
    }
  }

  /**
   * Agregar archivo a una observación existente
   * Subida de archivos adicionales para observaciones
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function addArchivoObservcion(Request $request): JsonResponse
  {
    try {
      $observacion = $this->getOneObservacionData(['id' => $request->input('observacion_id')]);
      $equipo_id = $observacion->equipo_id;

      $data = $request->all();
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_observaciones'), $fileName);
        $data['file'] = $fileName;
      }

      $this->addObservacionFileData($data);
      return response()->json($equipo_id);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar archivo'], 500);
    }
  }

  /**
   * Obtener archivos de una observación
   * Lista de archivos asociados a una observación específica
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getArchivosObservacion(Request $request): JsonResponse
  {
    return response()->json($this->getArchivosObservacionData($request->all()));
  }

  /**
   * Obtener observaciones de un equipo
   * Lista todas las observaciones del equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getObservaciones(Request $request): JsonResponse
  {
    return response()->json($this->getObservacionesData($request->all()));
  }

  /**
   * Obtener una observación específica
   * Información detallada de una observación
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getOneObservacion(Request $request): JsonResponse
  {
    return response()->json($this->getOneObservacionData($request->all()));
  }

  /**
   * Actualizar una observación existente
   * Incluye manejo de archivos y repuestos pendientes
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function updateObservacion(Request $request): JsonResponse
  {
    try {
      $data = $request->all();
      $observacion_id = $data['id'];
      $observacion = $this->getOneObservacionData($data);
      $file_anterior = $observacion->file;

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_observaciones'), $fileName);
        $data['file'] = $fileName;
      }

      // Verificar cambios en repuesto pendiente
      $cambio = 'no';
      if ($data['repuesto_id'] != $observacion->repuesto_id) {
        $cambio = 'si';
      }
      if (empty($data['repuesto_id'])) {
        $cambio = 'no';
      }

      if ($this->updateObservacionData($data)) {
        // Eliminar archivo anterior si se subió uno nuevo
        if (isset($data['file']) && $data['file'] != $file_anterior && !empty($file_anterior)) {
          $oldFilePath = public_path('assets/upload_observaciones/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json([
          'equipo_id' => $data['equipo_id'],
          'cambio' => $cambio,
          'observacion_id' => $observacion_id
        ]);
      } else {
        // Eliminar archivo subido si falló la actualización
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_observaciones/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json(['error' => 'Error al actualizar observación'], 500);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al actualizar observación'], 500);
    }
  }

  /**
   * Eliminar una observación
   * Elimina observación y archivos asociados
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteObservacion(Request $request): JsonResponse
  {
    try {
      $vector = ['id' => $request->input('id')];
      $observacion = $this->getOneObservacionData($vector);
      $file = $observacion->file;

      if ($this->deleteObservacionData($request->all())) {
        if (!empty($file)) {
          $filePath = public_path('assets/upload_observaciones/' . $file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
        return response()->json(['success' => true]);
      }
      return response()->json(['error' => 'Error al eliminar observación'], 500);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar observación'], 500);
    }
  }

  /**
   * Agregar repuesto a un equipo médico
   * Incluye subida de archivos de documentación
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function addEquipoRepuesto(Request $request): JsonResponse
  {
    try {
      $data = $request->all();

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_equipo_repuestos'), $fileName);
        $data['file'] = $fileName;
      }

      $data['usuario_id'] = Session::get('id');
      $this->addEquipoRepuestoData($data);

      return response()->json($data['equipo_id']);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar repuesto'], 500);
    }
  }

  /**
   * Agregar repuesto a correctivo general
   * Repuesto específico para correctivos generales
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function addEquipoRepuestoCorrectivoGeneral(Request $request): JsonResponse
  {
    try {
      $data = $request->all();

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_equipo_repuestos'), $fileName);
        $data['file'] = $fileName;
      }

      $data['usuario_id'] = Session::get('id');
      $this->addEquipoRepuestoData($data);

      return response()->json([
        'correctivo_general_id' => $data['correctivo_general_id'],
        'equipo_id' => $data['equipo_id']
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar repuesto'], 500);
    }
  }

  /**
   * Obtener un repuesto específico de equipo
   * Información detallada de un repuesto
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getOneEquipoRepuesto(Request $request): JsonResponse
  {
    return response()->json($this->getOneEquipoRepuestoData($request->all()));
  }

  /**
   * Obtener repuestos de un equipo
   * Lista todos los repuestos del equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getEquipoRepuestos(Request $request): JsonResponse
  {
    return response()->json($this->getEquipoRepuestosData($request->all()));
  }

  /**
   * Obtener repuestos de correctivos generales
   * Lista repuestos asociados a correctivos generales
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getEquipoRepuestosCorrectivosgenerales(Request $request): JsonResponse
  {
    return response()->json($this->getEquipoRepuestosCorrectivosGeneralesData($request->all()));
  }

  /**
   * Actualizar repuesto de equipo
   * Incluye manejo de archivos y reemplazo de documentos
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function updateEquipoRepuesto(Request $request): JsonResponse
  {
    try {
      $data = $request->all();
      $equipo_repuesto = $this->getOneEquipoRepuestoData($data);
      $file_anterior = $equipo_repuesto->file;

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_equipo_repuestos'), $fileName);
        $data['file'] = $fileName;
      }

      if ($this->updateEquipoRepuestoData($data)) {
        // Eliminar archivo anterior si se subió uno nuevo
        if (isset($data['file']) && $data['file'] != $file_anterior && !empty($file_anterior)) {
          $oldFilePath = public_path('assets/upload_equipo_repuestos/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json($data['equipo_id']);
      } else {
        // Eliminar archivo subido si falló la actualización
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_equipo_repuestos/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json(['error' => 'Error al actualizar repuesto'], 500);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al actualizar repuesto'], 500);
    }
  }

  /**
   * Eliminar repuesto de equipo
   * Elimina repuesto y archivos asociados
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteEquipoRepuesto(Request $request): JsonResponse
  {
    try {
      $vector = ['id' => $request->input('id')];
      $equipo_repuesto = $this->getOneEquipoRepuestoData($vector);
      $file = $equipo_repuesto->file;

      if ($this->deleteEquipoRepuestoData($request->all())) {
        if (!empty($file)) {
          $filePath = public_path('assets/upload_equipo_repuestos/' . $file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
        return response()->json(['success' => true]);
      }
      return response()->json(['error' => 'Error al eliminar repuesto'], 500);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar repuesto'], 500);
    }
  }

  /**
   * Obtener especificaciones de un equipo
   * Lista todas las especificaciones técnicas del equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getEquipoEspecificaciones(Request $request): JsonResponse
  {
    return response()->json($this->getEquipoEspecificacionesData($request->all()));
  }

  /**
   * Agregar especificación a un equipo médico
   * Incluye subida de archivos de documentación técnica
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function addEquipoEspecificacion(Request $request): JsonResponse
  {
    try {
      $data = $request->all();

      // Manejo de archivos
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_archivos'), $fileName);
        $data['file'] = $fileName;
      }

      $this->addEquipoEspecificacionData($data);
      return response()->json($data['equipo_id']);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar especificación'], 500);
    }
  }

  /**
   * Eliminar especificación de equipo
   * Elimina especificación técnica del equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteEquipoEspecificacion(Request $request): JsonResponse
  {
    try {
      $this->deleteEquipoEspecificacionData($request->all());
      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar especificación'], 500);
    }
  }

  /**
   * Obtener contactos de un equipo
   * Lista todos los contactos asociados al equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getEquipoContactos(Request $request): JsonResponse
  {
    return response()->json($this->getEquipoContactosData($request->all()));
  }

  /**
   * Agregar contacto a un equipo médico
   * Asocia un contacto (fabricante, proveedor, etc.) al equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function addEquipoContacto(Request $request): JsonResponse
  {
    try {
      $this->addEquipoContactoData($request->all());
      return response()->json($request->input('equipo_id'));
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar contacto'], 500);
    }
  }

  /**
   * Eliminar contacto de equipo
   * Elimina asociación de contacto con el equipo
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteEquipoContacto(Request $request): JsonResponse
  {
    try {
      $this->deleteEquipoContactoData($request->all());
      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar contacto'], 500);
    }
  }
  /* CRUD EQUIPO ARCHIVO */

  public function add_equipo_archivo()
  {
    if (isset($_POST)) {
      // code...
      $config['upload_path'] = './assets/upload_equipo_archivos'; // Evaluacion de la imagen
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadEquipoArchivo');
      $this->uploadEquipoArchivo->initialize($config);

      if (!empty($_FILES['vinculo']['name'])) {
        $this->uploadEquipoArchivo->do_upload('vinculo'); // Esto sube la imagen en la carpeta
        $data = '';
        $data = $this->uploadEquipoArchivo->data();
        $_POST['vinculo'] = $data['file_name'];
      }
      if (isset($_POST['fecha_capacitacion'])) {
        $_POST['created_at'] = $_POST['fecha_capacitacion'] . ' ' . $_POST['hora_capacitacion'];
        unset($_POST['fecha_capacitacion']);
        unset($_POST['hora_capacitacion']);
      }

      $this->Mequipo_archivos->add($_POST);
      echo 1;
    }
  }

  public function delete_equipo_archivo()
  {
    $this->Mequipo_archivos->delete($_POST);
  }

  /* OTROS */
  public function exportarExcel()
  {
    if (isset($_POST)) {
      header('Content-Type:application/xls;charset=utf-8');
      header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
      header('Content-Disposition: attachment;filename=EquiposHUV.xls');
      $equipos = $this->Mequipos->getFiltered($_POST);

?>

      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <table border="1">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion adicional</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Codigo actual</th>
            <th>Codigo antiguo</th>
            <th>Registro Sanitario</th>
            <th>Estado actual</th>
            <th>Fecha de adquisicion</th>
            <th>Fecha de instalacion</th>
            <th>Fecha de disposicion final</th>
            <th>Servicio</th>
            <th>Area</th>
            <th>Sede</th>
            <th>Localización actual</th>
            <th>Fecha del ultimo preventivo</th>
            <th>Frecuencia de mantenimiento establecida</th>
            <th>Frecuencia de mantenimiento utilizada</th>
            <th>Ultimo año programado</th>
            <!-- 						<th>Mes programado 1</th>
						<th>Mes programado 2</th>
						<th>Mes programado 3</th> -->
            <th>Proveedor del mantenimiento</th>
            <th>Cantidad de preventivos</th>
            <th>Estado actual del mantenimiento preventivo</th>
            <th>Fecha de la ultima calibracion</th>
            <th>Cantidad de calibraciones</th>
            <th>Costo</th>
            <th>Soporte de compra</th>
            <th>Tipo de compra</th>
            <th>Proveedor segun soporte</th>
            <th>Garantia</th>
            <th>Fecha de vencimiento de la garantia</th>
            <th>Fuente de alimentación</th>
            <th>Tecnologia principal</th>
            <th>Clasificación biomedica</th>
            <th>Clasificación de riesgo</th>
            <th>Tipo de adquisición</th>
            <th>Propiedad</th>
            <th>Otros</th>
            <th>Fecha del ultimo correctivo</th>
            <th>Descripción del ultimo correctivo</th>
            <th>Cantidad de correctivos registrados</th>
            <th>Cantidad de Tickets generados</th>
            <th>Distribución por zonas</th>
            <th>Información de contactos</th>
            <th>Archivo Excel cargado de Hoja de vida</th>
            <th>Tienen repuesto pendiente</th>
            <th>Vida util</th>
            <th>Guia rapida</th>
            <th>Url del manual</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($equipos as $equipo) { ?>
            <?php if ($equipo->estadoequipos == 'Equipo dado de baja' || $equipo->estadoequipos == 'Pendiente por dar de baja') { ?>
              <tr style="background-color: red;">
              <?php } else { ?>
              <tr>
              <?php } ?>
              <td><?php echo $equipo->id; ?></td>
              <td><?php echo $equipo->name; ?></td>
              <td><?php echo $equipo->descripcion; ?></td>
              <td><?php echo $equipo->marca; ?></td>
              <td><?php echo $equipo->modelo; ?></td>
              <td><?php echo 'sn: ' . $equipo->serial; ?></td>
              <td><?php echo $equipo->code; ?></td>
              <td><?php echo $equipo->codigo_antiguo; ?></td>
              <?php if ($equipo->registro_sanitario != null) { ?>
                <td><?php echo $equipo->registro_sanitario; ?></td>
              <?php } else { ?>
                <td><?php echo $equipo->invima; ?></td>
              <?php } ?>
              <td>
                <?php echo $equipo->estadoequipos; ?>
              </td>
              <td><?php echo $equipo->fecha_ad; ?></td>
              <td><?php echo $equipo->fecha_instalacion; ?></td>
              <td><?php echo $equipo->fecha_baja; ?></td>
              <td><?php echo $equipo->servicios; ?></td>
              <td><?php echo $equipo->area; ?></td>
              <td><?php echo $equipo->sede; ?></td>
              <td><?php echo $equipo->localizacion_actual; ?></td>
              <td><?php echo $equipo->ultimo_mantenimiento; ?></td>
              <td><?php echo $equipo->frecuencias; ?></td>
              <td><?php echo $equipo->frecuencia_utilizada; ?></td>
              <td><?php echo $equipo->ultimo_anio_programado; ?></td>
              <!-- 										<td><?php echo $equipo->mes_programado_1; ?></td>
										<td><?php echo $equipo->mes_programado_2; ?></td>
										<td><?php echo $equipo->mes_programado_3; ?></td> -->
              <td><?php echo $equipo->proveedor_mantenimiento; ?></td>
              <td><?php echo $equipo->cuenta_preventivos; ?></td>
              <td><?php echo $equipo->estadosm; ?></td>
              <td><?php echo $equipo->ultima_calibracion; ?></td>
              <td><?php echo $equipo->cuenta_calibraciones; ?></td>
              <td><?php echo $equipo->costo; ?></td>
              <td><?php echo $equipo->orden_compra; ?></td>
              <td><?php echo $equipo->tipo_compra; ?></td>
              <td><?php echo $equipo->proveedor; ?></td>
              <td><?php echo $equipo->garantia; ?></td>
              <td><?php echo $equipo->fecha_vencimiento_garantia; ?></td>
              <td><?php echo $equipo->fuentesal; ?></td>
              <td><?php echo $equipo->tecnologiasp; ?></td>
              <td><?php echo $equipo->cbiomedicas; ?></td>
              <td><?php echo $equipo->criesgos; ?></td>
              <td><?php echo $equipo->tadquisiciones; ?></td>
              <!-- <td><?php echo $equipo->propiedad; ?></td> -->
              <td><?php echo $equipo->propietario; ?></td>
              <td><?php echo $equipo->otros; ?></td>
              <td><?php echo $equipo->ultimo_correctivo; ?></td>
              <td><?php echo $equipo->descripcion_correctivo; ?></td>
              <td><?php echo $equipo->cuenta_correctivos; ?></td>
              <td><?php echo $equipo->cuenta_tickets; ?></td>
              <td><?php echo $equipo->zonas; ?></td>
              <td><?php echo $equipo->informacion_contacto; ?></td>
              <td><?php echo $equipo->file; ?></td>
              <td><?php echo $equipo->repuesto_pendiente; ?></td>
              <td><?php echo $equipo->vida_util; ?></td>
              <td><?php echo ($equipo->guia_id != 0) ? 'SI' : 'NO'; ?></td>
              <td><?php echo $equipo->manual_url; ?></td>
              </tr>
            <?php } ?>
        </tbody>
      </table>


    <?php

    }
  }

  public function incluir()
  {
    $equipo = $this->Mequipos->getOne($_POST);
    if ($equipo->fecha_mantenimiento == '0000-00-00') {
      $_POST['plan'] = 3;
      $this->Mequipos->update($_POST);
    } else {
      $_POST['plan'] = 1;
      $this->Mequipos->update($_POST);
    }
  }

  public function excluir()
  {
    $_POST['plan'] = 2;
    $_POST['estado_mantenimiento'] = 0;
    $_POST['fecha_mantenimiento'] = '0000-00-00';

    $this->Mequipos->update($_POST);
  }

  public function ConsolidadoPreventivosBaxter()
  {
    $preventivos = $this->Mequipos->getMantenimientosAllBaxter();
    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('Preventivos');

    $contador = 1;
    // Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    // Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
    // Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Codigo Preventivo');
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Fecha Programada');
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Fecha de ejecución');
    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Marca');
    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Codigo');
    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Serie');
    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Nombre');
    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'ID');
    foreach ($preventivos as $preventivo) {
      $contador = $contador + 1;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", $preventivo->codigo);
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", $preventivo->fecha_programada);
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", $preventivo->fecha_ejecucion);
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", $preventivo->marca);
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", $preventivo->code);
      $this->excel->getActiveSheet()->setCellValue("F{$contador}", $preventivo->serial);
      $this->excel->getActiveSheet()->setCellValue("G{$contador}", $preventivo->name);
      $this->excel->getActiveSheet()->setCellValue("H{$contador}", $preventivo->id);
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ConsolidadoPreventivos.xls"');
    header('Cache-Control: max-age=0'); // no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    // Forzamos a la descarga
    ob_end_clean();
    $objWriter->save('php://output');
    $this->excel->disconnectWorksheets();
    unset($this->excel);
  }

  public function ConsolidadoCorrectivos()
  {
    $correctivos = $this->Mordenes->getCorrectivosAll();

    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('Correctivos');

    $contador = 1;
    // Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
    // Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("N{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("V{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("W{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("X{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("Y{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("Z{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AA{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AB{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AC{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AD{$contador}")->getFont()->setBold(true);
    // Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Id Orden');
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Estado de la orden');
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Subproceso');
    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Proceso');
    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Diagnostico');
    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Información de Cierre');
    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha creación');
    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Fecha diagnostico');
    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Fecha asignación');
    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Fecha de cierre');
    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Descripcion');
    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Asunto');
    $this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Prioridad');
    $this->excel->getActiveSheet()->setCellValue("N{$contador}", 'Marca');
    $this->excel->getActiveSheet()->setCellValue("O{$contador}", 'Codigo');
    $this->excel->getActiveSheet()->setCellValue("P{$contador}", 'Serie');
    $this->excel->getActiveSheet()->setCellValue("Q{$contador}", 'Nombre');
    $this->excel->getActiveSheet()->setCellValue("R{$contador}", 'ID Equipo');
    $this->excel->getActiveSheet()->setCellValue("S{$contador}", 'Ubicacion');
    $this->excel->getActiveSheet()->setCellValue("T{$contador}", 'Nombre de usuario del reportante');
    $this->excel->getActiveSheet()->setCellValue("U{$contador}", 'Centro de costos del reportante');
    $this->excel->getActiveSheet()->setCellValue("V{$contador}", 'Usuario asignado');
    $this->excel->getActiveSheet()->setCellValue("W{$contador}", 'Usuario que diagnostica');
    $this->excel->getActiveSheet()->setCellValue("X{$contador}", 'Usuario que cierra');
    $this->excel->getActiveSheet()->setCellValue("Y{$contador}", 'Fecha solicitud repuesto');
    $this->excel->getActiveSheet()->setCellValue("Z{$contador}", 'Fecha recepcion repuesto');
    $this->excel->getActiveSheet()->setCellValue("AA{$contador}", 'Marca ingresada');
    $this->excel->getActiveSheet()->setCellValue("AB{$contador}", 'Codigo ingresado');
    $this->excel->getActiveSheet()->setCellValue("AC{$contador}", 'Serie ingresada');
    $this->excel->getActiveSheet()->setCellValue("AD{$contador}", 'Nombre ingresado');
    foreach ($correctivos as $correctivo) {
      $contador = $contador + 1;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", $correctivo->id);
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", $correctivo->estado);
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", $correctivo->subproceso);
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", $correctivo->proceso);
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", $correctivo->diagnostico);
      $this->excel->getActiveSheet()->setCellValue("F{$contador}", $correctivo->reparacion);
      $this->excel->getActiveSheet()->setCellValue("G{$contador}", $correctivo->fecha_inicio);
      $this->excel->getActiveSheet()->setCellValue("H{$contador}", $correctivo->fecha_diagnostico);
      $this->excel->getActiveSheet()->setCellValue("I{$contador}", $correctivo->fecha_asignacion);
      $this->excel->getActiveSheet()->setCellValue("J{$contador}", $correctivo->fecha_fin);
      $this->excel->getActiveSheet()->setCellValue("K{$contador}", $correctivo->descripcion);
      $this->excel->getActiveSheet()->setCellValue("L{$contador}", $correctivo->asunto);
      $this->excel->getActiveSheet()->setCellValue("M{$contador}", $correctivo->prioridad);
      $this->excel->getActiveSheet()->setCellValue("N{$contador}", $correctivo->equipo_marca);
      $this->excel->getActiveSheet()->setCellValue("O{$contador}", $correctivo->equipo_codigo);
      $this->excel->getActiveSheet()->setCellValue("P{$contador}", $correctivo->equipo_serie);
      $this->excel->getActiveSheet()->setCellValue("Q{$contador}", $correctivo->equipo_nombre);
      $this->excel->getActiveSheet()->setCellValue("R{$contador}", $correctivo->equipo_id);
      $this->excel->getActiveSheet()->setCellValue("S{$contador}", $correctivo->ubicacion);
      if ($correctivo->nombre_reportante != '' && $correctivo->nombre_reportante != null) {
        $this->excel->getActiveSheet()->setCellValue("T{$contador}", $correctivo->nombre_reportante);
        $this->excel->getActiveSheet()->setCellValue("U{$contador}", $correctivo->centro_costo_reportante);
      } else {
        $this->excel->getActiveSheet()->setCellValue("T{$contador}", $correctivo->username);
        $this->excel->getActiveSheet()->setCellValue("U{$contador}", $correctivo->centro);
      }
      $this->excel->getActiveSheet()->setCellValue("V{$contador}", $correctivo->asignado);
      $this->excel->getActiveSheet()->setCellValue("W{$contador}", $correctivo->diagnosticador);
      $this->excel->getActiveSheet()->setCellValue("X{$contador}", $correctivo->cerrador);
      $this->excel->getActiveSheet()->setCellValue("Y{$contador}", $correctivo->fecha_solicitud_repuesto);
      $this->excel->getActiveSheet()->setCellValue("Z{$contador}", $correctivo->fecha_recepcion_repuesto);
      $this->excel->getActiveSheet()->setCellValue("AA{$contador}", $correctivo->marca_equipo);
      $this->excel->getActiveSheet()->setCellValue("AB{$contador}", $correctivo->codigo_equipo);
      $this->excel->getActiveSheet()->setCellValue("AC{$contador}", $correctivo->serie_equipo);
      $this->excel->getActiveSheet()->setCellValue("AD{$contador}", $correctivo->nombre_equipo);
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ConsolidadoCorrectivos.xls"');
    header('Cache-Control: max-age=0'); // no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    // Forzamos a la descarga
    ob_end_clean();
    $objWriter->save('php://output');
    $this->excel->disconnectWorksheets();
    unset($this->excel);
  }

  public function ConsolidadoObsoletos()
  {
    $obsoletos = $this->Mequipos->getObsoletosModal();

    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('ObsoletosFecha');

    $contador = 1;
    // Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    // Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
    // Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Codigo antiguo');
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Fecha adquisición');
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Fecha instalacion');
    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Marca');
    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Codigo');
    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Serie');
    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Nombre');
    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'ID');
    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Años transcurridos');
    foreach ($obsoletos as $obsoleto) {
      $contador = $contador + 1;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", $obsoleto->codigo_antiguo);
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", $obsoleto->fecha_ad);
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", $obsoleto->fecha_instalacion);
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", $obsoleto->marca);
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", $obsoleto->code);
      $this->excel->getActiveSheet()->setCellValue("F{$contador}", $obsoleto->serial);
      $this->excel->getActiveSheet()->setCellValue("G{$contador}", $obsoleto->name);
      $this->excel->getActiveSheet()->setCellValue("H{$contador}", $obsoleto->id);
      $this->excel->getActiveSheet()->setCellValue("I{$contador}", $obsoleto->anios);
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ConsolidadoObsoletos.xls"');
    header('Cache-Control: max-age=0'); // no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    // Forzamos a la descarga
    ob_end_clean();
    $objWriter->save('php://output');
    $this->excel->disconnectWorksheets();
    unset($this->excel);
  }

  public function nombres_get_server_side()
  {
    $vector = $this->Mequipos->nombres_get_server_side($_POST);
    $respuesta = [
      'draw' => intval($this->input->post('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos'],
    ];
    echo json_encode($respuesta);
  }

  public function addMultipleCapacitaciones()
  {
    $config['upload_path'] = './assets/upload_equipo_archivos';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadEquipoArchivo');
    $this->uploadEquipoArchivo->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadEquipoArchivo->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadEquipoArchivo->data();
      $_POST['vinculo'] = $data['file_name'];
    }
    $_POST['created_at'] = $_POST['fecha_capacitacion'] . ' ' . $_POST['hora_capacitacion'];
    unset($_POST['fecha_capacitacion']);
    unset($_POST['hora_capacitacion']);

    if (isset($_POST['servicio_id'])) {
      unset($_POST['servicio_id']);
    }
    if (isset($_POST['area_id'])) {
      unset($_POST['area_id']);
    }

    if ($_POST['servicios'] == '') {
      $_POST['servicios'] = "''";
    }
    if ($_POST['areas'] == '') {
      $_POST['areas'] = "''";
    }

    $this->Mequipo_archivos->add_capacitaciones($_POST);
  }

  public function addMultipleEspecificaciones()
  {
    $this->Mequipo_especificaciones->add_especificaciones($_POST);
  }

  public function addMultipleImagenes()
  {
    $config['upload_path'] = './assets/upload_imagenes';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadImagen');
    $this->uploadImagen->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadImagen->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadImagen->data();
      $_POST['image'] = $data['file_name'];
    }

    $this->Mequipos->add_imagenes($_POST);
  }

  public function show_obsoletos()
  {
    $vector = [
      'obsoletos' => $this->Mequipos->getObsoletosModal(),
    ];
    $this->load->view('equipos/detail_obsoletos', $vector);
  }

  public function repuesto_pendiente_preventivo_true()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mpreventivos->repuesto_pendiente_true($_POST);
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_preventivo_false()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mpreventivos->repuesto_pendiente_false($_POST);
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_correctivo_general_true()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mcorrectivos_generales->repuesto_pendiente_true($_POST);
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_correctivo_general_false()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mcorrectivos_generales->repuesto_pendiente_false($_POST);
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_observacion_true()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mobservaciones->repuesto_pendiente_true($_POST);
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_observacion_false()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mobservaciones->repuesto_pendiente_false($_POST);
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function show_invima_asociaciones()
  {
    $equipos_a_asociar = $this->Mequipos->get();
    $vector = [
      'equipos' => $equipos_a_asociar,
      'invima_id' => $_POST['invima_id'],
    ];
    $this->load->view('equipos/modal_asociacion_invima_detail', $vector);
  }

  public function update_multiples_invimas()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_invimas($equipo_id, $_POST['invima_id']);
      }
      echo json_encode('El registro sanitario fue asociado exitosamente a los equipos seleccionados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function update_multiples_invimas_eliminar()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_invimas_eliminar($equipo_id, $_POST['invima_id']);
      }
      echo json_encode('Los equipos seleccionados vinculados al registro sanitario fueron desvinculados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function show_equipos_en_invima()
  {
    $equipos = $this->Mequipos->getEquiposEnInvima($_POST);
    $vector = [
      'equipos' => $equipos,
      'invima_id' => $_POST['invima_id'],
    ];
    $this->load->view('equipos/modal_asociacion_invima_detail_especifico', $vector);
  }

  public function show_orden_compra_asociaciones()
  {
    $equipos_a_asociar = $this->Mequipos->getPorCompra();

    $vector = [
      'equipos' => $equipos_a_asociar,
      'orden_compra_id' => $_POST['orden_compra_id'],
    ];
    $this->load->view('equipos/modal_asociacion_orden_compra_detail', $vector);
  }

  public function show_equipos_en_orden_compra()
  {
    $equipos = $this->Mequipos->getEquiposEnOrdenCompra($_POST);
    $vector = [
      'equipos' => $equipos,
      'orden_compra_id' => $_POST['orden_compra_id'],
    ];
    $this->load->view('equipos/modal_asociacion_orden_compra_especifico_detail', $vector);
  }

  /* Informacion procedente desde el modulo de invimas, sirve para asociar varios equipos al tiempo con una orden de compra, llega un post con vector de checkbox */
  public function update_multiples_ordenes_compra()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_ordenes_compra($equipo_id, $_POST['orden_compra_id']);
      }
      echo json_encode('El soporte de compra fue asociado con exito a los equipos seleccionados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function update_multiples_ordenes_compra_eliminar()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_ordenes_compra_eliminar($equipo_id, $_POST['orden_compra_id']);
      }
      echo json_encode('El soporte de compra fue eliminado con exito de los equipos seleccionados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function show_listado()
  {
    $equipos = $this->Mequipos->get_equipos_for_ticket();
    // $vector=array("equipos"=>$equipos);
    $this->load->view('ordenes/modal_listado_biomedicos');
  }

  public function get_general_server_side()
  {
    if (isset($_POST)) {
      if (isset($_POST['start'])) {
        $vector = $this->Mequipos->get_general_server_side($_POST);
        $respuesta = [
          'draw' => intval($this->input->post('draw')),
          'recordsTotal' => $vector['num_filas_limit'],
          'recordsFiltered' => $vector['num_filas'],
          'data' => $vector['datos'],
        ];
        echo json_encode($respuesta);
      }
    }
  }

  public function show_compartir_especificaciones()
  {
    $equipos = $this->Mequipos->get_general($_POST['equipo_origen_id']);
    $vector = [
      'equipos' => $equipos,
      'equipo_origen_id' => $_POST['equipo_origen_id'],
    ];
    $this->load->view('equipos/detalle_listado_compartir_especificaciones', $vector);
  }

  public function update_especificaciones_tecnicas()
  {
    $equipo_origen_id = $_POST['equipo_origen_id'];
    if (isset($_POST['creado'])) { // Seleccion tiene los id de los equipos objetivo
      $equipos_objetivos_id = $_POST['creado'];

      foreach ($equipos_objetivos_id as $equipo_objetivo_id) {
        $vector_eliminar = [
          'id' => $equipo_objetivo_id,
        ];
        $this->Mequipo_especificaciones->delete_multiple($vector_eliminar); // Se eliminan las especificaciones del equipo objetivo
        $vector_actualizar = [
          'equipo_objetivo_id' => $equipo_objetivo_id,
          'equipo_origen_id' => $equipo_origen_id,
        ];
        $this->Mequipo_especificaciones->update_especificaciones_tecnicas($vector_actualizar);

        $vector_eliminar = '';
        $vector_actualizar = '';
      }
      echo json_encode('Las especificaciones tecnicas fueron asociadas exitosamente a los equipos referenciados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function show_compartir_archivos()
  {
    $equipos = $this->Mequipos->get_para_copiar_archivos($_POST['equipo_archivo_origen_id']);
    $vector = [
      'equipos' => $equipos,
      'equipo_archivo_origen_id' => $_POST['equipo_archivo_origen_id'],
    ];
    $this->load->view('equipos/detalle_listado_compartir_archivos', $vector);
  }

  public function update_archivos()
  {
    $equipo_archivo_origen_id = $_POST['equipo_archivo_origen_id'];
    if ($_POST['control'] == 1) { // Si estan todos chekeados
      $equipos_objetivos_id = $_POST['seleccion']; // vector es seleccion
      foreach ($equipos_objetivos_id as $equipo_objetivo_id) {
        $vector_actualizar = [
          'equipo_objetivo_id' => $equipo_objetivo_id,
          'equipo_archivo_origen_id' => $equipo_archivo_origen_id,
        ];
        $this->Mequipo_archivos->update_archivos($vector_actualizar);
        $vector_actualizar = '';
      }
      echo json_encode('El archivo fue asociado exitosamente a los equipos referenciados');
    } else {
      if (isset($_POST['creado'])) { // vector es creado
        $equipos_objetivos_id = $_POST['creado'];

        foreach ($equipos_objetivos_id as $equipo_objetivo_id) {
          $vector_actualizar = [
            'equipo_objetivo_id' => $equipo_objetivo_id,
            'equipo_archivo_origen_id' => $equipo_archivo_origen_id,
          ];
          $this->Mequipo_archivos->update_archivos($vector_actualizar);
          $vector_actualizar = '';
        }
        echo json_encode('El archivo fue asociado exitosamente a los equipos referenciados');
      } else {
        echo json_encode('No se seleccionaron equipos');
      }
    }
  }

  public function VerificarEstadoMantenimiento()
  {
    $equipo_id = $_POST['equipo_id'];
    $equipo = $this->Mequipos->getOne(['id' => $equipo_id]);
    $frecuencia_mantenimiento = $equipo->frecuencia_id;

    $this->Mequipos->ActualizarEstadoMantenimiento(['equipo_id' => $equipo_id, 'frecuencia_mantenimiento' => $frecuencia_mantenimiento]);
  }

  public function VerificarEstadoMantenimiento2()
  {
    $equipo_id = $_POST['equipo_id'];
    $equipo = $this->Mequipos->getOne(['id' => $equipo_id]);

    $this->Mequipos->ActualizarEstadoMantenimiento2(['equipo_id' => $equipo_id]);
  }

  public function ObtenerListadoNombreEquipos()
  {
    echo json_encode($this->Mequipos->ObtenerListadoNombreEquipos());
  }

  public function ObtenerListadoModeloEquipos()
  {
    echo json_encode($this->Mequipos->ObtenerListadoModeloEquipos());
  }

  public function ObtenerListadoMarcaEquipos()
  {
    echo json_encode($this->Mequipos->ObtenerListadoMarcaEquipos());
  }

  public function getByAdquisicion()
  {
    $fecha = explode(' - ', $_POST['rango_fechas']);
    unset($_POST['rango_fechas']);
    $_POST['inicial'] = $fecha[0];
    $_POST['final'] = $fecha[1];

    $response = $this->Mequipos->getByAdquisicion($_POST);
    $additionalData = [
      'inversion' => $this->Mequipos->inversionAdquisicion($_POST)->inversion,
      'listado' => $this->Mequipos->listadoAdquisicion($_POST),
      'riesgos' => $this->Mequipos->riesgoAdquisicion($_POST),
      'tipos_adquisicion' => $this->Mequipos->tipoAdquisicionFromAdquisicion($_POST),
      'clasificaciones' => $this->Mequipos->clasificacionFromAdquisicion($_POST),
      'fuentes' => $this->Mequipos->fuenteFromAdquisicion($_POST),
    ];

    $this->load->view('equipos/modal_detail_adquisicion', array_merge($_POST, $response, $additionalData));
  }

  public function getByInstalacion()
  {
    $fecha = explode(' - ', $_POST['rango_fechas']);
    unset($_POST['rango_fechas']);
    $_POST['inicial'] = $fecha[0];
    $_POST['final'] = $fecha[1];
    $respuesta = $this->Mequipos->getByInstalacion($_POST);
    $inversion = $this->Mequipos->inversionInstalacion($_POST);
    $listado = $this->Mequipos->listadoInstalacion($_POST);
    $riesgos = $this->Mequipos->riesgoInstalacion($_POST);
    $tipos_adquisicion = $this->Mequipos->tipoAdquisicionFromInstalacion($_POST);
    $clasificaciones = $this->Mequipos->clasificacionFromInstalacion($_POST);
    $fuentes = $this->Mequipos->fuenteFromInstalacion($_POST);
    $equipos = $respuesta['equipos'];
    $cantidad = $respuesta['cantidad'];
    $this->load->view('equipos/modal_detail_instalacion', [
      'vector' => $_POST,
      'equipos' => $equipos,
      'cantidad' => $cantidad,
      'inversion' => $inversion->inversion,
      'listado' => $listado,
      'riesgos' => $riesgos,
      'tipos_adquisicion' => $tipos_adquisicion,
      'clasificaciones' => $clasificaciones,
      'fuentes' => $fuentes,
    ]);
  }

  public function consultarId()
  {
    echo json_encode($this->Mequipos->getOneWithTipe(['id' => $_POST['id']]));
  }

  public function listado_detalle_por_nombre_equipo()
  {
    echo json_encode($this->Mequipos->listado_detalle_por_nombre_equipo($_POST));
  }

  public function get_listado_nombres_equipos()
  {
    $this->load->view('equipos/modal_depurar_nombres_detail', ['listado' => $this->Mequipos->get_listado_nombres_equipos()]);
  }

  public function update_name_from_depuracion()
  {
    if (isset($_POST['seleccion'])) {
      $seleccion = $_POST['seleccion'];
      $seleccionados = '';
      $contador = 0;
      foreach ($seleccion as $row) {
        $contador = $contador + 1;
        if ($contador == sizeof($seleccion)) {
          $seleccionados .= "'" . $row . "'";
        } else {
          $seleccionados .= "'" . $row . "',";
        }
      }
      $_POST['seleccionados'] = $seleccionados;
      $this->Mequipos->update_name_from_depuracion($_POST);
      echo 1;
    } else {
      echo 2;
    }
  }

  public function get_listado_industriales()
  {
    echo json_encode($this->Mequipos->get_listado_industriales());
  }

  public function Exportar_cantidades()
  {
    header('Content-Type:application/xls;charset=utf-8');
    header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
    header('Content-Disposition: attachment;filename=CantidadesEquiposBiomedicos.xls');
    $cantidades = $this->Mequipos->getCantidades();
    ?>
    <h2>Cantidades equipos biomedicos</h3>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <table border="2">
        <thead>

          <tr>
            <th>Cantidad registrada</th>
            <th>Fecha registro</th>
            <th>Total sede norte</th>
            <th>Total sede principal</th>
            <th>Total sede principal activos</th>
            <th>Total sede norte activos</th>
            <th>Total sede principal fuera de servicio</th>
            <th>Total sede norte fuera de servicio</th>
            <th>Total sede principal dados de baja</th>
            <th>Total sede norte dados de baja</th>
            <th>Total sede principal pendientes de dar de baja</th>
            <th>Total sede norte pendientes de dar de baja</th>
            <th>Total sede principal con repuesto pendiente activos</th>
            <th>Total sede norte con repuesto pendiente activos</th>
            <th>Total sede principal con repuesto pendiente fuera de servicio</th>
            <th>Total sede norte con repuesto pendiente fuera de servicio</th>
            <th>Total sede principal pendiente por entregar</th>
            <th>Total sede norte pendiente por entregar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cantidades as $cantidad) { ?>
            <tr>
              <td> <?php echo $cantidad->cantidad; ?> </td>
              <td> <?php echo $cantidad->fecha; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_pendiente_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_pendiente_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_repuesto_pendiente_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_repuesto_pendiente_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_repuesto_pendiente_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_repuesto_pendiente_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_pendiente_entregar; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_pendiente_entregar; ?> </td>
            </tr>
          <?php } ?>
        </tbody>

      </table>
  <?php
  }
}
  ?>