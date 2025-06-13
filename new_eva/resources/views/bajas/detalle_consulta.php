	<table class="datatable-bajas table table-bordered table-condensed" border="1">
		<thead>
			<tr>
				<th></th>
				<th>Fecha</th>
				<th>Descripcion</th>
				<th>Archivo</th>

			</tr>
		</thead>
		<tbody>

			<?php foreach ($bajas as $baja): ?>
			<tr>
				<td>
					<span style="font-size: 8px;" class="btn btn-info" onclick="asociar_baja(<?php echo $baja->id;?>,<?php echo $equipo_id;?>)">Seleccionar</span>
						
					</td>
				<td><?php echo $baja->fecha_baja; ?></td>
				<td><?php echo $baja->descripcion; ?></td>
				<td>
					<?php if ($baja->archivo!=""&&$baja->archivo!=null): ?>
						
					<a target="__blank" class="glyphicon glyphicon-file" href="<?php echo base_url();?>assets/upload_bajas/<?php echo $baja->archivo;?>"></a>
					<?php endif ?>
				</td>
			</tr>	
			<?php endforeach ?>
		</tbody>
	</table>
