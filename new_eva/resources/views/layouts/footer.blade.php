<footer class="main-footer mi_footer">
  <div class="pull-right hidden-xs">
    <b>Version</b>4.6
  </div>
  <div class="main-footer-content">
    <strong>Copyright &copy; 2021 <a href="#">EVA gestiona la tecnologia</a>.</strong> Todos los derechos reservados.
  </div>
</footer>
</div>
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush

@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

  //TODO
  globalThis.role = '{{ json_encode(session('rol_id')); }}';
  window.baseUrl = '{{ url('/'); }}';
  window.actions =  {{ json_encode(session('acciones')); }};

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

  $(document).ready(function() {
    FastClick.attach(document.body);
    $('.rango-fechas').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    });
    $('.datemask').inputmask('yyyy-mm-dd', {
      'placeholder': 'yyyy-mm-dd'
    })
    $(".modal .modal-dialog").draggable({
      handle: ".modal-header"
    });
    $('.modal').resizable({
      minHeight: 200,
      minWidth: 200
    });
    $('.sidebar-menu').tree();
    var temporizador_recarga = "";
    var minutos_programados = 10;
    temporizador_recarga = setTimeout(function() {
      location.reload();
    }, 10000 * 6 * minutos_programados); //1000=1min
    $(document).click(function() {
      clearTimeout(temporizador_recarga);
      temporizador_recarga = setTimeout(function() {
        location.reload();
      }, 10000 * 6 * minutos_programados);
    });
    $(document).on("keypress", function() {
      clearTimeout(temporizador_recarga);
      temporizador_recarga = setTimeout(function() {
        location.reload();
      }, 10000 * 6 * minutos_programados);
    });
    lightbox.option({
      'resizeDuration': 100,
      'wrapAround': true
    });
    $(".datatable-general").dataTable({
      "stateSave": true
    });
    $(".datatable-repuesto").dataTable({
      "stateSave": true,
      "dom": 'lpfrti'
    });
    $(".datatable-columna0-desc").dataTable({
      "order": [
        [1, "desc"]
      ],
      "stateSave": true,
      "dom": 'lpfrti'
    });
    $(".file").fileinput({
      language: 'es'
    });
    $(".textarea-personalizado").summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['fontname', ['fontname']],
        ['table', ['table']],
      ],
    });
  });

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush
@push('scripts')
<script>

</script>
@endpush

<?php
function print_scripts($js_files)
{
  foreach ($js_files as $script) {
    echo '@push('scripts')
<script>

</script>
@endpush';
  }
}

$js_files = array();
if ($this->uri->segment(2) === 'Cequipos') {
  $js_files = array(
    'Repuestos_pendientes.js',
    'Empresas.js',
    'Servicios.js',
    'Manuales.js',
    'Equipos.js',
    'Equipos_server_side.js',
    'Correctivos_generales.js',
    'Correctivos_generales_server_side.js',
    'Preventivos.js',
    'Calibraciones.js',
    'Invimas.js',
    'Contactos.js',
    'Ordenes_compra.js',
    'Tipos_compra.js',
    'Bajas.js',
    'Sedes.js',
    'Avances_correctivos.js',
    'Areas.js',
    'Ordenes.js',
    'Especificaciones.js',
    'Archivos.js',
    'Repuestos.js',
    'Funciones_auxiliares.js',
    'Cambios_ubicaciones.js',
    'Ordenes_active_solicitud_cierre.js',
    'Ordenes_active_diagnostico.js',
    'Timeline.js',
    'Contingencias.js',
    'Guias.js',
    'Proveedores_mantenimiento.js',
    'Cambios_hdv.js',
    'Estadoequipos.js',
    'Propietarios.js',
    'Tipos_fallas.js'
  );
}
if ($this->uri->segment(2) === 'Cequipos_ind') {
  $js_files = array(
    'Servicios.js',
    'Repuestos_pendientes.js',
    'Equipos.js',
    'Equipos_server_side.js',
    'Contactos.js',
    'Areas.js',
    'Ordenes.js',
    'Ordenes_compra.js',
    'Archivos.js',
    'Sedes.js',
    'Especificaciones.js',
    'Correctivos_generales.js',
    'Avances_correctivos.js',
    'Preventivos.js',
    'Calibraciones.js',
    'Invimas.js',
    'Repuestos.js',
    'Funciones_auxiliares.js',
    'Cambios_ubicaciones.js',
    'Timeline.js',
    'Contingencias.js',
    'Guias.js',
    'Proveedores_mantenimiento.js',
    'Cambios_hdv.js',
    'Estadoequipos.js',
    'Propietarios.js',
    'Bajas.js',
    'Manuales.js'
  );
}
if (($this->uri->segment(2) === 'Cordenes') and ($this->uri->segment(3) == 'list_active')) {
  $js_files = array(
    'Ordenes_active.js',
    'Empresas.js',
    'Timeline.js',
    'Preventivos.js',
    'Correctivos_generales.js',
    'Equipos.js',
    'Equipos_server_side.js',
    'Ordenes_active_diagnostico.js',
    'Ordenes_active_solicitud_cierre.js',
    'Ordenes_auxiliar.js',
    'Avances_correctivos.js',
    'Calibraciones.js',
    'Especificaciones.js',
    'Contactos.js',
    'Contingencias.js',
    'Cambios_hdv.js',
    'Funciones_auxiliares.js'
  );
}
if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) === 'list_closed')) {
  $js_files = array(
    'Ordenes_closed.js',
    'Empresas.js',
    'Timeline.js',
    'Ordenes_auxiliar.js',
  );
}
if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == '')) {
  $js_files = array(
    'Servicios.js',
    'Areas.js',
    'Sedes.js',
    'Ordenes.js',
    'Equipos_server_side.js',
    'Funciones_auxiliares.js',
    'Empresas.js',
    'Timeline.js',
    'Ordenes_auxiliar.js',
    'Avances_correctivos.js',
  );
}
print_scripts($js_files);

?>
@if($this->uri->segment(2) == 'Cplanes')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Ccategorias')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cusuarios')
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cpermisos')
  @push('scripts')
<script>

  
</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cservicios')
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Crepuestos')
  @push('scripts')
<script>

  
</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cinvimas')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cestadoequipos')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Creportes')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Ccuentas')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Ccontactos')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(1) == 'Home')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cbajas')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cordenes_compra')
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Careas')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Ccontingencias')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cguias')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Ccapacitaciones')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(1) == 'Ccharts')
  @push('scripts')
<script>

  
</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cpropietarios')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
@if($this->uri->segment(2) == 'Cmanuales')
  @push('scripts')
<script>

</script>
@endpush
<?php endif ?>
</body>

</html>