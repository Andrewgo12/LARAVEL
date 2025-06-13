<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cordenes extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->library("email");
    $this->load->model("Mordenes");
    $this->load->model("Mequipos");
    $this->load->model("Mdiagnosticos");
    $this->load->model("Mcierres");
    $this->load->model("Musuarios");
    $this->load->model("Mrepuestos_ti");
    $this->load->model("Mempresas");
    $this->load->model("Mzonas");
    $this->load->model("Mavances_correctivos");
    $this->load->model('Mcambios_hdv');
    $this->load->model('Mcorrectivos_generales');
    $this->load->model('Mpreventivos');
    $this->load->model('Mobservaciones');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $acciones = $this->session->userdata("acciones");

    foreach ($acciones as $accion) {
      if ($accion->modulo == "tickets propios") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }
    if ($this->session->userdata("login")) {
      $data = array(
        'permisos' => $this->permisos
      );
      $this->session->set_userdata("editar_orden", "no");
      $this->session->set_userdata('controlador', $this->uri->segment(2));


      $this->load->view("layouts/header");
      $this->load->view("layouts/aside");
      $this->load->view("ordenes/list", $data);


      $this->load->view("ordenes/modal_add_biomedicos");
      $this->load->view("ordenes/modal_add_industriales");
      $this->load->view("ordenes/modal_add_otros");
      $this->load->view("ordenes/modal_show");
      $this->load->view("ordenes/modal_consulta_biomedicos");
      $this->load->view("ordenes/modal_timeline");


      $this->load->view("ordenes/modal_add_diagnostico_from_timeline");
      $this->load->view("ordenes/modal_add_solicitud_cierre_from_timeline");
      $this->load->view("avances_correctivos/modal_add");
      $this->load->view("layouts/footer");
    } else {
      redirect(base_url());
    }
  }
  public function list_active()
  {
    $acciones = $this->session->userdata("acciones");
    foreach ($acciones as $accion) {
      if ($accion->modulo === "tickets activos") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }
    if ($this->session->userdata("login")) {
      $data = array(
        'permisos' => $this->permisos
      );
      $this->session->set_userdata("editar_orden", "si");
      $this->load->view("layouts/header");
      $this->load->view("layouts/aside");
      $this->load->view("ordenes/list_active", $data);
      $this->load->view("equipos/modal_show");
      $this->load->view("ordenes/modal_show");
      $this->load->view("ordenes/modal_edit");
      $this->load->view("ordenes/modal_timeline");
      $this->load->view("ordenes/modal_add_diagnostico_from_timeline");
      $this->load->view("ordenes/modal_add_solicitud_cierre_from_timeline");
      $this->load->view("avances_correctivos/modal_add");
      $this->load->view("ordenes/modal_asignar_usuario");
      $this->load->view("ordenes/modal_asignar");
      $this->load->view("ordenes/modal_asignar_otro");
      $this->load->view("ordenes/modal_diagnose");
      $this->load->view("ordenes/modal_archivo_diagnose");
      $this->load->view("ordenes/modal_solicitud_cierre");
      $this->load->view("ordenes/modal_archivo_solicitud_cierre");
      $this->load->view("repuestos_pendientes/modal_add");
      $this->load->view("ordenes/modal_close");
      $this->load->view("equipos/historial/modal_show");
      $this->load->view("correctivos_generales/modal_show_single");
      $this->load->view("layouts/footer");
    } else {
      redirect(base_url());
    }
  }
  public function list_closed()
  {
    $acciones = $this->session->userdata("acciones");
    foreach ($acciones as $accion) {
      if ($accion->modulo == "tickets cerrados") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }
    if ($this->session->userdata("login")) {
      $this->session->set_userdata("editar_orden", "no");
      $this->load->view("layouts/header");
      $this->load->view("layouts/aside");
      $this->load->view("ordenes/list_closed");
      $this->load->view("ordenes/modal_show");
      $this->load->view("ordenes/modal_add_retro");
      $this->load->view("ordenes/modal_timeline");
      $this->load->view("ordenes/modal_add_diagnostico_from_timeline");
      $this->load->view("ordenes/modal_add_solicitud_cierre_from_timeline");
      $this->load->view("avances_correctivos/modal_add");
      $this->load->view("layouts/footer");
    } else {
      redirect(base_url());
    }
  }
  public function getByDevice()
  {
    echo json_encode($this->Mordenes->getByDevice($_POST));
  }
  public function getOwn()
  {
    echo json_encode($this->Mordenes->getOwn());
  }
  public function getOne()
  {
    echo json_encode($this->Mordenes->getOne($_POST));
  }
  public function getOneWithRepuestos()
  {
    $orden = $this->Mordenes->getOne($_POST);
    $repuestos = $this->Mrepuestos_ti->get($_POST);
    $respuesta = array(
      "orden" => $orden,
      "repuestos" => $repuestos
    );
    echo json_encode($respuesta);
  }
  public function getActive()
  {
    $fecha = explode(" - ", $_POST["rango_fechas"]);
    if (isset($fecha[1])) {
      unset($_POST["rango_fechas"]);
      $_POST["inicial"] = $fecha[0];
      $_POST["final"] = $fecha[1];
    } else {
      $_POST["inicial"] = date("Y-m-d");
      $_POST["final"] = date("Y-m-d");
    }
    echo json_encode($this->Mordenes->getActive());
  }
  public function getAsignadas()
  {
    $fecha = explode(" - ", $_POST["rango_fechas"]);
    if (isset($fecha[1])) {
      unset($_POST["rango_fechas"]);
      $_POST["inicial"] = $fecha[0];
      $_POST["final"] = $fecha[1];
    } else {
      $_POST["inicial"] = date("Y-m-d");
      $_POST["final"] = date("Y-m-d");
    }
    $id_empresa = $this->Musuarios->getOne($_POST["user_id"])->id_empresa;
    echo json_encode($this->Mordenes->getAsignadas($id_empresa));
  }
  public function getClosed()
  {

    echo json_encode($this->Mordenes->getClosed());
  }
  public function getLikeSerie()
  {
    $equipos = $this->Mequipos->getLikeSerie($_POST);
    echo json_encode($equipos);
  }
  public function getLikeCodigo()
  {
    $equipos = $this->Mequipos->getLikeCodigo($_POST);
    echo json_encode($equipos);
  }
  public function getRepuestos()
  {
    echo json_encode($this->Mrepuestos_ti->get($_POST));
  }
  public function add()
  {
    $this->session->set_userdata("empresa_id", $_POST["empresa_id"]);
    unset($_POST["empresa_id"]);
    $_POST["reportante_id"] = $this->session->userdata("id"); //Recupero el Id del reportante para guardarlo en la orden creada
    if (isset($_POST["sede_id"])) {
      unset($_POST["sede_id"]);
    }
    $control = array(
      "respuesta" => "",
      "valor" => ""
    );
    $_POST["fecha_inicio"] = date('Y-m-d H:i:s');
    unset($_POST["seleccionado"]);
    unset($_POST["seleccion_reportante"]);
    if (isset($_POST["equipo_id"]) && (($_POST["equipo_id"] == null) || ($_POST["equipo_id"] == ""))) {
      $_POST["equipo_id"] = "";
      $this->form_validation->set_rules('nombre_equipo', "Nombre", "required|min_length[5]|max_length[45]");
      $this->form_validation->set_rules('marca_equipo', "Marca", "required|min_length[4]");
    }
    $this->form_validation->set_rules('descripcion', "Descripcion", "required|min_length[30]");
    $this->form_validation->set_rules('asunto', "Asunto", "required|min_length[10]");
    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_correctivos_generales/"; //Ruta
      $config['allowed_types'] = '*';
      $config['max_size']  = 2000000;
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadImagen');
      $this->uploadImagen->initialize($config);
      $this->uploadImagen->do_upload("image"); //Esto sube la imagen en la carpeta
      $data = "";
      $data = $this->uploadImagen->data();
      $_POST["image"] = $data["file_name"];
      $id_ultima_orden = $this->Mordenes->add($_POST);
      $ultimo_ticket_generado = $this->Mordenes->getOne(array("id" => $id_ultima_orden));
      $descripcion_historial = "Se crea Ticket con ID = " . $ultimo_ticket_generado->id;
      $vector_cambios_hdv = array(
        "descripcion" => $descripcion_historial,
        "usuario_id" => $this->session->userdata("id"),
        "equipo_id" => $ultimo_ticket_generado->equipo_id
      );
      $this->Mcambios_hdv->add($vector_cambios_hdv);
      $control["respuesta"] = 1;
      $control["valor"] = $id_ultima_orden;
      echo json_encode($control);
    } else {
      $control["respuesta"] = 0;
      $control["valor"] = validation_errors();
      echo json_encode($control);
    }
  }
  public function update_general()
  {
    $this->Mordenes->update($_POST);
  }
  public function email_add_orden()
  {
    $num = $this->session->userdata("empresa_id");
    $empresa = $this->Mordenes->getOneEmpresa($num);
    $datos_usuarios = $this->Mordenes->getUsuarioEmpresa($num);
    $count_usuarios = $this->Mordenes->getCount($num);

    $orden = $this->Mordenes->getOne($_POST);
    $vector_orden = array(
      "empresa" => $empresa,
      "orden" => $orden
    );
    if ($orden->equipo_id != 0) {
      $vector = array("id" => $orden->equipo_id);
      $equipo = $this->Mequipos->getOne($vector);
      $vector_orden["equipo"] = $equipo;
    }
    $send = "";
    for ($i = 0; $i <= ($count_usuarios - 1); $i++) :
      if ($i == 0) {
        $send .= "" . $datos_usuarios[$i]->email_empresa . ",";
      } elseif ($i < ($count_usuarios - 1)) {
        $send .= " " . $datos_usuarios[$i]->email_empresa . ",";
      } elseif ($i == ($count_usuarios - 1)) {
        $send .= " " . $datos_usuarios[$i]->email_empresa . "";
      }
    endfor;
    $configGmail = array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_port' => 465,
      'smtp_user' => 'evagestionahuv@gmail.com',
      'smtp_pass' => 'ronrokgffjiurzio',
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n"
    );
    $this->email->initialize($configGmail);
    $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
    $this->email->to($send);
    $this->email->cc($orden->email);
    $this->email->subject('Creación de Ticket Nro ' . $_POST["id"]);
    if ($orden->image != "" && $orden->image != null) {
      $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->image, 'inline');
    }
    $this->email->attach(base_url() . "assets/template/3.jpg", 'inline');
    $msj = $this->load->view("ordenes/email_creacion", $vector_orden, TRUE);

    $this->email->message($msj);
    $this->email->send();
  }
  public function update_diagnose_orden()
  {
    $orden_id = $_POST["id"];
    $this->form_validation->set_rules('diagnostico', "Diagnostico", "required|min_length[12]");
    $this->form_validation->set_rules('retro_diagnostico', "Retro diagnostico", "required|min_length[4]");
    if ($this->form_validation->run()) {
      if (isset($_POST["repuestos"])) {
        $vector_repuestos = $_POST["repuestos"];
        foreach ($vector_repuestos as $repuesto) {
          if (!empty($repuesto)) {
            $vector_ingreso = array(
              "name" => $repuesto,
              "orden_id" => $_POST["id"]
            );
            $this->Mrepuestos_ti->add($vector_ingreso);
            $vector_ingreso = "";
          }
        }
        unset($_POST["repuestos"]);
      }
      if (!empty($_FILES["file_diagnostico"]["name"])) {
        $config['upload_path'] = "./assets/upload_correctivos_generales/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config, 'uploadDiagnostico');
        $this->uploadDiagnostico->initialize($config);
        $this->uploadDiagnostico->do_upload("file_diagnostico"); //Esto sube el archivo en la carpeta
        $data = "";
        $data = $this->uploadDiagnostico->data();
        $_POST["file_diagnostico"] = $data["file_name"];
      }
      if (isset($_POST["fecha_diagnostico"])) { // Significa que el diagnostico lo ingresa un administrador
        if (isset($_POST["hora_diagnostico"])) {
          $_POST["fecha_diagnostico"] = $_POST["fecha_diagnostico"] . " " . $_POST["hora_diagnostico"];
          unset($_POST["hora_diagnostico"]);
        }
      } else {
        $_POST["fecha_diagnostico"] = date("Y-m-d h:i:s");  // Fecha actual
      }
      $_POST["tecnico_diagnostico"] = $this->session->userdata("id"); // Usuario que ingresa el diagnostico
      $_POST["estado_id"] = 3;
      $this->Mordenes->update($_POST);
      $vector_respuesta = array(
        "caso" => 1,
        "contenido" => $orden_id
      );
      echo json_encode($vector_respuesta);
    } else {
      $vector_respuesta = array(
        "caso" => 2,
        "contenido" => validation_errors()
      );
      echo json_encode($vector_respuesta);
    }
  }
  public function update_diagnose_orden_email()
  {
    $orden = $this->Mordenes->getOne(array("id" => $_POST["id"]));
    $empresa_id = $orden->empresa_id;
    $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
    $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id));
    $reportante = $this->Musuarios->getOne($orden->reportante_id);
    $asignado = $this->Musuarios->getOne($orden->asignado_id);
    $usuario_actual = $this->Musuarios->getOne($this->session->userdata("id"));
    $repuestos = $this->Mrepuestos_ti->get(array("id" => $orden->id));
    $vector = array(
      "orden" => $orden,
      "empresa" => $empresa,
      "correos_empresa" => $correos_empresa,
      "reportante" => $reportante,
      "asignado" => $asignado,
      "usuario_actual" => $usuario_actual,
      "repuestos" => $repuestos
    );
    if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
      $vector["equipo"] = $this->Mequipos->getOne(array("id" => $orden->equipo_id));
    }
    $to = "";
    $contador = 0;
    $limite = $correos_empresa["cantidad"];
    $control = TRUE;
    if ($limite == 1) {
      $to .= $correos_empresa["correos_empresa"][0]->email;
    } elseif ($limite > 1) {
      foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
        $contador = $contador + 1;
        if ($contador != $limite) {
          $to .= $correo_empresa->email . ",";
        } else {
          $to .= $correo_empresa->email;
        }
      }
    } else {
      $control = !$control;
    }
    if ($control) {

      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'evagestionahuv@gmail.com',
        'smtp_pass' => 'ronrokgffjiurzio',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );
      $this->email->initialize($configGmail);
      $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
      $this->email->to($to);
      $this->email->cc($reportante->email);
      $this->email->subject('Diagnostico Ticket Nro. ' . $_POST["id"]);
      if ($orden->file_diagnostico != NULL && $orden->file_diagnostico != "") {
        $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_diagnostico, 'inline');
      }
      $msj = $this->load->view("ordenes/diagnostico_email", $vector, TRUE);

      $this->email->message($msj);
      $this->email->send();
    }
  }
  public function update_archivo_diagnose_orden()
  {

    $orden_id = $_POST["id"];
    if (!empty($_FILES["file_diagnostico"]["name"])) { // Verificación de si se envio archivo
      $config['upload_path'] = "./assets/upload_correctivos_generales/";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadDiagnostico');
      $this->uploadDiagnostico->initialize($config);
      $this->uploadDiagnostico->do_upload("file_diagnostico"); //Esto sube el archivo en la carpeta
      $data = "";
      $data = $this->uploadDiagnostico->data();
      $_POST["file_diagnostico"] = $data["file_name"];
    }
    $this->Mordenes->update($_POST);
    echo json_encode(array("orden_id" => $orden_id));
  }
  public function update_solicitar_cierre_orden()
  {
    $orden_id = $_POST["id"];
    $this->form_validation->set_rules('reparacion', "Información de cierre", "required|min_length[12]");
    $this->form_validation->set_rules('retro_cierre', "Retro diagnostico", "required|min_length[4]");
    if ($this->form_validation->run()) {
      if (!empty($_FILES["file_cierre"]["name"])) { // Verificación de si se envio archivo
        $config['upload_path'] = "./assets/upload_correctivos_generales/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config, 'uploadCierre');
        $this->uploadCierre->initialize($config);
        $this->uploadCierre->do_upload("file_cierre"); //Esto sube el archivo en la carpeta
        $data = "";
        $data = $this->uploadCierre->data();
        $_POST["file_cierre"] = $data["file_name"];
      }
      if (isset($_POST["fecha_asignacion_cierre"])) { // Significa que el diagnostico lo ingresa un administrador
        if (isset($_POST["hora_solicitud_cierre"])) {
          $_POST["fecha_asignacion_cierre"] = $_POST["fecha_asignacion_cierre"] . " " . $_POST["hora_solicitud_cierre"];
          unset($_POST["hora_solicitud_cierre"]);
        }
      } else {
        $_POST["fecha_asignacion_cierre"] = date("Y-m-d h:i:s");
      }
      $_POST["tecnico_cierre"] = $this->session->userdata("id"); // Usuario que ingresa el diagnostico
      $_POST["estado_id"] = 5;
      $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $code = substr(str_shuffle($set), 0, 12);
      $_POST['code'] = $code;
      $_POST['cierre_active'] = "false";
      $this->Mordenes->update($_POST);
      $vector_respuesta = array(
        "caso" => 1,
        "contenido" => $orden_id
      );
      echo json_encode($vector_respuesta);
    } else {
      $vector_respuesta = array(
        "caso" => 2,
        "contenido" => validation_errors()
      );
      echo json_encode($vector_respuesta);
    }
  }
  public function update_solicitar_cierre_orden_email()
  {
    $orden = $this->Mordenes->getOne(array("id" => $_POST["id"]));
    $empresa_id = $orden->empresa_id;
    $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
    $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id));
    $reportante = $this->Musuarios->getOne($orden->reportante_id);
    $asignado = $this->Musuarios->getOne($orden->asignado_id);
    $usuario_diagnostico = $this->Musuarios->getOne($orden->tecnico_diagnostico);
    $usuario_actual = $this->Musuarios->getOne($this->session->userdata("id"));
    $vector = array(
      "orden" => $orden,
      "empresa" => $empresa,
      "correos_empresa" => $correos_empresa,
      "reportante" => $reportante,
      "usuario_diagnostico" => $usuario_diagnostico,
      "asignado" => $asignado,
      "usuario_actual" => $usuario_actual
    );
    if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
      $vector["equipo"] = $this->Mequipos->getOne(array("id" => $orden->equipo_id));
    }

    $to = "";
    $contador = 0;
    $limite = $correos_empresa["cantidad"];
    $control = TRUE;
    if ($limite == 1) {
      $to .= $correos_empresa["correos_empresa"][0]->email;
    } elseif ($limite > 1) {
      foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
        $contador = $contador + 1;
        if ($contador != $limite) {
          $to .= $correo_empresa->email . ",";
        } else {
          $to .= $correo_empresa->email;
        }
      }
    } else {
      $control = !$control;
    }
    if ($control) {
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'evagestionahuv@gmail.com',
        'smtp_pass' => 'ronrokgffjiurzio',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );
      $this->email->initialize($configGmail);
      $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
      $this->email->to($to);
      $this->email->cc($reportante->email);
      /*Copia a:

			- Reportante
			- Dueños de la zona

			*/
      $this->email->subject('Trabajo realizado Ticket Nro. ' . $_POST["id"]);

      if ($orden->file_diagnostico != NULL && $orden->file_diagnostico != "") {
        $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_diagnostico, 'inline');
      }
      if ($orden->file_cierre != NULL && $orden->file_cierre != "") {
        $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_cierre, 'inline');
      }
      $msj = $this->load->view("ordenes/solicitud_cierre_email", $vector, TRUE);

      $this->email->message($msj);
      $this->email->send();
    }
  }
  public function update_archivo_solicitar_cierre_orden()
  {

    $orden_id = $_POST["id"];

    if (!empty($_FILES["file_cierre"]["name"])) { // Verificación de si se envio archivo
      $config['upload_path'] = "./assets/upload_correctivos_generales/";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadCierre');
      $this->uploadCierre->initialize($config);
      $this->uploadCierre->do_upload("file_cierre"); //Esto sube el archivo en la carpeta
      $data = "";
      $data = $this->uploadCierre->data();
      $_POST["file_cierre"] = $data["file_name"];
    }


    $this->Mordenes->update($_POST);

    echo json_encode(array("orden_id" => $orden_id));
  }
  public function update()
  {
    $orden = $this->Mordenes->getOne($_POST);
    if ($orden->tecnico_diagnostico != null) {
      $informacion_tecnico = $this->Musuarios->getOne($_POST["tecnico_diagnostico"]);
      unset($_POST["tecnico_diagnostico"]);
    }
    if (isset($_POST["diagnostico"])) {
      if (isset($_POST["hora_diagnostico"])) {
        $_POST["fecha_diagnostico"] = $_POST["fecha_diagnostico"] . " " . $_POST["hora_diagnostico"];
        unset($_POST["hora_diagnostico"]);
      } else {

        $_POST["fecha_diagnostico"] = date("Y-m-d h:i:s");
      }

      if (isset($_POST["repuestos"])) {
        $vector_repuestos = $_POST["repuestos"];
        foreach ($vector_repuestos as $repuesto) {
          if (!empty($repuesto)) {
            $vector_ingreso = array(
              "name" => $repuesto,
              "fecha_solicitud_repuesto" => $_POST["fecha_solicitud_repuesto"],
              "orden_id" => $_POST["id"]
            );
            $this->Mrepuestos_ti->add($vector_ingreso);
            $vector_ingreso = "";
          }
        }
        unset($_POST["repuestos"]);
      }
      $_POST["estado_id"] = 3;
      $config['upload_path'] = "./assets/upload_correctivos_generales/";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadDiagnostico');
      $this->uploadDiagnostico->initialize($config);
      $this->uploadDiagnostico->do_upload("file_diagnostico");
      $data = "";
      $data = $this->uploadDiagnostico->data();
      $_POST["file_diagnostico"] = $data["file_name"];
      $this->form_validation->set_rules('diagnostico', "Diagnostico", "required|min_length[12]");
    }
    if (isset($_POST["reparacion"])) {
      if (isset($_POST["hora_fin"])) {
        $_POST["fecha_asignacion_cierre"] = $_POST["fecha_asignacion_cierre"] . " " . $_POST["hora_fin"];
        unset($_POST["hora_fin"]);
      } else {
        $_POST["fecha_asignacion_cierre"] = date("Y-m-d h:i:s");
      }
      if (isset($_POST["repuesto_usado"])) {
        for ($i = 0; $i < sizeof(($_POST["repuesto_usado"])); $i++) {
          $vector_repuestos_recibidos = array(
            "id" => $_POST["id_repuesto"][$i],
            "used" => $_POST["repuesto_usado"][$i],
            "fecha_recepcion" => $_POST["fecha_recepcion_repuesto"][$i]
          );
          $this->Mrepuestos_ti->update($vector_repuestos_recibidos);
        }
        unset($_POST["repuesto_usado"]);
        unset($_POST["fecha_recepcion_repuesto"]);
        unset($_POST["id_repuesto"]);
      }
      $_POST["fecha_asignacion_cierre"] = date("Y-m-d h:i:s");
      $_POST["estado_id"] = 5; //esto se hace para mandar aviso de cerrar la orden 
      $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $code = substr(str_shuffle($set), 0, 12);
      $param['code'] = $code;
      $param['cierre_active'] = "false";
      $id["id"] = $orden->id;
      $param['tecnico_cierre'] = $this->session->userdata('id');
      $this->Mordenes->activate($param, $id);
      $config['upload_path'] = "./assets/upload_correctivos_generales/";
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config, 'uploadCierre');
      $this->uploadCierre->initialize($config);
      $this->uploadCierre->do_upload("file_cierre"); //Esto sube el archivo en la carpeta
      $data = "";
      $data = $this->uploadCierre->data();
      $_POST["file_cierre"] = $data["file_name"];
      $this->form_validation->set_rules('reparacion', "Información de cierre", "required|min_length[12]");
    } else {
      $informacion_tecnico = $this->Musuarios->getOne($_POST["tecnico_cierre"]);
    }
    /* Validaciones */
    if ($this->form_validation->run()) { // Si se cumple con todas las validaciones se procede a actualizar y a enviar el correo
      if (isset($_POST["id"])) {
        if ($this->Mordenes->update($_POST)) {
          $msj = "";
          $configGmail = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'evagestionahuv@gmail.com',
            'smtp_pass' => 'ronrokgffjiurzio',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
          );
          $this->email->initialize($configGmail);
          if (isset($_POST["reparacion"])) {
            $orden = $this->Mordenes->getOne($_POST); // Llamada a orden que sera editada
            $empresa = $this->Mempresas->getOne(array("id" => $orden->empresa_id)); //lama la info de la empresa asignada
            $usuario = $informacion_tecnico;
            $usuario_diagnostico = $this->Musuarios->getOne($orden->tecnico_diagnostico);
            $vector = array("orden" => $orden, "empresa" => $empresa, "usuario" => $usuario, "usuario_diagnostico" => $usuario_diagnostico);
            $id["id"] = $orden->id;
            $param['tecnico_cierre'] = $this->session->userdata('id');
            $this->Mordenes->activate($param, $id);
            $num = 1;
            $count_usuarios = $this->Mordenes->getCount($num);
            $datos_usuarios = $this->Mordenes->getUsuarioEmpresa($num);
            $send = "";
            for ($i = 0; $i <= ($count_usuarios - 1); $i++) :
              if ($i == 0) {
                $send .= "" . $datos_usuarios[$i]->email_empresa . ",";
              } elseif ($i < ($count_usuarios - 1)) {
                $send .= " " . $datos_usuarios[$i]->email_empresa . ",";
              } elseif ($i == ($count_usuarios - 1)) {
                $send .= " " . $datos_usuarios[$i]->email_empresa . "";
              }
            endfor;
            $this->email->clear();
            $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
            $this->email->to(
              array($orden->email) // Se envia al reportante y al que cierra la orden
            );
            $this->email->cc($send);
            $this->email->subject('El ticket Nro ' . $orden->id . ' esta esperando confirmacion de cierre');
            if ($orden->file_cierre != null && $orden->file_cierre != "") {
              $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_cierre, 'inline');
            }
            $msj = $this->load->view("ordenes/cierre_email", $vector, true);

            $this->email->message($msj);

            if ($this->email->send()) {
              // echo "Enviado by Electromedicina HUV";
            } else {
              show_error($this->email->print_debugger());
            }
          } elseif (isset($_POST["diagnostico"])) {
            $orden = $this->Mordenes->getOne($_POST); // Llamada a orden que sera editada
            $empresa = $this->Mempresas->getOne(array("id" => $orden->empresa_id)); //lama la info de la empresa asignada
            $usuario = $informacion_tecnico;
            $vector = array("orden" => $orden, "empresa" => $empresa, "usuario" => $usuario);
            $id["id"] = $orden->id;
            $param['tecnico_diagnostico'] = $this->session->userdata('id');
            $this->Mordenes->activate($param, $id);
            $num = 1;
            $count_usuarios = $this->Mordenes->getCount($num);
            $datos_usuarios = $this->Mordenes->getUsuarioEmpresa($num);
            $send = "";

            for ($i = 0; $i <= ($count_usuarios - 1); $i++) :
              if ($i == 0) {
                $send .= "" . $datos_usuarios[$i]->email_empresa . ",";
              } elseif ($i < ($count_usuarios - 1)) {
                $send .= " " . $datos_usuarios[$i]->email_empresa . ",";
              } elseif ($i == ($count_usuarios - 1)) {
                $send .= " " . $datos_usuarios[$i]->email_empresa . "";
              }
            endfor;
            $this->email->clear();
            $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
            $this->email->to(
              array($orden->email, $informacion_tecnico->email) // Se envia al reportante y al que diagnostica
            );
            $this->email->cc($send);
            $this->email->subject('El ticket Nro ' . $orden->id . ' ha pasado a estado diagnosticado');
            if ($orden->file_diagnostico != null && $orden->file_diagnostico != "") {
              $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_diagnostico, 'inline');
            }
            $msj = $this->load->view("ordenes/diagnostico_email", $vector, true);
            $this->email->message($msj);
            if ($this->email->send()) {
              // echo "Enviado by Electromedicina HUV";
            } else {
              show_error($this->email->print_debugger());
            }
          }
          echo 1;
        } else { // Si por alguna razon no se actualiza la orden en la base de datos se borra el archivo subido
          if (isset($_POST["file_diagnostico"])) {
            $this->load->helper("file");
            unlink("./assets/upload_correctivos_generales/" . $_POST["file_diagnostico"]);
          }
          if (isset($_POST["file_cierre"])) {
            $this->load->helper("file");
            unlink("./assets/upload_correctivos_generales/" . $_POST["file_cierre"]);
          }
        }
      }
    } else {
      echo json_encode(validation_errors());
    }
  }
  public function activate()
  {
    $id["id"] =  $this->uri->segment(4);
    $code = $this->uri->segment(5);
    $orden = $this->Mordenes->getallordenes($id);
    if ($orden->code == $code) {
      $orden = "";
      $data['cierre_active'] = "true";
      $data['fecha_fin'] = date('Y-m-d h:i:s');
      $data["estado_id"] = 4;
      $info = $this->Mordenes->getallordenes($id);
      $query = $this->Mordenes->activate($data, $id);
      $orden = $this->Mordenes->getOne($id);
      $empresa_id = $orden->empresa_id;
      $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
      $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id));
      $reportante = $this->Musuarios->getOne($orden->reportante_id);
      $asignado = $this->Musuarios->getOne($orden->asignado_id);
      $usuario_actual = $this->Musuarios->getOne($this->session->userdata("id"));
      $vector = array(
        "orden" => $orden,
        "empresa" => $empresa,
        "correos_empresa" => $correos_empresa,
        "reportante" => $reportante,
        "asignado" => $asignado,
        "usuario_actual" => $usuario_actual
      );
      if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
        $vector["equipo"] = $this->Mequipos->getOne(array("id" => $orden->equipo_id));
      }
      if ($query) {
        $this->session->set_tempdata('message', 'Orden cerrada', 40);
        $to = "";
        $contador = 0;
        $limite = $correos_empresa["cantidad"];
        $control = TRUE;
        if ($limite == 1) { // un solo correo
          $to .= $correos_empresa["correos_empresa"][0]->email;
        } elseif ($limite > 1) {
          foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
            $contador = $contador + 1;
            if ($contador != $limite) {
              $to .= $correo_empresa->email . ",";
            } else {
              $to .= $correo_empresa->email;
            }
          }
        } else {
          $control = !$control;
        }
        if ($control) {
          $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'evagestionahuv@gmail.com',
            'smtp_pass' => 'ronrokgffjiurzio',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
          );
          $this->email->initialize($configGmail);
          $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
          $this->email->to($to);
          $this->email->cc($reportante->email);
          $this->email->subject('Cierre Ticket Nro. ' . $this->uri->segment(4));
          if ($orden->file_diagnostico != NULL && $orden->file_diagnostico != "") {
            $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_diagnostico, 'inline');
          }
          if ($orden->file_cierre != NULL && $orden->file_cierre != "") {
            $this->email->attach(base_url() . "assets/upload_correctivos_generales/" . $orden->file_cierre, 'inline');
          }
          $msj = $this->load->view("ordenes/cierre_totalemail", $vector, TRUE);
          $this->email->message($msj);
          $this->email->send();
          redirect('orden/Cordenes/list_closed');
        }
      } else {
        $this->session->set_tempdata('message', 'Algo fue mal en el cierre de la orden', 40);
      }
    } else {
      $this->session->set_tempdata('message', 'No se puede cerrar la orden', 40);
    }
  }
  //TODO
  public function asignar_empresa()
  {
    if (isset($_POST)) {
      $orden_id = $_POST["id"];
      $_POST["asignador_id"] = $this->session->userdata("id");
      $_POST["fecha_asignacion"] = date('Y-m-d H:i:s');
      $this->Mordenes->asignar_empresa($_POST);
      $this->Mordenes->addEstado(array("id" => $orden_id, "estado_id" => 2));
      echo json_encode(array("orden_id" => $orden_id));
    }
  }
  public function asignar_trabajo()
  {
    if (isset($_POST)) {
      $orden_id = $_POST["id"];
      $_POST["asignador_id"] = $this->session->userdata("id");
      $_POST["fecha_asignacion"] = date('Y-m-d H:i:s');
      $this->Mordenes->asignar_empresa($_POST);
      $this->Mordenes->addEstado(array("id" => $orden_id, "estado_id" => 2));
      echo json_encode(array("orden_id" => $orden_id));
    }
  }
  public function revisar_orden()
  {
    if (($_POST["id"]) != null && ($_POST["id"]) != "") {
      $datos = $this->Mordenes->getallordenes($_POST);
      if ($datos->asignado_id != null && $datos->asignado_id != "") {
        $control["respuesta"] = 1;
        $control["asignado_id"] = $datos->asignado_id;
        echo json_encode($control);
      } else {
        $control["respuesta"] = 2;
        echo json_encode($control);
      }
    }
  }
  public function asignar_usuario()
  {

    if (($_POST["asignado_id"]) != null && ($_POST["asignado_id"]) != "") { // id del usuario que llega para asignar

      $_POST["fecha_asignacion_usuario"] = date('Y-m-d h:i:s');
      $usuario = $this->Musuarios->getOne($_POST["asignado_id"]);
      $asignar = $this->Mordenes->update($_POST);
      if ($asignar) {
        $control["respuesta"] = 1;
        echo json_encode($control);
      } else {
        $control["respuesta"] = 0;
        $control["valor"] = validation_errors();
        echo json_encode($control);
      }
    }
  }
  public function email_asignar_usuario()
  {


    $orden = $this->Mordenes->getOne(array("id" => $_POST["id"]));
    $empresa_id = $orden->empresa_id;
    $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
    $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id)); // Retorna vector con objeto y cantidad
    $reportante = $this->Musuarios->getOne($orden->reportante_id);
    $asignado = $this->Musuarios->getOne($orden->asignado_id);

    $vector = array(
      "orden" => $orden,
      "empresa" => $empresa,
      "correos_empresa" => $correos_empresa,
      "reportante" => $reportante,
      "asignado" => $asignado
    );
    if ($orden->equipo_id != null && $orden->equipo_id != "" && $orden->equipo_id != 0) {
      $vector["equipo"] = $this->Mequipos->getOne(array("id" => $orden->equipo_id));
    }


    $to = "";
    $contador = 0;
    $limite = $correos_empresa["cantidad"];
    $control = TRUE;


    if ($limite == 1) { // un solo correo
      $to .= $correos_empresa["correos_empresa"][0]->email;
    } elseif ($limite > 1) {
      foreach ($correos_empresa["correos_empresa"] as $correo_empresa) {
        $contador = $contador + 1;
        if ($contador != $limite) {
          $to .= $correo_empresa->email . ",";
        } else {
          $to .= $correo_empresa->email;
        }
      }
    } else {
      $control = !$control;
    }
    if ($control) {

      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'evagestionahuv@gmail.com',
        'smtp_pass' => 'ronrokgffjiurzio',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );

      $this->email->initialize($configGmail);
      $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
      $this->email->to($to);
      /*Se le informa a todos los de la empresa asignada que una cuenta en especifico selecciono la orden*/
      $this->email->cc($reportante->email);
      /*Copia a:

			- Reportante
			- Dueños de la zona	

			*/
      $this->email->subject('Asignacion de tecnico exitosa Ticket Nro ' . $_POST["id"]);

      $msj = $this->load->view("ordenes/email_asignacion_usuario", $vector, TRUE);

      $this->email->message($msj);
      $this->email->send();
    }
  }
  public function timeline()
  {

    $this->session->set_userdata("orden_id", $_POST["id"]);

    $orden = $this->Mordenes->getOne($_POST);



    $repuestos = $this->Mrepuestos_ti->get($_POST);
    $avances = $this->Mavances_correctivos->GetByOrden(array("orden_id" => $orden->id));
    $vector = array(
      "orden" => $orden,
      "repuestos" => $repuestos,
      "avances" => $avances
    );

    $this->load->view("ordenes/timeline_detail", $vector);
  }
  public function cerrar_orden()
  {
    $sinusar = $_POST["id"];
    $id = $this->session->userdata("id");
    $usu = $this->Musuarios->getOne($id);
    $num = $usu->id_empresa;
    echo json_encode($num);
  }
  public function show()
  {

    $orden = $this->Mordenes->getOne($_POST);
    $repuestos_relacionados = $this->Mrepuestos_ti->get($_POST);
    $param = array(
      'orden' => $orden,
      'repuestos_relacionados' => $repuestos_relacionados
    );
    $this->load->view("ordenes/detail", $param);
  }
  public function getProcesos()
  {

    echo json_encode($this->Mordenes->getProcesos());
  }
  public function getSubprocesos()
  {
    echo json_encode($this->Mordenes->getSubprocesos($_POST['proceso_id']));
  }
  public function getUsuarios()
  {
    echo json_encode($this->Mordenes->getUsuarios());
  }
  public function getDiagnosticos()
  {
    echo json_encode($this->Mdiagnosticos->get());
  }
  public function getCierres()
  {
    echo json_encode($this->Mcierres->get());
  }
  public function update_fecha_solicitud()
  {
    $this->Mordenes->update_fecha_solicitud($_POST);
  }
  public function update_fecha_recepcion()
  {
    $this->Mordenes->update_fecha_recepcion($_POST);
  }
  public function add_retro()
  {
    $id = $_POST["id"];
    $config['upload_path'] = "./assets/upload_correctivos_generales";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadRetro');
    $this->uploadRetro->initialize($config);
    $this->uploadRetro->do_upload("file_cierre"); //Esto sube el archivo en la carpeta
    $data = "";
    $data = $this->uploadRetro->data();
    $_POST["file_cierre"] = $data["file_name"];
    $this->Mordenes->update($_POST);
    echo "#" . $id . "id";
  }
  public function update_from_modal_diagnostico()
  {
    $_POST["id"] = $this->session->userdata("orden_id");
    $orden_id = $_POST["id"];
    $_POST["tecnico_diagnostico"] = $this->session->userdata("id");
    if (isset($_POST["fecha_diagnostico"]) && $_POST["fecha_diagnostico"] != "") {
      $_POST["fecha_diagnostico"] = $_POST["fecha_diagnostico"] . " " . $_POST["hora_diagnostico"];
      unset($_POST["hora_diagnostico"]);
    } else {
      $_POST["fecha_diagnostico"] = date('Y-m-d H:i:s');
      if (isset($_POST["hora_diagnostico"])) {
        unset($_POST["hora_diagnostico"]);
      }
    }
    $_POST["estado_id"] = 3;
    $orden = $this->Mordenes->getOne($_POST);
    $file_anterior = $orden->file_diagnostico;
    $config['upload_path'] = "./assets/upload_correctivos_generales";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadDiagnostico');
    $this->uploadDiagnostico->initialize($config);
    if (!empty($_FILES["file_diagnostico"]["name"])) {
      $this->uploadDiagnostico->do_upload("file_diagnostico"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadDiagnostico->data();
      $_POST["file_diagnostico"] = $data["file_name"];
    }
    if ($this->Mordenes->update($_POST)) {
      if (isset($_POST["file_diagnostico"])) {
        if (($_POST["file_diagnostico"] != $file_anterior) && $file_anterior != "" && $file_anterior != NULL && $file_anterior != null) {
          $this->load->helper("file");
          unlink("./assets/upload_correctivos_generales/" . $file_anterior);
        }
      }
    } else {
      if (isset($_POST["file_diagnostico"])) {
        $this->load->helper("file");
        unlink("./assets/upload_correctivos_generales/" . $_POST["file_diagnostico"]);
      }
    }
    echo json_encode($orden_id);
  }
  public function update_from_modal_solicitud_cierre()
  {
    $_POST["id"] = $this->session->userdata("orden_id");
    $orden_id = $_POST["id"];
    $_POST["tecnico_cierre"] = $this->session->userdata("id");
    if (isset($_POST["fecha_asignacion_cierre"]) && $_POST["fecha_asignacion_cierre"] != "") {
      $_POST["fecha_asignacion_cierre"] = $_POST["fecha_asignacion_cierre"] . " " . $_POST["hora_asignacion_cierre"];
      unset($_POST["hora_asignacion_cierre"]);
    } else {
      $_POST["fecha_asignacion_cierre"] = date('Y-m-d H:i:s');
      if (isset($_POST["hora_asignacion_cierre"])) {
        unset($_POST["hora_asignacion_cierre"]);
      }
    }
    $_POST["estado_id"] = 5;
    $_POST["cierre_id"] = 15;
    $orden = $this->Mordenes->getOne($_POST);
    $file_anterior = $orden->file_cierre;
    $config['upload_path'] = "./assets/upload_correctivos_generales";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadCierre');
    $this->uploadCierre->initialize($config);
    if (!empty($_FILES["file_cierre"]["name"])) {
      $this->uploadCierre->do_upload("file_cierre"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadCierre->data();
      $_POST["file_cierre"] = $data["file_name"];
    }
    if ($this->Mordenes->update($_POST)) {
      if (isset($_POST["file_cierre"])) {
        if (($_POST["file_cierre"] != $file_anterior) && $file_anterior != "" && $file_anterior != NULL && $file_anterior != null) {
          $this->load->helper("file");
          unlink("./assets/upload_correctivos_generales/" . $file_anterior);
        }
      }
    } else {
      if (isset($_POST["file_cierre"])) {
        $this->load->helper("file");
        unlink("./assets/upload_correctivos_generales/" . $_POST["file_cierre"]);
      }
    }
    echo json_encode($orden_id);
  }
  public function archivar_orden()
  {
    $_POST["estado_id"] = 4;
    $_POST["usuario_final_id"] = $this->session->userdata("id");
    $_POST["fecha_fin"] = date('Y-m-d H:i:s');

    $this->Mordenes->update($_POST);
  }
  public function enviar_correo()
  {
    $orden = $this->Mordenes->getOne(array("id" => $_POST["orden_id"]));
    $avances = $this->Mavances_correctivos->GetByOrden(array("orden_id" => $orden->id));
    $vector = array(
      "orden" => $orden,
      "avances" => $avances
    );
    $configGmail = array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_port' => 465,
      'smtp_user' => 'evagestionahuv@gmail.com',
      'smtp_pass' => 'ronrokgffjiurzio',
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n"
    );
    $this->email->initialize($configGmail);
    $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
    $this->email->to('jsebastiangb.12@gmail.com');
    $this->email->subject('Diagnostico Ticket Nro.');
    $msj = $this->load->view("ordenes/timeline_detail", $vector, TRUE);
    $this->email->message($msj);
    $this->email->send();
  }
  public function update_from_modal_repuesto_pendiente()
  {
    $_POST["id"] = $this->session->userdata("orden_id");
    $orden_id = $_POST["id"];
    $orden = $this->Mordenes->getOne(array("id" => $orden_id));
    if ($_POST["repuesto_pendiente"] != "" && $_POST["repuesto_pendiente"] != null && strlen($_POST["repuesto_pendiente"]) >= 2) {
      $this->Mordenes->update($_POST); // Se actualiza la orden
      if ($orden->equipo_id != "" && $orden->equipo_id != null && $orden->equipo_id != 0) { //Actualizar equipo
        $vector_actualizacion_equipo = array( // Array para actualizar el equipo
          "id" => $orden->equipo_id,
          "repuesto_pendiente" => "si"
        );
        $this->Mequipos->update($vector_actualizacion_equipo); // Se actualiza el equipo indicando que tiene un repuesto pendiente
      }
      echo json_encode($orden_id); // Respuesta al js
    } else {
      echo json_encode(-1);
    }
  }
  public function desvincular_repuesto_pendiente()
  {
    $_POST["id"] = $this->session->userdata("orden_id");
    $orden_id = $_POST["id"];
    $_POST["repuesto_pendiente_condicion"] = "no";
    $orden = $this->Mordenes->getOne(array("id" => $orden_id));
    $this->Mordenes->update($_POST); // Se actualiza la orden para no tener repuesto pendiente
    if ($orden->equipo_id != "" && $orden->equipo_id != null && $orden->equipo_id != 0) { //Actualizar equipo
      $equipo_id = $orden->equipo_id;
      $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
      $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
      $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
      $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
      $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
      if ($suma != 0) {
        $this->Mequipos->repuesto_pendiente_true($equipo_id);
      } else {
        $this->Mequipos->repuesto_pendiente_false($equipo_id);
      }
    }
    echo json_encode($orden_id);
  }
}
