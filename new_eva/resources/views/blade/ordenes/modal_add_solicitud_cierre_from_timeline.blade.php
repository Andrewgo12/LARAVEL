<div id="modal_add_solicitud_cierre_from_timeline" class="modal fade" role="dialog">
	<div class="modal-dialog">
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
								<h3 class="box-title">Trabajo realizado
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" id="form_add_solicitud_cierre_orden" name="form_add_solicitud_cierre_orden" enctype="multipart/form-data" method="post">
      @csrf
									<div class="row">
										<div class="col-md-2">
											<label for="retro_cierre">Codigo del retro de cierre</label>
										</div>
										<div class="col-md-10">
											<input required="" type="text" name="retro_cierre" id="retro_cierre" class="form-control" placeholder="Codigo">
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<label for="reparacion">Descripción del trabajo realizado</label>
										</div>
										<div class="col-md-10">
											<textarea required="" class="form-control" name="reparacion" id="reparacion" rows="5" placeholder="Ingrese la informacion del trabajo realizado"></textarea>
										</div>
									</div><br>	
									<?php if ({{ session('rol_id') }}<=2): ?>
										<div class="row">
											<div class="col-md-3">
												Fecha del procedimiento correctivo
											</div>
											<div class="col-md-9">
												<input type="date" name="fecha_asignacion_cierre" id="fecha_asignacion_cierre" class="form-control">
												<input type="time" name="hora_asignacion_cierre" id="hora_asignacion_cierre" class="form-control">
											<span style="color: blue;font-size: 12px;font-weight: 900;">Si el campo fecha no se diligencia se guardara con la fecha actual</span><br>
											</div>
										</div>										

										<div class="row">
											<div class="col-md-2">
												<label for="orden">Tecnico que realiza procedimiento correctivo</label><span style="color: #d6671d;font-size: 20px;" autofocus="" class="glyphicon glyphicon-flag" title="Si no se llena, esta cuenta quedara como la que realiza el procedimiento correctivo"></span>
											</div>
											<div class="col-md-10">
												<input type="text" class="form-control" name="tecnico_cierre_text" id="tecnico_cierre_text" placeholder="Nombre y apellido de quien realiza el procedimiento correctivo">
												<span style="color: blue;font-size: 12px;font-weight: 900;">Si no se diligencia quien es el que realiza el procedimiento correctivo, se asignara a esta cuenta como el usuario quien realiza el procedimiento correctivo</span><br>
											</div>
										</div><br>											

									<?php endif ?>	
									<div class="panel panel-default">
										<div class="panel-heading">Archivo asociado</div>
										<div class="panel-body">



											<div class="row">
												<div class="row">
													<div class="col col-md-12">
														<label for="" class="badge">Archivo asociado</label>
														<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file_cierre" name="file_cierre">
													</div>
												</div>
											</div>	


										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_solicitud_cierre_from_timeline">Ingresar</button>
									</div>

								</form>



								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							

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