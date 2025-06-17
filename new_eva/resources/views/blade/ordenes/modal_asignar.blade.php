<div id="modal_asignar_orden" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar Orden</h4>
      </div>

      {{-- Cuerpo --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Asignar Empresa Responsable</h3>
              </div>

              <div class="box-body form-horizontal">
                <form action="{{ url('orden/Cordenes/update') }}"
                      id="form_asignacion"
                      name="form_asignacion"
                      method="POST"
                      enctype="multipart/form-data">
                  @csrf

                  {{-- ID oculto --}}
                  <input type="hidden" id="id" name="id">

                  {{-- Selector de empresa --}}
                  <div class="form-group">
                    <label for="empresa_id" class="col-sm-3 control-label">Empresa</label>
                    <div class="col-sm-9">
                      <select name="empresa_id"
                              id="empresa_id"
                              class="form-control empresa_id"
                              required>
                        <option value="">-- Seleccione Empresa --</option>
                        {{-- Opciones se cargan desde el controlador o JS --}}
                      </select>
                    </div>
                  </div>

                  {{-- Botón --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_asignar_orden">Asignar</button>
                  </div>

                </form>
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
