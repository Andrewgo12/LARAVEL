<div id="modal_add_nota" class="modal fade" role="dialog">
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
								<h3 class="box-title">Nota
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ url('/') }}equipo/Cpreventivos/add_nota" id="form_preventivo_nota" name="form_preventivo_nota" enctype="multipart/form-data" method="post">
									<br>
									<input type="hidden" name="preventivo_id" id="preventivo_id">
									<div class="row">
										<div class="col-md-2">
											<label for="description">Descripción de la nota</label>
										</div>
										<div class="col-md-6">
											<input type="text" name="description" id="description" class="form-control" placeholder="Nota" required="">
										</div>
									</div><br>
									<div class="row">
										<div class="col-md-2">
											<label for="description">Fecha</label>
										</div>
										<div class="col-md-6">
											<input type="date" value="{{ date("Y-m-d") }}" name="fecha_nota" id="fecha_nota" class="form-control" required="">
										</div>
									</div><br>
					
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_preventivo">Ingresar</button>
									</div>
									<div class="errores"></div>
									<div class="mensaje"></div>
								</form>



								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							<br>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div> 