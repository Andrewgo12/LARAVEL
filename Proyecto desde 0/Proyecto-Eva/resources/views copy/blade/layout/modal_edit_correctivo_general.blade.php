<div id="modal_update_correctivo_general" class="modal fade" role="dialog" aria-labelledby="modalEditCorrectivoLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
				<h4 class="modal-title" id="modalEditCorrectivoLabel">Editar Correctivo</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Datos del Correctivo</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ url('equipos_ind/Cequipos_ind/updateCorrectivoGeneral') }}" id="form_update_correctivo_general" name="form_update_correctivo_general" enctype="multipart/form-data" method="post">
									@csrf
									<input type="hidden" name="id" id="id">
									<input type="hidden" name="equipo_id" id="equipo_id">

									<div class="form-group">
										<label for="code" class="col-sm-3 control-label">Código</label>
										<div class="col-sm-9">
											<input type="text" name="code" id="code" class="form-control" placeholder="Ingrese código" required>
										</div>
									</div>

									<div class="form-group">
										<label for="description" class="col-sm-3 control-label">Descripción</label>
										<div class="col-sm-9">
											<textarea class="form-control" name="description" id="description" rows="6" placeholder="Ingrese la información del reporte, así como información descriptiva de la gestión realizada"></textarea>
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_mantenimiento" class="col-sm-3 control-label">Fecha ejecución</label>
										<div class="col-sm-9">
											<input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control" required>
										</div>
									</div>

									<div class="form-group">
										<label for="file" class="col-sm-3 control-label">Archivo asociado</label>
										<div class="col-sm-9">
											<input type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											<p class="help-block">Deje en blanco para mantener el archivo actual</p>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="submit" class="btn btn-primary" id="btn_update_correctivo">Guardar cambios</button>
										</div>
									</div>

									<div class="errores"></div>
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


