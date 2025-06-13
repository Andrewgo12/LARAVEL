
<input type="hidden" name="orden_compra_id" value="<?php echo $orden_compra_id;?>">
<div class="table-responsive">
<table border="1" class="table table-condensed orden-compra-asociacion" >
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
    <?php foreach ($equipos as $equipo): ?>
      <tr>
        <td><?php echo $equipo->id; ?></td>
        <td><?php echo $equipo->name; ?></td>
        <td><?php echo $equipo->marca; ?></td>
        <td><?php echo $equipo->modelo; ?></td>
        <td><?php echo $equipo->code; ?></td>
        <td><?php echo $equipo->serial; ?></td>
        <td><?php echo $equipo->servicio; ?></td>
        <td>
          <?php if ($equipo->orden_compra_id==$orden_compra_id): ?>
            <input checked type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>">
            <?php else: ?>
            <input type="checkbox" name="seleccion[]" value="<?php echo $equipo->id; ?>">
              <?php if ($equipo->orden_compra_id!=null&&$equipo->orden_compra_id!=""&&$equipo->orden_compra_id!=0): ?>
                <span title="Asociado a otro soporte de compra" style="color: red;" class="glyphicon glyphicon-info-sign"></span>
              <?php endif ?>

            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
  <button class="btn btn-default">Asociar</button>

