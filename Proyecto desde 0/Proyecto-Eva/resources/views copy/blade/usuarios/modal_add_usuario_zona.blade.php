<div id="modal_add_usuario_zona" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Usuario a Zona</h4>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Asignación Usuario - Zona</h3>
              </div>

              <div class="box-body form-horizontal">
                <form action="{{ route('usuario_zona.store') }}" method="POST" enctype="multipart/form-data" id="form_usuario_zona" name="form_usuario_zona">
                  @csrf
                  <br>
                  <ul class="list-inline">
                    <li class="list-inline-item">
                      <label for="zona_id">Zona</label>
                      <select name="zona_id" id="zona_id" class="form-control zona_id" required>
                        <option value="">----Seleccione----</option>
                        @foreach($zonas as $zona)
                          <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                        @endforeach
                      </select>
                    </li>
                    <li class="list-inline-item">
                      <label for="usuario_id">Usuario</label>
                      <select name="usuario_id" id="usuario_id" class="form-control usuario_id" required>
                        <option value="">----Seleccione----</option>
                        @foreach($usuarios as $usuario)
                          <option value="{{ $usuario->id }}">{{ $usuario->nombre }} {{ $usuario->apellido }}</option>
                        @endforeach
                      </select>
                    </li>
                  </ul>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-add-usuario-zona">Ingresar</button>
                  </div>
                </form>
              </div>
              <br>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
