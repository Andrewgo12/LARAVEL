<strong style="font-size: 20px;text-transform: uppercase;">Repuestos instalados</strong><br>

<a href="{{ url('/') }}repuesto/Crepuestos/excel_repuestos_instalados" class="" target="__blank" >Exportar</a>
<table style="width: 70%;" class="table table-condensed table-bordered  tbl_repuestos_instalados">
	<thead>
		<tr>
			<th>Fecha de entrega</th>
			<th>Repuesto instalado</th>
			<th>Equipo</th>
			<th>Equipo Codigo</th>
			<th>Equipo Serie</th>
			<th>Equipo Marca</th>
			<th>Equipo Modelo</th>
			<th>Servicio</th>
			<th>Razon de la entrega</th>
		</tr>
	</thead>
	<tbody>
		@foreach($repuestos_instalados as $repuesto_instalado)
			<tr>
				<td>{{ $repuesto_instalado->fecha }}</td>
				<td>
					Repuesto instalado: {{ $repuesto_instalado->repuesto }}
					<br>
					Codigo: <?php echo $repuesto_instalado->codigo_repuesto ?>
					<br>
					Cantidad instalada: {{ $repuesto_instalado->cantidad_entregada }}
				</td>
				<td>
					Id: {{ $repuesto_instalado->equipo_id }}
					<br>
					{{ $repuesto_instalado->equipo_nombre }}

				</td>
				<td>{{ $repuesto_instalado->equipo_codigo }}</td>
				<td>{{ $repuesto_instalado->equipo_serie }}</td>
				<td>{{ $repuesto_instalado->marca }}</td>
				<td>{{ $repuesto_instalado->modelo }}</td>
				<td>{{ $repuesto_instalado->servicio }}</td>
				<td>
					{{ $repuesto_instalado->observacion }}
					<br><strong>Usuario que registra:</strong>
					{{ $repuesto_instalado->usuario }}
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>  