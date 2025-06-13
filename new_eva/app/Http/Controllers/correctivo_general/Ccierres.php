<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Ccierres extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mcierres');


	}
	public function get(){
	}
	public function getUsed(){
		echo json_encode($this->Mcierres->getUsed());
	}



}

?>