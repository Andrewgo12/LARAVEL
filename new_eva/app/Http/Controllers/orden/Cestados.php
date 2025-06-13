<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cestados extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mestados");
  }

  public function getAll()
  {
    echo json_encode($this->Mestados->getAll());
  }
  public function getUsed()
  {
    echo json_encode($this->Mestados->getUsed());
  }
}
