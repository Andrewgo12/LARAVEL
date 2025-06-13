<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mtipos_estados extends CI_Model
{
	
	function __construct()
	{
		defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get(){
		return $this->db->get("tipos_estados")->result();
	}


}
?>