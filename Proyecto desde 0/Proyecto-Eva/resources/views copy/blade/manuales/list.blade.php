<div class="content-wrapper">
  <section class="content-header">
    <h3>Manuales</h3> <small>Listado</small>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          @if (!empty($manuales))
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <div class="custom-row">
                    <button data-toggle="modal" data-target="#modal_add_manual" type="button" class="custom-btn-figure">
                      <i class="fa fa-plus"></i>
                    </button>
                  </div>
                  <br>
                  <table id="tabla-manuales" class="table tabla-manuales table-info container-table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Descripción</th>
                        <th>URL</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Los datos se cargan dinámicamente mediante JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          @else
            <div class="alert alert-info text-center">
              <h4><i class="icon fa fa-info"></i> No existen registros</h4>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
</div>
<!-- /.content-wrapper -->
<script>
  var base_url = "{{ url('/') }}/";
  var controlador = "{{ session('controlador') }}";
</script>
