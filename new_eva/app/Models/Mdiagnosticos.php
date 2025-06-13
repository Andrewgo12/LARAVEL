<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mdiagnosticos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		$this->db->where('status',1);
		$this->db->order_by("code","asc");
		$resultado = $this->db->get("codificacion_diagnosticos");
		return $resultado->result();
	}
}

?>