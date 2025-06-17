<div id="modal_update_manual" class="modal fade" role="dialog" aria-labelledby="modalUpdateManualTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
				<h4 class="modal-title" id="modalUpdateManualTitle">Editar Manual</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Información del Manual</h3>
							</div>

							<div class="box-body">
								<form action="{{ route('manual.update') }}" name="form_update_manual" class="form_update_manual" enctype="multipart/form-data" method="post" onsubmit="new manualObj().HandleSubmitUpdate(event)">
									@csrf
									@method('PUT')
									<input type="hidden" name="id" id="id">

									<div class="form-group">
										<label for="descripcion">Descripción</label>
										<input type="text" name="descripcion" id="descripcion" class="form-control descripcion" required placeholder="Ingrese descripción (a qué equipo(s) corresponde)">
									</div>

									<div class="form-group">
										<label for="url">URL</label>
										<input type="url" class="form-control url" id="url" name="url" placeholder="Ingrese URL válida">
									</div>

									<div class="form-group text-right">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Actualizar
										</button>
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
