<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcalibraciones extends CI_Model
{
	
	function __construct()
	{
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get($param){
		$this->db->where("equipo_id",$param['equipo_id']);
		$this->db->order_by("fecha_calibracion","desc");

		return $this->db->get("calibracion")->result();
	}
	public function get_ind($param){
		$this->db->where("equipo_id",$param['equipo_id']);
		$this->db->order_by("fecha_calibracion");
		return $this->db->get("calibracion_ind")->result();
	}
	public function add($param){
		$this->db->insert("calibracion",$param);
		return $this->db->insert_id();		
		
	}
	public function add_ind($param){
		$this->db->insert("calibracion_ind",$param);
	}
	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("calibracion")->row();
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("calibracion",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("calibracion");
	}


public function getOne_ind($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("calibracion_ind")->row();
	}
	public function update_ind($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("calibracion_ind",$param);
	}
	public function delete_ind($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("calibracion_ind");
	}

	public function getCalibracionesModal(){

		$this->db->select("equipos.name as equipo,equipos.marca as marca,equipos.modelo as modelo,equipos.serial as serial,equipos.code as code,calibracion.description as codigo, calibracion.fecha_calibracion as fecha_ejecucion,calibracion.fecha_programada as fecha_programada, servicios.name as ubicacion, calibracion.file as archivo");
		$this->db->from("equipos");
		$this->db->join("calibracion","calibracion.equipo_id=equipos.id");
		$this->db->join("servicios","equipos.servicio_id=servicios.id");
		$this->db->where("equipos.status=1");
		$this->db->where("equipos.tipo_id=".$this->session->userdata("tipo_id"));
		$this->db->order_by("calibracion.fecha_calibracion","asc");
		return $this->db->get()->result();

	}
	public function getCalibracionesAll(){
		$this->db->select("equipos.*,calibracion.description as codigo, calibracion.fecha_calibracion as fecha_ejecucion,calibracion.fecha_programada as fecha_programada,calibracion.file archivocalibracion,servicios.name as ubicacion");
		$this->db->from("equipos");
		$this->db->join("calibracion","calibracion.equipo_id=equipos.id");
		$this->db->join("servicios","servicios.id=equipos.servicio_id");
		$this->db->where("equipos.status=1");
		$this->db->order_by("calibracion.fecha_calibracion","asc");
		return $this->db->get()->result();

	}

	
}
 ?>