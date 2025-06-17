<div class="modal fade" id="modal_show_usuario" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <h4 class="modal-title" id="usuarioModalLabel">Información detallada del usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered table-hover">
          <tbody>
            <tr>
              <th>Nombre</th>
              <td>{{ $usuario->nombre ?? '' }}</td>
            </tr>
            <tr>
              <th>Apellidos</th>
              <td>{{ $usuario->apellido ?? '' }}</td>
            </tr>
            <tr>
              <th>Teléfono</th>
              <td>{{ $usuario->telefono ?? '' }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $usuario->email ?? '' }}</td>
            </tr>
            <tr>
              <th>Usuario</th>
              <td>{{ $usuario->username ?? '' }}</td>
            </tr>
            <tr>
              <th>Rol</th>
              <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
            </tr>
            <tr>
              <th>Centro de Costo</th>
              <td>{{ $usuario->centroCosto->nombre ?? 'No asignado' }}</td>
            </tr>
            <tr>
              <th>Empresa</th>
              <td>{{ $usuario->empresa->nombre ?? 'No asignada' }}</td>
            </tr>
            <tr>
              <th>Estado</th>
              <td>
                @if($usuario->estado == 1)
                  <span class="label label-success">Activo</span>
                @else
                  <span class="label label-danger">Inactivo</span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Fecha de Registro</th>
              <td>{{ $usuario->created_at->format('d/m/Y H:i') ?? '' }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
