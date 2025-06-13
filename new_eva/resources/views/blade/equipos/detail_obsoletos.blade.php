<div class="" style="overflow-x: auto;">
	<a class="btn btn-info" href="{{ asset('') }}equipo/Cequipos/ConsolidadoObsoletos" target="_blank">Exportar Consolidado</a><br><br>
	<table class="datatable-obsoletos table">
		<thead>

			<th>codigo</th>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Ubicacion</th>
			<th>Años transcurridos</th>
		</thead>
		<tbody>
			@foreach($obsoletos as $obsoleto)
				<tr>
					<td><?php echo $obsoleto->code; ?></td>
					<td><?php echo $obsoleto->name; ?></td>
					<td><?php echo $obsoleto->marca; ?></td>
					<td><?php echo $obsoleto->modelo; ?></td>
					<td><?php echo $obsoleto->serial; ?></td>
					<td><?php echo $obsoleto->ubicacion; ?></td>
					<td><?php echo $obsoleto->anios; ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
