<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Ctecnicos extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mtecnicos');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $data = array(
      "tecnicos" => $this->Mtecnicos->get()
    );

    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("tecnicos/list", $data);
    $this->load->view("layouts/footer");
  }
  public function get()
  {

    echo json_encode($this->Mtecnicos->get());
  }

  public function getFromTrabajos()
  {
    echo json_encode($this->Mtecnicos->getFromTrabajos($_POST));
  }

  public function show()
  {

    $result = $this->Mtecnicos->getOne($_POST['id']);
    $param = array(
      'categoria' => $result
    );
    $this->load->view('categorias/detail', $param);
  }
}
