<div class="content-wrapper">
  <section class="content-header">
    <h3>States</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 table-responsive">
            <table class="table table-info container-table" id="tblEstadoequipos">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Estado</th>
                  <th>Tipo de estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 table-responsive editarServicio">
            <form action="{{ asset('') }}ubicacion/Cestadoequipos/update" id="form_estadoequipo" name="form_estadoequipo" enctype="multipart/form-data" method="post">
              @csrf
              <input type="hidden" id="id" name="id" class="form-control">
              <br>
              <div class="row">
                <div class="col-sm-3">
                  <label for="name" class="">Nombre:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Nombre del estado" name="name" id="name">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3">
                  <label for="tipoestado_id" class="">Tipo de estado:</label>
                </div>
                <div class="col-sm-9">
                  <select name="tipoestado_id" id="tipoestado_id" class="form-control tipoestado_id"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3">
                  <label for="color" class="">Color:</label>
                </div>
                <div class="col-sm-9">
                  <input type="color" id="color" name="color" class="color">
                </div>
              </div>
              <br>
              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="btn_update_estado_equipo" onclick="aplicar_condicion(1)" disabled="">Actualizar</button>
                <button type="button" class="btn btn-info" id="btn_add_estado_equipo" onclick="aplicar_condicion(2)"><i class="fa fa-plus"></i> Agregar</button>
              </div>
              <div class="errores"></div>
              <input type="hidden" id="condicion">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php echo session('controlador'); ?>";
</script>


