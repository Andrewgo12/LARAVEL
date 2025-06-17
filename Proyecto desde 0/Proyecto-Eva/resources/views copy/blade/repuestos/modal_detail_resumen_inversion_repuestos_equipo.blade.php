<!-- <?php

print_r($inversion_repuestos_equipo);
 ?> -->
 <table class="table table-bordered">
 	<thead>
 		<tr>
 			<td>#</td>
 			<td>Equipo</td>
 			<td>Codigo</td>
 			<td>Serie</td>
 			<td>Año</td>
 			<td>Cantidad de repuestos instalados</td>
 			<td>Costo total</td>
 		</tr>
 	</thead>
 	<tbody>
 		@foreach($inversion_repuestos_equipo as $inversion)
 			<tr>
 				<td>{{ $inversion->id }}</td>
 				<td>{{ $inversion->equipo }}</td>
 				<td>{{ $inversion->codigo }}</td>
 				<td>{{ $inversion->serie }}</td>
 				<td>{{ $inversion->anio }}</td>
 				<td>{{ $inversion->cantidad }}</td>
 				<td>{{ $inversion->costo_total }}</td>
 			</tr>
 		@endforeach
 	</tbody>
 </table>
