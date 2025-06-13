<?php 

/**
 * 
 */
class Mcontingencias extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function get($param){
		$this->db->where("equipo_id",$param["equipo_id"]);
		return $this->db->get("contingencias")->result();
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("contingencias")->row();		
	}
	public function getAll(){
		$seleccion="
			contingencias.*,
			(SELECT CONCAT(usuarios.nombre,' ',usuarios.apellido,' (',usuarios.username, ')')) as usuario,
			equipos.name as name,
			equipos.code as codigo,
			equipos.serial as serial,
			equipos.marca as marca,
			equipos.modelo as modelo,
			tipos.name as tipo,
			estados.descripcion as estado

		";
		$this->db->select($seleccion);
		$this->db->from("contingencias");
		$this->db->join("usuarios","usuarios.id=contingencias.usuario_id","left");
		$this->db->join("equipos","equipos.id=contingencias.equipo_id","left");
		$this->db->join("tipos","tipos.id=equipos.tipo_id","left");
		$this->db->join("estados","estados.id=contingencias.estado_id","left");
		$this->db->order_by("fecha","desc");
		return $this->db->get()->result();
	}
	public function add($param){
		return ($this->db->insert("contingencias",$param));
		
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$this->db->update("contingencias",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		$this->db->delete("contingencias");	
	}

}
 ?>