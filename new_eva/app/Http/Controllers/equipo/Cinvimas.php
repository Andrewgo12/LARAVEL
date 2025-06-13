<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Cinvimas extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Minvimas');
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
      if ($accion->modulo == "invimas") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }

    $data = array(
      "invimas" => $this->Minvimas->getAll()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("invimas/list", $data);
    $this->load->view("invimas/modal_edit");
    $this->load->view("invimas/modal_add");
    $this->load->view("equipos/modal_asociacion_invima");
    $this->load->view("equipos/modal_asociacion_invima_especifico");
    $this->load->view("layouts/footer");
  }
  public function get()
  {
    echo json_encode($this->Minvimas->get());
  }
  public function getAll()
  {
    echo json_encode($this->Minvimas->getAll());
  }
  public function getWithNumberDevices()
  {
    echo json_encode($this->Minvimas->getWithNumberDevices());
  }

  public function getOne()
  {
    echo json_encode($this->Minvimas->getOne($_POST));
  }
  public function getdescriptionlike()
  {
    echo json_encode($this->Minvimas->getdescriptionlike($_POST));
  }

  public function add()
  {

    $this->form_validation->set_rules("invima", "Registro sanitario", "is_unique[invimas.invima]|required|min_length[4]");
    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_registros_sanitarios"; //Evaluacion del archivo
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadFile');
      $this->uploadFile->initialize($config);

      if (!empty($_FILES["file"]["name"])) {
        $this->uploadFile->do_upload("file"); //Esto sube el excel en la carpeta
        $data = "";
        $data = $this->uploadFile->data();
        $_POST["file"] = $data["file_name"];
      }
      if ($this->Minvimas->add($_POST)) {
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_registros_sanitarios/" . $_POST["file"]);
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

    if ($this->Minvimas->getOne($_POST)->invima == $_POST["invima"]) {
      $this->form_validation->set_rules("invima", "Registro sanitario", "required|min_length[4]");
    } else {
      $this->form_validation->set_rules("invima", "Registro sanitario", "is_unique[invimas.invima]|required|min_length[4]");
    }

    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_registros_sanitarios"; //Evaluacion del archivo
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadFile');
      $this->uploadFile->initialize($config);

      if (!empty($_FILES["file"]["name"])) {
        $this->uploadFile->do_upload("file"); //Esto sube el excel en la carpeta
        $data = "";
        $data = $this->uploadFile->data();
        $_POST["file"] = $data["file_name"];
      }
      if ($this->Minvimas->update($_POST)) {
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_archivos/" . $_POST["file"]);
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
    $this->Minvimas->delete($_POST);
  }
  public function activate()
  {
    $this->Minvimas->activate($_POST);
  }

  public function show()
  {
    $invimas_activos = $this->Minvimas->getAll();
    $vector = array(
      "invimas" => $invimas_activos
    );
    $this->load->view("invimas/detalle_consulta", $vector);
  }
}
