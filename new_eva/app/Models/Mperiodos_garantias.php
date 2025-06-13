<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mperiodos_garantias extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->select('*');	
		$this->db->from('periodos_garantias');
		$this->db->order_by('name','asc');
		$resultado = $this->db->get();
		return $resultado->result();
	}

}

?>