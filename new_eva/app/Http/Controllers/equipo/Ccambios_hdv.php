<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Ccambios_hdv extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mcambios_hdv');
  }
  public function index()
  {
  }
  public function get_from_device()
  {
    $this->load->view("equipos/historial/detail", array("cambios_hdv" => $this->Mcambios_hdv->get_from_device($_POST)));
  }
  public function getOne()
  {
    // echo json_encode($this->Mbajas->getOne($_POST));
  }
}
