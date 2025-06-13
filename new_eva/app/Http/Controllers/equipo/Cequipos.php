<?php defined('BASEPATH') or exit('El acceso directo no esta permitido');

class Cequipos extends CI_Controller
{
  private $permisos;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
    $this->load->model('Madquisiciones');
    $this->load->model('Mfuentes');
    $this->load->model('Mtecnologias');
    $this->load->model('Mcbiomedicas');
    $this->load->model('Mcriesgos');
    $this->load->model('Mfrecuencias');
    $this->load->model('Mzonas');
    $this->load->model('Mpreventivos');
    $this->load->model('Mcalibraciones');
    $this->load->model('Mespecificaciones');
    $this->load->model('Mequipo_especificaciones');
    $this->load->model('Mequipo_repuestos');
    $this->load->model('Mcontactos');
    $this->load->model('Mequipo_contactos');
    $this->load->model('Mordenes');
    $this->load->model('Mcorrectivos_generales');
    $this->load->model('Mcorrectivos_generales_archivos');
    $this->load->model('Mobservaciones');
    $this->load->model('Mequipo_archivos');
    $this->load->model('Marchivos');
    $this->load->model('Mupload');
    $this->load->model('Mperiodos_garantias');
    $this->load->model('Mbajas');
    $this->load->model('Mcambios_ubicaciones');
    $this->load->model('Mservicios');
    $this->load->model('Mcontingencias');
    $this->load->model('Mcambios_hdv');
    $this->load->model('Minvimas');
    $this->load->model('Mguias');
    $this->load->model('Mestadoequipos');
    $this->load->model('Mordenes_compra');
    $this->load->model('Mpropietarios');
  }

  public function index()
  {
    if ($this->session->userdata('login')) {
    } else {
      redirect(base_url('Cauth'));
    }
    $this->session->set_userdata('tipo_id', 1);
    $this->session->set_userdata('controlador', $this->uri->segment(2));
    $acciones = $this->session->userdata('acciones');
    foreach ($acciones as $accion) {
      if ($accion->modulo == 'equipos') {
        if ($accion->leer != 1) {
          redirect(base_url('Forbidden'));
        }
      }
    }
    $data = [
      'permisos' => $this->permisos,
      'garantia_casi_vencida' => $this->Mequipos->garantia_casi_vencida(),
      'garantia_vencida' => $this->Mequipos->garantia_vencida(),
      'equipos_baja' => $this->Mequipos->equipos_baja(),
      'equipos_pendientes_baja' => $this->Mequipos->equipos_pendientes_baja(),
      'acciones' => $acciones,
    ];
    $this->session->set_userdata('editar_orden', 'no');
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('equipos/list', $data);
    $this->load->view('equipos/modal_add', ['tipo_id' => 1]);
    $this->load->view('equipos/modal_edit', ['tipo_id' => 1]);
    $this->load->view('equipos/modal_copy', ['tipo_id' => 1]);
    $this->load->view('equipos/modal_show_adquisicion');
    $this->load->view('equipos/modal_show_instalacion');
    $this->load->view('equipos/modal_show'); /* metodo show en el controlador */
    $this->load->view('equipos/modal_add_equipo_especificacion');
    $this->load->view('equipos/modal_add_equipo_contacto');
    $this->load->view('equipos/modal_filter');
    $this->load->view('equipos/modal_show_file');
    $this->load->view('equipos/modal_show_archivos');
    $this->load->view('equipos/modal_add_archivos');
    $this->load->view('archivos/modal_compartir'); // Modal de compartir archivos
    $this->load->view('equipos/modal_add_observacion');
    $this->load->view('equipos/modal_edit_observacion');
    $this->load->view('equipos/modal_show_garantiaCasiVencida');
    $this->load->view('equipos/modal_show_garantiaVencida');
    $this->load->view('equipos/modal_multiple');
    $this->load->view('equipos/modal_obsoletos');
    $this->load->view('equipos/modal_add_archivo_correctivo');
    $this->load->view('servicios/modal_add');
    $this->load->view('correctivos_generales/modal_add');
    $this->load->view('correctivos_generales/modal_edit');
    $this->load->view('correctivos_generales/modal_show');
    $this->load->view('correctivos_generales/modal_show_single');
    $this->load->view('preventivos/modal_add');
    $this->load->view('preventivos/modal_edit');
    $this->load->view('preventivos/modal_show');
    $this->load->view('preventivos/nota/modal_add');
    $this->load->view('calibraciones/modal_add');
    $this->load->view('calibraciones/modal_edit');
    $this->load->view('calibraciones/modal_show');
    $this->load->view('archivos/modal_add_archivo_observacion');
    $this->load->view('invimas/modal_add');
    $this->load->view('invimas/modal_consulta');
    $this->load->view('guias/modal_consulta');
    $this->load->view('manuales/modal_consulta');
    $this->load->view('equipos/modal_add_repuesto');
    $this->load->view('equipos/modal_add_repuesto_correctivo_general');
    $this->load->view('equipos/modal_edit_equipo_repuesto');
    $this->load->view('ordenes_compra/modal_consulta');
    $this->load->view('ordenes_compra/modal_add');
    $this->load->view('bajas/modal_add');
    $this->load->view('bajas/modal_consulta');
    $this->load->view('contingencias/modal_add');
    $this->load->view('areas/modal_add');
    $this->load->view('equipos/modal_compartir_especificaciones');
    $this->load->view('cambios_ubicaciones/modal_show');
    $this->load->view('ordenes/modal_timeline');
    $this->load->view('ordenes/modal_add_diagnostico_from_timeline');
    $this->load->view('ordenes/modal_add_solicitud_cierre_from_timeline');
    $this->load->view('avances_correctivos/modal_add');
    $this->load->view('repuestos_pendientes/modal_add');
    $this->load->view('ordenes/modal_asignar');
    $this->load->view('equipos/modal_depurar_nombres');
    $this->load->view('equipos/historial/modal_show'); /* metodo show en el controlador */
    $this->load->view('propietarios/modal_add'); /* metodo show en el controlador */
    $this->load->view('layouts/footer');
  }

  public function get_devices(){
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $limit = $this->input->get('limit') ? $this->input->get('limit') : 10;
    $offset = ($page - 1) * $limit;
    $devices = $this->Mequipos->get_devices($limit, $offset);

    if ($devices){
      $this->output->set_status_header(200);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($devices));
    }
    else{
      $this->output->set_status_header(404);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('error' => 'No se encontraron equipos')));
    }
  }
  public function get_device($id){
    $device = $this->Mequipos->get_device($id);
    if ($device){
      $this->output->set_status_header(200);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($device));
    }
    else{
      $this->output->set_status_header(404);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('error' => 'No se encontró el equipo')));
    }
  }


  public function getAll()
  {
    echo json_encode($this->Mequipos->getAll());
  }

  public function get_server_side()
  {
    if (isset($_POST)) {
      if (isset($_POST['start'])) {
        $vector = $this->Mequipos->get_server_side($_POST);
        $respuesta = [
          'draw' => intval($this->input->post('draw')),
          'recordsTotal' => $vector['num_filas_limit'],
          'recordsFiltered' => $vector['num_filas'],
          'data' => $vector['datos'],
        ];
        echo json_encode($respuesta);
      }
    }
  }

  public function get_server_side_baxter()
  {
    if (isset($_POST)) {
      if (isset($_POST['start'])) {
        $vector = $this->Mequipos->get_server_side_baxter($_POST);
        $respuesta = [
          'draw' => intval($this->input->post('draw')),
          'recordsTotal' => $vector['num_filas_limit'],
          'recordsFiltered' => $vector['num_filas'],
          'data' => $vector['datos'],
        ];
        echo json_encode($respuesta);
      }
    }
  }

  public function get_server_side_filtros()
  {
    $vector = $this->Mequipos->get_server_side_filtros($_POST);
    $respuesta = [
      'draw' => intval($this->input->post('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos'],
    ];
    echo json_encode($respuesta);
  }

  public function get()
  {
    echo json_encode($this->Mequipos->get());
  }

  public function getForCOntingencias()
  {
    echo json_encode($this->Mequipos->getForCOntingencias());
  }

  public function getTadquisiciones()
  {
    echo json_encode($this->Madquisiciones->get());
  }

  public function getFuentes()
  {
    echo json_encode($this->Mfuentes->get());
  }

  public function getTecnologias()
  {
    echo json_encode($this->Mtecnologias->get());
  }

  public function getCbiomedicas()
  {
    echo json_encode($this->Mcbiomedicas->get());
  }

  public function getCriesgos()
  {
    echo json_encode($this->Mcriesgos->get());
  }

  public function getFrecuencias()
  {
    echo json_encode($this->Mfrecuencias->get());
  }

  public function getZonas()
  {
    echo json_encode($this->Mzonas->get());
  }

  public function getEspecificaciones()
  {
    echo json_encode($this->Mespecificaciones->get());
  }

  public function getOne()
  {
    $this->session->set_userdata('editar_orden', 'si');
    echo json_encode($this->Mequipos->getOne($_POST));
  }

  public function getArchivos()
  {
    echo json_encode($this->Marchivos->get());
  }

  public function getGarantias()
  {
    echo json_encode($this->Mperiodos_garantias->get());
  }

  public function get_garantiaCasiVencida()
  {
    echo json_encode($this->Mequipos->get_garantiaCasiVencida());
  }

  public function get_garantiaVencida()
  {
    echo json_encode($this->Mequipos->get_garantiaVencida());
  }

  public function add()
  {
    if ($_POST['servicio_id'] == null || $_POST['servicio_id'] == '' || $_POST['servicio_id'] == 0) {
      $_POST['servicio_id'] = 0;
    }
    if ($_POST['area_id'] == null || $_POST['area_id'] == '' || $_POST['area_id'] == 0) {
      $_POST['area_id'] = 0;
    }

    if (isset($_POST['manual'])) {
      $_POST['manual'] = serialize($_POST['manual']);
    }
    if (isset($_POST['plano'])) {
      $_POST['plano'] = serialize($_POST['plano']);
    }
    unset($_POST['sede_id']);

    /* Validación */

    $this->form_validation->set_rules('code', 'Codigo', 'is_unique[equipos.code]');
    $this->form_validation->set_rules('serial', 'Serie', 'is_unique[equipos.serial]');
    $this->form_validation->set_rules('name', 'descripcion', 'required|min_length[3]');
    $this->form_validation->set_rules('codigo_antiguo', 'Codigo antiguo', 'is_unique[equipos.codigo_antiguo]');
    if ($this->form_validation->run()) {
      $config['upload_path'] = './assets/upload_imagenes'; // Evaluacion de la imagen
      $config['allowed_types'] = 'gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadImagen');
      $this->uploadImagen->initialize($config);
      if (!empty($_FILES['image']['name'])) {
        $this->uploadImagen->do_upload('image'); // Esto sube la imagen en la carpeta
        $data = '';
        $data = $this->uploadImagen->data();
        $_POST['image'] = $data['file_name'];
      }
      $config['upload_path'] = './assets/upload_archivos'; // Evaluacion del archivo
      $config['allowed_types'] = 'xlsx|xls';
      $config['encrypt_name'] = false;
      $this->load->library('upload', $config, 'uploadFile');
      $this->uploadFile->initialize($config);
      if (!empty($_FILES['file']['name'])) {
        $this->uploadFile->do_upload('file'); // Esto sube el excel en la carpeta
        $data = '';
        $data = $this->uploadFile->data();
        $_POST['file'] = $data['file_name'];
      }
      $_POST['created_at'] = date('Y-m-d H:i:s');
      $_POST['plan'] = 2;
      if ($_POST['fecha_instalacion'] == '') {
        unset($_POST['fecha_instalacion']);
      }
      if ($_POST['fecha_mantenimiento'] == '') {
        unset($_POST['fecha_mantenimiento']);
      }
      if ($this->Mequipos->add($_POST)) { // Metodo para guardar equipo en la base de datos
        echo 1; // Si guardo en la base de datos retorna 1 para mostrar al usuario que fue agregado exitosamente
      } else { // En caso de que no se haya podido guardar se devuelve un mensaje indicando que no se guardo y adicionalmente se elimina el archivo
        if (isset($_POST['image'])) {
          $this->load->helper('file');
          unlink('./assets/upload_imagenes/' . $_POST['image']);
        }
        if (isset($_POST['file'])) {
          $this->load->helper('file');
          unlink('./assets/upload_archivos/' . $_POST['file']);
        }
        if (isset($_POST['archivo_invima'])) {
          $this->load->helper('file');
          unlink('./assets/upload_invimas/' . $_POST['archivo_invima']);
        }
        echo json_encode('No se a podido ingresar el equipo');
      }
    } else { // Cuando no cumple con las validaciones
      echo json_encode(validation_errors());
    }
  }

  public function copy()
  {
    if ($_POST['servicio_id'] == null || $_POST['servicio_id'] == '' || $_POST['servicio_id'] == 0) {
      $_POST['servicio_id'] = 0;
    }
    if (isset($_POST['area_id'])) {
      if ($_POST['area_id'] == null || $_POST['area_id'] == '' || $_POST['area_id'] == 0) {
        $_POST['area_id'] = 0;
      }
    }
    if (isset($_POST['manual'])) {
      $_POST['manual'] = serialize($_POST['manual']);
    }
    if (isset($_POST['plano'])) {
      $_POST['plano'] = serialize($_POST['plano']);
    }
    unset($_POST['sede_id']);
    /* Validación */
    $this->form_validation->set_rules('code', 'Codigo', 'is_unique[equipos.code]');
    $this->form_validation->set_rules('serial', 'Serie', 'is_unique[equipos.serial]');
    $this->form_validation->set_rules('name', 'descripcion', 'required|min_length[3]');
    $this->form_validation->set_rules('codigo_antiguo', 'Codigo antiguo', 'is_unique[equipos.codigo_antiguo]');

    if ($this->form_validation->run()) { // Cuando cumple con las validaciones
      $config['upload_path'] = './assets/upload_archivos'; // Evaluacion del archivo
      $config['allowed_types'] = 'xlsx|xls';
      $config['encrypt_name'] = false;
      $this->load->library('upload', $config, 'uploadFile');
      $this->uploadFile->initialize($config);

      if (!empty($_FILES['file']['name'])) {
        $this->uploadFile->do_upload('file'); // Esto sube el excel en la carpeta
        $data = '';
        $data = $this->uploadFile->data();
        $_POST['file'] = $data['file_name'];
      }

      $_POST['created_at'] = date('Y-m-d H:i:s');
      $_POST['plan'] = 2;
      if ($_POST['fecha_instalacion'] == '') {
        unset($_POST['fecha_instalacion']);
      }
      $equipo_id_origen = $_POST['id'];
      unset($_POST['id']);
      $equipo_id_destino = $this->Mequipos->copy($_POST); // Metodo para guardar equipo en la base de datos
      $vector = [
        'equipo_id_destino' => $equipo_id_destino,
        'equipo_id_origen' => $equipo_id_origen,
      ];
      $this->Mequipo_especificaciones->copy_especificaciones($vector);
      $this->Mequipo_contactos->copy_contactos($vector);
      echo 1;
    } else { // Cuando no cumple con las validaciones
      echo json_encode(validation_errors());
    }
  }

  public function update()
  {
    // Información nueva del equipo------------------------------------------------------------------
    $equipo_new = $_POST; // Solo se usa para actualizar el historial de la hoja de vida
    if (isset($_POST['consulta_invima'])) {
      unset($_POST['consulta_invima']);
    }
    if (isset($_POST['tadquisicion_id'])) {
      if ($_POST['tadquisicion_id'] != 2 && $_POST['tadquisicion_id'] != 3 && $_POST['tadquisicion_id'] != 4) {
        // $_POST["orden_compra_id"]=0;
      }
    }
    $sede_id = $_POST['sede_id']; // Información de sedealmacenada en sesion
    unset($_POST['sede_id']);
    // Información previa del equipo------------------------------------------------------------------
    $equipo = $this->Mequipos->getOne($_POST);
    $servicio_viejo = $this->Mservicios->getOne(['id' => $equipo->servicio_id]);
    $servicio_nuevo = $this->Mservicios->getOne(['id' => $_POST['servicio_id']]);

    /* Historial de cambios de la Hoja de vida */
    $descripcion_historial = ''; // Variable que almacena la descripcion del Historial de cambios de la HDV
    if ($equipo->name != $equipo_new['name']) {
      $descripcion_historial .= $descripcion_historial . 'Se cambio nombre de ' . $equipo->name . ' a ' . $equipo_new['name'] . "\n";
    }
    if ($equipo->marca != $equipo_new['marca']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio marca de ' . $equipo->marca . ' a ' . $equipo_new['marca'] . "\n";
    }
    if ($equipo->modelo != $equipo_new['modelo']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio modelo de ' . $equipo->modelo . ' a ' . $equipo_new['modelo'] . "\n";
    }

    if ($equipo->code != $equipo_new['code']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Codigo de ' . $equipo->code . ' a ' . $equipo_new['code'] . "\n";
    }
    if ($equipo->serial != $equipo_new['serial']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Serie de ' . $equipo->serial . ' a ' . $equipo_new['serial'] . "\n";
    }
    if ($equipo->fecha_ad != $equipo_new['fecha_ad']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Fecha adquisicion de ' . $equipo->fecha_ad . ' a ' . $equipo_new['fecha_ad'] . "\n";
    }
    if ($equipo->fecha_instalacion != $equipo_new['fecha_instalacion']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Fecha instalacion de ' . $equipo->fecha_instalacion . ' a ' . $equipo_new['fecha_instalacion'] . "\n";
    }
    if ($equipo->fecha_acta_recibo != $equipo_new['fecha_acta_recibo']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Fecha acta recibo de ' . $equipo->fecha_acta_recibo . ' a ' . $equipo_new['fecha_acta_recibo'] . "\n";
    }
    if ($equipo->fecha_inicio_operacion != $equipo_new['fecha_inicio_operacion']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Fecha inicio operacion de ' . $equipo->fecha_inicio_operacion . ' a ' . $equipo_new['fecha_inicio_operacion'] . "\n";
    }
    if ($equipo->fecha_fabricacion != $equipo_new['fecha_fabricacion']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio Fecha fabricación de ' . $equipo->fecha_fabricacion . ' a ' . $equipo_new['fecha_fabricacion'] . "\n";
    }
    if ($equipo->descripcion != $equipo_new['descripcion']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio descripción de ' . $equipo->descripcion . ' a ' . $equipo_new['descripcion'] . "\n";
    }
    if ($equipo->vida_util != $equipo_new['vida_util']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio vida util de ' . $equipo->vida_util . ' a ' . $equipo_new['vida_util'] . "\n";
    }
    if ($equipo->costo_original != $equipo_new['costo']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio costo de ' . $equipo->costo_original . ' a ' . $equipo_new['costo'] . "\n";
    }
    if ($equipo->verificacion_inventario != $equipo_new['verificacion_inventario']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio verificacion inventario de ' . $equipo->verificacion_inventario . ' a ' . $equipo_new['verificacion_inventario'] . "\n";
    }
    if (isset($equipo_new['otros']) && $equipo->otros != $equipo_new['otros']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio propiedad de otros de ' . $equipo->otros . ' a ' . $equipo_new['otros'] . "\n";
    }
    if ($equipo->activo_comodato != $equipo_new['activo_comodato']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio codigo comodato de ' . $equipo->activo_comodato . ' a ' . $equipo_new['activo_comodato'] . "\n";
    }
    if ($equipo->movilidad != $equipo_new['movilidad']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio movilidad de ' . $equipo->movilidad . ' a ' . $equipo_new['movilidad'] . "\n";
    }
    // if ($equipo->periodicidad!=$equipo_new["periodicidad"]) {
    // 	$descripcion_historial=$descripcion_historial."Se cambio periodicidad mantenimiento de ".$equipo->periodicidad." a ".$equipo_new["periodicidad"]."\n";
    // }
    if ($equipo->calibracion != $equipo_new['calibracion']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio calibracion de ' . $equipo->calibracion . ' a ' . $equipo_new['calibracion'] . "\n";
    }
    if ($equipo->estadoequipo_id != $equipo_new['estadoequipo_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio estado funcional del equipo de ' . $this->Mestadoequipos->getOne(['id' => $equipo->estadoequipo_id])->name . ' a ' . $this->Mestadoequipos->getOne(['id' => $equipo_new['estadoequipo_id']])->name . "\n";
    }
    if ($equipo->disponibilidad_id != $equipo_new['disponibilidad_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio disponibilidad del equipo de ' . $this->Mestadoequipos->getOne(['id' => $equipo->disponibilidad_id])->name . ' a ' . $this->Mestadoequipos->getOne(['id' => $equipo_new['disponibilidad_id']])->name . "\n";
    }
    if ((isset($equipo_new['localizacion_actual'])) && ($equipo->localizacion_actual != $equipo_new['localizacion_actual'])) {
      $descripcion_historial = $descripcion_historial . ' Se relaciono como localización acual del equipo: ' . $equipo_new['localizacion_actual'] . "\n";
    }
    if ($equipo->tadquisicion_id != $equipo_new['tadquisicion_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio tipo de adquisicion de ' . $this->Madquisiciones->getOne(['id' => $equipo->tadquisicion_id])->name . ' a ' . $this->Madquisiciones->getOne(['id' => $equipo_new['tadquisicion_id']])->name . "\n";
    }
    if ($equipo->frecuencia_id != $equipo_new['frecuencia_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio frecuencia de mtto de ' . $this->Mfrecuencias->getOne(['id' => $equipo->frecuencia_id])->name . ' a ' . $this->Mfrecuencias->getOne(['id' => $equipo_new['frecuencia_id']])->name . "\n";
    }
    if (!isset($equipo_new['propietario_id']) || $equipo_new['propietario_id'] == '' || $equipo_new['propietario_id'] == 0) {
      $equipo_new['propietario_id'] = 0;
    }
    if ($equipo->propietario_id != $equipo_new['propietario_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio propietario de ' . $this->Mpropietarios->getOne(['id' => $equipo->propietario_id])->nombre . ' a ' . $this->Mpropietarios->getOne(['id' => $equipo_new['propietario_id']])->nombre . "\n";
    }
    if (!isset($equipo_new['orden_compra_id']) || $equipo_new['orden_compra_id'] == '' || $equipo_new['orden_compra_id'] == 0) {
      $equipo_new['orden_compra_id'] = 0;
    }
    if ($equipo->orden_compra_id != $equipo_new['orden_compra_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio soporte de compra de ' . $this->Mordenes_compra->getOne(['id' => $equipo->orden_compra_id])->orden . ' a ' . $this->Mordenes_compra->getOne(['id' => $equipo_new['orden_compra_id']])->orden . "\n";
    }
    if (!isset($equipo_new['guia_id']) || $equipo_new['guia_id'] == '' || $equipo_new['guia_id'] == 0) {
      $equipo_new['guia_id'] = 0;
    }
    if ($equipo->guia_id != $equipo_new['guia_id']) {
      $descripcion_historial = $descripcion_historial . 'Se cambio guia rapida de ' . $this->Mguias->getOne(['id' => $equipo->guia_id])->name . ' a ' . $this->Mguias->getOne(['id' => $equipo_new['guia_id']])->name . "\n";
    }
    if (!isset($equipo_new['invima_id']) || $equipo_new['invima_id'] == '' || $equipo_new['invima_id'] == 0) {
      $nuevo_invima = 1;
    } else {
      $nuevo_invima = $equipo_new['invima_id'];
    }
    if ($equipo->invima_id == 0) {
      $viejo_invima = 1;
    } else {
      $viejo_invima = $equipo->invima_id;
    }

    if ($viejo_invima != $nuevo_invima) {
      $descripcion_historial = $descripcion_historial . 'Se cambio invima de ' . $this->Minvimas->getOne(['id' => $viejo_invima])->invima . ' a ' . $this->Minvimas->getOne(['id' => $nuevo_invima])->invima . "\n";
    }

    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($_POST['estadoequipo_id'] != 6) {
      $_POST['baja_id'] = null;
    }
    if (isset($_POST['manual'])) {
      $_POST['manual'] = serialize($_POST['manual']);
    } else {
      $_POST['manual'] = 'N;';
    }
    if (isset($_POST['plano'])) {
      $_POST['plano'] = serialize($_POST['plano']);
    } else {
      $_POST['plano'] = 'N;';
    }

    if ($_POST['fecha_instalacion'] == '') {
      unset($_POST['fecha_instalacion']);
    }

    if ($equipo->code == $_POST['code']) {
    } else {
      $this->form_validation->set_rules('code', 'Codigo', 'is_unique[equipos.code]');
    }
    if ($equipo->serial == $_POST['serial']) {
    } else {
      $this->form_validation->set_rules('serial', 'Serie', 'is_unique[equipos.serial]');
    }
    if ($equipo->codigo_antiguo == $_POST['codigo_antiguo']) {
    } else {
      $this->form_validation->set_rules('codigo_antiguo', 'Codigo antiguo', 'is_unique[equipos.codigo_antiguo]');
    }
    $this->form_validation->set_rules('name', 'Descripcion', 'required|min_length[3]');

    if ($this->form_validation->run()) { // Cuando cumple con las validaciones
      $config['upload_path'] = './assets/upload_imagenes'; // Evaluacion de la imagen
      $config['allowed_types'] = 'gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadImagen');
      $this->uploadImagen->initialize($config);

      if (!empty($_FILES['image1']['name'])) {
        $this->uploadImagen->do_upload('image1'); // Esto sube la imagen en la carpeta
        $data = '';
        $data = $this->uploadImagen->data();
        $_POST['image'] = $data['file_name'];
      }

      $config['upload_path'] = './assets/upload_archivos'; // Evaluacion del archivo
      $config['allowed_types'] = 'xlsx|xls';
      $config['encrypt_name'] = false;
      $this->load->library('upload', $config, 'uploadFile');
      $this->uploadFile->initialize($config);

      if (!empty($_FILES['file1']['name'])) {
        $this->uploadFile->do_upload('file1'); // Esto sube el excel en la carpeta
        $data = '';
        $data = $this->uploadFile->data();
        $_POST['file'] = $data['file_name'];
      }

      $config['upload_path'] = './assets/upload_invimas'; // Evaluacion del archivo
      $config['allowed_types'] = 'pdf';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadInvima');
      $this->uploadInvima->initialize($config);

      if (!empty($_FILES['archivo_invima1']['name'])) {
        $this->uploadInvima->do_upload('archivo_invima1'); // Esto sube el excel en la carpeta
        $data = '';
        $data = $this->uploadInvima->data();
        $_POST['archivo_invima'] = $data['file_name'];
      }

      if (isset($_POST['observacion'])) {
        if ($_POST['observacion'] != '') {
          $_POST['observacion'] = '' . date('Y-m-d h:i:s') . "\n" . $_POST['observacion'] . "\n" . $equipo->observacion;
        } else {
          unset($_POST['observacion']);
        }
      }
      if (isset($_POST['fecha_instalacion'])) {
        if ($_POST['fecha_instalacion'] == '') {
          unset($_POST['fecha_instalacion']);
        }
      }
      if (isset($_POST['fecha_instalacion'])) {
        if ($_POST['fecha_instalacion'] == '') {
          unset($_POST['fecha_instalacion']);
        }
      }
      if (isset($_POST['fecha_ad'])) {
        if ($_POST['fecha_ad'] == '') {
          unset($_POST['fecha_ad']);
        }
      }
      if (isset($_POST['invima_id'])) {
        if ($_POST['invima_id'] == 1) {
          $_POST['invima_id'] = null;
        }
      }

      if ($_POST['servicio_id'] == null || $_POST['servicio_id'] == '' || $_POST['servicio_id'] == 0) {
        $_POST['servicio_id'] = 0;
      }
      if (isset($_POST['area_id']) && ($_POST['area_id'] == null || $_POST['area_id'] == '' || $_POST['area_id'] == 0)) {
        $_POST['area_id'] = 0;
      }
      // Logica implementada para crear registro en caso de cambiarse el servicio
      if (isset($_POST['area_id']) && ($equipo->servicio_id != $_POST['servicio_id'] || $equipo->area_id != $_POST['area_id'])) {
        $this->Mcambios_ubicaciones->add([
          'servicio_origen_id' => $equipo->servicio_id,
          'servicio_destino_id' => $_POST['servicio_id'],
          'area_origen_id' => $equipo->area_id,
          'area_destino_id' => $_POST['area_id'],
          'equipo_id' => $equipo->id,
          'usuario_id' => $this->session->userdata('id'),
          'sede_origen_id' => $servicio_viejo->sede_id,
          'sede_destino_id' => $servicio_nuevo->sede_id,
        ]);
      }
      // Logica implementada para crear registro de cambio de hoja de vida
      $vector_cambios_hdv = '';
      if ($descripcion_historial != '') {
        $vector_cambios_hdv = [
          'descripcion' => $descripcion_historial,
          'usuario_id' => $this->session->userdata('id'),
          'equipo_id' => $equipo->id,
        ];
        $this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
      }

      $this->Mequipos->update($_POST); // Metodo para actualizar
      $this->Mequipos->depurarCodigo();
      // $this->Mequipos->updateFechasNull();
      $fecha_actual = date('Y-m-d');

      echo json_encode(['respuesta' => 1, 'equipo_id' => $equipo->id]);
    } else { // Cuando no cumple con las validaciones
      echo json_encode(['respuesta' => 2, 'errores' => validation_errors()]); // Retorna los mensajes de error en caso de que no supere las validaciones
    }
  }

  public function show()
  {
    $equipo = $this->Mequipos->getOne($_POST);

    $frecuency_computed = $this->Mequipos->compute_frecuency(
      $equipo->mes_programado1,
      $equipo->mes_programado2
    );
    $_POST['equipo_id'] = $_POST['id'];
    unset($_POST['id']);
    $preventivos = $this->Mpreventivos->get($_POST);
    $calibraciones = $this->Mcalibraciones->get($_POST);
    $repuestos = $this->Mequipo_repuestos->get($_POST);
    $especificaciones = $this->Mequipo_especificaciones->get($_POST);
    $tension = $this->Mequipo_especificaciones->get_tension($_POST);
    $potencia = $this->Mequipo_especificaciones->get_potencia($_POST);
    $presion = $this->Mequipo_especificaciones->get_presion($_POST);
    $temperatura = $this->Mequipo_especificaciones->get_temperatura($_POST);
    $corriente = $this->Mequipo_especificaciones->get_corriente($_POST);
    $frecuencia = $this->Mequipo_especificaciones->get_frecuencia($_POST);
    $velocidad = $this->Mequipo_especificaciones->get_velocidad($_POST);
    $humedad = $this->Mequipo_especificaciones->get_humedad($_POST);
    $peso = $this->Mequipo_especificaciones->get_peso($_POST);
    $otro = $this->Mequipo_especificaciones->get_otro($_POST);
    $archivo = $this->Mequipo_especificaciones->get_archivo($_POST);
    $contactos = $this->Mequipo_contactos->get($_POST);
    $fabricante = $this->Mequipo_contactos->get_fabricante($_POST);
    $proveedor = $this->Mequipo_contactos->get_proveedor($_POST);
    $representante = $this->Mequipo_contactos->get_representante($_POST);
    $fabricante = $this->Mequipo_contactos->get_fabricante($_POST);
    $representante = $this->Mequipo_contactos->get_representante($_POST);
    $correctivos = $this->Mordenes->get($_POST);
    $correctivos_generales = $this->Mcorrectivos_generales->get($_POST);
    $observaciones = $this->Mobservaciones->get($_POST);
    $bajas = $this->Mbajas->get_by_equipo($_POST);
    $contingencias = $this->Mcontingencias->get($_POST);
    $_POST['id'] = $_POST['equipo_id'];
    $archivos = $this->Mequipo_archivos->get($_POST);
    $cambios_hdv = $this->Mcambios_hdv->get_from_device($_POST);
    $param = [
      'equipo' => $equipo,
      'preventivos' => $preventivos,
      'calibraciones' => $calibraciones,
      'repuestos' => $repuestos,
      'especificaciones' => $especificaciones,
      'tension' => $tension,
      'potencia' => $potencia,
      'presion' => $presion,
      'temperatura' => $temperatura,
      'corriente' => $corriente,
      'frecuencia' => $frecuencia,
      'velocidad' => $velocidad,
      'humedad' => $humedad,
      'peso' => $peso,
      'otro' => $otro,
      'archivo' => $archivo,
      'contactos' => $contactos,
      'fabricante' => $fabricante,
      'proveedor' => $proveedor,
      'representante' => $representante,
      'correctivos' => $correctivos,
      'correctivos_generales' => $correctivos_generales,
      'observaciones' => $observaciones,
      'archivos' => $archivos,
      'bajas' => $bajas,
      'contingencias' => $contingencias,
      'cambios_hdv' => $cambios_hdv,
      'frecuency_computed' => $frecuency_computed,
    ];
    $this->load->view('equipos/detail', $param);
  }

  public function show_file()
  {
    $equipo = $this->Mequipos->getOne($_POST);
    $param = [
      'equipo' => $equipo,
    ];
    $this->load->view('equipos/detail_file', $param);
  }

  public function show_archivos()
  {
    $equipo_archivo = $this->Mequipo_archivos->get($_POST);
    $param = [
      'equipo_archivo' => $equipo_archivo,
    ];
    $this->load->view('equipos/detail_archivos', $param);
  }

  public function show_capacitaciones()
  {
    $equipo_archivo = $this->Mequipo_archivos->get_capacitaciones($_POST);
    $param = [
      'equipo_archivo' => $equipo_archivo,
    ];
    $this->load->view('equipos/detail_archivos', $param);
  }

  /* CRUD CORRECTIVOS */
  public function getCorrectivos()
  {
    echo json_encode($this->Mordenes->get($_POST));
  }

  /* CRUD CORRECTIVOS GENERALES */
  public function add_archivo_correctivo_general()
  {
    $config['upload_path'] = './assets/upload_correctivos_generales';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadCorrectivoGeneral');
    $this->uploadCorrectivoGeneral->initialize($config);

    if (!empty($_FILES['file']['name'])) {
      $this->uploadCorrectivoGeneral->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadCorrectivoGeneral->data();
      $_POST['file'] = $data['file_name'];
      unset($_POST['equipo_id']);

      $this->Mcorrectivos_generales_archivos->add($_POST);
    }
  }

  public function getArchivosCorrectivosGenerales()
  {
    echo json_encode($this->Mcorrectivos_generales_archivos->get($_POST));
  }

  public function deleteArchivoCorrectivoGeneral()
  {
    $archivo = $this->Mcorrectivos_generales_archivos->getOne($_POST);
    $file = $archivo->file;

    if ($this->Mcorrectivos_generales_archivos->delete($_POST['id'])) {
      $this->load->helper('file');
      unlink('./assets/upload_correctivos_generales/' . $file);
    }
  }

  /* CRUD OBSERVACIONES */
  public function addObservacion()
  {
    $config['upload_path'] = './assets/upload_observaciones';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadObservacion');
    $this->uploadObservacion->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadObservacion->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadObservacion->data();
      $_POST['file'] = $data['file_name'];
    }
    if ($_POST['created_at'] != '' && $_POST['created_at'] != null && $_POST['created_at'] != null) {
      $_POST['created_at'] = $_POST['created_at'] . ' ' . $_POST['hora_observacion'];
      unset($_POST['hora_observacion']);
    } else {
      $_POST['created_at'] = date('Y-m-d h:i:s');
      unset($_POST['hora_observacion']);
    }

    if (isset($_POST['repuesto_id']) && $_POST['repuesto_id'] != '' && $_POST['repuesto_id'] != null) {
      $_POST['repuesto_pendiente'] = 'si';
      $vector_actualizacion_equipo = [
        'id' => $_POST['equipo_id'],
        'repuesto_pendiente' => 'si',
      ];
      $this->Mequipos->update($vector_actualizacion_equipo); // Se actualiza el equipo indicando que tiene un repuesto pendiente
    } else {
      unset($_POST['repuesto_id']);
    }

    $ultimo_id = $this->Mobservaciones->add($_POST); // Agrego la observacion

    $vector_respuesta = [
      'observacion_id' => $ultimo_id,
      'equipo_id' => $_POST['equipo_id'],
    ];
    if (isset($vector_actualizacion_equipo)) {
      $vector_respuesta['repuesto_id'] = $_POST['repuesto_id'];
    }

    // echo json_encode($_POST["equipo_id"]);
    echo json_encode($vector_respuesta);
  }

  public function addArchivoObservcion()
  {
    $observacion = $this->Mobservaciones->getOne(['id' => $_POST['observacion_id']]);
    $equipo_id = $observacion->equipo_id;
    $config['upload_path'] = './assets/upload_observaciones';
    $config['allowed_types'] = '*';
    $config['max_size'] = 1000000;
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadObservacion');
    $this->uploadObservacion->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadObservacion->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadObservacion->data();
      $_POST['file'] = $data['file_name'];
    }
    $this->Mobservaciones->addFile($_POST);
    echo json_encode($equipo_id);
  }

  public function getArchivosObservacion()
  {
    echo json_encode($this->Mobservaciones->getArchivosObservacion($_POST));
  }

  public function getObservaciones()
  {
    echo json_encode($this->Mobservaciones->get($_POST));
  }

  public function getOneObservacion()
  {
    echo json_encode($this->Mobservaciones->getOne($_POST));
  }

  public function updateObservacion()
  {
    if (isset($_POST)) {
      $observacion_id = $_POST['id'];
      $observacion = $this->Mobservaciones->getOne($_POST);
      $file_anterior = $observacion->file;

      $config['upload_path'] = './assets/upload_observaciones';
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadObservacion');
      $this->uploadObservacion->initialize($config);
      if (!empty($_FILES['file']['name'])) {
        $this->uploadObservacion->do_upload('file'); // Esto sube el archivo
        $data = '';
        $data = $this->uploadObservacion->data();
        $_POST['file'] = $data['file_name'];
      }

      $cambio = 'no';

      if ($_POST['repuesto_id'] != $observacion->repuesto_id) { // Hubo un cambio en el repuesto pendiente
        $cambio = 'si';
      }
      if ($_POST['repuesto_id'] == '' || $_POST['repuesto_id'] == null) {
        $cambio = 'no';
      }

      if ($this->Mobservaciones->update($_POST)) {
        if (isset($_POST['file'])) {
          if ($_POST['file'] != $file_anterior) {
            $this->load->helper('file');
            unlink('./assets/upload_observaciones/' . $file_anterior);
          }
        }
        echo json_encode(['equipo_id' => $_POST['equipo_id'], 'cambio' => $cambio, 'observacion_id' => $observacion_id]);
      } else {
        if (isset($_POST['file'])) {
          $this->load->helper('file');
          unlink('./assets/upload_observaciones/' . $_POST['file']);
        }
      }
    }
  }

  public function deleteObservacion()
  {
    $vector = [
      'id' => $_POST['id'],
    ];
    $observacion = $this->Mobservaciones->getOne($vector);
    $file = $observacion->file;
    if ($this->Mobservaciones->delete($_POST)) {
      if ($file != '' && $file != null) {
        $this->load->helper('file');
        unlink('./assets/upload_observaciones/' . $file);
      }
    }
  }

  /* CRUD EQUIPO_REPUESTOS */
  public function addEquipoRepuesto()
  {
    $config['upload_path'] = './assets/upload_equipo_repuestos';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadEquipoRepuesto');
    $this->uploadEquipoRepuesto->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadEquipoRepuesto->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadEquipoRepuesto->data();
      $_POST['file'] = $data['file_name'];
    }
    $_POST['usuario_id'] = $this->session->userdata('id');
    $this->Mequipo_repuestos->add($_POST);
    echo json_encode($_POST['equipo_id']);
  }

  public function addEquipoRepuestoCorrectivoGeneral()
  {
    $config['upload_path'] = './assets/upload_equipo_repuestos';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadEquipoRepuesto');
    $this->uploadEquipoRepuesto->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadEquipoRepuesto->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadEquipoRepuesto->data();
      $_POST['file'] = $data['file_name'];
    }
    $_POST['usuario_id'] = $this->session->userdata('id');
    $this->Mequipo_repuestos->add($_POST);
    echo json_encode(['correctivo_general_id' => $_POST['correctivo_general_id'], 'equipo_id' => $_POST['equipo_id']]);
  }

  public function getOneEquipoRepuesto()
  {
    echo json_encode($this->Mequipo_repuestos->getOne($_POST));
  }

  public function getEquipoRepuestos()
  {
    echo json_encode($this->Mequipo_repuestos->get($_POST));
  }

  public function getEquipoRepuestosCorrectivosgenerales()
  {
    echo json_encode($this->Mequipo_repuestos->getEquipoRepuestosCorrectivosgenerales($_POST));
  }

  public function updateEquipoRepuesto()
  {
    if (isset($_POST)) {
      // code...
      $equipo_repuesto = $this->Mequipo_repuestos->getOne($_POST);
      $file_anterior = $equipo_repuesto->file;

      $config['upload_path'] = './assets/upload_equipo_repuestos';
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadEquipoRepuesto');
      $this->uploadEquipoRepuesto->initialize($config);
      if (!empty($_FILES['file']['name'])) {
        $this->uploadEquipoRepuesto->do_upload('file'); // Esto sube el archivo
        $data = '';
        $data = $this->uploadEquipoRepuesto->data();
        $_POST['file'] = $data['file_name'];
      }
      if ($this->Mequipo_repuestos->update($_POST)) {
        if (isset($_POST['file'])) {
          if ($_POST['file'] != $file_anterior) {
            $this->load->helper('file');
            unlink('./assets/upload_equipo_repuestos/' . $file_anterior);
          }
        }
        echo json_encode($_POST['equipo_id']);
      } else {
        if (isset($_POST['file'])) {
          $this->load->helper('file');
          unlink('./assets/upload_equipo_repuestos/' . $_POST['file']);
        }
      }
    }
  }

  public function deleteEquipoRepuesto()
  {
    $vector = [
      'id' => $_POST['id'],
    ];
    $equipo_repuesto = $this->Mequipo_repuestos->getOne($vector);
    $file = $equipo_repuesto->file;
    if ($this->Mequipo_repuestos->delete($_POST)) {
      if ($file != '' && $file != null) {
        $this->load->helper('file');
        unlink('./assets/upload_equipo_repuestos/' . $file);
      }
    }
  }

  /* CRUD EQUIPO-ESPECIFICACION */

  public function getEquipoEspecificaciones()
  {
    echo json_encode($this->Mequipo_especificaciones->get($_POST));
  }

  public function addEquipoEspecificacion()
  {
    $config['upload_path'] = './assets/upload_archivos';
    $config['allowed_types'] = '*';
    $config['max_size'] = 1000000;
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadEspecificacion');
    $this->uploadEspecificacion->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadEspecificacion->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadEspecificacion->data();
      $_POST['file'] = $data['file_name'];
    }

    $this->Mequipo_especificaciones->add($_POST);
    echo json_encode($_POST['equipo_id']);
  }

  public function deleteEquipoEspecificacion()
  {
    $this->Mequipo_especificaciones->delete($_POST);
  }

  /* CRUD EQUIPO-CONTACTO */
  public function getEquipoContactos()
  {
    echo json_encode($this->Mequipo_contactos->get($_POST));
  }

  public function addEquipoContacto()
  {
    $this->Mequipo_contactos->add($_POST);
    echo json_encode($_POST['equipo_id']);
  }

  public function deleteEquipoContacto()
  {
    $this->Mequipo_contactos->delete($_POST);
  }
  /* CRUD EQUIPO ARCHIVO */

  public function add_equipo_archivo()
  {
    if (isset($_POST)) {
      // code...
      $config['upload_path'] = './assets/upload_equipo_archivos'; // Evaluacion de la imagen
      $config['allowed_types'] = '*';
      $config['encrypt_name'] = true;
      $this->load->library('upload', $config, 'uploadEquipoArchivo');
      $this->uploadEquipoArchivo->initialize($config);

      if (!empty($_FILES['vinculo']['name'])) {
        $this->uploadEquipoArchivo->do_upload('vinculo'); // Esto sube la imagen en la carpeta
        $data = '';
        $data = $this->uploadEquipoArchivo->data();
        $_POST['vinculo'] = $data['file_name'];
      }
      if (isset($_POST['fecha_capacitacion'])) {
        $_POST['created_at'] = $_POST['fecha_capacitacion'] . ' ' . $_POST['hora_capacitacion'];
        unset($_POST['fecha_capacitacion']);
        unset($_POST['hora_capacitacion']);
      }

      $this->Mequipo_archivos->add($_POST);
      echo 1;
    }
  }

  public function delete_equipo_archivo()
  {
    $this->Mequipo_archivos->delete($_POST);
  }

  /* OTROS */
  public function exportarExcel()
  {
    if (isset($_POST)) {
      header('Content-Type:application/xls;charset=utf-8');
      header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
      header('Content-Disposition: attachment;filename=EquiposHUV.xls');
      $equipos = $this->Mequipos->getFiltered($_POST);

?>

      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <table border="1">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion adicional</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Codigo actual</th>
            <th>Codigo antiguo</th>
            <th>Registro Sanitario</th>
            <th>Estado actual</th>
            <th>Fecha de adquisicion</th>
            <th>Fecha de instalacion</th>
            <th>Fecha de disposicion final</th>
            <th>Servicio</th>
            <th>Area</th>
            <th>Sede</th>
            <th>Localización actual</th>
            <th>Fecha del ultimo preventivo</th>
            <th>Frecuencia de mantenimiento establecida</th>
            <th>Frecuencia de mantenimiento utilizada</th>
            <th>Ultimo año programado</th>
            <!-- 						<th>Mes programado 1</th>
						<th>Mes programado 2</th>
						<th>Mes programado 3</th> -->
            <th>Proveedor del mantenimiento</th>
            <th>Cantidad de preventivos</th>
            <th>Estado actual del mantenimiento preventivo</th>
            <th>Fecha de la ultima calibracion</th>
            <th>Cantidad de calibraciones</th>
            <th>Costo</th>
            <th>Soporte de compra</th>
            <th>Tipo de compra</th>
            <th>Proveedor segun soporte</th>
            <th>Garantia</th>
            <th>Fecha de vencimiento de la garantia</th>
            <th>Fuente de alimentación</th>
            <th>Tecnologia principal</th>
            <th>Clasificación biomedica</th>
            <th>Clasificación de riesgo</th>
            <th>Tipo de adquisición</th>
            <th>Propiedad</th>
            <th>Otros</th>
            <th>Fecha del ultimo correctivo</th>
            <th>Descripción del ultimo correctivo</th>
            <th>Cantidad de correctivos registrados</th>
            <th>Cantidad de Tickets generados</th>
            <th>Distribución por zonas</th>
            <th>Información de contactos</th>
            <th>Archivo Excel cargado de Hoja de vida</th>
            <th>Tienen repuesto pendiente</th>
            <th>Vida util</th>
            <th>Guia rapida</th>
            <th>Url del manual</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($equipos as $equipo) { ?>
            <?php if ($equipo->estadoequipos == 'Equipo dado de baja' || $equipo->estadoequipos == 'Pendiente por dar de baja') { ?>
              <tr style="background-color: red;">
              <?php } else { ?>
              <tr>
              <?php } ?>
              <td><?php echo $equipo->id; ?></td>
              <td><?php echo $equipo->name; ?></td>
              <td><?php echo $equipo->descripcion; ?></td>
              <td><?php echo $equipo->marca; ?></td>
              <td><?php echo $equipo->modelo; ?></td>
              <td><?php echo 'sn: ' . $equipo->serial; ?></td>
              <td><?php echo $equipo->code; ?></td>
              <td><?php echo $equipo->codigo_antiguo; ?></td>
              <?php if ($equipo->registro_sanitario != null) { ?>
                <td><?php echo $equipo->registro_sanitario; ?></td>
              <?php } else { ?>
                <td><?php echo $equipo->invima; ?></td>
              <?php } ?>
              <td>
                <?php echo $equipo->estadoequipos; ?>
              </td>
              <td><?php echo $equipo->fecha_ad; ?></td>
              <td><?php echo $equipo->fecha_instalacion; ?></td>
              <td><?php echo $equipo->fecha_baja; ?></td>
              <td><?php echo $equipo->servicios; ?></td>
              <td><?php echo $equipo->area; ?></td>
              <td><?php echo $equipo->sede; ?></td>
              <td><?php echo $equipo->localizacion_actual; ?></td>
              <td><?php echo $equipo->ultimo_mantenimiento; ?></td>
              <td><?php echo $equipo->frecuencias; ?></td>
              <td><?php echo $equipo->frecuencia_utilizada; ?></td>
              <td><?php echo $equipo->ultimo_anio_programado; ?></td>
              <!-- 										<td><?php echo $equipo->mes_programado_1; ?></td>
										<td><?php echo $equipo->mes_programado_2; ?></td>
										<td><?php echo $equipo->mes_programado_3; ?></td> -->
              <td><?php echo $equipo->proveedor_mantenimiento; ?></td>
              <td><?php echo $equipo->cuenta_preventivos; ?></td>
              <td><?php echo $equipo->estadosm; ?></td>
              <td><?php echo $equipo->ultima_calibracion; ?></td>
              <td><?php echo $equipo->cuenta_calibraciones; ?></td>
              <td><?php echo $equipo->costo; ?></td>
              <td><?php echo $equipo->orden_compra; ?></td>
              <td><?php echo $equipo->tipo_compra; ?></td>
              <td><?php echo $equipo->proveedor; ?></td>
              <td><?php echo $equipo->garantia; ?></td>
              <td><?php echo $equipo->fecha_vencimiento_garantia; ?></td>
              <td><?php echo $equipo->fuentesal; ?></td>
              <td><?php echo $equipo->tecnologiasp; ?></td>
              <td><?php echo $equipo->cbiomedicas; ?></td>
              <td><?php echo $equipo->criesgos; ?></td>
              <td><?php echo $equipo->tadquisiciones; ?></td>
              <!-- <td><?php echo $equipo->propiedad; ?></td> -->
              <td><?php echo $equipo->propietario; ?></td>
              <td><?php echo $equipo->otros; ?></td>
              <td><?php echo $equipo->ultimo_correctivo; ?></td>
              <td><?php echo $equipo->descripcion_correctivo; ?></td>
              <td><?php echo $equipo->cuenta_correctivos; ?></td>
              <td><?php echo $equipo->cuenta_tickets; ?></td>
              <td><?php echo $equipo->zonas; ?></td>
              <td><?php echo $equipo->informacion_contacto; ?></td>
              <td><?php echo $equipo->file; ?></td>
              <td><?php echo $equipo->repuesto_pendiente; ?></td>
              <td><?php echo $equipo->vida_util; ?></td>
              <td><?php echo ($equipo->guia_id != 0) ? 'SI' : 'NO'; ?></td>
              <td><?php echo $equipo->manual_url; ?></td>
              </tr>
            <?php } ?>
        </tbody>
      </table>


    <?php

    }
  }

  public function incluir()
  {
    $equipo = $this->Mequipos->getOne($_POST);
    if ($equipo->fecha_mantenimiento == '0000-00-00') {
      $_POST['plan'] = 3;
      $this->Mequipos->update($_POST);
    } else {
      $_POST['plan'] = 1;
      $this->Mequipos->update($_POST);
    }
  }

  public function excluir()
  {
    $_POST['plan'] = 2;
    $_POST['estado_mantenimiento'] = 0;
    $_POST['fecha_mantenimiento'] = '0000-00-00';

    $this->Mequipos->update($_POST);
  }

  public function ConsolidadoPreventivosBaxter()
  {
    $preventivos = $this->Mequipos->getMantenimientosAllBaxter();
    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('Preventivos');

    $contador = 1;
    // Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    // Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
    // Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Codigo Preventivo');
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Fecha Programada');
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Fecha de ejecución');
    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Marca');
    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Codigo');
    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Serie');
    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Nombre');
    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'ID');
    foreach ($preventivos as $preventivo) {
      $contador = $contador + 1;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", $preventivo->codigo);
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", $preventivo->fecha_programada);
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", $preventivo->fecha_ejecucion);
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", $preventivo->marca);
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", $preventivo->code);
      $this->excel->getActiveSheet()->setCellValue("F{$contador}", $preventivo->serial);
      $this->excel->getActiveSheet()->setCellValue("G{$contador}", $preventivo->name);
      $this->excel->getActiveSheet()->setCellValue("H{$contador}", $preventivo->id);
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ConsolidadoPreventivos.xls"');
    header('Cache-Control: max-age=0'); // no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    // Forzamos a la descarga
    ob_end_clean();
    $objWriter->save('php://output');
    $this->excel->disconnectWorksheets();
    unset($this->excel);
  }

  public function ConsolidadoCorrectivos()
  {
    $correctivos = $this->Mordenes->getCorrectivosAll();

    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('Correctivos');

    $contador = 1;
    // Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
    // Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("N{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("V{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("W{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("X{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("Y{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("Z{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AA{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AB{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AC{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("AD{$contador}")->getFont()->setBold(true);
    // Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Id Orden');
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Estado de la orden');
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Subproceso');
    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Proceso');
    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Diagnostico');
    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Información de Cierre');
    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha creación');
    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Fecha diagnostico');
    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Fecha asignación');
    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Fecha de cierre');
    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Descripcion');
    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Asunto');
    $this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Prioridad');
    $this->excel->getActiveSheet()->setCellValue("N{$contador}", 'Marca');
    $this->excel->getActiveSheet()->setCellValue("O{$contador}", 'Codigo');
    $this->excel->getActiveSheet()->setCellValue("P{$contador}", 'Serie');
    $this->excel->getActiveSheet()->setCellValue("Q{$contador}", 'Nombre');
    $this->excel->getActiveSheet()->setCellValue("R{$contador}", 'ID Equipo');
    $this->excel->getActiveSheet()->setCellValue("S{$contador}", 'Ubicacion');
    $this->excel->getActiveSheet()->setCellValue("T{$contador}", 'Nombre de usuario del reportante');
    $this->excel->getActiveSheet()->setCellValue("U{$contador}", 'Centro de costos del reportante');
    $this->excel->getActiveSheet()->setCellValue("V{$contador}", 'Usuario asignado');
    $this->excel->getActiveSheet()->setCellValue("W{$contador}", 'Usuario que diagnostica');
    $this->excel->getActiveSheet()->setCellValue("X{$contador}", 'Usuario que cierra');
    $this->excel->getActiveSheet()->setCellValue("Y{$contador}", 'Fecha solicitud repuesto');
    $this->excel->getActiveSheet()->setCellValue("Z{$contador}", 'Fecha recepcion repuesto');
    $this->excel->getActiveSheet()->setCellValue("AA{$contador}", 'Marca ingresada');
    $this->excel->getActiveSheet()->setCellValue("AB{$contador}", 'Codigo ingresado');
    $this->excel->getActiveSheet()->setCellValue("AC{$contador}", 'Serie ingresada');
    $this->excel->getActiveSheet()->setCellValue("AD{$contador}", 'Nombre ingresado');
    foreach ($correctivos as $correctivo) {
      $contador = $contador + 1;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", $correctivo->id);
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", $correctivo->estado);
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", $correctivo->subproceso);
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", $correctivo->proceso);
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", $correctivo->diagnostico);
      $this->excel->getActiveSheet()->setCellValue("F{$contador}", $correctivo->reparacion);
      $this->excel->getActiveSheet()->setCellValue("G{$contador}", $correctivo->fecha_inicio);
      $this->excel->getActiveSheet()->setCellValue("H{$contador}", $correctivo->fecha_diagnostico);
      $this->excel->getActiveSheet()->setCellValue("I{$contador}", $correctivo->fecha_asignacion);
      $this->excel->getActiveSheet()->setCellValue("J{$contador}", $correctivo->fecha_fin);
      $this->excel->getActiveSheet()->setCellValue("K{$contador}", $correctivo->descripcion);
      $this->excel->getActiveSheet()->setCellValue("L{$contador}", $correctivo->asunto);
      $this->excel->getActiveSheet()->setCellValue("M{$contador}", $correctivo->prioridad);
      $this->excel->getActiveSheet()->setCellValue("N{$contador}", $correctivo->equipo_marca);
      $this->excel->getActiveSheet()->setCellValue("O{$contador}", $correctivo->equipo_codigo);
      $this->excel->getActiveSheet()->setCellValue("P{$contador}", $correctivo->equipo_serie);
      $this->excel->getActiveSheet()->setCellValue("Q{$contador}", $correctivo->equipo_nombre);
      $this->excel->getActiveSheet()->setCellValue("R{$contador}", $correctivo->equipo_id);
      $this->excel->getActiveSheet()->setCellValue("S{$contador}", $correctivo->ubicacion);
      if ($correctivo->nombre_reportante != '' && $correctivo->nombre_reportante != null) {
        $this->excel->getActiveSheet()->setCellValue("T{$contador}", $correctivo->nombre_reportante);
        $this->excel->getActiveSheet()->setCellValue("U{$contador}", $correctivo->centro_costo_reportante);
      } else {
        $this->excel->getActiveSheet()->setCellValue("T{$contador}", $correctivo->username);
        $this->excel->getActiveSheet()->setCellValue("U{$contador}", $correctivo->centro);
      }
      $this->excel->getActiveSheet()->setCellValue("V{$contador}", $correctivo->asignado);
      $this->excel->getActiveSheet()->setCellValue("W{$contador}", $correctivo->diagnosticador);
      $this->excel->getActiveSheet()->setCellValue("X{$contador}", $correctivo->cerrador);
      $this->excel->getActiveSheet()->setCellValue("Y{$contador}", $correctivo->fecha_solicitud_repuesto);
      $this->excel->getActiveSheet()->setCellValue("Z{$contador}", $correctivo->fecha_recepcion_repuesto);
      $this->excel->getActiveSheet()->setCellValue("AA{$contador}", $correctivo->marca_equipo);
      $this->excel->getActiveSheet()->setCellValue("AB{$contador}", $correctivo->codigo_equipo);
      $this->excel->getActiveSheet()->setCellValue("AC{$contador}", $correctivo->serie_equipo);
      $this->excel->getActiveSheet()->setCellValue("AD{$contador}", $correctivo->nombre_equipo);
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ConsolidadoCorrectivos.xls"');
    header('Cache-Control: max-age=0'); // no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    // Forzamos a la descarga
    ob_end_clean();
    $objWriter->save('php://output');
    $this->excel->disconnectWorksheets();
    unset($this->excel);
  }

  public function ConsolidadoObsoletos()
  {
    $obsoletos = $this->Mequipos->getObsoletosModal();

    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('ObsoletosFecha');

    $contador = 1;
    // Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    // Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
    // Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Codigo antiguo');
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Fecha adquisición');
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Fecha instalacion');
    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Marca');
    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Codigo');
    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Serie');
    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Nombre');
    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'ID');
    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Años transcurridos');
    foreach ($obsoletos as $obsoleto) {
      $contador = $contador + 1;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", $obsoleto->codigo_antiguo);
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", $obsoleto->fecha_ad);
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", $obsoleto->fecha_instalacion);
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", $obsoleto->marca);
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", $obsoleto->code);
      $this->excel->getActiveSheet()->setCellValue("F{$contador}", $obsoleto->serial);
      $this->excel->getActiveSheet()->setCellValue("G{$contador}", $obsoleto->name);
      $this->excel->getActiveSheet()->setCellValue("H{$contador}", $obsoleto->id);
      $this->excel->getActiveSheet()->setCellValue("I{$contador}", $obsoleto->anios);
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ConsolidadoObsoletos.xls"');
    header('Cache-Control: max-age=0'); // no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    // Forzamos a la descarga
    ob_end_clean();
    $objWriter->save('php://output');
    $this->excel->disconnectWorksheets();
    unset($this->excel);
  }

  public function nombres_get_server_side()
  {
    $vector = $this->Mequipos->nombres_get_server_side($_POST);
    $respuesta = [
      'draw' => intval($this->input->post('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos'],
    ];
    echo json_encode($respuesta);
  }

  public function addMultipleCapacitaciones()
  {
    $config['upload_path'] = './assets/upload_equipo_archivos';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadEquipoArchivo');
    $this->uploadEquipoArchivo->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadEquipoArchivo->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadEquipoArchivo->data();
      $_POST['vinculo'] = $data['file_name'];
    }
    $_POST['created_at'] = $_POST['fecha_capacitacion'] . ' ' . $_POST['hora_capacitacion'];
    unset($_POST['fecha_capacitacion']);
    unset($_POST['hora_capacitacion']);

    if (isset($_POST['servicio_id'])) {
      unset($_POST['servicio_id']);
    }
    if (isset($_POST['area_id'])) {
      unset($_POST['area_id']);
    }

    if ($_POST['servicios'] == '') {
      $_POST['servicios'] = "''";
    }
    if ($_POST['areas'] == '') {
      $_POST['areas'] = "''";
    }

    $this->Mequipo_archivos->add_capacitaciones($_POST);
  }

  public function addMultipleEspecificaciones()
  {
    $this->Mequipo_especificaciones->add_especificaciones($_POST);
  }

  public function addMultipleImagenes()
  {
    $config['upload_path'] = './assets/upload_imagenes';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config, 'uploadImagen');
    $this->uploadImagen->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      $this->uploadImagen->do_upload('file'); // Esto sube el archivo
      $data = '';
      $data = $this->uploadImagen->data();
      $_POST['image'] = $data['file_name'];
    }

    $this->Mequipos->add_imagenes($_POST);
  }

  public function show_obsoletos()
  {
    $vector = [
      'obsoletos' => $this->Mequipos->getObsoletosModal(),
    ];
    $this->load->view('equipos/detail_obsoletos', $vector);
  }

  public function repuesto_pendiente_preventivo_true()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mpreventivos->repuesto_pendiente_true($_POST);
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_preventivo_false()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mpreventivos->repuesto_pendiente_false($_POST);
    $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_observaciones = $this->Mobservaciones->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $cantidad_ordenes = $this->Mordenes->cuenta_registros_repuestos_pendientes($equipo_id)->total;
    $suma = $cantidad_preventivos + $cantidad_correctivos_generales + $cantidad_observaciones + $cantidad_ordenes;
    if ($suma != 0) {
      $this->Mequipos->repuesto_pendiente_true($equipo_id);
    } else {
      $this->Mequipos->repuesto_pendiente_false($equipo_id);
    }
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_correctivo_general_true()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mcorrectivos_generales->repuesto_pendiente_true($_POST);
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
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_correctivo_general_false()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mcorrectivos_generales->repuesto_pendiente_false($_POST);
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
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_observacion_true()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mobservaciones->repuesto_pendiente_true($_POST);
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
    echo json_encode($equipo_id);
  }

  public function repuesto_pendiente_observacion_false()
  {
    $equipo_id = $_POST['equipo_id'];
    $this->Mobservaciones->repuesto_pendiente_false($_POST);
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
    echo json_encode($equipo_id);
  }

  public function show_invima_asociaciones()
  {
    $equipos_a_asociar = $this->Mequipos->get();
    $vector = [
      'equipos' => $equipos_a_asociar,
      'invima_id' => $_POST['invima_id'],
    ];
    $this->load->view('equipos/modal_asociacion_invima_detail', $vector);
  }

  public function update_multiples_invimas()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_invimas($equipo_id, $_POST['invima_id']);
      }
      echo json_encode('El registro sanitario fue asociado exitosamente a los equipos seleccionados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function update_multiples_invimas_eliminar()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_invimas_eliminar($equipo_id, $_POST['invima_id']);
      }
      echo json_encode('Los equipos seleccionados vinculados al registro sanitario fueron desvinculados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function show_equipos_en_invima()
  {
    $equipos = $this->Mequipos->getEquiposEnInvima($_POST);
    $vector = [
      'equipos' => $equipos,
      'invima_id' => $_POST['invima_id'],
    ];
    $this->load->view('equipos/modal_asociacion_invima_detail_especifico', $vector);
  }

  public function show_orden_compra_asociaciones()
  {
    $equipos_a_asociar = $this->Mequipos->getPorCompra();

    $vector = [
      'equipos' => $equipos_a_asociar,
      'orden_compra_id' => $_POST['orden_compra_id'],
    ];
    $this->load->view('equipos/modal_asociacion_orden_compra_detail', $vector);
  }

  public function show_equipos_en_orden_compra()
  {
    $equipos = $this->Mequipos->getEquiposEnOrdenCompra($_POST);
    $vector = [
      'equipos' => $equipos,
      'orden_compra_id' => $_POST['orden_compra_id'],
    ];
    $this->load->view('equipos/modal_asociacion_orden_compra_especifico_detail', $vector);
  }

  /* Informacion procedente desde el modulo de invimas, sirve para asociar varios equipos al tiempo con una orden de compra, llega un post con vector de checkbox */
  public function update_multiples_ordenes_compra()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_ordenes_compra($equipo_id, $_POST['orden_compra_id']);
      }
      echo json_encode('El soporte de compra fue asociado con exito a los equipos seleccionados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function update_multiples_ordenes_compra_eliminar()
  {
    if (isset($_POST['seleccion'])) {
      $equipos_seleccionados = $_POST['seleccion'];
      foreach ($equipos_seleccionados as $equipo_id) {
        $this->Mequipos->update_multiples_ordenes_compra_eliminar($equipo_id, $_POST['orden_compra_id']);
      }
      echo json_encode('El soporte de compra fue eliminado con exito de los equipos seleccionados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function show_listado()
  {
    $equipos = $this->Mequipos->get_equipos_for_ticket();
    // $vector=array("equipos"=>$equipos);
    $this->load->view('ordenes/modal_listado_biomedicos');
  }

  public function get_general_server_side()
  {
    if (isset($_POST)) {
      if (isset($_POST['start'])) {
        $vector = $this->Mequipos->get_general_server_side($_POST);
        $respuesta = [
          'draw' => intval($this->input->post('draw')),
          'recordsTotal' => $vector['num_filas_limit'],
          'recordsFiltered' => $vector['num_filas'],
          'data' => $vector['datos'],
        ];
        echo json_encode($respuesta);
      }
    }
  }

  public function show_compartir_especificaciones()
  {
    $equipos = $this->Mequipos->get_general($_POST['equipo_origen_id']);
    $vector = [
      'equipos' => $equipos,
      'equipo_origen_id' => $_POST['equipo_origen_id'],
    ];
    $this->load->view('equipos/detalle_listado_compartir_especificaciones', $vector);
  }

  public function update_especificaciones_tecnicas()
  {
    $equipo_origen_id = $_POST['equipo_origen_id'];
    if (isset($_POST['creado'])) { // Seleccion tiene los id de los equipos objetivo
      $equipos_objetivos_id = $_POST['creado'];

      foreach ($equipos_objetivos_id as $equipo_objetivo_id) {
        $vector_eliminar = [
          'id' => $equipo_objetivo_id,
        ];
        $this->Mequipo_especificaciones->delete_multiple($vector_eliminar); // Se eliminan las especificaciones del equipo objetivo
        $vector_actualizar = [
          'equipo_objetivo_id' => $equipo_objetivo_id,
          'equipo_origen_id' => $equipo_origen_id,
        ];
        $this->Mequipo_especificaciones->update_especificaciones_tecnicas($vector_actualizar);

        $vector_eliminar = '';
        $vector_actualizar = '';
      }
      echo json_encode('Las especificaciones tecnicas fueron asociadas exitosamente a los equipos referenciados');
    } else {
      echo json_encode('No se seleccionaron equipos');
    }
  }

  public function show_compartir_archivos()
  {
    $equipos = $this->Mequipos->get_para_copiar_archivos($_POST['equipo_archivo_origen_id']);
    $vector = [
      'equipos' => $equipos,
      'equipo_archivo_origen_id' => $_POST['equipo_archivo_origen_id'],
    ];
    $this->load->view('equipos/detalle_listado_compartir_archivos', $vector);
  }

  public function update_archivos()
  {
    $equipo_archivo_origen_id = $_POST['equipo_archivo_origen_id'];
    if ($_POST['control'] == 1) { // Si estan todos chekeados
      $equipos_objetivos_id = $_POST['seleccion']; // vector es seleccion
      foreach ($equipos_objetivos_id as $equipo_objetivo_id) {
        $vector_actualizar = [
          'equipo_objetivo_id' => $equipo_objetivo_id,
          'equipo_archivo_origen_id' => $equipo_archivo_origen_id,
        ];
        $this->Mequipo_archivos->update_archivos($vector_actualizar);
        $vector_actualizar = '';
      }
      echo json_encode('El archivo fue asociado exitosamente a los equipos referenciados');
    } else {
      if (isset($_POST['creado'])) { // vector es creado
        $equipos_objetivos_id = $_POST['creado'];

        foreach ($equipos_objetivos_id as $equipo_objetivo_id) {
          $vector_actualizar = [
            'equipo_objetivo_id' => $equipo_objetivo_id,
            'equipo_archivo_origen_id' => $equipo_archivo_origen_id,
          ];
          $this->Mequipo_archivos->update_archivos($vector_actualizar);
          $vector_actualizar = '';
        }
        echo json_encode('El archivo fue asociado exitosamente a los equipos referenciados');
      } else {
        echo json_encode('No se seleccionaron equipos');
      }
    }
  }

  public function VerificarEstadoMantenimiento()
  {
    $equipo_id = $_POST['equipo_id'];
    $equipo = $this->Mequipos->getOne(['id' => $equipo_id]);
    $frecuencia_mantenimiento = $equipo->frecuencia_id;

    $this->Mequipos->ActualizarEstadoMantenimiento(['equipo_id' => $equipo_id, 'frecuencia_mantenimiento' => $frecuencia_mantenimiento]);
  }

  public function VerificarEstadoMantenimiento2()
  {
    $equipo_id = $_POST['equipo_id'];
    $equipo = $this->Mequipos->getOne(['id' => $equipo_id]);

    $this->Mequipos->ActualizarEstadoMantenimiento2(['equipo_id' => $equipo_id]);
  }

  public function ObtenerListadoNombreEquipos()
  {
    echo json_encode($this->Mequipos->ObtenerListadoNombreEquipos());
  }

  public function ObtenerListadoModeloEquipos()
  {
    echo json_encode($this->Mequipos->ObtenerListadoModeloEquipos());
  }

  public function ObtenerListadoMarcaEquipos()
  {
    echo json_encode($this->Mequipos->ObtenerListadoMarcaEquipos());
  }

  public function getByAdquisicion()
  {
    $fecha = explode(' - ', $_POST['rango_fechas']);
    unset($_POST['rango_fechas']);
    $_POST['inicial'] = $fecha[0];
    $_POST['final'] = $fecha[1];

    $response = $this->Mequipos->getByAdquisicion($_POST);
    $additionalData = [
      'inversion' => $this->Mequipos->inversionAdquisicion($_POST)->inversion,
      'listado' => $this->Mequipos->listadoAdquisicion($_POST),
      'riesgos' => $this->Mequipos->riesgoAdquisicion($_POST),
      'tipos_adquisicion' => $this->Mequipos->tipoAdquisicionFromAdquisicion($_POST),
      'clasificaciones' => $this->Mequipos->clasificacionFromAdquisicion($_POST),
      'fuentes' => $this->Mequipos->fuenteFromAdquisicion($_POST),
    ];

    $this->load->view('equipos/modal_detail_adquisicion', array_merge($_POST, $response, $additionalData));
  }

  public function getByInstalacion()
  {
    $fecha = explode(' - ', $_POST['rango_fechas']);
    unset($_POST['rango_fechas']);
    $_POST['inicial'] = $fecha[0];
    $_POST['final'] = $fecha[1];
    $respuesta = $this->Mequipos->getByInstalacion($_POST);
    $inversion = $this->Mequipos->inversionInstalacion($_POST);
    $listado = $this->Mequipos->listadoInstalacion($_POST);
    $riesgos = $this->Mequipos->riesgoInstalacion($_POST);
    $tipos_adquisicion = $this->Mequipos->tipoAdquisicionFromInstalacion($_POST);
    $clasificaciones = $this->Mequipos->clasificacionFromInstalacion($_POST);
    $fuentes = $this->Mequipos->fuenteFromInstalacion($_POST);
    $equipos = $respuesta['equipos'];
    $cantidad = $respuesta['cantidad'];
    $this->load->view('equipos/modal_detail_instalacion', [
      'vector' => $_POST,
      'equipos' => $equipos,
      'cantidad' => $cantidad,
      'inversion' => $inversion->inversion,
      'listado' => $listado,
      'riesgos' => $riesgos,
      'tipos_adquisicion' => $tipos_adquisicion,
      'clasificaciones' => $clasificaciones,
      'fuentes' => $fuentes,
    ]);
  }

  public function consultarId()
  {
    echo json_encode($this->Mequipos->getOneWithTipe(['id' => $_POST['id']]));
  }

  public function listado_detalle_por_nombre_equipo()
  {
    echo json_encode($this->Mequipos->listado_detalle_por_nombre_equipo($_POST));
  }

  public function get_listado_nombres_equipos()
  {
    $this->load->view('equipos/modal_depurar_nombres_detail', ['listado' => $this->Mequipos->get_listado_nombres_equipos()]);
  }

  public function update_name_from_depuracion()
  {
    if (isset($_POST['seleccion'])) {
      $seleccion = $_POST['seleccion'];
      $seleccionados = '';
      $contador = 0;
      foreach ($seleccion as $row) {
        $contador = $contador + 1;
        if ($contador == sizeof($seleccion)) {
          $seleccionados .= "'" . $row . "'";
        } else {
          $seleccionados .= "'" . $row . "',";
        }
      }
      $_POST['seleccionados'] = $seleccionados;
      $this->Mequipos->update_name_from_depuracion($_POST);
      echo 1;
    } else {
      echo 2;
    }
  }

  public function get_listado_industriales()
  {
    echo json_encode($this->Mequipos->get_listado_industriales());
  }

  public function Exportar_cantidades()
  {
    header('Content-Type:application/xls;charset=utf-8');
    header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
    header('Content-Disposition: attachment;filename=CantidadesEquiposBiomedicos.xls');
    $cantidades = $this->Mequipos->getCantidades();
    ?>
    <h2>Cantidades equipos biomedicos</h3>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <table border="2">
        <thead>

          <tr>
            <th>Cantidad registrada</th>
            <th>Fecha registro</th>
            <th>Total sede norte</th>
            <th>Total sede principal</th>
            <th>Total sede principal activos</th>
            <th>Total sede norte activos</th>
            <th>Total sede principal fuera de servicio</th>
            <th>Total sede norte fuera de servicio</th>
            <th>Total sede principal dados de baja</th>
            <th>Total sede norte dados de baja</th>
            <th>Total sede principal pendientes de dar de baja</th>
            <th>Total sede norte pendientes de dar de baja</th>
            <th>Total sede principal con repuesto pendiente activos</th>
            <th>Total sede norte con repuesto pendiente activos</th>
            <th>Total sede principal con repuesto pendiente fuera de servicio</th>
            <th>Total sede norte con repuesto pendiente fuera de servicio</th>
            <th>Total sede principal pendiente por entregar</th>
            <th>Total sede norte pendiente por entregar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cantidades as $cantidad) { ?>
            <tr>
              <td> <?php echo $cantidad->cantidad; ?> </td>
              <td> <?php echo $cantidad->fecha; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_pendiente_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_pendiente_baja; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_repuesto_pendiente_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_repuesto_pendiente_activos; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_repuesto_pendiente_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_repuesto_pendiente_fuera_de_servicio; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_principal_pendiente_entregar; ?> </td>
              <td> <?php echo $cantidad->cantidad_sede_norte_pendiente_entregar; ?> </td>
            </tr>
          <?php } ?>
        </tbody>

      </table>
  <?php
  }
}
  ?>