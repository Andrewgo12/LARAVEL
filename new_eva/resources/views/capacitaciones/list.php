<div class="content-wrapper">
  <section class="content-header">
    <h3>Trainings</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#nav-cantidad-capacitaciones">#capacitaciones por mes</a></li>
          <li><a href="#nav-cantidad-equipos-cubiertos">Cobertura de equipos</a></li>
          <li><a href="#nav-informacion-por-registro">Informacion por registro</a></li>
        </ul>
        <div class="tab-content">
          <div id="nav-cantidad-capacitaciones" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-info container-table datatable-columna0-desc">
                  <thead>
                    <tr>
                      <th>Mes</th>
                      <th>Equipo</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($capacitaciones_equipo as $registro) : ?>
                      <tr>
                        <td><?php echo $registro->mes; ?></td>
                        <td><?php echo $registro->equipo; ?></td>
                        <td><?php echo $registro->cantidad; ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-info container-table datatable-columna0-desc">
                  <thead>
                    <tr>
                      <th>Mes</th>
                      <th>Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php foreach ($capacitaciones_mes as $registro) : ?>
                      <tr>
                        <td><?php echo $registro->mes; ?></td>
                        <td><?php echo $registro->cantidad; ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div id="nav-cantidad-equipos-cubiertos" class="tab-pane fade">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table class="table table-info container-table datatable-general" id="tblCapacitaciones">
                  <thead>
                    <tr>
                      <th>Equipo</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Servicio</th>
                      <th>Cantidad cubierta</th>
                      <th>Archivo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($capacitaciones_realizadas as $capacitacion_realizada) : ?>
                      <tr>
                        <td><?php echo $capacitacion_realizada->equipo; ?></td>
                        <td><?php echo $capacitacion_realizada->marca; ?></td>
                        <td><?php echo $capacitacion_realizada->modelo; ?></td>
                        <td><?php echo $capacitacion_realizada->servicio; ?></td>
                        <td><?php echo $capacitacion_realizada->cantidad; ?></td>
                        <td><a target="__blank" class="glyphicon glyphicon-file" href="<?php echo base_url(); ?>/assets/upload_equipo_archivos/<?php echo $capacitacion_realizada->vinculo ?>"></a></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div id="nav-informacion-por-registro" class="tab-pane fade">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table class="table table-info container-table datatable-general" id="tblCapacitaciones2">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Vinculo</th>
                      <th>Fecha de registro</th>
                      <th>Equipo</th>
                      <th>Marca</th>
                      <th>Servicio</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($capacitaciones_archivo as $capacitacion_archivo) : ?>
                      <tr>
                        <td><?php echo $capacitacion_archivo->id; ?></td>
                        <td><a target="__blank" class="glyphicon glyphicon-file" href="<?php echo base_url(); ?>/assets/upload_equipo_archivos/<?php echo $capacitacion_archivo->vinculo ?>"></a></td>
                        <td><?php echo $capacitacion_archivo->fecha_ingreso; ?></td>
                        <td><?php echo $capacitacion_archivo->equipo; ?></td>
                        <td><?php echo $capacitacion_archivo->marca; ?></td>
                        <td><?php echo $capacitacion_archivo->servicio; ?></td>
                      </tr>
                    <?php endforeach ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "<?= base_url(); ?>";
</script>