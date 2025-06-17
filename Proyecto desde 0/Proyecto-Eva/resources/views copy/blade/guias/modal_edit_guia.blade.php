<div id="modal_update_guia" class="modal fade" role="dialog">
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
								<h3 class="box-title">Guia rapida</h3>
							</div>

							<div class="box-body form-horizontal">
								<form action="{{ route('guia.update') }}" id="form_update_guia" name="form_update_guia" class="form_update_guia" enctype="multipart/form-data" method="post">
									@csrf
									@method('PUT')
									<span class="mensaje-guia-error"></span>
									<input type="hidden" id="id" name="id" class="id">

									<div class="form-group">
										<label for="name" class="col-sm-2 control-label">Nombre</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="name" id="name" placeholder="Nombre">
										</div>
									</div>

									<div class="form-group">
										<label for="estado" class="col-sm-2 control-label">Estado</label>
										<div class="col-sm-10">
											<select name="estado" id="estado" class="form-control">
												<option value="1">Activo</option>
												<option value="0">Inactivo</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label for="file" class="col-sm-2 control-label">Archivo</label>
										<div class="col-sm-10">
											<input type="file" class="file" name="file" id="file" data-browse-on-zone-click="true">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-primary">Actualizar</button>
										</div>
									</div>
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
