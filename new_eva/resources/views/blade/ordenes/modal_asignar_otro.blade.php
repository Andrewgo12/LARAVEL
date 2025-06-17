<div id="modal_asignar_orden_otro" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      {{-- Encabezado del modal --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Asignar orden de trabajo</h4>
      </div>

      {{-- Cuerpo del modal --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Asignación de responsabilidad</h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- Formulario --}}
                <form action="{{ url('orden/Cordenes/update') }}"
                      id="form_asignacion_otro"
                      name="form_asignacion_otro"
                      method="POST"
                      enctype="multipart/form-data">
                  @csrf

                  {{-- ID oculto --}}
                  <input type="hidden" id="id" name="id">

                  <div class="row">
                    {{-- Tipo de trabajo --}}
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="trabajo_id">Tipo de arreglo</label>
                        <select name="trabajo_id"
                                id="trabajo_id"
                                class="form-control trabajo_id"
                                onchange="seleccionar_tecnicos()"
                                required>
                          {{-- Opciones se cargan dinámicamente --}}
                        </select>
                      </div>
                    </div>

                    {{-- Técnico responsable --}}
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="tecnico_id">Responsable técnico</label>
                        <div class="contenedor_hijo_asignacion">
                          <select name="tecnico_id"
                                  id="tecnico_id"
                                  class="form-control tecnico_id"
                                  required>
                            {{-- Opciones se cargan dinámicamente --}}
                          </select>
                        </div>
                      </div>
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

      {{-- Pie del modal --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
