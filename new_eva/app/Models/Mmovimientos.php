<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mmovimientos extends CI_Model
{
	
	function __construct()
	{
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get_datatable(){
		$this->db->where("status",1);
		$this->db->order_by("cantidad","desc");		
		return $this->db->get("movimientos")->result();
	}
	public function get($param){
		$this->db->where("repuesto_id",$param["repuesto_id"]);
		$this->db->order_by("created_at","desc");
		return $this->db->get("movimientos")->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("movimientos")->row();
	}
	public function add($param){
		$this->db->insert("movimientos",$param);
	}

}
 ?>