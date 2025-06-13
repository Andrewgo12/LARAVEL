<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mrepuestos extends CI_Model
{
	
	function __construct()
	{
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get_datatable(){
		$this->db->where("status",1);
		$this->db->order_by("name","asc");		
		return $this->db->get("repuestos")->result();
	}
	public function get(){
		$this->db->order_by("name","asc");
		return $this->db->get("repuestos")->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("repuestos")->row();
	}
	public function add($param){
		$this->db->insert("repuestos",$param);
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("repuestos",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("repuestos",$param);
	}
	public function sumar($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("repuestos",$param);
	}
	public function restar($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("repuestos",$param);
	}


}
 ?>