<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 *
 */
class Cempresas extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mempresas');
    //$this->permisos=$this->backend_lib->control();

  }
  public function index()
  {
  }

  public function add()
  {
  }
  public function update()
  {
  }
  public function delete()
  {
  }

  public function getAll()
  {
    echo json_encode($this->Mempresas->getAll());
  }

  public function getOne()
  {
  }
}
