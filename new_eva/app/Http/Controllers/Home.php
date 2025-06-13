<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
class Home extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('id')) {
      redirect('Cauth');
    }
    $this->load->model("Mequipos");
    $this->load->model("Mguias");
    $this->load->model("Mcambios_hdv");
  }
  public function index()
  {
    // $this->Mequipos->updateEstadomAutomatico();
    $this->Mequipos->depurarCodigo();
    $this->Mcambios_hdv->depurarCodigo();
    $fecha_actual = date("Y-m-d");
    $vector = array(
      "estado_mantenimiento" => 2
    );
    $this->Mequipos->UpdateEstadom($fecha_actual, $vector);
    $vector = "";
    $vector = array(
      "plan" => 3
    );
    $this->Mequipos->UpdatePlan($vector);
    $guias_rapidas = $this->Mguias->getWithQuery();
    $vector_guias = array(
      "guias" => $guias_rapidas
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("admin/home", $vector_guias);
    $this->load->view("guias/modal_show_relacionar_guia");
    $this->load->view("layouts/footer");
  }
  public function relacionar_con_equipos()
  {
    echo json_encode($_POST);
  }
}
