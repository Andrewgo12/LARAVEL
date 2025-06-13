 <table class="table">
 	<thead>
 		<tr>
 			<th>Fecha</th>
 			<th>Descripción</th>
 			<th>Usuario</th>
 		</tr>
 	</thead>
 	<tbody>
 		@foreach($cambios_hdv as $registro)
 			<tr>
 				<td>{{ $registro->created_at }}</td>
 				<td>{{ nl2br($registro->descripcion) }}</td>
 				<td>{{ $registro->nombre." ".$registro->apellido." (".$registro->username.")" }}</td>
 			</tr>
 		<?php endforeach ?>
 	</tbody>
 </table>
