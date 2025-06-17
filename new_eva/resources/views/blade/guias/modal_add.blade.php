<div id="modal_add" class="modal fade" role="dialog">
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
								<h3 class="box-title">Guia rapida</h3>
							</div>

							<div class="box-body form-horizontal">
								<!-- Formulario de guía rápida -->
								<form action="{{ route('guia.store') }}" id="form_guia" name="form_guia" class="form_guia" enctype="multipart/form-data" method="post">
									@csrf
									<span class="mensaje-guia-error"></span>
									<div class="form-group">
										<label for="name" class="col-sm-2 control-label">Nombre</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="name" id="name" placeholder="Nombre">
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
											<button type="submit" class="btn btn-primary">Ingresar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

