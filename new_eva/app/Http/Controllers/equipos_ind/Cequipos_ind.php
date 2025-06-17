<?php

namespace App\Http\Controllers\EquiposInd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Controlador de Equipos Industriales - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de equipos industriales:
 * - CRUD de equipos industriales
 * - Mantenimientos preventivos
 * - Correctivos generales
 * - Calibraciones
 * - Gestión de archivos y documentos
 * - Reportes y consultas especializadas
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cequipos_ind extends Controller
{
  private $permisos;

  public function __construct()
  {
    $this->permisos = null;
  }
  public function index()
  {
    if (!Session::get('login')) {
      return redirect()->route('ci.login');
    }

    Session::put('tipo_id', 2);
    Session::put('controlador', 'equipos_ind');

    $acciones = Session::get("acciones", []);
    foreach ($acciones as $accion) {
      if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "equipos") {
        if (isset($accion->leer) && $accion->leer != 1) {
          return redirect()->route('forbidden');
        }
      }
    }

    try {
      $data = [
        "permisos" => $this->permisos,
        "garantia_casi_vencida" => $this->getGarantiaCasiVencida(),
        "garantia_vencida" => $this->getGarantiaVencida(),
        "equipos_baja" => $this->getEquiposBaja(),
        "equipos_pendientes_baja" => $this->getEquiposPendientesBaja(),
        "acciones" => $acciones
      ];

      $this->updateEstadoAutomatico();

      return view('equipos_industriales.list', $data)
        ->with('modals', [
          'modal_add' => view('equipos.modal_add', ["tipo_id" => 2])->render(),
          'modal_edit' => view('equipos.modal_edit', ["tipo_id" => 2])->render(),
          'modal_copy' => view('equipos.modal_copy', ["tipo_id" => 2])->render(),
          'modal_show_adquisicion' => view('equipos.modal_show_adquisicion')->render(),
          'modal_show_instalacion' => view('equipos.modal_show_instalacion')->render(),
          'modal_show' => view('equipos.modal_show', ["tipo_id" => 2])->render(),
          'modal_add_repuesto' => view('equipos.modal_add_repuesto')->render(),
          'modal_edit_equipo_repuesto' => view('equipos.modal_edit_equipo_repuesto')->render(),
          'modal_add_equipo_especificacion' => view('equipos.modal_add_equipo_especificacion')->render(),
          'modal_add_equipo_contacto' => view('equipos.modal_add_equipo_contacto')->render(),
          'modal_filter' => view('equipos.modal_filter')->render(),
          'modal_show_file' => view('equipos.modal_show_file')->render(),
          'modal_show_archivos' => view('equipos.modal_show_archivos')->render(),
          'modal_add_archivos' => view('equipos.modal_add_archivos')->render(),
          'modal_compartir' => view('archivos.modal_compartir')->render(),
          'modal_add_observacion' => view('equipos.modal_add_observacion')->render(),
          'modal_edit_observacion' => view('equipos.modal_edit_observacion')->render(),
          'modal_show_garantiaCasiVencida' => view('equipos.modal_show_garantiaCasiVencida')->render(),
          'modal_show_garantiaVencida' => view('equipos.modal_show_garantiaVencida')->render(),
          'modal_multiple' => view('equipos.modal_multiple')->render(),
          'modal_obsoletos' => view('equipos.modal_obsoletos')->render(),
          'modal_add_archivo_correctivo' => view('equipos.modal_add_archivo_correctivo')->render(),
          'modal_add_servicios' => view('servicios.modal_add')->render(),
          'modal_correctivos_add' => view('correctivos_generales.modal_add')->render(),
          'modal_correctivos_edit' => view('correctivos_generales.modal_edit')->render(),
          'modal_correctivos_show' => view('correctivos_generales.modal_show')->render(),
          'modal_correctivos_show_single' => view('correctivos_generales.modal_show_single')->render(),
          'modal_avances_correctivos_add' => view('avances_correctivos.modal_add')->render(),
          'modal_preventivos_add' => view('preventivos.modal_add')->render(),
          'modal_preventivos_edit' => view('preventivos.modal_edit')->render(),
          'modal_preventivos_show' => view('preventivos.modal_show')->render(),
          'modal_calibraciones_add' => view('calibraciones.modal_add')->render(),
          'modal_calibraciones_edit' => view('calibraciones.modal_edit')->render(),
          'modal_calibraciones_show' => view('calibraciones.modal_show')->render(),
          'modal_invimas_add' => view('invimas.modal_add')->render(),
          'modal_invimas_consulta' => view('invimas.modal_consulta')->render(),
          'modal_ordenes_compra_consulta' => view('ordenes_compra.modal_consulta')->render(),
          'modal_ordenes_compra_add' => view('ordenes_compra.modal_add')->render(),
          'modal_bajas_add' => view('bajas.modal_add')->render(),
          'modal_bajas_consulta' => view('bajas.modal_consulta')->render(),
          'modal_contingencias_add' => view('contingencias.modal_add')->render(),
          'modal_guias_consulta' => view('guias.modal_consulta')->render(),
          'modal_manuales_consulta' => view('manuales.modal_consulta')->render(),
          'modal_areas_add' => view('areas.modal_add')->render(),
          'modal_compartir_especificaciones' => view('equipos.modal_compartir_especificaciones')->render(),
          'modal_cambios_ubicaciones_show' => view('cambios_ubicaciones.modal_show')->render(),
          'modal_ordenes_timeline' => view('ordenes.modal_timeline')->render(),
          'modal_historial_show' => view('equipos.historial.modal_show')->render(),
          'modal_propietarios_add' => view('propietarios.modal_add')->render()
        ]);
    } catch (\Exception $e) {
      return redirect()->route('home')->with('error', 'Error al cargar equipos industriales: ' . $e->getMessage());
    }
  }

  public function getEquipo(Request $request)
  {
    try {
      $start  = $request->input('start', 0);
      $length = $request->input('length', 10);
      $search = $request->input('search.value', '');
      $draw   = $request->input('draw', 1);

      $result = $this->getEquipoData($start, $length, $search);

      if ($result) {
        $resultado = $result['datos'];
        $totalDatos = $result['numDataTotal'];

        $datos = [];
        foreach ($resultado as $row) {
          $datos[] = [
            'rownum' => $row->rownum ?? $row['rownum'],
            'imagen' => $row->imagen ?? $row['imagen'],
            'nombre' => $row->nombre ?? $row['nombre'],
            'marca' => $row->marca ?? $row['marca'],
            'serial' => $row->serial ?? $row['serial'],
            'modelo' => $row->modelo ?? $row['modelo'],
            'codigo_inventario' => $row->codigo_inventario ?? $row['codigo_inventario'],
            'name' => $row->name ?? $row['name'],
            'namem' => $row->namem ?? $row['namem'],
            'piso' => $row->piso ?? $row['piso'],
            'archivo' => $row->archivo ?? $row['archivo'],
            'tension' => $row->tension ?? $row['tension'],
            'corriente' => $row->corriente ?? $row['corriente'],
            'potencia' => $row->potencia ?? $row['potencia'],
            'temperatura' => $row->temperatura ?? $row['temperatura'],
            'estado' => $row->estado ?? $row['estado'],
            'fecha_mantenimiento' => $row->fecha_mantenimiento ?? $row['fecha_mantenimiento']
          ];
        }

        $json_data = [
          "draw" => intval($draw),
          "recordsTotal" => count($datos),
          "recordsFiltered" => intval($totalDatos),
          "data" => $datos
        ];

        return response()->json($json_data);
      } else {
        return response()->json([
          "draw" => intval($draw),
          "recordsTotal" => 0,
          "recordsFiltered" => 0,
          "data" => [],
          "error" => "No se pudo realizar la consulta"
        ]);
      }
    } catch (\Exception $e) {
      return response()->json([
        "draw" => intval($request->input('draw', 1)),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => "Error del sistema: " . $e->getMessage()
      ]);
    }
  }

  public function add(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nombre' => 'required|string|max:255',
      'marca' => 'required|string|max:255',
      'serial' => 'required|string|max:255',
      'modelo' => 'required|string|max:255',
      'codigo_inventario' => 'required|string|max:255',
      'servicio_id' => 'required|integer',
      'periodicidad_id' => 'required|integer',
      'imagen' => 'nullable|image|mimes:gif,jpg,jpeg,png,jfif|max:4048',
      'archivo' => 'nullable|file|mimes:pdf,xlsx,docx|max:20048'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->errors()->first()
      ], 422);
    }

    try {
      $data = $request->all();

      if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $imagenName = time() . '_' . Str::random(10) . '.' . $imagen->getClientOriginalExtension();

        $imagePath = public_path('style/imagenes');
        if (!File::exists($imagePath)) {
          File::makeDirectory($imagePath, 0755, true);
        }

        $imagen->move($imagePath, $imagenName);
        $data['imagen'] = $imagenName;
      }

      if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $archivoName = time() . '_' . Str::random(10) . '.' . $archivo->getClientOriginalExtension();

        $archivoPath = public_path('style/archivos/HV');
        if (!File::exists($archivoPath)) {
          File::makeDirectory($archivoPath, 0755, true);
        }

        $archivo->move($archivoPath, $archivoName);
        $data['archivo'] = $archivoName;
      }

      $data['created_at'] = Carbon::now();
      $result = $this->addEquipo($data);

      if ($result) {
        return response()->json([
          'success' => true,
          'message' => 'Equipo industrial creado exitosamente'
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Error al guardar el equipo'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function upd(Request $request)
  {
    try {
      $data = $request->input('rownum');
      $actual = $this->getActualEquipo($data);

      if ($actual) {
        return response()->json($actual);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'No se encontró el equipo'
        ], 404);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getOne(Request $request)
  {
    try {
      $result = $this->getOneEquipo($request->all());
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getLikeSerie(Request $request)
  {
    try {
      $equipos = $this->getEquiposLikeSerie($request->all());
      return response()->json($equipos);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getLikeCodigo(Request $request)
  {
    try {
      $equipos = $this->getEquiposLikeCodigo($request->all());
      return response()->json($equipos);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }
  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id_equipos' => 'required|integer',
      'nombre' => 'required|string|max:255',
      'marca' => 'required|string|max:255',
      'serial' => 'required|string|max:255',
      'modelo' => 'required|string|max:255',
      'codigo_inventario' => 'required|string|max:255',
      'imagen' => 'nullable|image|mimes:gif,jpg,jpeg,png,jfif|max:4048',
      'archivo' => 'nullable|file|mimes:pdf,xlsx,docx|max:40048'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->errors()->first()
      ], 422);
    }

    try {
      $data = $request->all();
      $valor = $request->input('id_equipos');

      if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $imagenName = time() . '_' . Str::random(10) . '.' . $imagen->getClientOriginalExtension();

        $imagePath = public_path('style/imagenes');
        if (!File::exists($imagePath)) {
          File::makeDirectory($imagePath, 0755, true);
        }

        $imagen->move($imagePath, $imagenName);
        $data['imagen'] = $imagenName;
      }

      if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $archivoName = time() . '_' . Str::random(10) . '.' . $archivo->getClientOriginalExtension();

        $archivoPath = public_path('style/archivos/HV');
        if (!File::exists($archivoPath)) {
          File::makeDirectory($archivoPath, 0755, true);
        }

        $archivo->move($archivoPath, $archivoName);
        $data['archivo'] = $archivoName;
      }

      $updateData = [
        "nombre" => $data['nombre'],
        "marca" => $data['marca'],
        "serial" => $data['serial'],
        "modelo" => $data['modelo'],
        "codigo_inventario" => $data['codigo_inventario'],
        "tension" => $data['Tension'] ?? null,
        "corriente" => $data['Corriente'] ?? null,
        "potencia" => $data['Potencia'] ?? null,
        "temperatura" => $data['Temperatura'] ?? null,
        "servicio_id" => $data['servicio_id'] ?? null,
        "periodicidad_id" => $data['periodicidad_id'] ?? null,
        "piso_id" => $data['piso_id'] ?? null,
        "fecha_mantenimiento" => $data['fecha_mantenimiento'] ?? null,
        "updated_at" => Carbon::now()
      ];

      if (isset($data['imagen'])) {
        $updateData['imagen'] = $data['imagen'];
      }

      if (isset($data['archivo'])) {
        $updateData['archivo'] = $data['archivo'];
      }

      $result = $this->updateEquipo($updateData, $valor);

      if ($result !== false) {
        return response()->json([
          'success' => true,
          'type' => 'upd',
          'message' => 'Equipo actualizado exitosamente'
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Error al actualizar el equipo'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function borrar(Request $request)
  {
    try {
      $data = $request->input('rownum');
      $actual = $this->borrarEquipo($data);

      if ($actual) {
        return response()->json([
          'success' => true,
          'type' => 'delete',
          'message' => 'Equipo eliminado exitosamente'
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Error al eliminar el equipo'
        ], 500);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getServicios(Request $request)
  {
    try {
      $s = $request->input('q', '');
      $result = $this->getServiciosData($s);
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getMantenimiento(Request $request)
  {
    try {
      $s = $request->input('r', '');
      $result = $this->getMantenimientoData($s);
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getPiso(Request $request)
  {
    try {
      $s = $request->input('m', '');
      $result = $this->getPisoData($s);
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function downloads($filename)
  {
    try {
      $filePath = public_path('style/archivos/HV/' . $filename);

      if (file_exists($filePath)) {
        return response()->download($filePath);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Archivo no encontrado'
        ], 404);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  /*CRUD PREVENTIVO*/
  public function addPreventivo(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'equipo_id' => 'required|integer',
        'fecha_mantenimiento' => 'required|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_preventivos');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      $data['created_at'] = Carbon::now();
      $this->addPreventivoData($data);

      return response()->json([
        'success' => true,
        'equipo_id' => $request->input('equipo_id'),
        'message' => 'Preventivo agregado exitosamente'
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al agregar preventivo: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getPreventivos(Request $request)
  {
    try {
      $result = $this->getPreventivosByEquipo($request->all());

      if ($result != null) {
        return response()->json($result);
      } else {
        return response()->json([]);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getOnePreventivo(Request $request)
  {
    try {
      $result = $this->getOnePreventivoData($request->all());
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }
  public function updatePreventivo(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'equipo_id' => 'required|integer',
        'fecha_mantenimiento' => 'required|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();
      $preventivo = $this->getOnePreventivoData($data);
      $file_anterior = $preventivo->file ?? null;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_preventivos');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      $data['updated_at'] = Carbon::now();

      if ($this->updatePreventivoData($data)) {
        if (isset($data['file']) && $data['file'] != $file_anterior && $file_anterior) {
          $oldFilePath = public_path('assets/upload_preventivos/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json([
          'success' => true,
          'equipo_id' => $request->input('equipo_id'),
          'message' => 'Preventivo actualizado exitosamente'
        ]);
      } else {
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_preventivos/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json([
          'success' => false,
          'message' => 'Error al actualizar preventivo'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function deletePreventivo(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => 'required|integer'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $vector = ["id" => $request->input("id")];
      $preventivo = $this->getOnePreventivoData($vector);
      $file = $preventivo->file ?? null;

      if ($this->deletePreventivoData($request->all())) {
        if ($file && $file != "") {
          $filePath = public_path('assets/upload_preventivos/' . $file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
        return response()->json([
          'success' => true,
          'message' => 'Preventivo eliminado exitosamente'
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Error al eliminar preventivo'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getLastPreventivo(Request $request)
  {
    try {
      $result = $this->getLastPreventivoData($request->all());
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  /*CRUD CORRECTIVOS GENERALES*/

  public function getCorrectivos(Request $request)
  {
    try {
      $result = $this->getCorrectivosData($request->all());

      if ($result != null) {
        return response()->json($result);
      } else {
        return response()->json([]);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function addCorrectivoGeneral(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'equipo_id' => 'required|integer',
        'fecha_mantenimiento' => 'required|date',
        'titulo' => 'required|string|max:255',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();
      $titulo = $request->input('titulo');

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_correctivos_generales');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      unset($data['titulo']);
      $data['created_at'] = Carbon::now();

      $ultimo_id = $this->addCorrectivoGeneralData($data);

      if (isset($data['file'])) {
        $vector = [
          "file" => $data['file'],
          "correctivo_general_id" => $ultimo_id,
          "titulo" => $titulo,
          "created_at" => Carbon::now()
        ];

        $this->addArchivoCorrectivoGeneralData($vector);
      }

      return response()->json([
        'success' => true,
        'equipo_id' => $request->input('equipo_id'),
        'message' => 'Correctivo general agregado exitosamente'
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al agregar correctivo: ' . $e->getMessage()
      ], 500);
    }
  }

  public function add_archivo_correctivo_general(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'correctivo_general_id' => 'required|integer',
        'titulo' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_correctivos_generales');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;

        unset($data['equipo_id']);
        $data['created_at'] = Carbon::now();

        $this->addArchivoCorrectivoGeneralData($data);

        return response()->json([
          'success' => true,
          'message' => 'Archivo agregado exitosamente'
        ]);
      }

      return response()->json([
        'success' => false,
        'message' => 'No se subió ningún archivo'
      ], 422);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al subir archivo: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getCorrectivosGenerales(Request $request)
  {
    try {
      $result = $this->getCorrectivosGeneralesData($request->all());

      if ($result != null) {
        return response()->json($result);
      } else {
        return response()->json([]);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getArchivosCorrectivosGenerales(Request $request)
  {
    try {
      $result = $this->getArchivosCorrectivosGeneralesData($request->all());
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getOneCorrectivoGeneral(Request $request)
  {
    try {
      $result = $this->getOneCorrectivoGeneralData($request->all());
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }
  public function updateCorrectivoGeneral(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'equipo_id' => 'required|integer',
        'fecha_mantenimiento' => 'required|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();
      $correctivo = $this->getOneCorrectivoGeneralData($data);
      $file_anterior = $correctivo->file ?? null;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_correctivos_generales');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      $data['updated_at'] = Carbon::now();

      if ($this->updateCorrectivoGeneralData($data)) {
        if (isset($data['file']) && $data['file'] != $file_anterior && $file_anterior) {
          $oldFilePath = public_path('assets/upload_correctivos_generales/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json([
          'success' => true,
          'equipo_id' => $request->input('equipo_id'),
          'message' => 'Correctivo general actualizado exitosamente'
        ]);
      } else {
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_correctivos_generales/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json([
          'success' => false,
          'message' => 'Error al actualizar correctivo'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function deleteCorrectivoGeneral(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => 'required|integer'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $resultados = $this->getAllArchivosCorrectivosGeneralesData($request->all());

      foreach ($resultados as $resultado) {
        if ($this->deleteArchivoCorrectivoGeneralData($resultado->id)) {
          $filePath = public_path('assets/upload_correctivos_generales/' . $resultado->file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
      }

      $this->deleteCorrectivoGeneralData($request->all());

      return response()->json([
        'success' => true,
        'message' => 'Correctivo general eliminado exitosamente'
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  /*CRUD CALIBRACION*/
  public function addCalibracion(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'equipo_id' => 'required|integer',
        'fecha_calibracion' => 'required|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_calibraciones');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      $data['created_at'] = Carbon::now();
      $this->addCalibracionData($data);

      return response()->json([
        'success' => true,
        'equipo_id' => $request->input('equipo_id'),
        'message' => 'Calibración agregada exitosamente'
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error al agregar calibración: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getCalibraciones(Request $request)
  {
    try {
      $result = $this->getCalibracionesByEquipo($request->all());

      if ($result != null) {
        return response()->json($result);
      } else {
        return response()->json([]);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function getOneCalibracion(Request $request)
  {
    try {
      $result = $this->getOneCalibracionData($request->all());
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function updateCalibracion(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'equipo_id' => 'required|integer',
        'fecha_calibracion' => 'required|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $data = $request->all();
      $calibracion = $this->getOneCalibracionData($data);
      $file_anterior = $calibracion->file ?? null;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_calibraciones');
        if (!File::exists($uploadPath)) {
          File::makeDirectory($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      $data['updated_at'] = Carbon::now();

      if ($this->updateCalibracionData($data)) {
        if (isset($data['file']) && $data['file'] != $file_anterior && $file_anterior) {
          $oldFilePath = public_path('assets/upload_calibraciones/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json([
          'success' => true,
          'equipo_id' => $request->input('equipo_id'),
          'message' => 'Calibración actualizada exitosamente'
        ]);
      } else {
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_calibraciones/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json([
          'success' => false,
          'message' => 'Error al actualizar calibración'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  public function deleteCalibracion(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id' => 'required|integer'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'success' => false,
          'message' => $validator->errors()->first()
        ], 422);
      }

      $vector = ["id" => $request->input("id")];
      $calibracion = $this->getOneCalibracionData($vector);
      $file = $calibracion->file ?? null;

      if ($this->deleteCalibracionData($request->all())) {
        if ($file && $file != "") {
          $filePath = public_path('assets/upload_calibraciones/' . $file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
        return response()->json([
          'success' => true,
          'message' => 'Calibración eliminada exitosamente'
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Error al eliminar calibración'
        ], 500);
      }

    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error del sistema: ' . $e->getMessage()
      ], 500);
    }
  }

  // Private methods for database operations (replacing model calls)
  private function getGarantiaCasiVencida()
  {
    return DB::select("
      SELECT e.*
      FROM equipos e
      WHERE e.tipo_id = 2
      AND e.fecha_vencimiento_garantia BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
      AND e.estadoequipo_id NOT IN (6, 9, 14)
    ");
  }

  private function getGarantiaVencida()
  {
    return DB::select("
      SELECT e.*
      FROM equipos e
      WHERE e.tipo_id = 2
      AND e.fecha_vencimiento_garantia < CURDATE()
      AND e.estadoequipo_id NOT IN (6, 9, 14)
    ");
  }

  private function getEquiposBaja()
  {
    return DB::select("
      SELECT e.*
      FROM equipos e
      WHERE e.tipo_id = 2
      AND e.estadoequipo_id = 6
    ");
  }

  private function getEquiposPendientesBaja()
  {
    return DB::select("
      SELECT e.*
      FROM equipos e
      WHERE e.tipo_id = 2
      AND e.estadoequipo_id = 14
    ");
  }

  private function updateEstadoAutomatico()
  {
    // Update equipment status automatically based on business rules
    DB::statement("
      UPDATE equipos_industriales
      SET estado = CASE
        WHEN fecha_mantenimiento < DATE_SUB(NOW(), INTERVAL 1 YEAR) THEN 2
        ELSE estado
      END
      WHERE estado = 1
    ");
  }

  private function getEquipoData($start, $length, $search)
  {
    $query = "
      SELECT
        id_equipos as rownum,
        imagen,
        nombre,
        marca,
        serial,
        modelo,
        codigo_inventario,
        si.name,
        fm.name as namem,
        p.name as piso,
        archivo,
        tension,
        corriente,
        potencia,
        temperatura,
        estado,
        fecha_mantenimiento
      FROM equipos_industriales ei
      INNER JOIN servicios_industriales si ON ei.servicio_id = si.id
      INNER JOIN frecuenciam fm ON ei.periodicidad_id = fm.id
      LEFT JOIN pisos p ON ei.piso_id = p.id
    ";

    if (!empty($search)) {
      $query .= " WHERE (ei.nombre LIKE '%{$search}%' OR ei.marca LIKE '%{$search}%' OR ei.serial LIKE '%{$search}%')";
    }

    $query .= " ORDER BY ei.nombre ASC";

    // Get total count
    $totalQuery = str_replace("SELECT id_equipos as rownum,imagen,nombre,marca,serial,modelo,codigo_inventario,si.name,fm.name as namem,p.name as piso,archivo,tension,corriente,potencia,temperatura,estado,fecha_mantenimiento", "SELECT COUNT(*) as total", $query);
    $totalResult = DB::select($totalQuery);
    $total = $totalResult[0]->total ?? 0;

    // Add limit
    $query .= " LIMIT {$start}, {$length}";
    $datos = DB::select($query);

    return [
      'datos' => $datos,
      'numDataTotal' => $total
    ];
  }

  private function addEquipo($data)
  {
    return DB::table('equipos_industriales')->insert($data);
  }

  private function getActualEquipo($id)
  {
    return DB::selectOne("
      SELECT
        id_equipos,
        imagen,
        nombre,
        marca,
        serial,
        modelo,
        codigo_inventario,
        ei.servicio_id,
        ei.periodicidad_id,
        ei.piso_id as id_piso,
        si.name,
        fm.name as namem,
        p.name as piso,
        archivo,
        tension,
        corriente,
        potencia,
        temperatura,
        estado,
        fecha_mantenimiento
      FROM equipos_industriales ei
      INNER JOIN servicios_industriales si ON ei.servicio_id = si.id
      INNER JOIN frecuenciam fm ON ei.periodicidad_id = fm.id
      INNER JOIN pisos p ON ei.piso_id = p.id
      WHERE id_equipos = ?
    ", [$id]);
  }

  private function getOneEquipo($data)
  {
    return DB::selectOne("
      SELECT
        id_equipos,
        imagen,
        nombre,
        marca,
        serial,
        modelo,
        codigo_inventario,
        ei.servicio_id,
        ei.periodicidad_id,
        ei.piso_id,
        si.name,
        fm.name as namem,
        p.name as piso,
        archivo,
        tension,
        corriente,
        potencia,
        temperatura,
        estado,
        fecha_mantenimiento
      FROM equipos_industriales ei
      INNER JOIN servicios_industriales si ON ei.servicio_id = si.id
      INNER JOIN frecuenciam fm ON ei.periodicidad_id = fm.id
      INNER JOIN pisos p ON ei.piso_id = p.id
      WHERE id_equipos = ?
    ", [$data['id']]);
  }

  private function updateEquipo($data, $id)
  {
    return DB::table('equipos_industriales')
      ->where('id_equipos', $id)
      ->update($data);
  }

  private function borrarEquipo($id)
  {
    $estado = DB::selectOne("SELECT estado FROM equipos_industriales WHERE id_equipos = ?", [$id]);

    if ($estado && $estado->estado == "1") {
      DB::update("UPDATE equipos_industriales SET estado = '2' WHERE id_equipos = ?", [$id]);
      return true;
    } else {
      DB::update("UPDATE equipos_industriales SET estado = '1' WHERE id_equipos = ?", [$id]);
      return true;
    }
  }

  private function getEquiposLikeSerie($data)
  {
    return DB::select("
      SELECT * FROM equipos_industriales
      WHERE serial LIKE ?
      ORDER BY serial ASC
    ", ['%' . $data['serie'] . '%']);
  }

  private function getEquiposLikeCodigo($data)
  {
    return DB::select("
      SELECT * FROM equipos_industriales
      WHERE codigo_inventario LIKE ?
      ORDER BY codigo_inventario ASC
    ", ['%' . $data['codigo'] . '%']);
  }

  private function getServiciosData($search)
  {
    return DB::select("
      SELECT id, name as text
      FROM servicios_industriales
      WHERE name LIKE ?
      ORDER BY name ASC
    ", ['%' . $search . '%']);
  }

  private function getMantenimientoData($search)
  {
    return DB::select("
      SELECT id, name as text
      FROM frecuenciam
      WHERE name LIKE ?
      ORDER BY name ASC
    ", ['%' . $search . '%']);
  }

  private function getPisoData($search)
  {
    return DB::select("
      SELECT id, name as text
      FROM pisos
      WHERE name LIKE ?
      ORDER BY name ASC
    ", ['%' . $search . '%']);
  }

  // Preventivos methods
  private function addPreventivoData($data)
  {
    return DB::table('mantenimiento_ind')->insert($data);
  }

  private function getPreventivosByEquipo($data)
  {
    return DB::table('mantenimiento_ind')
      ->where('equipo_id', $data['equipo_id'])
      ->orderBy('fecha_mantenimiento')
      ->get();
  }

  private function getOnePreventivoData($data)
  {
    return DB::table('mantenimiento_ind')
      ->where('id', $data['id'])
      ->first();
  }

  private function updatePreventivoData($data)
  {
    $id = $data['id'];
    unset($data['id']);
    return DB::table('mantenimiento_ind')
      ->where('id', $id)
      ->update($data);
  }

  private function deletePreventivoData($data)
  {
    return DB::table('mantenimiento_ind')
      ->where('id', $data['id'])
      ->delete();
  }

  private function getLastPreventivoData($data)
  {
    return DB::table('mantenimiento_ind')
      ->select('fecha_mantenimiento', 'file')
      ->where('equipo_id', $data['equipo_id'])
      ->orderBy('fecha_mantenimiento', 'desc')
      ->first();
  }

  // Correctivos methods
  private function getCorrectivosData($data)
  {
    return DB::table('ordenes')
      ->leftJoin('estados', 'ordenes.estado_id', '=', 'estados.id')
      ->select('ordenes.*', 'estados.descripcion as estado')
      ->where('ordenes.equipo_id', $data['equipo_id'])
      ->get();
  }

  private function addCorrectivoGeneralData($data)
  {
    return DB::table('correctivos_generales_ind')->insertGetId($data);
  }

  private function addArchivoCorrectivoGeneralData($data)
  {
    return DB::table('correctivos_generales_archivos_ind')->insert($data);
  }

  private function getCorrectivosGeneralesData($data)
  {
    return DB::table('correctivos_generales_ind')
      ->where('equipo_id', $data['equipo_id'])
      ->orderBy('fecha_mantenimiento', 'asc')
      ->get();
  }

  private function getArchivosCorrectivosGeneralesData($data)
  {
    return DB::table('correctivos_generales_archivos_ind')
      ->where('correctivo_general_id', $data['correctivo_general_id'])
      ->get();
  }

  private function getOneCorrectivoGeneralData($data)
  {
    return DB::table('correctivos_generales_ind')
      ->where('id', $data['id'])
      ->first();
  }

  private function updateCorrectivoGeneralData($data)
  {
    $id = $data['id'];
    unset($data['id']);
    return DB::table('correctivos_generales_ind')
      ->where('id', $id)
      ->update($data);
  }

  private function deleteCorrectivoGeneralData($data)
  {
    return DB::table('correctivos_generales_ind')
      ->where('id', $data['id'])
      ->delete();
  }

  private function getAllArchivosCorrectivosGeneralesData($data)
  {
    return DB::table('correctivos_generales_archivos_ind')
      ->where('correctivo_general_id', $data['id'])
      ->get();
  }

  private function deleteArchivoCorrectivoGeneralData($id)
  {
    return DB::table('correctivos_generales_archivos_ind')
      ->where('id', $id)
      ->delete();
  }

  // Calibraciones methods
  private function addCalibracionData($data)
  {
    return DB::table('calibracion_ind')->insert($data);
  }

  private function getCalibracionesByEquipo($data)
  {
    return DB::table('calibracion_ind')
      ->where('equipo_id', $data['equipo_id'])
      ->orderBy('fecha_calibracion')
      ->get();
  }

  private function getOneCalibracionData($data)
  {
    return DB::table('calibracion_ind')
      ->where('id', $data['id'])
      ->first();
  }

  private function updateCalibracionData($data)
  {
    $id = $data['id'];
    unset($data['id']);
    return DB::table('calibracion_ind')
      ->where('id', $id)
      ->update($data);
  }

  private function deleteCalibracionData($data)
  {
    return DB::table('calibracion_ind')
      ->where('id', $data['id'])
      ->delete();
  }
}
