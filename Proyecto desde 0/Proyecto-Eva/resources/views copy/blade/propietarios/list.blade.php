<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h3>Owners</h3> <small>List</small>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body">

        <hr>
        @if (!empty($propietarios))

          <div class="row">
            <div class="col-sm-10">

              <div class="table-responsive">
                <div class="custom-row">
                  <a href="" class="custom-btn-figure" data-toggle="modal" data-target="#modal_add_propietario">
                    <li class="fa fa-plus"></li>
                  </a>
                </div>

                <table class="table table-hover table-bordered table-condensed datatable-general tabla-propietarios">
                  <thead>
                    <tr>
                      <th>Nombre del propietario</th>
                      <th>Logo</th>
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
    @endif
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url = "{{ url('/') }}";
  var controlador = "{{ session('controlador') }}";
  var insertar_propietario = "{{ session('acciones')[22]->insertar }}"; //soportes compra
</script>
