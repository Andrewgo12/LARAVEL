<?php
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
*
*/
class Crepuestos extends CI_Controller
{
	private $repuestos;
	function __construct()
	{
		parent::__construct();
		$this->load->model("Mrepuestos");
		$this->load->model("Mequipo_repuestos");
		$this->load->model("Mmovimientos");
		// $this->permisos=$this->backend_lib->control();
	}
	public function index(){
		if($this->session->userdata('login')){

		}else{
			redirect(base_url('Cauth'));
		}
		$acciones=$this->session->userdata("acciones");
		$this->session->set_userdata('controlador', $this->uri->segment(2));
		foreach ($acciones as $accion) {
			if ($accion->modulo=="repuestos") {
				if ($accion->leer!=1) {
					redirect(base_url('Forbidden'));
				}
			}
		}

		$repuestos_instalados=$this->Mequipo_repuestos->getAll();
		$repuestos_pendientes_por_correctivos=$this->Mequipo_repuestos->getPendientesPorCorrectivos();
		$repuestos_pendientes_por_preventivos=$this->Mequipo_repuestos->getPendientesPorPreventivos();
		$repuestos_pendientes_por_observaciones=$this->Mequipo_repuestos->getPendientesPorObservaciones();
		$consolidado_anio_mes=$this->Mequipo_repuestos->getCOnsolidadoAnioMes();
		$consolidado_anio_mes_general=$this->Mequipo_repuestos->getCOnsolidadoAnioMesGeneral();
		$vector_repuestos=array(
			"repuestos_instalados"=>$repuestos_instalados,
			"repuestos_pendientes_por_correctivos"=>$repuestos_pendientes_por_correctivos,
			"repuestos_pendientes_por_preventivos"=>$repuestos_pendientes_por_preventivos,
			"repuestos_pendientes_por_observaciones"=>$repuestos_pendientes_por_observaciones,
			"consolidado_anio_mes"=>$consolidado_anio_mes,
			"consolidado_anio_mes_general"=>$consolidado_anio_mes_general
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("repuestos/list",$vector_repuestos);
		$this->load->view("repuestos/modal_show_movimientos");
		$this->load->view("repuestos/modal_show");
		$this->load->view("layouts/footer");
	}

	public function excel_repuestos_pendientes(){
		if (isset($_POST)) {

			header('Content-Type:application/xls;charset=utf-8');
			header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
			header('Content-Disposition: attachment;filename=RepuestosPendientes.xls');
			$repuestos_pendientes_por_correctivos=$this->Mequipo_repuestos->getPendientesPorCorrectivos();
			$repuestos_pendientes_por_preventivos=$this->Mequipo_repuestos->getPendientesPorPreventivos();
			$repuestos_pendientes_por_observaciones=$this->Mequipo_repuestos->getPendientesPorObservaciones();
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<table border="1">
				<thead>
					<tr>
						<th>Origen</th>
						<th>Id</th>
						<th>Equipo</th>
						<th>A.Fijo</th>
						<th>Sn</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Sede</th>
						<th>Servicio</th>
						<th>Codigo cierre del preventivo - correctivo</th>
						<th>Repuesto</th>
						<th>Fecha del reporte</th>
						<th>Proveedor</th>
						<th>Zona</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($repuestos_pendientes_por_correctivos)): ?>
						<?php foreach ($repuestos_pendientes_por_correctivos as $repuesto_pendiente_por_correctivo): ?>
							<tr>
								<td>Correctivos</td>
								<td><?php echo $repuesto_pendiente_por_correctivo->id; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->equipo; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->codigo; ?></td>
								<td><?php echo "sn: ".$repuesto_pendiente_por_correctivo->serie; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->marca; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->modelo; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->sede; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->servicio; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->codigo_cierre_correctivo; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->repuesto_por_correctivo; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->fecha_mantenimiento; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->proveedor_mantenimiento; ?></td>
								<td><?php echo $repuesto_pendiente_por_correctivo->zona; ?></td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>
					<?php if (!empty($repuestos_pendientes_por_preventivos)): ?>
						<?php foreach ($repuestos_pendientes_por_preventivos as $repuesto_pendiente_por_preventivo): ?>
							<tr>
								<td>Preventivos</td>
								<td><?php echo $repuesto_pendiente_por_preventivo->id; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->equipo; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->codigo; ?></td>
								<td><?php echo "sn: ".$repuesto_pendiente_por_preventivo->serie; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->marca; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->modelo; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->sede; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->servicio; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->codigo_cierre_preventivo; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->repuesto_por_preventivo; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->fecha_mantenimiento; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->proveedor_mantenimiento; ?></td>
								<td><?php echo $repuesto_pendiente_por_preventivo->zona; ?></td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>
					<?php if (!empty($repuestos_pendientes_por_observaciones)): ?>
						<?php foreach ($repuestos_pendientes_por_observaciones as $repuesto_pendiente_por_observacion): ?>
							<tr>
								<td>Observaciones</td>
								<td><?php echo $repuesto_pendiente_por_observacion->id; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->equipo; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->codigo; ?></td>
								<td><?php echo "sn: ".$repuesto_pendiente_por_observacion->serie; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->marca; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->modelo; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->sede; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->servicio; ?></td>
								<td></td>
								<td><?php echo $repuesto_pendiente_por_observacion->repuesto_por_observacion; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->created_at; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->proveedor_mantenimiento; ?></td>
								<td><?php echo $repuesto_pendiente_por_observacion->zona; ?></td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>
				</tbody>
			</table>
			<?php

		}
	}


