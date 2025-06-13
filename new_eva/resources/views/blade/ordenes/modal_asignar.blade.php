<div id="modal_asignar_orden" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Actualizar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">orden
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ asset('') }}orden/Cordenes/update" id="form_asignacion" name="form_asignacion" enctype="multipart/form-data" method="post">
      @csrf
									<!-- id orden -->
									<input type="hidden" id="id"  name="id">

									<br>
									<div class="form-group">
										<label for="empresa_id" class="col-sm-2 control-label">Asignar</label>
										<div class="col-sm-10">
											<select name="empresa_id" id="empresa_id" class="form-control empresa_id" style="width:60%" required="">
												<option value="">--Seleccione Empresas--</option>
											</select>
										</div>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_asignar_orden">Asignar</button>
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