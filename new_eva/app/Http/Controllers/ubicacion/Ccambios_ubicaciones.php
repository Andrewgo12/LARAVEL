<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Ccambios_ubicaciones extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Mcambios_ubicaciones");
		
	}
	public function index(){
	}
	public function getAll(){
		echo json_encode($this->Msedes->getAll());
	}
	public function show_cambios_ubicaciones(){
	$cambios_ubicaciones=$this->Mcambios_ubicaciones->getAllByDevice($_POST);
	$this->load->view("cambios_ubicaciones/modal_detail",array("cambios_ubicaciones"=>$cambios_ubicaciones));

	}
}


?>