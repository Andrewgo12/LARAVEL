<div id="modal_add_permiso" class="modal fade" role="dialog">
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
								<h3 class="box-title">permiso
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<span class="errores"></span>
								<div class="form-group">
									<label for="nombre" class="col-sm-2 control-label">Nombre</label>

									<div class="col-sm-10">
										<input type="text" class="form-control" required  name="nombre" id="add_nombre_permiso" placeholder="Nombre">
									</div>
								</div>
								<div class="form-group">
									<label for="apellido" class="col-sm-2 control-label">Apellidos</label>

									<div class="col-sm-10">
										<input type="text" class="form-control"  name="apellido" placeholder="Apellido" id="add_apellido_permiso">
									</div>
								</div>
								<div class="form-group">
									<label for="telefono" class="col-sm-2 control-label">Telefono</label>

									<div class="col-sm-10">
										<input type="number" class="form-control"  name="telefono" placeholder="Telefono" id="add_telefono_permiso">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">email</label>

									<div class="col-sm-10">
										<input type="email" class="form-control"  name="email" placeholder="email" id="add_email_permiso">
									</div>
								</div>
								<div class="form-group">
									<label for="username" class="col-sm-2 control-label">username</label>

									<div class="col-sm-10">
										<input type="text" class="form-control"  name="username" placeholder="username" id="add_username_permiso">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">password</label>

									<div class="col-sm-10">
										<input type="password" class="form-control"  name="password" placeholder="password" id="add_password_permiso">
									</div>
								</div>

								<div class="form-group">
									<label for="rol" class="col-sm-2 control-label">rol</label>

									<div class="col-sm-10">
										<select name="rol_id" id="add_rol_id_permiso" style="width: 60%"></select>
									</div>
								</div>


								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							<div class="box-footer">
								<button class="btn btn-primary" id="btn_add_permiso">Ingresar</button>
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