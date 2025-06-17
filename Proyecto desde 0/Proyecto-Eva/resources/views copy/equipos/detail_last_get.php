<h5>Sede: <?php echo $sede; ?></h5>

Mostrando <?php echo $cantidad; ?>
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Codigo</th>
			<th>Servicio</th>
			<th>Fecha de adquisicion</th>
			<th>Fecha de instalacion</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($equipos as $equipo): ?>
			<tr>
				<td><?php echo $equipo->name; ?></td>
				<td><?php echo $equipo->marca; ?></td>
				<td><?php echo $equipo->modelo; ?></td>
				<td><?php echo $equipo->serial; ?></td>
				<td><?php echo $equipo->code; ?></td>
				<td><?php echo $equipo->servicio; ?></td>
				<td><?php echo $equipo->fecha_ad; ?></td>
				<td><?php echo $equipo->fecha_instalacion; ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
</div>