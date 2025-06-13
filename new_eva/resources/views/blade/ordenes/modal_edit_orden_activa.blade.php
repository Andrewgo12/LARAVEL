<div id="modal_edit_orden_activa" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Orden de trabajo</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Gestion
								</h3>
							</div>
							<div class="box-body ">
								<form action="{{ asset('') }}equipo/Cequipos/updateCalibracion" id="form_update_orden_activa" name="form_update_orden_activa" enctype="multipart/form-data" method="post">
      @csrf
									<div class="row">
										<div class="col-sm-3">
											<h4 style="font-weight: 800;">ID orden</h4>
											<p id="id"></p>
										</div>
										<div class="col-sm-6">
											<h4 style="font-weight: 800;">Fecha de creación</h4>
											<p id="fecha_inicio"></p>
										</div>
										<div class="col-sm-3">
											<h4 style="font-weight: 800;">Estado de la orden</h4>
											<p id="estado"></p>
										</div>
									</div>
									<h4 style="font-weight: 800;">Descripción</h4>
									<p id="descripcion"></p>
									<div class="row">
										<div class="col-sm-6">
											<h4 style="font-weight: 800;">Nombre del reportante</h4>
											<p id="nombre"></p>
										</div>
										<div class="col-sm-6">
											<h4 style="font-weight: 800;">Correo electronico</h4>
											<p id="email"></p>
										</div>
									</div>
									<h4 style="font-weight: 800;">Servicio del reporte</h4>
									<p id="servicio"></p>
									<h4 id="titulo_diagnostico" style="display:none;font-weight: 800;">Diagnostico</h4>
									<p id="diagnostico"></p>
									<p id="cierre"></p>
									<br>
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Archivo asociado</label>
												<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											</div>
										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_update_calibracion">Ingresar</button>
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