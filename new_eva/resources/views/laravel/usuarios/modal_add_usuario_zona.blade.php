<div id="modal_add_usuario_zona" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 75%;">
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
								<h3 class="box-title">Usuario zona
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" id="form_usuario_zona" name="form_usuario_zona" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<ul class="list-inline">
										<li class="list-inline-item">
											<label for="zona_id">Zona</label>
											<select name="zona_id" id="zona_id" class="zona_id">
												<option value="">----Seleccione----</option>
											</select>
											
										</li>
										<li class="list-inline-item">
											<label for="usuario_id">Usuario</label>
											<select style="width: 100%;" name="usuario_id" id="usuario_id" class="usuario_id">
												<option value="">----Seleccione----</option>
											</select>
											
										</li>
									</ul>

									<div class="box-footer">
										<button class="btn btn-primary btn-add-usuario-zona" id="">Ingresar</button>
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
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div> 