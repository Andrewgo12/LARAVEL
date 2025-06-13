<div id="modal_add_baja" class="modal fade" role="dialog">
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

							<form action="<?php echo base_url();?>equipo/Cbajas/add" class="form_baja" enctype="multipart/form-data" method="post">
								<div class="box-body form-horizontal">

									<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
									

									<div class="form-group">

										<label for="fecha_baja" class="col-sm-2 control-label">Fecha de la baja</label>
										<div class="col-sm-10">
											<input required="" type="date" class="form-control"  name="fecha_baja" id="fecha_baja">
										</div>
									</div>
									<div class="form-group">

										<label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
										<div class="col-sm-10">
											<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripcion del documento"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="archivo" class="col-sm-2 control-label">Archivo</label>

										<div class="col-sm-10">
											<input required="" type="file" class="file"  id="archivo" name="archivo"  data-browse-on-zone-click="true">
										</div>
									</div>


									<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
								</div>
								<div class="box-footer">
									<button class="btn btn-primary" id="btn_add_categoria">Ingresar</button>
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