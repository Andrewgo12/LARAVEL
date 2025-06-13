
<input type="hidden" name="invima_id" value="{{ $invima_id }}">
<table border="1" class="table table-condensed invima-asociacion" >
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Marca</th>
      <th>Modelo</th>
      <th>Codigo</th>
      <th>Serie</th>
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
        <td>
          @if($equipo->invima_id==$invima_id)
            <input checked type="checkbox" name="seleccion[]" value="{{ $equipo->id }}">
            @else
            <input type="checkbox" name="seleccion[]" value="{{ $equipo->id }}">
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <button class="btn btn-default">Asociar</button>

