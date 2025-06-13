<div class="container table-responsive">
	<a class="btn btn-info" href="{{ asset('') }}equipo/Cequipos/ConsolidadoCorrectivosGenerales" target="_blank">Exportar Consolidado</a><br><br>
	<table class="datatable-correctivos table">
		<thead>

			<th>codigo Correctivo</th>
			<th>fecha ejecución</th>
			<th>Equipo</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Codigo Equipo</th>
			<th>Ubicacion</th>
			<th>Archivo</th>
		</thead>
		<tbody>
			@foreach($correctivos as $correctivo)
				<tr>
					<td><?php echo $correctivo->codigo_correctivo; ?></td>
					<td><?php echo $correctivo->fecha_ejecucion; ?></td>
					<td><?php echo $correctivo->equipo; ?></td>
					<td><?php echo $correctivo->marca; ?></td>
					<td><?php echo $correctivo->modelo; ?></td>
					<td><?php echo $correctivo->serial; ?></td>
					<td><?php echo $correctivo->code; ?></td>
					<td><?php echo $correctivo->ubicacion; ?></td>
					@if($correctivo->archivo!=""&&$correctivo->archivo!=null)
						<td><?php echo "<a target='__blank' class='glyphicon glyphicon-file' href='".base_url()."assets/upload_correctivos_generales/".$correctivo->archivo."'></a>"; ?></td>
					@else
						<td></td>
					<?php endif ?>

				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
