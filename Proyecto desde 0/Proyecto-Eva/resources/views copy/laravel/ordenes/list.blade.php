<div class="content-wrapper" style="">
  <section class="content-header">
    <img id="eva-tickets" src="<?php echo base_url('assets/template/eva_modificada.jpg'); ?>" />
  </section>
  <section class="content">
    <div class="box box-solid orden_creada">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <ul class="list-inline">
              <li class="list-inline-item"><a data-toggle="modal" onclick="inicio_modal()" data-target="#modal_add_biomedicos" title="Generar orden de trabajo para la revisión y/o reparación de equipos biomedicos" class="btn btn-lg btn-primary abrir_modal_add_orden_biomedico" href=""><span class="fa fa-ticket">Equipos biomedicos</span></a></li>
              <li class="list-inline-item"><a data-toggle="modal" onclick="inicio_modal()" data-target="#modal_add_industriales" title="Generar orden de trabajo para la revisión y/o reparación de equipos industriales" class="btn btn-lg btn-primary abrir_modal_add_orden_industrial" href=""><span class="fa fa-ticket">Equipos industriales</span></a></li>
              <li class="list-inline-item"><a data-toggle="modal" onclick="inicio_modal()" data-target="#modal_add_otros" title="Generar orden de trabajo" class="btn btn-lg btn-primary abrir_modal_add_orden_otros" href=""><span class="fa fa-ticket">Infraestructura y mobiliario</span></a></li>
            </ul>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <a href="" class="abrir_modal_add_orden" data-toggle="modal" data-target="#modal_add_orden"></a>
            <a style="display: none;" href="" class="abrir_modal_timeline" data-toggle="modal" data-target="#modal_timeline_orden"></a>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Origen</label>
                  <select class="form-control select2 subproceso_id" style="width: 100%;">
                    <option value="0">--------</option>
                    <option value="1">Equipos biomedicos</option>
                    <option value="2">Equipos industriales</option>
                    <option value="3">Infraestructura y mobiliario</option>
                  </select>
                </div>
              </div>
            </div>
            <table class="table container-table table-info" id="tblOrdenes">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Descripcion</th>
                  <th>Fecha de creación</th>
                  <th>Estado</th>
                  <th style="width: 20%;"></th>
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
  var id = "<?= session('id'); ?>";
  var controlador = "<?php print_r(session('controlador')); ?>";

  var anio_plan = "<?php print_r(session('anio_plan')); ?>";

  var insertar_area = "<?php print_r(session('acciones')[18]->insertar); ?>"; //areas
  var editar_area = "<?php print_r(session('acciones')[18]->editar); ?>"; //areas
  var eliminar_area = "<?php print_r(session('acciones')[18]->eliminar); ?>"; //areas
</script>