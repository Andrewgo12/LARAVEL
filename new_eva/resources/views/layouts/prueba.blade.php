<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<link rel="stylesheet" href="{{ url('/') }}css/login/login.css?n={{ time(); }}">

<!------ Include the above in your HEAD tag ---------->

<div class="container">

  <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">

    <div class="row">
      <div class="iconmelon">
        <svg viewBox="0 0 32 32">
          <g filter="">
            <use xlink:href="#git"></use>
          </g>
        </svg>
      </div>
      <img class="img-responsive" src="{{ url('/'); }}assets/template/6.jpg?n={{ time(); }}" alt="">
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panel-title text-center">Login</div>
      </div>

      <div class="panel-body">
        <div class="contenedor-login-eva">
          <form name="form-login" id="form-login" class="form-horizontal" enctype="multipart/form-data" method="POST">

            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input autofocus id="username" type="text" class="form-control" name="username" value="" placeholder="Nombre de usario">
            </div>

            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">
            </div>

            <div class="form-group">
              <!-- Button -->
              <div class="col-sm-12 controls">
                <button type="submit" href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <a href="" data-toggle="modal" data-target="#modal_reg_usuario" type="submit">Crear una cuenta</a>
    </div>
  </div>
</div>

<div id="particles"></div>

@push('scripts')
<script>

  var base_url = "{{ url('/'); }}";

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