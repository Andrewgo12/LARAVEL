<?php 
/**
* 
*/
class Backend_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getID($link){//Paso el link del modulo
		$this->db->where("link",$link);
		return $this->db->get("menus")->row();
	}
	public function getPermisos($menu,$rol){
		$this->db->select("*");
		$this->db->from("permisos");
		$this->db->where("menu_id",$menu);
		$this->db->where("rol_id",$rol);
		return $this->db->get("")->row();
	}
}


 ?>

