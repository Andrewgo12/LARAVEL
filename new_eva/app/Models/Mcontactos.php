<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcontactos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		$this->db->select("contacto.*,tcontacto.description as tcontacto");
		$this->db->from("contacto");
		$this->db->join("tcontacto","tcontacto.id=contacto.tcontacto_id");
		$this->db->where("contacto.status",1);
		$this->db->order_by("name",'asc');
		return $this->db->get()->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("contacto")->row();

	}
	public function get_datatable(){
		$this->db->select("contacto.*,tcontacto.description as tcontacto");
		$this->db->from("contacto");
		$this->db->join("tcontacto","tcontacto.id=contacto.tcontacto_id");
		$this->db->where("contacto.status",1);
		$this->db->order_by("name",'asc');
		return $this->db->get()->result();

	}
	public function getProveedores(){
		$this->db->select("contacto.*");
		$this->db->from("contacto");
		$this->db->where("contacto.tcontacto_id=3");
		$this->db->order_by("contacto.name","asc");
		return $this->db->get()->result();

	}
	public function getTcontactos(){
		return $this->db->get("tcontacto")->result();
	}
	public function add($param){
		$this->db->insert("contacto",$param);
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("contacto",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		$this->db->delete("contacto");
	}	
	public function getProveedoresMantenimiento(){
		$query = "
			SELECT DISTINCT
			    responsable
			FROM
			    planes_mantenimientos
			ORDER BY
			    responsable ASC
		";
		return $this->db->query($query)->result();
	}	
}

?>