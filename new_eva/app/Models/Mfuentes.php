<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mfuentes extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->where('status !=',0);
		$this->db->order_by("name","asc");		
		return $this->db->get("fuenteal")->result();
	}

}

?>