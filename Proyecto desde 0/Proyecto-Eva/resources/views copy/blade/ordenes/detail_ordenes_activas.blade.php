<div class="text-center">
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Asunto</th>
			<th>Descripción</th>
			<th>Fecha creación</th>
			<th>Estado</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($ordenes_activas as $orden_activa)
			<tr>
				<td>{{ $orden_activa->asunto }}</td>
				<td>{{ $orden_activa->descripcion }}</td>
				<td>{{ $orden_activa->fecha_inicio }}</td>
				<td>{{ $orden_activa->estado }}</td>
				<td>
					<a href=""
					   class="glyphicon glyphicon-pencil"
					   data-toggle="modal"
					   data-target="#modal_edit_orden_activa"
					   onclick="recover_modal_edit_orden_activa({{ $orden_activa->id }})">
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

