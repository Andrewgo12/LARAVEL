<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mestadoequipos extends CI_Model
{
	
	function __construct()
	{
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get_datatable(){
		$this->db->select("ee.*,te.nombre as tipo");
		$this->db->from("estadoequipos ee");
		$this->db->join("tipos_estados te","te.id=ee.tipoestado_id","left");
		return $this->db->get()->result();
	}
	public function get(){
		$this->db->where("estadoequipos.status=1");
		return $this->db->get("estadoequipos")->result();
	}
	public function getAll(){
		return $this->db->get("estadoequipos")->result();
	}
	public function get_usados(){
		$this->db->distinct();
		$this->db->select("equipos.estadoequipo_id as id,estadoequipos.name as name");
		$this->db->from("equipos");
		$this->db->join("estadoequipos","equipos.estadoequipo_id=estadoequipos.id","left");
		$this->db->group_by("estadoequipos.name","ASC");
		return $this->db->get()->result();
	}	
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("estadoequipos")->row();
	}
	public function add($param){
		$this->db->insert("estadoequipos",$param);
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("estadoequipos",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("estadoequipos",$param);
	}
	public function active($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("estadoequipos",$param);
	}
	public function getDistributionEstadosByDevice($param){
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
		$query="
		SELECT
		    COUNT(*) AS cantidad,
		    ee.name AS estadoequipo
		FROM
		    equipos eq
		LEFT JOIN estadoequipos ee ON
		    ee.id = eq.estadoequipo_id
		 LEFT JOIN servicios s ON s.id=eq.servicio_id   
		WHERE 
		s.sede_id LIKE '%".$param["sede_id"]."%' AND
		eq.tipo_id LIKE '%".$param["subproceso_id"]."%' AND
		".$tmp."   
		GROUP BY
		    ee.name ASC
		";
		return $this->db->query($query)->result();
	}

	public function getFuncionalidad(){
		$this->db->where("tipoestado_id = 1 AND status=1");
		return $this->db->get("estadoequipos")->result();
	}
	public function getDisponibilidad(){
		$this->db->where("tipoestado_id = 2 AND status=1");
		return $this->db->get("estadoequipos")->result();
	}


}
 ?>