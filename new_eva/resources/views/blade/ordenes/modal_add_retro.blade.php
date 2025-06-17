<div id="modal_add_retro" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      {{-- Modal Header --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar retro</h4>
      </div>

      {{-- Modal Body --}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Actualización de Ticket</h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- Formulario --}}
                <form action="{{ url('orden/Cordenes/add_retro') }}" id="form_retro" name="form_retro"
                      enctype="multipart/form-data" method="POST">
                  @csrf

                  <input type="hidden" name="id" id="id">

                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label for="file_cierre">Archivo del retro</label>
                      <input type="file" id="file_cierre" name="file_cierre" class="form-control" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary">Subir retro</button>
                    </div>
                  </div>
                </form>

                {{-- Mensaje AJAX --}}
                <h1><div id="mensaje"></div></h1>

              </div> {{-- box-body --}}
              <br>

            </div> {{-- box --}}
          </div>
        </div>
      </div>

      {{-- Modal Footer --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
