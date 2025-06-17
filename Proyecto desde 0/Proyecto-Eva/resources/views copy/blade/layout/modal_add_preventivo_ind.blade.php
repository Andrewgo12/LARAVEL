<div id="modal_add_preventivo_ind" class="modal fade" role="dialog" aria-labelledby="modalAddPreventivoLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
				<h4 class="modal-title" id="modalAddPreventivoLabel">Agregar Preventivo</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Datos del Preventivo</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ url('equipos_ind/Cequipos_ind/addPreventivo') }}" id="form_preventivo_ind" name="form_preventivo" enctype="multipart/form-data" method="post">
									@csrf
									<input type="hidden" name="equipo_id" id="id_equipos">

									<div class="form-group">
										<label for="description" class="col-sm-3 control-label">Código preventivo</label>
										<div class="col-sm-9">
											<input type="text" name="description" id="description" class="form-control" placeholder="Ingrese código" required>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-4 mostrar-primer-fecha-padre">
											<label>Primer mes:</label>
											<div class="mostrar-primer-fecha"></div>
										</div>
										<div class="col-sm-4 mostrar-segunda-fecha-padre">
											<label>Segundo mes:</label>
											<div class="mostrar-segunda-fecha"></div>
										</div>
										<div class="col-sm-4 mostrar-tercer-fecha-padre">
											<label>Tercer mes:</label>
											<div class="mostrar-tercer-fecha"></div>
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_mantenimiento" class="col-sm-3 control-label">Fecha ejecución</label>
										<div class="col-sm-9">
											<input type="date" class="form-control" name="fecha_mantenimiento" id="fecha_mantenimiento"
												required min="2015-01-01" max="{{ date('Y-m-d', strtotime('+1 day')) }}"
												onblur="set_fecha_programada_add()" onchange="set_fecha_programada_add()">
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_programada" class="col-sm-3 control-label">Fecha programada</label>
										<div class="col-sm-9">
											<input type="date" class="form-control" name="fecha_programada" id="fecha_programada" required>
										</div>
									</div>

									<div class="form-group">
										<label for="file" class="col-sm-3 control-label">Archivo asociado</label>
										<div class="col-sm-9">
											<input type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											<p class="help-block">Seleccione el archivo de respaldo para este preventivo</p>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="submit" class="btn btn-primary" id="btn_add_preventivo_ind">Guardar preventivo</button>
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
