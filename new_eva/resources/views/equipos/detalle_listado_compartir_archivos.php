<div class="contenedor_creado"></div>
<input type="hidden" name="equipo_archivo_origen_id" id="equipo_archivo_origen_id" value="<?php echo $equipo_archivo_origen_id;?>">
<input onclick="seleccionar_todos()" type="checkbox" class="total_box" label="check all"  />Seleccionar todos
<input type="text" id="control" name="control" class="control" value=0>
<table style="font-size: 12px;" class="table table-condensed table-sm table-hover tbl-listado-equipos">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Codigo</th>
			<th>Serie</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Sede</th>
			<th>Servicio</th>
			<th>Area</th>
			<th>Soporte de adquisicion</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($equipos as $equipo): ?>
			
		<tr>
			<td><?php echo $equipo->name; ?></td>
			<td><?php echo $equipo->code; ?></td>
			<td><?php echo $equipo->serial; ?></td>
			<td><?php echo $equipo->marca; ?></td>
			<td><?php echo $equipo->modelo; ?></td>
			<td><?php echo $equipo->sede; ?></td>
			<td><?php echo $equipo->servicio; ?></td>
			<td><?php echo $equipo->area; ?></td>
			<td><?php echo $equipo->soporte_compra."(".$equipo->proveedor.")"; ?></td>
			<td><input class="registro_<?php echo $equipo->id;?> total_box1" onclick="funcion_creacion_input_archivos(<?php echo $equipo->id; ?>)" type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>"></td>

		</tr>
		<?php endforeach ?>
		
	</tbody>
</table>

  <button class="btn btn-default">Compartir</button>
