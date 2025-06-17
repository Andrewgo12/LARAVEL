<div class="content-wrapper">
  <section class="content-header">
    <h3>Manuals</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <?php if (!empty($manuales)) : ?>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <div class="custom-row">
                    <button data-toggle="modal" data-target="#modal_add_manual" type="button" class="custom-btn-figure">
                      <li class="fa fa-plus"></li>
                    </button>
                  </div>
                  <br>
                  <table id="tabla-manuales" class="table tabla-manuales table-info container-table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Descripcion</th>
                        <th>url</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php else : ?>
            <span style="font-size: 50px;">No existen registros!</span>
          <?php endif ?>

        </div>
      </div>
    </div>
  </section>




</div>
<!-- /.content-wrapper -->
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php echo $this->session->userdata('controlador'); ?>";
</script>