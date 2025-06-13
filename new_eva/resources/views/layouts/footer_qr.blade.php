    <!-- ./wrapper -->
    <!-- jQuery 3 -->
    <!-- @push('scripts')
<script>

</script>
@endpush -->
    @push('scripts')
<script>

</script>
@endpush
    <!-- jQuery UI -->
    @push('scripts')
<script>

</script>
@endpush
    <!-- Bootstrap 3.3.7 -->
    @push('scripts')
<script>

</script>
@endpush
    <!-- SlimScroll -->
    @push('scripts')
<script>

</script>
@endpush
    <!-- FastClick -->
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
    <!-- Datatables  -->
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
    <!-- Bootstrap notify-Jgrowl  -->
    @push('scripts')
<script>

</script>
@endpush
    <!-- Bootstrap Select 2  -->
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

</script>
@endpush
    <!--light box-->
    @push('scripts')
<script>

</script>
@endpush

    @push('scripts')
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
@endpush

    </body>

    </html>