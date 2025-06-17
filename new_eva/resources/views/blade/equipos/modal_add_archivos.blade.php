<div id="modal_add_archivo" class="modal fade" role="dialog">
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
								<h3 class="box-title">Equipo</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ asset('') }}equipo/Cequipos/add_archivo" id="form_equipo_archivo" name="form_equipo_archivo" enctype="multipart/form-data" method="post">
									@csrf
									<br>
									<input type="hidden" id="equipo_id" name="equipo_id">
									<div class="row">
										<div class="col col-sm-2">
											<div>
												<label for="archivo_id">Tipo de archivo:</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div>
												<select name="archivo_id" id="archivo_id" class="form-control">
												</select>
											</div>
										</div>
									</div>
									<br>
									<div class="contenedor_fecha_capacitacion">
									</div>
									<div class="row">
										<div class="col-sm-2">
											<label for="vinculo">Archivo:</label>
										</div>
										<div class="col-sm-6">
											<input required type="file" name="vinculo" id="vinculo" class="file" data-browse-on-zone-click="true">
										</div>
									</div>
									<div class="box-footer">
										<button type="submit" class="btn btn-primary" id="btn_add_archivo">Insertar</button>
									</div>
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
