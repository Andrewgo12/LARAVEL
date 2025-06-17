<div class="content-wrapper">
  <section class="content-header">
    <h3>Invimas</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <hr>
        <?php if (!empty($invimas)) : ?>
          <div class="row">
            <div class="col-sm-10">
              <div class="table-responsive">
                <div class="custom-row">
                  <a href="" class="custom-btn-figure" data-toggle="modal" data-target="#modal_add_invima">
                    <li class="fa fa-plus"></li>
                  </a>
                </div>

                <table class="table container-table table-info datatable-general tabla_invimas">
                  <thead>
                    <tr>
                      <th>Registro sanitario</th>
                      <th>Descripcion</th>
                      <th>Titulo</th>
                      <th>Marcas</th>
                      <th>Archivo</th>
                      <th>Estado</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
      </div>
    @else
      <span style="font-size: 50px;">No existen registros!</span>
    <?php endif ?>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php echo session('controlador'); ?>";
</script>