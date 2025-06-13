<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcapacitaciones extends CI_Model
{
	
	function __construct()
	{
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}

	public function getAll(){
		$query="
			SELECT
			    equipos.name AS equipo,
			    equipos.marca AS marca,
			    equipos.modelo AS modelo,
			    servicios.name AS servicio,
			    COUNT(*) AS cantidad,
			    equipo_archivo.vinculo as vinculo
			FROM
			    `equipo_archivo`
			INNER JOIN equipos ON equipos.id = equipo_archivo.equipo_id
			INNER JOIN servicios ON servicios.id = equipos.servicio_id
			WHERE
			    equipo_archivo.archivo_id = 9
			GROUP BY
			    equipos.name,
			    equipos.modelo,
			    servicios.name
			ORDER BY
			    equipos.name ASC,
			    servicios.name ASC,
				cantidad desc
		";
		return $this->db->query($query)->result();
	}
	public function getCapacitacionesArchivo(){
		$query="
			SELECT
			    equipo_archivo.id,
			    equipo_archivo.vinculo AS vinculo,
			    equipo_archivo.created_at AS fecha_ingreso,
			    equipos.name AS equipo,
			    equipos.marca AS marca,
			    servicios.name AS servicio
			FROM
			    `equipo_archivo`
			INNER JOIN equipos ON equipos.id = equipo_archivo.equipo_id
			INNER JOIN servicios ON servicios.id = equipos.servicio_id
			WHERE
			    equipo_archivo.archivo_id = 9
			GROUP BY
			    equipo_archivo.vinculo,
			    equipo_archivo.created_at
			ORDER BY
			    equipo_archivo.id ASC,
			    equipos.name ASC,
			    servicios.name ASC
		";
		return $this->db->query($query)->result();

	}
	public function getCapacitacionesEquipo(){
		$query="
		SELECT
		    t.equipo AS equipo,
		    COUNT(*) AS cantidad,
		    (
		        CONCAT(
		            YEAR(t.created_at),
		            '(',
		            MONTH(t.created_at),
		            ')'
		        )
		    ) AS mes
		FROM
		    (
		    SELECT
		        (CONCAT(eq.name, ' ', eq.marca)) AS equipo,
		        ea.vinculo,
		        ea.created_at
		    FROM
		        equipo_archivo ea
		    LEFT JOIN equipos eq ON
		        eq.id = ea.equipo_id
		    WHERE
		        ea.archivo_id = 9
		    GROUP BY
		        ea.vinculo
		    ORDER BY
		        ea.created_at
		    DESC
		) t
		GROUP BY
		    (
		        EXTRACT(YEAR_MONTH
		    FROM
		        t.created_at)
		    ) ,
		    t.equipo 
		ORDER BY
		    (
		        EXTRACT(YEAR_MONTH
		    FROM
		        t.created_at)
		    ) ASC,
		    t.equipo ASC
		";
		return $this->db->query($query)->result();

	}
	public function getCapacitacionesMes(){
		$query="
		SELECT
		    COUNT(*) AS cantidad,
		    (
		        CONCAT(
		            YEAR(t.created_at),
		            '(',
		            MONTH(t.created_at),
		            ')'
		        )
		    ) AS mes
		FROM
		    (
		    SELECT
		        ea.vinculo,
		        ea.created_at
		    FROM
		        equipo_archivo ea
		    LEFT JOIN equipos eq ON
		        eq.id = ea.equipo_id
		    WHERE
		        ea.archivo_id = 9
		    GROUP BY
		        ea.vinculo
		    ORDER BY
		        ea.created_at
		    DESC
		) t
		GROUP BY
		    (
		        EXTRACT(YEAR_MONTH
		    FROM
		        t.created_at)
		    ) 
		ORDER BY
		    (
		        EXTRACT(YEAR_MONTH
		    FROM
		        t.created_at)
		    ) ASC
		";
		return $this->db->query($query)->result();

	}



}
 ?>