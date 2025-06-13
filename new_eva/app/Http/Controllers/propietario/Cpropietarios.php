<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cpropietarios extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mpropietarios');
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
      if ($accion->modulo == "propietarios") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }

    $data = array(
      "propietarios" => $this->Mpropietarios->getAll()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("propietarios/list", $data);
    $this->load->view("propietarios/modal_edit");
    $this->load->view("propietarios/modal_add");
    $this->load->view("layouts/footer");
  }
  public function getAll()
  {
    echo json_encode($this->Mpropietarios->getAll());
  }
  public function getOne()
  {
    echo json_encode($this->Mpropietarios->getOne($_POST));
  }
  public function add()
  {

    $this->form_validation->set_rules("nombre", "Nombre del propietario", "is_unique[propietarios.nombre]|required|min_length[4]");
    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_imagenes"; //Evaluacion del archivo
      $config['allowed_types'] = 'gif|jpg|png';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadImage');
      $this->uploadImage->initialize($config);

      if (!empty($_FILES["logo"]["name"])) {
        $this->uploadImage->do_upload("logo"); //
        $data = "";
        $data = $this->uploadImage->data();
        $_POST["logo"] = $data["file_name"];
      }
      if ($this->Mpropietarios->add($_POST)) {
      } else {
        if (isset($_POST["logo"])) {
          $this->load->helper("file");
          unlink("./assets/upload_imagenes/" . $_POST["logo"]);
        }
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
  public function update()
  {

    if ($this->Mpropietarios->getOne($_POST)->nombre == $_POST["nombre"]) {
      $this->form_validation->set_rules("nombre", "Nombre del propietario", "required|min_length[4]");
    } else {
      $this->form_validation->set_rules("nombre", "Nombre del propietario", "is_unique[propietarios.nombre]|required|min_length[4]");
    }

    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_imagenes"; //Evaluacion del archivo
      $config['allowed_types'] = 'gif|jpg|png';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadImage');
      $this->uploadImage->initialize($config);

      if (!empty($_FILES["logo"]["name"])) {
        $this->uploadImage->do_upload("logo"); //Esto sube el excel en la carpeta
        $data = "";
        $data = $this->uploadImage->data();
        $_POST["logo"] = $data["file_name"];
      }
      if ($this->Mpropietarios->update($_POST)) {
      } else {
        if (isset($_POST["logo"])) {
          $this->load->helper("file");
          unlink("./assets/upload_imagenes/" . $_POST["logo"]);
        }
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
  public function delete()
  {
    // $this->Minvimas->delete($_POST);
  }
  public function activate()
  {
    // $this->Minvimas->activate($_POST);
  }
}
