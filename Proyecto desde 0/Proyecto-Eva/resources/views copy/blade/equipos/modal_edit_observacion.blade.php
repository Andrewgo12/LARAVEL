<div id="modal_update_observacion" class="modal fade" role="dialog">
	<div class="modal-dialog">
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
								<h3 class="box-title">Observación</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ asset('') }}equipo/Cequipos/updateObservacion" id="form_update_observacion" name="form_update_observacion" enctype="multipart/form-data" method="post">
									@csrf
									<br>
									<input type="hidden" name="id" id="id">
									<input type="hidden" name="equipo_id" id="equipo_id">

									<div class="row">
										<div class="col-sm-2">
											<label for="description">Descripción</label>
										</div>
										<div class="col-sm-10">
											<textarea class="form-control" name="description" id="description" rows="10" placeholder="Ingrese la observación a consignar"></textarea>
										</div>
									</div><br>

									<div class="row">
										<div class="col-sm-12">
											<label for="file" class="badge">Archivo asociado</label>
											<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
										</div>
									</div>

									<div class="panel panel-warning">
										<div class="panel-heading">Repuesto pendiente</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-12">
													<br>
													<label for="repuesto_pendiente" class="badge">Repuesto pendiente</label>
													<input type="checkbox" id="repuesto_pendiente" name="repuesto_pendiente" class="repuesto_pendiente">
													<span>Al seleccionar se guarda automáticamente que el equipo tiene un repuesto pendiente.</span>
													<hr>
													<input class="form-control" type="text" name="repuesto_id" id="repuesto_id" placeholder="Repuesto pendiente">
													<small class="text-muted">Para que se guarde cuál es el repuesto pendiente hay que actualizar.</small>
												</div>
											</div>
										</div>
									</div>

									<div class="box-footer">
										<button type="submit" class="btn btn-primary" id="btn_update_observacion">Ingresar</button>
									</div>
									<div class="errores"></div>
								</form>
							</div>
							<br>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>

