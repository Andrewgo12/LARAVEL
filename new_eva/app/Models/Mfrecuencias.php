<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mfrecuencias extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		$this->db->where('status !=',0);
		$this->db->order_by("name","asc");
		$resultado = $this->db->get("frecuenciam");
		return $resultado->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("frecuenciam")->row();
	}	

}

?>