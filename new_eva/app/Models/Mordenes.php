<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mordenes extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }
  public function get($param)
  {
    $this->db->select("ordenes.*,estados.descripcion as estado");
    $this->db->from("ordenes");
    $this->db->join("estados", "ordenes.estado_id=estados.id", "left");
    $this->db->where("ordenes.equipo_id", $param['equipo_id']);
    return $this->db->get()->result();
  }
  public function getByDevice($param)
  {
    $query = "
		SELECT 
		ordenes.*,
		estados.descripcion as estado
		 FROM ordenes 
		 LEFT JOIN estados ON estados.id=ordenes.estado_id
		where equipo_id=" . $param["equipo_id"];
    return $this->db->query($query)->result();
  }
  public function get_server_side($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }
    $this->db->select('*');
    $this->db->from('ordenes');
    $this->db->where('descripcion like"%' . $param['search']['value'] . '%"');
    $this->db->limit($param['length'], $param['start']);
    $result = $this->db->get(); // Estructura de datos

    $num_filas_limit = $result->num_rows();
    $datos = $result->result();

    $this->db->select('*');
    $this->db->from('ordenes');
    $this->db->where('descripcion like"%' . $param['search']['value'] . '%"');
    $num_filas = $this->db->get()->num_rows();

    $vector = array(

      'datos' => $datos,
      'num_filas_limit' => $num_filas_limit,
      'num_filas' => $num_filas

    );

    return $vector;
  }
  public function getOwn()
  {
    $this->db->select(
      "
			o.equipo_id,
			o.id as id,
			o.prioridad as prioridad,
			o.nombre_equipo as nombre_equipo,
			o.modelo_equipo as modelo_equipo,
			o.serie_equipo as serie_equipo,
			o.codigo_equipo as codigo_equipo,
			o.asunto as asunto,
			o.descripcion as descripcion,
			o.fecha_inicio as fecha_inicio,
			o.estado_id as estado_id,
			sp.nombre as subproceso,
			e.name,
			e.code,
			e.marca,
			e.modelo,
			e.serial,
			e.code
			"
    );
    $this->db->from("ordenes o");
    $this->db->join("subprocesos sp", "sp.id=o.subproceso_id", "left");
    $this->db->join("equipos e", "e.id=o.equipo_id", "left");
    // $this->db->where("o.reportante_id",$param);
    $this->db->where("o.reportante_id", $this->session->userdata("id"));
    if (isset($_POST["subproceso_id"])) {
      if ($_POST["subproceso_id"] == 0) {
      } else {
        $this->db->where("o.subproceso_id", $_POST["subproceso_id"]);
      }
    }
    $this->db->order_by("o.fecha_inicio", "desc");
    return $this->db->get()->result();
  }
  public function getActive()
  {
    $this->db->select("
		equipos.id as equipo_id,
		equipos.name as equipo,
		equipos.marca as marca,
		equipos.modelo as modelo,
		equipos.code as codigo,
		equipos.serial as serial,
		equipos.localizacion_actual as localizacion_actual,
		equipos.repuesto_pendiente as repuesto_pendiente_equipo,
		empresas.name as empresa,
		ordenes.*,
		usuarios.username as usuario,
		usuarios_asignadores.username as usuario_asignador,
		usuarios_asignadores.nombre as nombre_usuario_asignador,
		usuarios_asignadores.apellido as apellido_usuario_asignador,
		subprocesos.nombre as subproceso,
		servicios.sede_id as sede_id,
		servicios.name as servicio,
		sedes.name as sede,
		areas.name as area,
		estadoequipos.name as estado_equipo,
		estadoequipos.color as color_estado_equipo,
		tecnicos.name as tecnico_asignado,
		tecnicos.id as tecnico_asignado_id,
		(SELECT pm.responsable FROM planes_mantenimientos pm WHERE pm.equipo_id = equipos.id order by pm.anio desc limit 1) as responsable_mantenimiento
		");
    $this->db->from("ordenes");
    $this->db->join("servicios", "servicios.id=ordenes.servicio_id", "left");
    $this->db->join("sedes", "sedes.id=servicios.sede_id", "left");
    $this->db->join("usuarios", "usuarios.id=ordenes.asignado_id", "left");
    $this->db->join("usuarios usuarios_asignadores", "usuarios_asignadores.id=ordenes.asignador_id", "left");
    $this->db->join("empresas", "empresas.id=ordenes.empresa_id", "left");
    $this->db->join("subprocesos", "subprocesos.id=ordenes.subproceso_id", "left");
    $this->db->join("equipos", "equipos.id=ordenes.equipo_id", "left");
    $this->db->join("areas", "equipos.area_id=areas.id", "left");
    $this->db->join("estadoequipos", "estadoequipos.id=equipos.estadoequipo_id", "left");
    $this->db->join("tecnicos", "tecnicos.id=ordenes.tecnico_id", "left");
    if (isset($_POST["sede_id"])) {
      if ($_POST["sede_id"] == 0) {
      } else {
        $this->db->where("servicios.sede_id = " . $_POST["sede_id"]);
      }
    }
    if (isset($_POST["estado_id"])) {
      if ($_POST["estado_id"] == "") {
      } else {
        $this->db->where("ordenes.estado_id = " . $_POST["estado_id"]);
      }
    }
    $this->db->where("ordenes.estado_id!=4");
    if ($this->session->userdata("id_empresa") == 3 || $this->session->userdata("id_empresa") == 6) {
      $this->db->where("ordenes.subproceso_id = 1");
    }
    if ($this->session->userdata("id_empresa") == 4 || $this->session->userdata("id_empresa") == 7) {
      $this->db->where("ordenes.subproceso_id = 2 or ordenes.subproceso_id = 3");
    }
    if ($this->session->userdata("id_empresa") == 27) {
      $this->db->where("ordenes.subproceso_id = 1 or ordenes.subproceso_id = 2");
    }
    if (isset($_POST["condicion"])) {
      if ($_POST["condicion"] == 1) {
        $this->db->where("ordenes.fecha_inicio <= '" . $_POST["final"] . "'");
        $this->db->where("ordenes.fecha_inicio >= '" . $_POST["inicial"] . "'");
        // $this->db->where("ordenes.fecha_asignacion_cierre <= '".$_POST["final"]."'");
        // $this->db->where("ordenes.fecha_asignacion_cierre >= '".$_POST["inicial"]."'");
      }
    }
    $this->db->order_by("ordenes.id", "desc");
    return $this->db->get()->result();
  }
  public function getAsignadas($id_empresa)
  {

    $this->db->select("
			e.name as equipo,
			e.marca as marca,
			e.modelo as modelo,
			e.code as codigo,
			e.serial as serial,
			e.localizacion_actual as localizacion_actual,
			e.repuesto_pendiente as repuesto_pendiente_equipo,
			em.name as empresa,
			o.*,
			usuarios.username as usuario,
			em.id as empresa_id,
			subprocesos.nombre as subproceso,
			servicios.sede_id as sede_id,
			servicios.name as servicio,
			sedes.name as sede,
			areas.name as area

			");
    $this->db->from("ordenes o");
    $this->db->join("servicios", "servicios.id=o.servicio_id", "left");
    $this->db->join("sedes", "sedes.id=servicios.sede_id", "left");
    $this->db->join("usuarios", "usuarios.id=o.asignado_id", "left");
    $this->db->join("empresas em", "em.id=o.empresa_id"); //,"left");
    $this->db->join("subprocesos", "subprocesos.id=o.subproceso_id", "left");
    $this->db->join("equipos e", "e.id=o.equipo_id", "left");
    $this->db->join("areas", "e.area_id=areas.id", "left");
    $this->db->where("o.empresa_id", $id_empresa);
    // $this->db->where("o.estado_id !=4");
    if (isset($_POST["sede_id"])) {
      if ($_POST["sede_id"] == 0) {
      } else {
        $this->db->where("servicios.sede_id = " . $_POST["sede_id"]);
      }
    }
    $this->db->where("o.estado_id!=4");
    if (isset($_POST["estado_id"])) {
      if ($_POST["estado_id"] == "") {
      } else {
        $this->db->where("o.estado_id = " . $_POST["estado_id"]);
      }
    }
    if (isset($_POST["condicion"])) {
      if ($_POST["condicion"] == 1) {
        $this->db->where("o.fecha_inicio <= '" . $_POST["final"] . "'");
        $this->db->where("o.fecha_inicio >= '" . $_POST["inicial"] . "'");
        // $this->db->where("o.fecha_asignacion_cierre <= '".$_POST["final"]."'");
        // $this->db->where("o.fecha_asignacion_cierre >= '".$_POST["inicial"]."'");
      }
    }
    $this->db->order_by("o.fecha_inicio", "desc");
    return $this->db->get()->result();
  }
  public function getClosed()
  {
    $this->db->select("
			o.*,
			e.name as equipo,
			e.marca as marca,
			e.modelo as modelo,
			e.code as codigo,
			e.serial as serial,
			usuarios.username as usuario,
			diagnosticadores.username as diagnosticador,
			reparadores.username as reparador,
			FORMAT((TIMESTAMPDIFF(MINUTE,
			o.fecha_inicio,
			o.fecha_fin)/60),1) AS tiempo,
			FORMAT((TIMESTAMPDIFF(MINUTE,
			o.fecha_inicio,
			o.fecha_fin)/60/24),1) AS tiempo_dia,
			FORMAT((TIMESTAMPDIFF(MINUTE,
			o.fecha_inicio,
			o.fecha_fin)/60/24/30),1) AS tiempo_mes,
			sp.nombre as subproceso
			");
    $this->db->from("ordenes o");
    $this->db->join("usuarios as usuarios", "usuarios.id=o.asignado_id", "left");
    $this->db->join("usuarios as diagnosticadores", "diagnosticadores.id=o.tecnico_diagnostico", "left");
    $this->db->join("usuarios as reparadores", "reparadores.id=o.tecnico_cierre", "left");
    $this->db->join("equipos e", "e.id=o.equipo_id", "left");
    $this->db->join("subprocesos sp", "sp.id=o.subproceso_id", "left");
    $this->db->join("servicios s", "s.id=e.servicio_id", "left");
    $this->db->where("o.estado_id=4");
    if ($this->session->userdata("id_empresa") == 3 || $this->session->userdata("id_empresa") == 6) {
      $this->db->where("o.subproceso_id = 1");
    }
    if ($this->session->userdata("id_empresa") == 4 || $this->session->userdata("id_empresa") == 7) {
      $this->db->where("o.subproceso_id = 2 or o.subproceso_id = 3");
    }
    if (isset($_POST["sede_id"])) {
      if ($_POST["sede_id"] == 0) {
      } else {
        $this->db->where("s.sede_id = " . $_POST["sede_id"]);
      }
    }
    $this->db->order_by("o.fecha_fin", "desc");
    return $this->db->get()->result();
  }
  public function getOrdenesForCorrectivos()
  {
    $query = "
			SELECT
			(SELECT avances_correctivos.date from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 1) as avance_fecha,
			(SELECT avances_correctivos.title from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 1) as avance_titulo,
			(SELECT avances_correctivos.description from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 1) as avance_descripcion,
			(SELECT avances_correctivos.date from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 1,1) as avance_fecha2,
			(SELECT avances_correctivos.title from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 1,1) as avance_titulo2,
			(SELECT avances_correctivos.description from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 1,1) as avance_descripcion2,
			(SELECT avances_correctivos.date from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 2,1) as avance_fecha3,
			(SELECT avances_correctivos.title from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 2,1) as avance_titulo3,
			(SELECT avances_correctivos.description from avances_correctivos WHERE avances_correctivos.orden_id=ordenes.id ORDER BY avances_correctivos.date desc LIMIT 2,1) as avance_descripcion3,
			ordenes.id AS id,
			DATE_FORMAT(ordenes.fecha_inicio,'%Y-%m-%d')  AS fecha_inicio,
			ordenes.reparacion AS reparacion,
			estados.descripcion AS estado,
			ordenes.descripcion AS descripcion,
			ordenes.retro_cierre AS retro_cierre,
			DATE_FORMAT(ordenes.fecha_diagnostico,'%Y-%m-%d') AS fecha_diagnostico,
			ordenes.retro_diagnostico AS retro_diagnostico,
			DATE_FORMAT(ordenes.fecha_fin,'%Y-%m-%d') AS fecha_fin,
			ordenes.fecha_asignacion_cierre AS fecha_asignacion_cierre,
      ordenes.repuesto_pendiente AS repuesto_pendiente,
      ordenes.repuesto_pendiente_condicion AS repuesto_pendiente_condicion,
			codificacion_cierres.code AS codigo_cierre,
			codificacion_cierres.name AS significado_cierre,
			ordenes.equipo_id AS equipo_id,
			equipos.name AS equipo,
			equipos.serial AS serie,
			equipos.marca AS marca,
			equipos.modelo AS modelo,
			equipos.code AS code,
			equipos.costo AS costo,
			estadoequipos.name AS estado_equipo,
			(SELECT pm.responsable FROM planes_mantenimientos pm WHERE equipo_id=equipos.id ORDER BY anio DESC LIMIT 1)AS responsable_mantenimiento,
			ordenes.nombre_equipo AS nombre_equipo,
			ordenes.serie_equipo AS serie_equipo,
			ordenes.marca_equipo AS marca_equipo,
			ordenes.modelo_equipo AS modelo_equipo,
			ordenes.codigo_equipo AS codigo_equipo,
			servicios.name AS servicio,
			sedes.name AS sede,
			areas.name AS area
			FROM
			ordenes
			LEFT JOIN equipos ON equipos.id = ordenes.equipo_id
			LEFT JOIN servicios ON servicios.id = ordenes.servicio_id
			LEFT JOIN areas ON areas.id = ordenes.area_id
			LEFT JOIN sedes ON sedes.id = servicios.sede_id
			LEFT JOIN codificacion_cierres ON codificacion_cierres.id = ordenes.cierre_id
			LEFT JOIN estados ON estados.id = ordenes.estado_id
			LEFT JOIN estadoequipos ON estadoequipos.id = equipos.estadoequipo_id
			WHERE equipos.tipo_id=" . $this->session->userdata("tipo_id") . "
			ORDER BY
			ordenes.fecha_fin
			DESC
		";
    return $this->db->query($query)->result();
  }
  public function getOneEmpresa($id_empresa)
  {

    $this->db->select("empresas.*");
    $this->db->from("empresas");
    $this->db->where("id", $id_empresa);
    return $this->db->get()->result();
  }
  public function getUsuarioEmpresa($id_empresa)
  {
    $this->db->select("usuarios.email as email_empresa");
    $this->db->from("usuarios");
    $this->db->where("usuarios.id_empresa", $id_empresa);
    return $this->db->get()->result();
  }
  public function getCount($id_empresa)
  {
    $qnr = "SELECT count(1) cant FROM usuarios WHERE id_empresa = " . $id_empresa;
    $qnr = $this->db->query($qnr);
    $qnr = $qnr->row();
    $qnr = $qnr->cant;
    return $qnr;
  }
  public function asignar_empresa($param)
  {
    $this->db->where("id", $param["id"]);
    unset($param["id"]);
    $this->db->update("ordenes", $param);
  }
  public function addEstado($param)
  {
    $this->db->where("id", $param["id"]);
    unset($param["id"]);
    $this->db->update("ordenes", $param);
  }
  public function activate($data, $id)
  {
    $this->db->where('ordenes.id', $id['id']);
    return $this->db->update('ordenes', $data);
  }
  public function add($param)
  {
    $this->db->insert("ordenes", $param);
    return $this->db->insert_id();
  }
  public function update($param)
  {
    $this->db->where("id", $param['id']);
    unset($param['id']);
    return $this->db->update("ordenes", $param);
  }
  public function getOne($param)
  {
    $this->db->select("
			ordenes.*,
			servicios.name as servicio,
			tecnico_cierre.username,
			areas.name as area,
			centros.name as centro,
			centro_reportante.name as centro_costo_reportante ,
			usuarios.nombre as nombre,usuarios.apellido as apellido,
			usuarios.telefono as telefono, usuarios.email as email,
			codificacion_diagnosticos.name as descripcion_diagnostico,
			codificacion_diagnosticos.code as codigo_diagnostico,
			codificacion_cierres.name as descripcion_cierre,
			codificacion_cierres.code as codigo_cierre,
			asignados.username as asignado,
			tecnico_diagnostico.nombre as nombre_tecnico_diagnostico,
			tecnico_diagnostico.apellido as apellido_tecnico_diagnostico,
			tecnico_cierre.nombre as nombre_tecnico_cierre,
			tecnico_cierre.apellido as apellido_tecnico_cierre,
			usuario_final.nombre as nombre_usuario_final,
			usuario_final.apellido as apellido_usuario_final,
			usuario_final.email as email_usuario_final,
			usuario_asignador.username as username_usuario_asignador,
			usuario_asignador.nombre as nombre_usuario_asignador,
			usuario_asignador.apellido as apellido_usuario_asignador,
			equipos.name as nombre_equipo_db,
			equipos.marca as marca_equipo_db,
			equipos.modelo as modelo_equipo_db,
			equipos.serial as serie_equipo_db,
			equipos.code as codigo_equipo_db,
			empresas.name as empresa,
			sedes.name as sede,
			trabajos.name as trabajo,
			tecnicos.name as tecnico,
			listado_industriales.name as tipo_industrial,
			(SELECT count(*) from repuestos_ti where repuestos_ti.orden_id=ordenes.id)as cantidad_repuestos");
    $this->db->from('ordenes');
    $this->db->join('servicios', ' servicios.id=ordenes.servicio_id', 'left');
    $this->db->join('usuarios ', ' usuarios.id=ordenes.reportante_id', 'left');
    $this->db->join('usuarios as asignados ', ' asignados.id=ordenes.asignado_id', 'left');
    $this->db->join('usuarios as tecnico_diagnostico ', ' tecnico_diagnostico.id=ordenes.tecnico_diagnostico', 'left');
    $this->db->join('usuarios as tecnico_cierre ', ' tecnico_cierre.id=ordenes.tecnico_cierre', 'left');
    $this->db->join('usuarios as usuario_final ', ' usuario_final.id=ordenes.usuario_final_id', 'left');
    $this->db->join('usuarios as usuario_asignador ', ' usuario_asignador.id=ordenes.asignador_id', 'left');
    $this->db->join('centros', ' centros.id=usuarios.centro_id', 'left');
    $this->db->join('centros as centro_reportante', ' centro_reportante.id=ordenes.centro_costo', 'left');
    $this->db->join('codificacion_diagnosticos', ' codificacion_diagnosticos.id=ordenes.diagnostico_id', 'left');
    $this->db->join('codificacion_cierres', ' codificacion_cierres.id=ordenes.cierre_id', 'left');
    $this->db->join('areas', ' areas.id=ordenes.area_id', 'left');
    $this->db->join('equipos', ' equipos.id=ordenes.equipo_id', 'left');
    $this->db->join('empresas', ' empresas.id=ordenes.empresa_id', 'left');
    $this->db->join('sedes', ' sedes.id=servicios.sede_id', 'left');
    $this->db->join('trabajos', ' trabajos.id=ordenes.trabajo_id', 'left');
    $this->db->join('tecnicos', ' tecnicos.id=ordenes.tecnico_id', 'left');
    $this->db->join('listado_industriales', ' listado_industriales.id=ordenes.listado_industrial_id', 'left');
    $this->db->where('ordenes.id=' . $param["id"]);
    return $this->db->get()->row();
  }
  public function getallordenes($param)
  {
    $this->db->select("ordenes.*");
    $this->db->from('ordenes');
    $this->db->where('ordenes.id=' . $param["id"]);
    $this->db->limit(1);
    return $this->db->get()->row();
  }
  public function getProcesos()
  {
    return $this->db->get("procesos")->result();
  }
  public function getSubprocesos($param)
  {
    $this->db->where("status", 1);
    $this->db->where("proceso_id", $param);
    return $this->db->get("subprocesos")->result();
  }
  public function getUsuarios()
  {
    $this->db->select("usuarios.*,roles.nombre as rol");
    $this->db->from("usuarios");
    $this->db->join("roles", "roles.id=usuarios.rol_id");
    $this->db->where("estado", 1);
    $this->db->where("rol_id !=4");
    $this->db->where("rol_id !=1");
    return $this->db->get()->result();
  }
  public function getPorEstado()
  {
    $this->db->select("estados.descripcion as estado,count(*) as total");
    $this->db->from("ordenes");
    $this->db->join("estados", "estados.id=ordenes.estado_id", "left");
    $this->db->group_by("estados.descripcion");
    $this->db->order_by("count(*)", "desc");
    return $this->db->get()->result();
  }
  public function getPromedioTotal()
  {
    $this->db->select("avg(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as total");
    $this->db->from("ordenes");
    return $this->db->get()->row();
  }
  public function getMenorTotal()
  {
    $this->db->select("min(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as total");
    $this->db->from("ordenes");
    return $this->db->get()->row();
  }
  public function getMayorTotal()
  {
    $this->db->select("max(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as total");
    $this->db->from("ordenes");
    return $this->db->get()->row();
  }
  public function getByFechaCierre($param)
  {
    $this->db->select("
			avg(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as promedio,
			min(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as menor,
			max(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as mayor
			");
    $this->db->from("ordenes");
    $this->db->where("fecha_fin between '" . $param["fecha_inicio"] . "' and '" . $param["fecha_fin"] . "' ");
    return $this->db->get()->row();
  }
  public function getByFechaCreacion($param)
  {
    $this->db->select("
			avg(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as promedio,
			min(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as menor,
			max(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as mayor
			");
    $this->db->from("ordenes");
    $this->db->where("fecha_inicio between '" . $param["fecha_inicio"] . "' and '" . $param["fecha_fin"] . "' ");
    return $this->db->get()->row();
  }
  public function getCorrectivosAll()
  {
    $this->db->select("ordenes.*,equipos.name as equipo_nombre,equipos.code as equipo_codigo,equipos.serial as equipo_serie,equipos.marca as equipo_marca,equipos.modelo as equipo_modelo,estados.descripcion as estado, subprocesos.nombre as subproceso, procesos.nombre as proceso, servicios.name as ubicacion, reportantes.username as username, centros.name as centro,,centro_reportante.name as centro_costo_reportante,  asignados.username as asignado, cerradores.username as cerrador, diagnosticadores.username as diagnosticador ");
    $this->db->from("ordenes");
    $this->db->join("equipos", "equipos.id=ordenes.equipo_id", "left");
    $this->db->join("estados", "estados.id=ordenes.estado_id", "left");
    $this->db->join("servicios", "servicios.id=ordenes.servicio_id", "left");
    $this->db->join("usuarios as reportantes", "reportantes.id=ordenes.reportante_id", "left");
    $this->db->join("usuarios as asignados", "asignados.id=ordenes.asignado_id", "left");
    $this->db->join("usuarios as cerradores", "cerradores.id=ordenes.tecnico_cierre", "left");
    $this->db->join("usuarios as diagnosticadores", "diagnosticadores.id=ordenes.tecnico_diagnostico", "left");
    $this->db->join("centros", "centros.id=reportantes.centro_id", "left");
    $this->db->join('centros as centro_reportante', ' centro_reportante.id=ordenes.centro_costo', 'left');
    $this->db->join("subprocesos", "subprocesos.id=ordenes.subproceso_id", "left");
    $this->db->join("procesos", "procesos.id=subprocesos.proceso_id", "left");
    $this->db->order_by("ordenes.fecha_inicio", "asc");
    return $this->db->get()->result();
  }
  public function update_fecha_solicitud($param)
  {
    $this->db->set("fecha_solicitud_repuesto", date("Y:m:d H:i:s"));
    $this->db->where("id", $param["id"]);
    $this->db->update("ordenes");
  }
  public function update_fecha_recepcion($param)
  {
    $this->db->set("fecha_recepcion_repuesto", date("Y:m:d H:i:s"));
    $this->db->where("id", $param["id"]);
    $this->db->update("ordenes");
  }
  public function getGeneratedByDate($param)
  {
    $query = "
		SELECT
		    (
		    SELECT
		        COUNT(*)
		    FROM
		        ordenes
		    WHERE
		        ordenes.electrico = 'true' AND EXTRACT(
		            YEAR_MONTH
		        FROM
		            ordenes.fecha_inicio
		        ) = EXTRACT(YEAR_MONTH
		    FROM
		        o.fecha_inicio)
		) AS cantidad_electrico,
		(
		    SELECT
		        COUNT(*)
		    FROM
		        ordenes
		    WHERE
		        ordenes.mecanico = 'true' AND EXTRACT(
		            YEAR_MONTH
		        FROM
		            ordenes.fecha_inicio
		        ) = EXTRACT(YEAR_MONTH
		    FROM
		        o.fecha_inicio)
		) AS cantidad_mecanico,
		(
		    SELECT
		        COUNT(*)
		    FROM
		        ordenes
		    WHERE
		        ordenes.locativo = 'true' AND EXTRACT(
		            YEAR_MONTH
		        FROM
		            ordenes.fecha_inicio
		        ) = EXTRACT(YEAR_MONTH
		    FROM
		        o.fecha_inicio)
		) AS cantidad_locativo,
		CONCAT(
		    YEAR(o.fecha_inicio),
		    '(',
		    MONTH(o.fecha_inicio),
		    ')'
		) AS mes,
		COUNT(*) AS cantidad
		FROM
		    ordenes o
		WHERE
		    o.subproceso_id LIKE '%" . $param["subproceso_id"] . "%'
		GROUP BY
		    EXTRACT(YEAR_MONTH
		FROM
		    o.fecha_inicio) 
		ORDER BY
		    EXTRACT(YEAR_MONTH
		FROM
		    o.fecha_inicio) ASC
		";
    return $this->db->query($query)->result();
  }
  public function getClosedByDate($param)
  {

    $query = "
				SELECT
		    (
			    SELECT
			        COUNT(*)
			    FROM
			        ordenes
			    WHERE
			        ordenes.electrico = 'true' AND EXTRACT(
			            YEAR_MONTH
			        FROM
			            (CASE WHEN ordenes.fecha_fin IS NULL THEN ordenes.fecha_asignacion_cierre ELSE ordenes.fecha_fin END)
			        ) = EXTRACT(YEAR_MONTH
			    FROM
			        (CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin END))
			) AS cantidad_electrico,
		    (
			    SELECT
			        COUNT(*)
			    FROM
			        ordenes
			    WHERE
			        ordenes.mecanico = 'true' AND EXTRACT(
			            YEAR_MONTH
			        FROM
			            (CASE WHEN ordenes.fecha_fin IS NULL THEN ordenes.fecha_asignacion_cierre ELSE ordenes.fecha_fin END)
			        ) = EXTRACT(YEAR_MONTH
			    FROM
			        (CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin END))
			) AS cantidad_mecanico,
		    (
			    SELECT
			        COUNT(*)
			    FROM
			        ordenes
			    WHERE
			        ordenes.locativo = 'true' AND EXTRACT(
			            YEAR_MONTH
			        FROM
			            (CASE WHEN ordenes.fecha_fin IS NULL THEN ordenes.fecha_asignacion_cierre ELSE ordenes.fecha_fin END)
			        ) = EXTRACT(YEAR_MONTH
			    FROM
			        (CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin END))
			) AS cantidad_locativo,
				    CONCAT(
				        YEAR(o.fecha_fin),
				        '(',
				        MONTH(o.fecha_fin),
				        ')'
				    ) AS mes,
				    COUNT(*) AS cantidad
				FROM
				    ordenes o
				WHERE
				    o.subproceso_id LIKE '%" . $param["subproceso_id"] . "%' AND (
				    CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin
				    END
				) IS NOT NULL
				GROUP BY
				    YEAR(
				        CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin
				    END
				) ,
				MONTH(
				    CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin
				END
				)
				ORDER BY
				    YEAR(
				        CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin
				    END
				) ASC,
				MONTH(
				    CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin
				END
				) ASC
		";
    return $this->db->query($query)->result();
  }
  public function getByStatus($param)
  {
    $query = "
			SELECT
			    es.descripcion AS estado,
			    COUNT(*) AS cantidad
			FROM
			    ordenes o
			LEFT JOIN estados es ON
			    es.id = o.estado_id
			    WHERE o.subproceso_id LIKE '%" . $param["subproceso_id"] . "%'
				GROUP BY
			    es.descripcion
				ORDER BY
			    es.descripcion ASC
		";
    return $this->db->query($query)->result();
  }
  public function getTicketsIndicador($param)
  {
    $query = "
			SELECT

			CONCAT(
			    YEAR(o.fecha_inicio),
			    '(',
			    MONTH(o.fecha_inicio),
			    ')'
			) AS mes,
			(
			    (
			    SELECT
			        COUNT(*)
			    FROM
			        ordenes ORD
			    WHERE
			    ORD.subproceso_id LIKE '%" . $param["subproceso_id"] . "%' AND
			        CONCAT(
			            YEAR(
			                CASE WHEN ORD.fecha_fin IS NULL THEN ORD.fecha_asignacion_cierre ELSE ORD.fecha_fin
			            END
			        ),
			        '(',
			        MONTH(
			            CASE WHEN ORD.fecha_fin IS NULL THEN ORD.fecha_asignacion_cierre ELSE ORD.fecha_fin
			        END
			),
			')'
			) = CONCAT(
			    YEAR(o.fecha_inicio),
			    '(',
			    MONTH(o.fecha_inicio),
			    ')'
			)
			) / COUNT(*)
			) * 100 AS porcentaje_cerrados,

			((SELECT COUNT(*) FROM ordenes WHERE ordenes.electrico = 'true' AND EXTRACT(YEAR_MONTH FROM ordenes.fecha_inicio ) = EXTRACT(YEAR_MONTH FROM o.fecha_inicio))/(SELECT COUNT(*) FROM ordenes WHERE ordenes.electrico = 'true' AND  EXTRACT(YEAR_MONTH FROM (CASE WHEN ordenes.fecha_fin IS NULL THEN ordenes.fecha_asignacion_cierre ELSE ordenes.fecha_fin END)) =  EXTRACT(YEAR_MONTH FROM (CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin END))))*100 as porcentaje_electricos,

			((SELECT COUNT(*) FROM ordenes WHERE ordenes.mecanico = 'true' AND EXTRACT(YEAR_MONTH FROM ordenes.fecha_inicio ) = EXTRACT(YEAR_MONTH FROM o.fecha_inicio))/(SELECT COUNT(*) FROM ordenes WHERE ordenes.mecanico = 'true' AND  EXTRACT(YEAR_MONTH FROM (CASE WHEN ordenes.fecha_fin IS NULL THEN ordenes.fecha_asignacion_cierre ELSE ordenes.fecha_fin END)) =  EXTRACT(YEAR_MONTH FROM (CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin END))))*100 as porcentaje_mecanicos,
			((SELECT COUNT(*) FROM ordenes WHERE ordenes.locativo = 'true' AND EXTRACT(YEAR_MONTH FROM ordenes.fecha_inicio ) = EXTRACT(YEAR_MONTH FROM o.fecha_inicio))/(SELECT COUNT(*) FROM ordenes WHERE ordenes.locativo = 'true' AND  EXTRACT(YEAR_MONTH FROM (CASE WHEN ordenes.fecha_fin IS NULL THEN ordenes.fecha_asignacion_cierre ELSE ordenes.fecha_fin END)) =  EXTRACT(YEAR_MONTH FROM (CASE WHEN o.fecha_fin IS NULL THEN o.fecha_asignacion_cierre ELSE o.fecha_fin END))))*100 as porcentaje_locativos

			FROM
			    ordenes o
			    WHERE o.subproceso_id LIKE '%" . $param["subproceso_id"] . "%'
			GROUP BY
			    YEAR(o.fecha_inicio) ,
			    MONTH(o.fecha_inicio)
			ORDER BY
			    YEAR(o.fecha_inicio) ASC,
			    MONTH(o.fecha_inicio) ASC
		";
    return $this->db->query($query)->result();
  }
  public function cuenta_registros_repuestos_pendientes($param)
  {
    $query = "
		SELECT
		COUNT(*) AS total
		FROM
		ordenes
		WHERE
		ordenes.equipo_id = " . $param . "
		and repuesto_pendiente_condicion='si'
		";
    return $this->db->query($query)->row();
  }
}
