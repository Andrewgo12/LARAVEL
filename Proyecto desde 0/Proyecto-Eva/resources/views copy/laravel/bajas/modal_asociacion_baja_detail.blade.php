
<input type="hidden" name="baja_id" value="{{ $baja_id }}">
<table border="1" class="table table-condensed baja-asociacion" >
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
          @if($equipo->baja_id==$baja_id)
            <input checked type="checkbox" name="seleccion[]" value="{{ $equipo->id }}">
            @else
            <input type="checkbox" name="seleccion[]" value="{{ $equipo->id }}">
              @if($equipo->baja_id!=null&&$equipo->baja_id!=""&&$equipo->baja_id!=0)
                <span title="Asociado a otro documento de baja" style="color: red;" class="glyphicon glyphicon-info-sign"></span>
              <?php endif ?>
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <button class="btn btn-default">Asociar</button>

