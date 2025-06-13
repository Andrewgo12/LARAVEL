<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mequipo_repuestos extends CI_Model
{
	
	function __construct()
	{
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get($param){
		$this->db->select("equipo_repuestos.*,repuestos.name as repuesto, repuestos.code as codigo_repuesto,(SELECT CONCAT(usuarios.nombre,' ',usuarios.apellido,' (',usuarios.username,') ')) as usuario");
		$this->db->from("equipo_repuestos");
		$this->db->join("repuestos","repuestos.id=equipo_repuestos.repuesto_id","left");
		$this->db->join("usuarios","usuarios.id=equipo_repuestos.usuario_id","left");
		$this->db->where("equipo_repuestos.equipo_id",$param['equipo_id']);
		$this->db->order_by("fecha","desc");

		return $this->db->get()->result();
	}
	public function getEquipoRepuestosCorrectivosgenerales($param){
		$this->db->select("equipo_repuestos.*,repuestos.name as repuesto, repuestos.code as codigo_repuesto,(SELECT CONCAT(usuarios.nombre,' ',usuarios.apellido,' (',usuarios.username,') ')) as usuario");
		$this->db->from("equipo_repuestos");
		$this->db->join("repuestos","repuestos.id=equipo_repuestos.repuesto_id","left");
		$this->db->join("usuarios","usuarios.id=equipo_repuestos.usuario_id","left");
		$this->db->where("equipo_repuestos.correctivo_general_id",$param['correctivo_general_id']);
		$this->db->order_by("fecha","desc");

		return $this->db->get()->result();
	}
	public function getAll(){
		$this->db->select("
			equipo_repuestos.*,
			repuestos.name as repuesto,
			equipos.name as equipo_nombre,
			equipos.code as equipo_codigo,
			equipos.serial as equipo_serie,
			equipos.marca as marca,
			equipos.modelo as modelo,
			servicios.name as servicio,
			repuestos.precio as precio,
			(repuestos.precio)*(equipo_repuestos.cantidad_entregada) as precio_global,
			repuestos.code as codigo_repuesto,
			(SELECT CONCAT(usuarios.nombre,'',usuarios.apellido,'(',usuarios.username,')')) as usuario

			");
		$this->db->from("equipo_repuestos");
		$this->db->join("repuestos","repuestos.id=equipo_repuestos.repuesto_id","left");
		$this->db->join("equipos","equipos.id=equipo_repuestos.equipo_id","left");
		$this->db->join("servicios","equipos.servicio_id=servicios.id","left");
		$this->db->join("usuarios","usuarios.id=equipo_repuestos.usuario_id","left");
		$this->db->order_by("equipo_repuestos.fecha","desc");
		return $this->db->get()->result();

	}
	public function getCOnsolidadoAnioMes(){
		$query="
			SELECT
			    YEAR(er.fecha) AS anio,
			    (
			    SELECT CASE
			        MONTH(er.fecha) WHEN '1' THEN 'ENERO' WHEN '2' THEN 'FEBRERO' WHEN '3' THEN 'MARZO' WHEN '4' THEN 'ABRIL' WHEN '5' THEN 'MAYO' WHEN '6' THEN 'JUNIO' WHEN '7' THEN 'JULIO' WHEN '8' THEN 'AGOSTO' WHEN '9' THEN 'SEPTIEMBRE' WHEN '10' THEN 'OCTUBRE' WHEN '11' THEN 'NOVIEMBRE' WHEN '12' THEN 'DICIEMBRE'
			END
			) AS mes,
			r.name AS repuesto,
			(SELECT FORMAT(r.precio,2)) AS costo_unidad,
			(FORMAT((r.precio*COUNT(*)*er.cantidad_entregada),2))AS costo_total,			
			(COUNT(*)*er.cantidad_entregada) AS cantidad
			FROM
			    equipo_repuestos er
			LEFT JOIN repuestos r ON
			    r.id = er.repuesto_id
			GROUP BY
				YEAR(er.fecha) ,
			    MONTH(er.fecha) ,
			    r.name 
			ORDER BY
				YEAR(er.fecha) DESC,
			    MONTH(er.fecha) DESC,
			    r.name ASC
		";
		return $this->db->query($query)->result();
	}
	public function getCOnsolidadoAnioMesGeneral(){
		$query="
			SELECT
			    YEAR(er.fecha) AS anio,
			    (
			    SELECT CASE
			        MONTH(er.fecha) WHEN '1' THEN 'ENERO' WHEN '2' THEN 'FEBRERO' WHEN '3' THEN 'MARZO' WHEN '4' THEN 'ABRIL' WHEN '5' THEN 'MAYO' WHEN '6' THEN 'JUNIO' WHEN '7' THEN 'JULIO' WHEN '8' THEN 'AGOSTO' WHEN '9' THEN 'SEPTIEMBRE' WHEN '10' THEN 'OCTUBRE' WHEN '11' THEN 'NOVIEMBRE' WHEN '12' THEN 'DICIEMBRE'
			END
			) AS mes,
			CONCAT('$ ',FORMAT(SUM(er.cantidad_entregada*r.precio),2)) AS costo_total,
			SUM(er.cantidad_entregada) as cantidad

			FROM
			    equipo_repuestos er
			LEFT JOIN repuestos r ON
			    r.id = er.repuesto_id
			GROUP BY
			    YEAR(er.fecha) ,
			    MONTH(er.fecha) 
			ORDER BY
			    YEAR(er.fecha) ASC,
			    MONTH(er.fecha) ASC
		";
		return $this->db->query($query)->result();
	}
	public function getPendientesPorCorrectivos(){
		$query="
		SELECT
		    equipos.id AS id,
		    equipos.name AS equipo,
		    equipos.code AS codigo,
		    equipos.serial AS serie,
		    equipos.marca AS marca,
		    equipos.modelo AS modelo,
		    servicios.name AS servicio,
		    sedes.name AS sede,
		    correctivos_generales.code AS codigo_cierre_correctivo,
		    correctivos_generales.repuesto_id AS repuesto_por_correctivo,
		    correctivos_generales.fecha_mantenimiento AS fecha_mantenimiento,
		    (SELECT planes_mantenimientos.responsable from planes_mantenimientos WHERE equipo_id = equipos.id ORDER BY planes_mantenimientos.anio desc limit 1) AS proveedor_mantenimiento,
		    (SELECT correctivos_generales.fecha_mantenimiento from correctivos_generales where equipo_id = equipos.id ORDER BY correctivos_generales.fecha_mantenimiento desc limit 1) AS fecha_ultimo_mantenimiento,
		    (SELECT correctivos_generales.code from correctivos_generales where equipo_id = equipos.id ORDER BY correctivos_generales.fecha_mantenimiento desc limit 1) AS codigo_ultimo_mantenimiento,
		    zonas.name as zona	
	
		FROM
		    `equipos`
		LEFT JOIN correctivos_generales ON correctivos_generales.equipo_id = equipos.id
		LEFT JOIN servicios ON servicios.id = equipos.servicio_id
		LEFT JOIN sedes ON sedes.id = servicios.sede_id
		LEFT JOIN zonas ON zonas.id = servicios.zona_id
		WHERE
		    equipos.repuesto_pendiente = 'si' AND correctivos_generales.repuesto_pendiente = 'si'
		    ORDER BY servicios.name ASC,correctivos_generales.fecha_mantenimiento ASC		
		
		";
		return $this->db->query($query)->result();
	}
	public function getPendientesPorPreventivos(){
		$query="

		SELECT
		    equipos.id AS id,
		    equipos.name AS equipo,
		    equipos.code AS codigo,
		    equipos.serial AS serie,
		    equipos.marca AS marca,
		    equipos.modelo AS modelo,
		    servicios.name AS servicio,
		    sedes.name AS sede,
		    mantenimiento.description AS codigo_cierre_preventivo,
		    mantenimiento.repuesto_id AS repuesto_por_preventivo,
		    mantenimiento.fecha_mantenimiento AS fecha_mantenimiento,
		    (SELECT planes_mantenimientos.responsable from planes_mantenimientos WHERE equipo_id = equipos.id ORDER BY planes_mantenimientos.anio desc limit 1) AS proveedor_mantenimiento,
		    zonas.name as zona		    
		FROM
		    `equipos`
		LEFT JOIN mantenimiento ON mantenimiento.equipo_id = equipos.id
		LEFT JOIN servicios ON servicios.id = equipos.servicio_id
		LEFT JOIN sedes ON sedes.id = servicios.sede_id
		LEFT JOIN zonas ON zonas.id = servicios.zona_id

		WHERE
		    equipos.repuesto_pendiente = 'si' AND mantenimiento.repuesto_pendiente = 'si'
		
		";
		return $this->db->query($query)->result();
	}
	public function getPendientesPorObservaciones(){
		$query="

		SELECT
		    equipos.id AS id,
		    equipos.name AS equipo,
		    equipos.code AS codigo,
		    equipos.serial AS serie,
		    equipos.marca AS marca,
		    equipos.modelo AS modelo,
		    servicios.name AS servicio,
		    sedes.name AS sede,
		    observaciones.repuesto_id AS repuesto_por_observacion,
		    observaciones.created_at AS created_at,
			(SELECT planes_mantenimientos.responsable from planes_mantenimientos WHERE planes_mantenimientos.equipo_id = equipos.id ORDER BY planes_mantenimientos.anio desc limit 1) AS proveedor_mantenimiento,
			zonas.name as zona			    
		FROM
		    `equipos`
		LEFT JOIN observaciones ON observaciones.equipo_id = equipos.id
		LEFT JOIN servicios ON servicios.id = equipos.servicio_id
		LEFT JOIN sedes ON sedes.id = servicios.sede_id
		LEFT JOIN zonas ON zonas.id = servicios.zona_id

		WHERE
		    equipos.repuesto_pendiente = 'si' AND observaciones.repuesto_pendiente = 'si'
		
		";
		return $this->db->query($query)->result();
	}
	public function add($param){
		$this->db->insert("equipo_repuestos",$param);
	}
	public function add_ind($param){
		$this->db->insert("calibracion_ind",$param);
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("equipo_repuestos")->row();
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("equipo_repuestos",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("equipo_repuestos");
	}


public function getOne_ind($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("calibracion_ind")->row();
	}
	public function update_ind($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("calibracion_ind",$param);
	}
	public function delete_ind($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("calibracion_ind");
	}
	public function getDistribucionRepuestos(){
		$query="
			SELECT
			    servicios.name as servicio,YEAR(equipo_repuestos.fecha) as anio,repuestos.name as repuesto,COUNT(*) as cantidad_entregada
			FROM
			    equipo_repuestos
			INNER JOIN repuestos on repuestos.id=equipo_repuestos.repuesto_id
			INNER JOIN equipos ON equipos.id = equipo_repuestos.equipo_id
			INNER JOIN servicios ON servicios.id = equipos.servicio_id    
			GROUP BY
			    servicios.id,YEAR(equipo_repuestos.fecha),repuestos.name
			    ORDER BY servicios.name ASC
		";
		return $this->db->query($query)->result();
	}	
	public function getInversionRepuestosequipo(){
		$query='
			SELECT
			    e.id AS id,
			    CONCAT(
			        e.name,
			        " ",
			        e.marca,
			        " ",
			        e.modelo
			    ) AS equipo,
			    e.code AS codigo,
			    e.serial AS serie,
			    YEAR(er.fecha) AS anio,
			    FORMAT(
			        SUM(
			            er.cantidad_entregada * r.precio
			        ),
			        2
			    ) AS costo_total,
			    SUM(er.cantidad_entregada) AS cantidad
			FROM
			    equipo_repuestos er
			LEFT JOIN repuestos r ON
			    r.id = er.repuesto_id
			LEFT JOIN equipos e ON
			    e.id = er.equipo_id
			GROUP BY
			    YEAR(er.fecha),
			    e.id
			ORDER BY
			    YEAR(er.fecha) DESC,
			    SUM(
			        er.cantidad_entregada * r.precio
			    )
			DESC
			';
		return $this->db->query($query)->result();
	}
	public function getInversionRepuestosServicio(){
		$query='
			SELECT
			    s.name AS servicio,
			    sed.name AS sede,
			    YEAR(er.fecha) AS anio,
			    FORMAT(
			        SUM(
			            er.cantidad_entregada * r.precio
			        ),
			        2
			    ) AS costo_total,
			    SUM(er.cantidad_entregada) AS cantidad
			FROM
			    equipo_repuestos er
			LEFT JOIN repuestos r ON
			    r.id = er.repuesto_id
			LEFT JOIN equipos e ON
			    e.id = er.equipo_id
			LEFT JOIN servicios s ON
			    s.id = e.servicio_id
			LEFT JOIN sedes sed ON
			    sed.id = s.sede_id
			GROUP BY
			    YEAR(er.fecha),
			    s.name
			ORDER BY
			    YEAR(er.fecha)
			DESC
			    ,
			    SUM(
			        er.cantidad_entregada * r.precio
			    )
			DESC
    			
			';
		return $this->db->query($query)->result();
	}
}
 ?>