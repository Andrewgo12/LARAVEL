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
  <!-- @push('scripts')
<script>

</script>
@endpush -->
  <!-- jQuery UI 1.11.4 -->
  <!-- @push('scripts')
<script>

</script>
@endpush -->
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  @push('scripts')
<script>

    // $.widget.bridge('uibutton', $.ui.button)
  
</script>
@endpush
  <!-- jQuery -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Bootstrap 4 -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Select2 -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Bootstrap4 Duallistbox -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- InputMask -->
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  <!-- date-range-picker -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Datatables -->
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

  <!-- daterangepicker -->
  @push('scripts')
<script>

</script>
@endpush
  @push('scripts')
<script>

</script>
@endpush
  <!-- bootstrap color picker -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Tempusdominus Bootstrap 4 -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Bootstrap Switch -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- BS-Stepper -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- dropzonejs -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Summernote -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- overlayScrollbars -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- AdminLTE App -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- AdminLTE for demo purposes -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Delay -->
  @push('scripts')
<script>

</script>
@endpush
  <!--Block Ui-->
  @push('scripts')
<script>

</script>
@endpush
  <!--light box-->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Jquery-print  -->
  @push('scripts')
<script>

</script>
@endpush
  <!-- Bootstrap-file  -->
  @push('scripts')
<script>

</script>
@endpush

  @push('scripts')
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
@endpush

  @if($this->uri->segment(2) == 'Cequipos')
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
    <!-- @push('scripts')
<script>

</script>
@endpush -->
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
  <?php endif ?>
  @if($this->uri->segment(2) == 'Cequipos_ind')
    <!-- @push('scripts')
<script>

</script>
@endpush -->
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
  <?php endif ?>
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
  @if(($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == ''))
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
  <?php endif ?>
  @if(($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == 'list_active'))
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
  <?php endif ?>
  @if(($this->uri->segment(2) == 'Cordenes') and ($this->uri->segment(3) == 'list_closed'))
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