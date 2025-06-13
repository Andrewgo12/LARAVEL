
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
        <td><?php echo $equipo->id; ?></td>
        <td><?php echo $equipo->name; ?></td>
        <td><?php echo $equipo->marca; ?></td>
        <td><?php echo $equipo->modelo; ?></td>
        <td><?php echo $equipo->code; ?></td>
        <td><?php echo $equipo->serial; ?></td>
        <td>
          @if($equipo->baja_id==$baja_id)
            <input checked type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>">
            @else
            <input type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>">
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

