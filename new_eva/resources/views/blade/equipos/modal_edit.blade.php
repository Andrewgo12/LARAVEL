<div id="modal_update_equipo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl" style="margin: 30px auto;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Actualizar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">equipo
								</h3>
							</div>

							<div class="box-body form-horizontal">
								<style type="text/css">
									input,
									select,
									textarea {
										border: 0;
									}
								</style>
								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
								<form action="{{ asset('') }}equipo/Cequipos/update" id="form_update_equipo" name="form_update_equipo" enctype="multipart/form-data" method="post">
      @csrf
									<input type="hidden" id="id" name="id" class="form-control">
									<br>
									<div class="table-responsive">

										<div class="tg-wrap">
											<table class="tg">
												<tr>
													<th class="tg-5xx9" colspan="10">EDICIÓN DE HOJA DE VIDA PARA EQUIPOS <?php echo ($tipo_id == 1) ? "BIOMEDICOS" : "INDUSTRIALES" ?> HOSPITAL UNIVERSITARIO DEL VALLE “EVARISTO GARCÍA” </th>
												</tr>
												<tr>
													<td class="tg-d4yz" colspan="10">IDENTIFICACIÓN DEL EQUIPO</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Nombre del equipo:</td>

													<td class="tg-0pky text-center" colspan="4">

														<input autocomplete="off" type="text" class="form-control" name="name" id="name" placeholder="Nombre" list="listadoNombresFromUpdate">
														<label for="descripcion">Descripcion adicional</label><br>
														<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion adicional">

														<datalist id="listadoNombresFromUpdate" class="datalistNombreEquipos"></datalist>
													</td>
													<td class="tg-dxek" colspan="5">IMAGEN RELACIONADA DEL EQUIPO <span id="preview_imagen"></span></td>
												</tr>
												<tr>
													<td class="tg-g8x9">Serie:</td>
													<td class="tg-0pky text-center" colspan="1"><input type="text" class="form-control input-sm" placeholder="Serie" name="serial" id="serial"></td>
													<td class="tg-g8x9">Archivo excel Hoja de vida:</td>
													<td class="tg-0pky text-center" colspan="4"><input style="height: 50%;" type="file" id="file" name="file" onchange="return validacionArchivo1()"></td>
													<td class="tg-ng7p" colspan="5" rowspan="9">
														<input type="file" class="file" id="image1" name="image1" onchange="return validacionImagen1()" data-browse-on-zone-click="true">
													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">INV/Activo:</td>
													<td class="tg-fymr" colspan="2">Antiguo:<input class="form-control" type="text" name="codigo_antiguo" id="codigo_antiguo" placeholder="Codigo antiguo"></td>
													<td class="tg-fymr" colspan="2">Nuevo:<input type="text" class="form-control" placeholder="Codigo de inventario" name="code" id="code"></td>

												</tr>

												<tr>
													<td class="tg-g8x9">Marca:</td>

													<td class="tg-0pky" colspan="4"><input autocomplete="off" type="text" class="form-control input-sm" placeholder="Marca" name="marca" id="marca" list="listadoMarcasFromUpdate">
														<datalist id="listadoMarcasFromUpdate" class="datalistMarcaEquipos"></datalist>

													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Modelo:</td>
													<td class="tg-0pky" colspan="4"><input autocomplete="off" type="text" class="form-control input-sm" placeholder="modelo" name="modelo" id="modelo" list="listadoModelosFromUpdate">
														<datalist id="listadoModelosFromUpdate" class="datalistModeloEquipos"></datalist>
													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">R.Invima:</td>
													<td class="tg-0pky" colspan="4">

														<div><span title="Agregar nuevo invima" class="glyphicon glyphicon-plus" style="font-size: 10px;font-weight: 900;" data-toggle="modal" data-target="#modal_add_invima"></span>

															<select onchange="funcion_cambio_select_update();" style="width:300px;" class="form-control invima_id" name="invima_id" id="invima_id"></select>

															<span class="file_registro_sanitario"></span>

															<!-- <button onclick="consultar_registro(event)" class="consultar glyphicon glyphicon-search"></button> -->
															<a data-toggle="modal" data-target="#modal_consulta_invima" onclick="show_consulta_invima(event)" class="consultar btn btn-success glyphicon glyphicon-search"></a>

														</div>

													</td>
												</tr>

												<tr>
													<td class="tg-g8x9">Ubicación:</td>

													<td class="tg-0pky" colspan="4">

														<ul class="list-inline">
															<li class="list-inline-item">

																<label for="sede_id">Sede:</label>
																<select style="width: 70%;" class="form-control sede" id="sede_id" name="sede_id">
																	<option value="1">PRINCIPAL</option>
																	<option value="2">NORTE</option>
																</select>
															</li>
															<li class="list-inline-item">

																<label for="servicio_id">Servicio:</label>

																<?php
																foreach ($acciones as $accion) {
																	if ($accion->modulo == "servicios" && $accion->insertar == 1) {
																?>

																		<a style="font-size: 10px;font-weight: 900;color: black;" data-toggle='modal' data-target='#modal_add_servicio' class="glyphicon glyphicon-plus"></a>
																<?php
																	}
																}
																?>
																<select required="" class="form-control servicio_id" style="width:100%;" name="servicio_id" id="servicio_id">
																</select>
															</li>
															<li class="list-inline-item">
																<label for="area_id">Area:</label>
																<?php $acciones = {{ session('acciones') }}; ?>
																@foreach($acciones as $accion)
																	@if($accion->modulo == "areas")
																		@if($accion->insertar == 1)
																			<a style="font-size: 10px;font-weight: 900;color: black;" data-toggle='modal' data-target='#modal_add_area' class="glyphicon glyphicon-plus"></a>
																		<?php endif ?>
																	<?php endif ?>
																<?php endforeach ?>
																<select name="area_id" id="area_id" class="form-control area_id">

																</select>

															</li>
														</ul>


													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Piso:</td>
													<td class="tg-0pky" colspan="2">
														<div id="pisos"></div>
													</td>
													<td class="tg-0pky"><span style="font-weight:700">Centro de costo:</span>
														<div id="codigo_centro">7009</div>
													</td>
													<td class="tg-0pky">
														<div id="centro"></div>
													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Equipo (Movil/fijo):</td>
													<td class="tg-0pky" colspan="2">
														<select class="form-control" id="movilidad" name="movilidad">
															<option value="">-----</option>
															<option value="FIJO">FIJO</option>
															<option value="MOVIL">MOVIL</option>
														</select>
													</td>
													<td class="tg-0pky"><span style="font-weight:700">Pais de origen:</span></td>
													<td class="tg-0pky"></td>
												</tr>
												<tr>
													<td class="tg-d4yz" colspan="5">REGISTRO HISTORICO</td>
												</tr>
												<tr>
													<td class="tg-0akb">Forma de adquisición:</td>
													<td class="tg-0pky" colspan="3">
														<select onchange="seleccion_contenedor_adquisicion(event)" class="form-control tadquisicion_id" style="width: 90%;" name="tadquisicion_id" id="tadquisicion_id" required="">
															<option value="">--SELECCIONE--</option>
														</select>
														<span class="contenedor_adquisicion_compra">
															<span class="contenedor_orden_compra"></span>
														</span>

													</td>
													<td class="tg-0pky"><span style="font-weight:700">Garantia:</span></td>
													<td class="tg-0akb" colspan="5"><select name="garantia" id="garantia" class="periodos_garantias form-control"></select></td>
												</tr>
												<tr>
													<td class="tg-0akb">Activo comodato:</td>
													<td class="tg-0pky" colspan="9"><input class="form-control" type="text" name="activo_comodato" id="activo_comodato" placeholder="Codigo de comodato"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Fecha de adquisición:</td>
													<td class="tg-0pky" colspan="2">
														<!-- 														<input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_ad" id="fecha_ad"> -->
														<input type="date" class="form-control" name="fecha_ad" id="fecha_ad">
													</td>
													<td class="tg-pwly"><span style="font-weight:700">Fecha acta de recibo:</span></td>
													<td class="tg-0pky" colspan="6"><input type="date" min="1950-01-31" class="form-control" name="fecha_acta_recibo" id="fecha_acta_recibo"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Fecha de instalación:</td>
													<td class="tg-0pky" colspan="2"><input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_instalacion" id="fecha_instalacion"></td>
													<td class="tg-pwly"><span style="font-weight:700">Fecha de inicio operación:</span></td>
													<td class="tg-0pky" colspan="6"><input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_inicio_operacion" id="fecha_inicio_operacion"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Fecha recepción almacen:</td>
													<td class="tg-0pky" colspan="2"><input type="date" min="1950-01-31" class="form-control" name="fecha_recepcion_almacen" id="fecha_recepcion_almacen"></td>
													<td class="tg-pwly"><span style="font-weight:700">Fecha de fabricación:</span></td>
													<td class="tg-0pky" colspan="6"><input type="date" class="form-control" name="fecha_fabricacion" id="fecha_fabricacion"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Costo:</td>
													<td class="tg-0pky" colspan="2"><input type="number" class="form-control input-sm" placeholder="Costo" name="costo" id="costo"></td>
													<td class="tg-0akb">Vida util:</td>
													<td class="tg-0pky" colspan="6"><input type="text" class="form-control input-sm" placeholder="Vida util (años)" name="vida_util" id="vida_util"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Información de Fabricantes/<br>Proveedores/<br>Distribuidores <br>
														<a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_equipo_contacto" style="font-size: 5px;"></a>
													</td>
													<td class="tg-0pky" colspan="9">
														<table class="table table-bordered tblEquipo_contactos">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th>Nombre</th>
																	<th>Email</th>
																	<th>Telefono</th>
																	<th>Tipo</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="tg-anza" colspan="10"><span style="font-weight:bold">REGISTRO TECNICO DE INSTALACIÓN Y FUNCIONAMIENTO</span></td>
												</tr>
												<tr>
													<td class="tg-0akb" colspan="2">Fuente de alimentación:</td>
													<td class="tg-0pky" colspan="8"><select required="" class="form-control fuente_id" name="fuente_id" id="fuente_id"></select></td>
												</tr>
												<tr>
													<td class="tg-0akb" colspan="2">Tecnologia predominante:</td>
													<td class="tg-0pky" colspan="8"><select required="" class="form-control tecnologia_id" name="tecnologia_id" id="tecnologia_id"></select></td>
												</tr>
												<tr>
													<td class="tg-46fy" rowspan="3">Especificaciones Tecnicas: <a onclick="funcion_modal_compartir_especificaciones(event)" data-toggle="modal" data-target="#modal_compartir_especificaciones" href="" style="color: blue;font-size: 13px;font-weight: 1200;" title="Compartir especificaciones tecnicas" class="glyphicon glyphicon-share"></a><br><a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_equipo_especificacion" style="font-size: 5px;"></a></td>
													<td class="tg-0pky" colspan="9" rowspan="3">
														<div class="row">
															<table class="table table-bordered tblEquipo_especificaciones" id="tabla_especificacion_edit">
																<tbody>
																</tbody>
															</table>
														</div>
													</td>
												</tr>
												<tr>
												</tr>
												<tr>
												</tr>
												<tr>
													<td class="tg-0akb">Evaluación de desempeño:</td>
													<td class="tg-0pky">
														<select class="form-control" id="evaluacion_desempenio" name="evaluacion_desempenio">
															<option value="">-----</option>
															<option value="SI">SI</option>
															<option value="NO">NO</option>
														</select>

													</td>
													<td class="tg-0akb">Se realiza calibración ?</td>
													<td class="tg-0pky">
														<select class="form-control" id="calibracion" name="calibracion">
															<option value="">-----</option>
															<option value="SI">SI</option>
															<option value="NO">NO</option>
														</select>
													</td>
													<td class="tg-0akb">Periodicidad</td>
													<td class="tg-0pky contenedor_periodicidad" colspan="9">

													</td>
												</tr>
												<tr>
													<td class="tg-0akb">Frecuencia de mantenimiento:</td>
													<td class="tg-0pky" colspan="9"><select required="" class="form-control frecuencia_id" name="frecuencia_id" id="frecuencia_id"></select></td>
												</tr>
												<tr>

													<td class="tg-0akb"><span style="font-weight: 900;">Estado actual del equipo</span>:</td>
													<td class="tg-0pky" colspan="9">
														<div class="row">
															<div class="col-md-2">
																<label for="estadoequipo_id">Funcionalidad</label>
															</div>
															<div class="col-md-4">
																<select required="" name="estadoequipo_id" id="estadoequipo_id" class="form-control estadoequipo_id"></select>
																<input disabled="" type="hidden" class="tmp_estado_equipo_id" name="tmp_estado_equipo_id" id="tmp_estado_equipo_id">
															</div>
															<div class="col-md-2">
																<label for="disponibilidad_id">Disponibilidad</label>
															</div>
															<div class="col-md-4">
																<select name="disponibilidad_id" id="disponibilidad_id" class="form-control disponibilidad_id"></select>
															</div>
														</div><br>
														<div class="row">
															<div class="col-md-2">
																<label for="">Localización actual</label>
															</div>
															<div class="col-md-10">
																<input disabled="" required="" class="form-control localizacion_actual" id="localizacion_actual" name="localizacion_actual" placeholder="Localización actual" type="text">
																<input disabled="" type="hidden" class="tmp_localizacion_actual" name="tmp_localizacion_actual" id="tmp_localizacion_actual">
															</div>
														</div>
													</td>
												</tr>

												<tr>
													<td class="tg-x39a" colspan="10">REGISTRO DE APOYO TÉCNICO</td>
												</tr>
												<tr>
													<td class="tg-ql13" colspan="3">Manuales:</td>
													<td class="tg-ql13" colspan="7">Planos:</td>
												</tr>
												<tr>
													<td class="tg-0pky" colspan="3" rowspan="3">
														<div class="row">
															<div class="col-sm-1">
																<a href="#" data-toggle="modal" data-target="#modal_consulta_manual" onclick="show_consulta_manual()" class="glyphicon glyphicon-search btn btn-link"></a>
															</div>
															<div class="col-sm-1">
																<a style="color: red;font-weight: 800;" href="#" class="fa fa-minus btn btn-link" onclick="borrar_relacion_manual()"></a>
															</div>
															<div class="col-sm-3">
																<input type="hidden" id="manual_id" name="manual_id" class="manual_id">
																<div class="contenedor_url_manual"></div>
																<div class="contenedor_descripcion_manual"></div>
															</div>
															<div class="col-sm-7">
																<input class="input_check" type="checkbox" name="manual[]" value="operacion">Operacion
																<br><input class="input_check" type="checkbox" name="manual[]" value="mantenimiento">Mantenimiento
																<br><input class="input_check" type="checkbox" name="manual[]" value="partes">Partes
															</div>
														</div>
													</td>
													<td class="tg-0pky" colspan="7" rowspan="3">
														<input class="input_check" type="checkbox" name="plano[]" value="electrico">Electrico
														<br><input class="input_check" type="checkbox" name="plano[]" value="electronico">Electronico
														<br><input class="input_check" type="checkbox" name="plano[]" value="neumatico">Neumatico
														<br><input class="input_check" type="checkbox" name="plano[]" value="mecanico">Mecanico
													</td>
												</tr>
												<tr>
												</tr>
												<tr>
												</tr>
												<tr>
													<td class="tg-ppov"><span style="font-weight:bold">Guias rapidas:</span></td>
													<td class="tg-0lax" colspan="9">
														<a href="#" data-toggle="modal" data-target="#modal_consulta_guia" onclick="show_consulta_guia()" class="glyphicon glyphicon-search btn btn-success"></a>
														<a href="#" class="fa fa-minus btn btn-danger" onclick="borrar_reacion_guia()"></a>
														<ul class="list-inline">
															<li class="list-inline-item"><input name="guia_id" id="guia_id" type="hidden" class="guia_id"></li>
															<li class="list-inline-item">
																<div class="contenedor_name_guia"></div>
															</li>
															<li class="list-inline-item">
																<div class="contenedor_archivo_guia"></div>
															</li>
														</ul>
													</td>
												</tr>
												@if($tipo_id == 1)
													<tr>
														<td class="tg-46fy" colspan="2">Clasificación biomedica:</td>
														<td class="tg-0pky" colspan="2">
															<select required="" class="form-control cbiomedica_id" name="cbiomedica_id" id="cbiomedica_id"></select>
														</td>
														<td class="tg-0pky"><span style="font-weight:700">Clasificación de acuerdo al riesgo:</span></td>
														<td class="tg-0pky" colspan="5"><select required="" class="form-control criesgo_id" name="criesgo_id" id="criesgo_id"></select></td>
													</tr>
												<?php endif ?>
												<tr>
													<td class="tg-hk8r" colspan="10">COMPONENTES</td>
												</tr>
												<tr>
													<td class="tg-0pky" colspan="10" rowspan="3">
														<div class="col-sm-12 col-md-12">
															<textarea class="textarea-personalizado form-control" name="accesorios" id="accesorios" width="100%" rows="4" placeholder="Indique cuales son los componentes/accesorios del equipo"></textarea>
														</div>
													</td>
												</tr>
												<tr>
												</tr>
												<tr>
												</tr>
												<tr>
													<td class="tg-x39a" colspan="10">SEGUIMIENTO</td>
												</tr>

												<tr>
													<td class="tg-0akb">Frecuencia de mantenimiento:</td>
													<td class="tg-0pky" colspan="9"><select required="" class="form-control frecuencia_id" name="frecuencia_id" id="frecuencia_id"></select></td>
												</tr>
												<tr>
													<td class="tg-0akb">Propietario:</td>
													<td class="tg-0pky" colspan="9">
														<!-- 														<select required="" class="form-control" id="propiedad" name="propiedad">
														<option value="">------Seleccione-------</option>
														<option value="PROPIO">PROPIO</option>
														<option value="UNIVALLE">UNIVALLE</option>
														<option value="BAXTER">BAXTER</option>
														<option value="DEPARTAMENTO">DEPARTAMENTO</option>
														<option value="OTROS">OTROS</option> -->
														<div class="row">
															<div class="col-sm-11">
																<select style="width: 100%" required="" name="propietario_id" id="propietario_id" class="propietario_id form-control"></select>
															</div>
															<div class="col-sm-1">
																<?php
																foreach ($acciones as $accion) {
																	if ($accion->modulo == "propietarios" && $accion->insertar == 1) {
																?>
																		<span title="Agregar nuevo popietario" class="glyphicon glyphicon-plus" style="font-size: 10px;font-weight: 900;" data-toggle="modal" data-target="#modal_add_propietario"></span>
																<?php
																	}
																}
																?>
															</div>
														</div>

													</td>
												</tr>
												<tr>
													<td class="tg-ppov"><span style="font-weight:bold">Verificacion fisica:</span></td>
													<td class="tg-0lax" colspan="9"><select class="form-control" id="verificacion_inventario" name="verificacion_inventario">
															<option value="">--------</option>
															<option value="NO">NO</option>
															<option value="SI">SI</option>
															<option value="NUEVO">NUEVO</option>
															<option value="NOENCONTRA">NO SE ENCONTRO</option>
														</select></td>
												</tr>
												<!-- 												<tr>
													<td class="tg-gj0n" colspan="10">OBSERVACIONES</td>
												</tr> -->
												<!-- 												    <tr>
														<td class="tg-0lax" colspan="10">
															<div id="observacion_temporal"></div>
															<textarea class="form-control" name="observacion" id="observacion" rows="4" placeholder="Ingrese todas las observaciones que se estimen pertinentes para el seguimiento del equipo"></textarea>
														</td>
													</tr>	 -->
												<tr>
													<td class="tg-gj0n" colspan="10">CORRECTIVOS TICKETS</td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<table class="table table-bordered tblCorrectivos">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th>Id Orden</th>
																	<th>Fecha de creación</th>
																	<th>Descripcion</th>
																	<th>Estado</th>
																	<th class="esconder">ARCHIVO RELACIONADO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="tg-gj0n" colspan="10">OTROS CORRECTIVOS&nbsp;<a onclick="reset_form_add_correctivos();" href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_correctivo_general" style="font-size: 5px;"></a></td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<table style="font-size: 10px;" style="border:0;" class="table table-condensed tblCorrectivosGenerales">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th><strong>Información de la Orden de trabajo</strong></th>
																	<th><strong>Información de cierre</strong></th>
																	<th class="esconder"><strong>ARCHIVO RELACIONADO</strong></th>
																	<th>Editar</th>
																	<th>Eliminar</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="tg-gj0n" colspan="10">OBSERVACIONES&nbsp;
														<!-- <a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_observacion" style="font-size: 5px;"></a> -->
													</td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<div id="observacion_temporal"></div><br>

														<table class="table table-bordered tblObservaciones">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th>Descripcion</th>
																	<th>Fecha de la observacion</th>
																	<th class="esconder">ARCHIVO RELACIONADO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="tg-gj0n" colspan="10">PREVENTIVOS &nbsp;<a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_preventivo" style="font-size: 5px;"></a></td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<table style="text-transform: lowercase;" class="table table-bordered tblPreventivos table-condensed table-sm">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th><strong>NRO MANTENIMIENTO</strong></th>
																	<th><strong>FECHA DE EJECUCION</strong></th>
																	<!-- <th>FECHA PROGRAMADA</th> -->
																	<th class="esconder"><strong>Información Relacionada</strong></th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="tg-gj0n" colspan="10">CALIBRACIONES&nbsp;<a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_calibracion" style="font-size: 5px;"></a></td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<table class="table table-bordered tblCalibraciones">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th>NRO CALIBRACION</th>
																	<th>FECHA DE EJECUCION</th>
																	<th>FECHA PROGRAMADA</th>
																	<th class="esconder">ARCHIVO RELACIONADO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td class="tg-gj0n" colspan="10">REPUESTOS/ACCESORIOS &nbsp;<a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_repuesto" style="font-size: 5px;"></a></td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<table class="table table-bordered tblEquipoRepuestos">
															<thead>
																<tr>
																	<!-- <th>ID</th> -->
																	<th>REPUESTO/ACCESORIO</th>
																	<th>OBSERVACION</th>
																	<th>FECHA DE INSTALACION</th>
																	<th>CANTIDAD ENTREGADA</th>
																	<th class="esconder">ARCHIVO RELACIONADO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</td>
												</tr>
											</table>
										</div>
										<div class="row" class="mensaje"></div>
										<div class="box-footer">
											<button class="btn btn-primary" id="btn_update_equipo">Actualizar</button>
										</div>
										<div class="errores"></div>
									</div>
								</form>

							</div>
							<br>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div>