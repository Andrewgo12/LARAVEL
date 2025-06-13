<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcbiomedicas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->where('status !=',0);
		$this->db->order_by("name","asc");
		$resultado = $this->db->get("cbiomedica");
		return $resultado->result();
	}
	public function getDistributionCbiomedicaOnDevices($param){

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
			    (
			        CASE WHEN cb.name IS NULL THEN 'N/R' WHEN cb.name IS NOT NULL THEN cb.name
			    END
			) AS cbiomedica
			FROM
			    equipos eq
			LEFT JOIN cbiomedica cb ON
			    cb.id = eq.cbiomedica_id
			LEFT JOIN servicios s ON
			    s.id = eq.servicio_id
			WHERE
			    s.sede_id LIKE '%".$param["sede_id"]."%'
			    AND eq.tipo_id LIKE '%".$param["subproceso_id"]."%'
			    AND ".$tmp."
			    AND ".$multiple_estado_equipo."
			GROUP BY
			    (
			        CASE WHEN cb.name IS NULL THEN 'N/R' WHEN cb.name IS NOT NULL THEN cb.name
			    END
			) ASC
		";
		return $this->db->query($query)->result();
	}

}

?>