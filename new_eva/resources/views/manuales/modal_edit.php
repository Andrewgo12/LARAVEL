<div id="modal_update_manual" class="modal fade" role="dialog">
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
								<h3 class="box-title">Manual
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" name="form_update_manual" class="form_update_manual" enctype="multipart/form-data" method="post" onsubmit="new manualObj().HandleSubmitUpdate(event)">
									<br>
									<input type="hidden" name="id" id="id">
									<div class="row">
										<div class="col-sm-12">
											<label for="descripcion" class="badge">Descripción</label>
											<input type="text" name="descripcion" id="descripcion" class="form-control descripcion" required="" placeholder="Ingrese descripcion (a que equipo(s) corresponde)">
										</div>
									</div><br>
									<div class="row">
										<div class="col col-sm-12">
											<label for="url" class="badge">Url</label>
											<input type="url" class="form-control url" id="url" name="url" placeholder="Ingrese url valida">
										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary">Actualizar</button>
									</div>
								</form>

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
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