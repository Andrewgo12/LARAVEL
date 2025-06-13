<?php
?>
<table class="table tabla_secop">

	<thead>
		<tr>
			<th>Id</th>
			<th>Fecha inicio ejecucion contrato</th>
			<th>Proveedor</th>
			<th>Objeto</th>
			<th>Detalle objeto</th>
			<th>Cuantia</th>
			<th>Contrato</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($vector as $registro) { ?>
			<?php if (isset($registro['fecha_ini_ejec_contrato'])) { ?>
				<tr>
					<td>{{ $registro['uid'] }}</td>
					<?php if (isset($registro['fecha_ini_ejec_contrato'])) { ?>
						<td>{{ $registro['fecha_ini_ejec_contrato'] }}</td>
					<?php } else { ?>
						<td>No registra</td>
					<?php } ?>
					<td>{{ $registro['nom_raz_social_contratista'] }}</td>
					<td>{{ $registro['objeto_a_contratar'] }}</td>
					<td>{{ $registro['objeto_del_contrato_a_la'] }}</td>
					<td>${{ number_format($registro['cuantia_contrato'], 2) }}</td>
					<td><a href="{{ $registro['ruta_proceso_en_secop_i']['url'] }}" target="__blank">
							{{ $registro['numero_del_contrato'] }}</a></td>
				</tr>
			<?php } ?>
		<?php } ?>
	</tbody>
</table>