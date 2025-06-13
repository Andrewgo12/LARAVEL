<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Cestadoequipos extends CI_Controller
{
	private $estadoequipos;
	function __construct()
	{
		parent::__construct();
		$this->load->model("Mestadoequipos");
		$this->load->model("Mtipos_estados");
		$this->permisos=$this->backend_lib->control();
		
	}
	public function index(){
		if($this->session->userdata('login')){

		}else{
			redirect(base_url('Cauth'));
		}			
		$acciones=$this->session->userdata("acciones");
		$this->session->set_userdata('controlador', $this->uri->segment(2));

		
		foreach ($acciones as $accion) {
			if ($accion->modulo=="estado equipos") {
				if ($accion->leer!=1) {
					redirect(base_url('Forbidden'));
				}
			}
		}

		$this->load->view("layouts/header");
		if ($this->session->userdata("rol_id")==1) {
			$this->load->view("layouts/aside");
		}elseif($this->session->userdata("rol_id")==2){
			$this->load->view("layouts/admin_aside");
		}elseif($this->session->userdata("rol_id")==3){
			$this->load->view("layouts/advance_aside");
		}else{
			$this->load->view("layouts/basic_aside");
		}
		
		$this->load->view("estadoequipos/list");
		$this->load->view("layouts/footer");
	}
	public function get_datatable(){
		echo json_encode($this->Mestadoequipos->get_datatable());
	}
	public function get(){
		echo json_encode($this->Mestadoequipos->get());
	}
	public function get_usados(){
		echo json_encode($this->Mestadoequipos->get_usados());
	}	
	public function getOne(){
		echo json_encode($this->Mestadoequipos->getOne($_POST));
	}

	public function update(){
		$estado = $this->Mestadoequipos->getOne($_POST);
		if ($estado->name == $_POST["name"]) {
			$this->form_validation->set_rules("name","Nombre del estado","required|min_length[3]");
		}else{
			$this->form_validation->set_rules("name","Nombre del estado","required|min_length[3]|is_unique[estadoequipos.name]");
		}
		if ($this->form_validation->run()) {
			$this->Mestadoequipos->update($_POST);
			$vector=array(
				'respuesta'=>1,
				'informacion'=>""
			);	
		}else{
			$vector=array(
				'respuesta'=>2,
				'informacion'=>validation_errors()
			);
		}
		echo json_encode($vector);
	}
	public function add(){

		if (isset($_POST["id"])) {
			unset($_POST["id"]);
		}
		$this->form_validation->set_rules("name","Nombre del estado","is_unique[estadoequipos.name]|required|min_length[3]");

		if ($this->form_validation->run()) {
			$vector=array(
				'respuesta'=>1,
				'informacion'=>""
			);
			$this->Mestadoequipos->add($_POST);
		}else{
			$vector=array(
				'respuesta'=>2,
				'informacion'=>validation_errors()
			);
		}
		echo json_encode($vector);
	}
	public function delete(){
		$_POST["status"]=2;
		$this->Mestadoequipos->delete($_POST);
	}
	public function active(){
		$_POST["status"]=1;
		$this->Mestadoequipos->active($_POST);
	}
	public function getFuncionalidad(){
		echo json_encode($this->Mestadoequipos->getFuncionalidad());
	}
	public function getDisponibilidad(){

		echo json_encode($this->Mestadoequipos->getDisponibilidad());
	}
	public function getTipoEstado(){
		echo json_encode($this->Mtipos_estados->get());
	}

}

?>