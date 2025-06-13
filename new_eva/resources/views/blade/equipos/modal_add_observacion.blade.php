<div id="modal_add_observacion" class="modal fade" role="dialog">
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
								<h3 class="box-title">Observacion
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ asset('') }}equipo/Cequipos/addObservacion" id="form_observacion" name="form_observacion" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<input type="hidden" name="equipo_id" id="equipo_id">
									<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo {{ session('id') }};?>">

									<div class="row">
										<div class="col-sm-2">
											<label for="description">Descripcion</label>
										</div>
										<div class="col-sm-10">
											<textarea class="form-control" name="description" id="description" rows="10" placeholder="Ingrese la observacion que desea consignar"></textarea>
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-12">
											<label for="fecha_inicio">Fecha de la observación</label>
										</div>
										<div class="col-sm-12">
											<span style="color: #3f8cb9;" class="text-muted">Si no se ingresa, se guardara la observación con la fecha actual</span>
										</div>
										<div class="col-sm-7">
											<input min="2015-01-01" type="date" name="created_at" id="created_at"  class="form-control">
										</div>
										<div class="col-sm-5">
											<input type="time" name="hora_observacion" id="hora_observacion" class="form-control">
										</div>
									</div>									

									<div class="row">
										<div class="col col-sm-12">
											<label for="" class="badge">Archivo asociado</label>
											<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
										</div>
									</div>

									<div class="row">
										<div class="col col-md-3"><label for="repuesto_id">Repuesto pendiente</label></div>		
										<div class="col col-md-9"><input placeholder="Relacionar si hay, repuesto pendiente(s)" type="text" class="form-control" id="repuesto_id" name="repuesto_id" class="repuesto_id"></div>		
										
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_observacion">Ingresar</button>
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