<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mtipos_fallas extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function get()
	{
		$this->db->where('status', 1);
		$this->db->order_by("name", "asc");
		$resultado = $this->db->get("tipos_fallas");
		return $resultado->result();
	}
}
