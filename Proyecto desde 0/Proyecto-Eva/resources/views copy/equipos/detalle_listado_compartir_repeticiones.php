<table style="font-size: 12px;" class="table table-condensed table-sm table-hover tbl-listado-equipos">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Codigo</th>
			<th>Serie</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($equipos as $equipo): ?>
			
		<tr>
			<td><?php echo $equipo->name; ?></td>
			<td><?php echo $equipo->code; ?></td>
			<td><?php echo $equipo->serial; ?></td>
			<td><?php echo $equipo->marca; ?></td>
			<td><?php echo $equipo->modelo; ?></td>
			<td></td>
		</tr>
		<?php endforeach ?>
		
	</tbody>
</table>