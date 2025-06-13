<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mproveedores_mantenimiento extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		// $this->db->select("*");
		// $this->db->from("invimas");
		// $this->db->where("status",1);
		// $this->db->order_by("invima",'asc');
		// return $this->db->get()->result();
	}
	public function getAll(){
		$this->db->select("*");
		$this->db->from("proveedores_mantenimiento pm");
		$this->db->where("pm.status=1");
		$this->db->order_by("pm.name","asc");
		return $this->db->get()->result();

	}

	public function getOne($param){
		// $this->db->where("id",$param["id"]);
		// return $this->db->get("invimas")->row();
	}
	public function delete($param){
		// $this->db->where("id",$param["id"]);
		// unset($param["id"]);
		// $param["status"]=0;
		// $this->db->update("invimas",$param);
	}	

}

?>