<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Cordenes_compra extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Mordenes_compra');
  }
  public function consultar_secop()
  {
    $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?nombre_de_la_entidad=VALLE%20DEL%20CAUCA%20%20ESE%20HOSPITAL%20UNIVERSITARIO%20DEL%20VALLE%20EVARISTO%20GARC%C3%8DA&$limit=10000';
    $json = file_get_contents($url);
    $array = json_decode($json, true);
    $this->load->view(
      "ordenes_compra/modal_api_detalle",
      array(
        "vector" => $array,
        "content" => $json
      )
    );
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
      if ($accion->modulo == "soportes compra") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }


    $data = array(
      "ordenes_compra" => $this->Mordenes_compra->getAll()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("ordenes_compra/list", $data);
    $this->load->view("ordenes_compra/modal_add");
    $this->load->view("ordenes_compra/modal_edit");
    $this->load->view("ordenes_compra/modal_api");
    $this->load->view("equipos/modal_asociacion_orden_compra");
    $this->load->view("equipos/modal_asociacion_orden_compra_especifico");
    /*
		*/
    $this->load->view("layouts/footer");
  }
  public function getAll()
  {
    echo json_encode($this->Mordenes_compra->getAll());
  }


  public function add()
  {

    $this->form_validation->set_rules("orden", "Soporte", "is_unique[ordenes_compra.orden]|required|min_length[4]");
    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_ordenes_compra"; //Evaluacion del archivo
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
      if ($this->Mordenes_compra->add($_POST)) {
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_ordenes_compra/" . $_POST["file"]);
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
  public function getOne()
  {
    echo json_encode($this->Mordenes_compra->getOne($_POST));
  }
  public function getWithNumberDevices()
  {
    echo json_encode($this->Mordenes_compra->getWithNumberDevices());
  }
  public function update()
  {

    if (isset($_POST["secop_id"]) && ($_POST["secop_id"] != 0)) {
      $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?$query=%20SELECT%20*%20WHERE%20uid=%27' . $_POST["secop_id"] . '%27';
      // $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?$query=%20SELECT%20*%20WHERE%20uid=%2720-4-10725897-10052052%27';
      $json = file_get_contents($url);
      $array = json_decode($json, true);
      $_POST["url_secop"] = $array[0]["ruta_proceso_en_secop_i"]["url"];
    }
    if ($this->Mordenes_compra->getOne($_POST)->orden == $_POST["orden"]) {
      $this->form_validation->set_rules("orden", "Orden de compra", "required|min_length[4]");
    } else {
      $this->form_validation->set_rules("orden", "Orden de compra", "is_unique[ordenes_compra.orden]|required|min_length[4]");
    }
    if ($this->form_validation->run()) {
      $config['upload_path'] = "./assets/upload_ordenes_compra"; //Evaluacion del archivo
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
      if ($this->Mordenes_compra->update($_POST)) {
      } else {
        if (isset($_POST["file"])) {
          $this->load->helper("file");
          unlink("./assets/upload_ordenes_compra/" . $_POST["file"]);
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
  public function show()
  {
    $ordenes_compra_activas = $this->Mordenes_compra->getActive();
    $vector = array(
      "ordenes_compra" => $ordenes_compra_activas
    );
    $this->load->view("ordenes_compra/detalle_consulta", $vector);
  }
  public function show_ordenes_compra()
  {
    $activas = $this->Mordenes_compra->getOrdenesCompra();
    $vector = array(
      "ordenes_compra" => $activas
    );
    $this->load->view("ordenes_compra/detalle_consulta", $vector);
  }
  public function show_contratos()
  {
    $activas = $this->Mordenes_compra->getContratos();
    $vector = array(
      "ordenes_compra" => $activas
    );
    $this->load->view("ordenes_compra/detalle_consulta", $vector);
  }
  public function show_cruces_cuentas()
  {
    $activas = $this->Mordenes_compra->getCrucesCuentas();
    $vector = array(
      "ordenes_compra" => $activas
    );
    $this->load->view("ordenes_compra/detalle_consulta", $vector);
  }
  public function show_comodatos()
  {
    $activas = $this->Mordenes_compra->getComodatos();
    $vector = array(
      "ordenes_compra" => $activas
    );
    $this->load->view("ordenes_compra/detalle_consulta", $vector);
  }
  public function ExportarExcel($orden_compra_id)
  {
    header('Content-Type:application/xls;charset=utf-8');
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=SoporteCompra.xls');
    $equipos = $this->Mequipos->getEquiposEnOrdenCompra(array("orden_compra_id" => $orden_compra_id));
    $orden_compra = $this->Mordenes_compra->getOne(array("id" => $orden_compra_id));
?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <strong>Soporte de adquisicion:</strong> = <?php echo $orden_compra->orden; ?> <br>
    <strong>Fecha:</strong> = <?php echo $orden_compra->fecha; ?>
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Servicio de instalación</th>
          <th>Area de instalación</th>
          <th>Fecha de instalación</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($equipos as $equipo) : ?>
          <tr>
            <td><?php echo $equipo->id; ?></td>
            <td><?php echo $equipo->name; ?></td>
            <td><?php echo $equipo->code; ?></td>
            <td><?php echo $equipo->serial; ?></td>
            <td><?php echo $equipo->marca; ?></td>
            <td><?php echo $equipo->modelo; ?></td>
            <td><?php echo $equipo->servicio; ?></td>
            <td><?php echo $equipo->area; ?></td>
            <td><?php echo $equipo->fecha_instalacion; ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php
  }
  public function ExportExcelAll()
  {
    header('Content-Type:application/xls;charset=utf-8');
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=Adquisiciones.xls');
    $ordenes_compra = $this->Mordenes_compra->getWithNumberDevices();
  ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table border="1">
      <thead>
        <tr>
          <th>Orden</th>
          <th>Fecha</th>
          <th>Proveedor</th>
          <th>Cantidad Equipos Asociaos en EVA</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ordenes_compra as $orden_compra) : ?>
          <tr>
            <td><?php echo $orden_compra->orden; ?></td>
            <td><?php echo $orden_compra->fecha; ?></td>
            <td><?php echo $orden_compra->proveedor; ?></td>
            <td><?php echo $orden_compra->cuenta; ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
<?php

  }
}
?>