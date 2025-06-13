<?php defined('BASEPATH') or exit('El acceso directo no esta permitido');


/**
 * 
 */
class Cplanes extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model("Mplanes");
    $this->load->model("Mequipos");
    $this->load->library('excel');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $acciones = $this->session->userdata("acciones");

    foreach ($acciones as $accion) {
      if ($accion->modulo == "planes mantenimiento") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }

    $data = $this->Mplanes->getAll();


    $planes = array(
      "planes" => $data,

    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("mantenimientos/list", $planes);
    $this->load->view("mantenimientos/modal_edit");
    $this->load->view("mantenimientos/modal_cambios");
    $this->load->view("layouts/footer");
  }
  public function getOne()
  {
    echo json_encode($this->Mplanes->getOne($_POST));
  }

  public function get_server_side()
  {

    if (isset($_POST)) {
      if (isset($_POST['start'])) {
        $vector = $this->Mplanes->get_server_side($_POST);
        $respuesta = array(

          'draw' => intval($this->input->post('draw')),
          'recordsTotal' => $vector['num_filas_limit'],
          'recordsFiltered' => $vector['num_filas'],
          'data' => $vector['datos']

        );
        echo json_encode($respuesta);
      }
    }
  }

  public function getAnios()
  {
    echo json_encode($this->Mplanes->getAnios());
  }

  public function  ImportFromExcel()
  {
    $archivo = $_FILES["file"]["name"];
    $tmpfname = $_FILES["file"]["tmp_name"];
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    $temporal = "";
    $anio = $_POST["anio_cronograma"];
    $reemplazar = $_POST["reemplazar"];

    if ($reemplazar == "si") {
      $this->Mplanes->deleteYear($anio);
    }
    $usuario_id = $this->session->userdata("id");
    for ($i = 2; $i <= $lastRow; $i++) {

      $this->Mplanes->deleteAnterior(array("equipo_id" => $worksheet->getCell('A' . $i)->getValue(), "anio" => $anio));
      $vector_insertar = array(

        "equipo_id" => $worksheet->getCell('A' . $i)->getValue(),
        "anio" => $anio,
        "mes1" => $worksheet->getCell('B' . $i)->getValue(),
        "mes2" => $worksheet->getCell('C' . $i)->getValue(),
        "mes3" => $worksheet->getCell('D' . $i)->getValue(),
        "responsable" => $worksheet->getCell('E' . $i)->getValue(),
        "frecuencia_id" => $worksheet->getCell('F' . $i)->getValue(),
        "usuario_id" => $usuario_id
      );
      $this->Mplanes->add($vector_insertar);
      $vector_insertar = "";
    }
    $this->Mequipos->updateEstadomAutomatico();
    echo json_encode($temporal);
  }

  public function update()
  {

    $anterior = $this->Mplanes->getOne($_POST)[0];
    $contador = 0;
    $cambio = "";

    if ($anterior->mes1 != $_POST["mes1"]) {
      $contador = $contador + 1;
      $cambio .= "(mes 1: " . $anterior->mes1 . "->" . $_POST["mes1"] . ")";
    }
    if ($anterior->mes2 != $_POST["mes2"]) {
      $contador = $contador + 1;
      $cambio .= "(mes 2: " . $anterior->mes2 . "->" . $_POST["mes2"] . ")";
    }
    if ($anterior->mes3 != $_POST["mes3"]) {
      $contador = $contador + 1;
      $cambio .= "(mes 3: " . $anterior->mes3 . "->" . $_POST["mes3"] . ")";
    }
    if ($anterior->responsable != $_POST["responsable"]) {
      $contador = $contador + 1;
      $cambio .= "(Responsable: " . $anterior->responsable . "->" . $_POST["responsable"] . ")";
    }
    if ($contador > 0) {
      $this->Mplanes->addControlCambio(array("planes_mantenimientos_id" => $anterior->id, "cambio" => $cambio, "usuario_id" => $this->session->userdata("id")));
    }

    $this->Mplanes->update($_POST);
  }

  public function getCambios()
  {
    echo json_encode($this->Mplanes->getCambios($_POST));
  }

  public function ExportarExcel()
  {

    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=Cronograma_mantenimiento.xls');
    $planes_mantenimientos = $this->Mplanes->getAll();

?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table class="table table-bordered" border="1">
      <thead>
        <tr>
          <th>Fecha de creación del registro</th>
          <th>Usuario responsable</th>
          <th>Fecha de la ultima actualización</th>
          <th>Ultima edición realizada</th>
          <th>Responsable de la edición</th>
          <th>Equipo Id</th>
          <th>Nombre</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Serie</th>
          <th>Codigo</th>
          <th>Servicio</th>
          <th>Area</th>
          <th>Sede</th>
          <th>Propiedad</th>
          <th>Año vigencia mantenimiento</th>
          <th>Frecuencia de mantenimiento</th>
          <th>Mes1</th>
          <th>Mes2</th>
          <th>Mes3</th>
          <th>Responsable del mantenimiento</th>
          <th>Cantidad de preventivos realizados en el año</th>

          <th>Soporte primer visita</th>
          <th>Fecha primer visita</th>
          <th>Soporte segunda visita</th>
          <th>Fecha segunda visita</th>
          <th>Soporte tercer visita</th>
          <th>Fecha tercer visita</th>
          <th>Soporte cuarta visita</th>
          <th>Fecha cuarta visita</th>

          <th>Estado del equipo</th>
          <th>Estado del mantenimiento</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($planes_mantenimientos as $plan_mantenimiento) : ?>
          <tr>
            <td><?php echo $plan_mantenimiento->created_at; ?></td>
            <td><?php echo $plan_mantenimiento->usuario; ?></td>
            <td><?php echo $plan_mantenimiento->fecha_actualizacion; ?></td>
            <td><?php echo $plan_mantenimiento->cambio; ?></td>
            <td><?php echo $plan_mantenimiento->usuario_editor; ?></td>
            <td><?php echo $plan_mantenimiento->equipo_id; ?></td>
            <td><?php echo $plan_mantenimiento->name; ?></td>
            <td><?php echo $plan_mantenimiento->marca; ?></td>
            <td><?php echo $plan_mantenimiento->modelo; ?></td>
            <td><?php echo "sn: " . $plan_mantenimiento->serial; ?></td>
            <td><?php echo $plan_mantenimiento->code; ?></td>
            <td><?php echo $plan_mantenimiento->servicio; ?></td>
            <td><?php echo $plan_mantenimiento->area; ?></td>
            <td><?php echo $plan_mantenimiento->sede; ?></td>
            <td><?php echo $plan_mantenimiento->propiedad; ?></td>
            <td><?php echo $plan_mantenimiento->anio; ?></td>
            <td><?php echo $plan_mantenimiento->frecuencia; ?></td>
            <td><?php echo $plan_mantenimiento->mes1; ?></td>
            <td><?php echo $plan_mantenimiento->mes2; ?></td>
            <td><?php echo $plan_mantenimiento->mes3; ?></td>
            <td><?php echo $plan_mantenimiento->responsable; ?></td>
            <td><?php echo $plan_mantenimiento->realizados; ?></td>

            <td><?php echo $plan_mantenimiento->primer_visita . " - " . $plan_mantenimiento->proveedor_primer_visita . ""; ?></td>
            <td><?php echo $plan_mantenimiento->fecha_primer_visita ?></td>
            <td><?php echo $plan_mantenimiento->segunda_visita . " - " . $plan_mantenimiento->proveedor_segunda_visita . ""; ?></td>
            <td><?php echo $plan_mantenimiento->fecha_segunda_visita ?></td>
            <td><?php echo $plan_mantenimiento->tercer_visita . " - " . $plan_mantenimiento->proveedor_tercer_visita . ""; ?></td>
            <td><?php echo $plan_mantenimiento->fecha_tercer_visita ?></td>
            <td><?php echo $plan_mantenimiento->cuarta_visita . " - " . $plan_mantenimiento->proveedor_cuarta_visita . ""; ?></td>
            <td><?php echo $plan_mantenimiento->fecha_cuarta_visita ?></td>


            <td><?php echo $plan_mantenimiento->estadoequipo; ?></td>
            <td><?php echo $plan_mantenimiento->estado_mantenimiento; ?></td>
          </tr>
        <?php endforeach ?>

      </tbody>
    </table>

<?php
  }
  public function getListadoResponsables()
  {
    echo json_encode($this->Mplanes->getListadoResponsables());
  }
}
?>