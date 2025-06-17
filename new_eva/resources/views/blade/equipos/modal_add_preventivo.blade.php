<div id="modal_add_preventivo" class="modal fade" role="dialog">
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
								<h3 class="box-title">Preventivo</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ asset('') }}equipo/Cequipos/addPreventivo" id="form_preventivo" name="form_preventivo" enctype="multipart/form-data" method="post">
									@csrf
									<br>
									<input type="hidden" name="equipo_id" id="equipo_id">
									<div class="row">
										<div class="col-sm-2">
											<label for="description">Código preventivo</label>
										</div>
										<div class="col-sm-4">
											<input type="text" name="description" id="description" class="form-control" placeholder="Código" required>
										</div>
										<div class="col-sm-2">
											<label for="proveedor_mantenimiento_id">Proveedor mantenimiento</label>
										</div>
										<div class="col-sm-4">
											<select required class="form-control" name="proveedor_mantenimiento_id" id="proveedor_mantenimiento_id">
											</select>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-9">
											<label for="observacion">Observaciones</label>
											<textarea class="form-control" id="observacion" name="observacion"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-4 mostrar-primer-fecha-padre">
											<label for="primer_mes">Primer mes:</label><br>
											<div class="mostrar-primer-fecha"></div>
										</div>
										<div class="col-sm-4 mostrar-segunda-fecha-padre">
											<label for="segundo_mes">Segundo mes:</label><br>
											<div class="mostrar-segunda-fecha"></div>
										</div>
										<div class="col-sm-4 mostrar-tercer-fecha-padre">
											<label for="tercer_mes">Tercer mes:</label><br>
											<div class="mostrar-tercer-fecha"></div>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-2">
											<label for="fecha_mantenimiento">Fecha ejecución</label>
										</div>
										@php
											$fecha_superior = date("Y-m-d", strtotime(date("Y-m-d")."+ 1 month"));
										@endphp
										<div class="col-sm-4">
											<input type="date" class="form-control" name="fecha_mantenimiento" id="fecha_mantenimiento" required min="2015-01-01" max="{{ $fecha_superior }}" onblur="set_fecha_programada_add()" onchange="set_fecha_programada_add()">
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
											<label for="repuesto_id" class="badge">Repuesto pendiente</label>
											<input class="form-control" type="text" name="repuesto_id" id="repuesto_id">
										</div>
									</div>

									<div class="box-footer">
										<button type="submit" class="btn btn-primary" id="btn_add_preventivo">Ingresar</button>
									</div>
									<div class="errores"></div>
									<div class="mensaje"></div>
								</form>
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
</div>

