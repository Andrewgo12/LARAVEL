<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 *
 */
class Ccontingencias extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mcontingencias');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
      $this->session->set_userdata('controlador', $this->uri->segment(2));
    } else {
      redirect(base_url('Cauth'));
    }
    $acciones = $this->session->userdata("acciones");
    foreach ($acciones as $accion) {
      if ($accion->modulo == "contingencias") {
        if ($accion->leer != 1) {
          redirect(base_url('Home'));
        }
      }
    }

    $data = array(
      "contingencias" => $this->Mcontingencias->getAll()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("contingencias/list", $data);
    $this->load->view("contingencias/modal_add");
    $this->load->view("contingencias/modal_edit");
    $this->load->view("layouts/footer");
  }
  public function get()
  {
    echo json_encode($this->Mcontingencias->get($_POST));
  }
  public function getAll()
  {
    echo json_encode($this->Mcontingencias->getAll());
  }

  public function getOne()
  {
    echo json_encode($this->Mcontingencias->getOne($_POST));
  }

  public function add()
  {

    $config['upload_path'] = "./assets/upload_contingencias"; //Evaluacion del archivo
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadArchivo');
    $this->uploadArchivo->initialize($config);

    if (!empty($_FILES["file"]["name"])) {
      $this->uploadArchivo->do_upload("file"); //Esto sube el excel en la carpeta
      $data = "";
      $data = $this->uploadArchivo->data();
      $_POST["file"] = $data["file_name"];
    }
    $_POST["usuario_id"] = $this->session->userdata("id");

    if ($this->Mcontingencias->add($_POST)) {
      echo 1;
    } else {
      if (isset($_POST["file"])) {
        $this->load->helper("file");
        unlink("./assets/upload_contingencias/" . $_POST["file"]);
      }
      echo 2;
    }
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
  public function close()
  {
    $_POST["estado_id"] = 4;
    $_POST["fecha_cierre"] = date("Y-m-d");
    $this->Mcontingencias->update($_POST);
    echo 1;
  }

  public function update()
  {

    $config['upload_path'] = "./assets/upload_contingencias"; //Evaluacion del archivo
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadArchivo');
    $this->uploadArchivo->initialize($config);

    if (!empty($_FILES["file"]["name"])) {
      $this->uploadArchivo->do_upload("file"); //Esto sube el excel en la carpeta
      $data = "";
      $data = $this->uploadArchivo->data();
      $_POST["file"] = $data["file_name"];
    }
    if ($_POST["fecha_cierre"] == "") {
      $_POST["fecha_cierre"] = null;
    }
    if ($_POST["fecha"] == "") {
      $_POST["fecha"] = null;
    }

    $this->Mcontingencias->update($_POST);
  }

  public function delete()
  {
    $vector = array(
      "id" => $_POST["id"]
    );
    $contingencia = $this->Mcontingencias->getOne($vector);
    $file = $contingencia->file;
    if ($this->Mcontingencias->delete($_POST)) {
      if ($file != "" && $file != null) {
        $this->load->helper("file");
        unlink("./assets/upload_contingencias/" . $file);
      }
    }
    echo 1;
  }
  public function exportar()
  {
    header('Content-Type:application/xls;charset=utf-8');
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=Contingencias.xls');
    $contingencias = $this->Mcontingencias->getAll();
?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <table border="1" class="table-hover table-bordered table-condensed">
        <thead>
          <tr>
            <th>Observaciones</th>
            <th>Fecha</th>
            <th>Fecha cierre</th>
            <th>Usuario quien la ingresa</th>
            <th>Nombre equipo</th>
            <th>Marca equipo</th>
            <th>Modelo equipo</th>
            <th>Codigo equipo</th>
            <th>Serie equipo</th>
            <th>Origen de la contingencia</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contingencias as $contingencia) : ?>
            <tr>
              <td><?php echo $contingencia->observacion; ?></td>
              <td><?php echo $contingencia->fecha; ?></td>
              <td><?php echo $contingencia->fecha_cierre; ?></td>
              <td><?php echo $contingencia->usuario; ?></td>
              <td><?php echo $contingencia->name; ?></td>
              <td><?php echo $contingencia->marca; ?></td>
              <td><?php echo $contingencia->modelo; ?></td>
              <td><?php echo $contingencia->codigo; ?></td>
              <td>
                <?php if ($contingencia->serial != "") : ?>
                  <?php echo "sn: " . $contingencia->serial; ?>
                <?php endif ?>
              </td>
              <td>
                <?php if ($contingencia->tipo == "") : ?>
                  Otras contingencias
                <?php else : ?>
                  <?php echo $contingencia->tipo; ?>
                <?php endif ?>

              </td>
              <td><?php echo $contingencia->estado; ?></td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
  <?php
  }
}
  ?>