<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');


/**
* 
*/
class Mpreventivos extends CI_Model
{
	
	function __construct()
	{
		defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get($param){
		$query="
		SELECT
		    p.*,
		    (
		    SELECT
		        COUNT(*)
		    FROM
		        observaciones o
		    WHERE
		        o.preventivo_id = p.id
		) AS nro_notas
		FROM
		    mantenimiento p
		WHERE
    p.equipo_id = ".$param['equipo_id']."
    ORDER BY p.fecha_mantenimiento desc
    ";
		return $this->db->query($query)->result();

	}
	public function get_ind($param){
		$this->db->where("equipo_id",$param['equipo_id']);
		$this->db->order_by("fecha_mantenimiento");
		return $this->db->get("mantenimiento_ind")->result();
	}
	public function add($param){
		$this->db->insert("mantenimiento",$param);
		return $this->db->insert_id();		
	}
	public function add_ind($param){
		$this->db->insert("mantenimiento_ind",$param);
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("mantenimiento")->row();
	}
	public function getOne_ind($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("mantenimiento_ind")->row();
	}
	public function getLast($param){
		$this->db->select("fecha_mantenimiento,file");
		$this->db->from("mantenimiento");
		$this->db->where("equipo_id",$param["equipo_id"]);
		$this->db->order_by("fecha_mantenimiento","desc");
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	public function getLast_ind($param){
		$this->db->select("fecha_mantenimiento,file");
		$this->db->from("mantenimiento_ind");
		$this->db->where("equipo_id",$param["equipo_id"]);
		$this->db->order_by("fecha_mantenimiento","desc");
		$this->db->limit(1);
		return $this->db->get()->row();
	}			
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("mantenimiento",$param);
	}
	public function update_ind($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("mantenimiento_ind",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("mantenimiento");

	}
	public function delete_ind($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("mantenimiento_ind");

	}
	public function get_anios(){
		return $this->db->query("select year(fecha_mantenimiento) as anio from mantenimiento group by year(fecha_mantenimiento) order by year(fecha_mantenimiento) asc")->result();
	}
	public function get_meses($param){
		$query="select month(fecha_mantenimiento) as mes from mantenimiento where year(fecha_mantenimiento)='".$param["anio"]."' group by month(fecha_mantenimiento) order by month(fecha_mantenimiento) asc";
		return $this->db->query($query)->result();
	}
	public function get_preventivos_por_anio($param){
		$query="select 
		equipos.propiedad as propiedad,
		year(mantenimiento.fecha_mantenimiento)as anio,
		count(*)as cantidad,

		(
			SELECT COUNT(*) FROM planes_mantenimientos 
			left join equipos b on b.id=planes_mantenimientos.equipo_id
			left join servicios c on c.id=b.servicio_id
			WHERE b.propiedad=equipos.propiedad
			and planes_mantenimientos.anio=".$param["anio"]." 
			and c.sede_id=".$param["sede"]." 
		)as cantidad_programados,
		(
			(count(*))/((
				SELECT COUNT(*) FROM planes_mantenimientos 
				left join equipos b on b.id=planes_mantenimientos.equipo_id
				left join servicios c on c.id=b.servicio_id
				WHERE b.propiedad=equipos.propiedad
				and planes_mantenimientos.anio=".$param["anio"]." 
				and c.sede_id=".$param["sede"]." 

			))*100
		)as porcentaje

		from mantenimiento
		inner join equipos on equipos.id=mantenimiento.equipo_id
		left join servicios on servicios.id=equipos.servicio_id
		where year(mantenimiento.fecha_mantenimiento)=".$param["anio"]."
		and servicios.sede_id=".$param["sede"]."
		group by equipos.propiedad "
		;
		return $this->db->query($query)->result();
	}
	public function get_preventivos_por_anio_general($param){
		$query="select 
		equipos.propiedad as propiedad,
		year(mantenimiento.fecha_mantenimiento)as anio,
		count(*)as cantidad,

		(
			SELECT COUNT(*) FROM planes_mantenimientos 
			left join equipos b on b.id=planes_mantenimientos.equipo_id
			left join servicios c on c.id=b.servicio_id
			where planes_mantenimientos.anio=".$param["anio"]." 
			and c.sede_id=".$param["sede"]." 
		)as cantidad_programados,
		(
			(count(*))/((
				SELECT COUNT(*) FROM planes_mantenimientos 
				left join equipos b on b.id=planes_mantenimientos.equipo_id
				left join servicios c on c.id=b.servicio_id
				where planes_mantenimientos.anio=".$param["anio"]." 
				and c.sede_id=".$param["sede"]." 

			))*100
		)as porcentaje

		from mantenimiento
		inner join equipos on equipos.id=mantenimiento.equipo_id
		left join servicios on servicios.id=equipos.servicio_id
		where year(mantenimiento.fecha_mantenimiento)=".$param["anio"]."
		and servicios.sede_id=".$param["sede"]."
		group by year(mantenimiento.fecha_mantenimiento) order by year(mantenimiento.fecha_mantenimiento) ASC  	
		"

		;
		return $this->db->query($query)->result();
	}
	public function get_preventivos_por_anio_mes($param){
		$query="select 
		eq.propiedad as propiedad,
		(case 
		when month(m.fecha_mantenimiento)= '1' then 'ENERO'
		when month(m.fecha_mantenimiento)= '2' then 'FEBRERO'
		when month(m.fecha_mantenimiento)= '3' then 'MARZO'
		when month(m.fecha_mantenimiento)= '4' then 'ABRIL'
		when month(m.fecha_mantenimiento)= '5' then 'MAYO'
		when month(m.fecha_mantenimiento)= '6' then 'JUNIO'
		when month(m.fecha_mantenimiento)= '7' then 'JULIO'
		when month(m.fecha_mantenimiento)= '8' then 'AGOSTO'
		when month(m.fecha_mantenimiento)= '9' then 'SEPTIEMPRE'
		when month(m.fecha_mantenimiento)= '10' then 'OCTUBRE'
		when month(m.fecha_mantenimiento)= '11' then 'NOVIEMBRE'
		when month(m.fecha_mantenimiento)= '12' then 'DICIEMBRE'
		END
		)as mes_string,
		month(m.fecha_mantenimiento)as mes,year(m.fecha_mantenimiento)as anio,
		count(*)as cantidad,

		(
		SELECT count(*) from planes_mantenimientos p
		left join equipos e on e.id=p.equipo_id
		left join servicios s on e.servicio_id=s.id

		  WHERE 

		  (mes1=".$param["mes"]." or mes2=".$param["mes"]." or mes3=".$param["mes"].") 

		  and e.propiedad=eq.propiedad 
		  and p.anio=".$param["anio"]."
		  and s.sede_id=".$param["sede"]."


		) as cantidad_programados,

		((count(*))/(		(
		SELECT count(*) from planes_mantenimientos p 
		left join equipos e on e.id=p.equipo_id
		left join servicios s on s.id=e.servicio_id

		  WHERE 

		  (mes1=".$param["mes"]." or mes2=".$param["mes"]." or mes3=".$param["mes"].") 

		  and e.propiedad=eq.propiedad 
		  and p.anio=".$param["anio"]."
		  and s.sede_id=".$param["sede"]."

		))*100) as porcentaje
		
		from mantenimiento m
		left join equipos eq on eq.id=m.equipo_id
		left join servicios s on s.id=eq.servicio_id
		where
		year(m.fecha_mantenimiento)='".$param["anio"]."'
		and month(m.fecha_mantenimiento)='".$param["mes"]."'
		and s.sede_id=".$param["sede"]."

		group by eq.propiedad,year(m.fecha_mantenimiento), month(m.fecha_mantenimiento) order by year(m.fecha_mantenimiento), month(m.fecha_mantenimiento) asc";
		return $this->db->query($query)->result();
	}
	public function get_preventivos_por_anio_mes_general($param){
		$query="select 
		eq.propiedad as propiedad,
		(case 
		when month(m.fecha_mantenimiento)= '1' then 'ENERO'
		when month(m.fecha_mantenimiento)= '2' then 'FEBRERO'
		when month(m.fecha_mantenimiento)= '3' then 'MARZO'
		when month(m.fecha_mantenimiento)= '4' then 'ABRIL'
		when month(m.fecha_mantenimiento)= '5' then 'MAYO'
		when month(m.fecha_mantenimiento)= '6' then 'JUNIO'
		when month(m.fecha_mantenimiento)= '7' then 'JULIO'
		when month(m.fecha_mantenimiento)= '8' then 'AGOSTO'
		when month(m.fecha_mantenimiento)= '9' then 'SEPTIEMPRE'
		when month(m.fecha_mantenimiento)= '10' then 'OCTUBRE'
		when month(m.fecha_mantenimiento)= '11' then 'NOVIEMBRE'
		when month(m.fecha_mantenimiento)= '12' then 'DICIEMBRE'
		END
		)as mes_string,
		month(m.fecha_mantenimiento)as mes,year(m.fecha_mantenimiento)as anio,
		count(*)as cantidad,

		(
		SELECT count(*) from planes_mantenimientos p
		left join equipos e on e.id=p.equipo_id
		left join servicios s on e.servicio_id=s.id

		  WHERE 

		  (mes1=".$param["mes"]." or mes2=".$param["mes"]." or mes3=".$param["mes"].") 

		  and p.anio=".$param["anio"]."
		  and s.sede_id=".$param["sede"]."


		) as cantidad_programados,

		((count(*))/(		(
		SELECT count(*) from planes_mantenimientos p 
		left join equipos e on e.id=p.equipo_id
		left join servicios s on s.id=e.servicio_id

		  WHERE 

		  (mes1=".$param["mes"]." or mes2=".$param["mes"]." or mes3=".$param["mes"].") 

		  and p.anio=".$param["anio"]."
		  and s.sede_id=".$param["sede"]."

		))*100) as porcentaje
		
		from mantenimiento m
		left join equipos eq on eq.id=m.equipo_id
		left join servicios s on s.id=eq.servicio_id
		where
		year(m.fecha_mantenimiento)='".$param["anio"]."'
		and month(m.fecha_mantenimiento)='".$param["mes"]."'
		and s.sede_id=".$param["sede"]."

		group by year(m.fecha_mantenimiento), month(m.fecha_mantenimiento) order by year(m.fecha_mantenimiento), month(m.fecha_mantenimiento) asc";
		return $this->db->query($query)->result();
	}
	public function repuesto_pendiente_true($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		unset($param["equipo_id"]);
		$param["repuesto_pendiente"]="si";
		return $this->db->update("mantenimiento",$param);
	}
	public function repuesto_pendiente_false($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		unset($param["equipo_id"]);
		$param["repuesto_pendiente"]="no";
		return $this->db->update("mantenimiento",$param);
	}	
	public function cuenta_registros_repuestos_pendientes($param){
		$query="
		SELECT
		COUNT(*) AS total
		FROM
		mantenimiento
		WHERE
		mantenimiento.equipo_id = ".$param."
		and repuesto_pendiente='si'		
		";
		return $this->db->query($query)->row();
	}

	public function getPreventivos(){
		$this->db->select("equipos.name as equipo,equipos.marca as marca,equipos.modelo as modelo,equipos.serial as serial,equipos.code as code,mantenimiento.description as codigo, mantenimiento.fecha_mantenimiento as fecha_ejecucion,mantenimiento.fecha_programada as fecha_programada, servicios.name as ubicacion, mantenimiento.file as archivo,mantenimiento.observacion as observacion");
		$this->db->from("equipos");
		$this->db->join("mantenimiento","mantenimiento.equipo_id=equipos.id");
		$this->db->join("servicios","equipos.servicio_id=servicios.id");
		$this->db->where("equipos.status=1");
		$this->db->where("equipos.tipo_id=".$this->session->userdata("tipo_id"));
		$this->db->order_by("mantenimiento.fecha_mantenimiento","asc");
		return $this->db->get()->result();
	}

	public function getMantenimientosAll(){
		/*
		$this->db->select("
			equipos.*,
			CONCAT(MONTH(mantenimiento.fecha_mantenimiento),'.. Codigo=',equipos.code,' serie=',equipos.serial,' Nombre= ',equipos.name,' Reporte=',mantenimiento.description,' Proveedor= ') as codificacion,
			mantenimiento.description as codigo,
			mantenimiento.fecha_mantenimiento as fecha_ejecucion,
			mantenimiento.fecha_programada as fecha_programada,
			servicios.name as ubicacion,
			mantenimiento.file as archivomtto,
			mantenimiento.observacion as observacion_mtto,
			sedes.name as sede,
			areas.name as area,
			estadoequipos.name as estado_equipo,
			pm.name as proveedor_mantenimiento

			");*/
		$this->db->select("
			equipos.*,
			CONCAT(MONTH(mantenimiento.fecha_mantenimiento),'.. Codigo=',equipos.code,' serie=',equipos.serial,' Nombre= ',equipos.name,' Reporte=',mantenimiento.description,' anio= ',' ..(',YEAR(mantenimiento.fecha_mantenimiento),')..',' (ID=',equipos.id) as codificacion,
			mantenimiento.description as codigo,
			mantenimiento.fecha_mantenimiento as fecha_ejecucion,
			mantenimiento.fecha_programada as fecha_programada,
			servicios.name as ubicacion,
			mantenimiento.file as archivomtto,
			mantenimiento.observacion as observacion_mtto,
			sedes.name as sede,
			areas.name as area,
			estadoequipos.name as estado_equipo,
			pm.name as proveedor_mantenimiento

			");
		$this->db->from("equipos");
		$this->db->join("mantenimiento","mantenimiento.equipo_id=equipos.id");
		$this->db->join("proveedores_mantenimiento pm","mantenimiento.proveedor_mantenimiento_id=pm.id","left");
		$this->db->join("servicios","equipos.servicio_id=servicios.id","left");
		$this->db->join("areas","equipos.area_id=areas.id","left");
		$this->db->join("sedes","servicios.sede_id=sedes.id","left");
		$this->db->join("estadoequipos","estadoequipos.id=equipos.estadoequipo_id","left");
		$this->db->where("equipos.status=1 and equipos.tipo_id=1");
		$this->db->order_by("mantenimiento.fecha_mantenimiento","asc");
		return $this->db->get()->result();
	}
	public function getPreventivosEjecutados($param){

		if (!isset($param["tadquisicion_id"])) {
			$tmp= "( eq.tadquisicion_id LIKE '%%' ) ";
		}else{

			if (sizeof($param["tadquisicion_id"])==1) {

				$valor = $param["tadquisicion_id"][0];
				$tmp=" ( eq.tadquisicion_id LIKE '%".$valor."%') ";

			}else{
				$vector=$param["tadquisicion_id"];
				$tmp="";
				$contador=0;
				$tamanio=sizeof($vector);
				foreach ($vector as $elemento) {
					$contador=$contador+1;
					if ($contador==1) {
						$tmp.=" ( eq.tadquisicion_id LIKE '%".$elemento."%' OR";
					}
					if ($contador>1&&$contador<$tamanio) {
						$tmp.=" eq.tadquisicion_id LIKE '%".$elemento."%' OR";
					}
					if ($contador==$tamanio) {
						$tmp.=" eq.tadquisicion_id LIKE '%".$elemento."%'  )";
					}
				}
			}

		}		
		if (!isset($param["estadoequipo_id"])) {
			$multiple_estado_equipo= "( eq.estadoequipo_id LIKE '%%' ) ";
		}else{

			if (sizeof($param["estadoequipo_id"])==1) {

				$valor = $param["estadoequipo_id"][0];
				$multiple_estado_equipo=" ( eq.estadoequipo_id LIKE '%".$valor."%') ";

			}else{
				$vector=$param["estadoequipo_id"];
				$multiple_estado_equipo="";
				$contador=0;
				$tamanio=sizeof($vector);
				foreach ($vector as $elemento) {
					$contador=$contador+1;
					if ($contador==1) {
						$multiple_estado_equipo.=" ( eq.estadoequipo_id LIKE '%".$elemento."%' OR";
					}
					if ($contador>1&&$contador<$tamanio) {
						$multiple_estado_equipo.=" eq.estadoequipo_id LIKE '%".$elemento."%' OR";
					}
					if ($contador==$tamanio) {
						$multiple_estado_equipo.=" eq.estadoequipo_id LIKE '%".$elemento."%'  )";
					}
				}
			}

		}				
		$query="
			SELECT
			    COUNT(*) AS cantidad,
			    CONCAT(
			        YEAR(m.fecha_mantenimiento),
			        '(',
			        MONTH(m.fecha_mantenimiento),
			        ')'
			    ) AS mes
			FROM
			    mantenimiento m
			LEFT JOIN equipos eq ON
			    eq.id = m.equipo_id
			LEFT JOIN servicios s ON 
				s.id = eq.servicio_id    
			WHERE
			    eq.tipo_id LIKE '%".$param["subproceso_id"]."%' AND ".$tmp." AND
			    s.sede_id LIKE '%".$param["sede_id"]."%' AND ".$multiple_estado_equipo."
			AND (
			    SELECT
			        responsable
			    FROM
			        planes_mantenimientos pm
			    WHERE
			        pm.equipo_id = eq.id AND
			      	pm.anio = YEAR(m.fecha_mantenimiento)
				LIMIT 1
			) LIKE '%".$param["responsable_mantenimiento"]."%'			    

			GROUP BY
			    CONCAT(
			        YEAR(m.fecha_mantenimiento),
			        '(',
			        MONTH(m.fecha_mantenimiento),
			        ')'
			    )
			ORDER BY
			    (
			        DATE(
			            CONCAT(
			                YEAR(m.fecha_mantenimiento),
			                '-',
			                MONTH(m.fecha_mantenimiento),
			                '-',
			                20
			            )
			        )
			    ) ASC
			    
		";
		return $this->db->query($query)->result();
	}
	public function getPreventivosIndicador($param){

		if (!isset($param["tadquisicion_id"])) {
			$tmp= "( eq.tadquisicion_id LIKE '%%' ) ";
		}else{

			if (sizeof($param["tadquisicion_id"])==1) {

				$valor = $param["tadquisicion_id"][0];
				$tmp=" ( eq.tadquisicion_id LIKE '%".$valor."%') ";

			}else{
				$vector=$param["tadquisicion_id"];
				$tmp="";
				$contador=0;
				$tamanio=sizeof($vector);
				foreach ($vector as $elemento) {
					$contador=$contador+1;
					if ($contador==1) {
						$tmp.=" ( eq.tadquisicion_id LIKE '%".$elemento."%' OR";
					}
					if ($contador>1&&$contador<$tamanio) {
						$tmp.=" eq.tadquisicion_id LIKE '%".$elemento."%' OR";
					}
					if ($contador==$tamanio) {
						$tmp.=" eq.tadquisicion_id LIKE '%".$elemento."%'  )";
					}
				}
			}

		}
		if (!isset($param["estadoequipo_id"])) {
			$multiple_estado_equipo= "( eq.estadoequipo_id LIKE '%%' ) ";
		}else{

			if (sizeof($param["estadoequipo_id"])==1) {

				$valor = $param["estadoequipo_id"][0];
				$multiple_estado_equipo=" ( eq.estadoequipo_id LIKE '%".$valor."%') ";

			}else{
				$vector=$param["estadoequipo_id"];
				$multiple_estado_equipo="";
				$contador=0;
				$tamanio=sizeof($vector);
				foreach ($vector as $elemento) {
					$contador=$contador+1;
					if ($contador==1) {
						$multiple_estado_equipo.=" ( eq.estadoequipo_id LIKE '%".$elemento."%' OR";
					}
					if ($contador>1&&$contador<$tamanio) {
						$multiple_estado_equipo.=" eq.estadoequipo_id LIKE '%".$elemento."%' OR";
					}
					if ($contador==$tamanio) {
						$multiple_estado_equipo.=" eq.estadoequipo_id LIKE '%".$elemento."%'  )";
					}
				}
			}

		}					
		$query="
			SELECT
			    fecha AS mes,
			((
			    SELECT
			        COUNT(*)
			    FROM
			        mantenimiento m
			    LEFT JOIN equipos eq ON eq.id=m.equipo_id
			    LEFT JOIN servicios s ON s.id=eq.servicio_id    
			    WHERE
			    s.sede_id LIKE '%".$param["sede_id"]."%' AND
			        CONCAT(
			            YEAR(m.fecha_mantenimiento),
			            '-',
			            MONTH(m.fecha_mantenimiento)
			        ) = t.fecha
			        AND
			        eq.tipo_id LIKE '%".$param["subproceso_id"]."%' AND
			        ".$tmp." AND ".$multiple_estado_equipo."
					AND (
					    SELECT
					        responsable
					    FROM
					        planes_mantenimientos pm
					    WHERE
					        pm.equipo_id = eq.id AND
					      	pm.anio = YEAR(m.fecha_mantenimiento)
						LIMIT 1
					) LIKE '%".$param["responsable_mantenimiento"]."%'			        
			        
			)/SUM(cuenta))*100 AS porcentaje
			FROM
			    (
			    SELECT
			        COUNT(*) AS cuenta,
			        CONCAT(anio, '-', mes1) AS fecha
			    FROM
			        planes_mantenimientos pm
			    LEFT JOIN equipos eq ON
			        eq.id = pm.equipo_id
			        LEFT JOIN servicios s ON s.id=eq.servicio_id
			    WHERE
			    s.sede_id LIKE '%".$param["sede_id"]."%' AND
			        pm.mes1 != '' AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%' AND ".$tmp." AND ".$multiple_estado_equipo."
				AND responsable LIKE '%".$param["responsable_mantenimiento"]."%'
			    GROUP BY
			        CONCAT(anio, '-', mes1) 
			    ORDER BY
			        CONCAT(anio, '-', mes1) ASC
			    UNION ALL
			SELECT
			    COUNT(*) AS cuenta,
			    CONCAT(anio, '-', mes2) AS fecha
			FROM
			    planes_mantenimientos pm
			LEFT JOIN equipos eq ON
			    eq.id = pm.equipo_id
			    LEFT JOIN servicios s ON s.id=eq.servicio_id
			WHERE
			s.sede_id LIKE '%".$param["sede_id"]."%' AND
			    pm.mes2 != '' AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%' AND ".$tmp." AND ".$multiple_estado_equipo."
				AND responsable LIKE '%".$param["responsable_mantenimiento"]."%'
			GROUP BY
			    CONCAT(anio, '-', mes2) 
			ORDER BY
			    CONCAT(anio, '-', mes2) ASC
			UNION ALL
			SELECT
			    COUNT(*) AS cuenta,
			    CONCAT(anio, '-', mes3) AS fecha
			FROM
			    planes_mantenimientos pm
			LEFT JOIN equipos eq ON
			    eq.id = pm.equipo_id
			    LEFT JOIN servicios s ON s.id=eq.servicio_id
			WHERE
			s.sede_id LIKE '%".$param["sede_id"]."%' AND
			    pm.mes3 != '' AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%' AND ".$tmp." AND ".$multiple_estado_equipo."
				AND responsable LIKE '%".$param["responsable_mantenimiento"]."%'
			GROUP BY
			    CONCAT(anio, '-', mes3) 
			ORDER BY
			    CONCAT(anio, '-', mes3) ASC
			) t
			GROUP BY
			    t.fecha
			ORDER BY
			    DATE(CONCAT(t.fecha, '-', '20')) ASC

		";

		return $this->db->query($query)->result();
	}

	public function DecodificarParaZip($param){
		$query='
			SELECT
			    m.description AS original,
			    m.file AS codificado,
			    CONCAT(
			        m.fecha_mantenimiento,
			        " (",
			        m.description,
			        ") ID-",
			        eq.id
			    ) AS nuevo
			FROM
			    mantenimiento m
			LEFT JOIN equipos eq ON
			    eq.id = m.equipo_id
			WHERE
			    m.file IS NOT NULL
			    AND 
			    CONCAT(
			        YEAR(m.fecha_mantenimiento),
			        "-",
			        MONTH(m.fecha_mantenimiento)
			    ) = "'.$param["fecha_preventivos"].'"
			ORDER BY
			    m.fecha_mantenimiento ASC
		';
		return $this->db->query($query)->result();
	}
	public function get_fechas_validas_ejecucion(){
		$query='
			SELECT
			    CONCAT(
			        YEAR(fecha_mantenimiento),
			        "-",
			        MONTH(fecha_mantenimiento)
			    )AS fecha_efectiva
			FROM
			    mantenimiento
			GROUP BY
			    EXTRACT(
			        YEAR_MONTH
			    FROM
			        fecha_mantenimiento
			    ) 
			ORDER BY
			    EXTRACT(
			        YEAR_MONTH
			    FROM
			        fecha_mantenimiento
			    ) 

			    GROUP BY 
			    EXTRACT(
			        YEAR_MONTH
			    FROM
			        fecha_mantenimiento
			    ) 
			    ORDER BY 
			    EXTRACT(
			        YEAR_MONTH
			    FROM
			        fecha_mantenimiento
			    ) ASC			    			    
		';
		return $this->db->query($query)->result();
	}
	
}
?>