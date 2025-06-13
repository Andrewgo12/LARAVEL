<div class="content-wrapper">
  <section class="content-header">
    <h3>Services</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <?php $acciones = {{ session('acciones') }}; ?>
        @foreach($acciones as $accion)
          @if($accion->modulo == "servicios")
            @if($accion->insertar == 1)
              <div class="custom-row">
                <button class="custom-btn-figure" onclick="(new serviceObj).OpenModalInsert(event)" data-toggle="modal" data-target="#modal_add_servicio" type="button">
                  <li class="fa fa-plus"></li>
                </button>
              </div>
              <br>
            <?php endif ?>
          <?php endif ?>
        <?php endforeach ?>
        <table class="tblServicios table table-info container-table" id="tblServicios" name="tblServicios">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Zona</th>
              <th>Centro de costo</th>
              <th>Sede</th>
              <th>Equipos asociados</th>
              <th>Areas asociadas</th>
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
  var controlador = "<?php print_r({{ session('controlador') }}); ?>";
  var eliminar_servicio = "<?php print_r({{ session('acciones') }}[2]->eliminar); ?>"; //servicios
  var editar_servicio = "<?php print_r({{ session('acciones') }}[2]->editar); ?>"; //servicios
</script>