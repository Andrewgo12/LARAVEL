<div id="modal_edit_orden" class="modal fade" role="dialog">
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
								<input type="hidden" id="diagnostico_db"  name="diagnostico_db"><!--Diagnostico en caso que se haya realizado-->

								<form action="{{ asset('') }}orden/Cordenes/update" id="form_orden" name="form_orden" enctype="multipart/form-data" method="post">
      @csrf
									<input type="hidden" id="id"  name="id"><!--id de la orden para actualizar-->
									<input type="hidden" name="tecnico_cierre" id="tecnico_cierre" value="<?= session('id');?>">
									<input type="hidden" name="tecnico_diagnostico" id="tecnico_diagnostico" value="<?= session('id');?>">

									<div class="subproceso_0">

										<br>
										<div class="row">
											<!--
											<div class="col-sm-7">
												<label for="">Ubicación actual del equipo</label><br>
												<select name="" id="" class="form-control servicio_id" style="width:100%" required="">
													<option value="">--Seleccione--</option>
												</select>
											</div>
										-->
											<div class="col-sm-5">
												<label for="prioridad">Prioridad</label><br>
												<select class="form-control" name="prioridad" id="prioridad">
													<option value="baja">Baja</option>
													<option value="media">Media</option>
													<option value="alta">Alta</option>
												</select>
											</div>
										</div><br>
										<div class="row">
											<div class="col-sm-12">
												<label for="asunto">Asunto</label><br>
												<table class="table table-bordered">
													<tr><td><input class="form-control" type="text" name="asunto" id="asunto"></td></tr>
												</table>
												
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<label for="descripcion" class="control-label">Descripción del problema</label><br>
												<textarea name="descripcion" id="descripcion" class="form-control"></textarea>
											</div>
										</div>
									</div>	<br>							


									<div class="subproceso_1"><!--subproceso_1 equipos biomedicos-->
										<?php if (session('rol_id')<=2): ?><!--super admin o admin-->

											<table class="table table-bordered">
												<tr>
													<th>Id Equipo</th>
													<th>Nombre equipo</th>
													<th>Serie equipo</th>
												</tr>
												<tr>
													<td><input class="form-control" type="number" id="equipo_id" name="equipo_id" placeholder=""></td>
													<td style="width: 50%;"><input type="text" class="form-control" name="nombre_equipo" id="nombre_equipo" placeholder="Nombre"></td>
													<td><input type="text" class="form-control" name="serie_equipo" id="serie_equipo" placeholder="serie del equipo"></td>
												</tr>
												<tr>
													<th>Modelo equipo</th>
													<th>Marca equipo</th>
													<th>Numero de inventario</th>
												</tr>
												<tr>
													<td><input type="text" class="form-control" name="modelo_equipo" id="modelo_equipo" placeholder="Modelo del equipo"></td>
													<td><input type="text" class="form-control" name="marca_equipo" id="marca_equipo" placeholder="Marca del equipo"></td>
													<td><input type="text" class="form-control" name="codigo_equipo" id="codigo_equipo" placeholder="Numero de inventario"></td>
												</tr>
											</table>
										<?php endif ?>
										<!-- <div id="contenedor_respuesta"></div> Para complementar con javascript -->

									</div><!--fin del div subproceso_1-->


									
									<div class="subproceso_2"><!--subproceso_2 subproceso de prueba-->
										<?php if (session('rol_id')<=2): ?><!--super admin o admin-->

											<table class="table table-bordered">
												<tr>
													<th>Id Equipo</th>
													<th>Nombre equipo</th>
													<th>Serie equipo</th>
												</tr>
												<tr>
													<td><input class="form-control" type="number" id="equipo_id_2" name="equipo_id_2" placeholder=""></td>
													<td style="width: 50%;"><input type="text" class="form-control" name="nombre_equipo_2" id="nombre_equip_2" placeholder="Nombre"></td>
													<td><input type="text" class="form-control" name="serie_equipo_2" id="serie_equipo_2" placeholder="serie del equipo"></td>
												</tr>
												<tr>
													<th>Modelo equipo</th>
													<th>Marca equipo</th>
													<th>Numero de inventario</th>
												</tr>
												<tr>
													<td><input type="text" class="form-control" name="modelo_equipo_2" id="modelo_equipo_2" placeholder="Modelo del equipo"></td>
													<td><input type="text" class="form-control" name="marca_equipo_2" id="marca_equipo_2" placeholder="Marca del equipo"></td>
													<td><input type="text" class="form-control" name="codigo_equipo_2" id="codigo_equipo_2" placeholder="Numero de inventario"></td>
												</tr>
											</table>
										<?php endif ?>
									</div><!--fin subproceso_2-->



