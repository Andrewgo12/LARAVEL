
<table class="table table-bordered">
	<thead>
		<th>Descripcion</th>
		<th>Fecha</th>
		<th>Accion</th>
		<th>Cantidad</th>
		<th>Razon</th>
	</thead>
	<tbody>
		<?php foreach ($movimientos as $movimiento): ?>
			<tr>
				<td><?php echo $movimiento->description; ?></td>
				<td><?php echo $movimiento->created_at; ?></td>
				<td><?php echo $movimiento->accion; ?></td>
				<td><?php echo $movimiento->cantidad; ?></td>
				<td><?php echo $movimiento->razon; ?></td>
			</tr>
		<?php endforeach ?>
		
	</tbody>
</table>