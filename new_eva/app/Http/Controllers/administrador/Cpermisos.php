<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cpermisos extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mpermisos');
    $this->load->model('Musuarios');
    $this->permisos = $this->backend_lib->control();
  }
  public function index()
  {

    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $permisos = $this->Mpermisos->get();
    $param = array(
      'permisos_listado' => $permisos
    );
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('permisos/list', $param);
    $this->load->view('layouts/footer');
  }
  public function add()
  { // Este add no almacena directamente, lo que hace es llamar un formulario
    $param = array(
      'roles' => $this->Musuarios->getRoles(),
      'menus' => $this->Mpermisos->getMenus()

    );

    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('permisos/add', $param);
    $this->load->view('layouts/footer');
  }
  public function save()
  {
    if ($this->Mpermisos->save($_POST)) {
      redirect(base_url() . "administrador/Cpermisos/add");
    } else {
      $this->session->set_flashdata("error", "No se pudo guardar la información");
      redirect(base_url() . "administrador/Cpermisos");
    }
  }
  public function edit($param)
  {
    $param = array(
      'roles' => $this->Musuarios->getRoles(),
      'menus' => $this->Mpermisos->getMenus(),
      'permiso' => $this->Mpermisos->getOne($param)
    );

    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('permisos/edit', $param);
    $this->load->view('layouts/footer');
  }
  public function update()
  {
    unset($_POST["menu_id"]);
    unset($_POST["rol_id"]);
    print_r($_POST);
    if ($this->Mpermisos->update($_POST)) {
      redirect(base_url() . "administrador/Cpermisos/add");
    } else {
      $this->session->set_flashdata("error", "No se pudo guardar la información");
      redirect(base_url() . "administrador/Cpermisos");
    }
  }
  public function delete($param)
  {
    if (!$this->Mpermisos->delete($param)) {
      redirect(base_url() . "administrador/Cpermisos");
    }
  }
}
