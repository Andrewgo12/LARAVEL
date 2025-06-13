<table class="table table-bordered datatable-manuales">
	<thead>
		<tr>
			<th>Id</th>
			<th>Descripción del manual</th>
			<th>Url</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($manuales_activos as $manual)
			<tr>
				<td><?php echo $manual->id; ?></td>
				<td><?php echo $manual->descripcion; ?></td>
				<td><a target="__blank" href="<?php echo $manual->url;?>" class="fa fa-external-link-square btn btn-link"></a></td>
				<td><a class="btn btn-success" onclick="asociar_manual(<?php echo $manual->id;?>,event)"><i class="glyphicon glyphicon-ok"></i></a></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>