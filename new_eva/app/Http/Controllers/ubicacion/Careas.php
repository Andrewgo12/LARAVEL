<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Careas extends CI_Controller
{
  private $servicios;
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mareas");
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
      if ($accion->modulo == "contactos") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }

    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("areas/list");
    $this->load->view("areas/modal_add");
    $this->load->view("areas/modal_edit");
    $this->load->view("layouts/footer");
  }

  // Refactoring
  public function ServiceGetAll()
  {
    echo json_encode($this->Mareas->getAllAreas());
  }
  public function ServiceGetOne($id)
  {
    echo json_encode($this->Mareas->getOneArea($id));
  }
  public function ServiceGetByService($id)
  {
    echo json_encode($this->Mareas->getByService($id));
  }
  public function delete($id)
  {
    return $this->Mareas->delete(array('id' => $id));
  }



  public function getAll()
  {
    echo json_encode($this->Mareas->getAll());
  }
  public function getOne()
  {
    echo json_encode($this->Mareas->getOne($_POST));
  }
  public function getAreaByservicio()
  {
    echo json_encode($this->Mareas->getAreaByservicio($_POST));
  }
  public function add()
  {
    $this->form_validation->set_rules("name", "Nombre del area", "is_unique[areas.name]|required|min_length[4]");
    if ($this->form_validation->run()) {
      if ($result = $this->Mareas->add($_POST)) {
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

    if ($this->Mareas->getOne($_POST)->name == $_POST["name"]) {
      $this->form_validation->set_rules("name", "Nombre del area", "required|min_length[4]");
    } else {
      $this->form_validation->set_rules("name", "Nombre del area", "is_unique[areas.name]|required|min_length[4]");
    }

    if ($this->form_validation->run()) {

      if ($this->Mareas->update($_POST)) {
      } else {
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
}
