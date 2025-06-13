<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Ccontactos extends CI_Controller
{
  private $servicios;
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mcontactos");

    // $this->permisos=$this->backend_lib->control();

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
    $this->load->view("contactos/list");
    $this->load->view("layouts/footer");
  }
  public function get_datatable()
  {
    echo json_encode($this->Mcontactos->get_datatable());
  }
  public function get()
  {
    echo json_encode($this->Mcontactos->get());
  }
  public function getOne()
  {
    echo json_encode($this->Mcontactos->getOne($_POST));
  }
  public function getProveedores()
  {
    echo json_encode($this->Mcontactos->getProveedores());
  }
  public function getTcontactos()
  {
    echo json_encode($this->Mcontactos->getTcontactos($_POST));
  }

  public function update()
  {
    $servicio = $this->Mcontactos->getOne($_POST);
    if ($servicio->name == $_POST["name"]) {
      $this->form_validation->set_rules("name", "Nombre del contacto", "required|min_length[3]");
    } else {
      $this->form_validation->set_rules("name", "Nombre del contacto", "required|min_length[3]|is_unique[servicios.name]");
    }
    if ($this->form_validation->run()) {
      $this->Mcontactos->update($_POST);
      $vector = array(
        'respuesta' => 1,
        'informacion' => ""
      );
    } else {
      $vector = array(
        'respuesta' => 2,
        'informacion' => validation_errors()
      );
    }
    echo json_encode($vector);
  }
  public function add()
  {

    if (isset($_POST["id"])) {
      unset($_POST["id"]);
    }
    $this->form_validation->set_rules("name", "Nombre del contacto", "is_unique[contacto.name]|required|min_length[3]");
    $this->form_validation->set_rules("tcontacto_id", "Tipo de contacto", "required");


    if ($this->form_validation->run()) {
      $vector = array(
        'respuesta' => 1,
        'informacion' => ""
      );
      $this->Mcontactos->add($_POST);
    } else {
      $vector = array(
        'respuesta' => 2,
        'informacion' => validation_errors()
      );
    }
    echo json_encode($vector);
  }
  public function delete()
  {
    $_POST["status"] = 2;
    $this->Mcontactos->delete($_POST);
  }

  public function getPisos()
  {
    echo json_encode($this->Mpisos->get());
  }
  public function getZonas()
  {
    echo json_encode($this->Mzonas->get());
  }
  public function getCentros()
  {
    echo json_encode($this->Mcentros->get());
  }
  public function getProveedoresMantenimiento()
  {
    echo json_encode($this->Mcontactos->getProveedoresMantenimiento());
  }
}
