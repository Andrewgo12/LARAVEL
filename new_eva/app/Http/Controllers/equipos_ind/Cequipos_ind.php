<?php

namespace App\Http\Controllers\EquiposInd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Mequipos_ind;
use App\Models\Mequipos;
use App\Models\Mpreventivos;
use App\Models\Mcalibraciones;
use App\Models\Mcorrectivos_generales;
use App\Models\Mcorrectivos_generales_archivos;
use App\Models\Mordenes;

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
      return redirect()->route('huv.login');
    }

    Session::put('tipo_id', 2);
    Session::put('controlador', 'equipos_ind');

    $acciones = Session::get("acciones", []);
    foreach ($acciones as $accion) {
      if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "equipos") {
        if (isset($accion->leer) && $accion->leer != 1) {
          return redirect()->route('huv.forbidden');
        }
      }
    }

    $mequipos = new Mequipos();
    $data = [
      "permisos" => $this->permisos,
      "garantia_casi_vencida" => $mequipos->garantia_casi_vencida(),
      "garantia_vencida" => $mequipos->garantia_vencida(),
      "equipos_baja" => $mequipos->equipos_baja(),
      "equipos_pendientes_baja" => $mequipos->equipos_pendientes_baja(),
      "acciones" => $acciones
    ];
    $mequipos->updateEstadomAutomatico();

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
  }

  public function getEquipo(Request $request)
  {
    $start  = $request->input('start', 0);
    $length = $request->input('length', 10);
    $search = $request->input('search.value', '');
    $draw   = $request->input('draw', 1);

    $mequipos_ind = new Mequipos_ind();
    $result = $mequipos_ind->getEquipo($start, $length, $search);

    if ($result) {
      $resultado = $result['datos'];
      $totalDatos = $result['numDataTotal'];

      $datos = [];

      if (method_exists($resultado, 'result_array')) {
        $rows = $resultado->result_array();
      } else {
        $rows = $resultado;
      }

      foreach ($rows as $row) {
        $array = [
          'rownum' => $row['rownum'],
          'imagen' => $row['imagen'],
          'nombre' => $row['nombre'],
          'marca' => $row['marca'],
          'serial' => $row['serial'],
          'modelo' => $row['modelo'],
          'codigo_inventario' => $row['codigo_inventario'],
          'name' => $row['name'],
          'namem' => $row['namem'],
          'piso' => $row['piso'],
          'archivo' => $row['archivo'],
          'tension' => $row['tension'],
          'corriente' => $row['corriente'],
          'potencia' => $row['potencia'],
          'temperatura' => $row['temperatura'],
          'estado' => $row['estado'],
          'fecha_mantenimiento' => $row['fecha_mantenimiento']
        ];
        $datos[] = $array;
      }

      $totalDatoObtenido = method_exists($resultado, 'num_rows') ? $resultado->num_rows() : count($datos);

      $json_data = [
        "draw" => intval($draw),
        "recordsTotal" => intval($totalDatoObtenido),
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
      return response()->json(['error' => $validator->errors()->first()]);
    }

    try {
      $data = $request->all();

      if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $imagenName = time() . '_' . $imagen->getClientOriginalName();
        $imagen->move(public_path('style/imagenes'), $imagenName);
        $data['imagen'] = $imagenName;
      }

      if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $archivoName = time() . '_' . $archivo->getClientOriginalName();
        $archivo->move(public_path('style/archivos/HV'), $archivoName);
        $data['archivo'] = $archivoName;
      }

      $mequipos_ind = new Mequipos_ind();
      $result = $mequipos_ind->add($data);

      if ($result) {
        return response()->json(['success' => true]);
      } else {
        return response()->json(['error' => 'Error al guardar el equipo']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  public function upd(Request $request)
  {
    $data = $request->input('rownum');

    $mequipos_ind = new Mequipos_ind();
    $actual = $mequipos_ind->actual($data);

    if ($actual) {
      return response()->json($actual);
    } else {
      return response()->json(['error' => 'No se encontró el equipo']);
    }
  }

  public function getOne(Request $request)
  {
    $mequipos_ind = new Mequipos_ind();
    $result = $mequipos_ind->getOne($request->all());
    return response()->json($result);
  }

  public function getLikeSerie(Request $request)
  {
    $mequipos_ind = new Mequipos_ind();
    $equipos = $mequipos_ind->getLikeSerie($request->all());
    return response()->json($equipos);
  }

  public function getLikeCodigo(Request $request)
  {
    $mequipos_ind = new Mequipos_ind();
    $equipos = $mequipos_ind->getLikeCodigo($request->all());
    return response()->json($equipos);
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
      return response()->json(['error' => $validator->errors()->first()]);
    }

    try {
      $data = $request->all();
      $valor = $request->input('id_equipos');

      $hasNewImage = false;
      if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $imagenName = time() . '_' . $imagen->getClientOriginalName();
        $imagen->move(public_path('style/imagenes'), $imagenName);
        $data['imagen'] = $imagenName;
        $hasNewImage = true;
      }

      $hasNewFile = false;
      if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $archivoName = time() . '_' . $archivo->getClientOriginalName();
        $archivo->move(public_path('style/archivos/HV'), $archivoName);
        $data['archivo'] = $archivoName;
        $hasNewFile = true;
      }


      $updateData = [
        "id_equipos" => $data['id_equipos'],
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
        "fecha_mantenimiento" => $data['fecha_mantenimiento'] ?? null
      ];

      if ($hasNewImage) {
        $updateData['imagen'] = $data['imagen'];
      }

      if ($hasNewFile) {
        $updateData['archivo'] = $data['archivo'];
      }

      $mequipos_ind = new Mequipos_ind();
      $result = $mequipos_ind->update($updateData, $valor);

      if ($result !== false) {
        return response()->json([
          'success' => true,
          'type' => 'upd'
        ]);
      } else {
        return response()->json(['error' => 'Error al actualizar el equipo']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  public function borrar(Request $request)
  {
    $data = $request->input('rownum');

    $mequipos_ind = new Mequipos_ind();
    $actual = $mequipos_ind->borrar($data);

    if ($actual) {
      return response()->json([
        'success' => true,
        'type' => 'delete'
      ]);
    } else {
      return response()->json(['error' => 'Error al eliminar el equipo']);
    }
  }

  public function getServicios(Request $request)
  {
    $s = $request->input('q', '');

    $mequipos_ind = new Mequipos_ind();
    $result = $mequipos_ind->getServicios($s);

    return response()->json($result);
  }

  public function getMantenimiento(Request $request)
  {
    $s = $request->input('r', '');

    $mequipos_ind = new Mequipos_ind();
    $result = $mequipos_ind->getMantenimiento($s);

    return response()->json($result);
  }

  public function getPiso(Request $request)
  {
    $s = $request->input('m', '');

    $mequipos_ind = new Mequipos_ind();
    $result = $mequipos_ind->getPiso($s);

    return response()->json($result);
  }

  public function downloads($filename)
  {
    $filePath = public_path('style/archivos/HV/' . $filename);

    if (file_exists($filePath)) {
      return response()->download($filePath);
    } else {
      return response()->json(['error' => 'Archivo no encontrado'], 404);
    }
  }

  /*CRUD PREVENTIVO*/
  public function addPreventivo(Request $request)
  {
    try {
      $data = $request->all();

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_preventivos'), $fileName);
        $data['file'] = $fileName;
      }

      $mpreventivos = new Mpreventivos();
      $result = $mpreventivos->add_ind($data);

      return response()->json($request->input('equipo_id'));

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar preventivo: ' . $e->getMessage()]);
    }
  }

  public function getPreventivos(Request $request)
  {
    $mpreventivos = new Mpreventivos();
    $result = $mpreventivos->get_ind($request->all());

    if ($result != null) {
      return response()->json($result);
    } else {
      return response()->json(2);
    }
  }

  public function getOnePreventivo(Request $request)
  {
    $mpreventivos = new Mpreventivos();
    $result = $mpreventivos->getOne_ind($request->all());

    return response()->json($result);
  }
  public function updatePreventivo(Request $request)
  {
    try {
      $data = $request->all();

      $mpreventivos = new Mpreventivos();
      $preventivo = $mpreventivos->getOne_ind($data);
      $file_anterior = $preventivo->file ?? null;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_preventivos'), $fileName);
        $data['file'] = $fileName;
      }

      if ($mpreventivos->update_ind($data)) {
        if (isset($data['file']) && $data['file'] != $file_anterior && $file_anterior) {
          $oldFilePath = public_path('assets/upload_preventivos/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json($request->input('equipo_id'));
      } else {
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_preventivos/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json(['error' => 'Error al actualizar preventivo']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  public function deletePreventivo(Request $request)
  {
    try {
      $vector = ["id" => $request->input("id")];

      $mpreventivos = new Mpreventivos();
      $preventivo = $mpreventivos->getOne_ind($vector);
      $file = $preventivo->file ?? null;

      if ($mpreventivos->delete_ind($request->all())) {
        if ($file && $file != "") {
          $filePath = public_path('assets/upload_preventivos/' . $file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
        return response()->json(['success' => true]);
      } else {
        return response()->json(['error' => 'Error al eliminar preventivo']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  public function getLastPreventivo(Request $request)
  {
    $mpreventivos = new Mpreventivos();
    $result = $mpreventivos->getLast_ind($request->all());

    return response()->json($result);
  }

  /*CRUD CORRECTIVOS GENERALES*/

  public function getCorrectivos(Request $request)
  {
    $mordenes = new Mordenes();
    $result = $mordenes->get($request->all());

    if ($result != null) {
      return response()->json($result);
    } else {
      return response()->json(2);
    }
  }

  public function addCorrectivoGeneral(Request $request)
  {
    try {
      $data = $request->all();
      $titulo = $request->input('titulo');

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_correctivos_generales'), $fileName);
        $data['file'] = $fileName;
      }

      unset($data['titulo']);

      $mcorrectivos_generales = new Mcorrectivos_generales();
      $ultimo_id = $mcorrectivos_generales->add_ind($data);

      if (isset($data['file'])) {
        $vector = [
          "file" => $data['file'],
          "correctivo_general_id" => $ultimo_id,
          "titulo" => $titulo
        ];

        $mcorrectivos_generales_archivos = new Mcorrectivos_generales_archivos();
        $mcorrectivos_generales_archivos->add_ind($vector);
      }

      return response()->json($request->input('equipo_id'));

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar correctivo: ' . $e->getMessage()]);
    }
  }

  public function add_archivo_correctivo_general(Request $request)
  {
    try {
      $data = $request->all();

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_correctivos_generales'), $fileName);
        $data['file'] = $fileName;

        unset($data['equipo_id']);

        $mcorrectivos_generales_archivos = new Mcorrectivos_generales_archivos();
        $mcorrectivos_generales_archivos->add_ind($data);

        return response()->json(['success' => true]);
      }

      return response()->json(['error' => 'No se subió ningún archivo']);

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al subir archivo: ' . $e->getMessage()]);
    }
  }

  public function getCorrectivosGenerales(Request $request)
  {
    $mcorrectivos_generales = new Mcorrectivos_generales();
    $result = $mcorrectivos_generales->get_ind($request->all());

    if ($result != null) {
      return response()->json($result);
    } else {
      return response()->json(2);
    }
  }

  public function getArchivosCorrectivosGenerales(Request $request)
  {
    $mcorrectivos_generales_archivos = new Mcorrectivos_generales_archivos();
    $result = $mcorrectivos_generales_archivos->get_ind($request->all());

    return response()->json($result);
  }

  public function getOneCorrectivoGeneral(Request $request)
  {
    $mcorrectivos_generales = new Mcorrectivos_generales();
    $result = $mcorrectivos_generales->getOne_ind($request->all());

    return response()->json($result);
  }
  public function updateCorrectivoGeneral(Request $request)
  {
    try {
      $data = $request->all();

      $mcorrectivos_generales = new Mcorrectivos_generales();
      $correctivo = $mcorrectivos_generales->getOne_ind($data);
      $file_anterior = $correctivo->file ?? null;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_correctivos_generales'), $fileName);
        $data['file'] = $fileName;
      }

      if ($mcorrectivos_generales->update_ind($data)) {
        if (isset($data['file']) && $data['file'] != $file_anterior && $file_anterior) {
          $oldFilePath = public_path('assets/upload_correctivos_generales/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json($request->input('equipo_id'));
      } else {
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_correctivos_generales/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json(['error' => 'Error al actualizar correctivo']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  public function deleteCorrectivoGeneral(Request $request)
  {
    try {
      $mcorrectivos_generales_archivos = new Mcorrectivos_generales_archivos();
      $resultados = $mcorrectivos_generales_archivos->getAll_ind($request->all());

      foreach ($resultados as $resultado) {
        if ($mcorrectivos_generales_archivos->delete_ind($resultado->id)) {
          $filePath = public_path('assets/upload_correctivos_generales/' . $resultado->file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
      }

      $mcorrectivos_generales = new Mcorrectivos_generales();
      $mcorrectivos_generales->delete_ind($request->all());

      return response()->json(['success' => true]);

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  /*CRUD CALIBRACION*/
  public function addCalibracion(Request $request)
  {
    try {
      $data = $request->all();

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_calibraciones'), $fileName);
        $data['file'] = $fileName;
      }

      $mcalibraciones = new Mcalibraciones();
      $mcalibraciones->add_ind($data);

      return response()->json($request->input('equipo_id'));

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al agregar calibración: ' . $e->getMessage()]);
    }
  }

  public function getCalibraciones(Request $request)
  {
    $mcalibraciones = new Mcalibraciones();
    $result = $mcalibraciones->get_ind($request->all());

    if ($result != null) {
      return response()->json($result);
    } else {
      return response()->json(2);
    }
  }

  public function getOneCalibracion(Request $request)
  {
    $mcalibraciones = new Mcalibraciones();
    $result = $mcalibraciones->getOne_ind($request->all());

    return response()->json($result);
  }

  public function updateCalibracion(Request $request)
  {
    try {
      $data = $request->all();

      $mcalibraciones = new Mcalibraciones();
      $calibracion = $mcalibraciones->getOne_ind($data);
      $file_anterior = $calibracion->file ?? null;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/upload_calibraciones'), $fileName);
        $data['file'] = $fileName;
      }

      if ($mcalibraciones->update_ind($data)) {
        if (isset($data['file']) && $data['file'] != $file_anterior && $file_anterior) {
          $oldFilePath = public_path('assets/upload_calibraciones/' . $file_anterior);
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        return response()->json($request->input('equipo_id'));
      } else {
        if (isset($data['file'])) {
          $newFilePath = public_path('assets/upload_calibraciones/' . $data['file']);
          if (file_exists($newFilePath)) {
            unlink($newFilePath);
          }
        }
        return response()->json(['error' => 'Error al actualizar calibración']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }

  public function deleteCalibracion(Request $request)
  {
    try {
      $vector = [
        "id" => $request->input("id")
      ];

      $mcalibraciones = new Mcalibraciones();
      $calibracion = $mcalibraciones->getOne_ind($vector);
      $file = $calibracion->file ?? null;

      if ($mcalibraciones->delete_ind($request->all())) {
        if ($file && $file != "") {
          $filePath = public_path('assets/upload_calibraciones/' . $file);
          if (file_exists($filePath)) {
            unlink($filePath);
          }
        }
        return response()->json(['success' => true]);
      } else {
        return response()->json(['error' => 'Error al eliminar calibración']);
      }

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error del sistema: ' . $e->getMessage()]);
    }
  }
}
