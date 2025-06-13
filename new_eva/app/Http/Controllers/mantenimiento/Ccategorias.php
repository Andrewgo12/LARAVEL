<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 *
 */
class Ccategorias extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mcategorias');
    $this->permisos = $this->backend_lib->control();
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $data = array(
      'permisos' => $this->permisos
    );
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('categorias/list', $data);
    $this->load->view('categorias/modal_add');
    $this->load->view('categorias/modal_edit');
    $this->load->view('categorias/modal_show');
    $this->load->view('layouts/footer');
  }
  public function get()
  {
    echo json_encode($this->Mcategorias->get());
  }
  public function get_server_side()
  {

    $vector = $this->Mcategorias->get_server_side($_POST);

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
    $this->form_validation->set_rules("nombre", "Nombre", "required|is_unique[categorias.nombre]");
    $this->form_validation->set_rules("descripcion", "Descripcion", "required|is_unique[categorias.descripcion]");
    if ($this->form_validation->run()) {
      echo json_encode(1);
      $this->Mcategorias->add($_POST);
    } else {
      $error = array(
        'nombre' => form_error('nombre'),
        'descripcion' => form_error('descripcion'),
      );
      echo json_encode($error);
    }
  }
  public function update()
  {
    $categoriaActual = $this->Mcategorias->getOne($_POST['id']);
    if ($_POST['nombre'] == $categoriaActual->nombre) {
      $unique = "";
    } else {
      $unique = "|is_unique[categorias.nombre]";
    }
    $this->form_validation->set_rules("nombre", "Nombre", "required" . $unique . "");
    $this->form_validation->set_rules("descripcion", "Descripcion", "required");
    if ($this->form_validation->run()) {
      echo json_encode(1);
      $this->Mcategorias->update($_POST);
    } else {
      $error = array(
        'nombre' => form_error('nombre'),
        'descripcion' => form_error('descripcion')
      );
      echo json_encode($error);
    }
  }
  public function delete()
  {
    $array = array('estado' => 0);
    $this->Mcategorias->delete($_POST, $array);
    // echo json_encode($_POST['id']);
  }
  public function show()
  {

    $result = $this->Mcategorias->getOne($_POST['id']);
    $param = array(
      'categoria' => $result
    );
    $this->load->view('categorias/detail', $param);
  }
}
