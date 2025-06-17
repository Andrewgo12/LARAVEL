
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre de la guia</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ $id }}</td>
			<td>{{ $guia->name }}</td>
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
 		@foreach($combinaciones as $combinacion)
 			<tr>
 				<td>{{ $combinacion->consulta }}</td>
 				<td>{{ $combinacion->cuenta }}</td>
 				<td><a onclick="relacionar_guia_con_equipos({{ $id }}, '{{ $combinacion->name }}', '{{ $combinacion->marca }}', '{{ $combinacion->modelo }}', event)" class="btn btn-success" href=""><i class="glyphicon glyphicon-ok"></i></a></td>
 			</tr>
 		@endforeach
 	</tbody>
 </table>
