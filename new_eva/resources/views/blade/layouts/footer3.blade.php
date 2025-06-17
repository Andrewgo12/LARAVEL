  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
  <!-- InputMask -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Datatables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <!-- bootstrap color picker -->
  <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Bootstrap Switch -->
  <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
  <!-- BS-Stepper -->
  <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
  <!-- dropzonejs -->
  <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <!-- Delay -->
  <script src="{{ asset('plugins/datatables/fnSetFilteringDelay.js') }}"></script>
  <!--Block Ui-->
  <script src="{{ asset('plugins/jquery.blockUI/jquery.blockUI.js') }}"></script>
  <!--light box-->
  <script src="{{ asset('plugins/lightbox2-master/dist/js/lightbox.min.js') }}"></script>
  <!-- Jquery-print  -->
  <script src="{{ asset('plugins/jquery-print/jquery.print.js') }}"></script>
  <!-- Bootstrap-file  -->
  <script src="{{ asset('plugins/bootstrap-file/js/fileinput.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
      });

      lightbox.option({
        'resizeDuration': 100,
        'wrapAround': true
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

  @if(request()->segment(2) == 'Cequipos')
    <script src="{{ asset('js/Equipos_server_side.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Equipos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Empresas.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Servicios.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Correctivos_generales.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Correctivos_generales_server_side.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Preventivos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Calibraciones.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Invimas.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Contactos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Ordenes_compra.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Tipos_compra.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Bajas.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Sedes.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Avances_correctivos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Areas.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Ordenes.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Especificaciones.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Archivos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Repuestos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Funciones_auxiliares.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Cambios_ubicaciones.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Ordenes_active_solicitud_cierre.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Ordenes_active_diagnostico.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Timeline.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Contingencias.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Guias.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Proveedores_mantenimiento.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Cambios_hdv.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Estadoequipos.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Propietarios.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Manuales.js') }}?v={{ time() }}"></script>
  @endif

  <!-- Más condicionales para cargar scripts específicos según la ruta -->
  @if(request()->segment(2) == 'Cequipos_ind')
    <script src="{{ asset('js/Servicios.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/Equipos.js') }}?v={{ time() }}"></script>
    <!-- Más scripts específicos... -->
  @endif

  </body>
  </html>
