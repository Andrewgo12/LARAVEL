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
 		<?php foreach ($inversion_repuestos_equipo as $inversion): ?>
 			<tr>
 				<td><?php echo $inversion->id; ?></td>
 				<td><?php echo $inversion->equipo; ?></td>
 				<td><?php echo $inversion->codigo; ?></td>
 				<td><?php echo $inversion->serie; ?></td>
 				<td><?php echo $inversion->anio; ?></td>
 				<td><?php echo $inversion->cantidad; ?></td>
 				<td><?php echo $inversion->costo_total; ?></td>
 			</tr>
 		<?php endforeach ?>
 	</tbody>
 </table>