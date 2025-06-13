<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mtipos_compra extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function getAll(){
		$this->db->select("*");
		$this->db->from("tipos_compra");
		$this->db->order_by("tipo_compra","asc");
		return $this->db->get()->result();
	}
}

?>