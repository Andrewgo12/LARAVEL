<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mtrabajos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function getAll(){
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->select('*');	
		$this->db->from('trabajos');
		$this->db->order_by('name',"asc");
		$resultado = $this->db->get();
		return $resultado->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("trabajos")->result();
	}
	
}

?>