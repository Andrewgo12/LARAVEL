<div id="modal_add_solicitud_cierre_from_timeline" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      {{-- Header del modal --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar</h4>
      </div>

      {{-- Cuerpo del modal --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Trabajo realizado</h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- Formulario --}}
                <form action="{{ url('orden/Cordenes/add_solicitud_cierre') }}" id="form_add_solicitud_cierre_orden"
                      name="form_add_solicitud_cierre_orden" method="POST" enctype="multipart/form-data">
                  @csrf

                  {{-- Código del retro --}}
                  <div class="form-group row">
                    <label for="retro_cierre" class="col-md-2 control-label">Código del retro de cierre</label>
                    <div class="col-md-10">
                      <input required type="text" name="retro_cierre" id="retro_cierre" class="form-control" placeholder="Código">
                    </div>
                  </div>

                  {{-- Descripción del trabajo --}}
                  <div class="form-group row">
                    <label for="reparacion" class="col-md-2 control-label">Descripción del trabajo realizado</label>
                    <div class="col-md-10">
                      <textarea required class="form-control" name="reparacion" id="reparacion" rows="5" placeholder="Ingrese la información del trabajo realizado"></textarea>
                    </div>
                  </div>

                  {{-- Condicional para roles administrativos --}}
                  @if(session('rol_id') <= 2)
                  <div class="form-group row">
                    <label class="col-md-3 control-label">Fecha del procedimiento correctivo</label>
                    <div class="col-md-9">
                      <input type="date" name="fecha_asignacion_cierre" id="fecha_asignacion_cierre" class="form-control mb-1">
                      <input type="time" name="hora_asignacion_cierre" id="hora_asignacion_cierre" class="form-control">
                      <small class="text-info">Si el campo fecha no se diligencia se guardará con la fecha actual</small>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tecnico_cierre_text" class="col-md-2 control-label">
                      Técnico que realiza procedimiento correctivo
                      <span class="glyphicon glyphicon-flag" style="color: #d6671d;" title="Si no se llena, esta cuenta quedará como quien realiza el procedimiento correctivo"></span>
                    </label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" name="tecnico_cierre_text" id="tecnico_cierre_text" placeholder="Nombre y apellido">
                      <small class="text-info">Si no se diligencia, se asignará a esta cuenta como quien realiza el procedimiento correctivo</small>
                    </div>
                  </div>
                  @endif

                  {{-- Archivo asociado --}}
                  <div class="panel panel-default">
                    <div class="panel-heading">Archivo asociado</div>
                    <div class="panel-body">
                      <div class="form-group row">
                        <div class="col-md-12">
                          <label for="file_cierre" class="badge">Archivo asociado</label>
                          <input type="file" class="form-control file" id="file_cierre" name="file_cierre" data-browse-on-zone-click="true">
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- Botón --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_add_solicitud_cierre_from_timeline">Ingresar</button>
                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Footer del modal --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
