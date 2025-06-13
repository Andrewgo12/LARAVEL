<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="container eva-container">
    <div class="row header-row">
      <div class="col-md-12">
        <h1 class="eva-title">EVA GESTIONA LA TECNOLOGIA</h1>
      </div>
      <div id='guides'></div>
      <div class="col-md-12 container-icon-title">
        <div class="icon-button"></div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-6">
        <div class="alert container-home-body">
          <div class="icon-book"></div>
          <div> CONSULTA AQUI! Guias rapidas equipos biomedicos</div>
        </div>
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" href="#collapse1">Guias rapidas equipos biomedicos</a>
              </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
              <div class="panel-body">
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                <table class="table tabla_guias">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($guias as $guia) : ?>
                      <?php if ($guia->id != 0) :  ?>
                        <tr>
                          <td>
                            <?php echo $guia->id; ?>
                          </td>
                          <td>
                            <?php echo $guia->name; ?>
                            <a class="glyphicon glyphicon-paperclip updateCounter" data-id=<?php echo $guia->id;  ?> target=" __blank" href="<?php echo base_url() . 'assets/upload_guias/' . $guia->file; ?>">
                            </a>
                          </td>
                          <td>
                            <?php echo $guia->totalQuery; ?>
                          </td>
                        </tr>
                      <?php endif ?>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <div class="panel-footer"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <video width="100%" controls autoplay>
          <source src="<?php echo base_url() . 'assets/upload_guias/'; ?>CUIDADO Y LIMPIEZA.mp4" type="video/mp4">
        </video>
      </div>
      <div class="col-sm-4">
      </div>
    </div>
  </div>
</div>
<script>
  let base_url = "<?= base_url(); ?>";
  let controlador = "<?php echo $this->session->userdata('controlador'); ?>";
  var insertar_guia = "<?php print_r($this->session->userdata('acciones')[21]->insertar); ?>";
  var editar_guia = "<?php print_r($this->session->userdata('acciones')[21]->editar); ?>";
  var eliminar_guia1 = "<?php print_r($this->session->userdata('acciones')[21]->eliminar); ?>";
  var editar_equipo = "<?php print_r($this->session->userdata('acciones')[0]->editar); ?>"; //equipos
</script>
<!-- /.content-wrapper -->