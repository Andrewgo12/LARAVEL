<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <title>EVA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @if ($this->uri->segment(1) == 'Dashboard')
    <link rel="stylesheet" href="{{ base_url() }}css/css_error.css?v={{ time() }}">
  @endif

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/template/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/template/font-awesome/css/font-awesome.min.css') }}">

  <!-- Own -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="shortcut icon" href="/css/icons/favicon.svg" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/aside.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/template/dist/css/AdminLTE.min.css') }}?v={{ time() }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins_old/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('plugins_old/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ asset('plugins_old/timepicker/bootstrap-timepicker.min.css') }}">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="{{ asset('assets/template/dist/css/skins/_all-skins.min.css') }}">
  <!-- Datatale -->
  <link rel="stylesheet" href="{{ asset('assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

  <!-- Bootstrap file -->
  <link rel="stylesheet" href="{{ asset('assets/template/bootstrap-file/css/fileinput.min.css') }}">
  <!-- Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets/template/lightbox2-master/dist/css/lightbox.min.css') }}">
  <!-- Carousel -->
  <link rel="stylesheet" href="{{ asset('assets/template/Carousel/Carousel-Hero.css') }}">
  <!-- Hoja de vida -->
  <link rel="stylesheet" href="{{ asset('css/hoja_de_vida/Hoja_de_vida.css') }}">
  <!-- Summernote -->
  <link rel="stylesheet" href="{{ asset('assets/template/summernote/summernote.min.css') }}">

  @if ($this->uri->segment(1) == 'Home')
    <link rel="stylesheet" href="/css/landing_page/header.css">
  @endif

  @if ($this->uri->segment(2) == 'Cinvimas')
    <link rel="stylesheet" href="{{ asset('css/invimas/Invimas.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(2) == 'Cordenes_compra')
    <link rel="stylesheet" href="{{ asset('css/ordenes_compra/Ordenes_compra.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(2) == 'Cusuarios')
    <link rel="stylesheet" href="{{ asset('css/usuarios/Usuarios.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(2) == 'Cordenes')
    <link rel="stylesheet" href="{{ asset('css/tickets/Tickets.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(2) == 'Cequipos')
    <link rel="stylesheet" href="{{ asset('css/tickets/Tickets.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/equipos/Equipos.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(2) == 'Cequipos_ind')
    <link rel="stylesheet" href="{{ asset('css/tickets/Tickets.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/equipos/Equipos.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(2) == 'Crepuestos')
    <link rel="stylesheet" href="{{ asset('css/repuestos/Repuestos.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(1) == 'Forbidden')
    <link rel="stylesheet" href="{{ asset('css/Forbidden.css') }}?v={{ time() }}">
  @endif

  @if ($this->uri->segment(1) == 'guia')
    <link rel="stylesheet" href="{{ asset('css/guias/Guias.css') }}?v={{ time() }}">
  @endif

  <link rel="stylesheet" href="{{ asset('css/propio.css') }}?v={{ time() }}">
</head>

<body class="hold-transition skin-black sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>E</b>VA</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>EVA APLICATIVO</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user hidden-xs">{{ session('nombre') }}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ url('administrador/Ccuentas') }}" class="btn btn-default btn-flat">Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ base_url() }}Cauth/logout" class="btn btn-default btn-flat">Salir</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
