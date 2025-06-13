<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mcorrectivos_generales extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function get($param)
	{
		$this->db->select("correctivos_generales.*,codificacion_cierres.name as descripcion_codigo,codificacion_cierres.code as codigo_cierre,(select count(*) from avances_correctivos where avances_correctivos.correctivo_general_id=correctivos_generales.id) as notas_avance,
			(
			    SELECT
			        description
			    FROM
			        avances_correctivos
			    WHERE
			        avances_correctivos.correctivo_general_id = correctivos_generales.id
			    ORDER BY
			        DATE
			    DESC
			LIMIT 1
			) AS last_description
			");
		$this->db->from("correctivos_generales");
		$this->db->join("codificacion_cierres", "codificacion_cierres.id=correctivos_generales.cierre_id", "left");
		$this->db->where("correctivos_generales.equipo_id", $param['equipo_id']);
		$this->db->order_by("correctivos_generales.fecha_inicio", "desc");
		return $this->db->get()->result();
	}
	public function get_ind($param)
	{
		$this->db->select("correctivos_generales_ind.*");
		$this->db->from("correctivos_generales_ind");
		$this->db->where("correctivos_generales_ind.equipo_id", $param['equipo_id']);
		$this->db->order_by("correctivos_generales_ind.fecha_mantenimiento", "asc");
		return $this->db->get()->result();
	}
	public function add($param)
	{
		$this->db->insert("correctivos_generales", $param);
		return $this->db->insert_id();
	}
	public function add_ind($param)
	{
		$this->db->insert("correctivos_generales_ind", $param);
		return $this->db->insert_id();
	}
	public function getOne($param)
	{
		$this->db->select("correctivos_generales.*
			,DATE(correctivos_generales.fecha_inicio) AS fecha_inicio_date
			,TIME(correctivos_generales.fecha_inicio) AS fecha_inicio_hora
			,DATE(correctivos_generales.fecha_diagnostico) AS fecha_diagnostico_date
			,TIME(correctivos_generales.fecha_diagnostico) AS fecha_diagnostico_hora
			,DATE(correctivos_generales.fecha_mantenimiento) AS fecha_mantenimiento_date
			,TIME(correctivos_generales.fecha_mantenimiento) AS fecha_mantenimiento_hora,
			codificacion_cierres.code as codigo_cierre,
			codificacion_cierres.name as significado_codigo,
			tipos_fallas.name as tipo_falla
			");
		$this->db->from("correctivos_generales");
		$this->db->join("codificacion_cierres", "codificacion_cierres.id=correctivos_generales.cierre_id", "left");
		$this->db->join("tipos_fallas", "tipos_fallas.id=correctivos_generales.tipo_falla_id", "left");
		$this->db->where("correctivos_generales.id", $param["id"]);
		return $this->db->get()->row();
	}
	public function getOne_ind($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->get("correctivos_generales_ind")->row();
	}
	public function get_correctivos_generales_abiertos_server_side($param)
	{
		if ($param['length'] < 0) {
			$param['length'] = 999999999;
		}
		$query = '
			SELECT
			    correctivos_generales.*,
			    equipos.name as equipo, 
			    equipos.code as codigo_equipo, 
			    equipos.serial as serie_equipo,
			    servicios.name as servicio,
			    areas.name as area,
			    (SELECT count(*) from avances_correctivos where correctivo_general_id=correctivos_generales.id) as avances
			FROM
			    correctivos_generales
			    INNER JOIN equipos ON equipos.id=correctivos_generales.equipo_id
			    LEFT JOIN servicios ON equipos.servicio_id=servicios.id
			    LEFT JOIN areas ON equipos.area_id=areas.id
			WHERE
			    orden IS NOT NULL AND orden != "" AND code_orden IS NOT NULL AND code_orden != "" AND fecha_inicio IS NOT NULL AND fecha_inicio != "" AND(
			        cierre_id = 14
			    )
			    AND (equipos.name LIKE "%' . $param["search"]["value"] . '%"
			    OR equipos.code LIKE "%' . $param["search"]["value"] . '%"
			    OR equipos.serial LIKE "%' . $param["search"]["value"] . '%"
			    OR servicios.name LIKE "%' . $param["search"]["value"] . '%"
			    OR areas.name LIKE "%' . $param["search"]["value"] . '%")
			    ORDER BY fecha_inicio DESC	
		';

		// $query='
		// 	SELECT
		// 	    correctivos_generales.*,
		// 	    equipos.name as equipo, 
		// 	    equipos.code as codigo_equipo, 
		// 	    equipos.serial as serie_equipo,
		// 	    servicios.name as servicio,
		// 	    areas.name as area,
		// 	    (SELECT count(*) from avances_correctivos where correctivo_general_id=correctivos_generales.id) as avances
		// 	FROM
		// 	    correctivos_generales
		// 	    INNER JOIN equipos ON equipos.id=correctivos_generales.equipo_id
		// 	    LEFT JOIN servicios ON equipos.servicio_id=servicios.id
		// 	    LEFT JOIN areas ON equipos.area_id=areas.id
		// 	WHERE
		// 	    orden IS NOT NULL AND orden != "" AND code_orden IS NOT NULL AND code_orden != "" AND fecha_inicio IS NOT NULL AND fecha_inicio != "" AND(
		// 	        cierre_id = "" OR cierre_id IS NULL OR cierre_id = 0
		// 	    )
		// 	    ORDER BY fecha_inicio DESC	
		// ';
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
	public function update($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$this->db->update("correctivos_generales", $param);
	}
	public function update_ind($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		return $this->db->update("correctivos_generales_ind", $param);
	}
	public function delete($param)
	{
		$this->db->where("id", $param["id"]);
		$this->db->delete("correctivos_generales");
	}
	public function delete_ind($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->delete("correctivos_generales_ind");
	}
	public function getAll()
	{
		$this->db->select("correctivos_generales.*,equipos.name as nombre_equipo,equipos.code as codigo_equipo, equipos.serial as serie_equipo, equipos.marca as marca_equipo, equipos.modelo as modelo_equipo, servicios.name as ubicacion, equipos.id as equipo_id");
		$this->db->from("correctivos_generales");
		$this->db->join("equipos", "equipos.id=correctivos_generales.equipo_id");
		$this->db->join("servicios", "equipos.servicio_id=servicios.id");
		$this->db->order_by("correctivos_generales.fecha_mantenimiento", "desc");
		return $this->db->get()->result();
	}
	public function repuesto_pendiente_true($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		unset($param["equipo_id"]);
		$param["repuesto_pendiente"] = "si";
		return $this->db->update("correctivos_generales", $param);
	}
	public function repuesto_pendiente_false($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		unset($param["equipo_id"]);
		$param["repuesto_pendiente"] = "no";
		return $this->db->update("correctivos_generales", $param);
	}
	public function cuenta_registros_repuestos_pendientes($param)
	{
		$query = "
		SELECT
		COUNT(*) AS total
		FROM
		correctivos_generales
		WHERE
		correctivos_generales.equipo_id = " . $param . "
		and repuesto_pendiente='si'		
		";
		return $this->db->query($query)->row();
	}
	public function getCorrectivosModal()
	{

		$this->db->select("
			equipos.id as equipo_id,

			(SELECT avances_correctivos.date from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 1) as avance_fecha,
			(SELECT avances_correctivos.title from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 1) as avance_titulo,
			(SELECT avances_correctivos.description from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 1) as avance_descripcion,
			(SELECT avances_correctivos.date from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 1,1) as avance_fecha2,
			(SELECT avances_correctivos.title from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 1,1) as avance_titulo2,
			(SELECT avances_correctivos.description from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 1,1) as avance_descripcion2,
			(SELECT avances_correctivos.date from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 2,1) as avance_fecha3,
			(SELECT avances_correctivos.title from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 2,1) as avance_titulo3,
			(SELECT avances_correctivos.description from avances_correctivos WHERE avances_correctivos.correctivo_general_id=correctivos_generales.id ORDER BY avances_correctivos.date desc LIMIT 2,1) as avance_descripcion3,
			(SELECT pm.responsable FROM planes_mantenimientos pm WHERE equipo_id=equipos.id ORDER BY anio DESC LIMIT 1)AS responsable_mantenimiento,
			equipos.name as equipo,
			equipos.marca as marca,
			equipos.modelo as modelo,
			equipos.serial as serial,
			equipos.code as code,
			equipos.costo as costo,
			estadoequipos.name as estado_equipo,

			correctivos_generales.orden as orden,
			correctivos_generales.code_orden as code_orden,
			correctivos_generales.fecha_inicio as fecha_inicio,

			correctivos_generales.diagnostico as diagnostico,
			correctivos_generales.code_diagnostico as code_diagnostico,
			correctivos_generales.fecha_diagnostico as fecha_diagnostico,

			correctivos_generales.description as descripcion,
			correctivos_generales.fecha_mantenimiento as fecha_ejecucion,
			correctivos_generales.code as codigo_correctivo,


			servicios.name as ubicacion,
			areas.name as area,
			sedes.name as sede,
			correctivos_generales.file as archivo,

			codificacion_cierres.name as descripcion_codificacion,
			codificacion_cierres.code as codificacion,

			tipos_fallas.name as tipo_falla

			");
		$this->db->from("equipos");
		$this->db->join("correctivos_generales", "correctivos_generales.equipo_id=equipos.id", "left");
		$this->db->join("servicios", "equipos.servicio_id=servicios.id", "left");
		$this->db->join("areas", "equipos.area_id=areas.id", "left");
		$this->db->join("sedes", "servicios.sede_id=sedes.id", "left");
		$this->db->join("codificacion_cierres", "correctivos_generales.cierre_id=codificacion_cierres.id", "left");
		$this->db->join("estadoequipos", "estadoequipos.id=equipos.estadoequipo_id", "left");
		$this->db->join("tipos_fallas", "tipos_fallas.id=correctivos_generales.tipo_falla_id", "left");
		$this->db->where("equipos.tipo_id=" . $this->session->userdata("tipo_id"));
		$this->db->order_by("correctivos_generales.fecha_mantenimiento", "asc");
		return $this->db->get()->result();
	}

	public function getCorrectivosGeneralesGeneratedByDate($param)
	{
		$query = "
			SELECT
			    COUNT(*) AS cantidad,
			    CONCAT(
			        YEAR(cg.fecha_inicio),
			        '(',
			        MONTH(cg.fecha_inicio),
			        ')'
			    ) AS mes
			FROM
			    correctivos_generales cg
			LEFT JOIN equipos e ON e.id=cg.equipo_id
			    
			WHERE
			    cg.fecha_inicio IS NOT NULL AND cg.fecha_inicio != '' AND
				e.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
			GROUP BY
			    YEAR(cg.fecha_inicio) ,
			    MONTH(cg.fecha_inicio) 
			ORDER BY
			    YEAR(cg.fecha_inicio) ASC,
			    MONTH(cg.fecha_inicio) ASC
		";
		return $this->db->query($query)->result();
	}

	public function getCorrectivosGeneralesClosedByDate($param)
	{
		$query = "
			SELECT
			    COUNT(*) AS cantidad,
			    CONCAT(
			        YEAR(cg.fecha_mantenimiento),
			        '(',
			        MONTH(cg.fecha_mantenimiento),
			        ')'
			    ) AS mes
			FROM
			    correctivos_generales cg
			LEFT JOIN equipos e ON e.id=cg.equipo_id

			WHERE
			    cg.fecha_mantenimiento IS NOT NULL AND cg.fecha_mantenimiento != '' AND cg.cierre_id != 0 AND cg.cierre_id != '' AND cg.cierre_id IS NOT NULL AND cg.cierre_id != 14 AND e.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
			GROUP BY
			    YEAR(cg.fecha_mantenimiento) ,
			    MONTH(cg.fecha_mantenimiento) 
			ORDER BY
			    YEAR(cg.fecha_mantenimiento) ASC,
			    MONTH(cg.fecha_mantenimiento) ASC
		";
		return $this->db->query($query)->result();
	}

	public function getCorrectivosGeneralesByStatus($param)
	{
		$query = "
			SELECT
			    COUNT(*) AS cantidad,
			    cc.name AS estado
			FROM
			    correctivos_generales cg
			LEFT JOIN codificacion_cierres cc ON
			    cc.id = cg.cierre_id
			LEFT JOIN equipos e ON e.id=cg.equipo_id    
			WHERE
			    cg.cierre_id IS NOT NULL AND
			    e.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
			GROUP BY
			    cc.name 
			ORDER BY
			    cc.name ASC	
		";
		return $this->db->query($query)->result();
	}
	public function getCorrectivosGeneralesIndicador($param)
	{
		$query = "
			SELECT
			    COUNT(*) AS cantidad_generados,
			    (
			    SELECT
			        COUNT(*) AS cantidad_cerrados
			    FROM
			        correctivos_generales cg2
			    LEFT JOIN equipos eq ON eq.id=cg2.equipo_id    
			    WHERE
			        (
			            CONCAT(
			                YEAR(cg2.fecha_mantenimiento),
			                '(',
			                MONTH(cg2.fecha_mantenimiento),
			                ')'
			            ) = CONCAT(
			                YEAR(cg.fecha_inicio),
			                '(',
			                MONTH(cg.fecha_inicio),
			                ')'
			            )
			        ) AND
			        eq.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
			        AND
			    cg2.cierre_id != 0 AND cg2.cierre_id != '' AND cg2.cierre_id IS NOT NULL AND cg2.cierre_id != 14
			) AS cantidad_cerrados,
			((
			    SELECT
			        COUNT(*) AS cantidad_cerrados
			    FROM
			        correctivos_generales cg2
			    LEFT JOIN equipos eq ON eq.id=cg2.equipo_id    
			    WHERE
			        (
			            CONCAT(
			                YEAR(cg2.fecha_mantenimiento),
			                '(',
			                MONTH(cg2.fecha_mantenimiento),
			                ')'
			            ) = CONCAT(
			                YEAR(cg.fecha_inicio),
			                '(',
			                MONTH(cg.fecha_inicio),
			                ')'
			            )
			        )  AND
			        eq.tipo_id LIKE '%" . $param["subproceso_id"] . "%'
			        AND
			     cg2.cierre_id != 0 AND cg2.cierre_id != '' AND cg2.cierre_id IS NOT NULL AND cg2.cierre_id != 14
			)/COUNT(*))*100 as porcentaje_cerrados,
			CONCAT(
			    YEAR(cg.fecha_inicio),
			    '(',
			    MONTH(cg.fecha_inicio),
			    ')'
			) AS mes
			FROM
			    correctivos_generales cg
			LEFT JOIN equipos e ON e.id=cg.equipo_id
			    WHERE cg.fecha_inicio IS NOT NULL AND cg.fecha_inicio!='' AND cg.fecha_inicio!='0000-00-00' AND 
			    e.tipo_id LIKE '%" . $param["subproceso_id"] . "%' 
			GROUP BY
			    YEAR(cg.fecha_inicio) ,
			    MONTH(cg.fecha_inicio) 
			ORDER BY
			    YEAR(cg.fecha_inicio) ASC,
			    MONTH(cg.fecha_inicio) ASC


		";
		return $this->db->query($query)->result();
	}
}
