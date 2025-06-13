<div id="modal_update_correctivo_general" class="modal fade" role="dialog">
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
								<h3 class="box-title">Correctivo
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="<?php echo base_url();?>equipos_ind/Cequipos_ind/updateCorrectivoGeneral" id="form_update_correctivo_general" name="form_update_correctivo_general" enctype="multipart/form-data" method="post">
									<br>
									<input type="hidden" name="id" id="id">
									<input type="hidden" name="equipo_id" id="equipo_id">

									<div class="row">
										<div class="col-sm-2">
											<label for="code">Codigo</label>
										</div>
										<div class="col-sm-6">
											<input type="text" name="code" id="code" class="form-control" placeholder="Codigo" required="">
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-2">
											<label for="description">Descripcion</label>
										</div>
										<div class="col-sm-10">
										<textarea class="form-control" name="description" id="description" rows="10" placeholder="Ingrese la informacion del reporte, asi como informacion descriptiva de la gesiton realizada"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-2">
											<label for="fecha_calibracion">Fecha ejecución</label>
										</div>
										<div class="col-sm-4">
											<input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" required="">
										</div>
									</div>
 									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Archivo asociado</label>
												<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											</div>
										</div>
									</div>	 
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_update_preventivo">Ingresar</button>
									</div>
									<div class="errores"></div>
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