<div id="modal_add_orden" class="modal fade" role="dialog">
	<div class="modal-dialog">
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

								<form action="{{ asset('') }}orden/Cordenes/add" id="form_orden" name="form_orden" enctype="multipart/form-data" method="post">
      @csrf
									<input type="hidden" name="seleccionado" id="seleccionado">

									<div class="row">
										<div class="col-sm-7">
											<label for="">Proceso al cual reportar</label>
											<select required="required" name="proceso" id="proceso" class="form-control">
												<option value="">--Seleccione--</option>
											</select>
										</div>
										<div class="col-sm-5">
											<label for="subproceso">Area del proceso</label>
											<select required="" required="required" name="subproceso_id" id="subproceso" class="form-control">
												<option value="">--Seleccione--</option>											
											</select>
										</div>
									</div>
									<br>
									<?php if ({{ session('rol_id') }}<=2): ?>

										<div class="row">
											<div class="col-sm-12 ">
												Reportante Origen (Sección visible para el administrador) <br>
												<input class="seleccion_reportante" type="radio" name="seleccion_reportante" value="propio" checked="" >Propio
												<input class="seleccion_reportante" type="radio" name="seleccion_reportante" value="otro">Otro
												<br>
												<div class="mensaje_aclaratorio">
													<h3>
														!!
														<small class="text-muted">Si se selecciona propio el Ticket sera almacenado con la información del administrador como reportante</small>
													</h3>																
													
												</div>
												<div class="contenedor_seleccion_reportante" style="display: none;">
													<div class="row">
														<div class="col-sm-6">
															<label for="nombre_reportante">Nombre del reportante:</label><br>
															<input class="form-control informacion_otro_reportante" required="" type="text" name="nombre_reportante" id="nombre_reportante" disabled="" placeholder="Nombre del reportante">
														</div>
														<div class="col-sm-6">
															<label for="servicio_reportante">Centro de costo del reportante:</label><br>
															<select style="width: 100%;" class="form-control informacion_otro_reportante" name="centro_costo" id="centro_costo" required=""></select>

														</div>
													</div>
												</div>
											</div>
										</div><br>
									<?php endif ?>

									<div class="form-group">
										<div class="col-sm-12">
											<label for="servicio_id" class="control-label">Ubicación de referencia</label><br>
											<select name="servicio_id" id="servicio_id" class="form-control" style="width:90%" required="">
												<option value="">--Seleccione--</option>>
											</select>
											<a href="#" data-toggle="modal" data-target="#modal_add_servicio" class="fa fa-info btn bnt-default"></a>
										</div>
									</div>

									<div class="subproceso_1"><!--subproceso_1-->
										<input type="hidden" name="equipo_id" id="equipo_id">
										<div class="row">
											<div class="col-sm-2">
												<label for="serie_equipo">Serie del equipo</label>
											</div>
											<div class="col-sm-4">
												<input autocomplete="off" type="text" class="form-control" name="serie_equipo" id="serial" placeholder="serie del equipo">
												<ul id="respuesta_serie" class="list-group dropdown-menu"></ul>
											</div>
											<div class="col-sm-2">
												<label for="codigo_equipo">Activo fijo</label>
											</div>
											<div class="col-sm-4">
												<input autocomplete="off" type="text" class="form-control" name="codigo_equipo" id="codigo_equipo" placeholder="Numero de inventario">

												<ul id="respuesta_codigo" class="list-group dropdown-menu"></ul>
											</div>
										</div>

										<div class="form-group">
											<label for="nombre_equipo" class="col-sm-2 control-label">Nombre del equipo</label>

											<div class="col-sm-10">
												<input type="text" class="form-control" name="nombre_equipo" id="nombre_equipo" placeholder="Nombre">
											</div>
										</div>
										<div class="form-group">
											<label for="modelo_equipo" class="col-sm-2 control-label">Modelo del equipo</label>

											<div class="col-sm-10">
												<input type="text" class="form-control" name="modelo_equipo" id="modelo_equipo" placeholder="Modelo del equipo">
											</div>
										</div>
										<div class="form-group">
											<label for="modelo_equipo" class="col-sm-2 control-label">Marca del equipo</label>

											<div class="col-sm-10">
												<input type="text" class="form-control" name="marca_equipo" id="marca_equipo" placeholder="Marca del equipo">
											</div>
										</div>
									</div><!--fin del div subproceso_1-->



									<div class="subproceso_2"><!--subproceso_2-->
										<input type="hidden" name="equipo_id" id="equipo_id_2">
										<div class="form-group">
											<label for="arreglo" class="col-sm-2 control-label">Tipo de arreglo: </label>
											<div class="row">
												<input type="checkbox" id="Locativo">Locativo</input>
												<input type="checkbox" id="Electrico">Electrico</input>
												<input type="checkbox" id="Mecanico">Mecanico</input>
											</div>
										</div>


										<div class="row">
											<div class="col-sm-2">
												<label for="serie_equipo">Serie del equipo</label>
											</div>
											<div class="col-sm-4">
												<input autocomplete="off" type="text" class="form-control" name="serie_equipo" id="serial_2" placeholder="serie del equipo">
												<ul id="respuesta_serie_2" class="list-group dropdown-menu"></ul>
											</div>
											<div class="col-sm-2">
												<label for="codigo_equipo">Activo fijo</label>
											</div>
											<div class="col-sm-4">
												<input autocomplete="off" type="text" class="form-control" name="codigo_equipo" id="codigo_equipo_2" placeholder="Numero de inventario">

												<ul id="respuesta_codigo_2" class="list-group dropdown-menu"></ul>
											</div>
										</div>

										<div class="form-group">
											<label for="nombre_equipo" class="col-sm-2 control-label">Nombre del equipo</label>

											<div class="col-sm-10">
												<input type="text" class="form-control" name="nombre_equipo" id="nombre_equipo_2" placeholder="Nombre">
											</div>
										</div>
										<div class="form-group">
											<label for="modelo_equipo" class="col-sm-2 control-label">Modelo del equipo</label>

											<div class="col-sm-10">
												<input type="text" class="form-control" name="modelo_equipo" id="modelo_equipo_2" placeholder="Modelo del equipo">
											</div>
										</div>
										<div class="form-group">
											<label for="modelo_equipo" class="col-sm-2 control-label">Marca del equipo</label>

											<div class="col-sm-10">
												<input type="text" class="form-control" name="marca_equipo" id="marca_equipo_2" placeholder="Marca del equipo">
											</div>
										</div>
									</div><!--fin subproceso_2-->






									<div class="row">
										<div class="col-sm-6">
											<label for="asunto">Asunto del Ticket</label><br>
											<input required="" class="form-control" type="text" id="asunto" name="asunto" placeholder="Asunto">
										</div>

										<div class="col-sm-6">
											<label for="prioridad">Prioridad</label><br>
											<select class="form-control" required="" name="prioridad" id="prioridad">
												<option value="">---Seleccione---</option>
												<option value="baja">Baja</option>
												<option value="media">Media</option>
												<option value="alta">Alta</option>
											</select>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-12">
											<label for="descripcion">Descripción del problema</label><br>
											<textarea class="form-control" id="descripcion" name="descripcion"  maxlength="450" placeholder="Describa detalladamente el problema presentado (minimo 30 caracteres)"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col col-sm-12">
											<label for="" class="badge">Imagen</label>
											<!-- <span><strong>Imagen del equipo</strong></span> -->
											<input data-browse-on-zone-click="true" type="file" class="file"  id="image" name="image" onchange="return validacionImagen()">
										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_orden">Ingresar</button>
									</div>

								</form>
								<h1><div id="mensaje"></div></h1>
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