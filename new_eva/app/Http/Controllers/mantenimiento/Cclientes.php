<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Cclientes extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mclientes');
    $this->permisos = $this->backend_lib->control();
  }
  public function index()
  {
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view("clientes/list");
    $this->load->view("clientes/modal_add");
    $this->load->view("clientes/modal_edit");
    $this->load->view("clientes/modal_show");
    $this->load->view('layouts/footer');
  }
  public function get_server_side()
  {
    $vector = $this->Mclientes->get_server_side($_POST);

    $respuesta = array(

      'draw' => intval($this->input->post('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos']

    );

    echo json_encode($respuesta);
  }
  public function add()
  {

    $this->Mclientes->add($_POST);
  }
  public function update()
  {
    $this->Mclientes->update($_POST);
  }
  public function delete()
  {
    $array = array('estado' => 0);
    $this->Mclientes->delete($_POST, $array);
  }
  public function show()
  {

    $result = $this->Mclientes->getOne($_POST['id']);
    $param = array(
      'cliente' => $result
    );
    $this->load->view('clientes/detail', $param);
  }
}
