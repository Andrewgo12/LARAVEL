<div id="modal_add_categoria" class="modal fade" role="dialog">
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
								<h3 class="box-title">Categoria
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<span class="errores"></span>

								<div class="form-group">
									<label for="nombre" class="col-sm-2 control-label">Nombre</label>
									<div class="col-sm-10">
										<input type="text" class="form-control"  name="nombre" id="add_nombre_categoria" placeholder="Nombre">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">Descripción</label>

									<div class="col-sm-10">
										<input type="text" class="form-control"  name="descripcion" placeholder="Descripción" id="add_descripcion_categoria">
									</div>
								</div>


								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							<div class="box-footer">
								<button class="btn btn-primary" id="btn_add_categoria">Ingresar</button>
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