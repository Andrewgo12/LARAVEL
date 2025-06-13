<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Madquisiciones extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->where('status !=',0);
		$this->db->order_by("name","asc");
		$resultado = $this->db->get("tadquisicion");
		return $resultado->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("tadquisicion")->row();
	}

}

?>