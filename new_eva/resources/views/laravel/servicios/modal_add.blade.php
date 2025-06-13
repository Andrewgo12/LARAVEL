<div id="modal_add_servicio" class="modal fade" role="dialog">
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
								<h3 class="box-title">Servicio
								</h3>
							</div>
							<div class="box-body form-horizontal">
								<form action="" name="form_add_servicio" class="form_add_servicio" enctype="multipart/form-data" method="post" onsubmit="(new serviceObj).HandleSubmitInsert(event)">
      @csrf
									<div class="form-group">
										<label for="name">Nombre del servicio</label>
										<input type="text" class="form-control" id="name" name="name" placeholder="Ingrese servicio" required="">
									</div>
									<div class="form-group">
										<label for="servicio_id">Zona</label>
										<select style="width: 100%;" class="form-control zona_id" id="zona_id" name="zona_id" required="">
										</select>
									</div>
									<div class="form-group">
										<label for="servicio_id">Piso</label>
										<select style="width: 100%;" class="form-control piso_id" id="piso_id" name="piso_id" required="">
										</select>
									</div>
									<div class="form-group">
										<label for="servicio_id">Centro de costo</label>
										<select style="width: 100%;" class="form-control centro_id" id="centro_id" name="centro_id" required="">
										</select>
									</div>
									<div class="form-group">
										<label for="servicio_id">Sede</label>
										<select style="width: 100%;" class="form-control sede_id" id="sede_id" name="sede_id" required="">
										</select>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary btn_add_area">Insertar</button>
									</div>
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