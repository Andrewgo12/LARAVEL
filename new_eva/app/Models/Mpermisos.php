<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mpermisos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function get(){
		$this->db->select("permisos.*,menus.nombre as menu,roles.nombre as rol");
		$this->db->from("permisos");
		$this->db->join("roles","permisos.rol_id=roles.id");
		$this->db->join("menus","permisos.menu_id=menus.id");
		return $this->db->get()->result();
	}
	public function getMenus(){
		return $this->db->get("menus")->result();
	}
	public function save($param){

		$this->db->insert("permisos",$param);
	}
	public function update($param){
	    $this->db->where('id',$param['id']);
	    unset($param["id"]);
	    $this->db->update('permisos',$param);
	}
	public function getOne($param){
		$this->db->where('id',$param);
		return $this->db->get("permisos")->row();
	}
	public function delete($param){
		$this->db->where("id",$param);
		$this->db->delete("permisos");
	}
}

 ?>