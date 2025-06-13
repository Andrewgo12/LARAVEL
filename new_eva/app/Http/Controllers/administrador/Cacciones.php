<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cacciones extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Macciones');
  }

  public function getAll()
  {
  }
  public function getByUser()
  {
  }
  public function edit()
  {
    $registro_acciones = $this->Macciones->getOne($_POST);

    if ($_POST["accion"] == 1) {
      if ($registro_acciones->leer == 1) {
        $_POST["leer"] = 0;
      } else {
        $_POST["leer"] = 1;
      }
    } else if ($_POST["accion"] == 2) {
      if ($registro_acciones->insertar == 1) {
        $_POST["insertar"] = 0;
      } else {
        $_POST["insertar"] = 1;
      }
    } else if ($_POST["accion"] == 3) {
      if ($registro_acciones->editar == 1) {
        $_POST["editar"] = 0;
      } else {
        $_POST["editar"] = 1;
      }
    } else if ($_POST["accion"] == 4) {
      if ($registro_acciones->eliminar == 1) {
        $_POST["eliminar"] = 0;
      } else {
        $_POST["eliminar"] = 1;
      }
    }
    unset($_POST["accion"]);
    $this->Macciones->edit($_POST);
    echo json_encode($this->Macciones->getByUser($registro_acciones->usuario_id));
  }
  /*
	public function add(){// Este add no almacena directamente, lo que hace es llamar un formulario
		$param=array(
			'roles' => $this->Musuarios->getRoles(),
			'menus' => $this->Mpermisos->getMenus()
			
			);

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('permisos/add',$param);
		$this->load->view('layouts/footer');

	}
	public function delete($param){
		if(!$this->Mpermisos->delete($param)){
			redirect(base_url()."administrador/Cpermisos");

		}

	}
	*/
}
