<div id="modal_filter_equipo" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Filtrar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">equipos
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
								<form action="{{ url('/') }}equipo/Cequipos/exportarExcel" method="post" target="_blank">
									<div class="row">
										<div class="col-md-4 text-left">
											<a href="#" style="padding: 15px;" onclick="aplicar_filtro()" class="btn btn-success glyphicon glyphicon-floppy-saved">Filtrar</a>
										</div>
										<div class="col-md-4"></div>
										<div class="col-md-4 text-right">
											<input type="submit" style="padding: 15px;" class="btn btn-success btn-lg fa fa-file-excel-o" value="Exportar">
										</div>
									</div> <br>
									<div class="row">
										<div class="col-md-2">
											<label for="filtro_code">Codigo:</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="filtro_code" name="filtro_code" placeholder="Codigo">
										</div>
										<div class="col-md-2">
											<label for="filtro_serie">Serie:</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="filtro_serial" name="filtro_serial" placeholder="Serie">
										</div>
									</div><br>
									<div class="row">
										<div class="col-md-2">
											<label for="filtro_modelo">Modelo:</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="filtro_modelo" name="filtro_modelo" placeholder="Modelo">
										</div>
										<div class="col-md-2">
											<label for="filtro_marca">Marca:</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="filtro_marca" name="filtro_marca" placeholder="Marca">
										</div>
									</div><br>
									<div class="row">
										<div class="col-md-2">
											<label for="filtro_nombre">Nombre</label>
										</div>
										<div class="col-md-10">
											<input class="form-control input-sm" type="text" id="filtro_name" name="filtro_name" placeholder="Nombre del equipo">
										</div>

									</div><br>
									<div class="row">
										<div class="col-md-1">
											<label for="filtro_zona">Zona</label>
										</div>
										<div class="col-md-3">
											<select class="form-control" name="filtro_zona" id="filtro_zona"></select>
										</div>
										<div class="col-md-2">
											<label for="filtro_estadoequipo_id">Estado Actual</label>
										</div>
										<div class="col-md-6">
											<select class="form-control estadoequipo_id_usado custom-select" name="filtro_estadoequipo_id" id="filtro_estadoequipo_id"></select>
										</div>

									</div><br>
									<div class="row">
										<div class="col-md-2">
											<label for="filtro_estadoequipo_id">Tipo adquisicion</label>
										</div>
										<div class="col-md-10">
											<select class="form-control filtro_tadquisicion_id" name="filtro_tadquisicion_id" id="filtro_tadquisicion_id">
												<option value="">------</option>
												<option value="2">Compra</option>
												<option value="3">Donación</option>
												<option value="4">Comodato</option>
												<option value="5">Alquiler</option>
												<option value="8">Demostración</option>
											</select>
										</div>
									</div>

									<br>
									<div class="row">
										<div class="col-md-2">
											<label for="filtro_estadom">Estado del mantenimiento</label>
										</div>
										<div class="col-md-5">
											<select class="form-control" name="filtro_estadom" id="filtro_estadom" class="filtro_estadom">
												<option value="">---------</option>
												<option value="1">Pendiente</option>
												<option value="2">Realizado</option>
												<option value="3">Atrasado</option>
												<option value="4">No definido</option>
												<option value="5">frecuencia no definida</option>
												<option value="6">Programado</option>
											</select>
										</div>
										<div class="col-md-5">
											<label for="filtro_estadom">Proveedor del mantenimiento</label>
											<input class="form-control input-sm" type="text" id="proveedor_mantenimiento" name="proveedor_mantenimiento" placeholder="Proveedor del mantenimiento">
										</div>
									</div><br>

								</form>
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