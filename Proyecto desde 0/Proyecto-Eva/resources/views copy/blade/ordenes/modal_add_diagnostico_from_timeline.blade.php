<div id="modal_add_diagnostico_from_timeline" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      {{-- Header del Modal --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar</h4>
      </div>

      {{-- Cuerpo del Modal --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Diagnóstico</h3>
              </div>

              <div class="box-body form-horizontal">
                <form action="" id="form_add_diagnostico_orden" name="form_add_diagnostico_orden"
                      enctype="multipart/form-data" method="post">
                  @csrf

                  {{-- Código del informe de diagnóstico --}}
                  <div class="row">
                    <div class="col-md-2">
                      <label for="retro_diagnostico">Código del informe de diagnóstico</label>
                    </div>
                    <div class="col-md-10">
                      <input required type="text" name="retro_diagnostico" id="retro_diagnostico"
                             class="form-control" placeholder="Ingrese el código del retro de diagnóstico">
                    </div>
                  </div>

                  {{-- Descripción del diagnóstico --}}
                  <div class="row">
                    <div class="col-md-2">
                      <label for="diagnostico">Descripción del diagnóstico</label>
                    </div>
                    <div class="col-md-10">
                      <textarea required class="form-control" name="diagnostico" id="diagnostico" rows="5"
                                placeholder="Ingrese la información del diagnóstico"></textarea>
                    </div>
                  </div>
                  <br>

                  @if(session('rol_id') <= 2)
                  {{-- Solo visible para rol administrador o técnico con privilegios --}}
                  <div class="row">
                    <div class="col-md-3">
                      Fecha del diagnóstico
                    </div>
                    <div class="col-md-9">
                      <input type="date" name="fecha_diagnostico" id="fecha_diagnostico" class="form-control mb-2">
                      <input type="time" name="hora_diagnostico" id="hora_diagnostico" class="form-control">
                      <span class="text-info small font-weight-bold">
                        Si el campo fecha no se diligencia se guardará con la fecha actual.
                      </span>
                      <br>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-2">
                      <label for="tecnico_diagnostico_text">Quién realiza el diagnóstico</label>
                      <span class="glyphicon glyphicon-flag text-warning" title="Si no se llena, se asignará automáticamente a esta cuenta."></span>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control" name="tecnico_diagnostico_text" id="tecnico_diagnostico_text"
                             placeholder="Nombre y apellido de quien realiza el diagnóstico">
                      <span class="text-info small font-weight-bold">
                        Si no se diligencia, se asignará automáticamente a esta cuenta.
                      </span>
                    </div>
                  </div>
                  <br>

                  {{-- Panel archivo asociado --}}
                  <div class="panel panel-default">
                    <div class="panel-heading">Archivo asociado</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="badge">Archivo asociado</label>
                          <input type="file" class="file" id="file_diagnostico" name="file_diagnostico"
                                 data-browse-on-zone-click="true">
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif

                  {{-- Botón ingresar --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_add_diagnostico_from_timeline">
                      Ingresar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        {{-- Footer del Modal --}}
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
    </div>
  </div>
</div>
