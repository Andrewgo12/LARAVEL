<div class="content-wrapper">
  <section class="content-header">
    <h3>Final disposition</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <div class="custom-row">
                <a href="#" data-toggle="modal" data-target="#modal_add_baja" class="custom-btn-figure">
                  <li class="fa fa-plus"></li>
                </a>
              </div>
              <table class="table table-info container-table tabla-bajas datatable-general">
                <thead>
                  <tr>
                    <th>Fecha baja</th>
                    <th>Descripcion</th>
                    <th>Archivo</th>
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
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php echo $this->session->userdata('controlador'); ?>";
</script>