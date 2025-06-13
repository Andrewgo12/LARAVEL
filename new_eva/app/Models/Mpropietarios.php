<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mpropietarios extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		$this->db->select("*");
		$this->db->from("invimas");
		$this->db->where("status",1);
		$this->db->order_by("invima",'asc');
		return $this->db->get()->result();
	}
	public function getAll(){
		$this->db->select("*");
		$this->db->from("propietarios p");
		$this->db->order_by("p.nombre","asc");
		return $this->db->get()->result();
	}
	public function getWithNumberDevices(){
		$query="
		SELECT
		invimas.*,
		(
		SELECT COUNT(*)
		FROM
		equipos
		WHERE
		equipos.invima_id = invimas.id  


		)as cuenta

		FROM
		invimas LEFT JOIN equipos on equipos.invima_id=invimas.id
		WHERE invimas.id!=1
		GROUP BY invimas.invima
		";
		return $this->db->query($query)->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("propietarios")->row();
	}
	public function getdescriptionlike($param){
		$query="select invima from invimas where description like '%".$param["consulta"]."%'";
		return $this->db->query($query)->result();
	}
	public function add($param){
		return($this->db->insert("propietarios",$param));
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return($this->db->update("propietarios",$param));
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$param["status"]=0;
		$this->db->update("invimas",$param);
	}	
	public function activate($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$param["status"]=1;
		$this->db->update("invimas",$param);
	}	
	// public function delete($param){
	// 	$this->db->where("id",$param["id"]);
	// 	$this->db->delete("invimas");
	// }	
}

?>