<div id="modal_archivo_solicitud_cierre_orden" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 60%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Informe tecnico de cierre</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ url('/') }}orden/Cordenes/update_solicitar_cierre_orden" id="form_solicitar_cierre_orden" name="form_solicitar_cierre_orden" class="form_solicitar_cierre_orden" enctype="multipart/form-data" method="post">
									<input type="hidden" name="id" id="id" class="id">
									<h4 class="badge">Archivo</h4>
									<input class="file" data-browse-on-zone-click="true" type="file" name="file_cierre" id="file_cierre">

									<div class="box-footer">
										<button class="btn btn-primary" id="btn_update">Actualizar</button>
										<h1><div id="mensaje"></div></h1>
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
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div> 