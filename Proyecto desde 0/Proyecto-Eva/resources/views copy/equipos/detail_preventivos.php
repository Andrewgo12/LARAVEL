<div class="container table-responsive">
	<a class="btn btn-info" href="<?php echo base_url();?>equipo/Cequipos/ConsolidadoPreventivos" target="_blank">Exportar listado</a><br><br>
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
			<?php foreach ($preventivos as $preventivo): ?>
				<tr>
					<td><?php echo $preventivo->codigo; ?></td>
					<td><?php echo $preventivo->fecha_ejecucion; ?></td>
					<td><?php echo $preventivo->equipo; ?></td>
					<td><?php echo $preventivo->marca; ?></td>
					<td><?php echo $preventivo->modelo; ?></td>
					<td><?php echo $preventivo->serial; ?></td>
					<td><?php echo $preventivo->code; ?></td>
					<td><?php echo $preventivo->ubicacion; ?></td>
					<?php if ($preventivo->archivo!=""&&$preventivo->archivo!=null): ?>
						<td><?php echo "<a target='__blank' class='glyphicon glyphicon-file' href='".base_url()."assets/upload_preventivos/".$preventivo->archivo."'></a>"; ?></td>
					<?php else: ?>
						<td></td>
					<?php endif ?>
					<td><?php echo $preventivo->observacion; ?></td>

				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
