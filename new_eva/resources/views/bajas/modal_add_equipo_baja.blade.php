<div id="modal_add_equipo_baja" class="modal fade" role="dialog">
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
								<h3 class="box-title">Baja
								</h3>
							</div>

							<form action="{{ url('/') }}equipo/Cbajas/addEquipoBaja" class="form_equipo_baja" enctype="multipart/form-data" method="post">
								<div class="box-body form-horizontal">

									<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
									

									<div class="form-group">
										<input type="hidden" name="equipo_id" id="equipo_id" class="equipo_id">

										<label for="baja_id" class="col-sm-2 control-label">Archivo de baja</label>
										<div class="row">
											
										<div class="col-sm-10">
											<select style="width: 100%;" required="" class="select_especial baja_id" id="baja_id" name="baja_id">
												
											</select>
										</div>
										</div>
									</div>


									<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
								</div>
								<div class="box-footer">
									<button class="btn btn-primary" id="btn_add_equipo_baja">Ingresar</button>
								</div>
							</form>	
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