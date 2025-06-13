<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mtecnologias extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		$this->db->where('status !=',0);
		$this->db->order_by("name","asc");
		$resultado = $this->db->get("tecnologiap");
		return $resultado->result();
	}

}

?>