	public function excel_repuestos_instalados(){
		$repuestos_instalados = $this->Mequipo_repuestos->getAll();

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Resultados');

		$contador = 1;
        //Le aplicamos ancho las columnas.
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        //Le aplicamos negrita a los títulos de la cabecera.
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
        //Definimos los títulos de la cabecera.
		$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Fecha');
		$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Repuesto');
		$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Cantidad entregada');
		$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Id equipo');
		$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Nombre equipo');
		$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Serie equipo');
		$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Codigo equipo');
		$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Marca');
		$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Modelo');
		$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Servicio');
		$this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Observación');
		$this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Precio');
		$this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Precio total');
		$this->excel->getActiveSheet()->setCellValue("N{$contador}", 'Codigo del repuesto');
		foreach ($repuestos_instalados as $repuesto_instalado) {
			$contador=$contador+1;
			$this->excel->getActiveSheet()->setCellValue("A{$contador}", $repuesto_instalado->fecha);
			$this->excel->getActiveSheet()->setCellValue("B{$contador}", $repuesto_instalado->repuesto);
			$this->excel->getActiveSheet()->setCellValue("C{$contador}", $repuesto_instalado->cantidad_entregada);
			$this->excel->getActiveSheet()->setCellValue("D{$contador}", $repuesto_instalado->equipo_id);
			$this->excel->getActiveSheet()->setCellValue("E{$contador}", $repuesto_instalado->equipo_nombre);
			$this->excel->getActiveSheet()->setCellValue("F{$contador}", "sn:".$repuesto_instalado->equipo_serie);
			$this->excel->getActiveSheet()->setCellValue("G{$contador}", $repuesto_instalado->equipo_codigo);
			$this->excel->getActiveSheet()->setCellValue("H{$contador}", $repuesto_instalado->marca);
			$this->excel->getActiveSheet()->setCellValue("I{$contador}", $repuesto_instalado->modelo);
			$this->excel->getActiveSheet()->setCellValue("J{$contador}", $repuesto_instalado->servicio);
			$this->excel->getActiveSheet()->setCellValue("K{$contador}", $repuesto_instalado->observacion);
			$this->excel->getActiveSheet()->setCellValue("L{$contador}", $repuesto_instalado->precio);
			$this->excel->getActiveSheet()->setCellValue("M{$contador}", $repuesto_instalado->precio_global);
			$this->excel->getActiveSheet()->setCellValue("N{$contador}", $repuesto_instalado->codigo_repuesto);
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="ConsolidadoRepuestosInstalados.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
        // Forzamos a la descarga
        ob_end_clean();
        $objWriter->save('php://output');
        $this->excel->disconnectWorksheets();
        unset($this->excel);
    }
    public function excel_repuestos_pendientes_por_correctivos(){
    	$repuestos_pendientes_por_correctivos = $this->Mequipo_repuestos->getPendientesPorCorrectivos();
    	$this->excel->setActiveSheetIndex(0);
    	$this->excel->getActiveSheet()->setTitle('Resultados');
    	$contador = 1;
        //Le aplicamos ancho las columnas.
    	$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    	$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
    	$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    	
        //Le aplicamos negrita a los títulos de la cabecera.
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
    	
        //Definimos los títulos de la cabecera.
    	$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Id equipo');
    	$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Equipo');
    	$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Codigo equipo');
    	$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Serie equipo');
    	$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Marca');
    	$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Modelo');
    	$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Servicio');
    	$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Codigo Reporte');
    	$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Repuesto pendiente');
    	$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Fecha del Reporte');
    	
    	foreach ($repuestos_pendientes_por_correctivos as $repuesto_pendiente_por_correctivo) {
    		$contador=$contador+1;
    		$this->excel->getActiveSheet()->setCellValue("A{$contador}", $repuesto_pendiente_por_correctivo->id);
    		$this->excel->getActiveSheet()->setCellValue("B{$contador}", $repuesto_pendiente_por_correctivo->equipo);
    		$this->excel->getActiveSheet()->setCellValue("C{$contador}", $repuesto_pendiente_por_correctivo->codigo);
    		$this->excel->getActiveSheet()->setCellValue("D{$contador}", "sn:".$repuesto_pendiente_por_correctivo->serie);
    		$this->excel->getActiveSheet()->setCellValue("E{$contador}", $repuesto_pendiente_por_correctivo->marca);
    		$this->excel->getActiveSheet()->setCellValue("F{$contador}", $repuesto_pendiente_por_correctivo->modelo);
    		$this->excel->getActiveSheet()->setCellValue("G{$contador}", $repuesto_pendiente_por_correctivo->servicio);
    		$this->excel->getActiveSheet()->setCellValue("H{$contador}", $repuesto_pendiente_por_correctivo->codigo_cierre_correctivo);
    		$this->excel->getActiveSheet()->setCellValue("I{$contador}", $repuesto_pendiente_por_correctivo->repuesto_por_correctivo);
    		$this->excel->getActiveSheet()->setCellValue("J{$contador}", $repuesto_pendiente_por_correctivo->fecha_mantenimiento);
    		
    	}
	// // $this->excel->getActiveSheet()->mergeCells('A1:D1');

    	header('Content-Type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment;filename="ConsolidadoRepuestosPendientesEnCorrectivos.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
        // Forzamos a la descarga
        ob_end_clean();
        $objWriter->save('php://output');
        $this->excel->disconnectWorksheets();
        unset($this->excel);



    }
    public function excel_repuestos_pendientes_por_preventivos(){
    	$this->Mequipo_repuestos->getPendientesPorPreventivos();

    	$repuestos_pendientes_por_preventivos = $this->Mequipo_repuestos->getPendientesPorPreventivos();

    	$this->excel->setActiveSheetIndex(0);
    	$this->excel->getActiveSheet()->setTitle('Resultados');

    	$contador = 1;
        //Le aplicamos ancho las columnas.
    	$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    	$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
    	$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    	$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    	
        //Le aplicamos negrita a los títulos de la cabecera.
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
    	
        //Definimos los títulos de la cabecera.
    	$this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Id equipo');
    	$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Equipo');
    	$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Codigo equipo');
    	$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Serie equipo');
    	$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Marca');
    	$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Modelo');
    	$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Servicio');
    	$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Codigo del preventivo');
    	$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Repuesto pendiente');
    	$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Fecha del preventivo');
    	
    	foreach ($repuestos_pendientes_por_preventivos as $repuesto_pendiente_por_preventivo) {
    		$contador=$contador+1;
    		$this->excel->getActiveSheet()->setCellValue("A{$contador}", $repuesto_pendiente_por_preventivo->id);
    		$this->excel->getActiveSheet()->setCellValue("B{$contador}", $repuesto_pendiente_por_preventivo->equipo);
    		$this->excel->getActiveSheet()->setCellValue("C{$contador}", $repuesto_pendiente_por_preventivo->codigo);
    		$this->excel->getActiveSheet()->setCellValue("D{$contador}", "sn:".$repuesto_pendiente_por_preventivo->serie);
    		$this->excel->getActiveSheet()->setCellValue("E{$contador}", $repuesto_pendiente_por_preventivo->marca);
    		$this->excel->getActiveSheet()->setCellValue("F{$contador}", $repuesto_pendiente_por_preventivo->modelo);
    		$this->excel->getActiveSheet()->setCellValue("G{$contador}", $repuesto_pendiente_por_preventivo->servicio);
    		$this->excel->getActiveSheet()->setCellValue("H{$contador}", $repuesto_pendiente_por_preventivo->codigo_cierre_preventivo);
    		$this->excel->getActiveSheet()->setCellValue("I{$contador}", $repuesto_pendiente_por_preventivo->repuesto_por_preventivo);
    		$this->excel->getActiveSheet()->setCellValue("J{$contador}", $repuesto_pendiente_por_preventivo->fecha_mantenimiento);
    		
    	}

    	header('Content-Type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment;filename="ConsolidadoRepuestosPendientesEnPreventivos.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
        // Forzamos a la descarga
        ob_end_clean();
        $objWriter->save('php://output');
        $this->excel->disconnectWorksheets();
        unset($this->excel);

    }
    public function get_datatable(){
    	echo json_encode($this->Mrepuestos->get_datatable());
    }
    public function get(){
    	echo json_encode($this->Mrepuestos->get());
    }
    public function getOne(){
    	echo json_encode($this->Mrepuestos->getOne($_POST));
    }

    public function update(){
    	$repuesto = $this->Mrepuestos->getOne($_POST);
    	if ($repuesto->name == $_POST["name"]) {
    		$this->form_validation->set_rules("name","Nombre del repuesto","required|min_length[3]");
    	}else{
    		$this->form_validation->set_rules("name","Nombre del repuesto","required|min_length[3]|is_unique[repuestos.name]");
    	}
    	if ($this->form_validation->run()) {
    		$this->Mrepuestos->update($_POST);
    		$vector=array(
    			'respuesta'=>1,
    			'informacion'=>""
    		);
    	}else{
    		$vector=array(
    			'respuesta'=>2,
    			'informacion'=>validation_errors()
    		);
    	}
    	echo json_encode($vector);
    }
    public function add_repuesto_from_equipos(){

    	if (isset($_POST)) {
    		$this->form_validation->set_rules("name","Nombre del repuesto","is_unique[repuestos.name]|required");
    		$this->form_validation->set_rules("code","Codigo del repuesto","is_unique[repuestos.code]|required|min_length[3]");
    		if ($this->form_validation->run()) {

    			$vector=array(
    				"respuesta"=>1,
    				"informacion"=>""
    			);
    			$this->Mrepuestos->add($_POST);
    			echo json_encode($vector);
    		}else{
    			$vector=array(
    				"respuesta"=>2,
    				"informacion"=>validation_errors()
    			);
    			echo json_encode($vector);
    		}
    	}

    }
    public function add(){

    	if (isset($_POST["id"])) {
    		unset($_POST["id"]);
    	}
    	$this->form_validation->set_rules("name","Nombre del repuesto","is_unique[repuestos.name]|required|min_length[3]");
    	$this->form_validation->set_rules("code","Codigo del repuesto","is_unique[repuestos.code]|required|min_length[3]");

    	if ($this->form_validation->run()) {
    		$vector=array(
    			'respuesta'=>1,
    			'informacion'=>""
    		);
    		$this->Mrepuestos->add($_POST);
    	}else{
    		$vector=array(
    			'respuesta'=>2,
    			'informacion'=>validation_errors()
    		);
    	}
    	echo json_encode($vector);
    }
    public function delete(){
    	$_POST["status"]=2;
    	$this->Mrepuestos->delete($_POST);
    }
    public function sumar(){
    	$razon=$_POST["razon"];
    	$repuesto_id=$_POST["id"];
    	unset($_POST["razon"]);
    	$sumado=$_POST["cantidad"];
    	$_POST["cantidad"]=$_POST["stock"]+$_POST["cantidad"];
    	unset($_POST["stock"]);
    	$vector=array(
    		'id'=>$_POST["id"]
    	);
    	$this->Mrepuestos->sumar($_POST);
    	$repuesto=$this->Mrepuestos->getOne($vector);
    	$movimiento=array(
    		"repuesto_id"=>$repuesto_id,
    		"accion"=>"sumar",
    		"description"=>"El usuario ".$this->session->userdata('nombre')." agrego ".$sumado." unidades del repuesto, el saldo resultante es de: ".$repuesto->cantidad,
    		"cantidad"=>$sumado,
    		"usuario_id"=>$this->session->userdata("id"),
    		"razon"=>$razon
    	);
    	$this->Mmovimientos->add($movimiento);

    	echo $repuesto->cantidad;
    }
    public function restar(){
    	$razon=$_POST["razon"];
    	$repuesto_id=$_POST["id"];
    	unset($_POST["razon"]);
    	$restado=$_POST["cantidad"];
    	$_POST["cantidad"]=$_POST["stock"]-$_POST["cantidad"];
    	unset($_POST["stock"]);
    	$vector=array(
    		'id'=>$_POST["id"]
    	);
    	$this->Mrepuestos->restar($_POST);
    	$repuesto=$this->Mrepuestos->getOne($vector);
    	$movimiento=array(
    		"repuesto_id"=>$repuesto_id,
    		"accion"=>"restar",
    		"description"=>"El usuario ".$this->session->userdata('nombre')." retiro ".$restado." unidades del repuesto, el saldo resultante es de: ".$repuesto->cantidad,
    		"cantidad"=>$restado,
    		"usuario_id"=>$this->session->userdata("id"),
    		"razon"=>$razon
    	);
    	$this->Mmovimientos->add($movimiento);
    	echo $repuesto->cantidad;
    }
    public function show(){
    	$movimientos = $this->Mmovimientos->get($_POST);
    	$vector=array(
    		'movimientos'=>$movimientos
    	);
    	$this->load->view("repuestos/detail",$vector);
    }	
    public function getDistribucionRepuestos(){
    	echo json_encode($this->Mequipo_repuestos->getDistribucionRepuestos());
    }

    public function show_repuestos_instalados(){
    	$this->load->view("repuestos/modal_detail_repuestos_instalados",array("repuestos_instalados"=>$this->Mequipo_repuestos->getAll()));
    }
    public function show_repuestos_pendientes(){

		$repuestos_pendientes_por_correctivos=$this->Mequipo_repuestos->getPendientesPorCorrectivos();
		$repuestos_pendientes_por_preventivos=$this->Mequipo_repuestos->getPendientesPorPreventivos();
		$repuestos_pendientes_por_observaciones=$this->Mequipo_repuestos->getPendientesPorObservaciones();
		$vector_repuestos=array(
			"repuestos_pendientes_por_correctivos"=>$repuestos_pendientes_por_correctivos,
			"repuestos_pendientes_por_preventivos"=>$repuestos_pendientes_por_preventivos,
			"repuestos_pendientes_por_observaciones"=>$repuestos_pendientes_por_observaciones

		);
    	$this->load->view("repuestos/modal_detail_repuestos_pendientes",$vector_repuestos);
    }
    public function show_resumen_por_repuesto(){
    	$this->load->view("repuestos/modal_detail_resumen_por_repuesto",array("consolidado_anio_mes"=>$this->Mequipo_repuestos->getCOnsolidadoAnioMes()));
    }
    public function show_resumen_general(){
    	$this->load->view("repuestos/modal_detail_resumen_general",array("consolidado_anio_mes_general"=>$this->Mequipo_repuestos->getCOnsolidadoAnioMesGeneral()));
    }

    public function show_resumen_inversion_repuestos_equipo(){
    	$this->load->view("repuestos/modal_detail_resumen_inversion_repuestos_equipo",array("inversion_repuestos_equipo"=>$this->Mequipo_repuestos->getInversionRepuestosequipo()));
    }
    public function show_resumen_inversion_repuestos_servicio(){
    	$this->load->view("repuestos/modal_detail_resumen_inversion_repuestos_servicio",array("inversion_repuestos_servicio"=>$this->Mequipo_repuestos->getInversionRepuestosServicio()));
    }

}

?>