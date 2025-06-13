<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
class Csedes extends CI_Controller
{
	private $servicios;
	function __construct()
	{
		parent::__construct();
		$this->load->model("Msedes");
		
	}
	public function index(){
		$this->session->set_userdata('controlador', $this->uri->segment(2));
	}

	/* Refactoring */
	public function ServiceGetAll()
	{
		echo json_encode($this->Msedes->getAllServices());
	}
	public function ServiceGetOne($id)
	{
		echo json_encode($this->Msedes->getOneService($id));
	}


	public function getAll(){
		echo json_encode($this->Msedes->getAll());
	}
	public function cambiar_sesion_sede(){
		$this->session->set_userdata("sede_id",$_POST["sede_seleccionada"]);
	}
	}
