<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 *
 */
class Ccuentas extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Musuarios');
    $this->load->model('Mcentros');
    $this->permisos = $this->backend_lib->control();
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $data = array(
      "permisos" => $this->permisos
    );
    $data = $this->Musuarios->getOne($this->session->userdata("id"));
    $vector = array(
      "usuario" => $data
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view('usuarios/cuenta', $vector);
    $this->load->view('layouts/footer');
  }
  public function update_pwd()
  {
    $_POST["password"] = sha1(md5($_POST["password"]));
    $this->Musuarios->update($_POST);
  }
}
