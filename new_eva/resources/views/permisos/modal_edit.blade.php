<div id="modal_update_usuario" class="modal fade" role="dialog">
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
								<h3 class="box-title">usuario
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<span class="errores"></span>
								<input type="hidden" id="update_id_usuario">
								<div class="form-group">
									<label for="nombre" class="col-sm-2 control-label">Nombre</label>

									<div class="col-sm-10">
										<input type="text" class="form-control" required  name="nombre" id="update_nombre_usuario" placeholder="Nombre">
									</div>
								</div>
								<div class="form-group">
									<label for="apellido" class="col-sm-2 control-label">Apellidos</label>

									<div class="col-sm-10">
										<input type="text" class="form-control"  name="apellido" placeholder="Apellido" id="update_apellido_usuario">
									</div>
								</div>
								<div class="form-group">
									<label for="telefono" class="col-sm-2 control-label">Telefono</label>

									<div class="col-sm-10">
										<input type="number" class="form-control"  name="telefono" placeholder="Telefono" id="update_telefono_usuario">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">email</label>

									<div class="col-sm-10">
										<input type="email" class="form-control"  name="email" placeholder="email" id="update_email_usuario">
									</div>
								</div>
								<div class="form-group">
									<label for="username" class="col-sm-2 control-label">username</label>

									<div class="col-sm-10">
										<input type="text" class="form-control"  name="username" placeholder="username" id="update_username_usuario">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">password</label>

									<div class="col-sm-10">
										<input type="password" class="form-control"  name="password" placeholder="password(Si esta vacia conserva la enterior)" id="update_password_usuario">
									</div>
								</div>

								<div class="form-group">
									<label for="rol" class="col-sm-2 control-label">rol</label>

									<div class="col-sm-10">
										<select name="rol_id" id="update_rol_id_usuario" style="width: 60%"></select>
									</div>
								</div>


								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							<div class="box-footer">
								<button class="btn btn-primary" id="btn_update_usuario">Ingresar</button>
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