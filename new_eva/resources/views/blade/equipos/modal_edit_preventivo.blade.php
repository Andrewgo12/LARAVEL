<div id="modal_update_preventivo" class="modal fade" role="dialog">
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
								<h3 class="box-title">Preventivo</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ asset('') }}equipo/Cequipos/updatePreventivo" id="form_update_preventivo" name="form_update_preventivo" enctype="multipart/form-data" method="post">
									@csrf
									<br>
									<input type="hidden" name="id" id="id">
									<input type="hidden" name="equipo_id" id="equipo_id">
									<div class="row">
										<div class="col-sm-2">
											<label for="description">Código preventivo</label>
										</div>
										<div class="col-sm-6">
											<input type="text" name="description" id="description" class="form-control" placeholder="Código" required>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-9">
											<label for="observacion">Observaciones</label>
											<textarea class="form-control" id="observacion" name="observacion"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-2">
											<label for="fecha_mantenimiento">Fecha ejecución</label>
										</div>
										@php
											$fecha_superior = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 month"));
										@endphp
										<div class="col-sm-4">
											<input type="date" class="form-control" name="fecha_mantenimiento" id="fecha_mantenimiento" required min="2015-01-01" max="{{ $fecha_superior }}" onblur="set_fecha_programada_edit()" onchange="set_fecha_programada_edit()">
										</div>
										<div class="col-sm-2">
											<label for="fecha_programada">Fecha programada</label>
										</div>
										<div class="col-sm-4">
											<input type="date" class="form-control" name="fecha_programada" id="fecha_programada" required>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<label for="file" class="badge">Archivo asociado</label>
											<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<br>
											<label for="repuesto_pendiente" class="badge">Repuesto pendiente</label>
											<input type="checkbox" id="repuesto_pendiente" name="repuesto_pendiente" class="repuesto_pendiente">
											<input class="form-control" type="text" name="repuesto_id" id="repuesto_id">
										</div>
									</div>
									<div class="box-footer">
										<button type="submit" class="btn btn-primary" id="btn_update_preventivo">Ingresar</button>
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
