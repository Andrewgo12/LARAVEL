
<table class="table table-bordered">
	<thead>
		<th>Descripcion</th>
		<th>Fecha</th>
		<th>Accion</th>
		<th>Cantidad</th>
		<th>Razon</th>
	</thead>
	<tbody>
		@foreach($movimientos as $movimiento)
			<tr>
				<td>{{ $movimiento->description }}</td>
				<td>{{ $movimiento->created_at }}</td>
				<td>{{ $movimiento->accion }}</td>
				<td>{{ $movimiento->cantidad }}</td>
				<td>{{ $movimiento->razon }}</td>
			</tr>
		<?php endforeach ?>
		
	</tbody>
</table>