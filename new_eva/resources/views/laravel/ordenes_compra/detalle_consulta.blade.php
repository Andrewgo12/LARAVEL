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

			@foreach($ordenes_compra as $orden_compra)
			<tr>
				<td>
					<span style="font-size: 10px;" class="btn btn-info" onclick="asociar_orden_compra('{{ $orden_compra->id }}')">Seleccionar</span>
					{{ $orden_compra->orden }}
						
					</td>
				<td>{{ $orden_compra->fecha }}</td>
				<td>{{ $orden_compra->proveedor }}</td>
				<td><a target="__blank" class="glyphicon glyphicon-file" href="{{ asset('') }}assets/upload_ordenes_compra/{{ $orden_compra->file }}"></a></td>
			</tr>	
			<?php endforeach ?>
		</tbody>
	</table>
