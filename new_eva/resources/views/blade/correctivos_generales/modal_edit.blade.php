<div id="modal_update_correctivo_general" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 75%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Correctivo
								</h3>
							</div>
							<div class="box-body form-horizontal">
								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
								<form action="{{ asset('') }}equipo/Cequipos/updateCorrectivoGeneral" id="form_update_correctivo_general" name="form_update_correctivo_general" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<input type="hidden" name="id" id="id">
									<input type="hidden" name="equipo_id" id="equipo_id">

									<div class="panel panel-danger">
										<div class="panel-heading">Orden de trabajo</div>
										<div class="panel-body">

											<div class="row">
												<div class="col-sm-2">
													<label for="code">Codigo de la orden</label>
												</div>
												<div class="col-sm-6">
													<input type="text" name="code_orden" id="code_orden" class="form-control" placeholder="Codigo de orden">
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="orden">Descripción de la orden de trabajo</label>
												</div>
												<div class="col-sm-10">
													<textarea class="form-control" name="orden" id="orden" rows="6" placeholder="Ingrese la informacion de la orden"></textarea>
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="fecha_inicio">Fecha de la orden</label>
												</div>
												<div class="col-sm-4">
													<input min="2015-01-01" type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"><input type="time" name="hora_orden" id="hora_orden" class="form-control">
												</div>
											</div>
										</div>
									</div>
									<p>
										<a href="" class="btn btn-default" data-toggle="modal" data-target="#modal_add_avance_correctivo" onclick="funcion_recobrar_id_correctivo(event)">Agregar avance</a>
									</p>
									<p>

										<span class="listado-avances-correctivos"></span>
									</p>
									<div class="panel panel-success">
										<div class="panel-heading">Cierre</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-2">
													<label for="code">Codigo</label>
												</div>
												<div class="col-sm-6">
													<input type="text" name="code" id="code" class="form-control" placeholder="Codigo">
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="description">Descripcion</label>
												</div>
												<div class="col-sm-10">
													<textarea class="form-control" name="description" id="description" rows="6" placeholder="Ingrese la informacion del reporte, asi como informacion descriptiva de la gesiton realizada"></textarea>
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="fecha_calibracion">Fecha ejecución</label>
												</div>
												<div class="col-sm-4">
													<input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control"><input type="time" name="hora_mantenimiento" id="hora_mantenimiento" class="form-control">
												</div>
												<div class="col-sm-5">
													<label for="cierre_id">Codigo de Cierre</label>
													<select required="" id="cierre_id" name="cierre_id" class="form-control">
													</select>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-sm-2">
													<label for="tipo_falla_id">Tipo de falla</label>
												</div>
												<div class="col-sm-5">
													<select name="tipo_falla_id" id="tipo_falla_id" class="form-control tipo_falla_id">-----</select>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">Archivo asociado</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-2">
													<label for="titulo">Titulo del archivo</label>
												</div>
												<div class="col-sm-10">
													<input type="text" name="titulo" id="titulo" class="form-control" placeholder="En caso de  agregar archivo, ingrese un titulo de referencia">
												</div>
											</div>
											<div class="row">
												<div class="row">
													<div class="col col-sm-12">
														<label for="" class="badge">Archivo asociado</label>
														<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-warning">
										<div class="panel-heading">Repuesto instalado</div>
										<div class="panel-body">
											<div class="row">
												<div class="col col-sm-12">
													<br>
													<label for="repuesto_instalado" class="badge">Repuesto instalado</label>
													<a href="" class="esconder btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_repuesto_correctivo_general" style="font-size: 5px;"></a>
												</div>
												<div class="col col-sm-12">
													<br>
													<table class="table table-bordered tblEquipoRepuestos">
														<thead>
															<tr>
																<th>REPUESTO/ACCESORIO</th>
																<th>OBSERVACION</th>
																<th>FECHA DE INSTALACION</th>
																<th>CANTIDAD ENTREGADAs</th>
																<th class="esconder">ARCHIVO RELACIONADO</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-warning">
										<div class="panel-heading">Repuesto pendiente</div>
										<div class="panel-body">
											<div class="row">
												<div class="col col-sm-12">
													<div class="col col-sm-3">
														<label for="" class="badge">Repuesto pendiente</label>
													</div>
													<div class="col col-sm-4">
														<button class="btn btn-info glyphicon glyphicon-plus btn-xs add_new_rep"></input>
													</div>
													<div class="containerrep_table"></div>
													<div class="containerrep"></div>
													<input type="checkbox" id="repuesto_pendiente" name="repuesto_pendiente" class="repuesto_pendiente"> Al seleccionar se guarda automaticamente que el equipo tiene un repuesto pendiente.
													<hr>
													<input class="form-control" type="repuesto_id" name="repuesto_id" id="repuesto_id" placeholder="Repuesto pendiente">
													Para que se guarde cual es el repuesto pendiente hay que actualizar !!!!!
												</div>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_update_correctivo_general">Actualizar</button>
									</div>
									<div class="errores"></div>
								</form>
							</div>
							<br>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>
</div>