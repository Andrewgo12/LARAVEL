<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ElectromedicinaHuv | Ingreso</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login/login.css') }}?v={{ time() }}">
</head>
<body>

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
      <img class="img-responsive" src="{{ asset('assets/template/6.jpg') }}?v={{ time() }}" alt="Logo">
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
              <input autofocus id="username" type="text" class="form-control" name="username" value="" placeholder="Nombre de usuario">
            </div>

            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">
            </div>

            <div class="form-group">
              <div class="col-sm-12 controls">
                <button type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <a href="" data-toggle="modal" data-target="#modal_reg_usuario">Crear una cuenta</a>
    </div>
  </div>
</div>

<div id="particles"></div>

<script>
  var base_url = "{{ url('/') }}/";
</script>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.2.0/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/template/bootstrap/js/bootstrap-notify.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/login.js') }}?v={{ time() }}"></script>
</body>
</html>

