<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Cmanuales extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mmanuales');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $acciones = $this->session->userdata("acciones");
    $this->session->set_userdata('controlador', $this->uri->segment(2));
    foreach ($acciones as $accion) {
      if ($accion->modulo == "manuales") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }

    $data = array(
      "manuales" => $this->Mmanuales->getAll()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("manuales/list", $data);
    $this->load->view("manuales/modal_edit");
    $this->load->view("manuales/modal_add");
    $this->load->view("manuales/modal_consulta");
    $this->load->view("manuales/detalle_consulta");
    $this->load->view("layouts/footer");
  }

  // Refactoring
  public function ServiceGetAll()
  {
    echo json_encode($this->Mmanuales->getAllManuals());
  }
  public function ServiceGetOne($id)
  {
    echo json_encode($this->Mmanuales->getOneManual($id));
  }
  public function delete($id)
  {
    $this->Mmanuales->delete(array('id' => $id));
  }



  public function getAll()
  {
    echo json_encode($this->Mmanuales->getAll());
  }
  public function getOne($id = '')
  {
    if ($id != '') {
      $_POST['id'] = $id;
    }
    echo json_encode($this->Mmanuales->getOne($_POST));
  }
  public function add()
  {

    $this->form_validation->set_rules("descripcion", "Descripcion del manual", "is_unique[manuales.descripcion]|required|min_length[4]");
    $this->form_validation->set_rules("url", "url ingresada", "is_unique[manuales.url]|required|min_length[4]");
    if ($this->form_validation->run()) {
      if ($result = $this->Mmanuales->add($_POST)) {
        echo json_encode(array('result' => $result));
        return;
      }
    } else {
      echo json_encode(array('error' => validation_errors()));
      return;
    }
  }
  public function update()
  {

    if ($this->Mmanuales->getOne($_POST)->url == $_POST["url"]) {
      $this->form_validation->set_rules("url", "Url valida", "required|min_length[4]");
    } else {
      $this->form_validation->set_rules("url", "Url valida", "is_unique[manuales.url]|required|min_length[4]");
    }

    if ($this->form_validation->run()) {

      if ($this->Mmanuales->update($_POST)) {
      }
      $vector_respuesta = array(
        "caso" => 1
      );
    } else {
      $informacion_error = validation_errors();
      $vector_respuesta = array(

        "caso" => 2,
        "informacion_error" => $informacion_error
      );
    }
    echo json_encode($vector_respuesta);
  }

  public function activate()
  {
    // $this->Minvimas->activate($_POST);
  }
  public function show()
  {
    $manuales_activos = $this->Mmanuales->get();
    $this->load->view("manuales/detalle_consulta", array("manuales_activos" => $manuales_activos));
  }
}
