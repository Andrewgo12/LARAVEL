<div class="modal fade" id="modal_add_archivo_observacion">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title text-center" style="background-color: #888888;color: white;">NUEVO ARCHIVO</h4>
        </div>

        <div class="modal-body impresion">
          <form action="{{ url('equipo/Cequipos/addCalibracion') }}" id="form_archivo_observacion" name="form_archivo_observacion" enctype="multipart/form-data" method="post">
            @csrf
            <br>
            <input type="hidden" name="observacion_id" id="observacion_id">
            <div class="row">
              <div class="col-sm-2">
                <label for="titulo">Titulo</label>
              </div>
              <div class="col-sm-6">
                <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo" >
              </div>
            </div><br>
            <div class="row">
              <div class="col col-sm-12">
                <label for="" class="badge">Archivo asociado</label>
                <input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
              </div>
            </div>
            <div class="box-footer">
              <button class="btn btn-primary" id="btn_add_calibracion">Ingresar</button>
            </div>
          </form>
          <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right close" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>