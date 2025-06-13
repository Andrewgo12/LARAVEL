<div id="modal_add_avance_correctivo" class="modal fade" role="dialog">
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
								<h3 class="box-title">Avance
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="<?php echo base_url();?>correctivo_general/Cavances_correctivos/add" id="form_add_avance_correctivo" name="form_add_avance_correctivo" enctype="multipart/form-data" method="post">
									<br>
									<input type="hidden" name="correctivo_general_id" id="correctivo_general_id">
									<input type="hidden" name="orden_id" id="orden_id">
									<input type="hidden" name="origen" id="origen" class="origen">

									<p>
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="date" class="badge">Fecha de avance</label>
												<input required="" type="date" class="form-control" id="date" name="date" >
											</div>
										</div>
									</div>	
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="description" class="badge">Titulo o asunto del avance</label>
												<input type="text" class="form-control" id="title" name="title" placeholder="Titulo del avance">
											</div>
										</div>
									</div>	
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="description" class="badge">Descripción del avance</label>
												<textarea required="" placeholder="Descripción detallada del avance" class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
											</div>
										</div>
									</div>	
									<div class="row">
										<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Archivo asociado</label>
												<input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
											</div>
										</div>
									</div>									
									<div class="box-footer">
										<button class="btn btn-primary" id="ingresar_avance_correctivo">Ingresar</button>
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