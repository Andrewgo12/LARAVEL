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
 		<?php foreach ($inversion_repuestos_servicio as $inversion): ?>
 			<tr>
 				<td><?php echo $inversion->sede; ?></td>
 				<td><?php echo $inversion->servicio; ?></td>
 				<td><?php echo $inversion->anio; ?></td>
 				<td><?php echo $inversion->costo_total; ?></td>
 				<td><?php echo $inversion->cantidad; ?></td>
 			</tr>
 		<?php endforeach ?>
 	</tbody>
 </table>