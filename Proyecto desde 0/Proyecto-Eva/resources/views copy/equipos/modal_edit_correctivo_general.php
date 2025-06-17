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

								<form action="<?php echo base_url();?>equipo/Cequipos/updateCorrectivoGeneral" id="form_update_correctivo_general" name="form_update_correctivo_general" enctype="multipart/form-data" method="post">
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
													<input type="text" name="code_orden" id="code_orden" class="form-control" placeholder="Codigo de orden" >
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="orden">Descripción de la orden de trabajo</label>
												</div>
												<div class="col-sm-10">
													<textarea class="form-control" name="orden" id="orden" rows="10" placeholder="Ingrese la informacion de la orden"></textarea>
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="fecha_inicio">Fecha en que se hace el reporte</label>
												</div>
												<div class="col-sm-4">
													<input min="2015-01-01" type="date" name="fecha_inicio" id="fecha_inicio"  class="form-control"><input type="time" name="hora_orden" id="hora_orden" class="form-control">
												</div>
											</div>  	
										</div>
									</div>									
									<div class="panel panel-primary">
										<div class="panel-heading">Diagnostico</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-2">
													<label for="code_diagnostico">Codigo del diagnostico</label>
												</div>
												<div class="col-sm-6">
													<input type="text" name="code_diagnostico" id="code_diagnostico" class="form-control" placeholder="Codigo" >
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="diagnostico">Descripcion del diagnostico realizado</label>
												</div>
												<div class="col-sm-10">
													<textarea class="form-control" name="diagnostico" id="diagnostico" rows="10" placeholder="Ingrese la informacion del diagnostico"></textarea>
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="fecha_diagnostico">Fecha diagnostico</label>
												</div>
												<div class="col-sm-8">
													<input min="2015-01-01" type="date" name="fecha_diagnostico" id="fecha_diagnostico"  class="form-control"><input type="time" name="hora_diagnostico" id="hora_diagnostico" class="form-control">
												</div>
											</div>  	

										</div>
									</div>									
									<div class="panel panel-success">
										<div class="panel-heading">Cierre</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-2">
													<label for="code">Codigo</label>
												</div>
												<div class="col-sm-6">
													<input type="text" name="code" id="code" class="form-control" placeholder="Codigo" >
												</div>
											</div><br>
											<div class="row">
												<div class="col-sm-2">
													<label for="description">Descripcion</label>
												</div>
												<div class="col-sm-10">
													<textarea class="form-control" name="description" id="description" rows="10" placeholder="Ingrese la informacion del reporte, asi como informacion descriptiva de la gesiton realizada"></textarea>
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
													<label for="fecha_calibracion">Codigo de Cierre</label>
													<select required="" disabled="" id="cierre_id" name="cierre_id" class="form-control">	
													</select>
												</div>
											</div>  	
 	

										</div>
									</div>									

									<div class="panel panel-warning">
										<div class="panel-heading">Repuesto pendiente</div>
										<div class="panel-body">
											<div class="row">
												<div class="col col-sm-12">
													<br>
													<label for="" class="badge">Repuesto pendiente</label>

													<input type="checkbox" id="repuesto_pendiente" name="repuesto_pendiente" class="repuesto_pendiente"> Al seleccionar se guarda automaticamente que el equipo tiene un repuesto pendiente.
													<hr>
													<!--<select class="form-control repuesto_id" id="repuesto_id" name="repuesto_id"></select>-->
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



								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
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