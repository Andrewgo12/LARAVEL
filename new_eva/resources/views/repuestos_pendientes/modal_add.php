<div id="modal_add_repuesto_pendiente_ticket" class="modal fade" role="dialog">
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
								<h3 class="box-title">Repuesto pendiente
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="<?php echo base_url();?>correctivo_general/Cavances_correctivos/add" id="form_add_avance_correctivo" name="form_add_avance_correctivo" enctype="multipart/form-data" method="post">
									<br>
									<div class="row">
											<div class="col col-sm-12">
												<label for="" class="badge">Repuesto pendiente</label>
												<input type="text" class="form-control" id="repuesto_pendiente" name="repuesto_pendiente">
												<input type="hidden" id="repuesto_pendiente_condicion" name="repuesto_pendiente_condicion" value="si">
											</div>
									</div>									
									<div class="box-footer">
										<button  class="btn btn-primary" id="ingresar_repuesto_pendiente">Ingresar</button>
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