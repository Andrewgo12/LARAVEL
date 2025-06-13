<?php
// defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
 * 
 */
require APPPATH . 'libraries/REST_Controller.php';

class Restserver extends REST_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');

    //$this->permisos=$this->backend_lib->control();
  }

  public function test_get()
  {
    $array = $this->Mequipos->get_some();
    //echo "sdfsd";
    //header("Access-Control-Origin: http://localhost:8100");
    //header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    $this->response($array);
  }
  public function user_post()
  {
    $data = "algo";
    $this->response($data);
  }
  public function indext_get()
  {
    $data = "algo";

    $this->response($data, REST_Controller::HTTP_OK);
  }
}
