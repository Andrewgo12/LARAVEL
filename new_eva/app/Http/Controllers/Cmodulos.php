<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cmodulos extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mmodulos');
    $this->load->model('Macciones');
  }
  public function getAll()
  {
    echo json_encode($this->Mmodulos->getAll());
  }
  public function getWithAccount()
  {
    echo json_encode($this->Mmodulos->getWithAccount());
  }
  public function setear_acciones()
  {
    $this->Macciones->setear_acciones($_POST);
  }
}
