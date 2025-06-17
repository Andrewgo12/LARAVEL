<div class="content-wrapper">
  <section class="content-header">
    <h3>Areas</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <?php $acciones = session('acciones'); ?>
        @foreach($acciones as $accion)
          @if($accion->modulo == "areas")
            @if($accion->insertar == 1)
              <div class="custom-row">
                <button class="custom-btn-figure" onclick="(new areaObj).OpenModalInsert(event)" data-toggle="modal" data-target="#modal_add_area" type="button">
                  <li class=" fa fa-plus"></li>
                </button>
              </div>
              <br>
            <?php endif ?>
          <?php endif ?>
        <?php endforeach ?>
        <table class="tblAreas table table-info container-table" id="tblAreas" name="tblAreas">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Servicio</th>
              <th>Sede</th>
              <th>Piso</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php print_r(session('controlador')); ?>";
  var eliminar_area = "<?php print_r(session('acciones')[19]->eliminar); ?>"; //areas
  var editar_area = "<?php print_r(session('acciones')[19]->editar); ?>"; //areas
</script>