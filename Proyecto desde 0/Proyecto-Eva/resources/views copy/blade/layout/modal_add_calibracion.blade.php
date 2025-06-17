<div id="modal_add_calibracion" class="modal fade" role="dialog" aria-labelledby="modalAddCalibracionLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
				<h4 class="modal-title" id="modalAddCalibracionLabel">Agregar Calibración</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Datos de Calibración</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ url('equipos_ind/Cequipos_ind/addCalibracion') }}" id="form_calibracion" name="form_calibracion" enctype="multipart/form-data" method="post">
									@csrf
									<input type="hidden" name="equipo_id" id="id_equipos">

									<div class="form-group">
										<label for="description" class="col-sm-3 control-label">Código calibración</label>
										<div class="col-sm-9">
											<input type="text" name="description" id="description" class="form-control" placeholder="Ingrese código" required>
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_calibracion" class="col-sm-3 control-label">Fecha ejecución</label>
										<div class="col-sm-9">
											<input type="date" name="fecha_calibracion" id="fecha_calibracion" class="form-control"
												required min="2015-01-01" max="{{ date('Y-m-d', strtotime('+1 day')) }}"
												onblur="set_fecha_programada_add_calibracion()"
												onchange="set_fecha_programada_add_calibracion()">
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_programada" class="col-sm-3 control-label">Fecha programada</label>
										<div class="col-sm-9">
											<input type="date" name="fecha_programada" id="fecha_programada" class="form-control" required>
										</div>
									</div>

									<div class="form-group">
										<label for="file" class="col-sm-3 control-label">Archivo asociado</label>
										<div class="col-sm-9">
											<input type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="submit" class="btn btn-primary" id="btn_add_calibracion">Guardar calibración</button>
										</div>
									</div>

									<div class="errores"></div>
									<div class="mensaje"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
