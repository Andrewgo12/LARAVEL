<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Cproveedores_mantenimiento extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mproveedores_mantenimiento');
	}
	public function index(){
		if($this->session->userdata('login')){

		}else{
			redirect(base_url('Cauth'));
		}


	}
	public function get(){
		// echo json_encode($this->Minvimas->get());
	}
	public function getAll(){
		echo json_encode($this->Mproveedores_mantenimiento->getAll());
	}
	public function getOne(){
		// echo json_encode($this->Minvimas->getOne($_POST));
	}

	public function add(){

	}
	public function update(){

	}

	public function delete(){
		// $this->Minvimas->delete($_POST);
	}

	public function show(){

	}

}
?>