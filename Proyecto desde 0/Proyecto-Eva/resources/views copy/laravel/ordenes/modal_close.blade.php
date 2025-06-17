<div id="modal_close_orden" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 30%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Cierre del Ticket</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Informe tecnico
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ asset('') }}orden/Cordenes/update" id="form_orden" name="form_orden" class="form_orden" enctype="multipart/form-data" method="post">
      @csrf

									<input type="hidden" name="id" id="id">

									<ul class="list-inline">
										<li class="list-inline-item"><span style="font-weight: 900;">Codigo del informe tecnico:</span></li>
										<li class="list-inline-item"><input required="" class="form-control" type="text" name="retro_cierre" id="retro_cierre" placeholder="Ingrese codigo"></li>
										<li class="list-inline-item"><span style="font-weight: 900;">Fecha del reporte:</span></li>
										<li class="list-inline-item"><input required="" class="form-control" type="date" id="fecha_retro_cierre" name="fecha_retro_cierre"></li>
									</ul>

									<div class="row">
										<div class="col col-sm-12">
											<label for="" class="badge">Archivo del retro</label>
											<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file_cierre" name="file_cierre">
										</div>
									</div>									

									<div class="box-footer">
										<button class="btn btn-primary" id="btn_edit_orden">Actualizar</button>
									</div>

								</form>
								<span id="errores"></span>

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