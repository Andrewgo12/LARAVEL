
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre de la guia</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $id ?></td>
			<td><?php echo $guia->name; ?></td>
		</tr>
	</tbody>
</table>
 <table class="table table-bordered table-condensed tbl-combinaciones">
 	<thead>
 		<tr>
 			<th>Combinación</th>
 			<th>Cantidad</th>
 			<th></th>

 		</tr>
 	</thead>
 	<tbody>
 			<?php foreach ($combinaciones as $combinacion): ?>
 				<tr>
 					<td><?php echo $combinacion->consulta; ?></td>
 					<td><?php echo $combinacion->cuenta; ?></td>
 					<td><a onclick="relacionar_guia_con_equipos(<?php echo $id;?>,'<?php echo $combinacion->name;?>','<?php echo $combinacion->marca;?>','<?php echo $combinacion->modelo;?>',event)" class="btn btn-success" href=""><i class="glyphicon glyphicon-ok"></i></a></td>
 				</tr>
 			<?php endforeach ?>
 		
 	</tbody>
 </table>