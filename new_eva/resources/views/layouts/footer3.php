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
  <!-- <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script> -->
  <!-- jQuery UI 1.11.4 -->
  <!-- <script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script> -->
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    // $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url(); ?>plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Datatables -->
  <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- daterangepicker -->
  <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="<?php echo base_url(); ?>plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="<?php echo base_url(); ?>plugins/dropzone/min/dropzone.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
  <!-- Delay -->
  <script src="<?php echo base_url(); ?>plugins/datatables/fnSetFilteringDelay.js"></script>
  <!--Block Ui-->
  <script src="<?php echo base_url(); ?>plugins/jquery.blockUI/jquery.blockUI.js"></script>
  <!--light box-->
  <script src="<?php echo base_url(); ?>plugins/lightbox2-master/dist/js/lightbox.min.js"></script>
  <!-- Jquery-print  -->
  <script src="<?php echo base_url(); ?>plugins/jquery-print/jquery.print.js"></script>
  <!-- Bootstrap-file  -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-file/js/fileinput.min.js"></script>

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
    <script src="<?php echo base_url(); ?>js/Equipos_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Equipos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Equipos.js?n=<?= time(); ?>" ;></script>
    <!-- <script src="<?php echo base_url(); ?>js/Equipos_server_side.js?n=<?= time(); ?>";></script> -->
    <script src="<?php echo base_url(); ?>js/Correctivos_generales.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Correctivos_generales_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Preventivos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Calibraciones.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Invimas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Contactos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_compra.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Tipos_compra.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Bajas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Sedes.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Avances_correctivos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Areas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Especificaciones.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Archivos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Repuestos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Cambios_ubicaciones.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_active_solicitud_cierre.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_active_diagnostico.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Contingencias.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Guias.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Proveedores_mantenimiento.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Cambios_hdv.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Estadoequipos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Propietarios.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Manuales.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cequipos_ind') : ?>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/equipos_ind.js?n=<?= time(); ?>" ></script> -->
    <script src="<?php echo base_url(); ?>js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Equipos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Equipos_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Contactos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Areas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Sedes.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Especificaciones.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Correctivos_generales.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Preventivos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Calibraciones.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Invimas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Repuestos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Cambios_ubicaciones.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Contingencias.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Guias.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Cambios_hdv.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Estadoequipos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Propietarios.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Bajas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Manuales.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Cplanes') : ?>

    <script type="text/javascript" src="<?php echo base_url(); ?>js/Planes.js?n=<?= time(); ?>"></script>
  <?php endif ?>
  <?php if ($this->uri->segment(2) == 'Ccategorias') : ?>
    <script src="<?php echo base_url(); ?>js/Categorias.js?n=<?= time(); ?>" ;>

    </script>
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
  <?php if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == '')) : ?>
    <script src="<?php echo base_url(); ?>js/Servicios.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Areas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Sedes.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Equipos_server_side.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_auxiliar.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Avances_correctivos.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == 'list_active')) : ?>
    <script src="<?php echo base_url(); ?>js/Ordenes_active.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_active_diagnostico.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_active_solicitud_cierre.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_auxiliar.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Avances_correctivos.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Funciones_auxiliares.js?n=<?= time(); ?>" ;></script>
  <?php endif ?>
  <?php if (($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == 'list_closed')) : ?>
    <script src="<?php echo base_url(); ?>js/Ordenes_closed.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Empresas.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Timeline.js?n=<?= time(); ?>" ;></script>
    <script src="<?php echo base_url(); ?>js/Ordenes_auxiliar.js?n=<?= time(); ?>" ;></script>
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
    <script src="<?php echo base_url(); ?>js/Servicios.js?n=<?= time(); ?>" ;></script>
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