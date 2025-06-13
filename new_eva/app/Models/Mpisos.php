<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Mpisos extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function getAllPisos()
	{
		$this->db->where("status", 1);
		return $this->db->get("pisos")->result();
	}
	public function get()
	{
		$this->db->where("status", 1);
		return $this->db->get("pisos")->result();
	}
}
