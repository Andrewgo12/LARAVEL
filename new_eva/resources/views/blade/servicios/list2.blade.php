<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Servicios
      <small>Listado</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 table-responsive">
            <table class="table table-stripped" id="tblServicios">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Pertenencia</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 table-responsive editarServicio">
            <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
            <form action="{{ asset('') }}ubicacion/Cservicios/update" id="form_servicio" name="form_servicio" enctype="multipart/form-data" method="post">
      @csrf
              <input type="hidden" id="id" name="id" class="form-control">
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Nombre.:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="text" class="form-control" placeholder="Nombre del servicio" name="name" id="name">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Piso:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <select required="" name="piso_id" id="piso_id" class="form-control"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Zona:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <select required="" name="zona_id" id="zona_id" class="form-control"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Centro de costo:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <select style="width: 100%;" required="" name="centro_id" id="centro_id" class="form-control select2"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Sede:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <select style="width: 100%;" required="" name="sede_id" id="sede_id" class="form-control select2"></select>
                </div>
              </div>
              <br>
              <div class="box-footer">
                <?php
                $acciones = {{ session('acciones') }};
                foreach ($acciones as $accion) {
                  if ($accion->modulo == "servicios" && $accion->insertar == 1) {  ?>
                    <button class="btn btn-info fa fa-plus btn-flat" id="btn_add_equipo" onclick="aplicar_condicion(2)">Agregar</button>
                  <?php
                  }
                  if ($accion->modulo == "servicios" && $accion->editar == 1) {  ?>
                    <button class="btn btn-primary" id="btn_update_equipo" onclick="aplicar_condicion(1)" disabled="">Actualizar</button>
                <?php
                  }
                }
                ?>
              </div>
              <div class="errores"></div>
              <input type="hidden" id="condicion">
            </form>


          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php print_r({{ session('controlador') }}); ?>";


  var eliminar_servicio = "<?php print_r({{ session('acciones') }}[2]->eliminar); ?>"; //servicios
  var editar_servicio = "<?php print_r({{ session('acciones') }}[2]->editar); ?>"; //servicios
</script>