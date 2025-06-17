<div id="modal_close_orden" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 30%;">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cierre del Ticket</h4>
      </div>

      {{-- Cuerpo del modal --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Informe Técnico</h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- Formulario --}}
                <form action="{{ url('orden/Cordenes/update') }}"
                      id="form_orden"
                      name="form_orden"
                      class="form_orden"
                      method="POST"
                      enctype="multipart/form-data">
                  @csrf

                  {{-- ID oculto --}}
                  <input type="hidden" name="id" id="id">

                  {{-- Datos del informe --}}
                  <div class="form-group">
                    <label for="retro_cierre" class="control-label col-sm-5">Código del informe técnico:</label>
                    <div class="col-sm-7">
                      <input required type="text"
                             class="form-control"
                             name="retro_cierre"
                             id="retro_cierre"
                             placeholder="Ingrese código">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="fecha_retro_cierre" class="control-label col-sm-5">Fecha del reporte:</label>
                    <div class="col-sm-7">
                      <input required type="date"
                             class="form-control"
                             name="fecha_retro_cierre"
                             id="fecha_retro_cierre">
                    </div>
                  </div>

                  {{-- Archivo adjunto --}}
                  <div class="form-group">
                    <label for="file_cierre" class="control-label col-sm-5">Archivo del retro:</label>
                    <div class="col-sm-7">
                      <input type="file"
                             class="file"
                             id="file_cierre"
                             name="file_cierre"
                             data-browse-on-zone-click="true">
                    </div>
                  </div>

                  {{-- Botón de acción --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_edit_orden">Actualizar</button>
                  </div>

                </form>

                {{-- Área de errores --}}
                <span id="errores"></span>

              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Footer --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
