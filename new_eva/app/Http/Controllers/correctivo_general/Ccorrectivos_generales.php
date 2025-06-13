<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Ccorrectivos_generales extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library("email");
		$this->load->model('Mequipos');
		$this->load->model('Mcorrectivos_generales');
		$this->load->model('Mcorrectivos_generales_archivos');
		$this->load->model('Mordenes');
		$this->load->model('Mpreventivos');
		$this->load->model('Mavances_correctivos');
		$this->load->model('Mservicios');
		$this->load->model('Mzonas');
		$this->load->model('Mequipo_repuestos');
		$this->load->model('Mcambios_hdv');
		$this->load->model('Mrepuestos_ti');
		$this->load->model('Mrepuestos_pendientes');
	}
	public function index()
	{
	}
	public function get()
	{
		echo json_encode($this->Mcorrectivos_generales->get($_POST));
	}
	public function getAll()
	{
	}
	public function getOne()
	{
		echo json_encode($this->Mcorrectivos_generales->getOne($_POST));
	}
	public function add()
	{
		if (isset($_POST["lista_repuestos_pendientes"])) {
			$lista_repuestos_pendientes = $_POST["lista_repuestos_pendientes"];
			unset($_POST["lista_repuestos_pendientes"]);
		}

		#Subida de archivo de repuesto instalado, cuando se ingresa un correctivo general
		$config['upload_path'] = "./assets/upload_equipo_repuestos";
		$config['allowed_types'] = '*';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config, 'uploadequiporepuesto');
		$this->uploadequiporepuesto->initialize($config);
		if (!empty($_FILES["file_repuesto_instalado"]["name"])) {
			$this->uploadequiporepuesto->do_upload("file_repuesto_instalado"); //Esto sube el archivo
			$data = "";
			$data = $this->uploadequiporepuesto->data();
			$_POST["file_repuesto_instalado"] = $data["file_name"];
		} else {
			$_POST["file_repuesto_instalado"] = null;
		}
		if ($_POST["repuesto_id_instalado"] != "" && $_POST["repuesto_id_instalado"] != null) {
			$vector_repuesto_instalado = array(
				"repuesto_id" => $_POST["repuesto_id_instalado"],
				"equipo_id" => $_POST["equipo_id"],
				"cantidad_entregada" => $_POST["cantidad_entregada"],
				"fecha" => $_POST["fecha"],
				"file" => $_POST["file_repuesto_instalado"],
				"observacion" => $_POST["observacion"],
				"usuario_id" => $this->session->userdata("id")
			);
			$this->Mequipo_repuestos->add($vector_repuesto_instalado);
		}
		#Ya se agrego a equipo repuesto, se aplica unset para no afectar a la logica del correctivo general
		if (isset($_POST["repuesto_id_instalado"])) {
			unset($_POST["repuesto_id_instalado"]);
		}
		if (isset($_POST["cantidad_entregada"])) {
			unset($_POST["cantidad_entregada"]);
		}
		if (isset($_POST["fecha"])) {
			unset($_POST["fecha"]);
		}
		if (isset($_POST["observacion"])) {
			unset($_POST["observacion"]);
		}
		unset($_POST["file_repuesto_instalado"]);
		#Subida de archivo de correctivo general
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
		if (isset($_POST["fecha_inicio"])) {
			$_POST["fecha_inicio"] = $_POST["fecha_inicio"] . " " . $_POST["hora_orden"];
			unset($_POST["hora_orden"]);
		}
		if (isset($_POST["fecha_diagnostico"])) {
			$_POST["fecha_diagnostico"] = $_POST["fecha_diagnostico"] . " " . $_POST["hora_diagnostico"];
			unset($_POST["hora_diagnostico"]);
		}
		if (isset($_POST["fecha_mantenimiento"])) {
			$_POST["fecha_mantenimiento"] = $_POST["fecha_mantenimiento"] . " " . $_POST["hora_mantenimiento"];
			unset($_POST["hora_mantenimiento"]);
		}
		$titulo = $_POST["titulo"];
		unset($_POST["titulo"]);
		if ($_POST["repuesto_id"] != "" && $_POST["repuesto_id"] != null) {
			$_POST["repuesto_pendiente"] = "si";
			$vector_actualizacion_equipo = array(

				"id" => $_POST["equipo_id"],
				"repuesto_pendiente" => "si"
			);
			$this->Mequipos->update($vector_actualizacion_equipo); // Se actualiza el equipo indicando que tiene un repuesto pendiente
		} else {
			unset($_POST["repuesto_id"]);
		}
		/*Logica para ingresar avance*/
		$existe_descripcion = "";

		if (isset($_POST["descripcion_avance"]) && ($_POST["descripcion_avance"] != "")) {
			$existe_descripcion = "si";
			$vector_avance_correctivo = array(
				"description" => $_POST["descripcion_avance"],
				"date" => $_POST["fecha_avance"],
				"title" => $_POST["titulo_avance"],
				"usuario_id" => $this->session->userdata("id")
			);
			if (isset($_POST["file"])) {
				$vector_avance_correctivo["file"] = $_POST["file"];
			} else {
				$vector_avance_correctivo["file"] = "";
			}
			unset($_POST["descripcion_avance"]);
		}
		if (isset($_POST["fecha_avance"])) {
			unset($_POST["fecha_avance"]);
		}
		if (isset($_POST["titulo_avance"])) {
			unset($_POST["titulo_avance"]);
		}
		if (isset($_POST["descripcion_avance"])) {
			unset($_POST["descripcion_avance"]);
		}
		if (isset($_POST["lista_repuestos_pendientes"])) {
			unset($_POST["lista_repuestos_pendientes"]);
		}

		$ultimo_id = $this->Mcorrectivos_generales->add($_POST); //Agrego el correctivo y mantengo su id
		# Implementing adding multiple rp
		if (isset($lista_repuestos_pendientes)) {
			foreach ($lista_repuestos_pendientes as $repuesto_pendiente) {
				$this->Mrepuestos_pendientes->add(
					array(
						"correctivo_general_id" => $ultimo_id,
						"name" => $repuesto_pendiente
					)
				);
			}
		}
		if ($existe_descripcion == "si") {
			$vector_avance_correctivo["correctivo_general_id"] = $ultimo_id; // se entrega el id del correctivo para guardar el avance
			$this->Mavances_correctivos->add($vector_avance_correctivo);
		}
		$descripcion_historial = "Se agrega correctivo general con ID = " . $this->Mcorrectivos_generales->getOne(array("id" => $ultimo_id))->id;
		$vector_cambios_hdv = array(
			"descripcion" => $descripcion_historial,
			"usuario_id" => $this->session->userdata("id"),
			"equipo_id" => $this->Mcorrectivos_generales->getOne(array("id" => $ultimo_id))->equipo_id
		);
		$this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
		if (isset($_POST["file"])) {
			$vector = array(
				"file" => $_POST["file"],
				"correctivo_general_id" => $ultimo_id,
				"titulo" => $titulo
			);
			$this->Mcorrectivos_generales_archivos->add($vector);
		} else {
		}
		$vector_respuesta = array(
			"correctivo_general_id" => $ultimo_id,
			"equipo_id" => $_POST["equipo_id"]
		);
		if (isset($vector_actualizacion_equipo)) {
			$vector_respuesta["repuesto_pendiente"] = $_POST["repuesto_id"];
		}
		echo json_encode($vector_respuesta);
	}
	public function send_email_correctivo_general()
	{

		$equipo = $this->Mequipos->getOne(array("id" => $_POST["equipo_id"]));
		$correctivo_general = $this->Mcorrectivos_generales->getOne(array("id" => $_POST["correctivo_general_id"]));
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
			$this->email->subject("Notificación de repuesto pendiente. ID orden:" . $correctivo_general->id);
			$vector_correo = array(
				"equipo" => $equipo,
				"correctivo_general" => $correctivo_general,
				"correos" => $correos,
				"servicio" => $servicio
			);
			$msj = $this->load->view("correctivos_generales/email/email_add_correctivo_general", $vector_correo, TRUE); //Vista

			$this->email->message($msj);
			$this->email->send();
		}
	}
	public function update()
	{
		# Implementing adding multiple rp
		if (isset($_POST["lista_repuestos_pendientes"])) {
			foreach ($_POST["lista_repuestos_pendientes"] as $repuesto_pendiente) {
				$this->Mrepuestos_pendientes->add(
					array(
						"correctivo_general_id" => $_POST["id"],
						"name" => $repuesto_pendiente
					)
				);
			}
			unset($_POST["lista_repuestos_pendientes"]);
		}
		$correctivo_general_id = $_POST["id"];
		$correctivo_general_antiguo = $this->Mcorrectivos_generales->getOne(array("id" => $correctivo_general_id));
		$titulo = $_POST["titulo"];
		unset($_POST["titulo"]);
		if (isset($_POST["fecha_inicio"])) {
			$_POST["fecha_inicio"] = $_POST["fecha_inicio"] . " " . $_POST["hora_orden"];
			unset($_POST["hora_orden"]);
		}
		if (isset($_POST["fecha_diagnostico"])) {
			$_POST["fecha_diagnostico"] = $_POST["fecha_diagnostico"] . " " . $_POST["hora_diagnostico"];
			unset($_POST["hora_diagnostico"]);
		}
		if (isset($_POST["fecha_mantenimiento"])) {
			$_POST["fecha_mantenimiento"] = $_POST["fecha_mantenimiento"] . " " . $_POST["hora_mantenimiento"];
			unset($_POST["hora_mantenimiento"]);
		}
		unset($_POST["repuesto_pendiente"]);
		$cambio = "no";
		if ($_POST["repuesto_id"] != $correctivo_general_antiguo->repuesto_id) { // Hubo un cambio en el repuesto pendiente
			$cambio = "si";
		}
		if ($_POST["repuesto_id"] == "" || $_POST["repuesto_id"] == null) {
			$cambio = "no";
		}
		$this->Mcorrectivos_generales->update($_POST);
		////////////////////////////////////////////////////////////////////////////////
		$descripcion_historial = "Se edita correctivo general con ID = " . $correctivo_general_id;
		$vector_cambios_hdv = array(
			"descripcion" => $descripcion_historial,
			"usuario_id" => $this->session->userdata("id"),
			"equipo_id" => $_POST["equipo_id"]
		);
		$this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
		////////////////////////////////////////////////////////////////////////////////    	
		$vector_respuesta = array(
			"equipo_id" => $_POST["equipo_id"],
			"correctivo_general_id" => $correctivo_general_id,
			"cambio" => $cambio,
			"actual" => $_POST["repuesto_id"],
			"antiguo" => $correctivo_general_antiguo->repuesto_id
		);
		// En caso de enviarse un archivo
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
		if (isset($_POST["file"])) {
			$vector = array(
				"file" => $_POST["file"],
				"correctivo_general_id" => $correctivo_general_id,
				"titulo" => $titulo
			);
			$this->Mcorrectivos_generales_archivos->add($vector);
		}
		echo json_encode($vector_respuesta);
	}
	public function delete()
	{
		$this->load->helper("file");
		$resultados = $this->Mcorrectivos_generales_archivos->getAll($_POST);
		foreach ($resultados as $resultado) {
			if ($this->Mcorrectivos_generales_archivos->delete($resultado->id)) {
				unlink("./assets/upload_correctivos_generales/" . $resultado->file);
			}
		}
		$correctivo_general = $this->Mcorrectivos_generales->getOne(array("id" => $_POST["id"]));
		$this->Mcorrectivos_generales->delete($_POST);
		////////////////////////////////////////////////////////////////////////////////
		$descripcion_historial = "Se elimina correctivo general con ID = " . $correctivo_general->id;
		$vector_cambios_hdv = array(
			"descripcion" => $descripcion_historial,
			"usuario_id" => $this->session->userdata("id"),
			"equipo_id" => $correctivo_general->equipo_id
		);
		$this->Mcambios_hdv->add($vector_cambios_hdv); // Se inserta el registro de cambio de HDV
		////////////////////////////////////////////////////////////////////////////////    	
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
	public function show()
	{
		$vector = array(
			'correctivos' => $this->Mcorrectivos_generales->getCorrectivosModal()
		);
		$this->load->view("correctivos_generales/detail", $vector);
	}
	public function show_one()
	{
		$_POST["correctivo_general_id"] = $_POST["id"];
		$vector = array(
			"correctivo" => $this->Mcorrectivos_generales->getOne($_POST),
			"avances" => $this->Mavances_correctivos->GetByDevice($_POST),
			"archivos" => $this->Mcorrectivos_generales_archivos->get($_POST)
		);
		$this->load->view("correctivos_generales/detail_single", $vector);
	}
	public function show_correctivos_generales_abiertos()
	{
		$this->load->view("correctivos_generales/detalle/detalle_correctivos_generales_abiertos");
	}
	public function get_datatable_server_side_correctivos_generales_abiertos()
	{
		if (isset($_POST)) {
			if (isset($_POST['start'])) {
				$vector = $this->Mcorrectivos_generales->get_correctivos_generales_abiertos_server_side($_POST);
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
	public function get_repuestos_pendientes()
	{
		if (isset($_POST)) {
			$listado = $this->Mrepuestos_pendientes->getAll($_POST);
			echo json_encode($listado);
		}
	}
	public function toggle_state_repuesto_pendiente()
	{
		$this->Mrepuestos_pendientes->toggle_state_repuesto_pendiente($_POST);
		$repuesto_pendiente = $this->Mrepuestos_pendientes->getOne($_POST);
		echo json_encode($repuesto_pendiente);
	}
	public function ExportarExcel()
	{
		header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		header('Content-Disposition: attachment;filename=CorrectivosEB.xls');
		$correctivos_generales = $this->Mcorrectivos_generales->getCorrectivosModal();
		$tickets = $this->Mordenes->getOrdenesForCorrectivos();
?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<table border="1">
			<thead>
				<tr>
					<th>Fuente</th>
					<th>Responsable del mantenimiento</th>
					<th>Equipo Id</th>
					<th>Fecha de creación de la orden</th>
					<th>Codigo de orden de trabajo</th>
					<th>Descripcion de la orden</th>
					<th>Codificación de cierre</th>
					<th>Equipo</th>
					<th>Codigo Equipo</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Serie</th>
					<th>Estado actual del equipo</th>
					<th>Sede</th>
					<th>Servicio</th>
					<th>Area</th>
					<th>Archivo</th>
					<th>Fecha avance</th>
					<th>Titulo/Retro Avance1</th>
					<th>Descripcion avance</th>
					<th>Fecha avance2</th>
					<th>Titulo/Retro Avance2</th>
					<th>Descripcion avance2</th>
					<th>Fecha avance3</th>
					<th>Titulo/Retro Avance3</th>
					<th>Descripcion avance3</th>
					<th>Retro de cierre</th>
					<th>Descripcion de Cierre</th>
					<th>Fecha de Cierre</th>
					<th>Costo del equipo</th>
					<th>Fecha fin</th>
					<th>Repuesto instalado</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($correctivos_generales as $correctivo) : ?>
					<tr>
						<td>Correctivos generales</td>
						<td><?php echo $correctivo->responsable_mantenimiento; ?></td>
						<td><?php echo $correctivo->equipo_id ?></td>
						<td><?php echo $correctivo->fecha_inicio; ?></td>
						<td><?php echo $correctivo->code_orden; ?></td>
						<td><?php echo $correctivo->orden; ?></td>
						<td>
							<?php if ($correctivo->code_orden != "" && $correctivo->code_orden != null) : ?>

								<!-- 								<?php if (($correctivo->descripcion == "" || $correctivo->descripcion == null) && ($correctivo->codigo_correctivo == "" || $correctivo->codigo_correctivo == null) && ($correctivo->fecha_ejecucion == '' || $correctivo->fecha_ejecucion == null)) : ?>
								<?php else : ?>
										<?php echo $correctivo->codificacion; ?>
									<?php echo $correctivo->descripcion_codificacion; ?>
									<?php endif ?> -->
								<?php echo $correctivo->descripcion_codificacion; ?>
							<?php else : ?>
								<span>Sin Info de orden de trabajo</span>
							<?php endif ?>
						</td>
						<td><?php echo $correctivo->equipo; ?></td>
						<td><?php echo $correctivo->code; ?></td>
						<td><?php echo $correctivo->marca; ?></td>
						<td><?php echo $correctivo->modelo; ?></td>
						<td>SN:&nbsp; <?php echo $correctivo->serial; ?></td>
						<?php if ($correctivo->estado_equipo != null) : ?>
							<td><?php echo $correctivo->estado_equipo; ?></td>
						<?php else : ?>
							<td></td>
						<?php endif ?>
						<td><?php echo $correctivo->sede; ?></td>
						<td><?php echo $correctivo->ubicacion; ?></td>
						<td><?php echo $correctivo->area; ?></td>
						<?php if ($correctivo->archivo != "" && $correctivo->archivo != null) : ?>
							<td><?php echo "<a target='__blank' class='glyphicon glyphicon-file' href='" . base_url() . "assets/upload_correctivos_generales/" . $correctivo->archivo . "'></a>"; ?></td>
						<?php else : ?>
							<td></td>
						<?php endif ?>
						<td><?php echo $correctivo->avance_fecha; ?></td>
						<td><?php echo $correctivo->avance_titulo ?></td>
						<td><?php echo $correctivo->avance_descripcion; ?></td>
						<td><?php echo $correctivo->avance_fecha2; ?></td>
						<td><?php echo $correctivo->avance_titulo2 ?></td>
						<td><?php echo $correctivo->avance_descripcion2; ?></td>
						<td><?php echo $correctivo->avance_fecha3; ?></td>
						<td><?php echo $correctivo->avance_titulo3 ?></td>
						<td><?php echo $correctivo->avance_descripcion3; ?></td>
						<td><?php echo $correctivo->codigo_correctivo; ?></td>
						<td><?php echo $correctivo->descripcion; ?></td>
						<td><?php echo $correctivo->fecha_ejecucion; ?></td>
						<td><?php echo $correctivo->costo; ?></td>
						<td></td>
						<td></td>
					</tr>
				<?php endforeach ?>
				<?php foreach ($tickets as $ticket) : ?>
					<tr>
						<td>Tickets
							<?php if ($ticket->equipo_id == "" || $ticket->equipo_id == NULL || $ticket->equipo_id == 0 || $ticket->equipo_id == null) : ?>
								(Equipo ingresado de forma manual)
							<?php endif ?>
						</td>
						<td><?php echo $ticket->responsable_mantenimiento; ?></td>
						<td><?php echo $ticket->equipo_id; ?></td>
						<td><?php echo $ticket->fecha_inicio; ?></td>
						<td><?php echo $ticket->id; ?></td>
						<td><?php echo $ticket->descripcion; ?></td>
						<?php if ($ticket->codigo_cierre == null) : ?>
							<td><?php echo $ticket->estado; ?> </td>
						<?php else : ?>
							<td>(<?php echo $ticket->codigo_cierre ?>) <?php echo $ticket->significado_cierre; ?></td>
						<?php endif ?>

						<?php if ($ticket->equipo_id == "" || $ticket->equipo_id == NULL || $ticket->equipo_id == 0 || $ticket->equipo_id == null) : ?>
							<!--Sin equipo vinculado-->
							<td><?php echo $ticket->nombre_equipo; ?></td>
							<td><?php echo $ticket->codigo_equipo; ?></td>
							<td><?php echo $ticket->marca_equipo; ?></td>
							<td><?php echo $ticket->modelo_equipo; ?></td>
							<td>SN:&nbsp; <?php echo $ticket->serie_equipo; ?></td>
							<td>No vinculado</td>
						<?php else : ?>
							<!--con equipo vinculador-->
							<td><?php echo $ticket->equipo; ?></td>
							<td><?php echo $ticket->code; ?></td>
							<td><?php echo $ticket->marca; ?></td>
							<td><?php echo $ticket->modelo; ?></td>
							<td>SN:&nbsp; <?php echo $ticket->serie; ?></td>
							<?php if ($ticket->estado_equipo != null) : ?>
								<td><?php echo $ticket->estado_equipo ?></td>
							<?php else : ?>
								<td></td>
							<?php endif ?>
						<?php endif ?>
						<td><?php echo $ticket->sede; ?></td>
						<td><?php echo $ticket->servicio; ?></td>
						<td><?php echo $ticket->area; ?></td>
						<td></td>
						<!--avances-->
						<td><?php echo $ticket->avance_fecha; ?></td>
						<td><?php echo $ticket->avance_titulo ?></td>
						<td><?php echo $ticket->avance_descripcion; ?></td>
						<td><?php echo $ticket->avance_fecha2; ?></td>
						<td><?php echo $ticket->avance_titulo2 ?></td>
						<td><?php echo $ticket->avance_descripcion2; ?></td>
						<td><?php echo $ticket->avance_fecha3; ?></td>
						<td><?php echo $ticket->avance_titulo3 ?></td>
						<td><?php echo $ticket->avance_descripcion3; ?></td>
						<td><?php echo $ticket->retro_cierre . "\n"; ?>
							<?php if ($ticket->retro_diagnostico != "" && $ticket->retro_diagnostico != NULL) : ?>
								<!--||Retro diagnostico: <?php echo $ticket->retro_diagnostico; ?>-->
							<?php endif ?>
						</td>
						<td><?php echo $ticket->reparacion; ?></td>
						<td><?php echo $ticket->fecha_asignacion_cierre; ?></td>
						<td><?php echo $ticket->costo; ?></td>
						<td><?php echo $ticket->fecha_fin; ?></td>
						<td><?php if($ticket->repuesto_pendiente_condicion == 'no') echo $ticket->repuesto_pendiente; ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
<?php
	}
}
?>