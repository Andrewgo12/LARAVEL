<div class="container table-responsive">
	<a class="btn btn-info" href="<?php echo base_url();?>equipo/Cequipos/ConsolidadoCalibraciones" target="_blank">Exportar Consolidado</a><br><br>
	<table class="datatable-calibraciones table">
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
		</thead>
		<tbody>
			<?php foreach ($calibraciones as $calibracion): ?>
				<tr>
					<td><?php echo $calibracion->codigo; ?></td>
					<td><?php echo $calibracion->fecha_ejecucion; ?></td>
					<td><?php echo $calibracion->equipo; ?></td>
					<td><?php echo $calibracion->marca; ?></td>
					<td><?php echo $calibracion->modelo; ?></td>
					<td><?php echo $calibracion->serial; ?></td>
					<td><?php echo $calibracion->code; ?></td>
					<td><?php echo $calibracion->ubicacion; ?></td>
					<?php if ($calibracion->archivo!=""&&$calibracion->archivo!=null): ?>
						<td><?php echo "<a target='__blank' class='glyphicon glyphicon-file' href='".base_url()."assets/upload_calibraciones/".$calibracion->archivo."'></a>"; ?></td>
					<?php else: ?>
						<td></td>
					<?php endif ?>

				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
