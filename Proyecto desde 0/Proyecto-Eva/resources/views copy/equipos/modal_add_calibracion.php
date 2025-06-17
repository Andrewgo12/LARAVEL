<div id="modal_add_calibracion" class="modal fade" role="dialog">
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
								<h3 class="box-title">Calibración
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="<?php echo base_url();?>equipo/Cequipos/addCalibracion" id="form_calibracion" name="form_calibracion" enctype="multipart/form-data" method="post">
									<br>
									<input type="hidden" name="equipo_id" id="equipo_id">
									<div class="row">
										<div class="col-sm-2">
											<label for="description">Codigo calibracion</label>
										</div>
										<div class="col-sm-6">
											<input type="text" name="description" id="description" class="form-control" placeholder="Codigo" required="">
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-2">
											<label for="fecha_calibracion">Fecha ejecución</label>
										</div>
										<?php 
										 $fecha_superior=date("Y-m-d",strtotime(date("Y-m-d")."+ 1 day"));
										 ?>
										<div class="col-sm-4">
											<input type="date" name="fecha_calibracion" id="fecha_calibracion" required="" min="2015-01-01" max="<?php echo $fecha_superior;?>" onblur="set_fecha_programada_add_calibracion()" onchange="set_fecha_programada_add_calibracion()">
										</div>
										<div class="col-sm-2">
											<label for="fecha_programada">Fecha programada</label>
										</div>
										<div class="col-sm-4">
											<input type="date" name="fecha_programada" id="fecha_programada" required="">
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
										<button class="btn btn-primary" id="btn_add_calibracion">Ingresar</button>
									</div>
									<div class="errores"></div>
									<div class="mensaje"></div>
									
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