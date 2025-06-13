<html>
	<table class="datatable-invimas" border="1">
		<thead>
			<tr>
				<th>Registro sanitario</th>
				<th>Descripcion</th>
				<th>Titulo</th>
				<th>Marcas</th>

			</tr>
		</thead>
		<tbody>

			@foreach($invimas as $invima)
			<tr>
				<td>
					<span class="btn btn-info" onclick="asociar_registro('<?php echo $invima->id;?>')">Seleccionar</span>
					<?php echo $invima->invima; ?>
					@if($invima->file!=null&$invima->file!="")
							<a target="__blank" class="glyphicon glyphicon-file" href="{{ asset('') }}assets/upload_registros_sanitarios/<?php echo $invima->file;?>"></a>
						<?php endif ?>	

				</td>
				<td><?php echo $invima->description; ?></td>
				<td><?php echo $invima->titulo; ?></td>
				<td><?php echo $invima->marcas; ?></td>
			</tr>	
			<?php endforeach ?>
		</tbody>
	</table>
</html>