<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Cpreventivos extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library("email");
    $this->load->model('Mequipos');
    $this->load->model('Mpreventivos');
    $this->load->model('Mcorrectivos_generales');
    $this->load->model('Mservicios');
    $this->load->model('Mzonas');
    $this->load->model('Mobservaciones');
    $this->load->model('Mcambios_hdv');
  }
  public function index()
  {
  }
  public function get()
  {
    echo json_encode($this->Mpreventivos->get($_POST));
  }
  public function getAll()
  {
  }
  public function getOne()
  {
    echo json_encode($this->Mpreventivos->getOne($_POST));
  }
  public function getLast()
  {
    echo json_encode($this->Mpreventivos->getLast($_POST));
  }

  public function add()
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
    if ($_POST["repuesto_id"] != "") {
      $_POST["repuesto_pendiente"] = "si";
      $vector_actualizacion_equipo = array(

        "id" => $_POST["equipo_id"],
        "repuesto_pendiente" => "si"
      );
      $this->Mequipos->update($vector_actualizacion_equipo);
    } else {
      unset($_POST["repuesto_id"]);
    }

    $ultimo_id = $this->Mpreventivos->add($_POST); //Agrego el preventivo
    /*----Se actualiza el historial de la hoja de vida*/
    ////////////////////////////////////////////////////////////////////////////////
    $descripcion_historial = "Se agrega el preventivo con codigo = " . $this->Mpreventivos->getOne(array("id" => $ultimo_id))->description;
    $vector_cambios_hdv = array(
      "descripcion" => $descripcion_historial,
      "usuario_id" => $this->session->userdata("id"),
      "equipo_id" => $_POST["equipo_id"]
    );
    $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
    ////////////////////////////////////////////////////////////////////////////////
    $vector_respuesta = array(
      "preventivo_id" => $ultimo_id,
      "equipo_id" => $_POST["equipo_id"]
    );
    if (isset($vector_actualizacion_equipo)) {
      $vector_respuesta["repuesto_pendiente"] = $_POST["repuesto_id"];
    }
    echo json_encode($vector_respuesta);
  }
  public function send_email_preventivo()
  {

    $equipo = $this->Mequipos->getOne(array("id" => $_POST["equipo_id"]));
    $preventivo = $this->Mpreventivos->getOne(array("id" => $_POST["preventivo_id"]));
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
        'smtp_pass' => '793150eva',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );

      $this->email->initialize($configGmail);
      $this->email->from('evagestionahuv@gmail.com', "Repuesto pendiente");
      $this->email->to($to);
      //$this->email->cc($cc);
      // $this->email->subject('Creación de Ticket Nro '.$_POST["id"]);
      $this->email->subject("Notificación de repuesto pendiente. ID preventivo:" . $preventivo->id);
      /*
			if ($orden->image!=""&&$orden->image!=null) {
				$this->email->attach(base_url()."assets/upload_correctivos_generales/".$orden->image,'inline');	
			}
			*/
      //$this->email->attach(base_url()."assets/template/3.jpg", 'inline');	
      $vector_correo = array(
        "equipo" => $equipo,
        "preventivo" => $preventivo,
        "correos" => $correos,
        "servicio" => $servicio
      );

      $msj = $this->load->view("preventivos/email/email_add_preventivo", $vector_correo, TRUE); //Vista

      $this->email->message($msj);
      $this->email->send();
    }
  }

  public function update()
  {

    if (isset($_POST)) {
      unset($_POST["repuesto_pendiente"]);
      $preventivo_id = $_POST["id"];
      $preventivo = $this->Mpreventivos->getOne($_POST);
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
      unset($_POST["repuesto_pendiente"]);
      if ($this->Mpreventivos->update($_POST)) {


        /*----Se actualiza el historial de la hoja de vida*/
        ////////////////////////////////////////////////////////////////////////////////
        $descripcion_historial = "Se actualiza el preventivo con codigo = " . $preventivo->description;
        $vector_cambios_hdv = array(
          "descripcion" => $descripcion_historial,
          "usuario_id" => $this->session->userdata("id"),
          "equipo_id" => $preventivo->equipo_id
        );
        $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
        ////////////////////////////////////////////////////////////////////////////////


        if (isset($_POST["file"])) {
          if ($_POST["file"] != $file_anterior) {
            $this->load->helper("file");
            unlink("./assets/upload_preventivos/" . $file_anterior);
          }
        }
        // echo json_encode($_POST["equipo_id"]);
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_preventivos/" . $_POST["file"]);
        }
      }
      $cambio = "no";

      if ($_POST["repuesto_id"] != $preventivo->repuesto_id) { // Hubo un cambio en el repuesto pendiente
        $cambio = "si";
      }
      if ($_POST["repuesto_id"] == "" || $_POST["repuesto_id"] == null) {
        $cambio = "no";
      }
      $vector_respuesta = array(
        "equipo_id" => $_POST["equipo_id"],
        "preventivo_id" => $preventivo_id,
        "cambio" => $cambio,
        "actual" => $_POST["repuesto_id"],
        "antiguo" => $preventivo->repuesto_id
      );

      echo json_encode($vector_respuesta);
    }
  }

  public function delete()
  {

    $preventivo = $this->Mpreventivos->getOne(array("id" => $_POST["id"]));

    $file = $preventivo->file;
    if ($this->Mpreventivos->delete($_POST)) {


      ////////////////////////////////////////////////////////////////////////////////
      $descripcion_historial = "Se elimina el preventivo con codigo = " . $preventivo->description;
      $vector_cambios_hdv = array(
        "descripcion" => $descripcion_historial,
        "usuario_id" => $this->session->userdata("id"),
        "equipo_id" => $preventivo->equipo_id
      );
      $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
      ////////////////////////////////////////////////////////////////////////////////

      if ($file != "" && $file != null) {
        $this->load->helper("file");
        unlink("./assets/upload_preventivos/" . $file);
      }
      $equipo_id = $_POST["equipo_id"];
      $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
      $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
      $suma = $cantidad_preventivos + $cantidad_correctivos_generales;
      if ($suma != 0) {
        $this->Mequipos->repuesto_pendiente_true($equipo_id);
      } else {
        $this->Mequipos->repuesto_pendiente_false($equipo_id);
      }
    }
  }

  public function show()
  {
    $vector = array(
      'preventivos' => $this->Mpreventivos->getPreventivos()
    );
    $this->load->view("preventivos/detail", $vector);
  }

  public function ExportarExcel()
  {

    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=PreventivosEB.xls');
    $preventivos = $this->Mpreventivos->getMantenimientosAll();

?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table border="1">
      <thead>
        <tr>
          <th>Fecha de ejecucion</th>
          <th>Codigo preventivo</th>
          <th>Marca</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Nombre</th>
          <th>ID</th>
          <th>Sede</th>
          <th>Servicio</th>
          <th>Area</th>
          <th>ARCHIVO</th>
          <th>Observaciones</th>
          <th>Propiedad</th>
          <th>Estado del equipo</th>
          <th>Proveedor mantenimiento</th>
          <th>Codificación</th>
        </tr>
      </thead>
      <tbody style="text-align: left">
        <?php foreach ($preventivos as $preventivo) : ?>

          <tr>

            <td><?php echo $preventivo->fecha_ejecucion; ?></td>
            <td><?php echo $preventivo->codigo; ?></td>
            <td><?php echo $preventivo->marca; ?></td>
            <td><?php echo $preventivo->code; ?></td>
            <td>SN:&nbsp; <?php echo $preventivo->serial; ?></td>
            <td><?php echo $preventivo->name; ?></td>
            <td><?php echo $preventivo->id; ?></td>
            <td><?php echo $preventivo->sede; ?></td>
            <td><?php echo $preventivo->ubicacion; ?></td>
            <td><?php echo $preventivo->area; ?></td>
            <td><?php echo $preventivo->archivomtto; ?></td>
            <td><?php echo $preventivo->observacion_mtto; ?></td>
            <td><?php echo $preventivo->propiedad; ?></td>
            <td><?php echo $preventivo->estado_equipo; ?></td>
            <td><?php echo $preventivo->proveedor_mantenimiento; ?></td>
            <td><?php echo $preventivo->codificacion; ?></td>
          </tr>
        <?php endforeach ?>

      </tbody>
    </table>

<?php


  }
  public function get_fechas_validas_ejecucion()
  {
    echo json_encode($this->Mpreventivos->get_fechas_validas_ejecucion());
  }
  public function add_nota()
  {
    $_POST["usuario_id"] = $this->session->userdata("id");
    $this->Mobservaciones->add($_POST);
    echo json_encode($_POST["preventivo_id"]);
  }

  public function get_notas_from_preventivo()
  {
    echo json_encode($this->Mobservaciones->get_notas_from_preventivo($_POST));
  }
}
?>