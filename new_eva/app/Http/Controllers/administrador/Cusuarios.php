<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
class Cusuarios extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Musuarios');
    $this->load->model('Musuarios_zonas');
    $this->load->model('Mcentros');
    $this->load->model('Macciones');
    $this->load->model('Mmodulos');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $this->session->set_userdata('controlador', $this->uri->segment(2));
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view('usuarios/list', array("modulos" => $this->Mmodulos->getWithAccount()));
    $this->load->view('usuarios/modal_add');
    $this->load->view('usuarios/modal_edit');
    $this->load->view('usuarios/modal_show');
    $this->load->view('usuarios/modal_add_usuario_zona');
    $this->load->view('layouts/footer');
  }
  public function ServiceGetAll()
  {
    echo json_encode($this->Musuarios->getAllUsers());
  }
  public function ServiceGetOne($id)
  {
    echo json_encode($this->Musuarios->getOneUser($id));
  }

  public function getAll()
  {
    echo json_encode($this->Musuarios->getAll());
  }
  public function get_server_side()
  {
    $vector = $this->Musuarios->get_server_side($_POST);
    $respuesta = array(
      'draw' => intval($this->input->post('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos']
    );
    echo json_encode($respuesta);
  }
  public function getRoles()
  {
    echo json_encode($this->Musuarios->getRoles());
  }
  public function add()
  {
    $this->form_validation->set_rules("username", "Nombre de usuario", "required|is_unique[usuarios.username]");
    $this->form_validation->set_rules("email", "Correo electronico", "required|is_unique[usuarios.email]|valid_email");
    $this->form_validation->set_rules("password", "Contraseña", "required|min_length[4]");
    if ($this->form_validation->run()) {
      echo json_encode(1);
      $_POST["password"] = sha1(md5($_POST["password"]));
      $this->Musuarios->add($_POST);
    } else {
      $error = array(
        'username' => form_error('username'),
        'email' => form_error('email'),
        'password' => form_error('password'),
      );
      echo json_encode($error);
    }
  }
  public function update()
  {
    $usuarioActual = $this->Musuarios->getOne($_POST['id']);
    if ($usuarioActual->username == $_POST["username"]) { //username unico
      $username_is_unique = "";
    } else {
      $username_is_unique = "|is_unique[usuarios.username]";
    }
    if ($usuarioActual->email == $_POST['email']) {
      $email_is_unique = "";
    } else {
      $email_is_unique = "|is_unique[usuarios.email]";
    }
    if ($_POST['password'] == '') { // Si usuario no escribe un password
      unset($_POST['password']);
      $this->form_validation->set_rules("username", "username", "required" . $username_is_unique);
      $this->form_validation->set_rules("email", "Correo electronico", "required" . $email_is_unique . "|valid_email");
      if ($this->form_validation->run()) {
        echo json_encode(1);
        $this->Musuarios->update($_POST);
      } else {
        $error = array(
          'username' => form_error('username'),
          'email' => form_error('email'),
        );
        echo json_encode($error);
      }
    } else {
      $this->form_validation->set_rules('password', 'Constraseña', 'min_length[4]');
      $this->form_validation->set_rules("username", "username", "required" . $username_is_unique);
      $this->form_validation->set_rules("email", "Correo electronico", "required" . $email_is_unique . "|valid_email");
      if ($this->form_validation->run()) {
        echo json_encode(1);
        $_POST['password'] = sha1(md5($_POST["password"]));
        $this->Musuarios->update($_POST);
      } else {
        $error = array(
          'username' => form_error('username'),
          'email' => form_error('email'),
          'password' => form_error('password'),
        );
        echo json_encode($error);
      }
    }
  }
  public function delete()
  {
    $array = array('estado' => 0);
    $this->Musuarios->delete($_POST, $array);
  }
  public function show()
  {
    $result = $this->Musuarios->getOne($_POST['id']);
    $param = array(
      'usuario' => $result
    );
    $this->load->view('usuarios/detail', $param);
  }
  public function getOne()
  {
    echo json_encode($this->Musuarios->getOne($_POST["id"]));
  }
  public function getOneWithActions()
  {
    $usuario = $this->Musuarios->getOne($_POST["id"]);
    $acciones = $this->Macciones->getByUser($_POST["id"]);
    $vector = array(
      "usuario" => $usuario,
      "acciones" => $acciones
    );
    echo json_encode($vector);
  }
  public function getCentros()
  {
    echo json_encode($this->Mcentros->get());
  }
  public function CambiarSede()
  {
    $usuario = $this->Musuarios->getOne($_POST["id"]);
    if ($usuario->sede_id == 1) {
      $param = array(
        "id" => $_POST["id"],
        "caso" => 1
      );
    } else {
      $param = array(
        "id" => $_POST["id"],
        "caso" => 2
      );
    }
    $this->Musuarios->CambiarSede($param);
    $usuario = "";
    $usuario = $this->Musuarios->getOne($_POST["id"]);
    $this->session->set_userdata('sede_id', $usuario->sede_id);
    echo json_encode($usuario->sede);
  }
  public function cambiar_sede_general()
  {
    $this->Musuarios->update(array("id" => $_POST["usuario_id"], "sede_id" => $_POST["sede_id"]));
    $this->session->set_userdata("sede_id", $_POST["sede_id"]);
    echo json_encode("");
  }

  public function getUsuarios_zonas()
  {
    echo json_encode($this->Musuarios->getUsuarios_zonas());
  }
  public function delete_usuario_zona()
  {
    echo json_encode($this->Musuarios->delete_usuario_zona($_POST));
  }
  public function add_usuario_zona()
  {
    echo json_encode($this->Musuarios_zonas->add($_POST));
  }
  public function getUsuariosFromEmpresa()
  {
    echo json_encode($this->Musuarios->getUsuariosFromEmpresa($_POST));
  }
  public function CambiarAnio()
  {
    $usuario_id = $_POST["id"];
    $usuario = $this->Musuarios->getOne($usuario_id);
    $this->Musuarios->CambiarAnio(array("id" => $usuario->id, "anio_plan" => $_POST["anio"]));
    $usuario = "";
    $usuario = $this->Musuarios->getOne($usuario_id);
    $this->session->set_userdata('anio_plan', $usuario->anio_plan);
    echo json_encode($usuario->anio_plan);
  }
}
