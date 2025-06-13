<div id="modal_update_plan_mantenimiento" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Registro de plan de mantenimiento
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="" name="form_update_plan_mantenimiento" class="form_update_plan_mantenimiento" enctype="multipart/form-data" method="post">
      @csrf
									<input type="hidden" id="id" name="id" class="id">
									<ul class="list-inline">
										<li class="list-inline-item">
											<label for="mes1">Mes1</label>
											<select name="mes1" id="mes1" class="mes1 form-control">
												<option value="">-------</option>
												<option value="1">Enero</option>
												<option value="2">Febrero</option>
												<option value="3">Marzo</option>
												<option value="4">Abril</option>
												<option value="5">Mayo</option>
												<option value="6">Junio</option>
												<option value="7">Julio</option>
												<option value="8">Agosto</option>
												<option value="9">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</li>
										<li class="list-inline-item">
											<label for="mes2">Mes2</label>
											<select name="mes2" id="mes2" class="mes2 form-control">
												<option value="">-------</option>
												<option value="1">Enero</option>
												<option value="2">Febrero</option>
												<option value="3">Marzo</option>
												<option value="4">Abril</option>
												<option value="5">Mayo</option>
												<option value="6">Junio</option>
												<option value="7">Julio</option>
												<option value="8">Agosto</option>
												<option value="9">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</li>
										<li class="list-inline-item">
											<label for="mes3">Mes3</label>
											<select name="mes3" id="mes3" class="mes3 form-control">
												<option value="">-------</option>
												<option value="1">Enero</option>
												<option value="2">Febrero</option>
												<option value="3">Marzo</option>
												<option value="4">Abril</option>
												<option value="5">Mayo</option>
												<option value="6">Junio</option>
												<option value="7">Julio</option>
												<option value="8">Agosto</option>
												<option value="9">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</li>

									</ul>
									<div class="form-group">
										<label for="name">Responsable</label>
										<input autocomplete="off" list="responsables" type="text" class="form-control responsable" id="responsable" name="responsable" placeholder="Quien realiza el mantenimiento" required="">
										<datalist id="responsables" class="responsables">

										</datalist>
									</div>

									<div class="box-footer">
										<button class="btn btn-primary btn_update_plan_mantenimiento">Actualizar</button>
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
				</div>

			</div>
		</div>
	</div>
</div> 