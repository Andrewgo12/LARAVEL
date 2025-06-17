	<table class="datatable-ordenes-compra table table-bordered table-condensed" border="1">
		<thead>
			<tr>
				<th>Codigo</th>
				<th>Fecha</th>
				<th>Proveedor</th>
				<th>Archivo</th>

			</tr>
		</thead>
		<tbody>

			<?php foreach ($ordenes_compra as $orden_compra): ?>
			<tr>
				<td>
					<span style="font-size: 10px;" class="btn btn-info" onclick="asociar_orden_compra('<?php echo $orden_compra->id;?>')">Seleccionar</span>
					<?php echo $orden_compra->orden; ?>
						
					</td>
				<td><?php echo $orden_compra->fecha; ?></td>
				<td><?php echo $orden_compra->proveedor; ?></td>
				<td><a target="__blank" class="glyphicon glyphicon-file" href="<?php echo base_url();?>assets/upload_ordenes_compra/<?php echo $orden_compra->file;?>"></a></td>
			</tr>	
			<?php endforeach ?>
		</tbody>
	</table>
