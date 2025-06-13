<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
class Mequipos extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mequipos");
  }
  public function get_devices($limit, $offset){
    $this->db->limit($limit, $offset);
    $query = $this->db->get("equipos");
    if($query->num_rows() > 0){
      return $query->result_array();
    }
    else{
      return null;
    }
  }

  public function get_device($id){
    $this->db->select('equipos.*,servicios.name as service');
    $this->db->from('equipos');
    $this->db->join('servicios','equipos.servicio_id = servicios.id');
    $this->db->where("equipos.id", $id);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->row();
    }
    else{
      return null;
    }
  }


  public function guardar_texto($param)
  {
    return $this->db->insert("pruebas", $param);
  }
  public function get_some()
  {
    $this->db->select("e.name as nombre,e.serial as serie,e.code as codigo,e.marca as marca, e.modelo as modelo, s.name as servicio, a.name as area, sed.name as sede");
    $this->db->from("equipos e");
    $this->db->join("servicios s", "s.id=e.servicio_id", "left");
    $this->db->join("areas a", "a.id=e.area_id", "left");
    $this->db->join("sedes sed", "sed.id=s.sede_id", "left");
    $this->db->where("e.tipo_id=1");
    $this->db->where("e.estadoequipo_id!=6");
    return $this->db->get()->result();
  }

  public function getCantidades()
  {
    $this->db->select("*");
    $this->db->from("equipos_indicador");
    return $this->db->get()->result();
  }
  public function getForGoogle()
  {
    $this->db->select("equipos.*,equipos.code as codigo,equipos.codigo_antiguo as codigoa,servicios.name as servicio, areas.name as area, sedes.name as sede,estadoequipos.name as estado,(SELECT mantenimiento.fecha_mantenimiento FROM mantenimiento WHERE mantenimiento.equipo_id=equipos.id ORDER BY fecha_mantenimiento DESC LIMIT 1) AS fecha_mantenimiento,(SELECT mantenimiento.description FROM mantenimiento WHERE mantenimiento.equipo_id=equipos.id ORDER BY fecha_mantenimiento DESC LIMIT 1) AS codigom");
    $this->db->from("equipos");
    $this->db->join("servicios", "equipos.servicio_id=servicios.id", "left");
    $this->db->join("areas", "equipos.area_id=areas.id", "left");
    $this->db->join("sedes", "servicios.sede_id=sedes.id", "left");
    $this->db->join("estadoequipos", "equipos.estadoequipo_id=estadoequipos.id", "left");
    $this->db->where("tipo_id", 1);
    $resultado = $this->db->get();
    $vector = array(
      "num_rows" =>  $resultado->num_rows(),
      "data" => $resultado->result()
    );
    return $vector;
  }
  public function get_general($param)
  {
    $this->db->select("equipos.*,servicios.name as servicio, areas.name as area,(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id) as numero_especificaciones");
    $this->db->from("equipos");
    $this->db->join("servicios", "servicios.id=equipos.servicio_id", "left");
    $this->db->join("areas", "areas.id=equipos.area_id", "left");
    $this->db->where("equipos.id!=", $param);
    $this->db->where("equipos.tipo_id=", $this->session->userdata("tipo_id"));
    return $this->db->get()->result();
  }
  public function get_equipos_for_ticket()
  {
    $this->db->select("equipos.*,servicios.name as servicio, areas.name as area,(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id) as numero_especificaciones");
    $this->db->from("equipos");
    $this->db->join("servicios", "servicios.id=equipos.servicio_id", "left");
    $this->db->join("areas", "areas.id=equipos.area_id", "left");
    return $this->db->get()->result();
  }
  public function get_para_copiar_archivos($param)
  {
    $query = "
			SELECT
			    equipos.*,
			    servicios.name AS servicio,
			    areas.name AS area,
			    sedes.name AS sede,
			    oc.orden AS soporte_compra,
			    contacto.name AS proveedor
			FROM
			    equipos
			LEFT JOIN servicios ON servicios.id = equipos.servicio_id
			LEFT JOIN areas ON areas.id = equipos.area_id
			LEFT JOIN sedes ON sedes.id = servicios.sede_id
			LEFT JOIN ordenes_compra oc ON oc.id = equipos.orden_compra_id
			LEFT JOIN contacto ON contacto.id=oc.proveedor_id
			WHERE
			(SELECT count(*) from equipo_archivo where equipo_id=equipos.id and vinculo=(SELECT vinculo from equipo_archivo where id= " . $param . "))=0
			ORDER BY
			    equipos.name ASC
			";
    return $this->db->query($query)->result();
  }
  public function get_general_server_side($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }
    $query = "
		SELECT equipos.*,servicios.name as servicio, areas.name as area
		FROM equipos
		LEFT join servicios ON servicios.id=equipos.servicio_id
		LEFT join areas ON areas.id=equipos.area_id
		WHERE
		equipos.status !=0 AND
		equipos.tipo_id = " . $param["tipo_id"] . " AND
		";
    if ((isset($param["sede_id"])) && (($param["sede_id"]) != 0) && (($param["sede_id"] != ""))) {
      $query .= "servicios.sede_id = '" . $param["sede_id"] . "' AND ";
    }
    if (($param["servicio_id"]) != 0 && ($param["servicio_id"] != "")) {
      $query .= "servicios.id = '" . $param["servicio_id"] . "' AND ";
    }
    if (($param["area_id"]) != 0 && ($param["area_id"] != "")) {
      $query .= "areas.id = '" . $param["area_id"] . "' AND ";
    }

    $query .= "
		(
		equipos.name LIKE  '%" . $param["search"]["value"] . "%' OR
		equipos.marca LIKE '%" . $param["search"]["value"] . "%' OR
		servicios.name LIKE '%" . $param["search"]["value"] . "%' OR
		areas.name LIKE '%" . $param["search"]["value"] . "%' OR
		equipos.modelo LIKE '%" . $param["search"]["value"] . "%' OR
		equipos.code LIKE '%" . $param["search"]["value"] . "%' OR
		equipos.codigo_antiguo LIKE '%" . $param["search"]["value"] . "%' OR
		equipos.serial LIKE '%" . $param["search"]["value"] . "%'
		)
		ORDER BY equipos.name ASC, equipos.id ASC
		";
    $limitar = ' LIMIT ' . $param["start"] . ',' . $param["length"] . '';
    $resultl = $this->db->query($query . $limitar);
    $numero_filas_con_limite = $resultl->num_rows();
    $resultado_con_limite = $resultl->result();
    $resultsl = $this->db->query($query);
    $numero_filas_sin_limite = $resultsl->num_rows();
    $vector = array(
      "datos" => $resultado_con_limite,
      "num_filas_limit" => $numero_filas_con_limite,
      "num_filas" => $numero_filas_sin_limite
    );
    return $vector;
  }
  public function get_server_side_filtros($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }
    if (isset($_POST)) {

      $query = "
		SELECT
		equipos.invima_id as invima_id,
		equipos.localizacion_actual as localizacion_actual,
		equipos.propietario_id as propietario_id,
		bajas.fecha_baja as fecha_baja,
		equipos.tipo_id as tipo_id,
		invimas.invima as registro_sanitario,
		invimas.file as archivo_registro_sanitario,
		equipos.repuesto_pendiente as repuesto_pendiente,
		YEAR(equipos.fecha_ad) as anio,
		(select observaciones.description from observaciones where observaciones.equipo_id=equipos.id order by observaciones.id desc limit 1) as ultima_observacion,
		(select observaciones.created_at from observaciones where observaciones.equipo_id=equipos.id order by observaciones.id desc limit 1) as fecha_ultima_observacion,

		(select fecha_inicio from correctivos_generales where correctivos_generales.equipo_id=equipos.id and correctivos_generales.fecha_inicio is not null and fecha_inicio!='0000-00-00 00:00:00' and fecha_inicio!='' order by correctivos_generales.fecha_inicio desc limit 1)as fecha_inicio_correctivo_general,

		(select orden from correctivos_generales where correctivos_generales.equipo_id=equipos.id and correctivos_generales.fecha_inicio is not null and fecha_inicio!='0000-00-00 00:00:00' and fecha_inicio!='' order by correctivos_generales.fecha_inicio desc limit 1)as orden,

		(select fecha_mantenimiento from correctivos_generales where correctivos_generales.equipo_id=equipos.id and correctivos_generales.fecha_mantenimiento is not null and fecha_mantenimiento!='0000-00-00 00:00:00' and fecha_mantenimiento!='' order by correctivos_generales.fecha_mantenimiento desc limit 1)as fecha_ultimo_correctivo,

		(select description from correctivos_generales where correctivos_generales.equipo_id=equipos.id and correctivos_generales.fecha_mantenimiento is not null and fecha_mantenimiento!='0000-00-00 00:00:00' and fecha_mantenimiento!='' order by correctivos_generales.fecha_mantenimiento desc limit 1)as descripcion_ultimo_correctivo_general,

		(select  CASE when(planes_mantenimientos.mes1=1) then 'enero' when(planes_mantenimientos.mes1=2) then 'febrero' when(planes_mantenimientos.mes1=3) then 'marzo' when(planes_mantenimientos.mes1=4) then 'abril' when(planes_mantenimientos.mes1=5) then 'mayo' when(planes_mantenimientos.mes1=6) then 'junio' when(planes_mantenimientos.mes1=7) then 'julio' when(planes_mantenimientos.mes1=8) then 'agosto' when(planes_mantenimientos.mes1=9) then 'septiembre' when(planes_mantenimientos.mes1=10) then 'octubre' when(planes_mantenimientos.mes1=11) then 'noviembre' when(planes_mantenimientos.mes1=12) then 'diciembre' else ''  end from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id and anio=" . $_POST["anio_plan"] . " order by planes_mantenimientos.anio desc limit 1)as preventivo_mes1,
		(select  CASE when(planes_mantenimientos.mes2=1) then 'enero' when(planes_mantenimientos.mes2=2) then 'febrero' when(planes_mantenimientos.mes2=3) then 'marzo' when(planes_mantenimientos.mes2=4) then 'abril' when(planes_mantenimientos.mes2=5) then 'mayo' when(planes_mantenimientos.mes2=6) then 'junio' when(planes_mantenimientos.mes2=7) then 'julio' when(planes_mantenimientos.mes2=8) then 'agosto' when(planes_mantenimientos.mes2=9) then 'septiembre' when(planes_mantenimientos.mes2=10) then 'octubre' when(planes_mantenimientos.mes2=11) then 'noviembre' when(planes_mantenimientos.mes2=12) then 'diciembre' else ''  end from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id and anio=" . $_POST["anio_plan"] . " order by planes_mantenimientos.anio desc limit 1)as preventivo_mes2,
		(select  CASE when(planes_mantenimientos.mes3=1) then 'enero' when(planes_mantenimientos.mes3=2) then 'febrero' when(planes_mantenimientos.mes3=3) then 'marzo' when(planes_mantenimientos.mes3=4) then 'abril' when(planes_mantenimientos.mes3=5) then 'mayo' when(planes_mantenimientos.mes3=6) then 'junio' when(planes_mantenimientos.mes3=7) then 'julio' when(planes_mantenimientos.mes3=8) then 'agosto' when(planes_mantenimientos.mes3=9) then 'septiembre' when(planes_mantenimientos.mes3=10) then 'octubre' when(planes_mantenimientos.mes3=11) then 'noviembre' when(planes_mantenimientos.mes3=12) then 'diciembre' else ''  end from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id and anio=" . $_POST["anio_plan"] . " order by planes_mantenimientos.anio desc limit 1)as preventivo_mes3,
		(select responsable from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id and anio=" . $_POST["anio_plan"] . " order by planes_mantenimientos.anio desc limit 1)as preventivo_responsable,

		(select count(*) from planes_mantenimientos where equipo_id=equipos.id and anio=" . $_POST["anio_plan"] . " limit 1)as cuenta_planes_mantenimientos,


		(select file from mantenimiento where equipos.id=mantenimiento.equipo_id order by fecha_mantenimiento desc limit 1)as archivo_ultimo_mantenimiento,

		(select fecha_calibracion from calibracion where calibracion.equipo_id=equipos.id order by fecha_calibracion desc limit 1)as ultima_calibracion,

		(select file from calibracion where equipos.id=calibracion.equipo_id order by fecha_calibracion desc limit 1)as archivo_ultima_calibracion,

		(select fecha_mantenimiento from correctivos_generales where correctivos_generales.equipo_id=equipos.id order by fecha_mantenimiento desc limit 1) as ultimo_correctivo,

		(select fecha_inicio from ordenes o where o.equipo_id=equipos.id order by o.fecha_inicio desc limit 1) as fecha_inicio_ultimo_ticket,
		(select descripcion from ordenes o where o.equipo_id=equipos.id order by o.fecha_inicio desc limit 1) as descripcion_ultimo_ticket,
		(select fecha_fin from ordenes o where o.equipo_id=equipos.id order by o.fecha_fin desc limit 1) as fecha_fin_ultimo_ticket,
		(select reparacion from ordenes o where o.equipo_id=equipos.id order by o.fecha_fin desc limit 1) as descripcion_cierre_ultimo_ticket,

		(select fecha_mantenimiento from mantenimiento where mantenimiento.equipo_id=equipos.id order by fecha_mantenimiento desc limit 1 )as ultimo_mantenimiento,

		(select count(*) from equipo_archivo ea where ea.equipo_id=equipos.id AND ea.archivo_id!=9 limit 1)as cuenta_archivos,

		(select count(*) from equipo_archivo ea where ea.equipo_id=equipos.id AND ea.archivo_id=9 limit 1)as cuenta_archivos_capacitaciones,

		(select count(*) from mantenimiento where mantenimiento.equipo_id=equipos.id limit 1) as cuenta,

		(select count(*) from calibracion where equipo_id=equipos.id limit 1) as cuenta_calibracion,

		equipos.id as id,
		equipos.name as name,
		equipos.descripcion as descripcion,
		equipos.code as code,
		equipos.serial as serial,
		equipos.marca as marca,
		equipos.modelo as modelo,
		equipos.verificacion_inventario as verificacion_inventario,
		equipos.estado_mantenimiento as estado_mantenimiento,
		equipos.image as image,
		equipos.observacion as observacion,
		equipos.guia_id as guia_id,
		equipos.manual_id as manual_id,
		servicios.name as servicios,
		frecuenciam.name as frecuencias,
		pisos.name as pisos,
		pisos_areas.name as pisos_areas,
		disponibilidades.name as disponibilidad,
		estadoequipos.name as estadoequipo,
		estadoequipos.color as color_estado,
		equipos.orden_compra_id as orden_compra_id,
		ordenes_compra.orden as orden_compra,
		ordenes_compra.file as orden_compra_file,
		ordenes_compra.url_secop as url_secop,
		tipos_compra.tipo_compra as tipo_compra,
		equipos.baja_id as baja_id,
		bajas.archivo as file_baja,
		areas.name as area,
		(SELECT COUNT(*) from cambios_ubicaciones WHERE equipo_id=equipos.id)as movimiento,
		estadosm.name as estado_del_mantenimiento,
		zonas.name as zona,
		sedes.name as sede,
		(SELECT COUNT(*) FROM contingencias where contingencias.equipo_id=equipos.id) as cantidad_contingencias,
		gr.name as guia_nombre,
		gr.file as guia_file,
		man.descripcion as manual_descripcion,
		man.url as manual_url,
		pro.nombre as propietario,
		pro.logo as propietario_logo,
		(SELECT fm.name FROM planes_mantenimientos pm LEFT JOIN frecuenciam fm ON fm.id=pm.frecuencia_id WHERE pm.equipo_id=equipos.id AND pm.anio=(SELECT anio FROM vigencias_mantenimiento)) AS frecuencia_cronograma,
		(SELECT pm.mes1 FROM planes_mantenimientos pm WHERE pm.equipo_id=equipos.id AND pm.anio=(SELECT anio FROM vigencias_mantenimiento)) AS mes_programado1,
		(SELECT pm.mes2 FROM planes_mantenimientos pm WHERE pm.equipo_id=equipos.id AND pm.anio=(SELECT anio FROM vigencias_mantenimiento)) AS mes_programado2
		FROM equipos

		LEFT JOIN servicios on servicios.id=equipos.servicio_id
		LEFT JOIN frecuenciam on frecuenciam.id=equipos.frecuencia_id
		LEFT JOIN zonas on zonas.id=servicios.zona_id
		LEFT JOIN estadoequipos on estadoequipos.id=equipos.estadoequipo_id
		LEFT JOIN estadoequipos disponibilidades on disponibilidades.id=equipos.disponibilidad_id
		LEFT JOIN pisos on pisos.id=servicios.piso_id
		LEFT JOIN ordenes_compra on ordenes_compra.id=equipos.orden_compra_id
		LEFT JOIN tipos_compra on tipos_compra.id=ordenes_compra.tipo_compra_id
		LEFT JOIN bajas on bajas.id=equipos.baja_id
		LEFT JOIN sedes on sedes.id=servicios.sede_id
		LEFT JOIN areas on areas.id=equipos.area_id
		LEFT JOIN pisos pisos_areas on pisos_areas.id=areas.piso_id
		LEFT JOIN invimas on invimas.id=equipos.invima_id
		LEFT JOIN estadosm on estadosm.id=equipos.estado_mantenimiento
		LEFT JOIN guias_rapidas gr on gr.id=equipos.guia_id
		LEFT JOIN manuales man on man.id=equipos.manual_id
		LEFT JOIN propietarios pro on pro.id=equipos.propietario_id
";
      if ($param["consulta_id"] != "") {
        $query .= " WHERE equipos.id= " . $param["consulta_id"] . " AND equipos.tipo_id=" . $this->session->userdata("tipo_id");
      } else {
        $query .= "
			WHERE
			servicios.sede_id like'%" . $param["sede_id"] . "%' AND
			equipos.status !=0 AND
			equipos.tipo_id=" . $this->session->userdata("tipo_id") . " AND  ";

        if ($param["estado_id"] != "") {
          $query .= "(SELECT COUNT(*) from ordenes o where o.equipo_id=equipos.id and o.estado_id = '" . $param["estado_id"] . "')>0 AND ";
        }
        if ($param["cierre_id"] != "") {
          $query .= "(SELECT COUNT(*) FROM correctivos_generales cg where cg.equipo_id=equipos.id AND cg.cierre_id = '" . $param["cierre_id"] . "') >0 AND ";
        }
        if (isset($param["servicio_id"])) {
          if ($param["servicio_id"] != "" && $param["servicio_id"] != null && $param["servicio_id"] != 0) {
            $query .= "servicios.id = " . $param["servicio_id"] . " AND ";
          }
        }
        if (isset($param["area_id"])) {
          if ($param["area_id"] != "" && $param["area_id"] != null && $param["area_id"] != 0) {
            $query .= "areas.id = " . $param["area_id"] . " AND ";
          }
        }
        if ($param["proveedor_mantenimiento"] != null and $param["proveedor_mantenimiento"] != "")
          $query .= "(SELECT responsable from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id and anio=" . $param["anio_plan"] . " order by planes_mantenimientos.anio desc limit 1)LIKE '%" . $param["proveedor_mantenimiento"] . "%' AND ";
        if (!empty($param['search']['value'])) {
          $query .= "
				equipos.name LIKE '%" . $param["filtro_name"] . "%' AND
				equipos.marca LIKE '%" . $param["filtro_marca"] . "%' AND
				equipos.modelo LIKE '%" . $param["filtro_modelo"] . "%' AND
				equipos.serial LIKE '%" . $param["filtro_serial"] . "%' AND
				zonas.id LIKE '%" . $param["filtro_zona"] . "%' AND
				equipos.estado_mantenimiento LIKE '%" . $param["filtro_estadom"] . "%' AND
				equipos.estadoequipo_id LIKE '%" . $param["filtro_estadoequipo_id"] . "%' AND
				equipos.tadquisicion_id LIKE '%" . $param["filtro_tadquisicion_id"] . "%' AND
				(
				equipos.name LIKE  '%" . $param["search"]["value"] . "%' OR
				equipos.marca LIKE '%" . $param["search"]["value"] . "%' OR
				servicios.name LIKE '%" . $param["search"]["value"] . "%' OR
				areas.name LIKE '%" . $param["search"]["value"] . "%' OR
				equipos.modelo LIKE '%" . $param["search"]["value"] . "%' OR
				equipos.code LIKE '%" . $param["search"]["value"] . "%' OR
				equipos.codigo_antiguo LIKE '%" . $param["search"]["value"] . "%' OR
				equipos.serial LIKE '%" . $param["search"]["value"] . "%' OR
				equipos.descripcion LIKE '%" . $param["search"]["value"] . "%'
				)
				";
        } else {

          $query .= "
				equipos.name LIKE '%" . $param["filtro_name"] . "%' AND
				equipos.marca LIKE '%" . $param["filtro_marca"] . "%' AND
				equipos.modelo LIKE '%" . $param["filtro_modelo"] . "%' AND
				equipos.serial LIKE '%" . $param["filtro_serial"] . "%' AND
				zonas.id LIKE '%" . $param["filtro_zona"] . "%' AND
				equipos.estado_mantenimiento LIKE '%" . $param["filtro_estadom"] . "%' AND
				equipos.tadquisicion_id LIKE '%" . $param["filtro_tadquisicion_id"] . "%' AND
				equipos.estadoequipo_id LIKE '%" . $param["filtro_estadoequipo_id"] . "%' 
			";
        }
      }
      $columnas = array(
        0 => "equipos.name",
        1 => "equipos.id",
        2 => "servicios.name",
        3 => "ultimo_mantenimiento"
      );
      $columna = $param["order"][0]["column"];
      $dir = $param["order"][0]["dir"];
      $ordenar = " ORDER BY " . $columnas[$columna] . " " . $dir;
      $limitar = ' LIMIT ' . $param["start"] . ',' . $param["length"] . '';

      $resultl = $this->db->query($query . $ordenar . $limitar);
      $numero_filas_con_limite = $resultl->num_rows();
      $resultado_con_limite = $resultl->result();

      $resultsl = $this->db->query($query);
      $numero_filas_sin_limite = $resultsl->num_rows();

      $vector = array(
        "datos" => $resultado_con_limite,
        "num_filas_limit" => $numero_filas_con_limite,
        "num_filas" => $numero_filas_sin_limite
      );
      return $vector;
    }
  }
  public function get()
  {
    $this->db->select("equipos.*");
    $this->db->from("equipos");
    return $this->db->where("equipos.tipo_id=", $this->session->userdata("tipo_id"))->get()->result();
  }
  public function getAll()
  {
    $this->db->select("equipos.*");
    $this->db->from("equipos");
    return $this->db->where("equipos.tipo_id=", $this->session->userdata("tipo_id"))->get()->result();
  }
  public function getForCOntingencias()
  {
    $query = "
		SELECT
		    *
		FROM
		    equipos eq
		WHERE
		    eq.tipo_id = 1
		ORDER BY
		    eq.id ASC
		";

    return $this->db->query($query)->result();
  }
  public function getPorCompra()
  {
    $this->db->select("equipos.*,servicios.name as servicio");
    $this->db->from("equipos");
    $this->db->join("servicios", "servicios.id=equipos.servicio_id", "left");
    $this->db->where("equipos.tadquisicion_id=2 OR equipos.tadquisicion_id=3 OR equipos.tadquisicion_id=4");
    return $this->db->get()->result();
  }
  public function add($param)
  {
    return $this->db->insert("equipos", $param);
  }
  public function copy($param)
  {
    $this->db->insert("equipos", $param);
    return $this->db->insert_id();
  }
  public function update($param)
  {
    $this->db->where('id', $param['id']);
    unset($param['id']);
    $this->db->update("equipos", $param);
  }
  public function getOneWithTipe($param)
  {
    $this->db->where("id=" . $param["id"] . " AND tipo_id=" . $this->session->userdata("tipo_id"));
    return $this->db->get("equipos")->row();
  }
  public function getOne($param)
  {
    $this->db->select('
			equipos.*,
			(SELECT CONCAT("$",(SELECT FORMAT(equipos.costo,2)))) as costo,
			equipos.costo as costo_original,
			centros.code as centro,
			servicios.name as servicios,
			fuenteal.name as fuentes,
			tecnologiap.name as tecnologias,
			frecuenciam.name as frecuencias,
			cbiomedica.name as clasificaciones,
			criesgo.name as criesgos,
			pisos.name as pisos,
			pisos_areas.name as pisos_areas,
			tadquisicion.name as adquisiciones,
			monthname(equipos.fecha_mantenimiento) as mes,
			estadoequipos.name as estadoequipos,
			periodos_garantias.name as garantias,
			(select DATE_ADD(equipos.fecha_ad,interval case when(equipos.garantia=1) then 12 when(equipos.garantia=2) then 24 when(equipos.garantia=3) then 25 when(equipos.garantia=4) then 6 when(equipos.garantia=5) then 36 when(equipos.garantia=7) then 18 when(equipos.garantia=6) then 48 end month))as fecha_vencimiento_garantia,
			invimas.invima as registro_sanitario,
			invimas.file as file_registro_sanitario,
			invimas.description as registro_sanitario_descripcion,
			invimas.id as registro_sanitario_id,
			ordenes_compra.orden as orden_compra,
			ordenes_compra.file as file_orden_compra,
			guias_rapidas.name as name_guia,
			guias_rapidas.file as file_guia,
			manuales.descripcion as manual_descripcion,
			manuales.url as manual_url,
			ordenes_compra.tipo_compra_id as tipo_compra_id,
			sedes.id as sede_id,
			areas.name as area,
			propietarios.nombre as propietario,
			propietarios.logo as propietario_logo,
		(select  CASE when(mes1=1) then "enero" when(mes1=2) then "febrero" when(mes1=3) then "marzo" when(mes1=4) then "abril" when(mes1=5) then "mayo" when(mes1=6) then "junio" when(mes1=7) then "julio" when(mes1=8) then "agosto" when(mes1=9) then "septiembre" when(mes1=10) then "octubre" when(mes1=11) then "noviembre" when(mes1=12) then "diciembre" else ""  end from planes_mantenimientos where planes_mantenimientos.equipo_id=' . $param["id"] . ' and anio=' . $this->session->userdata("anio_plan") . ' order by planes_mantenimientos.anio desc limit 1)as preventivo_mes1,
		(select  CASE when(mes2=1) then "enero" when(mes2=2) then "febrero" when(mes2=3) then "marzo" when(mes2=4) then "abril" when(mes2=5) then "mayo" when(mes2=6) then "junio" when(mes2=7) then "julio" when(mes2=8) then "agosto" when(mes2=9) then "septiembre" when(mes2=10) then "octubre" when(mes2=11) then "noviembre" when(mes2=12) then "diciembre" else ""  end from planes_mantenimientos where planes_mantenimientos.equipo_id=' . $param["id"] . ' and anio=' . $this->session->userdata("anio_plan") . ' order by planes_mantenimientos.anio desc limit 1)as preventivo_mes2,
		(select  CASE when(mes3=1) then "enero" when(mes3=2) then "febrero" when(mes3=3) then "marzo" when(mes3=4) then "abril" when(mes3=5) then "mayo" when(mes3=6) then "junio" when(mes3=7) then "julio" when(mes3=8) then "agosto" when(mes3=9) then "septiembre" when(mes3=10) then "octubre" when(mes3=11) then "noviembre" when(mes3=12) then "diciembre" else ""  end from planes_mantenimientos where planes_mantenimientos.equipo_id=' . $param["id"] . ' and anio=' . $this->session->userdata("anio_plan") . ' order by planes_mantenimientos.anio desc limit 1)as preventivo_mes3,
		(select count(*) from planes_mantenimientos where equipo_id=' . $param["id"] . ' and anio=' . $this->session->userdata("anio_plan") . ')as cuenta_planes_mantenimientos,
		(select count(*) from mantenimiento where equipo_id=' . $param["id"] . ')as cuenta_preventivos,
		(select YEAR(fecha_mantenimiento) from mantenimiento where equipo_id=' . $param["id"] . ' order by fecha_mantenimiento desc limit 1)as anio_ultimo_preventivo,
		bajas.descripcion as baja,
		bajas.archivo as baja_documento,
		bajas.fecha_baja as baja_fecha,
		(SELECT pm.mes1 FROM planes_mantenimientos pm WHERE pm.equipo_id=' . $param["id"] . ' AND pm.anio=(SELECT anio FROM vigencias_mantenimiento)) AS mes_programado1,
		(SELECT pm.mes2 FROM planes_mantenimientos pm WHERE pm.equipo_id=' . $param["id"] . ' AND pm.anio=(SELECT anio FROM vigencias_mantenimiento)) AS mes_programado2
			');
    $this->db->from('equipos');
    $this->db->join('servicios', 'equipos.servicio_id=servicios.id', 'left');
    $this->db->join('centros', 'servicios.centro_id=centros.id', 'left');
    $this->db->join('bajas', 'equipos.baja_id=bajas.id', 'left');
    $this->db->join('fuenteal', 'equipos.fuente_id=fuenteal.id', 'left');
    $this->db->join('tecnologiap', 'equipos.tecnologia_id=tecnologiap.id', 'left');
    $this->db->join('frecuenciam', 'equipos.frecuencia_id=frecuenciam.id', 'left');
    $this->db->join('cbiomedica', 'equipos.cbiomedica_id=cbiomedica.id', 'left');
    $this->db->join('criesgo', 'equipos.criesgo_id=criesgo.id', 'left');
    $this->db->join('tadquisicion', 'equipos.tadquisicion_id=tadquisicion.id', 'left');
    $this->db->join('pisos', 'servicios.piso_id=pisos.id', 'left');
    $this->db->join('estadoequipos', 'estadoequipos.id=equipos.estadoequipo_id', 'left');
    $this->db->join('periodos_garantias', 'periodos_garantias.id=equipos.garantia', 'left');
    $this->db->join('invimas', 'invimas.id=equipos.invima_id', 'left');
    $this->db->join('ordenes_compra', 'ordenes_compra.id=equipos.orden_compra_id', 'left');
    $this->db->join('guias_rapidas', 'guias_rapidas.id=equipos.guia_id', 'left');
    $this->db->join('manuales', 'manuales.id=equipos.manual_id', 'left');
    $this->db->join('propietarios', 'propietarios.id=equipos.propietario_id', 'left');
    $this->db->join('sedes', 'sedes.id=servicios.sede_id', 'left');
    $this->db->join('areas', 'areas.id=equipos.area_id', 'left');
    $this->db->join('pisos pisos_areas', 'pisos_areas.id=areas.piso_id', 'left');
    $this->db->where('equipos.id=' . $param["id"]);
    return $this->db->get()->row();
  }
  public function getMantenimientos($id)
  {
    $query = $this->db->select('*')
      ->from('mantenimiento')
      ->where('equipo_id', $id)
      ->get();
    return $query->result();
  }
  public function getMantenimientosAllBaxter()
  {
    $this->db->select("equipos.*,mantenimiento.description as codigo, mantenimiento.fecha_mantenimiento as fecha_ejecucion,mantenimiento.fecha_programada as fecha_programada");
    $this->db->from("equipos");
    $this->db->join("mantenimiento", "mantenimiento.equipo_id=equipos.id");
    $this->db->where("equipos.status=1 and (equipos.name like '%bomba de%' or equipos.name like '%infusion%' or equipos.name like '%nutricion%') and equipos.name not like'%vacio%' ");
    $this->db->order_by("mantenimiento.fecha_mantenimiento", "asc");
    return $this->db->get()->result();
  }
  public function getCalibraciones($id)
  {
    $query = $this->db->select('*')
      ->from('calibracion')
      ->where('equipo_id', $id)
      ->get();
    return $query->result();
  }
  public function getObsoletosModal()
  {
    $this->db->select("equipos.*,servicios.name as ubicacion,TIMESTAMPDIFF(YEAR,fecha_ad,NOW()) AS anios");
    $this->db->from("equipos");
    $this->db->join("servicios", "servicios.id=equipos.servicio_id", "left");
    $this->db->where("(TIMESTAMPDIFF(YEAR,fecha_instalacion,NOW())>5 or TIMESTAMPDIFF(YEAR,fecha_ad,NOW())>6) AND equipos.tipo_id=" . $this->session->userdata("tipo_id"));
    return $this->db->get()->result();
  }
  public function getFiltered($param)
  {

    $select = '
		group_concat(contacto.name,"-",tcontacto.description SEPARATOR "///") as informacion_contacto,

		(select correctivos_generales.description from correctivos_generales where correctivos_generales.equipo_id=equipos.id order by correctivos_generales.fecha_mantenimiento desc limit 1)as descripcion_correctivo,

		(select max(fecha_mantenimiento) from correctivos_generales where correctivos_generales.equipo_id=equipos.id) as ultimo_correctivo,

		(select max(fecha_mantenimiento) from mantenimiento where mantenimiento.equipo_id=equipos.id )as ultimo_mantenimiento ,

		(select max(fecha_calibracion) from calibracion where calibracion.equipo_id=equipos.id )as ultima_calibracion,

		(select count(*) from mantenimiento where equipo_id=equipos.id) as cuenta_preventivos,

		(select count(*) from calibracion where equipo_id=equipos.id) as cuenta_calibraciones,

		(select count(*) from correctivos_generales where equipo_id=equipos.id) as cuenta_correctivos,

		(select count(*) from ordenes where equipo_id = equipos.id) as cuenta_tickets,

		monthname(equipos.fecha_mantenimiento) as mes,
		equipos.*,
		bajas.fecha_baja as fecha_baja,
		servicios.name as servicios,
		fuenteal.name as fuentesal,
		tecnologiap.name as tecnologiasp,
		frecuenciam.name as frecuencias,
		cbiomedica.name as cbiomedicas,
		criesgo.name as criesgos,
		zonas.id as zona_id,zonas.name as zonas,
		pisos.name as pisos,
		estadosm.name as estadosm,
		tadquisicion.name as tadquisiciones,
		estadoequipos.name as estadoequipos,
		(select DATE_ADD(equipos.fecha_ad,interval case when(equipos.garantia=1) then 12 when(equipos.garantia=2) then 24 when(equipos.garantia=3) then 25 when(equipos.garantia=4) then 6 when(equipos.garantia=5) then 36 when(equipos.garantia=6) then 48 end month))as fecha_vencimiento_garantia,

		invimas.invima as registro_sanitario,
		ordenes_compra.orden as orden_compra,
		tipos_compra.tipo_compra as tipo_compra,
		sedes.name as sede,
		areas.name as area,
		proveedores.name as proveedor,
		propietarios.nombre as propietario,
		manuales.url as manual_url,
		(select responsable from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id order by anio desc limit 1)as proveedor_mantenimiento,
		(select anio from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id order by anio desc limit 1)as ultimo_anio_programado,
		(select CASE when(mes1=1) then "enero" when(mes1=2) then "febrero" when(mes1=3) then "marzo" when(mes1=4) then "abril" when(mes1=5) then "mayo" when(mes1=6) then "junio" when(mes1=7) then "julio" when(mes1=8) then "agosto" when(mes1=9) then "septiembre" when(mes1=10) then "octubre" when(mes1=11) then "noviembre" when(mes1=12) then "diciembre" else ""  end  from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id order by anio desc limit 1)as mes_programado_1,
		(select CASE when(mes2=1) then "enero" when(mes2=2) then "febrero" when(mes2=3) then "marzo" when(mes2=4) then "abril" when(mes2=5) then "mayo" when(mes2=6) then "junio" when(mes2=7) then "julio" when(mes2=8) then "agosto" when(mes2=9) then "septiembre" when(mes2=10) then "octubre" when(mes2=11) then "noviembre" when(mes2=12) then "diciembre" else "" end from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id order by anio desc limit 1)as mes_programado_2,
		(select CASE when(mes3=1) then "enero" when(mes3=2) then "febrero" when(mes3=3) then "marzo" when(mes3=4) then "abril" when(mes3=5) then "mayo" when(mes3=6) then "junio" when(mes3=7) then "julio" when(mes3=8) then "agosto" when(mes3=9) then "septiembre" when(mes3=10) then "octubre" when(mes3=11) then "noviembre" when(mes3=12) then "diciembre" else "" end from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id order by anio desc limit 1)as mes_programado_3,
		(SELECT frecuencia_usada.name FROM planes_mantenimientos left join frecuenciam frecuencia_usada on frecuencia_usada.id=planes_mantenimientos.frecuencia_id WHERE planes_mantenimientos.equipo_id=equipos.id order by planes_mantenimientos.anio desc limit 1) as frecuencia_utilizada
		';
    $this->db->select($select);
    $this->db->from('equipos');
    $this->db->join('servicios', 'equipos.servicio_id=servicios.id', 'left');
    $this->db->join('fuenteal', 'equipos.fuente_id=fuenteal.id', 'left');
    $this->db->join('tecnologiap', 'equipos.tecnologia_id=tecnologiap.id', 'left');
    $this->db->join('frecuenciam', 'equipos.frecuencia_id=frecuenciam.id', 'left');
    $this->db->join('cbiomedica', 'equipos.cbiomedica_id=cbiomedica.id', 'left');
    $this->db->join('zonas', 'servicios.zona_id=zonas.id', 'left');
    $this->db->join('pisos', 'servicios.piso_id=pisos.id', 'left');
    $this->db->join('estadosm', 'estadosm.value=equipos.estado_mantenimiento', 'left');
    $this->db->join("criesgo", "criesgo.id=equipos.criesgo_id", "left");
    $this->db->join("tadquisicion", "tadquisicion.id=equipos.tadquisicion_id", "left");
    $this->db->join("estadoequipos", "estadoequipos.id=equipos.estadoequipo_id", "left");
    $this->db->join('equipo_contacto', 'equipo_contacto.equipo_id=equipos.id', 'left');
    $this->db->join('contacto', 'contacto.id=equipo_contacto.contacto_id', 'left');
    $this->db->join('tcontacto', 'tcontacto.id=contacto.tcontacto_id', 'left');
    $this->db->join('invimas', 'invimas.id=equipos.invima_id', 'left');
    $this->db->join('ordenes_compra', 'ordenes_compra.id=equipos.orden_compra_id', 'left');
    $this->db->join('tipos_compra', 'tipos_compra.id=ordenes_compra.tipo_compra_id', 'left');
    $this->db->join('sedes', 'sedes.id=servicios.sede_id', 'left');
    $this->db->join('areas', 'areas.id=equipos.area_id', 'left');
    $this->db->join('contacto as proveedores', 'proveedores.id=ordenes_compra.proveedor_id', 'left');
    $this->db->join('bajas', 'bajas.id=equipos.baja_id', 'left');
    $this->db->join('propietarios', 'propietarios.id=equipos.propietario_id', 'left');
    $this->db->join('manuales', 'manuales.id=equipos.manual_id', 'left');

    $where = '
				equipos.status !=0 and
				equipos.tipo_id = ' . $this->session->userdata("tipo_id") . ' and
				equipos.name like"%' . $param["filtro_name"] . '%" and
				equipos.code like"%' . $param["filtro_code"] . '%" and
				equipos.marca like"%' . $param["filtro_marca"] . '%" and
				equipos.modelo like"%' . $param["filtro_modelo"] . '%" and
				equipos.serial like"%' . $param["filtro_serial"] . '%" and
				zonas.id like"%' . $param["filtro_zona"] . '%" and 
				equipos.estadoequipo_id like"%' . $param["filtro_estadoequipo_id"] . '%" and
				equipos.estado_mantenimiento like "%' . $param["filtro_estadom"] . '%"
				';
    $this->db->where($where);
    $this->db->group_by("equipos.id");
    $this->db->order_by("equipos.name", "asc");
    return $this->db->get()->result();
  }
  public function getLikeSerie($param)
  {
    $this->db->where("serial like '%" . $param["serial"] . "%' ");
    $this->db->limit(12);
    $this->db->order_by("name", "asc");
    return $this->db->get("equipos")->result();
  }
  public function getLikeCodigo($param)
  {
    $this->db->where("code like '%" . $param["code"] . "%' ");
    $this->db->limit(12);
    $this->db->order_by("name", "asc");
    return $this->db->get("equipos")->result();
  }
  public function updateFechasNull()
  {
    $query = "UPDATE equipos e SET e.fecha_inicio_operacion= NULL where e.fecha_inicio_operacion ='0000-00-00' OR e.fecha_inicio_operacion=''";
    $this->db->query($query);
    $query = "UPDATE equipos e SET e.fecha_recepcion_almacen= NULL where e.fecha_recepcion_almacen ='0000-00-00' OR e.fecha_recepcion_almacen=''";
    $this->db->query($query);
    $query = "UPDATE equipos e SET e.fecha_fabricacion= NULL where e.fecha_fabricacion ='0000-00-00' OR e.fecha_fabricacion=''";
    $this->db->query($query);
    $query = "UPDATE equipos e SET e.fecha_acta_recibo= NULL where e.fecha_acta_recibo ='0000-00-00' OR e.fecha_acta_recibo=''";
    $this->db->query($query);
    $query = "UPDATE equipos e SET e.fecha_ad= NULL where e.fecha_ad ='0000-00-00' OR e.fecha_ad=''";
    $this->db->query($query);
    $query = "UPDATE equipos e SET e.fecha_instalacion= NULL where e.fecha_instalacion ='0000-00-00' OR e.fecha_instalacion=''";
    $this->db->query($query);
  }
  public function updateEstadomAutomatico()
  {
    /*
			1-> Pendiente.
			2-> Realizado.
			3-> Atrasado.
			4-> No definido.
			5-> No iniciado.
			6-> Programado.
			*/
    $query_sin_plan = "
						UPDATE equipos SET estado_mantenimiento=4

						WHERE
						(
						SELECT COUNT(*) from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id AND planes_mantenimientos.anio=(SELECT anio FROM vigencias_mantenimiento)
						)=0
				";
    $this->db->query($query_sin_plan);
    $query_sin_preventivos = "
						UPDATE equipos SET estado_mantenimiento=CASE

						WHEN
				 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(pm.anio,'-',pm.mes1,'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM planes_mantenimientos pm WHERE pm.anio= (SELECT anio FROM vigencias_mantenimiento) AND pm.equipo_id=equipos.id order by pm.anio desc LIMIT 1)>1

						THEN 3

						WHEN
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(pm.anio,'-',pm.mes1,'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM planes_mantenimientos pm WHERE pm.anio= (SELECT anio FROM vigencias_mantenimiento) AND pm.equipo_id=equipos.id order by pm.anio desc LIMIT 1) BETWEEN -1 AND 0

						THEN 1

						WHEN
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(pm.anio,'-',pm.mes1,'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM planes_mantenimientos pm WHERE pm.anio= (SELECT anio FROM vigencias_mantenimiento) AND pm.equipo_id=equipos.id order by pm.anio desc LIMIT 1) <-1

						THEN 6

						END 

						WHERE
						(SELECT COUNT(*) from planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id and planes_mantenimientos.anio=(SELECT anio FROM vigencias_mantenimiento))>0
						AND 
						(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=equipos.id AND YEAR(mantenimiento.fecha_mantenimiento)=(SELECT anio FROM vigencias_mantenimiento))=0
				";
    $this->db->query($query_sin_preventivos);
    // Con preventivos ejecutados
    // SIn frecuencia definida
    // Bimensual
    $query_bimensual = "
						UPDATE equipos set estado_mantenimiento = CASE

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)=0
						THEN 2

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1) BETWEEN 1 AND 2
						THEN 1

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)>2
						THEN 3

						END

						WHERE (SELECT pm.frecuencia_id FROM planes_mantenimientos pm WHERE pm.equipo_id=equipos.id AND pm.anio = (SELECT anio FROM vigencias_mantenimiento) LIMIT 1)=8
						
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id AND planes_mantenimientos.anio=(SELECT anio FROM vigencias_mantenimiento))>0
						AND
						(SELECT COUNT(*) FROM mantenimiento WHERE equipos.id=mantenimiento.equipo_id)>0		

				";
    $this->db->query($query_bimensual);

    // Trimestral
    $query_trimestral = "";
    $query_trimestral = "
						UPDATE equipos set estado_mantenimiento = CASE

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)BETWEEN 0 AND 1

						THEN 2

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)BETWEEN 2 AND 3

						THEN 1

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)>3

						THEN 3

						END

						WHERE (SELECT pm.frecuencia_id FROM planes_mantenimientos pm WHERE pm.equipo_id=equipos.id AND pm.anio = (SELECT anio FROM vigencias_mantenimiento) LIMIT 1)=2
						
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id AND planes_mantenimientos.anio=(SELECT anio FROM vigencias_mantenimiento))>0
						AND
						(SELECT COUNT(*) FROM mantenimiento WHERE equipos.id=mantenimiento.equipo_id)>0		

				";
    $this->db->query($query_trimestral);


    // Semestral
    $query_semestral = "";
    $query_semestral = "
						UPDATE equipos set estado_mantenimiento = CASE

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)BETWEEN 0 AND 4

						THEN 2

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)BETWEEN 5 AND 6

						THEN 1

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)>6

						THEN 3

						END

						WHERE (SELECT pm.frecuencia_id FROM planes_mantenimientos pm WHERE pm.equipo_id=equipos.id AND pm.anio = (SELECT anio FROM vigencias_mantenimiento) LIMIT 1)=4

						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id AND planes_mantenimientos.anio=(SELECT anio FROM vigencias_mantenimiento))>0

						AND
						(SELECT COUNT(*) FROM mantenimiento WHERE equipos.id=mantenimiento.equipo_id)>0
				";
    $this->db->query($query_semestral);


    // Anual
    $query_anual = "";
    $query_anual = "
						UPDATE equipos set estado_mantenimiento = CASE

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)BETWEEN 0 AND 10
						THEN 2
						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)BETWEEN 11 AND 12

						THEN 1

						WHEN 
						(SELECT TIMESTAMPDIFF(MONTH,(SELECT CONCAT(YEAR(m.fecha_mantenimiento),'-',MONTH(m.fecha_mantenimiento),'-',20)),(SELECT CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',20))) FROM mantenimiento m WHERE m.equipo_id=equipos.id order by m.fecha_mantenimiento desc LIMIT 1)>12

						THEN 3

						END

						WHERE (SELECT pm.frecuencia_id FROM planes_mantenimientos pm WHERE pm.equipo_id=equipos.id AND pm.anio = (SELECT anio FROM vigencias_mantenimiento) LIMIT 1)=5
						
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=equipos.id AND planes_mantenimientos.anio=(SELECT anio FROM vigencias_mantenimiento))>0
						AND
						(SELECT COUNT(*) FROM mantenimiento WHERE equipos.id=mantenimiento.equipo_id)>0		
				";
    $this->db->query($query_anual);
  }
  public function UpdateEstadom($fecha_actual, $vector)
  { // Se ejecuta cada vez que se añade, o se edita un equipo y cuando se abre home
    /*Coloca en atrasado*/
    $this->db->where("
			equipos.estado_mantenimiento = 0 and
			equipos.fecha_mantenimiento<'{$fecha_actual}' and
			equipos.fecha_mantenimiento>'0000-00-00' and
			(equipos.plan = 1 or equipos.plan=3)
			");
    $this->db->update("equipos", $vector);
    /*Coloca en pendiente*/
    $vector["estado_mantenimiento"] = 0;
    $this->db->where("
			equipos.estado_mantenimiento = 2 and
			equipos.fecha_mantenimiento>='{$fecha_actual}' and
			(equipos.plan = 1 or equipos.plan=3)
			");
    $this->db->update("equipos", $vector);
    $vector["estado_mantenimiento"] = 2;
  }
  public function UpdatePlan($vector)
  {
    $this->db->where("
			equipos.fecha_mantenimiento='0000-00-00' and
			equipos.plan = 1
			");
    $this->db->update("equipos", $vector);
  }
  /*Para Dashboard*/
  public function getTotal()
  {
    $this->db->select("count(*) as total");
    $this->db->from("equipos");
    return $this->db->get()->row();
  }
  public function getTotalBaxter()
  {
    $this->db->select("count(*) as total");
    $this->db->from("equipos");
    $this->db->where("name like '%bomba de% or name like '%infusion% or name like '%nutricion%'");
    return $this->db->get()->row();
  }
  public function getEquiposEnOrdenCompra($param)
  {
    $this->db->select("equipos.*,servicios.name as servicio,areas.name as area");
    $this->db->from("equipos");
    $this->db->join("servicios", "equipos.servicio_id=servicios.id", "left");
    $this->db->join("areas", "equipos.area_id=areas.id", "left");
    $this->db->where("orden_compra_id", $param["orden_compra_id"]);
    return $this->db->get()->result();
  }
  public function getEquiposEnInvima($param)
  {
    $this->db->select("*");
    $this->db->from("equipos");
    $this->db->where("invima_id", $param["invima_id"]);
    return $this->db->get()->result();
  }
  public function getEquiposEnBaja($param)
  {
    $this->db->select("*");
    $this->db->from("equipos");
    $this->db->where("baja_id", $param["baja_id"]);
    return $this->db->get()->result();
  }
  public function getPlan()
  {
    $this->db->select("count(*) as total");
    $this->db->from("equipos");
    $this->db->where("equipos.plan!=2 and equipos.status=1");
    return $this->db->get()->row();
  }
  public function getComodato()
  {
    $this->db->select("count(*) as total");
    $this->db->from("equipos");
    $this->db->join("tadquisicion", "tadquisicion.id=equipos.tadquisicion_id");
    $this->db->like("tadquisicion.name", "comodato", "both");
    return $this->db->get()->row();
  }
  public function getPlanNoComodato()
  {
    $this->db->select("count(*) as total");
    $this->db->from("equipos");
    $this->db->where("tadquisicion_id!=4 and tadquisicion_id!=5 and plan=2");
    return $this->db->get()->row();
  }
  public function getCbiomedicas()
  {
    $this->db->select("cbiomedica.name as cbiomedica,count(*) as total");
    $this->db->from("equipos");
    $this->db->join("cbiomedica", "cbiomedica.id=equipos.cbiomedica_id");
    $this->db->group_by("cbiomedica.name");
    return $this->db->get()->result();
  }
  public function getCriesgos()
  {
    $this->db->select("criesgo.name as criesgo,count(*) as total");
    $this->db->from("equipos");
    $this->db->join("criesgo", "criesgo.id=equipos.criesgo_id");
    $this->db->group_by("criesgo.name");
    return $this->db->get()->result();
  }
  public function getNombres()
  {
    $this->db->select("distinccriesgo.name as criesgo,count(*) as total");
    $this->db->from("equipos");
    $this->db->join("criesgo", "criesgo.id=equipos.criesgo_id");
    $this->db->group_by("criesgo.name");
    return $this->db->get()->result();
  }
  public function nombres_get_server_side($param)
  {
    if ($param['length'] < 0) {
      $param['length'] = 999999999;
    }
    $this->db->select('name, count(*) as total');
    $this->db->from('equipos');
    $this->db->where('status !=0 and name like"%' . $param['search']['value'] . '%" ');
    // $this->db->order_by("count(*)","desc");
    if ($param["order"][0]["column"] == 1) {
      $this->db->order_by("count(*)", $param["order"][0]["dir"]);
    } elseif ($param["order"][0]["column"] == 0) {
      $this->db->order_by("name", $param["order"][0]["dir"]);
    }

    $this->db->group_by("name");
    $this->db->limit($param['length'], $param['start']);
    $result = $this->db->get(); // Estructura de datos

    $num_filas_limit = $result->num_rows();
    $datos = $result->result();

    $this->db->select('name, count(*) as total');
    $this->db->from('equipos');
    $this->db->where('status !=0 and name like"%' . $param['search']['value'] . '%" ');
    // $this->db->order_by("count(*)","desc");
    // $this->db->order_by($param["order"][0]["column"],$param["order"][0]["dir"]);
    if ($param["order"][0]["column"] == 1) {
      $this->db->order_by("count(*)", $param["order"][0]["dir"]);
    } elseif ($param["order"][0]["column"] == 0) {
      $this->db->order_by("name", $param["order"][0]["dir"]);
    }

    $this->db->group_by("name");

    $num_filas = $this->db->get()->num_rows();

    $vector = array(

      'datos' => $datos,
      'num_filas_limit' => $num_filas_limit,
      'num_filas' => $num_filas

    );

    return $vector;
  }
  /*--------------------------------------INFORMACION DE GARANTIA PROXIMA A VENCER----------------------------------*/
  public function garantia_casi_vencida()
  {
    $this->db->select("COUNT(*) as cuenta_garantia_casi_vencida
			FROM
			`equipos`
			WHERE
			(
			TIMESTAMPDIFF(
			DAY,
			(
			SELECT
			DATE_ADD(
			equipos.fecha_ad,
			INTERVAL CASE WHEN(equipos.garantia = 1) THEN 12 WHEN(equipos.garantia = 2) THEN 24 WHEN(equipos.garantia = 3) THEN 25 WHEN(equipos.garantia = 4) THEN 6 WHEN(equipos.garantia = 5) THEN 36 WHEN(equipos.garantia = 6) THEN 48
			END MONTH            
			) AS fecha_vencimiento_garantia
			),
			NOW())
		) between -90 and 0");


    return $this->db->get()->row();
  }
  public function get_garantiaCasiVencida()
  {
    $this->db->select(" equipos.*,periodos_garantias.name as tiempo_garantia,(case when (equipos.plan=1 or equipos.plan=3) then 'Incluido' when equipos.plan=2 then 'No_incluido' end) as inclusion_plan
			FROM
			equipos
			INNER JOIN periodos_garantias ON periodos_garantias.id=equipos.garantia
			WHERE
			TIMESTAMPDIFF(
			DAY,
			(
			SELECT
			DATE_ADD(
			fecha_ad,
			INTERVAL CASE WHEN(equipos.garantia = 1) THEN 12 WHEN(equipos.garantia = 2) THEN 24 WHEN(equipos.garantia = 3) THEN 25 WHEN(equipos.garantia = 4) THEN 6 WHEN(equipos.garantia = 5) THEN 36 WHEN(equipos.garantia = 6) THEN 48
			END MONTH
			)

			),
			NOW()) BETWEEN -90 AND 0");
    return $this->db->get()->result();
  }
  /*--------------------------------------INFORMACION DE GARANTIA VENCIDA RECIENTEMENTE----------------------------------*/
  public function garantia_vencida()
  {
    $this->db->select("COUNT(*) as cuenta_garantia_vencida
			FROM
			`equipos`
			WHERE
			(
			TIMESTAMPDIFF(
			DAY,
			(
			SELECT
			DATE_ADD(
			equipos.fecha_ad,
			INTERVAL CASE WHEN(equipos.garantia = 1) THEN 12 WHEN(equipos.garantia = 2) THEN 24 WHEN(equipos.garantia = 3) THEN 25 WHEN(equipos.garantia = 4) THEN 6 WHEN(equipos.garantia = 5) THEN 36 WHEN(equipos.garantia = 6) THEN 48
			END MONTH            
			) AS fecha_vencimiento_garantia
			),
			NOW())
		) between 1 and 90");


    return $this->db->get()->row();
  }
  public function get_garantiaVencida()
  {
    $this->db->select(" equipos.*,periodos_garantias.name as tiempo_garantia,(case when (equipos.plan=1 or equipos.plan=3) then 'Incluido' when equipos.plan=2 then 'No_incluido' end) as inclusion_plan
			FROM
			equipos
			INNER JOIN periodos_garantias ON periodos_garantias.id=equipos.garantia
			WHERE
			TIMESTAMPDIFF(
			DAY,
			(
			SELECT
			DATE_ADD(
			fecha_ad,
			INTERVAL CASE WHEN(equipos.garantia = 1) THEN 12 WHEN(equipos.garantia = 2) THEN 24 WHEN(equipos.garantia = 3) THEN 25 WHEN(equipos.garantia = 4) THEN 6 WHEN(equipos.garantia = 5) THEN 36 WHEN(equipos.garantia = 6) THEN 48
			END MONTH
			)

			),
			NOW()) BETWEEN 1 AND 90");
    return $this->db->get()->result();
  }
  /*--------------------------------------------------------------------------------------*/
  public function add_imagenes($param)
  {

    if ($param["clarear_imagen"] == "si") {

      $this->db->where("equipos.name like '%" . $param["name"] . "%' and equipos.marca like '%" . $param["marca"] . "%' and equipos.modelo like '%" . $param["modelo"] . "%'");
    } else {

      $this->db->where("(equipos.image ='' or equipos.image is null) and equipos.name like '%" . $param["name"] . "%' and equipos.marca like '%" . $param["marca"] . "%' and equipos.modelo like '%" . $param["modelo"] . "%'");
    }

    unset($param["marca"]);
    unset($param["modelo"]);
    unset($param["name"]);
    unset($param["clarear_imagen"]);
    $this->db->update("equipos", $param);
  }
  /*--------------------------------------------------------------------------------------*/
  public function equipos_baja()
  {
    $this->db->select("count(*) as cuenta");
    $this->db->from("equipos");
    $this->db->where("estadoequipo_id", "6");
    return $this->db->get()->row();
  }
  public function equipos_pendientes_baja()
  {
    $this->db->select("count(*) as cuenta");
    $this->db->from("equipos");
    $this->db->where("estadoequipo_id", "5");
    return $this->db->get()->row();
  }
  public function repuesto_pendiente_true($param)
  {
    $query = "
		UPDATE
		equipos
		SET
		repuesto_pendiente = 'si'
		where id=" . $param . "
		";
    $this->db->query($query);
  }
  public function repuesto_pendiente_false($param)
  {
    $query = "
		UPDATE
		equipos
		SET
		repuesto_pendiente = 'no'
		where id=" . $param . "
		";
    $this->db->query($query);
  }
  public function cambiar_dado_baja($param)
  {
    $this->db->where('id', $param['equipo_id']);
    unset($param['equipo_id']);
    $this->db->update("equipos", $param);
  }
  public function reset_invima($invima_id)
  {
    $query = "UPDATE equipos set invima_id = null WHERE invima_id=" . $invima_id;
    $this->db->query($query);
  }
  public function reset_baja($baja_id)
  {
    $query = "UPDATE equipos set baja_id = null WHERE baja_id=" . $baja_id;
    $this->db->query($query);
  }
  public function update_multiples_invimas($equipo_id, $invima_id)
  {
    $param = array(
      "invima_id" => $invima_id
    );
    $this->db->where("id", $equipo_id);
    $this->db->update("equipos", $param);
  }
  public function update_multiples_bajas($equipo_id, $baja_id)
  {
    $param = array(
      "baja_id" => $baja_id,
      "estadoequipo_id" => 6
    );
    $this->db->where("id", $equipo_id);
    $this->db->update("equipos", $param);
  }
  public function reset_orden_compra($orden_compra_id)
  {
    $query = "UPDATE equipos set orden_compra_id = null WHERE orden_compra_id=" . $orden_compra_id;
    $this->db->query($query);
  }
  public function update_multiples_ordenes_compra($equipo_id, $orden_compra_id)
  {
    $param = array(
      "orden_compra_id" => $orden_compra_id
    );
    $this->db->where("id", $equipo_id);
    $this->db->update("equipos", $param);
  }
  public function update_multiples_ordenes_compra_eliminar($equipo_id, $orden_compra_id)
  {
    $param = array(
      "orden_compra_id" => null
    );
    $this->db->where("id", $equipo_id);
    $this->db->update("equipos", $param);
  }
  public function update_multiples_invimas_eliminar($equipo_id, $invima_id)
  {
    $param = array(
      "invima_id" => null
    );
    $this->db->where("id", $equipo_id);
    $this->db->update("equipos", $param);
  }
  public function update_multiples_bajas_eliminar($equipo_id, $baja_id)
  {
    $param = array(
      "baja_id" => null,
      "estadoequipo_id" => 5
    );
    $this->db->where("id", $equipo_id);
    $this->db->update("equipos", $param);
  }
  public function asociar_baja($param)
  {
    $this->db->where("id", $param["equipo_id"]);
    unset($param["equipo_id"]);
    $this->db->update("equipos", $param);
  }
  public function ActualizarEstadoMantenimiento($param)
  {

    switch ($param["frecuencia_mantenimiento"]) {
      case 1:
        $query = "
						UPDATE equipos set equipos.estado_mantenimiento=4 where equipos.id=" . $param["equipo_id"] . "
					";
        $this->db->query($query);;
        break;

      case 2:
        $query = "
						UPDATE equipos set equipos.estado_mantenimiento=case
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) = 3 THEN 1
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) BETWEEN 0 AND 2 THEN 2
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) >3 THEN 3
						END
						where equipos.id=" . $param["equipo_id"] . "

						AND
						(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT YEAR(fecha_mantenimiento) FROM mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . " ORDER BY fecha_mantenimiento DESC LIMIT 1)=YEAR(NOW())
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT anio from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " ORDER BY anio DESC LIMIT 1)=YEAR(NOW())
						";
        $this->db->query($query);;
        break;

      case 3:
        $query = "
						UPDATE equipos set equipos.estado_mantenimiento=case
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) = 4 THEN 1
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) BETWEEN 0 AND 3 THEN 2
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) >4 THEN 3
						END
						where equipos.id=" . $param["equipo_id"] . "

						AND
						(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT YEAR(fecha_mantenimiento) FROM mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . " ORDER BY fecha_mantenimiento DESC LIMIT 1)=YEAR(NOW())
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT anio from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " ORDER BY anio DESC LIMIT 1)=YEAR(NOW())
					";
        $this->db->query($query);;
        break;

      case 4:
        $query = "
						UPDATE equipos set equipos.estado_mantenimiento=case
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) = 6 THEN 1
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) BETWEEN 0 AND 6 THEN 2
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) >6 THEN 3
						END
						where equipos.id=" . $param["equipo_id"] . "

						AND
						(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT YEAR(fecha_mantenimiento) FROM mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . " ORDER BY fecha_mantenimiento DESC LIMIT 1)=YEAR(NOW())
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT anio from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " ORDER BY anio DESC LIMIT 1)=YEAR(NOW())
					";
        $this->db->query($query);;
        break;

      case 5: //Anual
        $query = "
						UPDATE equipos set equipos.estado_mantenimiento=case
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) = 12 THEN 1
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) BETWEEN 0 AND 11 THEN 2
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) >12 THEN 3
						END
						where equipos.id=" . $param["equipo_id"] . "

						AND
						(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT YEAR(fecha_mantenimiento) FROM mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . " ORDER BY fecha_mantenimiento DESC LIMIT 1)=YEAR(NOW())
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT anio from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " ORDER BY anio DESC LIMIT 1)=YEAR(NOW())
					";
        $this->db->query($query);;
        break;

      case 6:
        $query = "";
        $this->db->query($query);;
        break;

      case 7:
        $query = "";
        $this->db->query($query);;
        break;

      case 8:
        $query = "
						UPDATE equipos set equipos.estado_mantenimiento=case
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) = 2 THEN 1
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) BETWEEN 0 AND 1 THEN 2
						when timestampdiff(MONTH,LAST_DAY((SELECT  fecha_mantenimiento  FROM  mantenimiento   WHERE  equipo_id = " . $param["equipo_id"] . "  ORDER BY fecha_mantenimiento DESC  LIMIT 1 )),LAST_DAY(NOW())) >2 THEN 3
						END
						where equipos.id=" . $param["equipo_id"] . "

						AND
						(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT YEAR(fecha_mantenimiento) FROM mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . " ORDER BY fecha_mantenimiento DESC LIMIT 1)=YEAR(NOW())
						AND
						(SELECT COUNT(*) FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")>0
						AND
						(SELECT anio from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " ORDER BY anio DESC LIMIT 1)=YEAR(NOW())
					";
        $this->db->query($query);;
        break;
    }
  }
  public function ActualizarEstadoMantenimiento2($param)
  {

    $query_sin_plan = "
				UPDATE equipos SET estado_mantenimiento=4

				WHERE
				(SELECT COUNT(*) from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")=0
				OR
				(SELECT anio FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " order by anio desc LIMIT 1)!=YEAR(NOW())

				AND equipos.id=" . $param["equipo_id"] . "

		";
    $this->db->query($query_sin_plan);

    $query_sin_preventivos = "
				UPDATE equipos SET estado_mantenimiento=CASE

				WHEN
				(SELECT mes1 from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " order by anio desc LIMIT 1)-(SELECT MONTH(NOW()))>1

				THEN 6

				WHEN
				(SELECT mes1 from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " order by anio desc LIMIT 1)-(SELECT MONTH(NOW())) BETWEEN 0 AND 1

				THEN 1

				WHEN
				(SELECT mes1 from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " order by anio desc LIMIT 1)-(SELECT MONTH(NOW())) <0

				THEN 3

				END

				WHERE

				equipos.id=" . $param["equipo_id"] . " and
				(SELECT COUNT(*) from planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . ")>0
				AND
				(SELECT anio FROM planes_mantenimientos where planes_mantenimientos.equipo_id=" . $param["equipo_id"] . " order by anio desc LIMIT 1)=YEAR(NOW())
				AND
				(
				(SELECT COUNT(*) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . ")=0
				OR
				(SELECT YEAR(fecha_mantenimiento) from mantenimiento where mantenimiento.equipo_id=" . $param["equipo_id"] . " order by fecha_mantenimiento desc LIMIT 1)!=YEAR(NOW())
)
		";
    $this->db->query($query_sin_preventivos);
  }
  public function depurarCodigo()
  {

    $query = "UPDATE equipos SET code=REPLACE(code,'EMC0','EMCO')";
    $this->db->query($query);
  }
  public function ObtenerListadoNombreEquipos()
  {
    $query = "SELECT DISTINCT name FROM equipos WHERE status=1 ORDER BY name ASC";
    return $this->db->query($query)->result();
  }
  public function ObtenerListadoModeloEquipos()
  {
    $query = "SELECT DISTINCT modelo FROM equipos WHERE status=1 ORDER BY modelo ASC";
    return $this->db->query($query)->result();
  }
  public function ObtenerListadoMarcaEquipos()
  {
    $query = "SELECT DISTINCT marca FROM equipos WHERE status=1 ORDER BY marca ASC";
    return $this->db->query($query)->result();
  }
  public function getByAdquisicion($param)
  {
    $query = $this->db->select('equipos.*, s.name as servicio, a.name as area, ta.name as tadquisicion, ee.name as estado')
      ->select('(SELECT CONCAT("$", FORMAT(equipos.costo, 2))) AS costo', false)
      ->from('equipos')
      ->join('servicios s', 's.id = equipos.servicio_id')
      ->join('areas a', 'a.id = equipos.area_id')
      ->join('tadquisicion ta', 'ta.id = equipos.tadquisicion_id')
      ->join('estadoequipos ee', 'ee.id = equipos.estadoequipo_id')
      ->where('equipos.status', 1)
      ->where('equipos.tipo_id', $param['tipo'])
      ->like('s.sede_id', $this->session->userdata('sede_id'))
      ->where('equipos.fecha_ad BETWEEN "' . $param['inicial'] . '" AND "' . $param['final'] . '"')
      ->order_by('equipos.fecha_ad', 'DESC')
      ->get();

    $equipos = $query->result();

    return [
      'cantidad' => count($equipos),
      'equipos' => $equipos
    ];
  }
  public function getByInstalacion($param)
  {
    $query = "SELECT
		equipos.*, 
		s.name as servicio,
		a.name as area,
		ta.name as tadquisicion,
		ee.name as estado,
		(SELECT CONCAT('$',(SELECT(FORMAT(equipos.costo,2)))))AS costo

		FROM equipos 
		LEFT JOIN servicios s ON s.id=equipos.servicio_id
		LEFT JOIN areas a ON a.id=equipos.area_id
		LEFT JOIN tadquisicion ta ON ta.id=equipos.tadquisicion_id
		LEFT JOIN estadoequipos ee ON ee.id=equipos.estadoequipo_id
		where 
		equipos.status=1 AND
		equipos.tipo_id = " . $param["tipo"] . " AND
		s.sede_id LIKE '%" . $this->session->userdata("sede_id") . "%' AND
		equipos.fecha_instalacion BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "'
		ORDER BY equipos.fecha_instalacion DESC
		";
    $resultado = $this->db->query($query);
    $cantidad = $resultado->num_rows();
    $equipos = $resultado->result();
    return array("cantidad" => $cantidad, "equipos" => $equipos);
  }
  public function inversionAdquisicion($param)
  {
    $query = '
		SELECT
		    CONCAT(
		        "$",
		        (
		        SELECT
		            FORMAT(
		                (
		                SELECT
		                    SUM(costo)
		                FROM
		                    equipos
		                    LEFT JOIN 	servicios s on s.id=equipos.servicio_id
		                WHERE
		                    costo IS NOT NULL AND costo != "" AND
		                    tipo_id=' . $param["tipo"] . ' AND
		                     fecha_ad BETWEEN "' . $param["inicial"] . '" AND "' . $param["final"] . '"
								AND s.sede_id like "%' . $this->session->userdata("sede_id") . '%"
		                    )
							
			
		                    ,
		                    2
		            )
		            )
		    ) AS inversion;
				';
    return $this->db->query($query)->row();
  }
  public function inversionInstalacion($param)
  {
    $query = '
		SELECT
		    CONCAT(
		        "$",
		        (
		        SELECT
		            FORMAT(
		                (
		                SELECT
		                    SUM(costo)
		                FROM
		                    equipos
		                    LEFT JOIN 	servicios s on s.id=equipos.servicio_id
		                WHERE
		                    costo IS NOT NULL AND costo != "" AND
		                    tipo_id=' . $param["tipo"] . ' AND
		                     fecha_instalacion BETWEEN "' . $param["inicial"] . '" AND "' . $param["final"] . '"
								AND s.sede_id like "%' . $this->session->userdata("sede_id") . '%"
		                    )
							
			
		                    ,
		                    2
		            )
		            )
		    ) AS inversion;
				';
    return $this->db->query($query)->row();
  }
  public function listadoAdquisicion($param)
  {

    $query = "

					SELECT
					    COUNT(*) AS cantidad,
					    e.name as nombre
					FROM
					    equipos e
					 	LEFT JOIN servicios s ON s.id=e.servicio_id	   
					WHERE
					    e.fecha_ad BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
						s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
						e.tipo_id like '%" . $param["tipo"] . "%'	

					GROUP BY
					    e.name
					ORDER BY
						e.name ASC

			";

    return $this->db->query($query)->result();
  }
  public function listadoInstalacion($param)
  {

    $query = "

		SELECT
		    COUNT(*) AS cantidad,
		    e.name as nombre
		FROM
		    equipos e
		 	LEFT JOIN servicios s ON s.id=e.servicio_id	   
		WHERE
		    e.fecha_instalacion BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
			e.tipo_id like '%" . $param["tipo"] . "%'	

		GROUP BY
		    e.name 
		ORDER BY 
			e.name ASC    


		";

    return $this->db->query($query)->result();
  }
  public function riesgoAdquisicion($param)
  {

    $query = "

			SELECT
			    COUNT(*) AS cantidad,
			    cr.name as riesgo
			FROM
			    equipos e
			    left join criesgo cr on cr.id=e.criesgo_id
			    left join servicios s on s.id=e.servicio_id
			WHERE
			    e.fecha_ad BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			    s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
			    e.tipo_id like '%" . $param["tipo"] . "%' 
			    GROUP BY
			    cr.name
			    ORDER BY
			    cr.name ASC

		";

    return $this->db->query($query)->result();
  }
  public function riesgoInstalacion($param)
  {

    $query = "

			SELECT
			    COUNT(*) AS cantidad,
			    cr.name as riesgo
			FROM
			    equipos e
			    left join criesgo cr on cr.id=e.criesgo_id
			    left join servicios s on s.id=e.servicio_id
			WHERE
			    e.fecha_instalacion BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			    s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
			    e.tipo_id like '%" . $param["tipo"] . "%' 
			    GROUP BY cr.name 
			    ORDER BY cr.name ASC

		";

    return $this->db->query($query)->result();
  }
  public function tipoAdquisicionFromAdquisicion($param)
  {

    $query = "
		SELECT
		    COUNT(*) AS cantidad,
		    ta.name as tipoa,
		    e.name as nombre
		FROM
		    equipos e
		LEFT JOIN tadquisicion ta ON ta.id = e.tadquisicion_id
		LEFT JOIN servicios s ON s.id = e.servicio_id
		WHERE
		    e.fecha_ad BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
		    e.tipo_id like '%" . $param["tipo"] . "%'    
			GROUP BY  e.name, e.tadquisicion_id
			ORDER BY e.name, e.tadquisicion_id ASC

		";

    return $this->db->query($query)->result();
  }
  public function tipoAdquisicionFromInstalacion($param)
  {

    $query = "
		SELECT
		    COUNT(*) AS cantidad,
		    ta.name as tipoa,
		    e.name as nombre
		FROM
		    equipos e
		LEFT JOIN tadquisicion ta ON ta.id = e.tadquisicion_id
		LEFT JOIN servicios s ON s.id = e.servicio_id
		WHERE
		    e.fecha_instalacion BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
		    e.tipo_id like '%" . $param["tipo"] . "%'    
			GROUP BY  e.name, e.tadquisicion_id 
			ORDER BY  e.name, e.tadquisicion_id ASC

		";

    return $this->db->query($query)->result();
  }
  public function clasificacionFromAdquisicion($param)
  {

    $query = "
		SELECT
		    COUNT(*) AS cantidad,
		    cb.name as clasificacion
		    
		FROM
		    equipos e
		LEFT JOIN cbiomedica cb ON cb.id = e.cbiomedica_id
		LEFT JOIN servicios s ON s.id = e.servicio_id
		WHERE
		    e.fecha_ad BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
		    e.tipo_id like '%" . $param["tipo"] . "%'    
			GROUP BY  cb.name
			ORDER BY cb.name ASC

		";

    return $this->db->query($query)->result();
  }
  public function clasificacionFromInstalacion($param)
  {

    $query = "
		SELECT
		    COUNT(*) AS cantidad,
		    cb.name as clasificacion
		    
		FROM
		    equipos e
		LEFT JOIN cbiomedica cb ON cb.id = e.cbiomedica_id
		LEFT JOIN servicios s ON s.id = e.servicio_id
		WHERE
		    e.fecha_instalacion BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
		    e.tipo_id like '%" . $param["tipo"] . "%'    
			GROUP BY  cb.name 
			ORDER BY  cb.name ASC

		";

    return $this->db->query($query)->result();
  }
  public function fuenteFromAdquisicion($param)
  {

    $query = "
		SELECT
		    COUNT(*) AS cantidad,
		    f.name as fuente
		    
		FROM
		    equipos e
		LEFT JOIN fuenteal f ON f.id = e.fuente_id
		LEFT JOIN servicios s ON s.id = e.servicio_id
		WHERE
		    e.fecha_ad BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
		    e.tipo_id like '%" . $param["tipo"] . "%'    
			GROUP BY  f.name
			ORDER BY  f.name ASC

		";

    return $this->db->query($query)->result();
  }
  public function fuenteFromInstalacion($param)
  {

    $query = "
		SELECT
		    COUNT(*) AS cantidad,
		    f.name as fuente
		    
		FROM
		    equipos e
		LEFT JOIN fuenteal f ON f.id = e.fuente_id
		LEFT JOIN servicios s ON s.id = e.servicio_id
		WHERE
		    e.fecha_instalacion BETWEEN '" . $param["inicial"] . "' AND '" . $param["final"] . "' AND
			s.sede_id like '%" . $this->session->userdata("sede_id") . "%' AND
		    e.tipo_id like '%" . $param["tipo"] . "%'    
			GROUP BY  f.name 
			ORDER BY  f.name ASC

		";

    return $this->db->query($query)->result();
  }
  public function getEquiposAdquisiciones($param)
  {

    if (!isset($param["tadquisicion_id"])) {

      $multiselect_tadquisicion_eq = "( eq.tadquisicion_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["tadquisicion_id"]) == 1) {

        $valor = $param["tadquisicion_id"][0];
        $multiselect_tadquisicion_eq = " ( eq.tadquisicion_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["tadquisicion_id"];
        $multiselect_tadquisicion_eq = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiselect_tadquisicion_eq .= " ( eq.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiselect_tadquisicion_eq .= " eq.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiselect_tadquisicion_eq .= " eq.tadquisicion_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    if (!isset($param["estadoequipo_id"])) {

      $multiple_estado_equipo = "( eq.estadoequipo_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["estadoequipo_id"]) == 1) {

        $valor = $param["estadoequipo_id"][0];
        $multiple_estado_equipo = " ( eq.estadoequipo_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["estadoequipo_id"];
        $multiple_estado_equipo = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiple_estado_equipo .= " ( eq.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiple_estado_equipo .= " eq.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiple_estado_equipo .= " eq.estadoequipo_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    $query = "
		SELECT
		    COUNT(*) as cantidad,
		    CONCAT(
		        YEAR(eq.fecha_ad),
		        '(',
		        MONTH(eq.fecha_ad),
		        ')'
		    ) AS mes
		FROM
		    equipos eq 
		LEFT JOIN servicios s ON s.id=eq.servicio_id
		    where fecha_ad !=''
		    AND fecha_ad IS NOT NULL
		    AND fecha_ad !='0000-00-00'
		    AND YEAR(eq.fecha_ad)>=YEAR(NOW())-3
		    AND s.sede_id LIKE '%" . $param["sede_id"] . "%'
			AND eq.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
            AND " . $multiselect_tadquisicion_eq . "
            AND " . $multiple_estado_equipo . "
		GROUP BY
		    YEAR(eq.fecha_ad) ASC,
		    MONTH(eq.fecha_ad) ASC
		";
    return $this->db->query($query)->result();
  }
  public function getEquiposInstalaciones($param)
  {

    if (!isset($param["tadquisicion_id"])) {

      $multiselect_tadquisicion_eq = "( eq.tadquisicion_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["tadquisicion_id"]) == 1) {

        $valor = $param["tadquisicion_id"][0];
        $multiselect_tadquisicion_eq = " ( eq.tadquisicion_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["tadquisicion_id"];
        $multiselect_tadquisicion_eq = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiselect_tadquisicion_eq .= " ( eq.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiselect_tadquisicion_eq .= " eq.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiselect_tadquisicion_eq .= " eq.tadquisicion_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    if (!isset($param["estadoequipo_id"])) {

      $multiple_estado_equipo = "( eq.estadoequipo_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["estadoequipo_id"]) == 1) {

        $valor = $param["estadoequipo_id"][0];
        $multiple_estado_equipo = " ( eq.estadoequipo_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["estadoequipo_id"];
        $multiple_estado_equipo = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiple_estado_equipo .= " ( eq.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiple_estado_equipo .= " eq.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiple_estado_equipo .= " eq.estadoequipo_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }
    $query = "
		SELECT
		    COUNT(*) as cantidad,
		    CONCAT(
		        YEAR(eq.fecha_instalacion),
		        '(',
		        MONTH(eq.fecha_instalacion),
		        ')'
		    ) AS mes
		FROM
		    equipos eq 
		LEFT JOIN servicios s ON s.id=eq.servicio_id
		    where fecha_instalacion !=''
		    AND fecha_instalacion IS NOT NULL
		    AND fecha_instalacion !='0000-00-00'
		    AND YEAR(eq.fecha_instalacion)>=YEAR(NOW())-3
		    AND s.sede_id LIKE '%" . $param["sede_id"] . "%'
			AND eq.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
            AND " . $multiselect_tadquisicion_eq . "
            AND " . $multiple_estado_equipo . "
		GROUP BY
		    YEAR(eq.fecha_instalacion) ASC,
		    MONTH(eq.fecha_instalacion) ASC
		";
    return $this->db->query($query)->result();
  }
  public function getEquipoInstalacionAdquisicionIndicador($param)
  {

    if (!isset($param["tadquisicion_id"])) {

      $multiselect_tadquisicion_eq = "( eq.tadquisicion_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["tadquisicion_id"]) == 1) {

        $valor = $param["tadquisicion_id"][0];
        $multiselect_tadquisicion_eq = " ( eq.tadquisicion_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["tadquisicion_id"];
        $multiselect_tadquisicion_eq = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiselect_tadquisicion_eq .= " ( eq.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiselect_tadquisicion_eq .= " eq.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiselect_tadquisicion_eq .= " eq.tadquisicion_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    if (!isset($param["tadquisicion_id"])) {

      $multiselect_tadquisicion_equipos = "( equipos.tadquisicion_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["tadquisicion_id"]) == 1) {

        $valor = $param["tadquisicion_id"][0];
        $multiselect_tadquisicion_equipos = " ( equipos.tadquisicion_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["tadquisicion_id"];
        $multiselect_tadquisicion_equipos = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiselect_tadquisicion_equipos .= " ( equipos.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiselect_tadquisicion_equipos .= " equipos.tadquisicion_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiselect_tadquisicion_equipos .= " equipos.tadquisicion_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    if (!isset($param["estadoequipo_id"])) {

      $multiple_estado_equipo_eq = "( eq.estadoequipo_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["estadoequipo_id"]) == 1) {

        $valor = $param["estadoequipo_id"][0];
        $multiple_estado_equipo_eq = " ( eq.estadoequipo_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["estadoequipo_id"];
        $multiple_estado_equipo_eq = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiple_estado_equipo_eq .= " ( eq.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiple_estado_equipo_eq .= " eq.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiple_estado_equipo_eq .= " eq.estadoequipo_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    if (!isset($param["estadoequipo_id"])) {

      $multiple_estado_equipo_equipos = "( equipos.estadoequipo_id LIKE '%%' ) ";
    } else {

      if (sizeof($param["estadoequipo_id"]) == 1) {

        $valor = $param["estadoequipo_id"][0];
        $multiple_estado_equipo_equipos = " ( equipos.estadoequipo_id LIKE '%" . $valor . "%') ";
      } else {
        $vector = $param["estadoequipo_id"];
        $multiple_estado_equipo_equipos = "";
        $contador = 0;
        $tamanio = sizeof($vector);
        foreach ($vector as $elemento) {
          $contador = $contador + 1;
          if ($contador == 1) {
            $multiple_estado_equipo_equipos .= " ( equipos.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador > 1 && $contador < $tamanio) {
            $multiple_estado_equipo_equipos .= " equipos.estadoequipo_id LIKE '%" . $elemento . "%' OR";
          }
          if ($contador == $tamanio) {
            $multiple_estado_equipo_equipos .= " equipos.estadoequipo_id LIKE '%" . $elemento . "%'  )";
          }
        }
      }
    }

    $query = "
			SELECT
			     CONCAT(
			        YEAR(DATE(eq.fecha_ad)),
			        '(',
			        MONTH(DATE(eq.fecha_ad)),
			        ')'
			    ) AS mes,
			    
			((
			    SELECT
			        COUNT(*)
			    FROM
			        equipos 
			    LEFT JOIN servicios s ON s.id=equipos.servicio_id
			    WHERE
                EXTRACT(YEAR_MONTH FROM DATE(equipos.fecha_instalacion))=
                EXTRACT(YEAR_MONTH FROM DATE(eq.fecha_ad))
                AND s.sede_id LIKE '%" . $param["sede_id"] . "%'
				AND equipos.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
                AND " . $multiselect_tadquisicion_equipos . "
                AND " . $multiple_estado_equipo_equipos . "
			)/COUNT(*))*100 AS porcentaje
			FROM
			    equipos eq 
			LEFT JOIN servicios s ON s.id=eq.servicio_id
			WHERE
			    eq.fecha_ad != '' AND eq.fecha_ad IS NOT NULL AND eq.fecha_ad != '0000-00-00'
			    AND YEAR(eq.fecha_ad)>=YEAR(NOW())-3
			    AND s.sede_id LIKE '%" . $param["sede_id"] . "%'
				AND eq.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
                AND " . $multiselect_tadquisicion_eq . "
                AND " . $multiple_estado_equipo_eq . "
			GROUP BY
            EXTRACT(YEAR_MONTH FROM DATE(eq.fecha_ad)) ASC

		";
    return $this->db->query($query)->result();
  }
  public function listado_detalle_por_nombre_equipo($param)
  {
    $query = "
		SELECT
		    eq.name,
		    eq.marca,
		    eq.modelo,
		    COUNT(*) AS cantidad_total,
		    (CASE WHEN eq2.cantidad_con_guia IS NULL THEN 0 ELSE eq2.cantidad_con_guia  END) AS cantidad_con_guia
		    
		FROM
		    equipos eq
		LEFT JOIN(
		    SELECT
		        COUNT(*) AS cantidad_con_guia,
		        equipos.name,
		        equipos.marca,
		        equipos.modelo
		    FROM
		        equipos
		    WHERE
		        equipos.guia_id != 0 AND equipos.name = '" . $param["name"] . "'
		        AND equipos.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
		        AND equipos.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)
		    GROUP BY
		        CONCAT(
		            equipos.name,
		            equipos.marca,
		            equipos.modelo
		        )
		) eq2
		ON
		    CONCAT(
		        eq2.name,
		        eq2.marca,
		        eq2.modelo
		    ) = CONCAT(eq.name, eq.marca, eq.modelo)
		WHERE
		    eq.name = '" . $param["name"] . "'
	        AND eq.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
	        AND eq.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)		    
		GROUP BY
		    CONCAT(eq.name, eq.marca, eq.modelo)
	    ORDER BY (CASE WHEN eq2.cantidad_con_guia IS NULL THEN 0 ELSE eq2.cantidad_con_guia  END) DESC,
		    CONCAT(eq.name, eq.marca, eq.modelo) ASC
		";
    return $this->db->query($query)->result();
  }
  public function get_listado_nombres_equipos()
  {
    $query = "
				SELECT
				    eq.name,
				    COUNT(*) AS cantidad
				FROM
				    equipos eq
				WHERE
				    eq.tipo_id LIKE '%1%'
				GROUP BY
				    eq.name 
				ORDER BY 
				    eq.name ASC
		    	";
    return $this->db->query($query)->result();
  }
  public function update_name_from_depuracion($param)
  {

    $query = "
			UPDATE equipos eq SET
			eq.name = '" . $param["nombre_equipo_destino"] . "',
			eq.descripcion = '" . $param["descripcion_equipo"] . "'
			WHERE eq.name IN(" . $param["seleccionados"] . ")
		";
    $this->db->query($query);
  }
  public function get_listado_industriales()
  {
    $this->db->select("*");
    $this->db->from("listado_industriales");
    return $this->db->get()->result();
  }
  public function compute_frecuency($startMonth, $endMonth)
  {
    $startMonth = (int) $startMonth;
    $endMonth = (int) $endMonth;

    if ($endMonth > $startMonth) {
      return ($endMonth - $startMonth) . " Meses";
    }

    if (!empty($startMonth)) {
      return "Anual";
    }

    return "";
  }
}
