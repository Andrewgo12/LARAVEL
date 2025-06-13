<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

class Cpisos extends CI_Controller
{
	private $pisos;
	function __construct()
	{
		parent::__construct();
		$this->load->model("Mpisos");
	}
	public function index()
	{
		/* 		if ($this->session->userdata('login')) {
		} else {
			redirect(base_url('Cauth'));
		} */
		/* 
		$acciones = $this->session->userdata("acciones");
		$this->session->set_userdata('controlador', $this->uri->segment(2));

		foreach ($acciones as $accion) {
			if ($accion->modulo == "contactos") {
				if ($accion->leer != 1) {
					redirect(base_url('Forbidden'));
				}
			}
		} */

		/* 		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("areas/list");
		$this->load->view("areas/modal_add");
		$this->load->view("areas/modal_edit");
		$this->load->view("layouts/footer"); */
	}
	public function ServiceGetAll()
	{
		echo json_encode($this->Mpisos->getAllPisos());
	}
}
