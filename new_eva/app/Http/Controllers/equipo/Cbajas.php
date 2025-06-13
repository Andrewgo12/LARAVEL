<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cbajas extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mbajas');
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
      if ($accion->modulo == "bajas biomedicos") {
        if ($accion->leer != 1) {
          redirect(base_url('Home'));
        }
      }
    }

    $data = array(
      "bajas" => $this->Mbajas->get()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("bajas/list", $data);
    $this->load->view("bajas/modal_add");
    $this->load->view("bajas/modal_edit");
    $this->load->view("bajas/modal_asociacion_baja");
    $this->load->view("bajas/modal_asociacion_baja_especifico");
    $this->load->view("layouts/footer");
  }
  public function get()
  {

    echo json_encode($this->Mbajas->get());
  }
  public function getWithNumberDevices()
  {
    echo json_encode($this->Mbajas->getWithNumberDevices());
  }

  public function getOne()
  {
    echo json_encode($this->Mbajas->getOne($_POST));
  }

  public function get_equipos_bajas()
  {

    echo json_encode($this->Mbajas->get_equipos_bajas());
  }
  public function add()
  {

    $config['upload_path'] = "./assets/upload_bajas"; //Evaluacion del archivo
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadArchivo');
    $this->uploadArchivo->initialize($config);

    if (!empty($_FILES["archivo"]["name"])) {
      $this->uploadArchivo->do_upload("archivo"); //Esto sube el excel en la carpeta
      $data = "";
      $data = $this->uploadArchivo->data();
      $_POST["archivo"] = $data["file_name"];
    }

    if ($this->Mbajas->add($_POST)) {
      echo 1;
    } else {
      if (isset($_POST["archivo"])) {
        $this->load->helper("file");
        unlink("./assets/upload_bajas/" . $_POST["archivo"]);
      }
      echo 2;
    }
  }
  public function add_equipo_baja()
  {
    if (isset($_POST)) {
      $vector = array(
        "equipo_id" => $_POST["equipo_id"],
        "estadoequipo_id" => 6
      );
    }
    if ($this->Mbajas->add_equipo_bajas($_POST)) {
      $this->Mequipos->cambiar_dado_baja($vector);
    };
  }
  public function delete_equipo_baja()
  {
    $this->Mbajas->delete_equipo_baja($_POST);
  }
  public function show()
  {
    $bajas = $this->Mbajas->getAll();
    $vector = array(
      "bajas" => $bajas,
      "equipo_id" => $_POST["equipo_id"]
    );
    $this->load->view("bajas/detalle_consulta", $vector);
  }
  public function asociar_baja()
  {
    $_POST["estadoequipo_id"] = 6;
    $this->Mequipos->asociar_baja($_POST);
  }
  public function update()
  {
    if ($this->Mbajas->getOne($_POST)->descripcion == $_POST["descripcion"]) {
      $this->form_validation->set_rules("descripcion", "Descripcion del documento", "required|min_length[4]");
    } else {
      $this->form_validation->set_rules("descripcion", "Descripcion del documento", "is_unique[bajas.descripcion]|required|min_length[4]");
    }

    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_bajas"; //Evaluacion del archivo
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadFile');
      $this->uploadFile->initialize($config);

      if (!empty($_FILES["archivo"]["name"])) {
        $this->uploadFile->do_upload("archivo"); //Esto sube el excel en la carpeta
        $data = "";
        $data = $this->uploadFile->data();
        $_POST["archivo"] = $data["file_name"];
      }
      if ($this->Mbajas->update($_POST)) {
      } else {
        if (isset($_POST["archivo"])) {
          $this->load->helper("file");
          unlink("./assets/upload_archivos/" . $_POST["archivo"]);
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

  public function show_baja_asociaciones()
  {
    $equipos_a_asociar = $this->Mequipos->get();
    $vector = array(
      "equipos" => $equipos_a_asociar,
      "baja_id" => $_POST["baja_id"]
    );
    $this->load->view("bajas/modal_asociacion_baja_detail", $vector);
  }
  public function update_multiples_bajas()
  {
    //En el post llega un vector de id, de equipos llamado seleccion y el id del invima llamado invima_id

    if (isset($_POST["seleccion"])) {
      //$this->Mequipos->reset_baja($_POST["baja_id"]);
      $equipos_seleccionados = $_POST["seleccion"];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_bajas($equipo_id, $_POST["baja_id"]);
      }
      echo json_encode("El registro de disposición final fue asociado exitosamente a los equipos seleccionados");
    } else {
      echo json_encode("No se seleccionaron equipos");
    }
  }
  public function update_multiples_bajas_eliminar()
  {
    //En el post llega un vector de id, de equipos llamado seleccion y el id del invima llamado invima_id

    if (isset($_POST["seleccion"])) {
      $equipos_seleccionados = $_POST["seleccion"];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_bajas_eliminar($equipo_id, $_POST["baja_id"]);
      }
      echo json_encode("Los equipos seleccionados vinculados al documento de disposicion final fueron desvinculados");
    } else {
      echo json_encode("No se seleccionaron equipos");
    }
  }


  public function show_equipos_en_baja()
  {
    $equipos = $this->Mequipos->getEquiposEnBaja($_POST);
    $vector = array(
      "equipos" => $equipos,
      "baja_id" => $_POST["baja_id"]
    );
    $this->load->view("bajas/modal_asociacion_baja_detail_especifico", $vector);
  }
}
