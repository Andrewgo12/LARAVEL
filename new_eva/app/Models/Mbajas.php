<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mbajas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

		
	}
	public function get(){
		$this->db->select("*");
		$this->db->from("bajas");
		$this->db->order_by("fecha_baja","desc");
		return $this->db->get()->result();
	}
	public function getWithNumberDevices(){
		$query="
		SELECT
		bajas.*,
		(
		SELECT COUNT(*)
		FROM
		equipos
		WHERE
		equipos.baja_id = bajas.id
		)as cuenta
		FROM bajas
		ORDER BY bajas.fecha_baja DESC


		";
		return $this->db->query($query)->result();


	}

	public function get_equipos_bajas(){
  
		$this->db->select("equipos.name as equipo,equipos.id as equipo_id,equipos.serial as serie,equipos.code as codigo,equipos.marca as marca, equipos.modelo as modelo,bajas.archivo as archivo,bajas.fecha_baja as fecha_baja");
		$this->db->from("equipos_bajas");
		$this->db->join("equipos","equipos.id=equipos_bajas.equipo_id");
		$this->db->join("bajas","bajas.id=equipos_bajas.baja_id");
		return $this->db->get()->result();
	}
	public function add($param){
		return $this->db->insert("bajas",$param);
	}
	public function add_equipo_bajas($param){
		return $this->db->insert("equipos_bajas",$param);
	}
	public function get_by_equipo($param){
		 $this->db->select("equipos_bajas.id as id,bajas.descripcion as descripcion,bajas.fecha_baja as fecha_baja,bajas.archivo as archivo");
		 $this->db->from("equipos_bajas");
		 $this->db->join("bajas","bajas.id=equipos_bajas.baja_id");
		return $this->db->where("equipos_bajas.equipo_id",$param["equipo_id"])->get()->result();

	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("bajas")->row();
	}

	
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("bajas",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("bajas");

	}
	public function delete_equipo_baja($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("equipos_bajas");

	}
	public function getAll(){
		$this->db->select("*");
		$this->db->from("bajas");
		return $this->db->get()->result();
	}

}
?>