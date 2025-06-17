<?php

namespace App\Http\Controllers\Guia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Controlador de Guías Rápidas - Laravel 11
 * Migrado desde CodeIgniter
 */
class Cguias extends Controller
{
  private $permisos;

  public function __construct()
  {
    parent::__construct();
  }
  public function index()
  {
    if (!Session::get('login')) {
      return redirect()->route('ci.login');
    }

    Session::put("controlador", "Cguias");

    $acciones = Session::get("acciones");
    Session::put('controlador', request()->segment(2));

    foreach ($acciones as $accion) {
      if ($accion->modulo == "guias rapidas") {
        if ($accion->leer != 1) {
          return redirect()->route('forbidden');
        }
      }
    }

    $data = [
      "guias" => $this->getAll(),
      "acciones" => $acciones,
      "cantidad_cumple_criterios" => $this->countAll(),
      "cantidad_cumple_criterios_con_guia" => $this->countWithGuia(),
      "cobertura_biomedicos" => $this->getCoberturaBiomedicos(),
      "cobertura_industriales" => $this->getCoberturaIndustriales()
    ];

    return view('guias.index', $data);
  }
  public function getCoberturaBiomedicos()
  {
    return response()->json($this->getCoberturaBiomedicosData());
  }

  public function getCoberturaIndustriales()
  {
    return response()->json($this->getCoberturaIndustrialesData());
  }

  public function get()
  {
    return response()->json($this->getGuias());
  }

  public function getWithQuery()
  {
    return response()->json($this->getGuiasWithQuery());
  }

  public function getOne(Request $request)
  {
    return response()->json($this->getOneGuia($request->all()));
  }

  public function getAll()
  {
    return response()->json($this->getAllGuias());
  }