<!-------            -------->		<div class="contenedor_input_diagnostico" style="display: none;"><!-- información del diagnostico -->
										<?php if (session('rol_id')<=2): ?><!--Puede ingresar fecha de -->
											
										<div class="row">
											<div class="col-sm-12">
												<label for="diagnostico">Fecha del diagnostico </label>
												<input required="" min="2015-01-01" type="date" name="fecha_diagnostico" id="fecha_diagnostico"  class="form-control"><input type="time" name="hora_diagnostico" id="hora_diagnostico" class="form-control">
												
											</div>
										</div><br>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<label for="tecnico_diagnostico_text">Relacione el nombre del tecnico que realiza el diagnostico</label>
												<input class="form-control" type="text" name="tecnico_diagnostico_text" id="tecnico_diagnostico_text">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<label for="retro_diagnostico">Retro Diagnostico</label>
												<input type="text" name="retro_diagnostico" id="retro_diagnostico"><br>
											</div>
										</div><br>										
										<?php endif ?>
										<div class="row">
											<div class="col-sm-12">
												<label for="diagnostico">Diagnostico</label>
												<input disabled="" type="file" name="file_diagnostico" id="file_diagnostico"><br>
												<textarea class="form-control" disabled="" name="diagnostico" id="diagnostico" ></textarea>
											</div>
										</div><br>
										
										<div class="row">
											<div class="col-sm-12">
												<label for="">Codigo de diagnostico</label><br>
												<select required="" class="form-control" class="diagnostico_id" name="diagnostico_id" id="diagnostico_id"></select>
											</div>
										</div><br>
										<div class="row control_repuestos">
											<div class="col-sm-3">
												<label for="">Solicitar repuesto(s)</label><br>
											</div>	
											<div class="col-sm-1"><span class="glyphicon glyphicon-plus solicitar_repuestos"></span>&nbsp;<span class="glyphicon glyphicon-erase eliminar_repuestos"></div>	
											<div class="col-sm-8">
												<label for="">Fecha de solicitud &nbsp;
												</label>
												<input required="" class="form-control" type="date" id="fecha_solicitud_repuesto" name="fecha_solicitud_repuesto">	
											</div>									
										</div><br>
										<div class="row control_repuestos">
											<div class="col-sm-12">

												<div class="contenedor_repuestos">
													
													<table class="table table-bordered table-condensed table-hover table-sm">
														<thead>	
															<tr>
																<th>Repuesto</th>
															</tr>
														</thead>
														<tbody>

														</tbody>
													</table>													

												</div>
											</div>
										</div>											
									</div>
<!-------            --------><div class="contenedor_input_cierre" style="display: none;"><!-- información de cierre -->

										<?php if (session('rol_id')<=2): ?><!--Puede ingresar fecha de -->
											
											
										<div class="row">
											<div class="col-sm-12">
												<label for="diagnostico">Fecha cierre </label>
												<input required="" min="2015-01-01" type="date" name="fecha_asignacion_cierre" id="fecha_asignacion_cierre"  class="form-control"><input type="time" name="hora_fin" id="hora_fin" class="form-control">
												
											</div>
										</div><br>
									
										<br>
										<div class="row">
											<div class="col-sm-12">
												<label for="tecnico_diagnostico_text">Relacione el nombre del tecnico que cierra la orden</label>
												<input class="form-control" type="text" name="tecnico_cierre_text" id="tecnico_cierre_text">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<label for="retro_cierre">Retro Cierre</label>
												<input type="text" name="retro_cierre" id="retro_cierre"><br>
											</div>
										</div><br>										

										<?php endif ?>	
										<div class="row">
											<div class="col-sm-12">
												<label for="reparacion">Información de cierre</label>
												<input disabled="" type="file" name="file_cierre" id="file_cierre"><br>
												<textarea class="form-control" disabled="" name="reparacion" id="reparacion" ></textarea>
											</div>
										</div><br>
										<div class="row">
											<div class="col-sm-12">
												<label for="">Codigo de cierre</label><br>
												<select required="" class="form-control" name="cierre_id" id="cierre_id" class="cierre_id"></select>
											</div>
										</div><br>

										<div class="row">
											<div class="col-sm-12">
												<label for="">Repuestos:</label><br>
												<div class="repuestos_usados"></div>
											</div>
										</div><br>
									</div>
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_update">Actualizar</button>
										<h1><div id="mensaje"></div></h1>
									</div>

								</form>
								<div id="errores"></div>

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