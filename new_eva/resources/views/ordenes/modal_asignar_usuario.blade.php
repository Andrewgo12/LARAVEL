<div id="modal_asignar_orden_usuario" class="modal fade" role="dialog">
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

								<form action="{{ url('/') }}orden/Cordenes/update" id="form_asignacion_usuario" name="form_asignacion_usuario" enctype="multipart/form-data" method="post">
									<!-- id orden -->
									<input type="hidden" id="id"  name="id">

									<br>
									<div class="form-group">
										<label for="asignado_id" class="col-sm-2 control-label">Asignar Usuario</label>
										<div class="col-sm-10">
											<select name="asignado_id" id="asignado_id" class="form-control" style="width:60%" required="">
												<option value="">--Seleccione Usuario--</option>
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



                <label class="">
                  <div class="icheckbox_flat-green checked" aria-checked="false" aria-disabled="false" style="position: relative;">
                  	<input type="checkbox" class="flat-red" checked="" style="position: absolute; opacity: 0;">
                  	  <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                  	  </ins>
                  </div>
                </label>
