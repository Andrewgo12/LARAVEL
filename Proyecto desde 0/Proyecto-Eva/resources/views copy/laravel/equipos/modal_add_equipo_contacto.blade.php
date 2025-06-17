<div id="modal_add_equipo_contacto" class="modal fade" role="dialog">
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
								<h3 class="box-title">Contacto
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

													<div class="contenedor_formulario_contacto row" style="display: none;">
														<div class="col-sm-2"></div>
														<div class="col-sm-7" >
														  <div class="form-group">
														    <label for="auxiliar_nombre_contacto">Nombre del contacto:</label>
														    <input required="" type="text" class="form-control auxiliar_nombre_contacto" name="auxiliar_nombre_contacto" id="auxiliar_nombre_contacto" placeholder="Ingrese el nombre del nuevo contacto">
														    <label for="auxiliar_email_contacto">Correo del contacto:</label>
														    <input type="email" class="form-control auxiliar_email_contacto" name="auxiliar_email_contacto" id="auxiliar_email_contacto" placeholder="Correo electronico">
														    <label for="auxiliar_telefono_contacto">Telefono:</label>
														    <input type="text" class="form-control auxiliar_telefono_contacto" name="auxiliar_telefono_contacto" id="auxiliar_telefono_contacto" placeholder="Telefono del contacto">
														    <label for="auxiliar_tcontacto">Tipo de contacto:</label>
														    <select style="width: 100%;" class="auxiliar_tcontacto form-control select_especial" name="auxiliar_tcontacto" id="auxiliar_tcontacto"></select>
														  </div>
														  <span class="btn btn-success agregar_contacto">Añadir</span>
														</div>	
													</div>

								<form action="{{ asset('') }}equipo/Cequipos/addEquipoContacto" id="form_equipo_contacto" name="form_equipo_contacto" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<input type="hidden" name="equipo_id" id="equipo_id">
									<div class="row">
										<div class="col-sm-3">
											<label for="description">Contacto</label>
										</div>
										<div class="col-sm-8">
										<select style="width: 100%;" required="" class="form-control select_especial" name="contacto_id" id="contacto_id"></select>									
										</div>										
										<div class="col-sm-1"></div>
										<span class="glyphicon glyphicon-plus mostrar_formulario_contacto" style="font-size: 10px;font-weight: 900;" title="Ingresar nuevo contacto a la base de datos"></span>

									</div>
	
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_equipo_contacto">Ingresar</button>
									</div>
									<div class="mensaje"></div>
									<div class="errores"></div>
								</form>



								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
							<br>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div> 