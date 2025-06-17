    <!-- ./wrapper -->
    <!-- jQuery 3 -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js?n=<?= time(); ?>"></script> -->
    <script src="<?php echo base_url(); ?>assets/template/jquery/jquery.min.js?n=<?= time(); ?>"></script>
    <!-- jQuery UI -->
    <script src="<?php echo base_url(); ?>assets/template/jquery-ui/jquery-ui.min.js?n=<?= time(); ?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(); ?>assets/template/bootstrap/js/bootstrap.min.js?n=<?= time(); ?>"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>assets/template/jquery-slimscroll/jquery.slimscroll.min.js?n=<?= time(); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/template/fastclick/lib/fastclick.js?n=<?= time(); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/template/dist/js/adminlte.min.js?n=<?= time(); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/template/dist/js/demo.js?n=<?= time(); ?>"></script>
    <!-- Datatables  -->
    <script src="<?php echo base_url(); ?>assets/template/datatables.net/js/jquery.dataTables.min.js?n=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables.net/js/dataTables.responsive.min.js?n=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables.net-bs/js/dataTables.bootstrap.min.js?n=<?= time(); ?>"></script>
    <!-- Bootstrap notify-Jgrowl  -->
    <script src="<?php echo base_url(); ?>assets/template/bootstrap/js/bootstrap-notify.min.js?n=<?= time(); ?>"></script>
    <!-- Bootstrap Select 2  -->
    <script src="<?php echo base_url(); ?>assets/template/select2/dist/js/select2.min.js?n=<?= time(); ?>"></script>
    <!-- Jquery-print  -->
    <script src="<?php echo base_url(); ?>assets/template/jquery-print/jquery.print.js?n=<?= time(); ?>"></script>
    <!-- Bootstrap-file  -->
    <script src="<?php echo base_url(); ?>assets/template/bootstrap-file/js/fileinput.min.js?n=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/template/bootstrap-file/js/locales/es.js?n=<?= time(); ?>"></script>
    <!--light box-->
    <script src="<?php echo base_url(); ?>assets/template/lightbox2-master/dist/js/lightbox.min.js?n=<?= time(); ?>"></script>

    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree();
            // $(".select_especial").select2();
            var temporizador_recarga = "";
            var minutos_programados = 5;
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
                'resizeDuration': 500,
                'wrapAround': true
            })
        })
    </script>

    </body>

    </html>