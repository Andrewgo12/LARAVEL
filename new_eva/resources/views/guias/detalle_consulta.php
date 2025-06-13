<table class="table table-bordered datatable-guias">
	<thead>
		<tr>
			<th>Nombre</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($guias_activas as $guia): ?>
			<tr>
				<td><?php echo $guia->name; ?></td>
				<td><a target="__blank" style="font-size: 15px;font-weight: 800;color: orange;" href="<?php echo base_url(); ?>assets/upload_guias/<?php echo $guia->file; ?>" class="fa fa-paperclip"></a></td>
				<td><a class="btn btn-success" onclick="asociar_guia_rapida(<?php echo $guia->id;?>,event)"><i class="glyphicon glyphicon-ok"></i></a></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>