<div class="" style="overflow-x: auto;">
	<a class="btn btn-info" href="{{ url('/') }}equipo/Cequipos/ConsolidadoObsoletos" target="_blank">Exportar Consolidado</a><br><br>
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
					<td>{{ $obsoleto->code }}</td>
					<td>{{ $obsoleto->name }}</td>
					<td>{{ $obsoleto->marca }}</td>
					<td>{{ $obsoleto->modelo }}</td>
					<td>{{ $obsoleto->serial }}</td>
					<td>{{ $obsoleto->ubicacion }}</td>
					<td>{{ $obsoleto->anios }}</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
