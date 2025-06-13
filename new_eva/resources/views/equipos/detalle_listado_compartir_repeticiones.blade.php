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
		@foreach($equipos as $equipo)
			
		<tr>
			<td>{{ $equipo->name }}</td>
			<td>{{ $equipo->code }}</td>
			<td>{{ $equipo->serial }}</td>
			<td>{{ $equipo->marca }}</td>
			<td>{{ $equipo->modelo }}</td>
			<td></td>
		</tr>
		<?php endforeach ?>
		
	</tbody>
</table>