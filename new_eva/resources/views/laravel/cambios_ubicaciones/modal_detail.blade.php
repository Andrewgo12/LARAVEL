<table class="tblCambiosEquipos table table-condensed table-bordered table-sm table-hover">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Servicio origen</th>
			<th>Servicio destino</th>
			<th>Area origen</th>
			<th>Area destino</th>
			<th>Sede origen</th>
			<th>Sede destino</th>
			<th>Responsable</th>
		</tr>
	</thead>
	<tbody style="text-transform: lowercase;">
		@foreach($cambios_ubicaciones as $cambio_ubicacion)
			<tr>
				<td>{{ $cambio_ubicacion->fecha }}</td>
				<td>{{ $cambio_ubicacion->servicio_origen }}</td>
				<td>{{ $cambio_ubicacion->servicio_destino }}</td>
				<td>{{ $cambio_ubicacion->area_origen }}</td>
				<td>{{ $cambio_ubicacion->area_destino }}</td>
				<td>{{ $cambio_ubicacion->sede_origen }}</td>
				<td>{{ $cambio_ubicacion->sede_destino }}</td>
				<td>{{ $cambio_ubicacion->usuario }}</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>