<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Ctipos_fallas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mtipos_fallas');
	}
	public function getAll()
	{
		echo json_encode($this->Mtipos_fallas->get());
	}
}
