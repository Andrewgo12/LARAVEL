<div tabindex="-1" role="dialog" class="modal fade" id="modal_show_relacionar_guia">
  <div class="modal-dialog" style="width: 60%;margin: 30px auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="modal-title text-center" style="background-color: #888888;color: white;font-family: 'calibri';font-size: 30px;">
          Relacionar guias rapidas con equipos
        </div>
      </div>
      <div class="modal-body impresion" style="overflow-x: auto;">
        <form action="{{ url('guia/Cguias/relacionar_con_equipos') }}" id="formulario_guia" name="formulario_guia" enctype="multipart/form-data" method="post">
          @csrf
          <input type="hidden" class="id" name="id" id="id">
          <ul class="list-inline">
            <li class="list-inline-item">
              <label for="nombre">NOMBRE DEL EQUIPO</label>
              <input required readonly autocomplete="off" type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre equipo" list="datalistNombreEquipos">
              <datalist id="datalistNombreEquipos" class="datalistNombreEquipos"></datalist>
            </li>
            <li class="list-inline-item">
              <label for="marca">MARCA DEL EQUIPO</label>
              <input autocomplete="off" readonly type="text" class="form-control" id="marca" name="marca" placeholder="Marca equipo" list="datalistMarcaEquipos">
              <datalist id="datalistMarcaEquipos" class="datalistMarcaEquipos"></datalist>
            </li>
            <li class="list-inline-item">
              <label for="modelo">MODELO DEL EQUIPO</label>
              <input autocomplete="off" type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo equipo" list="datalistModeloEquipos">
              <datalist id="datalistModeloEquipos" class="datalistModeloEquipos"></datalist>
            </li>
          </ul>
          <div class="row">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary">RELACIONAR</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <!-- <button onmouseenter="esconder()" onmouseleave="revelar()" type="buton" class="btn btn-primary btn-print"><span class="fa fa-print">Imprimir</span></button> -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </div>
