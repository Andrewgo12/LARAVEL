<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Ccapacitaciones extends CI_Controller
{
  //private $capacitaciones;
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mcapacitaciones");
    //$this->load->model("Mequipo_repuestos");
    // $this->load->model("Mmovimientos");
    // $this->permisos=$this->backend_lib->control();

  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $acciones = $this->session->userdata("acciones");

    foreach ($acciones as $accion) {
      if ($accion->modulo == "capacitaciones") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }
    $capacitaciones_realizadas = $this->Mcapacitaciones->getAll();
    $capacitaciones_archivo = $this->Mcapacitaciones->getCapacitacionesArchivo();
    $capacitaciones_equipo = $this->Mcapacitaciones->getCapacitacionesEquipo();
    $capacitaciones_mes = $this->Mcapacitaciones->getCapacitacionesMes();
    $vector_capacitaciones = array(
      "capacitaciones_realizadas" => $capacitaciones_realizadas,
      "capacitaciones_archivo" => $capacitaciones_archivo,
      "capacitaciones_equipo" => $capacitaciones_equipo,
      "capacitaciones_mes" => $capacitaciones_mes
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("capacitaciones/list", $vector_capacitaciones);
    $this->load->view("layouts/footer");
  }
}
