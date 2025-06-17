
<input type="hidden" name="invima_id" value="<?php echo $invima_id;?>">
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
    <?php foreach ($equipos as $equipo): ?>
      <tr>
        <td><?php echo $equipo->id; ?></td>
        <td><?php echo $equipo->name; ?></td>
        <td><?php echo $equipo->marca; ?></td>
        <td><?php echo $equipo->modelo; ?></td>
        <td><?php echo $equipo->code; ?></td>
        <td><?php echo $equipo->serial; ?></td>
        <td>
          <?php if ($equipo->invima_id==$invima_id): ?>
            <input checked type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>">
            <?php else: ?>
            <input type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>">
              <?php if ($equipo->invima_id!=null&&$equipo->invima_id!=""&&$equipo->invima_id!=0): ?>
                <span title="Asociado a otro registro sanitario" style="color: red;" class="glyphicon glyphicon-info-sign"></span>
              <?php endif ?>
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <button class="btn btn-default">Asociar</button>

