<input type="hidden" name="orden_compra_id" value="{{ $orden_compra_id }}">
<div class="table-responsive">
  <table border="1" class="table table-condensed orden-compra-asociacion">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Codigo</th>
        <th>Serie</th>
        <th>Servicio</th>
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
          <td>
            @if($equipo->orden_compra_id == $orden_compra_id)
              <input checked type="checkbox" name="seleccion[]" value="{{ $equipo->id }}">
            @else
              <input type="checkbox" name="seleccion[]" value="{{ $equipo->id }}">
              @if($equipo->orden_compra_id != null && $equipo->orden_compra_id != "" && $equipo->orden_compra_id != 0)
                <span title="Asociado a otro soporte de compra" style="color: red;" class="glyphicon glyphicon-info-sign"></span>
              @endif
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<button type="submit" class="btn btn-primary">Asociar</button>s
