<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mguias extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function get()
	{
		$this->db->where("estado", 1);
		return $this->db->get("guias_rapidas")->result();
	}

	public function getAll()
	{

		$query = "

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
		";
		return $this->db->query($query)->result();
	}
	public function getOne($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->get("guias_rapidas")->row();
	}
	public function add($param)
	{

		$this->db->insert('guias_rapidas', $param);
	}
	public function update($param)
	{

		$this->db->where('id', $param['id']);
		unset($param['id']);
		return $this->db->update('guias_rapidas', $param);
	}
	public function delete($param, $array)
	{
		$this->db->where('id', $param['id']);
		$this->db->update('categorias', $array);
	}
	public function getByFile($param)
	{
		$this->db->where("file", $param);
		return $this->db->get("guias_rapidas")->num_rows();
	}
	public function get_indicador_por_guia()
	{
		$query = "
			SELECT
			    MAX(cantidad_individual) AS cantidad_individual,
			    MAX(cantidad_total) AS cantidad_total,
			    MAX(porcentaje) AS porcentaje,
			    nombre
			FROM
			    (
			        (
			        SELECT
			            0 AS cantidad_individual,
			            COUNT(*) AS cantidad_total,
			            0 AS porcentaje,
			            eq3.name AS nombre
			        FROM
			            equipos eq3
			        WHERE
			            eq3.guia_id = 0 AND eq3.estadoequipo_id NOT IN(
			            SELECT
			                estadoequipo_id
			            FROM
			                estados_excluidos_guias
			        ) AND eq3.criesgo_id IN(
			        SELECT
			            criesgo_id
			        FROM
			            riesgos_incluidos_guias
			    )
			GROUP BY
			    eq3.name
			    )
			UNION ALL
			    (
			    SELECT
			        COUNT(*) AS cantidad_individual,
			        eq2.cantidad_total AS cantidad_total,
			        (COUNT(*) / eq2.cantidad_total) * 100 AS porcentaje,
			        eq1.name AS nombre
			    FROM
			        equipos eq1
			    JOIN(
			        SELECT
			            COUNT(*) AS cantidad_total,
			            equipos.name
			        FROM
			            equipos
			        WHERE
			            equipos.estadoequipo_id NOT IN(
			            SELECT
			                estadoequipo_id
			            FROM
			                estados_excluidos_guias
			        ) AND equipos.criesgo_id IN(
			        SELECT
			            criesgo_id
			        FROM
			            riesgos_incluidos_guias
			        )
			    GROUP BY
			        equipos.name
			    ) eq2
			ON
			    eq1.name = eq2.name
			WHERE
			    eq1.guia_id != 0 AND eq1.estadoequipo_id NOT IN(
			    SELECT
			        estadoequipo_id
			    FROM
			        estados_excluidos_guias
			) AND eq1.criesgo_id IN(
			    SELECT
			        criesgo_id
			    FROM
			        riesgos_incluidos_guias
			)
			GROUP BY
			    eq1.name
			)
			ORDER BY
			    porcentaje
			DESC
			    ,
			    nombre ASC
			    ) AS tabla
			GROUP BY
			    nombre
			ORDER BY
			    porcentaje
			DESC
			    ,
			    nombre ASC
		";
		return $this->db->query($query)->result();
	}
	public function get_relaciones()
	{
		$query = '
			SELECT
				e.name as name,
				e.marca as marca,
				e.modelo as modelo,
			    CONCAT(
			        e.name,
			        "|",
			        e.marca,
			        "|",
			        e.modelo
			    ) AS consulta,
			    COUNT(*) AS cuenta
			FROM
			    equipos e
			WHERE
			    e.tipo_id = 1 AND e.guia_id = 0 AND
			    e.estadoequipo_id!=6 AND
			    e.estadoequipo_id!=9 AND
			    e.estadoequipo_id!=14 
			GROUP BY
			    CONCAT(
			        e.name,
			        "|",
			        e.marca,
			        "|",
			        e.modelo
			    ) 
			ORDER BY
			    CONCAT(
			        e.name,
			        "|",
			        e.marca,
			        "|",
			        e.modelo
			    ) ASC	
		';
		return $this->db->query($query)->result();
	}
	public function cantidad_equipos_asociados($param)
	{
		$query = "
			SELECT COUNT(*) as cantidad FROM equipos e
			WHERE e.guia_id=" . $param["id"] . "
		";
		return $this->db->query($query)->row();
	}
	public function cantidad_relacionar_con_equipos($param)
	{
		$query = "
			SELECT * FROM equipos e WHERE
			e.name LIKE '%" . $param["nombre"] . "%' AND
			e.marca LIKE '%" . $param["marca"] . "%' AND
			e.modelo LIKE '%" . $param["modelo"] . "%' AND
		    e.estadoequipo_id!=6 AND
		    e.estadoequipo_id!=9 AND
		    e.estadoequipo_id!=14 			
		";
		return $this->db->query($query)->num_rows();
	}
	public function relacionar_con_equipos($param)
	{
		$query = "
			UPDATE equipos e SET e.guia_id = " . $param["id"] . " WHERE
			e.name LIKE '%" . $param["nombre"] . "%' AND
			e.marca LIKE '%" . $param["marca"] . "%' AND
			e.modelo LIKE '%" . $param["modelo"] . "%' AND
		    e.estadoequipo_id!=6 AND
		    e.estadoequipo_id!=9 AND
		    e.estadoequipo_id!=14 	
		";
		$this->db->query($query);
	}
	public function relacionar_guia_con_equipos($param)
	{
		$query = "
			UPDATE equipos e SET e.guia_id = " . $param["id"] . " WHERE
			e.name = '" . $param["nombre"] . "' AND
			e.marca = '" . $param["marca"] . "' AND
			e.modelo = '" . $param["modelo"] . "' AND
		    e.estadoequipo_id!=6 AND
		    e.estadoequipo_id!=9 AND
		    e.estadoequipo_id!=14 	
		";
		$this->db->query($query);
	}
	public function getPriorizados()
	{
		$query = "
            SELECT
                *
            FROM
                equipos e
            WHERE
            e.tipo_id=1
            AND sedes.id != 2
            AND e.propietario_id !=25
						AND
						e.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)
						AND
						e.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
						AND
						e.name NOT IN (SELECT name FROM equipos_excluidos_guias)
						ORDER BY e.name ASC
		";
		return $this->db->query($query)->result();
		echo "1";
	}
	public function getPriorizadosGuia()
	{
		$query = "
						SELECT
								e.*,g.name as guia, sedes.name as sede, estadoequipos.name as estado
						FROM
								equipos e
						LEFT JOIN
								guias_rapidas g ON g.id=e.guia_id
						LEFT JOIN 
								servicios ON e.servicio_id=servicios.id
						LEFT JOIN
								sedes ON servicios.sede_id=sedes.id
            LEFT JOIN
                estadoequipos ON estadoequipos.id=e.estadoequipo_id
						WHERE
								e.guia_id != 0 AND e.tipo_id=1
            AND NOT(sedes.id = 2 AND e.propietario_id =25)
						AND
								e.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)
						AND
								e.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
						AND
								e.name NOT IN (SELECT name FROM equipos_excluidos_guias)
						ORDER BY e.name ASC
		";
		return $this->db->query($query)->result();
		echo "1";
	}
	public function getPrioritizedWithoutGuide()
	{
		$query = "
						SELECT
								e.*,g.name as guia, sedes.name as sede, estadoequipos.name as estado
						FROM
								equipos e
						LEFT JOIN
								guias_rapidas g ON g.id=e.guia_id
						LEFT JOIN 
								servicios ON e.servicio_id=servicios.id
						LEFT JOIN
								sedes ON servicios.sede_id=sedes.id
            LEFT JOIN
                estadoequipos ON estadoequipos.id=e.estadoequipo_id                
						WHERE
								e.guia_id = 0 AND e.tipo_id=1
            AND NOT(sedes.id = 2 AND e.propietario_id =25)
						AND
								e.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)
						AND
								e.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
						AND
								e.name NOT IN (SELECT name FROM equipos_excluidos_guias)
						ORDER BY e.name ASC
		";
		return $this->db->query($query)->result();
		echo "1";
	}
	public function getPriorizadosGrupo()
	{
		$query = "
		 SELECT name,cantidad_total,cantidad_con_guia,FORMAT(cantidad_con_guia/cantidad_total*100,2)AS porcentaje
		 FROM(
		     SELECT name, sum(cantidad) AS cantidad_total,sum(cantidad2) AS cantidad_con_guia
		         from
		          (
		                (SELECT
		                    e.name AS name,
		                    COUNT(*) AS cantidad,0 as cantidad2
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
		                    equipos_excluidos_guias
		                )
		                GROUP BY
		                    e.name)

		                    UNION
		                (SELECT
		                    name,0 as cantidad,COUNT(*)as cantidad2
		                FROM
		                    equipos
		                WHERE
		                    equipos.guia_id != 0 AND equipos.tipo_id = 1 AND equipos.estadoequipo_id NOT IN(
		                    SELECT
		                        estadoequipo_id
		                    FROM
		                        estados_excluidos_guias
		                ) AND equipos.criesgo_id IN(
		                    SELECT
		                        criesgo_id
		                    FROM
		                        riesgos_incluidos_guias
		                ) AND equipos.name NOT IN(
		                    SELECT name
		                FROM
		                    equipos_excluidos_guias
		                ) 
		                GROUP BY name asc)
		              )t
		        group by t.name
		        order by t.cantidad desc
		 )j

    
		";
		return $this->db->query($query)->result();
		echo "1";
	}
	public function getCoberturaBIomedicos()
	{
		$query = '
			SELECT
			    CONCAT(
			        FORMAT(
			            (
			            SELECT
			                COUNT(*)
			            FROM
			                equipos e
			            WHERE
			                e.guia_id != 0 AND e.tipo_id=1
						AND
						e.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)
						AND
						e.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
						AND
						e.name NOT IN (SELECT name FROM equipos_excluidos_guias)
			        ) /(
				        SELECT
				            COUNT(*)
				        FROM
				            equipos e
				        WHERE
				            e.tipo_id=1
						AND
						e.estadoequipo_id NOT IN(SELECT estadoequipo_id FROM estados_excluidos_guias)
						AND
						e.criesgo_id IN(SELECT criesgo_id FROM riesgos_incluidos_guias)
						AND
						e.name NOT IN (SELECT name FROM equipos_excluidos_guias)

			    ) * 100,
			    2
			        ),
			        " %"
			    ) AS cobertura

		';
		return $this->db->query($query)->row();
	}
	public function getCoberturaIndustriales()
	{
		$query = '
			SELECT
			    CONCAT(
			        FORMAT(
			            (
			            SELECT
			                COUNT(*)
			            FROM
			                equipos e
			            WHERE
			                e.tipo_id=2
						AND
					    e.estadoequipo_id!=6 AND
					    e.estadoequipo_id!=9 AND
					    e.estadoequipo_id!=14			                
			        ) /(
				        SELECT
				            COUNT(*)
				        FROM
				            equipos e
				        WHERE
				            e.guia_id = 0 AND e.tipo_id=2
						AND
					    e.estadoequipo_id!=6 AND
					    e.estadoequipo_id!=9 AND
					    e.estadoequipo_id!=14				            
			    ) * 100,
			    2
			        ),
			        " %"
			    ) AS cobertura

		';
		return $this->db->query($query)->row();
	}
	public function getRiesgosIncluidos()
	{
		$query = "
		SELECT
		    cr.name
		FROM
		    riesgos_incluidos_guias ri
		LEFT JOIN criesgo cr ON
		    cr.id = ri.criesgo_id
		ORDER BY
		    cr.name ASC

		";
		return $this->db->query($query)->result();
	}
	public function getEstadosExcluidos()
	{
		$query = "
		SELECT
		    ee.name
		FROM
		    estados_excluidos_guias ex
		LEFT JOIN estadoequipos ee ON
		    ee.id = ex.estadoequipo_id
		ORDER BY
		    ee.name ASC
		";
		return $this->db->query($query)->result();
	}
	public function countWithGuia()
	{

		$query = "
		SELECT
		    COUNT(*) AS cantidad
		FROM
		    equipos e
		WHERE
		    e.tipo_id = 1 AND e.guia_id != 0 AND e.estadoequipo_id NOT IN(
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
		";
		return $this->db->query($query)->row();
	}
	public function countAll()
	{

		$query = "
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
		";
		return $this->db->query($query)->row();
	}

	public function updateGuideQueryQuantity($param)
	{
		return ($this->db->insert("consultas_guias_rapidas", $param));
	}

	/**
	 * It returns a list of all the guides, and the number of queries that each guide has
	 * 
	 * @return The query is returning the following:
	 */
	public function getWithQuery()
	{
		$query = "
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
		";
		return $this->db->query($query)->result();
	}
}
