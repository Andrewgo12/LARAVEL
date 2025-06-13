<h5>Sede: {{ $sede }}</h5>

Mostrando {{ $cantidad }}
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
		@foreach($equipos as $equipo)
			<tr>
				<td>{{ $equipo->name }}</td>
				<td>{{ $equipo->marca }}</td>
				<td>{{ $equipo->modelo }}</td>
				<td>{{ $equipo->serial }}</td>
				<td>{{ $equipo->code }}</td>
				<td>{{ $equipo->servicio }}</td>
				<td>{{ $equipo->fecha_ad }}</td>
				<td>{{ $equipo->fecha_instalacion }}</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
</div>