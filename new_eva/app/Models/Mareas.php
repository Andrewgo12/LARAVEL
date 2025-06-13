<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mareas extends CI_Model
{

	function __construct()
	{
		defined('BASEPATH') or exit('El acceso directo no esta permitido');
		parent::__construct();
	}


	// Refactoring
	public function getOneArea($id)
	{
		$this->db->select('areas.*');
		$this->db->from('areas');
		$this->db->where('areas.id', $id);
		return $this->db->get()->row();
	}
	public function getAllAreas()
	{
		$this->db->select("areas.*,servicios.name as servicio,sedes.name as sede,pisos.name as piso");
		$this->db->from("areas");
		$this->db->join("servicios", "servicios.id=areas.servicio_id", "left");
		$this->db->join("sedes", "sedes.id=servicios.sede_id", "left");
		$this->db->join("pisos", "pisos.id=areas.piso_id", "left");
		$this->db->order_by("areas.name", "asc");
		return $this->db->get()->result();
	}
	public function getByService($id)
	{
		$this->db->select("areas.*,servicios.name as servicio,sedes.name as sede,pisos.name as piso");
		$this->db->from("areas");
		$this->db->join("servicios", "servicios.id=areas.servicio_id", "left");
		$this->db->join("sedes", "sedes.id=servicios.sede_id", "left");
		$this->db->join("pisos", "pisos.id=areas.piso_id", "left");
		$this->db->where('areas.servicio_id', $id);
		$this->db->order_by("areas.name", "asc");
		return $this->db->get()->result();
	}
	public function add($param)
	{
		return ($this->db->insert("areas", $param));
	}
	public function update($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		return ($this->db->update("areas", $param));
	}
	public function delete($param)
	{
		$this->db->where('id', $param['id']);
		$this->db->delete('areas');
	}




	public function getAll()
	{
		$this->db->select("areas.*,servicios.name as servicio,sedes.name as sede,pisos.name as piso");
		$this->db->from("areas");
		$this->db->join("servicios", "servicios.id=areas.servicio_id", "left");
		$this->db->join("sedes", "sedes.id=servicios.sede_id", "left");
		$this->db->join("pisos", "pisos.id=areas.piso_id", "left");
		$this->db->order_by("areas.name", "asc");
		return $this->db->get()->result();
	}
	public function getOne($param)
	{
		$this->db->select("areas.*,servicios.name as servicio");
		$this->db->from("areas");
		$this->db->join("servicios", "servicios.id=areas.servicio_id", "left");
		$this->db->where("areas.id", $param["id"]);
		return $this->db->get()->row();
	}
	public function getAreaByservicio($param)
	{
		$this->db->where("servicio_id", $param["servicio_id"]);
		$this->db->order_by("name", "asc");
		return $this->db->get("areas")->result();
	}
}
