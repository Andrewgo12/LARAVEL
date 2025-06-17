<table class="table table-bordered">
 	<thead>
 		<tr>
 			<th>Sede</th>
 			<th>Servicio</th>
 			<th>Año</th>
 			<th>Cantidad de repuestos instalados</th>
 			<th>Costo total</th>
 		</tr>
 	</thead>
 	<tbody>
 		@foreach($inversion_repuestos_servicio as $inversion)
 			<tr>
 				<td>{{ $inversion->sede }}</td>
 				<td>{{ $inversion->servicio }}</td>
 				<td>{{ $inversion->anio }}</td>
 				<td>{{ $inversion->costo_total }}</td>
 				<td>{{ $inversion->cantidad }}</td>
 			</tr>
 		@endforeach
 	</tbody>
 </table>
