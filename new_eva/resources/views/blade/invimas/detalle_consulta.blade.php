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
					<span class="btn btn-info" onclick="asociar_registro('{{ $invima->id }}')">Seleccionar</span>
					{{ $invima->invima }}
					@if($invima->file != null && $invima->file != "")
						<a target="__blank" class="glyphicon glyphicon-file" href="{{ asset('assets/upload_registros_sanitarios/' . $invima->file) }}"></a>
					@endif
				</td>
				<td>{{ $invima->description }}</td>
				<td>{{ $invima->titulo }}</td>
				<td>{{ $invima->marcas }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</html>

