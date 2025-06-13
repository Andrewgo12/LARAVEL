<div id="modal_add_otros" class="modal fade contenedor-orden" role="dialog">
	<div class="modal-dialog" style="width: 75%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title lead">Nueva orden de trabajo</h4>
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

								<form action="{{ url('/') }}orden/Cordenes/add" id="form_orden_otros" name="form_orden_otros" class="form_orden" enctype="multipart/form-data" method="post">
									<input type="hidden" value="4" name="empresa_id">

									@if(session('rol_id') <= 2)
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
																<li><input class="seleccion_reportante_otros" type="radio" name="seleccion_reportante" value="propio" checked="">Propio</li>
																<li><input class="seleccion_reportante_otros" type="radio" name="seleccion_reportante" value="otro">Otro</li>
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
									<input type="hidden" id="subproceso_id" name="subproceso_id" class="subproceso_id" value="3">
									<!--panel ubicacion-->


									<div class="panel panel-default">
										<div class="panel-heading">
											Información del reporte
										</div>
										<div class="panel-body">
											<!-- 											<ul class="list-inline">
												<li class="list-inline-item">
													Arreglo:
												</li>
												<li class="list-inline-item">
													
														<input class="form-check-input" type="checkbox" name="mecanico" id="mecanico" value="true">
														<label class="form-check-label" for="mecanico">Mecanico</label>
												</li>
												<li class="list-inline-item">
													
														<input class="form-check-input" type="checkbox" name="electrico" id="electrico" value="true">
														<label class="form-check-label" for="electrico">Electrico</label>
												</li>
												<li class="list-inline-item">
													
														<input class="form-check-input" type="checkbox" name="locativo" id="locativo" value="true">
														<label class="form-check-label" for="locativo">Locativo</label>
												</li>

											</ul> -->
											<div class="col-sm-6">
												<label for="asunto">Asunto</label><br>
												<input required="" class="form-control" type="text" id="asunto" name="asunto" placeholder="Asunto">
											</div>

											<!-- 											<div class="col-sm-6">
												<label for="prioridad">Prioridad</label><br>
												<select class="form-control" required="" name="prioridad" id="prioridad">
													<option value="">---Seleccione---</option>
													<option value="baja">Baja</option>
													<option value="media">Media</option>
													<option value="alta">Alta</option>
												</select>
											</div> -->
											<div class="col-sm-12">
												<label for="descripcion">Descripción del problema</label><br>
												<textarea class="form-control" id="descripcion" name="descripcion" maxlength="450" placeholder="Describa detalladamente el problema presentado (minimo 30 caracteres)"></textarea>
											</div>

										</div>
									</div>

									<!--panel equipo-->
									<div class="panel panel-default">

									</div>

									<div class="panel panel-default">
										<div class="panel-heading">
											Ubicación actual del elemento
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
													<select title="ubicación actual del equipo biomedico" name="servicio_id" id="" class="select2 form-control servicio_id" style="width:100%" required="">
														<option value="">--------------</option>
													</select>

												</div>
												<div class="col-sm-4">
													<label for="area_id" class="control-label">Area</label><br>
													<select title="ubicación actual del equipo biomedico" name="area_id" id="area_id" class="form-control area_id select_especial" style="width:100%">
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
										<button class="btn btn-primary btn_add_orden_otros" id="btn_add_orden_otros">Ingresar</button>
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