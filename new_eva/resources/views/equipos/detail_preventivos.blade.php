<div class="container table-responsive">
	<a class="btn btn-info" href="{{ url('/') }}equipo/Cequipos/ConsolidadoPreventivos" target="_blank">Exportar listado</a><br><br>
	<table class="datatable-preventivos table">
		<thead>

			<th>codigo</th>
			<th>fecha ejecución</th>
			<th>Equipo</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Codigo</th>
			<th>Ubicacion</th>
			<th>Archivo</th>
			<th>Observaciones</th>
		</thead>
		<tbody>
			@foreach($preventivos as $preventivo)
				<tr>
					<td>{{ $preventivo->codigo }}</td>
					<td>{{ $preventivo->fecha_ejecucion }}</td>
					<td>{{ $preventivo->equipo }}</td>
					<td>{{ $preventivo->marca }}</td>
					<td>{{ $preventivo->modelo }}</td>
					<td>{{ $preventivo->serial }}</td>
					<td>{{ $preventivo->code }}</td>
					<td>{{ $preventivo->ubicacion }}</td>
					@if($preventivo->archivo!=""&&$preventivo->archivo!=null)
						<td>{{ "<a target='__blank' class='glyphicon glyphicon-file' href='".url('/')."assets/upload_preventivos/".$preventivo->archivo."'></a>" }}</td>
					@else
						<td></td>
					<?php endif ?>
					<td>{{ $preventivo->observacion }}</td>

				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
