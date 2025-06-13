<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Cemail extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library("email");
    $this->load->model("Mequipos");
    $this->load->model("Mobservaciones");
    $this->load->model("Mservicios");
    $this->load->model("Mzonas");
    $this->load->model("Mordenes");
    $this->load->model("Mempresas");
    $this->load->model("Musuarios");
    $this->load->model("Mtrabajos");
    $this->load->model("Mtecnicos");
  }

  public function email_asignar_empresa()
  {
    try {
      $orden = $this->Mordenes->getOne(array("id" => $_POST["orden_id"]));
      print_r($orden);
      $empresa_id = $orden->empresa_id;
      print_r($empresa_id);
      $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
      print_r($empresa);
      $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id));
      print_r($correos_empresa);
      $reportante = $this->Musuarios->getOne($orden->reportante_id);
      print_r($reportantes);
      $vector = array(
        "orden" => $orden,
        "empresa" => $empresa,
        "correos_empresa" => $correos_empresa,
        "reportante" => $reportante
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
        $this->email->subject('Asignacion de orden exitosa. Ticket Nro ' . $orden->id);
        $msj = $this->load->view("ordenes/tikect_email", $vector, TRUE);
        $this->email->message($msj);
        $this->email->send();
      }
    } catch (Exception $e) {
      echo json_encode($e);
    }
  }
  public function email_asignar_trabajo()
  {
    $orden = $this->Mordenes->getOne(array("id" => $_POST["orden_id"]));
    $trabajo = $this->Mtrabajos->getOne(array("id" => $orden->trabajo_id));
    $tecnico = $this->Mtecnicos->getOne(array("id" => $orden->tecnico_id));
    $empresa_id = 4; //Mantenimiento industrial administrativo
    $empresa = $this->Mempresas->getOne(array("id" => $empresa_id));
    $correos_empresa = $this->Mempresas->getEmailUsuariosEmpresa(array("id_empresa" => $empresa_id)); // Retorna vector con objeto y cantidad
    $reportante = $this->Musuarios->getOne($orden->reportante_id);

    $vector = array(
      "orden" => $orden,
      "empresa" => $empresa,
      "trabajo" => $trabajo,
      "tecnico" => $tecnico,
      "correos_empresa" => $correos_empresa,
      "reportante" => $reportante
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
      $this->email->cc($reportante->email);
      $this->email->subject('Asignacion de orden exitosa. Ticket Nro ' . $orden->id);

      $msj = $this->load->view("ordenes/tikect_email", $vector, TRUE);

      $this->email->message($msj);
      $this->email->send();
    }
  }

  public function send_email_observacion()
  {

    $equipo = $this->Mequipos->getOne(array("id" => $_POST["equipo_id"]));
    $observacion = $this->Mobservaciones->getOne(array("id" => $_POST["observacion_id"]));
    $servicio = $this->Mservicios->getOne(array("id" => $equipo->servicio_id));
    $correos = $this->Mzonas->get_emails_with_service(array("servicio_id" => $servicio->id));
    $to = "";
    $contador = 0;
    $limite = $correos["cantidad"];
    $control = TRUE;

    if ($limite == 1) { // un solo correo
      $to .= $correos["correos"][0]->correo_usuario;
    } elseif ($limite > 1) {
      foreach ($correos["correos"] as $correo) {
        $contador = $contador + 1;
        if ($contador != $limite) {
          $to .= $correo->correo_usuario . ",";
        } else {
          $to .= $correo->correo_usuario;
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
      $this->email->from('evagestionahuv@gmail.com', "Repuesto pendiente");
      $this->email->to($to);
      $this->email->subject("Notificación de repuesto pendiente del equipo con Id :" . $equipo->id);
      $vector_correo = array(
        "equipo" => $equipo,
        "observacion" => $observacion,
        "correos" => $correos,
        "servicio" => $servicio
      );
      $msj = $this->load->view("equipos/email/email_add_observacion", $vector_correo, TRUE); //Vista
      $this->email->message($msj);
      $this->email->send();
    }
  }
}
