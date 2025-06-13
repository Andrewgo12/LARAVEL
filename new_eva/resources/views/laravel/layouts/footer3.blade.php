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
  <!-- <script src="{{ asset('') }}plugins/jquery/jquery.min.js"></script> -->
  <!-- jQuery UI 1.11.4 -->
  <!-- <script src="{{ asset('') }}plugins/jquery-ui/jquery-ui.min.js"></script> -->
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    // $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- jQuery -->
  <script src="{{ asset('') }}plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="{{ asset('') }}plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{ asset('') }}plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="{{ asset('') }}plugins/moment/moment.min.js"></script>
  <script src="{{ asset('') }}plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('') }}plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Datatables -->
  <script src="{{ asset('') }}plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="{{ asset('') }}plugins/jszip/jszip.min.js"></script>
  <script src="{{ asset('') }}plugins/pdfmake/pdfmake.min.js"></script>
  <script src="{{ asset('') }}plugins/pdfmake/vfs_fonts.js"></script>
  <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- daterangepicker -->
  <script src="{{ asset('') }}plugins/moment/moment.min.js"></script>
  <script src="{{ asset('') }}plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="{{ asset('') }}plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('') }}plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="{{ asset('') }}plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="{{ asset('') }}plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="{{ asset('') }}plugins/dropzone/min/dropzone.min.js"></script>
  <!-- Summernote -->
  <script src="{{ asset('') }}plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('') }}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('') }}dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('') }}dist/js/demo.js"></script>
  <!-- Delay -->
  <script src="{{ asset('') }}plugins/datatables/fnSetFilteringDelay.js"></script>
  <!--Block Ui-->
  <script src="{{ asset('') }}plugins/jquery.blockUI/jquery.blockUI.js"></script>
  <!--light box-->
  <script src="{{ asset('') }}plugins/lightbox2-master/dist/js/lightbox.min.js"></script>
  <!-- Jquery-print  -->
  <script src="{{ asset('') }}plugins/jquery-print/jquery.print.js"></script>
  <!-- Bootstrap-file  -->
  <script src="{{ asset('') }}plugins/bootstrap-file/js/fileinput.min.js"></script>

  <script>
    $(document).ready(function() {

      $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
      });
      // $(".modal .modal-dialog").draggable({
      //     handle: ".modal-header"
      // });

      // $('.modal').resizable({
      //      minHeight: 200, // Minimum height of a resizing modal
      //      minWidth: 200 // Minimum width of resizing width
      // });   

      // $('.sidebar-menu').tree();
      // $(".select_especial").select2();
      // var temporizador_recarga="";
      // var minutos_programados=10;
      //     temporizador_recarga= setTimeout(function(){ location.reload(); }, 10000*6*minutos_programados);//1000=1min
      //     $(document).click(function(){
      //       clearTimeout(temporizador_recarga);
      //       temporizador_recarga= setTimeout(function(){ location.reload(); }, 10000*6*minutos_programados);  
      //     });
      //     $(document).on("keypress",function(){
      //       clearTimeout(temporizador_recarga);
      //       temporizador_recarga= setTimeout(function(){ location.reload(); }, 10000*6*minutos_programados);  
      //     });
      lightbox.option({
        'resizeDuration': 100,
        'wrapAround': true
      });
      //     $(".datatable-general").dataTable({
      //       "stateSave":true
      //     });


      //     /*****--------------------*/



      //     $(".datatable-repuesto").dataTable({
      //       "stateSave":true,
      //       "dom": 'lpfrti'
      //     });
      //     $(".datatable-columna0-desc").dataTable({
      //       "order": [[ 1, "desc" ]],         
      //       "stateSave":true,
      //       "dom": 'lpfrti'
      //     });

      //     /*****--------------------*/
      //     // $('[data-toggle="push-menu"]').pushMenu('toggle');

      $(".file").fileinput({
        language: 'es'
      });
      $(".textarea-personalizado").summernote({
        toolbar: [
          // [groupName, [list of button]]
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

  <?php if ($this->uri->segment(2) == 'Cequipos') : ?>
    <script src="{{ asset('') }}js/Equipos_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Equipos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Equipos.js?n=<?= time(); ?>" ;></script>
    <!-- <script src="{{ asset('') }}js/Equipos_server_side.js?n=<?= time(); ?>";></script> -->
    <script src="{{ asset('') }}js/Correctivos_generales.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Correctivos_generales_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Preventivos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Calibraciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Invimas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Contactos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_compra.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Tipos_compra.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Bajas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Sedes.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Avances_correctivos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Areas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Especificaciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Archivos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Repuestos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Cambios_ubicaciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_active_solicitud_cierre.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_active_diagnostico.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Contingencias.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Guias.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Proveedores_mantenimiento.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Cambios_hdv.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Estadoequipos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Propietarios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Manuales.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cequipos_ind') : ?>
    <!-- <script type="text/javascript" src="{{ asset('') }}js/equipos_ind.js?n=<?= time(); ?>" ></script> -->
    <script src="{{ asset('') }}js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Equipos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Equipos_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Contactos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Areas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Sedes.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Especificaciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Correctivos_generales.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Preventivos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Calibraciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Invimas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Repuestos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Cambios_ubicaciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Contingencias.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Guias.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Cambios_hdv.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Estadoequipos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Propietarios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Bajas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Manuales.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cplanes') : ?>

    <script type="text/javascript" src="{{ asset('') }}js/Planes.js?n=<?= time(); ?>"></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Ccategorias') : ?>
    <script src="{{ asset('') }}js/Categorias.js?n=<?= time(); ?>" ;>

    </script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cusuarios') : ?>
    <script src="{{ asset('') }}js/Usuarios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Usuarios_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Acciones.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Zonas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Modulos.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cpermisos') : ?>
    <script src="{{ asset('') }}js/Permisos.js?n=<?= time(); ?>" ;>

    </script>
  <?php endif ?>
  <?php if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == '')) : ?>
    <script src="{{ asset('') }}js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Areas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Sedes.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Equipos_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_auxiliar.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Avances_correctivos.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == 'list_active')) : ?>
    <script src="{{ asset('') }}js/Ordenes_active.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_active_diagnostico.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_active_solicitud_cierre.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_auxiliar.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Avances_correctivos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == 'list_closed')) : ?>
    <script src="{{ asset('') }}js/Ordenes_closed.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Ordenes_auxiliar.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cservicios') : ?>
    <script src="{{ asset('') }}js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Sedes.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Crepuestos') : ?>
    <script src="{{ asset('') }}js/Repuestos.js?n=<?= time(); ?>" ;>

    </script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cinvimas') : ?>

    <script src="{{ asset('') }}js/Invimas.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cestadoequipos') : ?>

    <script src="{{ asset('') }}js/Estadoequipos.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Creportes') : ?>

    <script src="{{ asset('') }}js/Reportes.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Ccuentas') : ?>

    <script src="{{ asset('') }}js/Cuentas.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Ccontactos') : ?>

    <script src="{{ asset('') }}js/Contactos.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(1) == 'Home') : ?>

    <script src="{{ asset('') }}js/Guias.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cbajas') : ?>

    <script src="{{ asset('') }}js/bajas.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cordenes_compra') : ?>
    <script src="{{ asset('') }}js/Ordenes_compra.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Contactos.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Tipos_compra.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Careas') : ?>
    <script src="{{ asset('') }}js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="{{ asset('') }}js/Areas.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Ccontingencias') : ?>

    <script src="{{ asset('') }}js/Contingencias.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cguias') : ?>

    <script src="{{ asset('') }}js/Guias.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Ccapacitaciones') : ?>

    <script src="{{ asset('') }}js/Capacitaciones.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(1) == 'Ccharts') : ?>
    <script src="{{ asset('') }}js/Chart.js?n=<?= time(); ?>" ;>
    </script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cpropietarios') : ?>

    <script src="{{ asset('') }}js/Propietarios.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cmanuales') : ?>

    <script src="{{ asset('') }}js/Manuales.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>

  </body>

  </html>