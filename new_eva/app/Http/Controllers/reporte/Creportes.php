<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Creportes extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mordenes');
    $this->load->model('Mpreventivos');
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
      if ($accion->modulo == "reportes") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }

    $data = array(
      'permisos' => $this->permisos,
      'total' => $this->Mequipos->getTotal(),
      'incluidoPreventivo' => $this->Mequipos->getPlan(),
      'obtenidosComodato' => $this->Mequipos->getComodato(),
      'planNoComodato' => $this->Mequipos->getPlanNoComodato(),
      'estadoOrdenes' => $this->Mordenes->getPorEstado(),
      'PromedioTiempoTotal' => $this->Mordenes->getPromedioTotal(),
      'MenorTiempoTotal' => $this->Mordenes->getMenorTotal(),
      'MayorTiempoTotal' => $this->Mordenes->getMayorTotal(),
      'cbiomedicas' => $this->Mequipos->getCbiomedicas(),
      'criesgos' => $this->Mequipos->getCriesgos()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view('reportes/list', $data);
    // $this->load->view('categorias/modal_add');
    // $this->load->view('categorias/modal_edit');
    // $this->load->view('categorias/modal_show');
    $this->load->view('layouts/footer');
  }
  public function getByFechaCierre()
  {
    echo json_encode($this->Mordenes->getByFechaCierre($_POST));
  }
  public function getByFechaCreacion()
  {
    echo json_encode($this->Mordenes->getByFechaCreacion($_POST));
  }
  public function get_anios()
  { // funcion creada para obtener los años en que se han realizado preventivos
    echo json_encode($this->Mpreventivos->get_anios());
  }
  public function get_meses()
  { // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
    echo json_encode($this->Mpreventivos->get_meses($_POST));
  }
  public function preventivos_por_anio()
  { // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
    echo json_encode($this->Mpreventivos->get_preventivos_por_anio($_POST));
  }
  public function preventivos_por_anio_general()
  { // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
    echo json_encode($this->Mpreventivos->get_preventivos_por_anio_general($_POST));
  }
  public function preventivos_por_anio_mes()
  {
    echo json_encode($this->Mpreventivos->get_preventivos_por_anio_mes($_POST));
  }
  public function preventivos_por_anio_mes_general()
  {
    echo json_encode($this->Mpreventivos->get_preventivos_por_anio_mes_general($_POST));
  }
}
