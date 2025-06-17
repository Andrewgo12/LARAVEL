<div class="content-wrapper">
  <section class="content-header">
    <h3>Gestion de Tickets</h3> <small>List</small>
    <input class="rol" type="hidden" value=<?= session('rol_id') ?>>
    <input class="usuario_id" type="hidden" value=<?= session('id') ?>>
  </section>
  <section class="content">
    <?php if ($this->session->tempdata('message')) { ?>
      <div class="alert alert-info text-center">
        <?php sleep(5);
        echo $this->session->tempdata('message'); ?>
      </div>
    <?php }   ?>
    <div class="box box-solid orden_activa">
      <div class="box-body">
        <hr>
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <div class="row">
              <div class="col-xs-4">
                <div class="form-group">
                  <label>Estado orden</label>
                  <select class="form-control select2 estado_id" style="width: 100%;">
                    <option value="">--------</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label>Sede</label>
                  <select class="form-control select2 sede_id">
                    <option value="0">--------</option>
                    <option value="1">Principal</option>
                    <option value="2">Norte</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label>Fecha creacion de ticket</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right rango-fechas">
                  </div>
                  <label class="checkbox-inline"><input type="checkbox" value="" class="condicion">Aplicar filtro</label>
                </div>
              </div>
            </div>
            <a href="#" data-toggle="modal" data-target="#modal_edit_orden" class="abrir_modal_edit_orden"></a>
            <table class="table container-table table-info" id="tblOrdenes">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Descripcion</th>
                  <th>Fecha de creación</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "<?= base_url(); ?>";
  var rol = "<?= session('rol_id'); ?>";
  var id_propio = "<?= session('id'); ?>";
  var controlador = "<?php echo session('controlador'); ?>";
  var insertar_observacion = "<?php print_r(session('acciones')[17]->insertar); ?>";
  var eliminar_observacion = "<?php print_r(session('acciones')[17]->eliminar); ?>";
  var editar_observacion = "<?php print_r(session('acciones')[17]->editar); ?>";
</script>