<div id="modal_edit_orden_activa" class="modal fade" role="dialog" aria-labelledby="titulo_modal_orden_activa" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="titulo_modal_orden_activa">Orden de trabajo</h4>
      </div>

      {{-- Cuerpo --}}
      <div class="modal-body">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Gestión de orden activa</h3>
          </div>

          <div class="box-body">
            <form action="{{ url('equipo/Cequipos/updateCalibracion') }}"
                  id="form_update_orden_activa"
                  name="form_update_orden_activa"
                  enctype="multipart/form-data"
                  method="POST">
              @csrf

              {{-- Información general --}}
              <div class="row mb-3">
                <div class="col-sm-3">
                  <label><strong>ID orden</strong></label>
                  <p id="id" class="form-control-static"></p>
                </div>
                <div class="col-sm-6">
                  <label><strong>Fecha de creación</strong></label>
                  <p id="fecha_inicio" class="form-control-static"></p>
                </div>
                <div class="col-sm-3">
                  <label><strong>Estado</strong></label>
                  <p id="estado" class="form-control-static"></p>
                </div>
              </div>

              {{-- Descripción --}}
              <div class="mb-3">
                <label><strong>Descripción</strong></label>
                <p id="descripcion" class="form-control-static"></p>
              </div>

              {{-- Reportante --}}
              <div class="row mb-3">
                <div class="col-sm-6">
                  <label><strong>Nombre del reportante</strong></label>
                  <p id="nombre" class="form-control-static"></p>
                </div>
                <div class="col-sm-6">
                  <label><strong>Correo electrónico</strong></label>
                  <p id="email" class="form-control-static"></p>
                </div>
              </div>

              {{-- Servicio --}}
              <div class="mb-3">
                <label><strong>Servicio del reporte</strong></label>
                <p id="servicio" class="form-control-static"></p>
              </div>

              {{-- Diagnóstico --}}
              <div id="bloque_diagnostico" style="display: none;">
                <label><strong>Diagnóstico</strong></label>
                <p id="diagnostico" class="form-control-static"></p>
              </div>

              {{-- Cierre --}}
              <div id="bloque_cierre" class="mb-3">
                <p id="cierre" class="form-control-static"></p>
              </div>

              {{-- Archivo --}}
              <div class="form-group">
                <label class="badge">Archivo asociado</label>
                <input type="file" class="file" id="file" name="file" data-browse-on-zone-click="true">
              </div>

              {{-- Botón --}}
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btn_update_calibracion">Ingresar</button>
              </div>

              {{-- Errores --}}
              <div class="errores mt-3"></div>
            </form>
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
