<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Forbidden extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect('Cauth');
		}

	}
	public function index(){
		$this->load->view('layouts/header');
		$this->load->view("layouts/aside");
		$this->load->view("admin/forbidden");
		$this->load->view("layouts/footer");

	}
}
?>