<div id="modal_add_industriales" class="modal fade contenedor-orden" role="dialog">
	<div class="modal-dialog" style="width: 75%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title lead">Nueva orden de trabajo equipos industriales</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="<?php echo base_url(); ?>orden/Cordenes/add" id="form_orden_industriales" name="form_orden_industriales" class="form_orden" enctype="multipart/form-data" method="post">
									<input type="hidden" value="4" name="empresa_id">

									<?php if ($this->session->userdata("rol_id") <= 2) : ?>
										<div class="panel panel-default">

											<!--panel reportante-->
											<div class="panel-heading">
												Reportante <div class="small text-muted">(Sección visible para el administrador)</div>
											</div>
											<div class="panel-body">


												<div class="row">
													<div class="col-sm-12 ">
														<div class="panel panel-default">
															<br>
															<ul>
																<li><input class="seleccion_reportante_industriales" type="radio" name="seleccion_reportante" value="propio" checked="">Propio</li>
																<li><input class="seleccion_reportante_industriales" type="radio" name="seleccion_reportante" value="otro">Otro</li>
															</ul>


															<br>

														</div>
														<div class="mensaje_aclaratorio">
															<h3>
																!!
																<small class="text-muted">Si se selecciona propio el Ticket sera almacenado con la información del administrador como reportante</small>
															</h3>

														</div>
														<div class="contenedor_seleccion_reportante">
														</div>
													</div>
												</div><br>
											</div>

										</div>

									<?php endif ?>
									<input type="hidden" id="subproceso_id" name="subproceso_id" class="subproceso_id" value="2">
									<!--panel ubicacion-->



									<div class="panel panel-default">
										<div class="panel-heading">
											Información del reporte
										</div>
										<div class="panel-body">

											<div class="col-sm-6">
												<label for="asunto">Asunto</label><br>
												<input required="" class="form-control" type="text" id="asunto" name="asunto" placeholder="Asunto">
											</div>
											<div class="col-sm-12">
												<label for="descripcion">Descripción del problema</label><br>
												<textarea class="form-control" id="descripcion" name="descripcion" maxlength="450" placeholder="Describa detalladamente el problema presentado (minimo 30 caracteres)"></textarea>
											</div>

										</div>
									</div>

									<!--panel equipo-->
									<div class="panel panel-default">
										<div class="panel-heading">
											Información del equipo
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-xs-5">
													<label for="listado_industrial_id">Seleccione tipo de equipo</label><br>
													<select style="width: 100%;" name="listado_industrial_id" class="form-control listado_industrial_id" id="listado_industrial_id"></select>
												</div>
												<div class="col-xs-4">
													<a title="Seleccionar equipo" style="color:#20123a;font-weight: 1000;font-size: 25px;" onclick="funcion_get_equipos_biomedicos(2)" href="" class="fa fa-search" data-toggle="modal" data-target="#modal_consulta_equipos_biomedicos"></a><small class="text-muted">Buscar equipo en la base de datos</small>
													<p>
														<span class="resultado_seleccion_equipo">

														</span>
													</p>
												</div>
												<div class="col-xs-12">
													<div><a onclick="set_manual(event)" href="" class="btn btn-light fa fa-pencil"></a><small class="text-muted">Ingresar de Forma Manual</small></div>

												</div>
												<input class="form-control equipo_id" type="hidden" name="equipo_id" id="equipo_id">

											</div>

										</div>
									</div>

									<div class="panel panel-default panel-ubicacion">
										<div class="panel-heading">
											Ubicación donde esta actualmente el equipo

										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-4">
													<label for="sede_id" class="control-label">Sede:</label><br>
													<select title="Sede" name="sede_id" id="" class="form-control sede_id" style="width:100%" required="">
														<option value="1">Principal</option>
														<option value="2">Norte</option>
													</select>

												</div>
												<div class="col-sm-4">
													<label for="servicio_id" class="control-label">Servicio</label><br>
													<select title="Servicio actual del equipo industrial" name="servicio_id" id="" class="select2 form-control servicio_id" style="width:100%" required="">
														<option value="">--------------</option>
													</select>

												</div>
												<div class="col-sm-4">
													<label for="area_id" class="control-label">Area</label><br>
													<select title="Area actual del equipo industrial" name="area_id" id="area_id" class="form-control area_id select_especial" style="width:100%">
														<option value="">-----</option>
													</select>

												</div>
											</div><br>
										</div>
									</div>
									<div class="row">
									</div>
									<div class="form-group">
										<div class="col col-sm-12">
											<label for="" class="badge">Archivo relacionado</label>
											<!-- <span><strong>Imagen del equipo</strong></span> -->
											<input data-browse-on-zone-click="true" type="file" class="file" id="image" name="image">
										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary btn_add_orden" id="btn_add_orden" disabled="">Ingresar</button>
									</div>

								</form>
								<h1>
									<div id="mensaje"></div>
								</h1>
								<div id="errores"></div>

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
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