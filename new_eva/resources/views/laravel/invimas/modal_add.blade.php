<div id="modal_add_invima" class="modal fade" role="dialog">
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
								<h3 class="box-title">Registro sanitario
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" name="form_add_invima" class="form_add_invima" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<input type="hidden" name="id" id="id">
									<div class="row">
										<div class="col-sm-5">
											<label for="invima">Registro sanitario</label>
											<input type="text" name="invima" id="invima" class="form-control" required="" placeholder="Ingrese el Registro sanitario">
										</div>
										<div class="col-sm-7">
											<label for="description">Descripción detallada del Registro sanitario</label>
											<textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-6">
											<label for="titulo">Titulo</label>
											<textarea class="form-control" name="titulo" id="titulo" cols="30" rows="5" placeholder="Ingrese titulo, en el registro sanitario aparece como nombre del producto"></textarea>
										</div>
										<div class="col-sm-6">
											<label for="marcas">Marcas</label>
											<textarea class="form-control" name="marcas" id="marcas" cols="30" rows="5" placeholder="Ingrese marcas. En el registro sanitario aparece como marcas"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Archivo asociado</label>
												<input  style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											</div>
										</div>
									</div>	
									<div class="box-footer">
										<button class="btn btn-primary">Insertar</button>
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