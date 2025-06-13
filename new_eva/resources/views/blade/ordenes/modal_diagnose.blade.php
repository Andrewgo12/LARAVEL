<div id="modal_diagnose_orden" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 60%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Diagnostico</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ asset('') }}orden/Cordenes/update_diangosticar_orden" id="form_diagnosticar_orden" name="form_diagnosticar_orden" class="form_diagnosticar_orden" enctype="multipart/form-data" method="post">
      @csrf
									<input type="hidden" name="id" id="id" class="id">

									<ul class="list-inline">
										<li class="list-inline-item">
											<h3>Asunto</h3>
											<h4>
												<span class="asunto"></span>
											</h4>
										</li>
										<li class="list-inline-item">
											<h3>Descripción</h3>
											<h4>
												<span class="descripcion"></span>
											</h4>										
										</li>
										<li class="list-inline-item">
											<h3>Prioridad</h3>
											<h4>
												<span style="text-transform: uppercase;" class="prioridad"></span>
											</h4>										
										</li>
										
										<span class="contenido_ubicacion"></span>
									</ul>
									<span class="contenido_equipo"></span>

									<ul class="list-inline">
										<li class="list-inline-item">
											<h4>Retro diagnostico</h4>
											<h5>
												<input required="" type="text" class="form-control" id="retro_diagnostico" name="retro_diagnostico" placeholder="Ingrese retro diagnostico">
											</h5>
										</li>
										<li class="list-inline-item">
											<h4>Diagnostico</h4>
											<h5>
												<textarea required="" name="diagnostico" id="diagnostico" cols="50" rows="5" placeholder="Ingrese el respectivo diagnostico"></textarea>
											</h5>
										</li>
										<li class="list-inline-item">
											<h4>Codificación de diagnostico</h4>
											<h5>
												<select required="" class="form-control diagnostico_id"  name="diagnostico_id" id="diagnostico_id"></select>
											</h5>
										</li>
										<li class="list-inline-item">

											<div class="contenendor_file" style="display: none;">
												<h4>Archivo de diagnostico</h4>
												<input disabled="" class="file" data-browse-on-zone-click="true" type="file" name="file_diagnostico" id="file_diagnostico">
											</div>
										</li>
									</ul>

										<span class="contenido_administrador"></span>
									<div class="row control_repuestos">
										<div class="col-sm-3">
											<label for="">Repuestos necesarios</label><br>
										</div>	
										<div class="col-md-5"><span title="Agregar nuevo repuesto" class="glyphicon glyphicon-plus  solicitar_repuestos"></span>&nbsp;<span class="glyphicon glyphicon-erase eliminar_repuestos"></div>	
										</div><br>
										<div class="row control_repuestos">
											<div class="col-sm-12">

												<div class="contenedor_repuestos">
													
													<table class="table table-bordered table-condensed table-hover table-sm">
														<thead>	
															<tr>
																<th>Repuestos</th>
															</tr>
														</thead>
														<tbody>

														</tbody>
													</table>													

												</div>
											</div>
										</div>								
										<div class="box-footer">
											<button class="btn btn-primary" id="btn_update">Actualizar</button>
											<h1><div id="mensaje"></div></h1>
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