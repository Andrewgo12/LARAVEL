<h3>Subir Imagen</h3>
<form action="{{ asset('') }}cupload/subirImagen" method="POST" enctype="multipart/form-data">
	<table>
		<tr>
			<td>Titulo</td>
			<td><input type="text" name="titImagen" class="form-control"></td>
		</tr>
		<tr>
			<td>Imagen</td>
			<td>
				<input type="file" name="fileImagen" class="form-control">
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Guardar"></td>
		</tr>
	</table>
</form>

{{ $error }}
<br><br>
<h3>Subir y descargar Archivo</h3>
<form action="{{ asset('') }}cupload/subirArchivo" method="POST" enctype="multipart/form-data">
	<table>
		<tr>
			<td>Titulo</td>
			<td><input type="text" name="titImagen" class="form-control"></td>
		</tr>
		<tr>
			<td>Imagen</td>
			<td>
				<input type="file" name="fileImagen" class="form-control">
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Guardar"></td>
		</tr>
	</table>
</form>
{{ $errorArch }}
{{ $estado }}
<a href="{{ asset('') }}cupload/downloads/{{ $archivo }}">Descargar</a>
