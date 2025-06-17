<div class="contenedor_creado"></div>
<input type="hidden" name="equipo_origen_id" id="equipo_origen_id" value="{{ $equipo_origen_id }}">
<table style="font-size: 12px;" class="table table-condensed table-sm table-hover tbl-listado-equipos">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Codigo</th>
			<th>Serie</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>#Espec.</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($equipos as $equipo)
			
		<tr>
			<td><?php echo $equipo->name; ?></td>
			<td><?php echo $equipo->code; ?></td>
			<td><?php echo $equipo->serial; ?></td>
			<td><?php echo $equipo->marca; ?></td>
			<td><?php echo $equipo->modelo; ?></td>
			<td><?php echo $equipo->numero_especificaciones; ?></td>
			<td><input class="registro_<?php echo $equipo->id;?>" onclick="funcion_creacion_input_especificaciones_tecnicas(<?php echo $equipo->id; ?>)" type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>"></td>
		</tr>
		<?php endforeach ?>
		
	</tbody>
</table>

  <button class="btn btn-default">Compartir</button>
