<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
class Ccentros extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Mcentros");
	}
	public function index()
	{
	}

	// Refactoring
	public function ServiceGetAll()
	{
		echo json_encode($this->Mcentros->getAllCentros());
	}
	public function ServiceGetOne($id)
	{
		echo json_encode($this->Mcentros->getOneCentro($id));
	}
}
