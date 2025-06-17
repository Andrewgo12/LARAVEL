<div class="content-wrapper">
  <section class="content-header">
    <h3>Services</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        {{-- Asumiendo que $acciones se pasa a la vista. Si no, usa @foreach(session('acciones') as $accion) --}}
        @foreach($acciones as $accion)
          @if($accion->modulo == "servicios")
            @if($accion->insertar == 1)
              <div class="custom-row">
                <button class="custom-btn-figure" onclick="(new serviceObj).OpenModalInsert(event)" data-toggle="modal" data-target="#modal_add_servicio" type="button">
                  <li class="fa fa-plus"></li>
                </button>
              </div>
              <br>
            @endif
          @endif
        @endforeach
        <table class="tblServicios table table-info container-table" id="tblServicios" name="tblServicios">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Zona</th>
              <th>Centro de costo</th>
              <th>Sede</th>
              <th>Equipos asociados</th>
              <th>Areas asociadas</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "{{ asset('') }}"; // Corregido para usar sintaxis Blade
  var controlador = "{{ session('controlador') }}"; // Corregido para usar sintaxis Blade
  var eliminar_servicio = "{{ session('acciones')[2]->eliminar }}"; // Corregido para usar sintaxis Blade
  var editar_servicio = "{{ session('acciones')[2]->editar }}"; // Corregido para usar sintaxis Blade
</script>
