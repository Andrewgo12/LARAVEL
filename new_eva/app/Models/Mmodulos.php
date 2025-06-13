<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mmodulos extends CI_Model
{
	
	function __construct()
	{
		defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function getAll(){
		$this->db->select("*");
		$this->db->from("modulos");
		$this->db->order_by("modulos.id","asc");
		return $this->db->get()->result();
	}
	public function getWithAccount(){
		$query="
			SELECT
			    m.*,
			    (
			    SELECT
			        COUNT(*)
			    FROM
			        acciones a
			    WHERE
			        a.modulo_id = m.id
			) AS cantidad
			FROM
			    modulos m			
		";
		return $this->db->query($query)->result();
	}
	public function getOne($param){
		// $this->db->select("areas.*,servicios.name as servicio");
		// $this->db->from("areas");
		// $this->db->join("servicios","servicios.id=areas.servicio_id","left");
		// $this->db->where("areas.id",$param["id"]);
		// return $this->db->get()->row();
	}

	public function add($param){
		// return($this->db->insert("areas",$param));
	}
	public function update($param){
		// $this->db->where("id",$param["id"]);
		// unset($param["id"]);
		// return($this->db->update("areas",$param));
	}

	public function delete($param){
		// $this->db->where("id",$param["id"]);
		// $this->db->delete("areas");
	}	


}
?>