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
								<h3 class="box-title">usuario</h3>
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
										<label for="telefono" class="col-sm-2 control-label">Teléfono</label>
										<div class="col-sm-10">
											<input type="number" class="form-control" name="telefono" placeholder="Teléfono" id="telefono">
										</div>
									</div>

									<div class="form-group">
										<label for="email" class="col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
											<input type="email" class="form-control" name="email" placeholder="Email" id="email">
										</div>
									</div>

									<div class="form-group">
										<label for="username" class="col-sm-2 control-label">Username</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="username" placeholder="Username" id="username">
										</div>
									</div>

									<div class="form-group">
										<label for="password" class="col-sm-2 control-label">Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" name="password" placeholder="Password (Si está vacía conserva la anterior)" id="password">
										</div>
									</div>

									<div class="form-group">
										<label for="rol" class="col-sm-2 control-label">Rol</label>
										<div class="col-sm-10">
											<select required name="rol_id" id="rol_id" style="width: 90%;"></select>
										</div>
									</div>

									<div class="form-group">
										<label for="centro_id" class="col-sm-2 control-label">Centro de costo</label>
										<div class="col-sm-10">
											<select required name="centro_id" id="centro_id" style="width: 90%;"></select>
										</div>
									</div>

									<div class="form-group">
										<label for="id_empresa" class="col-sm-2 control-label">Asignar empresa</label>
										<div class="col-sm-10">
											<select class="empresa_id" name="id_empresa" id="id_empresa" style="width: 90%;">
												<option value="">--Seleccione Empresa--</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-primary" id="btn_update_usuario">Actualizar</button>
										</div>
									</div>
								</form>
							</div>

							<div class="box-footer"></div>
							<br>
						</div>
					</div>
				</div>

				<!-- Tabla de permisos -->
				<div class="row">
					<div class="col-sm-12">
						<table style="font: small-caps 150%/300% serif;" border="1" class="tbl_acciones table table-bordered table-striped">
							<thead>
								<tr>
									<th>Módulo</th>
									<th>Leer</th>
									<th>Insertar</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<!-- Aquí se insertan dinámicamente los permisos -->
							</tbody>
						</table>
					</div>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>

		</div>
	</div>
</div>
