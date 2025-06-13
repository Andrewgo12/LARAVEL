<div class="table-responsive">
	<table class="table table-condensed table-sm tblCorrectivosAbiertos">
		<thead>
			<tr>
				<th>Fecha de creación</th>
				<th>Equipo</th>
				<th>Codigo</th>
				<th>Descripción</th>
				<th>Codigo Equipo</th>
				<th>Serie Equipo</th>
				<th>Servicio</th>
				<th>Area</th>
				<th>#avances</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<!-- 			@foreach($abiertos as $abierto)
				<tr>
					<td><span style="font-size: 10px;">{{ $abierto->fecha_inicio }}</span></td>
					<td>{{ $abierto->code_orden }}</td>
					<td>{{ $abierto->orden }}</td>
					<td>{{ $abierto->codigo_equipo }}</td>
					<td>{{ $abierto->serie_equipo }}</td>
					<td>{{ $abierto->servicio }}</td>
					<td>{{ $abierto->area }}</td>
					<td><span class="badge">{{ $abierto->avances }}</span></td>
					<td><a data-toggle="modal" data-target="#modal_update_correctivo_general" onclick="recover_modal_edit_correctivo_general({{ $abierto->id }})" class="btn btn-success glyphicon glyphicon-pencil" style="padding:5px;"></a></td>
				</tr>
			<?php endforeach ?>
 -->		</tbody>
	</table>
</div>