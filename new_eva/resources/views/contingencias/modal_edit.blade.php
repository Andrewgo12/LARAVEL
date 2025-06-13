<div id="modal_update_contingencia" class="modal fade" role="dialog">
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
								<h3 class="box-title">Contingencia
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" name="" class="" enctype="multipart/form-data" method="post">
									<br>
									<input type="hidden" name="id" id="id" class="id">
									<div class="row">
										<div class="col-sm-4">
											<label for="fecha">
												
											</label>
											<input type="date" name="fecha" id="fecha" class="fecha form-control">
										</div>
										<div class="col-sm-4">
											<label for="fecha_cierre">
												
											</label>
											<input type="date" name="fecha_cierre" id="fecha_cierre" class="fecha_cierre form-control">
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-12">
											<label for="observacion">
												
											</label>
											<textarea name="observacion" class="observacion form-control" style="width: 100%;" id="observacion"  rows="5"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-12">
											<select style="width: 100%;" class="equipo_id" name="equipo_id" id="equipo_id"></select>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-12">
											<input type="file" class="file" name="file" id="file" data-browse-on-zone-click="true">
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