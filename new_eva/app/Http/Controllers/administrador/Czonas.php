<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
class Czonas extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mzonas');
  }
  public function index()
  {
  }

  public function ServiceGetAll()
  {
    echo json_encode($this->Mzonas->getAllZones());
  }
  public function getAll()
  {
    echo json_encode($this->Mzonas->getAll());
  }

  public function getOne()
  {
    echo json_encode($this->Musuarios->getOne($_POST["id"]));
  }
}
