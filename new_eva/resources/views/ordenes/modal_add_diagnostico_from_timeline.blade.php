<div id="modal_add_diagnostico_from_timeline" class="modal fade" role="dialog">
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
								<h3 class="box-title">Diagnostico
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" id="form_add_diagnostico_orden" name="form_add_diagnostico_orden" enctype="multipart/form-data" method="post">
									<div class="row">
										<div class="col-md-2">
											<label for="titulo">Codigo del informe de diagnostico</label>
										</div>
										<div class="col-md-10">
											<input required="" type="text" name="retro_diagnostico" id="retro_diagnostico" class="form-control" placeholder="Ingrese el codigo del retro de diagnostico">
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<label for="diagnostico">Descripción del diagnostico</label>
										</div>
										<div class="col-md-10">
											<textarea required="" class="form-control" name="diagnostico" id="diagnostico" rows="5" placeholder="Ingrese la informacion del diagnostico"></textarea>
										</div>
									</div><br>	

									@if(session('rol_id')<=2)

										<div class="row">
											<div class="col-md-3">
												Fecha del diagnostico
											</div>
											<div class="col-md-9">
												<input type="date" name="fecha_diagnostico" id="fecha_diagnostico">
												<input type="time" name="hora_diagnostico" id="hora_diagnostico" class="form-control">
											<span style="color: blue;font-size: 12px;font-weight: 900;">Si el campo fecha no se diligencia se guardara con la fecha actual</span><br>											
											</div>
										</div>

									<div class="row">
										<div class="col-md-2">
											<label for="orden">Quien realiza el diagnostico</label><span style="color: #d6671d;font-size: 20px;" class="glyphicon glyphicon-flag" title="Si no se llena, el que diagnostica, se asignara a esta cuenta como el usuario quien realiza el diagnostico"></span>
										</div>
										<div class="col-md-10">
											<input type="text" class="form-control" name="tecnico_diagnostico_text" id="tecnico_diagnostico_text" placeholder="Nombre y apellido de quien realiza el diagnostico">
											<span style="color: blue;font-size: 12px;font-weight: 900;">Si no se diligencia quien es el que realiza el diagnostico, se asignara a esta cuenta como el usuario quien realiza el diagnostico</span><br>
										</div>
									</div><br>											

									<div class="panel panel-default">
										<div class="panel-heading">Archivo asociado</div>
										<div class="panel-body">

											<br>
											<div class="row">
												<div class="row">
													<div class="col col-md-12">
														<label for="" class="badge">Archivo asociado</label>
														<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file_diagnostico" name="file_diagnostico">
													</div>
												</div>
											</div>	


										</div>
									</div>
									<?php endif ?>								
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_diagnostico_from_timeline">Ingresar</button>
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