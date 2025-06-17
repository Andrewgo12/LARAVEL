
<input type="hidden" name="orden_compra_id" value="{{ $orden_compra_id }}">
<a class="btn btn-info" href="{{ asset('') }}ordenes_compra/Cordenes_compra/ExportarExcel/{{ $orden_compra_id }}" target="_blank">Exportar</a><br><br>

<table border="1" class="table table-condensed orden-compra-asociacion-especifico" >
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Marca</th>
      <th>Modelo</th>
      <th>Codigo</th>
      <th>Serie</th>
      <th>Servicio de instalación</th>
      <th>Area de instalación</th>
      <th>Fecha de instalación</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($equipos as $equipo)
      <tr>
        <td>{{ $equipo->id }}</td>
        <td>{{ $equipo->name }}</td>
        <td>{{ $equipo->marca }}</td>
        <td>{{ $equipo->modelo }}</td>
        <td>{{ $equipo->code }}</td>
        <td>{{ $equipo->serial }}</td>
        <td>{{ $equipo->servicio }}</td>
        <td>{{ $equipo->area }}</td>
        <td>{{ $equipo->fecha_instalacion }}</td>
        <td><input type="checkbox" name="seleccion[]" value="{{ $equipo->id }}"></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>

<button class="btn btn-default">Desvincular</button>

