<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Ctipos_compra extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mtipos_compra');
  }
  public function getAll()
  {
    echo json_encode($this->Mtipos_compra->getAll());
  }
}
