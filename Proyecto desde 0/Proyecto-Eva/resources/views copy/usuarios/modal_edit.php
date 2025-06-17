<div id="modal_update_usuario" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">
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
								<h3 class="box-title">usuario
								</h3>
							</div>
							<div class="box-body form-horizontal">
								<span class="errores"></span>
								<form action="<?= base_url(); ?>administrador/Cusuarios/update" enctype="multipart/form-data" method="post" id="form_usuario" class="form_usuario" name="form_usuario">
									<input type="hidden" id="id" name="id">
									<div class="form-group">
										<label for="nombre" class="col-sm-2 control-label">Nombre</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" required name="nombre" id="nombre" placeholder="Nombre">
										</div>
									</div>
									<div class="form-group">
										<label for="apellido" class="col-sm-2 control-label">Apellidos</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="apellido" placeholder="Apellido" id="apellido">
										</div>
									</div>
									<div class="form-group">
										<label for="telefono" class="col-sm-2 control-label">Telefono</label>
										<div class="col-sm-10">
											<input type="number" class="form-control" name="telefono" placeholder="Telefono" id="telefono">
										</div>
									</div>
									<div class="form-group">
										<label for="email" class="col-sm-2 control-label">email</label>
										<div class="col-sm-10">
											<input type="email" class="form-control" name="email" placeholder="email" id="email">
										</div>
									</div>
									<div class="form-group">
										<label for="username" class="col-sm-2 control-label">username</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="username" placeholder="username" id="username">
										</div>
									</div>
									<div class="form-group">
										<label for="password" class="col-sm-2 control-label">password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" name="password" placeholder="password(Si esta vacia conserva la enterior)" id="password">
										</div>
									</div>
									<div class="form-group">
										<label for="rol" class="col-sm-2 control-label">rol</label>
										<div class="col-sm-10">
											<select required="" name="rol_id" id="rol_id" style="width: 90%"></select>
										</div>
									</div>
									<div class="form-group">
										<label for="rol" class="col-sm-2 control-label">Centro de costo</label>
										<div class="col-sm-10">
											<select required="" name="centro_id" id="centro_id" style="width: 90%"></select>
										</div>
									</div>
									<div class="form-group">
										<label for="rol" class="col-sm-2 control-label">Asignar empresa</label>
										<div class="col-sm-10">
											<select class="empresa_id" name="id_empresa" id="id_empresa" style="width:90%">
												<option value="">--Seleccione Empresas--</option>
											</select>
										</div>
									</div>
									<button class="btn btn-primary" id="btn_update_usuario">Actualizar</button>
								</form>
							</div>
							<div class="box-footer">
							</div>
							<br>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table style="font: small-caps 150%/300% serif;" border="1" class="tbl_acciones">
							<thead>
								<tr>
									<th>Modulo</th>
									<th>Leer</th>
									<th>Insertar</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>