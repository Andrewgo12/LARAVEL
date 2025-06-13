<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Cservicios extends CI_Controller
{
	private $servicios;
	function __construct()
	{
		parent::__construct();
		$this->load->model("Mservicios");
		$this->load->model("Mpisos");
		$this->load->model("Mzonas");
		$this->load->model("Mcentros");
		$this->permisos = $this->backend_lib->control();
	}
	public function index()
	{
		if ($this->session->userdata('login')) {
		} else {
			redirect(base_url('Cauth'));
		}
		$acciones = $this->session->userdata("acciones");
		$this->session->set_userdata('controlador', $this->uri->segment(2));


		foreach ($acciones as $accion) {
			if ($accion->modulo == "servicios") {
				if ($accion->leer != 1) {
					redirect(base_url('Forbidden'));
				}
			}
		}
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("servicios/list");
		$this->load->view("servicios/modal_add");
		$this->load->view("servicios/modal_edit");
		$this->load->view("layouts/footer");
	}
	/* Refactoring */
	public function ServiceGetAll()
	{
		echo json_encode($this->Mservicios->getAllServices());
	}
	public function ServiceGetOne($id)
	{
		echo json_encode($this->Mservicios->getOneService($id));
	}
	public function ServiceGetBySede($id)
	{
		echo json_encode($this->Mservicios->getBySede($id));
	}
	public function add()
	{
		$this->form_validation->set_rules("name", "Nombre del servicio", "is_unique[servicios.name]|required|min_length[4]");
		if ($this->form_validation->run()) {
			if ($result = $this->Mservicios->add($_POST)) {
				echo json_encode(array('result' => $result));
				return;
			}
		} else {
			echo json_encode(array('error' => validation_errors()));
			return;
		}
	}
	public function delete($id)
	{
		return $this->Mservicios->delete(array('id' => $id));
	}



	public function get_datatable()
	{
		echo json_encode($this->Mservicios->get_datatable());
	}
	public function get()
	{
		echo json_encode($this->Mservicios->get());
	}
	public function getOne()
	{

		echo json_encode($this->Mservicios->getOne($_POST));
	}
	public function getUbicacion()
	{

		echo json_encode($this->Mservicios->getUbicacion($_POST));
	}
	public function update()
	{
		$servicio = $this->Mservicios->getOne($_POST);
		if ($servicio->name == $_POST["name"]) {
			$this->form_validation->set_rules("name", "Nombre del servicio", "required|min_length[3]");
		} else {
			$this->form_validation->set_rules("name", "Nombre del servicio", "required|min_length[3]|is_unique[servicios.name]");
		}
		if ($this->form_validation->run()) {
			$this->Mservicios->update($_POST);
			$vector_respuesta = array(
				'respuesta' => 1,
			);
		} else {
			$informacion_error = validation_errors();
			$vector_respuesta = array(

				"caso" => 2,
				"informacion_error" => $informacion_error
			);
		}
		echo json_encode($vector_respuesta);
	}


	public function getPisos()
	{

		echo json_encode($this->Mpisos->get());
	}
	public function getZonas()
	{

		echo json_encode($this->Mzonas->get());
	}
	public function getCentros()
	{

		echo json_encode($this->Mcentros->get());
	}
	public function getFromSede()
	{

		echo json_encode($this->Mservicios->getFromSede($_POST));
	}
}
