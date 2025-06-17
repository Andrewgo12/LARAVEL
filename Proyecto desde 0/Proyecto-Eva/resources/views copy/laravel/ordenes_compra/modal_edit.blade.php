<div id="modal_update_orden_compra" class="modal fade" role="dialog">
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
								<h3 class="box-title">Soporte de compra
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" name="form_update_orden_compra" class="form_update_orden_compra" enctype="multipart/form-data" method="post">
      @csrf

									<br>
									<div class="row">
										<input type="hidden" id="id" name="id">
										<div class="col-sm-4">
											<label for="orden">Codigo</label>
											<input type="text" name="orden" id="orden" class="form-control" required="" placeholder="Ingrese el numero de orden de compra">
										</div>
										<div class="col-sm-4">
											<label for="fecha">Fecha</label>
											<input class="form-control" type="date" id="fecha" name="fecha">
										</div>
										<div class="col-sm-4">
											<label for="titulo">Proveedor</label>
											<select class="form-control" name="proveedor_id" id="proveedor_id">
												<option value="">-------</option>
											</select>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-6">
											<label for="tipo_compra_id">Tipo de compra</label>
											<select required="" class="form-control select_tipos_compra" name="tipo_compra_id" id="tipo_compra_id">
											</select>
										</div>
										<div class="col-sm-6">
											<label for="url_secop">URL SECOP1</label>
											<input type="url" name="url_secop" id="url_secop" class="form-control" placeholder="Ingrese URL">
										</div>
									</div><br>
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Archivo asociado</label>
												<input style="height: 30%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											</div>
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