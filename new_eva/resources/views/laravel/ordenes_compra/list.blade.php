<div class="content-wrapper">
	<section class="content-header">
		<h3>purchase orders</h3> <small>List</small>
	</section>
	<section class="content">
		<div class="box box-solid">
			<div class="box-body">
				<hr>
				<?php if (!empty($ordenes_compra)) : ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<div class="custom-row">
									<a href="" class="custom-btn-figure" data-toggle="modal" data-target="#modal_add_orden_compra">
										<li class="glyphicon glyphicon-plus"></li>
									</a>
									<a class="custom-btn-figure" href="#" onclick="consultar_secop(event)" data-toggle="modal" data-target="#modal_api">
										<li class="glyphicon glyphicon-search"></li>
									</a>
									<a class="custom-btn-figure" href="{{ asset('') }}ordenes_compra/Cordenes_compra/ExportExcelAll">
										<li class="fa fa-file-excel-o"></li>
									</a>
								</div>
								<table class="table table-info container-table tabla_ordenes_compra">
									<thead>
										<tr>
											<th>Codigo/Numero de soporte</th>
											<th>Tipo de compra</th>
											<th>Fecha</th>
											<th>Archivo</th>
											<th>Proveedor</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		@else
			<a href="" class="btn btn-success glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_orden_compra"></a>
			<span style="font-size: 50px;">No existen registros!</span>
		<?php endif ?>
		</div>
	</section>
</div>
<script>
	var base_url = "<?= base_url(); ?>";
	var controlador = "<?php echo session('controlador'); ?>";
</script>