<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Ccharts extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('id')) {
      redirect('Cauth');
    }
    $this->load->model("Mordenes");
    $this->load->model("Mcorrectivos_generales");
    $this->load->model("Mplanes");
    $this->load->model("Mpreventivos");
    $this->load->model("Mcbiomedicas");
    $this->load->model("Mcriesgos");
    $this->load->model("Mequipos");
    $this->load->model("Mestadoequipos");
  }
  public function index()
  {

    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view('admin/charts');
    $this->load->view('layouts/footer');
  }
  /*----------------Pagina 1 Estados---------------------*/
  public function getGeneratedByDate()
  {
    echo json_encode($this->Mordenes->getGeneratedByDate($_POST));
  }
  public function getClosedByDate()
  {
    echo json_encode($this->Mordenes->getClosedByDate($_POST));
  }
  public function getByStatus()
  {
    echo json_encode($this->Mordenes->getByStatus($_POST));
  }
  /*----------------Pagina 1 Correctivos generales---------------------*/

  public function getCorrectivosGeneralesGeneratedByDate()
  {
    echo json_encode($this->Mcorrectivos_generales->getCorrectivosGeneralesGeneratedByDate($_POST));
  }

  public function getCorrectivosGeneralesClosedByDate()
  {
    echo json_encode($this->Mcorrectivos_generales->getCorrectivosGeneralesClosedByDate($_POST));
  }

  public function getCorrectivosGeneralesByStatus()
  {
    echo json_encode($this->Mcorrectivos_generales->getCorrectivosGeneralesByStatus($_POST));
  }
  /*----------------Pagina 1 Tickets---------------------*/

  public function getTicketsIndicador()
  {
    echo json_encode($this->Mordenes->getTicketsIndicador($_POST));
  }
  public function getCorrectivosGeneralesIndicador()
  {
    echo json_encode($this->Mcorrectivos_generales->getCorrectivosGeneralesIndicador($_POST));
  }

  /*-----------------Pagina 2--------------------*/

  public function getPreventivosProgramados()
  {
    echo json_encode($this->Mplanes->getPreventivosProgramados($_POST));
  }
  public function getPreventivosEjecutados()
  {
    echo json_encode($this->Mpreventivos->getPreventivosEjecutados($_POST));
  }
  public function getPreventivosIndicador()
  {
    echo json_encode($this->Mpreventivos->getPreventivosIndicador($_POST));
  }
  /*-----------------Pagina 3--------------------*/

  public function getDistributionCbiomedicaOnDevices()
  {
    echo json_encode($this->Mcbiomedicas->getDistributionCbiomedicaOnDevices($_POST));
  }
  public function getDistributionCriesgoOnDevices()
  {
    echo json_encode($this->Mcriesgos->getDistributionCriesgoOnDevices($_POST));
  }
  public function getDistributionEstadosByDevice()
  {
    echo json_encode($this->Mestadoequipos->getDistributionEstadosByDevice($_POST));
  }
  public function getEquiposAdquisiciones()
  {
    echo json_encode($this->Mequipos->getEquiposAdquisiciones($_POST));
  }
  public function getEquiposInstalaciones()
  {
    echo json_encode($this->Mequipos->getEquiposInstalaciones($_POST));
  }
  public function getEquipoInstalacionAdquisicionIndicador()
  {
    echo json_encode($this->Mequipos->getEquipoInstalacionAdquisicionIndicador($_POST));
  }
}
