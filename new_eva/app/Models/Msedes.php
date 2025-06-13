<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Msedes extends CI_Model
{

	function __construct()
	{
		defined('BASEPATH') or exit('El acceso directo no esta permitido');
		parent::__construct();
	}

	/* Refactoring */
	public function getOneService($id)
	{
		$this->db->select('sedes.*');
		$this->db->from('sedes');
		$this->db->where('sedes.id', $id);
		return $this->db->get()->row();
	}
	public function getAllServices()
	{
		$this->db->select("sedes.*");
		$this->db->from("sedes");
		$this->db->order_by("name", "asc");
		return $this->db->get()->result();
	}

	public function getAll()
	{
		$this->db->order_by("name", "asc");
		return $this->db->get("sedes")->result();
	}
}
