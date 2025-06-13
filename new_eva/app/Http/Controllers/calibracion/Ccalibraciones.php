<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Ccalibraciones extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mcalibraciones');
    $this->load->model('Mcambios_hdv');
  }
  public function index()
  {
  }
  public function get()
  {
    echo json_encode($this->Mcalibraciones->get($_POST));
  }
  public function getAll()
  {
  }
  public function getOne()
  {
    echo json_encode($this->Mcalibraciones->getOne($_POST));
  }
  public function getLast()
  {
    echo json_encode($this->Mpreventivos->getLast($_POST));
  }

  public function add()
  {

    $config['upload_path'] = "./assets/upload_calibraciones";
    $config['allowed_types'] = '*';
    $config['max_size']  = 1000000;
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadCalibracion');
    $this->uploadCalibracion->initialize($config);
    if (!empty($_FILES["file"]["name"])) {
      $this->uploadCalibracion->do_upload("file"); //Esto sube el archivo
      $data = "";
      $data = $this->uploadCalibracion->data();
      $_POST["file"] = $data["file_name"];
    }
    $ultimo_id = $this->Mcalibraciones->add($_POST);
    ////////////////////////////////////////////////////////////////////////////////
    $descripcion_historial = "Se agrega calibracion con codigo = " . $this->Mcalibraciones->getOne(array("id" => $ultimo_id))->description;
    $vector_cambios_hdv = array(
      "descripcion" => $descripcion_historial,
      "usuario_id" => $this->session->userdata("id"),
      "equipo_id" => $_POST["equipo_id"]
    );
    $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
    ////////////////////////////////////////////////////////////////////////////////    
    echo json_encode($_POST["equipo_id"]);
  }
  public function update()
  {

    if (isset($_POST)) {
      # code...
      $calibracion = $this->Mcalibraciones->getOne($_POST);
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
      if ($this->Mcalibraciones->update($_POST)) {

        ////////////////////////////////////////////////////////////////////////////////
        $descripcion_historial = "Se actualiza calibracion con codigo = " . $calibracion->description;
        $vector_cambios_hdv = array(
          "descripcion" => $descripcion_historial,
          "usuario_id" => $this->session->userdata("id"),
          "equipo_id" => $calibracion->equipo_id
        );
        $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
        ////////////////////////////////////////////////////////////////////////////////   	    	
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

  public function delete()
  {

    $vector = array(
      "id" => $_POST["id"]
    );
    $calibracion = $this->Mcalibraciones->getOne($vector);
    $file = $calibracion->file;
    if ($this->Mcalibraciones->delete($_POST)) {
      ////////////////////////////////////////////////////////////////////////////////
      $descripcion_historial = "Se elimina calibracion con codigo = " . $calibracion->description;
      $vector_cambios_hdv = array(
        "descripcion" => $descripcion_historial,
        "usuario_id" => $this->session->userdata("id"),
        "equipo_id" => $calibracion->equipo_id
      );
      $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
      ////////////////////////////////////////////////////////////////////////////////   		
      if ($file != "" && $file != null) {
        $this->load->helper("file");
        unlink("./assets/upload_calibraciones/" . $file);
      }
    }
  }

  public function show()
  {
    $vector = array(
      'calibraciones' => $this->Mcalibraciones->getCalibracionesModal()
    );
    $this->load->view("calibraciones/detail", $vector);
  }

  public function ExportarExcel()
  {
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=CalibracionesEB.xls');
    $calibraciones = $this->Mcalibraciones->getCalibracionesAll();

?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <thead>
        <tr>
          <th>Codigo calibracion</th>
          <th>Fecha de ejecucion</th>
          <th>Marca</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Nombre equipo</th>
          <th>Id equipo</th>
          <th>Archivo</th>
          <th>Ubicación</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($calibraciones as $calibracion) : ?>
          <tr>
            <td><?php echo $calibracion->codigo; ?></td>
            <td><?php echo $calibracion->fecha_ejecucion; ?></td>
            <td><?php echo $calibracion->marca; ?></td>
            <td><?php echo $calibracion->code; ?></td>
            <td>SN:&nbsp;<?php echo $calibracion->serial; ?></td>
            <td><?php echo $calibracion->name; ?></td>
            <td><?php echo $calibracion->id; ?></td>
            <td><?php echo $calibracion->archivocalibracion; ?></td>
            <td><?php echo $calibracion->ubicacion; ?></td>
          </tr>
        <?php endforeach ?>

      </tbody>
    </table>
<?php

  }
}
