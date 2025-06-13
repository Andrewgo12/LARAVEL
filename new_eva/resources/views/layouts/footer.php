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
<script src="<?php echo base_url(); ?>assets/template/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/template/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/dist/js/demo.js"></script>
<script src="<?php echo base_url(); ?>assets/template/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/datatables.net/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/datatables.net/js/fnSetFilteringDelay.js"></script>
<script src="<?php echo base_url(); ?>assets/template/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/bootstrap/js/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/jquery-print/jquery.print.js"></script>
<script src="<?php echo base_url(); ?>assets/template/bootstrap-file/js/fileinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/bootstrap-file/js/locales/es.js"></script>
<script src="<?php echo base_url(); ?>assets/template/lightbox2-master/dist/js/lightbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/template/jquery.blockUI/jquery.blockUI.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo base_url(); ?>assets/template/summernote/summernote.min.js"></script>
<script src="<?php echo base_url(); ?>plugins_old/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins_old/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins_old/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>plugins_old/input-mask/jquery.inputmask.js"></script>
<script src="<?= base_url(); ?>plugins_old/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= base_url(); ?>plugins_old/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?= base_url(); ?>application/app/components/BaseComponent.js"></script>
<script type="module" src="<?= base_url(); ?>application/app/index.js"></script>
<script>
  //TODO
  globalThis.role = '<?= json_encode($this->session->userdata("rol_id")); ?>';
  window.baseUrl = '<?= base_url(); ?>';
  window.actions =  <?= json_encode($this->session->userdata("acciones")); ?>;
</script>
<script type="module" src="<?= base_url(); ?>application/javascript/main.js"></script>
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
<script src="<?php echo base_url(); ?>js/objects/MedicalDevicesMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/ReportsMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/ManualsMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/PisosMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/AreasMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/ServicesMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/ZonesMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/CentrosMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/SedesMethods.js?n=<?= time(); ?>" ;></script>
<script src="<?php echo base_url(); ?>js/objects/UsersMethods.js?n=<?= time(); ?>" ;></script>

<?php
function print_scripts($js_files)
{
  foreach ($js_files as $script) {
    echo '<script src="' . base_url() . 'js/' . $script . '?n=' . time() . '"></script>';
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
<?php if ($this->uri->segment(2) == 'Cplanes') : ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/Planes.js?n=<?= time(); ?>"></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Ccategorias') : ?>
  <script src="<?php echo base_url(); ?>js/Categorias.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cusuarios') : ?>
  <script src="<?php echo base_url(); ?>js/Usuarios.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Usuarios_server_side.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Acciones.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Zonas.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Empresas.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Modulos.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cpermisos') : ?>
  <script src="<?php echo base_url(); ?>js/Permisos.js?n=<?= time(); ?>" ;>
  </script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cservicios') : ?>
  <script src="<?php echo base_url(); ?>js/Servicios.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Sedes.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Crepuestos') : ?>
  <script src="<?php echo base_url(); ?>js/Repuestos.js?n=<?= time(); ?>" ;>
  </script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cinvimas') : ?>
  <script src="<?php echo base_url(); ?>js/Invimas.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cestadoequipos') : ?>
  <script src="<?php echo base_url(); ?>js/Estadoequipos.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Creportes') : ?>
  <script src="<?php echo base_url(); ?>js/Reportes.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Ccuentas') : ?>
  <script src="<?php echo base_url(); ?>js/Cuentas.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Ccontactos') : ?>
  <script src="<?php echo base_url(); ?>js/Contactos.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(1) == 'Home') : ?>
  <script src="<?php echo base_url(); ?>js/Guias.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cbajas') : ?>
  <script src="<?php echo base_url(); ?>js/bajas.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cordenes_compra') : ?>
  <script src="<?php echo base_url(); ?>js/Ordenes_compra.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Contactos.js?n=<?= time(); ?>" ;></script>
  <script src="<?php echo base_url(); ?>js/Tipos_compra.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Careas') : ?>
  <script src="<?php echo base_url(); ?>js/Areas.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Ccontingencias') : ?>
  <script src="<?php echo base_url(); ?>js/Contingencias.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cguias') : ?>
  <script src="<?php echo base_url(); ?>js/Guias.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Ccapacitaciones') : ?>
  <script src="<?php echo base_url(); ?>js/Capacitaciones.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(1) == 'Ccharts') : ?>
  <script src="<?php echo base_url(); ?>js/Chart.js?n=<?= time(); ?>" ;>
  </script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cpropietarios') : ?>
  <script src="<?php echo base_url(); ?>js/Propietarios.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
<?php if ($this->uri->segment(2) == 'Cmanuales') : ?>
  <script src="<?php echo base_url(); ?>js/Manuales.js?n=<?= time(); ?>" ;></script>
<?php endif ?>
</body>

</html>