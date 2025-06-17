<div id="modal_archivo_solicitud_cierre_orden" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 60%;">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informe técnico de cierre</h4>
      </div>

      {{-- Cuerpo del modal --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Adjuntar informe</h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- Formulario --}}
                <form action="{{ url('orden/Cordenes/update_solicitar_cierre_orden') }}"
                      id="form_solicitar_cierre_orden"
                      name="form_solicitar_cierre_orden"
                      method="POST"
                      enctype="multipart/form-data">

                  @csrf

                  {{-- ID oculto --}}
                  <input type="hidden" name="id" id="id" class="id">

                  {{-- Archivo --}}
                  <div class="form-group">
                    <label for="file_cierre" class="col-sm-2 control-label badge">Archivo</label>
                    <div class="col-sm-10">
                      <input type="file"
                             class="form-control file"
                             name="file_cierre"
                             id="file_cierre"
                             required
                             data-browse-on-zone-click="true"
                             accept=".pdf,.doc,.docx,.xlsx,.png,.jpg,.jpeg">
                    </div>
                  </div>

                  {{-- Botón --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_update">Actualizar</button>
                    <div id="mensaje" class="mt-2 text-success"></div>
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
