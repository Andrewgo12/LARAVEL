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
                    @foreach($guias as $guia)
                      @if($guia->id != 0)
                        <tr>
                          <td>
                            {{ $guia->id }}
                          </td>
                          <td>
                            {{ $guia->name }}
                            <a class="glyphicon glyphicon-paperclip updateCounter" data-id={{ $guia->id }} target=" __blank" href="{{ asset('assets/upload_guias/'.$guia->file) }}">
                            </a>
                          </td>
                          <td>
                            {{ $guia->totalQuery }}
                          </td>
                        </tr>
                      @endif
                    @endforeach
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
          <source src="{{ asset('assets/upload_guias/CUIDADO Y LIMPIEZA.mp4') }}" type="video/mp4">
        </video>
      </div>
      <div class="col-sm-4">
      </div>
    </div>
  </div>
</div>
<script>
  let base_url = "{{ url('/') }}/";
  let controlador = "{{ session('controlador') }}";
  var insertar_guia = "{{ session('acciones')[21]->insertar }}";
  var editar_guia = "{{ session('acciones')[21]->editar }}";
  var eliminar_guia1 = "{{ session('acciones')[21]->eliminar }}";
  var editar_equipo = "{{ session('acciones')[0]->editar }}"; //equipos
</script>
<!-- /.content-wrapper -->
