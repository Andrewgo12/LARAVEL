<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cequipos_ind extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos_ind');
    $this->load->model('Mequipos');
    $this->load->model("Mpreventivos");
    $this->load->model("Mcalibraciones");
    $this->load->model("Mcorrectivos_generales");
    $this->load->model("Mcorrectivos_generales_archivos");
    $this->load->model("Mordenes");
    $this->load->helper('download');
    //$this->permisos=$this->backend_lib->control();
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }

    $this->session->set_userdata('tipo_id', 2);
    $this->session->set_userdata('controlador', $this->uri->segment(2));


    $acciones = $this->session->userdata("acciones");
    foreach ($acciones as $accion) {
      if ($accion->modulo == "equipos") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }
    $data = array(
      "permisos" => $this->permisos,
      "garantia_casi_vencida" => $this->Mequipos->garantia_casi_vencida(),
      "garantia_vencida" => $this->Mequipos->garantia_vencida(),
      "equipos_baja" => $this->Mequipos->equipos_baja(),
      "equipos_pendientes_baja" => $this->Mequipos->equipos_pendientes_baja(),
      "acciones" => $acciones
    );
    $this->Mequipos->updateEstadomAutomatico();

    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("equipos_industriales/list", $data);
    /*CRUD EQUIPO*/
    $this->load->view("equipos/modal_add", array("tipo_id" => 2));
    $this->load->view("equipos/modal_edit", array("tipo_id" => 2));
    $this->load->view("equipos/modal_copy", array("tipo_id" => 2));
    /*DETALLE EQUIPO*/
    $this->load->view("equipos/modal_show_adquisicion");
    $this->load->view("equipos/modal_show_instalacion");
    $this->load->view("equipos/modal_show", array("tipo_id" => 2));/*metodo show en el controlador*/
    /*CRUD REPUESTOS*/
    $this->load->view("equipos/modal_add_repuesto");
    $this->load->view("equipos/modal_edit_equipo_repuesto");
    //$this->load->view("equipos/modal_edit_calibracion");
    /*CRUD ESPECIFICACIONES*/
    $this->load->view("equipos/modal_add_equipo_especificacion");
    /*CRUD CONTACTOS*/
    $this->load->view("equipos/modal_add_equipo_contacto");
    /*CARGA VISTA DEL FILTRO*/
    $this->load->view("equipos/modal_filter");
    /*CARGA EL ARCHIVO EXCEL DE HOJA DE VIDA CON PLUGIN GOOGLE*/
    $this->load->view("equipos/modal_show_file");
    /*CARGA EL MODAL PARA MOSTRAR DOCUMENTACION DEL EUIPO*/
    $this->load->view("equipos/modal_show_archivos");
    /*CARGA EL MODAL PARA GUARDAR ARCHIVOS DE DOCUMENTACION DEL EQUIPO*/
    $this->load->view("equipos/modal_add_archivos");
    $this->load->view("archivos/modal_compartir"); // Modal de compartir archivos
    /*CARGA EL MODAL PARA GUARDAR OBSERVACIONES*/
    $this->load->view("equipos/modal_add_observacion");
    /*CARGA EL MODAL PARA editar OBSERVACIONES*/
    $this->load->view("equipos/modal_edit_observacion");
    /*CARGA EL MODAL PARA mostrar las garantias proximas a vencer*/
    $this->load->view("equipos/modal_show_garantiaCasiVencida");
    /*CARGA EL MODAL PARA mostrar las garantias vencidas receintemente*/
    $this->load->view("equipos/modal_show_garantiaVencida");
    /*CARGA EL MODAL PARA insertar multiples registros al tiempo*/
    $this->load->view("equipos/modal_multiple");
    /*CARGA EL MODAL PARA visualizar equipos obsoletos*/
    $this->load->view("equipos/modal_obsoletos");
    /*CARGA EL MODAL PARA visualizar el formulario de insercion de archivos para correctivos*/
    $this->load->view("equipos/modal_add_archivo_correctivo");
    /*CARGA EL MODAL PARA visualizar el formulario de insercion de servicios desde equipos*/
    $this->load->view("servicios/modal_add");


    /*Modal relacionado CORRECTIVOS GENERALES*/
    $this->load->view("correctivos_generales/modal_add");
    $this->load->view("correctivos_generales/modal_edit");
    $this->load->view("correctivos_generales/modal_show");
    $this->load->view("correctivos_generales/modal_show_single");
    $this->load->view("avances_correctivos/modal_add"); // Avances de correctivos generales    

    /*Modal relacionado PREVENTIVOS*/
    $this->load->view("preventivos/modal_add");
    $this->load->view("preventivos/modal_edit");
    $this->load->view("preventivos/modal_show");


    /*Modal relacionado CALIBRACIONES*/
    $this->load->view("calibraciones/modal_add");
    $this->load->view("calibraciones/modal_edit");
    $this->load->view("calibraciones/modal_show");

    /*Modal relacionado registros sanitarios*/
    $this->load->view("invimas/modal_add");
    $this->load->view("invimas/modal_consulta");

    /*Modal relacionado ordenes de compra*/
    $this->load->view("ordenes_compra/modal_consulta");
    $this->load->view("ordenes_compra/modal_add");

    /*Modal relacionado bajas*/
    //$this->load->view("bajas/modal_add_equipo_baja");
    $this->load->view("bajas/modal_add");
    $this->load->view("bajas/modal_consulta");

    /*Modal relacionado contingencias*/
    $this->load->view("contingencias/modal_add");

    /*Modal relacionado guias*/
    $this->load->view("guias/modal_consulta");

    /*Modal relacionado manuales*/
    $this->load->view("manuales/modal_consulta");

    /*Modal relacionado con areas*/
    $this->load->view("areas/modal_add");

    /*Modal para compartir (copiar especificaciones tecnicas)*/
    $this->load->view("equipos/modal_compartir_especificaciones");

    /*Modal del detalle de movimiento de equipos*/
    $this->load->view("cambios_ubicaciones/modal_show");

    $this->load->view("ordenes/modal_timeline"); // Se copio de ordenes para tener a disposicion el modal

    /*Modal del historial de la hoja de vida*/
    $this->load->view("equipos/historial/modal_show");/*metodo show en el controlador*/

    /*Modal de insercion de nuevo propietario*/
    $this->load->view("propietarios/modal_add");/*metodo show en el controlador*/


    $this->load->view("layouts/footer");
  }

  public function getEquipo()
  { //server side processing


    //parametro inicio
    //parametro final
    //parametro de busqueda

    $start  = $this->input->post('start');
    $length = $this->input->post('length');
    $search = $this->input->post('search')['value'];

    $result = $this->Mequipos_ind->getEquipo($start, $length, $search);

    if ($result = $this->Mequipos_ind->getEquipo($start, $length, $search)) {

      //echo "se realizo la consulta";
      $resultado = $result['datos'];
      $totalDatos = $result['numDataTotal'];;


      $datos = array();

      foreach ($resultado->result_array() as $row) {
        $array = array();
        $array['rownum']    = $row['rownum'];
        $array['imagen']    = $row['imagen'];
        $array['nombre']    = $row['nombre'];
        $array['marca']     = $row['marca'];
        $array['serial']    = $row['serial'];
        $array['modelo']    = $row['modelo'];
        $array['codigo_inventario']    = $row['codigo_inventario'];
        $array['name']      = $row['name'];
        $array['namem']     = $row['namem'];
        $array['piso']           = $row['piso'];
        $array['archivo']        = $row['archivo'];
        $array['tension']        = $row['tension'];
        $array['corriente']      = $row['corriente'];
        $array['potencia']       = $row['potencia'];
        $array['temperatura']    = $row['temperatura'];
        $array['estado']                 = $row['estado'];
        $array['fecha_mantenimiento']    = $row['fecha_mantenimiento'];
        //$array['estado_mantenimiento']   = $row['estado_mantenimiento'];
        $datos[]            = $array;
      }

      $totalDatoObtenido = $resultado->num_rows();

      $json_data = array(
        "draw"            => intval($this->input->post('draw')),
        "recordsTotal"    => intval($totalDatoObtenido),
        "recordsFiltered" => intval($totalDatos),
        "data"            => $datos
      );
      //$this->load->view('layout/formulario_update',compact("resultado"));
      echo json_encode($json_data);
    } else {
      echo "No se realizo la consulta";
      $this->load->view('layout/header');
      $this->load->view('layout/menu');
      $this->load->view('layout/datatable');
      $this->load->view('layout/footer');
    }
  }

  public function add()
  {
    //Validacion del formulario
    $this->form_validation->set_rules('nombre', 'nombre', 'required');
    $this->form_validation->set_rules('marca', 'marca', 'required');
    $this->form_validation->set_rules('serial', 'serial', 'required');
    $this->form_validation->set_rules('modelo', 'modelo', 'required');
    $this->form_validation->set_rules('codigo_inventario', 'codigo inventario', 'required');
    $this->form_validation->set_rules('servicio_id', 'servicio', 'required');
    $this->form_validation->set_rules('periodicidad_id', 'periodicidad', 'required');

    if ($this->form_validation->run()) {

      $config['upload_path']   = './style/imagenes/';
      $config['allowed_types'] = 'gif|jpg|png|jfif';
      $config['max_size']      = '4048';
      $config['max_width']     = '4024';
      $config['max_height']    = '4008';

      $this->load->library('upload', $config, 'uploadImagen');
      $this->uploadImagen->initialize($config);
      $this->uploadImagen->do_upload("imagen"); //Esto sube la imagen en la carpeta
      //$form = $_POST;
      $data = "";
      $data = $this->uploadImagen->data();
      $_POST["imagen"] = $data["file_name"];
      //echo "Se cargo";
      //print_r($_POST);

      $config1['upload_path'] = './style/archivos/HV';
      $config1['allowed_types'] = 'pdf|xlsx|docx';
      $config1['max_size'] = '20048';

      $this->load->library('upload', $config1, 'uploadFile');
      $this->uploadFile->initialize($config1);
      $this->uploadFile->do_upload("archivo"); //Esto sube el excel en la carpeta
      $data = "";
      $data = $this->uploadFile->data();
      $_POST["archivo"] = $data["file_name"];


      $result = $this->Mequipos_ind->add($_POST);

      if ($result) {
        $msg['success'] = true;
        //$msg['type'] = 'add';
        echo json_encode($msg);
      }
    } else {

      $error = validation_errors();
      echo json_encode(['error' => $error]); //['error'=>$error]);

    }
  }

  public function upd()
  {
    $data = $_POST['rownum'];
    //echo "id=".$data;
    $actual = $this->Mequipos_ind->actual($data);
    //$msg['success'] = true;
    //echo json_encode($msg);
    if ($actual) {

      echo json_encode($actual);
      //downloads($actual);
    }
  }
  public function getOne()
  {

    echo json_encode($this->Mequipos_ind->getOne($_POST));
  }
  public function getLikeSerie()
  {
    $equipos = $this->Mequipos_ind->getLikeSerie($_POST);
    echo json_encode($equipos);
  }
  public function getLikeCodigo()
  {
    $equipos = $this->Mequipos_ind->getLikeCodigo($_POST);
    echo json_encode($equipos);
  }
  public function update()
  {
    //Validacion del formulario
    $this->form_validation->set_rules('nombre', 'nombre', 'required');
    $this->form_validation->set_rules('marca', 'marca', 'required');
    $this->form_validation->set_rules('serial', 'serial', 'required');
    $this->form_validation->set_rules('modelo', 'modelo', 'required');
    $this->form_validation->set_rules('codigo_inventario', 'codigo inventario', 'required');


    if ($this->form_validation->run()) {
      //print_r($_FILES);
      $config['upload_path']   = './style/imagenes/';
      $config['allowed_types'] = 'gif|jpg|png|jfif';
      //$config['max_size']      = '4048';
      //$config['max_width']     = '4024';
      //$config['max_height']    = '4008';

      $this->load->library('upload', $config, 'uploadImagen');
      $this->uploadImagen->initialize($config);


      $this->uploadImagen->do_upload("imagen"); //Esto sube la imagen en la carpeta
      $data = "";
      $data = $this->uploadImagen->data();
      $_POST["imagen"] = $data["file_name"];


      $config1['upload_path'] = './style/archivos/HV';
      $config1['allowed_types'] = 'pdf|xlsx|docx';
      $config1['max_size'] = '40048';

      $this->load->library('upload', $config1, 'uploadFile');
      $this->uploadFile->initialize($config1);

      $this->uploadFile->do_upload("archivo"); //Esto sube el excel en la carpeta
      $data = "";
      $data = $this->uploadFile->data();
      $_POST["archivo"] = $data["file_name"];


      //actualizacion  sin archivos o imagen
      $datos  = array(
        "id_equipos" => $_POST['id_equipos'],
        "nombre" => $_POST['nombre'],
        "marca" => $_POST['marca'],
        "serial" => $_POST['serial'],
        "modelo" => $_POST['modelo'],
        "codigo_inventario" => $_POST['codigo_inventario'],
        "tension" => $_POST['Tension'],
        "corriente" => $_POST['Corriente'],
        "potencia" => $_POST['Potencia'],
        "temperatura" => $_POST['Temperatura'],
        "servicio_id" => $_POST['servicio_id'],
        "periodicidad_id" => $_POST['periodicidad_id'],
        "piso_id" => $_POST['piso_id'],
        "fecha_mantenimiento" => $_POST['fecha_mantenimiento']
      );

      //actualizacion de solo imagen
      $datos1  = array(
        "id_equipos" => $_POST['id_equipos'],
        "imagen" => $_POST['imagen'],
        "nombre" => $_POST['nombre'],
        "marca" => $_POST['marca'],
        "serial" => $_POST['serial'],
        "modelo" => $_POST['modelo'],
        "codigo_inventario" => $_POST['codigo_inventario'],
        "tension" => $_POST['Tension'],
        "corriente" => $_POST['Corriente'],
        "potencia" => $_POST['Potencia'],
        "temperatura" => $_POST['Temperatura'],
        "servicio_id" => $_POST['servicio_id'],
        "periodicidad_id" => $_POST['periodicidad_id'],
        "piso_id" => $_POST['piso_id'],
        "fecha_mantenimiento" => $_POST['fecha_mantenimiento']
      );
      //actualizacion de archivo
      $datos2  = array(
        "id_equipos" => $_POST['id_equipos'],
        "nombre" => $_POST['nombre'],
        "marca" => $_POST['marca'],
        "serial" => $_POST['serial'],
        "modelo" => $_POST['modelo'],
        "codigo_inventario" => $_POST['codigo_inventario'],
        "archivo" => $_POST['archivo'],
        "tension" => $_POST['Tension'],
        "corriente" => $_POST['Corriente'],
        "potencia" => $_POST['Potencia'],
        "temperatura" => $_POST['Temperatura'],
        "servicio_id" => $_POST['servicio_id'],
        "periodicidad_id" => $_POST['periodicidad_id'],
        "piso_id" => $_POST['piso_id'],
        "fecha_mantenimiento" => $_POST['fecha_mantenimiento']
      );


      $valor  =  $_POST['id_equipos'];



      if (empty($_FILES["imagen"]["name"]) && empty($_FILES["archivo"]["name"])) {
        $result =  $this->Mequipos_ind->update($datos, $valor);
        $msg['success'] = true;
        $msg['type']    = "upd";
        echo json_encode($msg);
        //echo "0";

      } elseif (empty($_FILES["imagen"]["name"]) && !empty($_FILES["archivo"]["name"])) {
        $result =  $this->Mequipos_ind->update($datos2, $valor);
        $msg['success'] = true;
        $msg['type']    = "upd";
        echo json_encode($msg);
      } elseif (!empty($_FILES["imagen"]["name"]) && empty($_FILES["archivo"]["name"])) {
        $result =  $this->Mequipos_ind->update($datos1, $valor);
        $msg['success'] = true;
        $msg['type']    = "upd";
        echo json_encode($msg);
      } else {
        $result =  $this->Mequipos_ind->update($_POST, $valor);
        $msg['success'] = true;
        $msg['type']    = "upd";
        echo json_encode($msg);
      }
    } else {

      $error = validation_errors();
      echo json_encode(['error' => $error]);
    }
  }

  public function borrar()
  {

    $data = $_POST['rownum'];
    $actual = $this->Mequipos_ind->borrar($data);
    if ($actual) {
      $msg['success'] = true;
      $msg['type'] = "delete";
      echo json_encode($msg);
    }
  }

  public function getServicios()
  {

    $s  = $this->input->get('q');
    // echo json_encode($s);
    $result = $this->Mequipos_ind->getServicios($s);
    echo json_encode($result);
  }

  public function getMantenimiento()
  {

    $s  = $this->input->get('r');
    $result = $this->Mequipos_ind->getMantenimiento($s);
    echo json_encode($result);
  }
  public function getPiso()
  {

    $s  = $this->input->get('m');
    $result = $this->Mequipos_ind->getPiso($s);
    echo json_encode($result);
  }

  public function downloads($actual)
  {
    $data = file_get_contents('./style/archivos/HV/' . $actual);
    force_download($name, $data);
  }

  /*CRUD PREVENTIVO*/
  public function addPreventivo()
  {

    $config['upload_path'] = "./assets/upload_preventivos";
    $config['allowed_types'] = '*';
    $config['max_size']  = 1000000;
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadPreventivo');
    $this->uploadPreventivo->initialize($config);
    if (!empty($_FILES["file"]["name"])) {
      $this->uploadPreventivo->do_upload("file"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadPreventivo->data();
      $_POST["file"] = $data["file_name"];
    }

    $this->Mpreventivos->add_ind($_POST); //Agrego el preventivo  
    echo json_encode($_POST["equipo_id"]);
  }

  public function getPreventivos()
  {
    if ($this->Mpreventivos->get_ind($_POST) != null) {
      echo json_encode($this->Mpreventivos->get_ind($_POST));
    } else {
      echo 2;
    }
  }
  public function getOnePreventivo()
  {
    echo json_encode($this->Mpreventivos->getOne_ind($_POST));
  }
  public function updatePreventivo()
  {

    if (isset($_POST)) {
      $preventivo = $this->Mpreventivos->getOne_ind($_POST);
      $file_anterior = $preventivo->file;

      $config['upload_path'] = "./assets/upload_preventivos";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadPreventivo');
      $this->uploadPreventivo->initialize($config);
      if (!empty($_FILES["file"]["name"])) {
        $this->uploadPreventivo->do_upload("file"); //Esto sube el archivo
        $data = "";
        $data = $this->uploadPreventivo->data();
        $_POST["file"] = $data["file_name"];
      }
      if ($this->Mpreventivos->update_ind($_POST)) {
        if (isset($_POST["file"])) {
          if ($_POST["file"] != $file_anterior) {
            $this->load->helper("file");
            unlink("./assets/upload_preventivos/" . $file_anterior);
          }
        }
        echo json_encode($_POST["equipo_id"]);
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_preventivos/" . $_POST["file"]);
        }
      }
    }
  }

  public function deletePreventivo()
  {
    $vector = array("id" => $_POST["id"]);
    $preventivo = $this->Mpreventivos->getOne_ind($vector);
    $file = $preventivo->file;
    if ($this->Mpreventivos->delete_ind($_POST)) {
      if ($file != "" && $file != null) {
        $this->load->helper("file");
        unlink("./assets/upload_preventivos/" . $file);
      }
    }
  }

  public function getLastPreventivo()
  {
    echo json_encode($this->Mpreventivos->getLast_ind($_POST));
  }

  /*CRUD CORRECTIVOS GENERALES*/

  public function getCorrectivos()
  {
    if ($this->Mordenes->get($_POST) != null) {
      echo json_encode($this->Mordenes->get($_POST));
    } else {
      echo 2;
    }
  }

  public function addCorrectivoGeneral()
  {
    $config['upload_path'] = "./assets/upload_correctivos_generales";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadCorrectivoGeneral');
    $this->uploadCorrectivoGeneral->initialize($config);
    if (!empty($_FILES["file"]["name"])) {
      $this->uploadCorrectivoGeneral->do_upload("file"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadCorrectivoGeneral->data();
      $_POST["file"] = $data["file_name"];
    }



    $titulo = $_POST["titulo"];
    unset($_POST["titulo"]);
    $ultimo_id = $this->Mcorrectivos_generales->add_ind($_POST); //Agrego el correctivo

    if (isset($_POST["file"])) {
      $vector = array(
        "file" => $_POST["file"],
        "correctivo_general_id" => $ultimo_id,
        "titulo" => $titulo
      );
      $this->Mcorrectivos_generales_archivos->add_ind($vector);
    } else {
    }
    echo json_encode($_POST["equipo_id"]);
  }

  public function add_archivo_correctivo_general()
  {
    $config['upload_path'] = "./assets/upload_correctivos_generales";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadCorrectivoGeneral');
    $this->uploadCorrectivoGeneral->initialize($config);

    if (!empty($_FILES["file"]["name"])) {
      $this->uploadCorrectivoGeneral->do_upload("file"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadCorrectivoGeneral->data();
      $_POST["file"] = $data["file_name"];
      unset($_POST["equipo_id"]);

      $this->Mcorrectivos_generales_archivos->add_ind($_POST);
    }
  }
  public function getCorrectivosGenerales()
  {

    if ($this->Mcorrectivos_generales->get_ind($_POST) != null) {
      echo json_encode($this->Mcorrectivos_generales->get_ind($_POST));
    } else {
      echo 2;
    }
  }
  public function getArchivosCorrectivosGenerales()
  {
    echo json_encode($this->Mcorrectivos_generales_archivos->get_ind($_POST));
  }

  public function getOneCorrectivoGeneral()
  {
    echo json_encode($this->Mcorrectivos_generales->getOne_ind($_POST));
  }
  public function updateCorrectivoGeneral()
  {

    if (isset($_POST)) {
      # code...
      $correctivo = $this->Mcorrectivos_generales->getOne_ind($_POST);
      $file_anterior = $correctivo->file;

      $config['upload_path'] = "./assets/upload_correctivos_generales";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadCorrectivoGeneral');
      $this->uploadCorrectivoGeneral->initialize($config);


      if (!empty($_FILES["file"]["name"])) {
        $this->uploadCorrectivoGeneral->do_upload("file"); //Esto sube el archivo
        $data = "";
        $data = $this->uploadCorrectivoGeneral->data();
        $_POST["file"] = $data["file_name"];
      }
      if ($this->Mcorrectivos_generales->update_ind($_POST)) {

        if (isset($_POST["file"])) {
          if ($_POST["file"] != $file_anterior) {
            $this->load->helper("file");
            unlink("./assets/upload_correctivos_generales/" . $file_anterior);
          }
        }
        echo json_encode($_POST["equipo_id"]);
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_correctivos_generales/" . $_POST["file"]);
        }
      }
    }
  }
  public function deleteCorrectivoGeneral()
  {
    $this->load->helper("file");
    $resultados = $this->Mcorrectivos_generales_archivos->getAll_ind($_POST);
    foreach ($resultados as $resultado) {
      if ($this->Mcorrectivos_generales_archivos->delete_ind($resultado->id)) {
        unlink("./assets/upload_correctivos_generales/" . $resultado->file);
      }
    }
    $this->Mcorrectivos_generales->delete_ind($_POST);
  }

  /*CRUD CALIBRACION*/
  public function addCalibracion()
  {
    $config['upload_path'] = "./assets/upload_calibraciones";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadCalibracion');
    $this->uploadCalibracion->initialize($config);
    if (!empty($_FILES["file"]["name"])) {
      $this->uploadCalibracion->do_upload("file"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadCalibracion->data();
      $_POST["file"] = $data["file_name"];
    }
    $this->Mcalibraciones->add_ind($_POST);
    echo json_encode($_POST["equipo_id"]);
  }

  public function getCalibraciones()
  {
    if ($this->Mcalibraciones->get_ind($_POST) != null) {
      echo json_encode($this->Mcalibraciones->get_ind($_POST));
    } else {
      echo 2;
    }
  }

  public function getOneCalibracion()
  {
    echo json_encode($this->Mcalibraciones->getOne_ind($_POST));
  }

  public function updateCalibracion()
  {
    if (isset($_POST)) {
      # code...
      $calibracion = $this->Mcalibraciones->getOne_ind($_POST);
      $file_anterior = $calibracion->file;

      $config['upload_path'] = "./assets/upload_calibraciones";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadCalibracion');
      $this->uploadCalibracion->initialize($config);
      if (!empty($_FILES["file"]["name"])) {
        $this->uploadCalibracion->do_upload("file"); //Esto sube el archivo
        $data = "";
        $data = $this->uploadCalibracion->data();
        $_POST["file"] = $data["file_name"];
      }
      if ($this->Mcalibraciones->update_ind($_POST)) {
        if (isset($_POST["file"])) {
          if ($_POST["file"] != $file_anterior) {
            $this->load->helper("file");
            unlink("./assets/upload_calibraciones/" . $file_anterior);
          }
        }
        echo json_encode($_POST["equipo_id"]);
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_calibraciones/" . $_POST["file"]);
        }
      }
    }
  }
  public function deleteCalibracion()
  {
    $vector = array(
      "id" => $_POST["id"]
    );
    $calibracion = $this->Mcalibraciones->getOne_ind($vector);
    $file = $calibracion->file;
    if ($this->Mcalibraciones->delete_ind($_POST)) {
      if ($file != "" && $file != null) {
        $this->load->helper("file");
        unlink("./assets/upload_calibraciones/" . $file);
      }
    }
  }
}
