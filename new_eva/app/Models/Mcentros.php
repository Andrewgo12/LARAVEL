<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
class Mcentros extends CI_Model
{

	function __construct()
	{
		defined('BASEPATH') or exit('El acceso directo no esta permitido');
		parent::__construct();
	}

	// Refactoring
	public function getOneCentro($id)
	{
		$this->db->select('centros.*');
		$this->db->from('centros');
		$this->db->where('centros.id', $id);
		return $this->db->get()->row();
	}
	public function getAllCentros()
	{
		$this->db->select("centros.*");
		$this->db->from("centros");
		$this->db->where("centros.status", 1);
		$this->db->order_by("centros.name", "asc");
		return $this->db->get()->result();
	}





	public function get()
	{
		$this->db->select('centros.*');
		$this->db->from('centros');
		return $this->db->get()->row();
	}
}
