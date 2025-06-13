<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mavances_correctivos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function add($param){
		return $this->db->insert("avances_correctivos",$param);

	}
	public function get(){
	}
	public function GetByDevice($param){
		$this->db->select("avances_correctivos.*,usuarios.nombre as usuario");
		$this->db->from("avances_correctivos");
		$this->db->join("usuarios","usuarios.id=avances_correctivos.usuario_id","left");
		$this->db->where("avances_correctivos.correctivo_general_id",$param['correctivo_general_id']);
		$this->db->order_by("date","desc");
		return $this->db->get()->result();

	}
	public function GetByOrden($param){
		$this->db->select("avances_correctivos.*,usuarios.nombre as usuario");
		$this->db->from("avances_correctivos");
		$this->db->join("usuarios","usuarios.id=avances_correctivos.usuario_id","left");
		$this->db->where("avances_correctivos.orden_id",$param['orden_id']);
		$this->db->order_by("date","desc");
		return $this->db->get()->result();

	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("avances_correctivos");

	}

}

?>