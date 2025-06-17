<div class="" style="overflow-x: auto;">
	<!-- <div class="" style="overflow-x: auto;"> -->
	<a class="btn btn-info" href="<?php echo base_url(); ?>correctivo_general/Ccorrectivos_generales/ExportarExcel" target="_blank">Exportar Consolidado</a><br><br>
	<table border="1" style="font-size: 12px;" class="datatable-correctivos table table-condensed">
		<thead>
			<th>Fecha de creación de la orden</th>
			<th>Codigo de orden de trabajo</th>
			<th>Descripcion de la orden</th>

			<th>Codificación de cierre</th>
			<th>Equipo</th>
			<th>Codigo Equipo</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Ubicacion</th>
			<th>Archivo</th>
			<th>Codigo de Retro</th>
			<th>Descripcion de Cierre</th>
			<th>Fecha de Cierre</th>
		</thead>
		<tbody>
			<?php foreach ($correctivos as $correctivo) : ?>
				<tr>
					<td><?php echo $correctivo->fecha_inicio; ?></td>
					<td><?php echo $correctivo->code_orden; ?></td>
					<td><span class="limitado"> <?php echo $correctivo->orden; ?></span></td>
					<td>
						<?php if ($correctivo->code_orden != "" && $correctivo->code_orden != null) : ?>
							<?php if (($correctivo->descripcion == "" || $correctivo->descripcion == null) && ($correctivo->codigo_correctivo == "" || $correctivo->codigo_correctivo == null)) : ?>
								<span style="color: red;font-size: 15px;font-weight: 700;">---Orden abierta---</span>
							<?php else : ?>
								<?php echo $correctivo->codificacion; ?>
								<hr>
								<?php echo $correctivo->descripcion_codificacion; ?>
							<?php endif ?>
						<?php else : ?>
							<span>Sin Info de orden de trabajo</span>
						<?php endif ?>
					</td>
					<td><?php echo $correctivo->equipo; ?></td>
					<td><?php echo $correctivo->code; ?></td>
					<td><?php echo $correctivo->marca; ?></td>
					<td><?php echo $correctivo->modelo; ?></td>
					<td><?php echo $correctivo->serial; ?></td>
					<td><?php echo $correctivo->ubicacion; ?></td>
					<?php if ($correctivo->archivo != "" && $correctivo->archivo != null) : ?>
						<td><?php echo "<a target='__blank' class='glyphicon glyphicon-file' href='" . base_url() . "assets/upload_correctivos_generales/" . $correctivo->archivo . "'></a>"; ?></td>
					<?php else : ?>
						<td></td>
					<?php endif ?>
					<td><?php echo $correctivo->codigo_correctivo; ?></td>
					<td class="limitado"><?php echo $correctivo->descripcion; ?></td>
					<td><?php echo $correctivo->fecha_ejecucion; ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>