  public function get_indicador_por_guia()
  {
    return response()->json($this->getIndicadorPorGuia());
  }
  public function add(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|unique:guias_rapidas,name|min:5',
      'file' => 'required|file|max:1000000'
    ]);

    if ($validator->fails()) {
      return response()->json([
        "caso" => 2,
        "informacion" => $validator->errors()->first()
      ]);
    }

    try {
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = Str::random(32) . '.' . $file->getClientOriginalExtension();

        // Ensure upload directory exists
        $uploadPath = public_path('assets/upload_guias');
        if (!file_exists($uploadPath)) {
          mkdir($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);

        $data = $request->all();
        $data['file'] = $fileName;

        $this->addGuia($data);

        return response()->json(["caso" => 1]);
      } else {
        return response()->json([
          "caso" => 2,
          "informacion" => "Falta ingresar archivo"
        ]);
      }
    } catch (\Exception $e) {
      return response()->json([
        "caso" => 2,
        "informacion" => "Error al subir archivo: " . $e->getMessage()
      ]);
    }
  }
  public function update(Request $request)
  {
    $guia = $this->getOneGuia($request->all());

    $rules = [
      'estado' => 'required'
    ];

    if ($guia->name != $request->input('name')) {
      $rules['name'] = 'required|unique:guias_rapidas,name|min:5';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json([
        "caso" => 2,
        "informacion" => $validator->errors()->first()
      ]);
    }

    try {
      $data = $request->all();

      if ($request->hasFile('file')) {
        // Delete old file if exists
        if ($guia->file && file_exists(public_path('assets/upload_guias/' . $guia->file))) {
          unlink(public_path('assets/upload_guias/' . $guia->file));
        }

        $file = $request->file('file');
        $fileName = Str::random(32) . '.' . $file->getClientOriginalExtension();

        $uploadPath = public_path('assets/upload_guias');
        if (!file_exists($uploadPath)) {
          mkdir($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $fileName);
        $data['file'] = $fileName;
      }

      $this->updateGuia($data);

      return response()->json([
        "caso" => 1,
        "informacion" => "Guia rapida editada exitosamente"
      ]);
    } catch (\Exception $e) {
      return response()->json([
        "caso" => 2,
        "informacion" => "Error al actualizar: " . $e->getMessage()
      ]);
    }
  }
  public function delete(Request $request)
  {
    $data = $request->all();
    $data["estado"] = 0;
    $this->updateGuia($data);

    return response()->json(["success" => true]);
  }

  public function show()
  {
    $guias_activas = $this->getGuias();
    return view("guias.detalle_consulta", ["guias_activas" => $guias_activas]);
  }

  public function detail_relacionar()
  {
    $relaciones = $this->getRelaciones();
    return view('guias.modal_link_detail', ["relaciones" => $relaciones]);
  }

  public function cantidad_relacionar_con_equipos(Request $request)
  {
    return response()->json($this->getCantidadRelacionarConEquipos($request->all()));
  }

  public function relacionar_con_equipos(Request $request)
  {
    $this->relacionarConEquipos($request->all());
    return response()->json(1);
  }

  public function relacionar_guia_con_equipos(Request $request)
  {
    $this->relacionarGuiaConEquipos($request->all());
    $cantidad = $this->getCantidadEquiposAsociados(["id" => $request->input("id")]);

    return response()->json($cantidad);
  }

  public function show_combinaciones(Request $request)
  {
    $guia = $this->getOneGuia(["id" => $request->input("id")]);
    $data = [
      "guia" => $guia,
      "id" => $request->input("id"),
      "combinaciones" => $this->getRelaciones()
    ];

    return view("guias.modal_show_relacionar_guia_equipos_detail", $data);
  }
  public function getRiesgosIncluidos()
  {
    return response()->json($this->getRiesgosIncluidosData());
  }

  public function getEstadosExcluidos()
  {
    return response()->json($this->getEstadosExcluidosData());
  }
  public function exportarPriorizados()
  {
    $equipos = $this->getPriorizados();

    $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
        </tr>
      </thead>
      <tbody>';

    foreach ($equipos as $equipo) {
      $html .= '<tr>
        <td>' . $equipo->id . '</td>
        <td>' . $equipo->name . '</td>
        <td>' . $equipo->code . '</td>
        <td>' . $equipo->serial . '</td>
        <td>' . $equipo->marca . '</td>
        <td>' . $equipo->modelo . '</td>
      </tr>';
    }

    $html .= '</tbody></table>';

    return response($html)
      ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
      ->header('Content-Disposition', 'attachment; filename=EquiposPriorizados.xls');
  }
  public function exportarPriorizadosGuia()
  {
    $equipos = $this->getPriorizadosGuia();

    $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Sede</th>
          <th>Nombre de la Guia</th>
          <th>Estado del equipo</th>
        </tr>
      </thead>
      <tbody>';

    foreach ($equipos as $equipo) {
      $html .= '<tr>
        <td>' . $equipo->id . '</td>
        <td>' . $equipo->name . '</td>
        <td>' . $equipo->code . '</td>
        <td>' . $equipo->serial . '</td>
        <td>' . $equipo->marca . '</td>
        <td>' . $equipo->modelo . '</td>
        <td>' . $equipo->sede . '</td>
        <td>' . $equipo->guia . '</td>
        <td>' . $equipo->estado . '</td>
      </tr>';
    }

    $html .= '</tbody></table>';

    return response($html)
      ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
      ->header('Content-Disposition', 'attachment; filename=EquiposPriorizadosConGuia.xls');
  }
  public function exportPrioritizedWithoutGuide()
  {
    $equipos = $this->getPrioritizedWithoutGuide();

    $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>sede</th>
          <th>Nombre de la Guia</th>
          <th>Estado del equipo</th>
        </tr>
      </thead>
      <tbody>';

    foreach ($equipos as $equipo) {
      $html .= '<tr>
        <td>' . $equipo->id . '</td>
        <td>' . $equipo->name . '</td>
        <td>' . $equipo->code . '</td>
        <td>' . $equipo->serial . '</td>
        <td>' . $equipo->marca . '</td>
        <td>' . $equipo->modelo . '</td>
        <td>' . $equipo->sede . '</td>
        <td>' . $equipo->guia . '</td>
        <td>' . $equipo->estado . '</td>
      </tr>';
    }

    $html .= '</tbody></table>';

    return response($html)
      ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
      ->header('Content-Disposition', 'attachment; filename=EquiposPriorizadosSinGuia.xls');
  }
  public function exportarPriorizadosGrupo()
  {
    $equipos = $this->getPriorizadosGrupo();

    $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Cantidad total</th>
          <th>Cantidad con guia</th>
          <th>%</th>
        </tr>
      </thead>
      <tbody>';

    foreach ($equipos as $equipo) {
      $html .= '<tr>
        <td>' . $equipo->name . '</td>
        <td>' . $equipo->cantidad_total . '</td>
        <td>' . $equipo->cantidad_con_guia . '</td>
        <td>' . $equipo->porcentaje . '</td>
      </tr>';
    }

    $html .= '</tbody></table>';

    return response($html)
      ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
      ->header('Content-Disposition', 'attachment; filename=EquiposPriorizadosPorGrupo.xls');
  }
  public function countWithGuia()
  {
    return response()->json($this->countWithGuiaData()->cantidad);
  }

  public function countAll()
  {
    return response()->json($this->countAllData()->cantidad);
  }

  public function updateGuideQueryQuantity(Request $request)
  {
    return response()->json($this->updateGuideQueryQuantityData($request->all()));
  }

  // Private methods for database operations (replacing model calls)
  private function getAllGuias()
  {
    return DB::select("
      SELECT gr.*,
          (
          SELECT
              COUNT(*)
          FROM
              equipos e
          WHERE
              e.guia_id = gr.id
      ) AS nro_equipos
      FROM
          `guias_rapidas` gr
        ORDER BY gr.name ASC
    ");
  }

  private function getGuias()
  {
    return DB::table('guias_rapidas')
      ->where('estado', 1)
      ->get();
  }

  private function getOneGuia($param)
  {
    return DB::table('guias_rapidas')
      ->where('id', $param['id'])
      ->first();
  }

  private function addGuia($param)
  {
    return DB::table('guias_rapidas')->insert($param);
  }

  private function updateGuia($param)
  {
    $id = $param['id'];
    unset($param['id']);
    return DB::table('guias_rapidas')
      ->where('id', $id)
      ->update($param);
  }

  private function getCoberturaBiomedicosData()
  {
    return DB::select("
      SELECT
          COUNT(*) AS cantidad_total,
          (
          SELECT
              COUNT(*)
          FROM
              equipos e
          WHERE
              e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
              SELECT
                  estadoequipo_id
              FROM
                  estados_excluidos_guias
          ) AND e.criesgo_id IN(
              SELECT
                  criesgo_id
              FROM
                  riesgos_incluidos_guias
          ) AND e.name NOT IN(
              SELECT name
          FROM
              equipos_excluidos_guias) AND e.guia_id IS NOT NULL
      ) AS cantidad_con_guia
      FROM
          equipos e
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias)
    ");
  }

  private function getCoberturaIndustrialesData()
  {
    return DB::select("
      SELECT
          COUNT(*) AS cantidad_total,
          (
          SELECT
              COUNT(*)
          FROM
              equipos e
          WHERE
              e.tipo_id = 2 AND e.estadoequipo_id NOT IN(
              SELECT
                  estadoequipo_id
              FROM
                  estados_excluidos_guias
          ) AND e.criesgo_id IN(
              SELECT
                  criesgo_id
              FROM
                  riesgos_incluidos_guias
          ) AND e.name NOT IN(
              SELECT name
          FROM
              equipos_excluidos_guias) AND e.guia_id IS NOT NULL
      ) AS cantidad_con_guia
      FROM
          equipos e
      WHERE
          e.tipo_id = 2 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias)
    ");
  }

  private function getGuiasWithQuery()
  {
    return DB::select("
      SELECT
          *,
          (
          SELECT
              COUNT(*)
          FROM
              consultas_guias_rapidas
          WHERE
              consultas_guias_rapidas.guia_id = guias_rapidas.id
      ) AS totalQuery
      FROM
          guias_rapidas
      WHERE
          id != 0
    ");
  }

  private function getIndicadorPorGuia()
  {
    return DB::select("
      SELECT
          gr.name,
          COUNT(e.id) AS cantidad_equipos
      FROM
          guias_rapidas gr
      LEFT JOIN equipos e ON
          e.guia_id = gr.id
      WHERE
          gr.estado = 1
      GROUP BY
          gr.id,
          gr.name
      ORDER BY
          cantidad_equipos DESC
    ");
  }

  private function getRelaciones()
  {
    return DB::select("
      SELECT DISTINCT
          e.name,
          e.marca,
          e.modelo,
          COUNT(*) AS cantidad
      FROM
          equipos e
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias)
      GROUP BY
          e.name,
          e.marca,
          e.modelo
      ORDER BY
          cantidad DESC
    ");
  }

  private function getCantidadRelacionarConEquipos($param)
  {
    return DB::select("
      SELECT
          COUNT(*) AS cantidad
      FROM
          equipos e
      WHERE
          e.name LIKE ? AND
          e.marca LIKE ? AND
          e.modelo LIKE ? AND
          e.estadoequipo_id != 6 AND
          e.estadoequipo_id != 9 AND
          e.estadoequipo_id != 14
    ", ['%' . $param['nombre'] . '%', '%' . $param['marca'] . '%', '%' . $param['modelo'] . '%']);
  }

  private function relacionarConEquipos($param)
  {
    return DB::update("
      UPDATE equipos e SET e.guia_id = ? WHERE
      e.name LIKE ? AND
      e.marca LIKE ? AND
      e.modelo LIKE ? AND
      e.estadoequipo_id != 6 AND
      e.estadoequipo_id != 9 AND
      e.estadoequipo_id != 14
    ", [$param['id'], '%' . $param['nombre'] . '%', '%' . $param['marca'] . '%', '%' . $param['modelo'] . '%']);
  }

  private function relacionarGuiaConEquipos($param)
  {
    return DB::update("
      UPDATE equipos e SET e.guia_id = ? WHERE
      e.name = ? AND
      e.marca = ? AND
      e.modelo = ? AND
      e.estadoequipo_id != 6 AND
      e.estadoequipo_id != 9 AND
      e.estadoequipo_id != 14
    ", [$param['id'], $param['nombre'], $param['marca'], $param['modelo']]);
  }

  private function getCantidadEquiposAsociados($param)
  {
    return DB::table('equipos')
      ->where('guia_id', $param['id'])
      ->count();
  }

  private function getRiesgosIncluidosData()
  {
    return DB::table('riesgos_incluidos_guias')
      ->join('criesgos', 'riesgos_incluidos_guias.criesgo_id', '=', 'criesgos.id')
      ->select('criesgos.*')
      ->get();
  }

  private function getEstadosExcluidosData()
  {
    return DB::table('estados_excluidos_guias')
      ->join('estadoequipos', 'estados_excluidos_guias.estadoequipo_id', '=', 'estadoequipos.id')
      ->select('estadoequipos.*')
      ->get();
  }

  private function getPriorizados()
  {
    return DB::select("
      SELECT
          e.id,
          e.name,
          e.code,
          e.serial,
          e.marca,
          e.modelo
      FROM
          equipos e
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias)
      ORDER BY
          e.name ASC
    ");
  }

  private function getPriorizadosGuia()
  {
    return DB::select("
      SELECT
          e.id,
          e.name,
          e.code,
          e.serial,
          e.marca,
          e.modelo,
          s.name AS sede,
          gr.name AS guia,
          ee.name AS estado
      FROM
          equipos e
      LEFT JOIN sedes s ON
          e.sede_id = s.id
      LEFT JOIN guias_rapidas gr ON
          e.guia_id = gr.id
      LEFT JOIN estadoequipos ee ON
          e.estadoequipo_id = ee.id
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias) AND e.guia_id IS NOT NULL
      ORDER BY
          e.name ASC
    ");
  }

  private function getPrioritizedWithoutGuide()
  {
    return DB::select("
      SELECT
          e.id,
          e.name,
          e.code,
          e.serial,
          e.marca,
          e.modelo,
          s.name AS sede,
          gr.name AS guia,
          ee.name AS estado
      FROM
          equipos e
      LEFT JOIN sedes s ON
          e.sede_id = s.id
      LEFT JOIN guias_rapidas gr ON
          e.guia_id = gr.id
      LEFT JOIN estadoequipos ee ON
          e.estadoequipo_id = ee.id
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias) AND e.guia_id IS NULL
      ORDER BY
          e.name ASC
    ");
  }

  private function getPriorizadosGrupo()
  {
    return DB::select("
      SELECT
          e.name,
          COUNT(*) AS cantidad_total,
          (
          SELECT
              COUNT(*)
          FROM
              equipos e2
          WHERE
              e2.name = e.name AND e2.guia_id IS NOT NULL AND e2.tipo_id = 1 AND e2.estadoequipo_id NOT IN(
              SELECT
                  estadoequipo_id
              FROM
                  estados_excluidos_guias
          ) AND e2.criesgo_id IN(
              SELECT
                  criesgo_id
              FROM
                  riesgos_incluidos_guias
          ) AND e2.name NOT IN(
              SELECT name
          FROM
              equipos_excluidos_guias)
      ) AS cantidad_con_guia,
          ROUND(
          (
              (
              SELECT
                  COUNT(*)
              FROM
                  equipos e2
              WHERE
                  e2.name = e.name AND e2.guia_id IS NOT NULL AND e2.tipo_id = 1 AND e2.estadoequipo_id NOT IN(
                  SELECT
                      estadoequipo_id
                  FROM
                      estados_excluidos_guias
              ) AND e2.criesgo_id IN(
                  SELECT
                      criesgo_id
                  FROM
                      riesgos_incluidos_guias
              ) AND e2.name NOT IN(
                  SELECT name
              FROM
                  equipos_excluidos_guias)
          ) / COUNT(*)
      ) * 100,
          2
      ) AS porcentaje
      FROM
          equipos e
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias)
      GROUP BY
          e.name
      ORDER BY
          porcentaje DESC
    ");
  }

  private function countWithGuiaData()
  {
    return DB::selectOne("
      SELECT
          COUNT(*) AS cantidad
      FROM
          equipos e
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias) AND e.guia_id IS NOT NULL
    ");
  }

  private function countAllData()
  {
    return DB::selectOne("
      SELECT
          COUNT(*) AS cantidad
      FROM
          equipos e
      WHERE
          e.tipo_id = 1 AND e.estadoequipo_id NOT IN(
          SELECT
              estadoequipo_id
          FROM
              estados_excluidos_guias
      ) AND e.criesgo_id IN(
          SELECT
              criesgo_id
          FROM
              riesgos_incluidos_guias
      ) AND e.name NOT IN(
          SELECT name
      FROM
          equipos_excluidos_guias)
    ");
  }

  private function updateGuideQueryQuantityData($param)
  {
    return DB::table('consultas_guias_rapidas')->insert($param);
  }
}