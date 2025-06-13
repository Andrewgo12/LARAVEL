<table class="table table-bordered tblRelacionGuias" >
	
	<thead>
		<tr>
			<th>resultado</th>
			<th>Cantidad Equipos sin guia</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($relaciones as $relacion)
			<tr>
				<td><?php echo $relacion->consulta; ?></td>
				<td><?php echo $relacion->cuenta; ?></td>
				<td><a onclick="enviar_a_formulario('<?php echo $relacion->name;?>' ,'<?php echo $relacion->marca;?>','<?php echo $relacion->modelo;?>')" href="#" class="btn btn-warning"><i class="fa fa-random"></i></a></td>
			</tr>
		<?php endforeach ?>			
	</tbody>
</table>