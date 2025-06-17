<div id="modal_archivo_diagnose_orden" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 60%;">
    <div class="modal-content">

      {{-- Encabezado del modal --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Archivo de diagnóstico</h4>
      </div>

      {{-- Cuerpo del modal --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Subir archivo</h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- Formulario --}}
                <form action="{{ url('orden/Cordenes/update_diangosticar_orden') }}"
                      id="form_diagnosticar_orden"
                      name="form_diagnosticar_orden"
                      enctype="multipart/form-data"
                      method="POST">

                  @csrf

                  {{-- Campo oculto de ID --}}
                  <input type="hidden" name="id" id="id" class="id">

                  {{-- Selector de archivo --}}
                  <div class="form-group">
                    <label class="col-sm-2 control-label badge" for="file_diagnostico">Archivo diagnóstico</label>
                    <div class="col-sm-10">
                      <input required type="file" class="form-control file"
                             id="file_diagnostico" name="file_diagnostico"
                             data-browse-on-zone-click="true" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                    </div>
                  </div>

                  {{-- Footer del formulario --}}
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
