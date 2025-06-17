<div id="modal_add_repuesto_correctivo_general" class="modal fade" role="dialog">
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
								<h3 class="box-title">Repuesto
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
								<div class="contenedor_formulario_repuesto row" style="display: none;">
									<div class="col-sm-2"></div>
									<div class="col-sm-10">
										<form class="form-inline formulario_repuesto" id="formulario_repuesto" action="" method="post">
      @csrf
											<div class="form-group">
												<label for="name">Nombre:</label>
												<input required="" type="text" class="form-control" name="name" id="name" placeholder="Nombre del nuevo repuesto"><br><br>
											</div>
											<div class="form-group">

												<label for="code">Codigo:</label>
												<input required="" type="text" class="form-control" name="code" id="code" placeholder="Ingrese el Codigo del nuevo repuesto"><br><br>
											</div>
											<div class="form-group">

												<label for="precio">Precio con iva:</label>
												<input type="number" class="form-control" name="precio" id="precio" placeholder="Ingrese el valor del nuevo repuesto"><br><br>
											</div><br>
											<div class="form-group">

												<label for="precio">Grupo:</label>
												<select style="width: 100%;" class="form-control" name="grupo" id="grupo">
													<option value="">------------------</option>
													<option value="MT1">MT1</option>
													<option value="DM1">DM1</option>
													<option value="M30">M30</option>
													<option value="ET1">ET1</option>
												</select>
											</div><br><br>
											<div class="form-group">
												<button type="submit" class="btn btn-success">Ingresar</button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<form action="{{ asset('') }}equipo/Cequipos/addEquipoRepuesto" id="form_repuesto_correctivo_general" name="form_repuesto_correctivo_general" enctype="multipart/form-data" method="post">
      @csrf
								<br>
								<input type="hidden" name="equipo_id" id="equipo_id">
								<input type="hidden" name="correctivo_general_id" id="correctivo_general_id">

								<div class="row">
									<div class="col-sm-2">
										<label for="observacion">Observación</label>
									</div>
									<div class="col-sm-6">
										<textarea name="observacion" id="observacion" class="form-control" placeholder="Observacion relacionada" required=""></textarea>
									</div>
								</div><br>

								<div class="row">
									<div class="col-sm-2">
										<label for="description">Cantidad</label>
									</div>
									<div class="col-sm-6">
										<input type="number" name="cantidad_entregada" value="1" id="cantidad_entregada" class="form-control" placeholder="Cantidad entregada" required="">
									</div>
								</div><br>
								<div class="row">
									<div class="col-sm-2">
										<label for="description">Repuesto</label>
									</div>
									<div class="col-sm-8">
										<select class="form-control repuesto_id select_especial" id="repuesto_id" name="repuesto_id" required="" style="width: 100%;"></select>

									</div>
									<div class="col-sm-2">
										<span class="glyphicon glyphicon-info-sign mostrar_formulario_repuesto" title="Ingresar nuevo repuesto"></span>
									</div><br><br>
								</div><br>
								<div class="row">
									<div class="col-sm-2">
										<label for="fecha">Fecha de instalacion</label>
									</div>
									@php
										$fecha_superior = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 day"));
									@endphp
									<div class="col-sm-4">
										<input type="date" name="fecha" id="fecha" required="" min="2015-01-01" max="{{ $fecha_superior }}">
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
									<button class="btn btn-primary" id="btn_add_repuesto_correctivo_general">Ingresar</button>
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
			</div>

		</div>
	</div>
</div>
</div>
