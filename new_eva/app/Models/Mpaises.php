<?php 
/**
 * 
 */
class Mpaises extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function getAll(){
		$this->db->select("paises.*");
		$this->db->from("paises");
		return $this->db->get()->result();
	}
}
 ?>