<table class="table table-bordered datatable-guias">
	<thead>
		<tr>
			<th>Nombre</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($guias_activas as $guia)
			<tr>
				<td>{{ $guia->name }}</td>
				<td><a target="__blank" style="font-size: 15px;font-weight: 800;color: orange;" href="{{ url('/') }}assets/upload_guias/{{ $guia->file }}" class="fa fa-paperclip"></a></td>
				<td><a class="btn btn-success" onclick="asociar_guia_rapida({{ $guia->id }},event)"><i class="glyphicon glyphicon-ok"></i></a></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>