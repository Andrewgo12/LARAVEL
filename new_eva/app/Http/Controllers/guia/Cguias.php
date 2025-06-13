<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Cguias extends CI_Controller
{
  private $permisos;
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mguias');
  }
  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $this->session->set_userdata("controlador", "Cguias");

    $acciones = $this->session->userdata("acciones");
    $this->session->set_userdata('controlador', $this->uri->segment(2));
    foreach ($acciones as $accion) {
      if ($accion->modulo == "guias rapidas") {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }


    $data = array(
      "guias" => $this->Mguias->getAll(),
      "acciones" => $acciones,
      "cantidad_cumple_criterios" => $this->Mguias->countAll(),
      "cantidad_cumple_criterios_con_guia" => $this->Mguias->countWithGuia(),
      "cobertura_biomedicos" => $this->Mguias->getCoberturaBiomedicos(),
      "cobertura_industriales" => $this->Mguias->getCoberturaIndustriales()
    );
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("guias/list", $data);
    $this->load->view("guias/modal_add");
    $this->load->view("guias/modal_link");
    $this->load->view("guias/modal_edit_guia");
    $this->load->view("guias/modal_show_relacionar_guia");
    $this->load->view("guias/modal_show_relacionar_guia_equipos");
    $this->load->view("layouts/footer");
  }
  public function getCoberturaBiomedicos()
  {

    echo json_encode($this->Mguias->getCoberturaBiomedicos());
  }
  public function getCoberturaIndustriales()
  {

    echo json_encode($this->Mguias->getCoberturaIndustriales());
  }
  public function get()
  {
    echo json_encode($this->Mguias->get());
  }
  public function getWithQuery()
  {
    echo json_encode($this->Mguias->getWithQuery());
  }
  public function getOne()
  {

    echo json_encode($this->Mguias->getOne($_POST));
  }
  public function getAll()
  {

    echo json_encode($this->Mguias->getAll());
  }
  public function get_indicador_por_guia()
  {

    echo json_encode($this->Mguias->get_indicador_por_guia());
  }
  public function add()
  {

    $config['upload_path'] = "./assets/upload_guias";
    $config['allowed_types'] = '*';
    $config['max_size']  = 1000000;
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadGuia');
    $this->uploadGuia->initialize($config);

    $this->form_validation->set_rules("name", "Nombre del archivo", "required|is_unique[guias_rapidas.name]|min_length[5]");
    if ($this->form_validation->run()) {
      $coincidencias = $this->Mguias->getByFile($_FILES["file"]["name"]);
      if (!empty($_FILES["file"]["name"])) {
        $this->uploadGuia->do_upload("file"); //Esto sube el archivo
        $data = "";
        $data = $this->uploadGuia->data();
        $_POST["file"] = $data["file_name"];
        $this->Mguias->add($_POST);
        $respuesta = array("caso" => 1);
      } else {
        $respuesta = array("caso" => 2, "informacion" => "Falta ingresar archivo");
      }
    } else {
      $respuesta = array("caso" => 2, "informacion" => validation_errors());
    }
    echo json_encode($respuesta);
  }
  public function update()
  {

    $guia = $this->Mguias->getOne($_POST);
    $config['upload_path'] = "./assets/upload_guias";
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config, 'uploadGuia');
    $this->uploadGuia->initialize($config);

    $this->form_validation->set_rules("estado", "Estado", "required");
    if ($guia->name != $_POST["name"]) {
      $this->form_validation->set_rules("name", "Nombre del archivo", "required|is_unique[guias_rapidas.name]|min_length[5]");
    }
    if (!empty($_FILES["file"]["name"])) {
      $_POST["file"] = $_FILES["file"]["name"];
    }

    if ($this->form_validation->run()) { // Pasa todas las validaciones

      if (!empty($_FILES["file"]["name"])) {
        if ($guia->file != "" && $guia->file != null) {
          $this->load->helper("file");
          unlink("./assets/upload_guias/" . $guia->file);
        }
        $this->uploadGuia->do_upload("file"); //Esto sube el archivo
        $data = "";
        $data = $this->uploadGuia->data();
        $_POST["file"] = $data["file_name"];
      }
      $this->Mguias->update($_POST);
      echo json_encode(array("caso" => 1, "informacion" => "Guia rapida editada exitosamente"));
    } else {
      echo json_encode(array("caso" => 2, "informacion" => validation_errors()));
    }
  }
  public function delete()
  {

    $_POST["estado"] = 0;
    $this->Mguias->update($_POST);
    // $this->Mguias->delete($_POST);
    // echo json_encode($_POST['id']);
  }
  public function show()
  {
    $guias_activas = $this->Mguias->get();
    $this->load->view("guias/detalle_consulta", array("guias_activas" => $guias_activas));
  }
  public function detail_relacionar()
  {
    $relaciones = $this->Mguias->get_relaciones();
    $this->load->view('guias/modal_link_detail', array("relaciones" => $relaciones));
  }
  public function cantidad_relacionar_con_equipos()
  {

    echo json_encode($this->Mguias->cantidad_relacionar_con_equipos($_POST));
  }
  public function relacionar_con_equipos()
  {
    $this->Mguias->relacionar_con_equipos($_POST);
    echo 1;
  }
  public function relacionar_guia_con_equipos()
  {
    $this->Mguias->relacionar_guia_con_equipos($_POST);

    echo json_encode($this->Mguias->cantidad_equipos_asociados(array("id" => $_POST["id"])));
  }
  public function show_combinaciones()
  {
    $guia = $this->Mguias->getOne(array("id" => $_POST["id"]));
    $this->load->view("guias/modal_show_relacionar_guia_equipos_detail", array("guia" => $guia, "id" => $_POST["id"], "combinaciones" => $this->Mguias->get_relaciones()));
  }
  public function getRiesgosIncluidos()
  {

    echo json_encode($this->Mguias->getRiesgosIncluidos());
  }
  public function getEstadosExcluidos()
  {
    echo json_encode($this->Mguias->getEstadosExcluidos());
  }
  public function  exportarPriorizados()
  {
    header('Content-Type:application/xls;charset=utf-8');
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=EquiposPriorizados.xls');
    $equipos = $this->Mguias->getPriorizados();
?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
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
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php
  }
  public function  exportarPriorizadosGuia()
  {

    header('Content-Type:application/xls;charset=utf-8');
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=EquiposPriorizadosConGuia.xls');

    $equipos = $this->Mguias->getPriorizadosGuia();
  ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Sede</th>
          <th>Nombre de la Guia</th>
          <th>Estado del equipo</th>
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
            <td><?php echo $equipo->sede; ?></td>
            <td><?php echo $equipo->guia; ?></td>
            <td><?php echo $equipo->estado; ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php
  }
  public function  exportPrioritizedWithoutGuide()
  {
    header('Content-Type:application/xls;charset=utf-8');
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header('Content-Disposition: attachment;filename=EquiposPriorizadosSinGuia.xls');

    $equipos = $this->Mguias->getPrioritizedWithoutGuide();
  ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Serie</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>sede</th>
          <th>Nombre de la Guia</th>
          <th>Estado del equipo</th>
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
            <td><?php echo $equipo->sede; ?></td>
            <td><?php echo $equipo->guia; ?></td>
            <td><?php echo $equipo->estado; ?></td>
          </tr>
        <?php endforeach ?>

      </tbody>

    </table>

  <?php


  }
  public function  exportarPriorizadosGrupo()
  {

    //header('Content-Type:application/xls;charset=utf-8');
    //header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    //header('Content-Disposition: attachment;filename=EquiposPriorizadosPorGrupo.xls');		

    $equipos = $this->Mguias->getPriorizadosGrupo();
  ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table border="1">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Cantidad total</th>
          <th>Cantidad con guia</th>
          <th>%</th>

        </tr>
      </thead>
      <tbody>
        <?php foreach ($equipos as $equipo) : ?>
          <tr>
            <td><?php echo $equipo->name; ?></td>
            <td><?php echo $equipo->cantidad_total; ?></td>
            <td><?php echo $equipo->cantidad_con_guia; ?></td>
            <td><?php echo $equipo->porcentaje; ?></td>

          </tr>
        <?php endforeach ?>

      </tbody>

    </table>

<?php
  }
  public function countWithGuia()
  {

    echo $this->Mguias->countWithGuia()->cantidad;
  }
  public function countAll()
  {

    echo $this->Mguias->countAll()->cantidad;
  }

  public function updateGuideQueryQuantity()
  {
    echo $this->Mguias->updateGuideQueryQuantity($_POST);
  }
}
?>