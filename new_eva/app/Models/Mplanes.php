<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');


/**
 * 
 */
class Mplanes extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function add($param){

		return($this->db->insert("planes_mantenimientos",$param));

	}

	public function getAll(){
		$query='

			SELECT
			    planes_mantenimientos.*,
			    equipos.name AS name,
			    equipos.code AS code,
			    equipos.serial AS serial,
			    equipos.marca AS marca,
			    equipos.modelo AS modelo,
			    equipos.propiedad AS propiedad,
			    estadoequipos.name AS estadoequipo,
			    frecuenciam.name AS frecuencia,
			    servicios.name AS servicio,
			    areas.name AS area,
			    sedes.name AS sede,
			    estadosm.name AS estado_mantenimiento,
			    (
			    SELECT
			        CONCAT(
			            usuarios_editores.nombre,
			            " ",
			            usuarios_editores.apellido,
			            " (",
			            usuarios_editores.username,
			            ")"
			        )
			    FROM
			        cambios_cronograma
			    LEFT JOIN usuarios AS usuarios_editores
			    ON
			        usuarios_editores.id = cambios_cronograma.usuario_id
			    WHERE
			        cambios_cronograma.planes_mantenimientos_id = planes_mantenimientos.id
			    ORDER BY
			        cambios_cronograma.created_at
			    DESC
			LIMIT 1
			) AS usuario_editor,(
			    SELECT
			        cambios_cronograma.created_at
			    FROM
			        cambios_cronograma
			    WHERE
			        cambios_cronograma.planes_mantenimientos_id = planes_mantenimientos.id
			    ORDER BY
			        cambios_cronograma.created_at
			    DESC
			LIMIT 1
			) AS fecha_actualizacion,(
			    SELECT
			        cambios_cronograma.cambio
			    FROM
			        cambios_cronograma
			    WHERE
			        cambios_cronograma.planes_mantenimientos_id = planes_mantenimientos.id
			    ORDER BY
			        cambios_cronograma.created_at
			    DESC
			LIMIT 1
			) AS cambio, CONCAT(
			    usuarios.nombre,
			    " ",
			    usuarios.apellido,
			    " (",
			    usuarios.username,
			    ") "
			) AS usuario,(
			    SELECT
			        fecha_mantenimiento
			    FROM
			        mantenimiento
			    WHERE
			        mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        fecha_mantenimiento
			    DESC
			LIMIT 1
			) AS fecha_ultimo_preventivo, LAST_DAY(
			    CONCAT(
			        planes_mantenimientos.anio,
			        "-",
			        planes_mantenimientos.mes1,
			        "-",
			        15
			    )
			) AS last_day_m1, DATE_ADD(
			    CONCAT(
			        planes_mantenimientos.anio,
			        "-",
			        planes_mantenimientos.mes1,
			        "-",
			        15
			    ),
			    INTERVAL - DAY(
			        CONCAT(
			            planes_mantenimientos.anio,
			            "-",
			            planes_mantenimientos.mes1,
			            "-",
			            15
			        )
			    ) +1 DAY
			) AS first_day_m1, IF(
			    planes_mantenimientos.mes2 IS NULL,
			    NULL,
			    LAST_DAY(
			        CONCAT(
			            planes_mantenimientos.anio,
			            "-",
			            planes_mantenimientos.mes2,
			            "-",
			            15
			        )
			    )
			) AS last_day_m2, IF(
			    planes_mantenimientos.mes2 IS NULL,
			    NULL,
			    DATE_ADD(
			        CONCAT(
			            planes_mantenimientos.anio,
			            "-",
			            planes_mantenimientos.mes2,
			            "-",
			            15
			        ),
			        INTERVAL - DAY(
			            CONCAT(
			                planes_mantenimientos.anio,
			                "-",
			                planes_mantenimientos.mes2,
			                "-",
			                15
			            )
			        ) +1 DAY
			    )
			) AS first_day_m2, IF(
			    planes_mantenimientos.mes3 IS NULL,
			    NULL,
			    LAST_DAY(
			        CONCAT(
			            planes_mantenimientos.anio,
			            "-",
			            planes_mantenimientos.mes3,
			            "-",
			            15
			        )
			    )
			) AS last_day_m3, IF(
			    planes_mantenimientos.mes3 IS NULL,
			    NULL,
			    DATE_ADD(
			        CONCAT(
			            planes_mantenimientos.anio,
			            "-",
			            planes_mantenimientos.mes3,
			            "-",
			            15
			        ),
			        INTERVAL - DAY(
			            CONCAT(
			                planes_mantenimientos.anio,
			                "-",
			                planes_mantenimientos.mes3,
			                "-",
			                15
			            )
			        ) +1 DAY
			    )
			) AS first_day_m3,(
			    SELECT
			        COUNT(*)
			    FROM
			        mantenimiento
			    WHERE
			        mantenimiento.equipo_id = planes_mantenimientos.equipo_id AND YEAR(
			            mantenimiento.fecha_mantenimiento
			        ) = planes_mantenimientos.anio
			) AS realizados,
			(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 1
			    ) THEN(
			    SELECT
			        m.description
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 1
			)
			END
			) AS primer_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 1
			    ) THEN(
			    SELECT
			        m.fecha_mantenimiento
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 1
			)
			END
			) AS fecha_primer_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 1
			    ) THEN(
			    SELECT
			        pm.name
			    FROM
			        mantenimiento m
			    LEFT JOIN proveedores_mantenimiento pm ON
			        pm.id = m.proveedor_mantenimiento_id
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 1
			)
			END
			) AS proveedor_primer_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 2
			    ) THEN(
			    SELECT
			        m.description
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 1,
			    1
			)
			END
			) AS segunda_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 2
			    ) THEN(
			    SELECT
			        m.fecha_mantenimiento
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 1,
			    1
			)
			END
			) AS fecha_segunda_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 2
			    ) THEN(
			    SELECT
			        pm.name
			    FROM
			        mantenimiento m
			    LEFT JOIN proveedores_mantenimiento pm ON
			        pm.id = m.proveedor_mantenimiento_id
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 1,
			    1
			)
			END
			) AS proveedor_segunda_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 3
			    ) THEN(
			    SELECT
			        m.description
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 2,
			    1
			)
			END
			) AS tercer_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 3
			    ) THEN(
			    SELECT
			        m.fecha_mantenimiento
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 2,
			    1
			)
			END
			) AS fecha_tercer_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 3
			    ) THEN(
			    SELECT
			        pm.name
			    FROM
			        mantenimiento m
			    LEFT JOIN proveedores_mantenimiento pm ON
			        pm.id = m.proveedor_mantenimiento_id
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 2,
			    1
			)
			END
			) AS proveedor_tercer_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 4
			    ) THEN(
			    SELECT
			        m.description
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 3,
			    1
			)
			END
			) AS cuarta_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 4
			    ) THEN(
			    SELECT
			        m.fecha_mantenimiento
			    FROM
			        mantenimiento m
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 3,
			    1
			)
			END
			) AS fecha_cuarta_visita,(
			    CASE WHEN(
			        (
			        SELECT
			            COUNT(*)
			        FROM
			            mantenimiento
			        WHERE
			            YEAR(
			                mantenimiento.fecha_mantenimiento
			            ) = planes_mantenimientos.anio AND mantenimiento.equipo_id = planes_mantenimientos.equipo_id
			    ) >= 4
			    ) THEN(
			    SELECT
			        pm.name
			    FROM
			        mantenimiento m
			    LEFT JOIN proveedores_mantenimiento pm ON
			        pm.id = m.proveedor_mantenimiento_id
			    WHERE
			        YEAR(m.fecha_mantenimiento) = planes_mantenimientos.anio AND m.equipo_id = planes_mantenimientos.equipo_id
			    ORDER BY
			        m.fecha_mantenimiento ASC
			    LIMIT 3,
			    1
			)
			END
			) AS proveedor_cuarta_visita
			FROM
			    planes_mantenimientos
			INNER JOIN equipos ON equipos.id = planes_mantenimientos.equipo_id
			LEFT JOIN estadoequipos ON estadoequipos.id = equipos.estadoequipo_id
			LEFT JOIN frecuenciam ON frecuenciam.id = equipos.frecuencia_id
			LEFT JOIN servicios ON servicios.id = equipos.servicio_id
			LEFT JOIN areas ON areas.id = equipos.area_id
			LEFT JOIN sedes ON sedes.id = servicios.sede_id
			LEFT JOIN estadosm ON estadosm.id = equipos.estado_mantenimiento
			LEFT JOIN usuarios ON usuarios.id = planes_mantenimientos.usuario_id

		';
		return $this->db->query($query)->result();
	}

	public function get_server_side($param){
		if ($param['length']<0) {
			$param['length']=999999999;
		}


		$query='

		SELECT  

		planes_mantenimientos.id as id,
		planes_mantenimientos.equipo_id as equipo_id,
		planes_mantenimientos.responsable as responsable,
		equipos.name as equipo,
		equipos.code as code,
		equipos.serial as serial,
		equipos.marca as marca,
		equipos.modelo as modelo,

		LAST_DAY(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes1,"-",15)) AS last_day_m1,

		DATE_ADD(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes1,"-",15),INTERVAL-DAY(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes1,"-",15)) +1 DAY) AS first_day_m1,

		IF(planes_mantenimientos.mes2 is null,null,LAST_DAY(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes2,"-",15))) as last_day_m2,

		IF(planes_mantenimientos.mes2 is null,null,DATE_ADD(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes2,"-",15),INTERVAL-DAY(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes2,"-",15)) +1 DAY)) as first_day_m2,

		IF(planes_mantenimientos.mes3 is null,null,LAST_DAY(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes3,"-",15))) as last_day_m3,

		IF(planes_mantenimientos.mes3 is null,null,DATE_ADD(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes3,"-",15),INTERVAL-DAY(CONCAT(planes_mantenimientos.anio,"-",planes_mantenimientos.mes3,"-",15)) +1 DAY)) as first_day_m3,
		(SELECT COUNT(*) FROM mantenimiento WHERE equipo_id=planes_mantenimientos.equipo_id and YEAR(mantenimiento.fecha_mantenimiento)=planes_mantenimientos.anio) as cantidad_ejecutados,

		(IF(planes_mantenimientos.mes1 is NULL OR planes_mantenimientos.mes1="",0,1)+IF(planes_mantenimientos.mes2 is NULL OR planes_mantenimientos.mes2="",0,1)+IF(planes_mantenimientos.mes3 is NULL OR planes_mantenimientos.mes3="",0,1))as cantidad_programados,
		IF(

(IF(planes_mantenimientos.mes1 is NULL OR planes_mantenimientos.mes1="",0,1)+IF(planes_mantenimientos.mes2 is NULL OR planes_mantenimientos.mes2="",0,1)+IF(planes_mantenimientos.mes3 is NULL OR planes_mantenimientos.mes3="",0,1))
<=
(SELECT COUNT(*) FROM mantenimiento WHERE mantenimiento.equipo_id=planes_mantenimientos.equipo_id and YEAR(mantenimiento.fecha_mantenimiento)=planes_mantenimientos.anio)


		,"Si cumple","No cumple")as cumplimiento_global,
		(SELECT count(*) from cambios_cronograma where cambios_cronograma.planes_mantenimientos_id=planes_mantenimientos.id)as cuenta_cambios


		FROM
		planes_mantenimientos 

		INNER JOIN equipos on equipos.id=planes_mantenimientos.equipo_id


		WHERE 
		planes_mantenimientos.anio='.$param["anio"].' and
		(
		equipos.name like "%'.$param["search"]["value"].'%" or
		equipos.code like "%'.$param["search"]["value"].'%" or
		equipos.serial like "%'.$param["search"]["value"].'%" or
		equipos.id like "%'.$param["search"]["value"].'%" or
		planes_mantenimientos.responsable like "%'.$param["search"]["value"].'%" or

(IF(

(IF(planes_mantenimientos.mes1 is NULL OR planes_mantenimientos.mes1="",0,1)+IF(planes_mantenimientos.mes2 is NULL OR planes_mantenimientos.mes2="",0,1)+IF(planes_mantenimientos.mes3 is NULL OR planes_mantenimientos.mes3="",0,1))
<=
(SELECT COUNT(*) FROM mantenimiento WHERE mantenimiento.equipo_id=planes_mantenimientos.equipo_id and YEAR(mantenimiento.fecha_mantenimiento)=planes_mantenimientos.anio)


		,"Si cumple","No cumple"))

		 like "%'.$param["search"]["value"].'%" 
		)
		';
		
		$limitar=' LIMIT '.$param["start"].','.$param["length"].'';
		$resultl = $this->db->query($query.$limitar);
		$numero_filas_con_limite=$resultl->num_rows();
		$resultado_con_limite=$resultl->result();

		$resultsl = $this->db->query($query); 
		$numero_filas_sin_limite= $resultsl->num_rows();

		$vector=array(
			"datos"=>$resultado_con_limite,
			"num_filas_limit"=>$numero_filas_con_limite,
			"num_filas"=>$numero_filas_sin_limite
		);
		
		return $vector;
	}

	public function getAnios(){
		$query="
		SELECT DISTINCT
		    anio
		FROM
		    planes_mantenimientos
		ORDER BY
		    anio ASC		
		";
		return $this->db->query($query)->result();
	}

	public function deleteYear($param){
		$query="DELETE FROM planes_mantenimientos where anio=".$param;
		$this->db->query($query);
	}

	public function getOne($param){
		$this->db->select("*");
		$this->db->from("planes_mantenimientos");
		$this->db->where("id",$param["id"]);
		return $this->db->get()->result();
	}

	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("planes_mantenimientos",$param);
	}

	public function addControlCambio($param){
		
		return($this->db->insert("cambios_cronograma",$param));

	}
	public function getCambios($param){
		$query="
			SELECT
			    cambios_cronograma.*,
			    CONCAT(
			        usuarios.nombre,' ',
			        usuarios.apellido,'(',
			        usuarios.username,')'
			    ) AS usuario
			FROM
			    `cambios_cronograma`
			LEFT JOIN planes_mantenimientos ON planes_mantenimientos.id = cambios_cronograma.planes_mantenimientos_id
			LEFT JOIN usuarios ON usuarios.id = cambios_cronograma.usuario_id

			WHERE cambios_cronograma.planes_mantenimientos_id=".$param["id"]."

		";
		return $this->db->query($query)->result();
	}

	public function deleteAnterior($param){
		$this->db->where("equipo_id",$param["equipo_id"]);
		$this->db->where("anio",$param["anio"]);
		return $this->db->delete("planes_mantenimientos");
	}
	public function getListadoResponsables(){
		$query="
			SELECT DISTINCT responsable FROM planes_mantenimientos ORDER BY responsable asc
		";
		return $this->db->query($query)->result();
	}
	public function getMantenimientosProgramados($param){
		$query='

			SELECT
			 SUM(
				(
			    	IF(planes_mantenimientos.mes1 is NULL OR planes_mantenimientos.mes1 ='.$param["mes"].',0,1 )+
			    	IF(planes_mantenimientos.mes2 is NULL OR planes_mantenimientos.mes2 ='.$param["mes"].',0,1 )+
			    	IF(planes_mantenimientos.mes3 is NULL OR planes_mantenimientos.mes3 ='.$param["mes"].',0,1 )
				) 
			  )AS cantidad_programados
			FROM
			    planes_mantenimientos
			WHERE 
				planes_mantenimientos.anio='.$param["anio"].' AND
			    (
			    	planes_mantenimientos.mes1='.$param["mes"].' or
			    	planes_mantenimientos.mes2='.$param["mes"].' or
			    	planes_mantenimientos.mes3='.$param["mes"].'
			    )
		';

	}
	public function getPreventivosProgramados($param){
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

			SELECT SUM(cuenta) AS cantidad, fecha AS mes from(
			SELECT COUNT(*) as cuenta,CONCAT(anio,'-',mes1) as fecha  FROM planes_mantenimientos pm
			LEFT JOIN equipos eq ON eq.id=pm.equipo_id
			LEFT JOIN servicios s ON s.id=eq.servicio_id
				 WHERE 
				s.sede_id LIKE '%".$param["sede_id"]."%' AND	
				pm.mes1 !=''
				AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%'
				AND ".$tmp."
				AND ".$multiple_estado_equipo."
				AND responsable LIKE '%".$param["responsable_mantenimiento"]."%'
				GROUP BY CONCAT(anio,'-',mes1) 
				ORDER BY CONCAT(anio,'-',mes1) ASC

			UNION ALL
			SELECT COUNT(*) as cuenta,CONCAT(anio,'-',mes2) as fecha  FROM planes_mantenimientos pm
			LEFT JOIN equipos eq ON eq.id=pm.equipo_id
			LEFT JOIN servicios s ON s.id=eq.servicio_id
				 WHERE 
				s.sede_id LIKE '%".$param["sede_id"]."%' AND	
				pm.mes2 !=''
				AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%'
				AND ".$tmp."
				AND ".$multiple_estado_equipo."
				AND responsable LIKE '%".$param["responsable_mantenimiento"]."%'
				GROUP BY CONCAT(anio,'-',mes2) 
				ORDER BY CONCAT(anio,'-',mes2) ASC

			UNION ALL
			SELECT COUNT(*) as cuenta,CONCAT(anio,'-',mes3) as fecha  FROM planes_mantenimientos pm
			LEFT JOIN equipos eq ON eq.id=pm.equipo_id
			LEFT JOIN servicios s ON s.id=eq.servicio_id
				 WHERE 
				s.sede_id LIKE '%".$param["sede_id"]."%' AND	
				pm.mes3 !=''
				AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%'
				AND ".$tmp."
				AND ".$multiple_estado_equipo."
				AND responsable LIKE '%".$param["responsable_mantenimiento"]."%'
				GROUP BY CONCAT(anio,'-',mes3)
				ORDER BY CONCAT(anio,'-',mes3) ASC


			) t group by t.fecha
			ORDER BY DATE(CONCAT(fecha,'-','20')) ASC
		";
		return $this->db->query($query)->result();
	}
	
}
?>