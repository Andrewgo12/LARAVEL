<div id="modal_add_equipo" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 85%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agregar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								@if(session('tipo_id') == 1)
									<h3 class="box-title">Equipo biomedico</h3>
								@else
									<h3 class="box-title">Equipo industrial</h3>
								@endif
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ asset('') }}equipo/Cequipos/add" id="form_equipo" name="form_equipo" enctype="multipart/form-data" method="post">
      @csrf


									<input type="hidden" id="id" name="id" class="form-control">
									<input type="hidden" id="tipo_id" name="tipo_id" class="form-control" value="{{ $tipo_id }}">
									<br>
									<div class="table-responsive">

										<div class="tg-wrap">
											<table class="tg">
												<tr>
													<th class="tg-5xx9" colspan="10">REGISTRO DE EQUIPOS {{ $tipo_id == 1 ? "BIOMEDICOS" : "INDUSTRIALES" }} HOSPITAL UNIVERSITARIO DEL VALLE "EVARISTO GARCÍA"</th>
												</tr>
												<tr>
													<td class="tg-d4yz" colspan="10">IDENTIFICACIÓN DEL EQUIPO</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Nombre del equipo:</td>

													<td class="tg-0pky text-center" colspan="4"><input autocomplete="off" type="text" class="form-control" name="name" id="name" placeholder="Nombre" list="listadoNombresFromInsert">
														<datalist id="listadoNombresFromInsert" class="datalistNombreEquipos"></datalist>

														<label for="descripcion">Descripcion adicional</label><br>
														<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion adicional">
													</td>
													<td class="tg-dxek" colspan="5">IMAGEN RELACIONADA DEL EQUIPO</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Serie:</td>
													<td class="tg-0pky text-center" colspan="1"><input type="text" class="form-control input-sm" placeholder="Serie" name="serial" id="serial"></td>
													<td class="tg-g8x9">Archivo excel Hoja de vida:</td>
													<td class="tg-0pky text-center" colspan="4"><input style="height: 50%;" type="file" id="file" name="file" onchange="return validacionArchivo()"></td>
													<td class="tg-ng7p" colspan="5" rowspan="9">
														<input type="file" class="file" id="image" name="image" onchange="return validacionImagen()" data-browse-on-zone-click="true">
													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">INV/Activo:</td>
													<td class="tg-fymr" colspan="2">Antiguo:<input class="form-control" type="text" name="codigo_antiguo" id="codigo_antiguo" placeholder="Codigo antiguo"></td>
													<td class="tg-fymr" colspan="2">Nuevo:<input type="text" class="form-control" placeholder="Codigo de inventario" name="code" id="code"></td>

												</tr>
												<tr>
													<td class="tg-g8x9">Marca:</td>

													<td class="tg-0pky" colspan="4"><input autocomplete="off" type="text" class="form-control input-sm" placeholder="Marca" name="marca" id="marca" list="listadoMarcasFromInsert">
														<datalist id="listadoMarcasFromInsert" class="datalistMarcaEquipos"></datalist>

													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Modelo:</td>
													<td class="tg-0pky" colspan="4"><input autocomplete="off" type="text" class="form-control input-sm" placeholder="modelo" name="modelo" id="modelo" list="listadoModelosFromInsert">
														<datalist id="listadoModelosFromInsert" class="datalistModeloEquipos"></datalist>

													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">R.Invima:
														<div><span title="Agregar nuevo invima" class="glyphicon glyphicon-plus" style="font-size: 10px;font-weight: 900;" data-toggle="modal" data-target="#modal_add_invima"></span><select onchange="funcion_cambio_select_add();" style="width:300px;" class="form-control " name="invima_id" id="invima_id"></select><span class="file_registro_sanitario"></span>

															<!-- <button onclick="consultar_registro(event)" class="consultar glyphicon glyphicon-search"></button> -->
															<a data-toggle="modal" data-target="#modal_consulta_invima" onclick="show_consulta_invima(event)" class="consultar btn btn-success glyphicon glyphicon-search"></a>

														</div>
													</td>
													<!-- <td class="tg-0pky" colspan="4"><input type="text" class="form-control" placeholder="Registro sanitario" name="invima" id="invima"><input type="file" name="archivo_invima" id="archivo_invima" onchange="return validacionArchivoPdf()"></td> -->
												</tr>
												<tr>
													<td class="tg-g8x9">Ubicación:</td>
													<td class="tg-0pky" colspan="4">


														<ul class="list-inline">
															<li class="list-inline-item">

																<label for="sede_id">Sede:</label>
																<select style="width: 70%;" class="form-control sede" id="sede_id" name="sede_id">
																	<option value="1">Sede Principal</option>
																	<option value="2">Sede Norte</option>
																</select>
															</li>
															<li class="list-inline-item">
																<label for="servicio_id">Servicio:</label>
																@foreach($acciones as $accion)
																	@if($accion->modulo == "servicios" && $accion->insertar == 1)
																		<a style="font-size: 10px;font-weight: 900;color: black;" data-toggle='modal' data-target='#modal_add_servicio' class="glyphicon glyphicon-plus"></a>
																	@endif
																@endforeach
																<select required="" class="form-control servicio_id" style="width:100%;" name="servicio_id" id="servicio_id">
																</select>
															</li>
															<li class="list-inline-item">
																<label for="area_id">Area:</label>
																<a style="font-size: 10px;font-weight: 900;color: black;" data-toggle='modal' data-target='#modal_add_area' class="glyphicon glyphicon-plus"></a>
																<select name="area_id" id="area_id" class="form-control area_id">

																</select>

															</li>
														</ul>

													</td>
												</tr>

												<tr>
													<td class="tg-g8x9">Piso:</td>
													<td class="tg-0pky" colspan="2">
														<div id="piso"></div>
													</td>
													<td class="tg-0pky"><span style="font-weight:700">Centro de costo:<div id="codigo_centro"></div></span></td>
													<td class="tg-0pky">
														<div id="centro"></div>
													</td>
												</tr>
												<tr>
													<td class="tg-g8x9">Equipo (Movil/fijo):</td>
													<td class="tg-0pky" colspan="2">
														<select required="" class="form-control" id="movilidad" name="movilidad">
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
														<select class="form-control tadquisicion_id" style="width: 90%;" name="tadquisicion_id" id="tadquisicion_id" required="">
															<option value="">--SELECCIONE--</option>
														</select>

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
													<td class="tg-0pky" colspan="2"><input type="date" min="1950-01-31" max="{{ date('Y-m-d') }}" class="form-control" name="fecha_ad" id="fecha_ad"></td>
													<td class="tg-pwly"><span style="font-weight:700">Fecha acta de recibo:</span></td>
													<td class="tg-0pky" colspan="6"><input type="date" min="1950-01-31" max="{{ date('Y-m-d') }}" class="form-control" name="fecha_acta_recibo" id="fecha_acta_recibo"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Fecha de instalación:</td>
													<td class="tg-0pky" colspan="2"><input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_instalacion" id="fecha_instalacion"></td>
													<td class="tg-pwly"><span style="font-weight:700">Fecha de inicio operación:</span></td>
													<td class="tg-0pky" colspan="6"><input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_inicio_operacion" id="fecha_inicio_operacion"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Fecha recepción almacen:</td>
													<td class="tg-0pky" colspan="2"><input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_recepcion_almacen" id="fecha_recepcion_almacen"></td>
													<td class="tg-pwly"><span style="font-weight:700">Fecha de fabricación:</span></td>
													<td class="tg-0pky" colspan="6"><input type="date" min="1950-01-31" max="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_fabricacion" id="fecha_fabricacion"></td>
												</tr>
												<tr>
													<td class="tg-0akb">Costo:</td>
													<td class="tg-0pky" colspan="2"><input type="number" class="form-control input-sm" placeholder="Costo" name="costo" id="costo"></td>
													<td class="tg-0akb">Vida util:</td>
													<td class="tg-0pky" colspan="6"><input type="text" class="form-control input-sm" placeholder="Vida util (años)" name="vida_util" id="vida_util"></td>
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
													<td class="tg-0pky" colspan="5">
														<div class="contenedor_periodicidad"></div>
													</td>
												</tr>
												<tr>
													<td class="tg-0akb">Frecuencia de mantenimiento:</td>
													<td class="tg-0pky" colspan="9"><select required="" class="form-control frecuencia_id" name="frecuencia_id" id="frecuencia_id"></select></td>
												</tr>
												<tr>

													<td class="tg-0akb" colspan="1">Estado actual del equipo:</td>
													<td class="tg-0pky" colspan="9">
														<!-- 														<select required="" name="estadoequipo_id" id="estadoequipo_id" class="form-control estadoequipo_id"></select> -->
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
																<input required="" class="form-control localizacion_actual" id="localizacion_actual" name="localizacion_actual" placeholder="Localización actual" type="text">

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
														<input class="input_check" type="checkbox" name="manual[]" value="operacion">Operacion
														<br><input class="input_check" type="checkbox" name="manual[]" value="mantenimiento">Mantenimiento
														<br><input class="input_check" type="checkbox" name="manual[]" value="partes">Partes
														<br><input class="input_check" type="checkbox" name="manual[]" value="despiece">Despiece
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
																@foreach($acciones as $accion)
																	@if($accion->modulo == "propietarios" && $accion->insertar == 1)
																		<span title="Agregar nuevo propietario" class="glyphicon glyphicon-plus" style="font-size: 10px;font-weight: 900;" data-toggle="modal" data-target="#modal_add_propietario"></span>
																	@endif
																@endforeach
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
														</select></td>
												</tr>
												<tr>
													<td class="tg-gj0n" colspan="10">OBSERVACIONES</td>
												</tr>
												<tr>
													<td class="tg-0lax" colspan="10">
														<div id="observacion_temporal"></div>
														<textarea class="form-control" name="observacion" id="observacion" rows="4" placeholder="Ingrese todas las observaciones que se estimen pertinentes para el seguimiento del equipo"></textarea>
													</td>
												</tr>
											</table>
										</div>


										<div class="row" id="mensaje"></div>

										<div class="box-footer">
											<button class="btn btn-primary" id="btn_update_equipo">Agregar</button>
										</div>
										<div class="errores"></div>

									</div>

								</form>



								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							<br>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div>

