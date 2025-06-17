<div class="modal fade" id="modal_compartir_archivos">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title text-center" style="background-color: #888888;color: white;">EQUIPOS A COMPARTIR</h4>
        </div>
        <form action="" class="form_compartir_archivos" id="form_compartir_archivos" name="form_compartir_archivos" enctype="multipart/form-data" method="post">
        @csrf

        <div class="modal-body impresion">
          Cargando.....
        </div>
        </form>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right close" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>