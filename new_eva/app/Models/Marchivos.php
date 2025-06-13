<?php 
/**
* 
*/
class Marchivos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function get(){
		$this->db->order_by("name","asc");
		return $this->db->get("archivos")->result();
	}

}

 ?>