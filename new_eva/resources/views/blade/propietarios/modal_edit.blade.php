<div id="modal_update_propietario" class="modal fade" role="dialog">
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
								<h3 class="box-title">Propietario
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" name="form_update_propietario" class="form_update_propietario" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<input type="hidden" name="id" id="id">
									<div class="row">
										<div class="col-sm-12">
											<label for="nombre">Nombre del propietario</label>
											<input type="text" name="nombre" id="nombre" class="form-control" required="" placeholder="Ingrese el Nombre del propietario">
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-12">
											<label for="" class="badge">Logo</label>
											<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="logo" name="logo">											
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