<div id="modal_add_archivo_correctivo" class="modal fade" role="dialog">
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
								<h3 class="box-title">Archivo
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="{{ asset('') }}equipo/Cequipos/addArchivoCorrectivoGeneral" id="form_archivo_correctivo_general" name="form_archivo_correctivo_general" enctype="multipart/form-data" method="post">
      @csrf
									<br>
									<input type="hidden" name="correctivo_general_id" id="correctivo_general_id">
									<input type="hidden" name="equipo_id" id="equipo_id">
									<label for="titulo">Titulo</label><input required="" class="form-control" id="titulo" name="titulo" type="text" placeholder="Titulo">
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Archivo asociado</label>
												<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											</div>
										</div>
									</div>	
									<div class="box-footer">
										<button class="btn btn-primary" id="btn_add_archivo_correctivo_general">Ingresar</button>
									</div>
								</form>
								


								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-success" id="actualizar">Agregar</button> -->
				</div>

			</div>
		</div>
	</div>
</div> 