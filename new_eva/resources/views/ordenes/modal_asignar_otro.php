<div id="modal_asignar_orden_otro" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Actualizar....</h4>
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

								<form action="<?php echo base_url();?>orden/Cordenes/update" id="form_asignacion_otro" name="form_asignacion_otro" enctype="multipart/form-data" method="post">
									<!-- id orden -->
									<input type="hidden" id="id"  name="id">
									<br><p></p>
									<div class="row">
										<div class="col-sm-6">
												<label for="trabajo_id" class="">Asignar tipo de arreglo</label>
												<br>
												<div class="">
													<select onchange="seleccionar_tecnicos()" style="width: 80%;" name="trabajo_id" id="trabajo_id" class="form-control trabajo_id" style="width:60%" required="">
													</select>
												</div>
										</div>
										<div class="col-sm-6">
												<label for="tecnico_id" class="">Asignar responsable</label><br>
												<div class="contenedor_hijo_asignacion">
													<select style="width: 80%;" name="tecnico_id" id="tecnico_id" class="form-control tecnico_id" style="width:60%" required="">
													</select>
												</div>
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