<div id="modal_add_retro" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agregar retro</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Actualizacion de Ticket
								</h3>
							</div>

							<div class="box-body form-horizontal">

								<!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

								<form action="<?php echo base_url();?>orden/Cordenes/add_retro" id="form_retro" name="form_retro" enctype="multipart/form-data" method="post">
									<div class="row">
										<div class="col-sm-6 col-md-6">
										<input type="hidden" name="id" id="id">
											<label for="file_cierre">Archivo del retro</label>
											<input required="" type="file" id="file_cierre" name="file_cierre">
										</div>
									</div><br>
									<div class="row">
										<div class="col-sm-3 col-md-3">
											<input type="submit" role="button">
										</div>
									</div>
									
								</form>
								<h1><div id="mensaje"></div></h1>

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