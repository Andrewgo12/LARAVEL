<footer class="main-footer mi_footer">
  <div class="pull-right hidden-xs">
    <b>Version</b>4.6
  </div>
  <div class="main-footer-content">
    <strong>Copyright &copy; 2021 <a href="#">EVA gestiona la tecnologia</a>.</strong> Todos los derechos reservados.
  </div>
</footer>
</div>
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="{{ asset('assets/template/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/template/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/template/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/template/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/template/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('assets/template/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('assets/template/dist/js/demo.js') }}"></script>
<script src="{{ asset('assets/template/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/template/datatables.net/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/template/datatables.net/js/fnSetFilteringDelay.js') }}"></script>
<script src="{{ asset('assets/template/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/template/bootstrap/js/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/template/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/template/jquery-print/jquery.print.js') }}"></script>
<script src="{{ asset('assets/template/bootstrap-file/js/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/template/bootstrap-file/js/locales/es.js') }}"></script>
<script src="{{ asset('assets/template/lightbox2-master/dist/js/lightbox.min.js') }}"></script>
<script src="{{ asset('assets/template/jquery.blockUI/jquery.blockUI.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{ asset('assets/template/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('plugins_old/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('plugins_old/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins_old/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins_old/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins_old/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins_old/input-mask/jquery.inputmask.extensions.js') }}"></script>

<script src="{{ asset('application/app/components/BaseComponent.js') }}"></script>
<script type="module" src="{{ asset('application/app/index.js') }}"></script>
<script>
  //TODO
  globalThis.role = '{{ session('rol_id', '') }}';
  window.baseUrl = '{{ url('/') }}';
  window.actions = @json(session('acciones', []));
</script>
<script type="module" src="{{ asset('application/javascript/main.js') }}"></script>
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
<script src="{{ asset('js/objects/MedicalDevicesMethods.js') }}"></script>
<script src="{{ asset('js/objects/ReportsMethods.js') }}"></script>
<script src="{{ asset('js/objects/ManualsMethods.js') }}"></script>
<script src="{{ asset('js/objects/PisosMethods.js') }}"></script>
<script src="{{ asset('js/objects/AreasMethods.js') }}"></script>
<script src="{{ asset('js/objects/ServicesMethods.js') }}"></script>
<script src="{{ asset('js/objects/ZonesMethods.js') }}"></script>
<script src="{{ asset('js/objects/CentrosMethods.js') }}"></script>
<script src="{{ asset('js/objects/SedesMethods.js') }}"></script>
<script src="{{ asset('js/objects/UsersMethods.js') }}"></script>

@php
$js_files = [];
if (request()->segment(2) === 'Cequipos') {
  $js_files = [
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
  ];
}
if (request()->segment(2) === 'Cequipos_ind') {
  $js_files = [
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
if ((request()->segment(2) === 'Cordenes') and (request()->segment(3) == 'list_active')) {
  $js_files = [
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
  ];
}
if ((request()->segment(2) == 'Cordenes') and (request()->segment(3) === 'list_closed')) {
  $js_files = [
    'Ordenes_closed.js',
    'Empresas.js',
    'Timeline.js',
    'Ordenes_auxiliar.js',
  ];
}
if ((request()->segment(2) == 'Cordenes') and (request()->segment(3) == '')) {
  $js_files = [
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
  ];
}

// Cargar scripts dinámicamente
foreach ($js_files as $script) {
    echo '<script src="' . asset('js/' . $script) . '"></script>';
}
@endphp
@if(request()->segment(2) == 'Cplanes')
  <script type="text/javascript" src="{{ asset('js/Planes.js') }}"></script>
@endif
@if(request()->segment(2) == 'Ccategorias')
  <script src="{{ asset('js/Categorias.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cusuarios')
  <script src="{{ asset('js/Usuarios.js') }}"></script>
  <script src="{{ asset('js/Usuarios_server_side.js') }}"></script>
  <script src="{{ asset('js/Acciones.js') }}"></script>
  <script src="{{ asset('js/Zonas.js') }}"></script>
  <script src="{{ asset('js/Empresas.js') }}"></script>
  <script src="{{ asset('js/Modulos.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cpermisos')
  <script src="{{ asset('js/Permisos.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cservicios')
  <script src="{{ asset('js/Servicios.js') }}"></script>
  <script src="{{ asset('js/Sedes.js') }}"></script>
@endif
@if(request()->segment(2) == 'Crepuestos')
  <script src="{{ asset('js/Repuestos.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cinvimas')
  <script src="{{ asset('js/Invimas.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cestadoequipos')
  <script src="{{ asset('js/Estadoequipos.js') }}"></script>
@endif
@if(request()->segment(2) == 'Creportes')
  <script src="{{ asset('js/Reportes.js') }}"></script>
@endif
@if(request()->segment(2) == 'Ccuentas')
  <script src="{{ asset('js/Cuentas.js') }}"></script>
@endif
@if(request()->segment(2) == 'Ccontactos')
  <script src="{{ asset('js/Contactos.js') }}"></script>
@endif
@if(request()->segment(1) == 'Home')
  <script src="{{ asset('js/Guias.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cbajas')
  <script src="{{ asset('js/bajas.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cordenes_compra')
  <script src="{{ asset('js/Ordenes_compra.js') }}"></script>
  <script src="{{ asset('js/Contactos.js') }}"></script>
  <script src="{{ asset('js/Tipos_compra.js') }}"></script>
@endif
@if(request()->segment(2) == 'Careas')
  <script src="{{ asset('js/Areas.js') }}"></script>
@endif
@if(request()->segment(2) == 'Ccontingencias')
  <script src="{{ asset('js/Contingencias.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cguias')
  <script src="{{ asset('js/Guias.js') }}"></script>
@endif
@if(request()->segment(2) == 'Ccapacitaciones')
  <script src="{{ asset('js/Capacitaciones.js') }}"></script>
@endif
@if(request()->segment(1) == 'Ccharts')
  <script src="{{ asset('js/Chart.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cpropietarios')
  <script src="{{ asset('js/Propietarios.js') }}"></script>
@endif
@if(request()->segment(2) == 'Cmanuales')
  <script src="{{ asset('js/Manuales.js') }}"></script>
@endif
</body>

</html>