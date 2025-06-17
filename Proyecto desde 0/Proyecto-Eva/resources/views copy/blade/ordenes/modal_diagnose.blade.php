<div id="modal_diagnose_orden" class="modal fade" role="dialog" aria-labelledby="titulo_modal_diagnostico" aria-hidden="true">
  <div class="modal-dialog" style="width: 60%;">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="titulo_modal_diagnostico">Diagnóstico</h4>
      </div>

      {{-- Cuerpo --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Información de la orden</h3>
              </div>

              <div class="box-body form-horizontal">
                <form action="{{ url('orden/Cordenes/update_diangosticar_orden') }}"
                      id="form_diagnosticar_orden"
                      name="form_diagnosticar_orden"
                      method="POST"
                      enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="id" id="id" class="id">

                  {{-- Datos generales --}}
                  <ul class="list-unstyled">
                    <li><strong>Asunto:</strong> <span class="asunto"></span></li>
                    <li><strong>Descripción:</strong> <span class="descripcion"></span></li>
                    <li><strong>Prioridad:</strong> <span class="prioridad text-uppercase"></span></li>
                  </ul>

                  <div class="contenido_ubicacion mb-2"></div>
                  <div class="contenido_equipo mb-2"></div>

                  {{-- Diagnóstico --}}
                  <div class="form-group">
                    <label for="retro_diagnostico">Retro diagnóstico</label>
                    <input required type="text" class="form-control" id="retro_diagnostico" name="retro_diagnostico" placeholder="Ingrese retro diagnóstico">
                  </div>

                  <div class="form-group">
                    <label for="diagnostico">Diagnóstico</label>
                    <textarea required class="form-control" name="diagnostico" id="diagnostico" rows="4" placeholder="Ingrese el respectivo diagnóstico"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="diagnostico_id">Codificación del diagnóstico</label>
                    <select required class="form-control" name="diagnostico_id" id="diagnostico_id">
                      {{-- Opciones cargadas dinámicamente --}}
                    </select>
                  </div>

                  <div class="form-group contenendor_file" style="display: none;">
                    <label for="file_diagnostico">Archivo de diagnóstico</label>
                    <input disabled type="file" class="file" id="file_diagnostico" name="file_diagnostico" data-browse-on-zone-click="true">
                  </div>

                  {{-- Repuestos --}}
                  <div class="contenido_administrador mb-3"></div>

                  <div class="row control_repuestos mb-2">
                    <div class="col-sm-3">
                      <label>Repuestos necesarios</label>
                    </div>
                    <div class="col-md-5">
                      <span title="Agregar nuevo repuesto" class="glyphicon glyphicon-plus solicitar_repuestos cursor-pointer"></span>
                      &nbsp;
                      <span title="Eliminar todos los repuestos" class="glyphicon glyphicon-erase eliminar_repuestos cursor-pointer"></span>
                    </div>
                  </div>

                  <div class="row control_repuestos">
                    <div class="col-sm-12">
                      <div class="contenedor_repuestos">
                        <table class="table table-bordered table-hover table-sm">
                          <thead>
                            <tr>
                              <th>Repuestos</th>
                            </tr>
                          </thead>
                          <tbody>
                            {{-- Repuestos agregados dinámicamente --}}
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  {{-- Botón de acción --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_update">Actualizar</button>
                    <div id="mensaje" class="mt-3"></div>
                  </div>
                </form>
              </div>
              <br>
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
