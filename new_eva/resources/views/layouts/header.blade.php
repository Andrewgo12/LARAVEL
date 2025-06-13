<!DOCTYPE html>
<html lang="en">

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
  <!-- Bootstrap 3.3.7 -->
  <!-- <link rel="stylesheet" href="{{ url('/') }}css/normalize.css?n={{ time(); }}"> -->
  @if($this->uri->segment(1) == 'Dashboard')
    <link rel="stylesheet" href="{{ url('/'); }}css/css_error.css?n={{ time(); }}">
  <?php endif ?>
  <link rel="stylesheet" href="{{ url('/') }}assets/template/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/') }}assets/template/font-awesome/css/font-awesome.min.css">

  <!-- Own -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="shortcut icon" href="/css/icons/favicon.svg" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ url('/') }}css/footer.css">


  <link rel="stylesheet" href="{{ url('/') }}css/aside.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/') }}assets/template/dist/css/AdminLTE.min.css?n={{ time(); }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ url('/') }}plugins_old/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ url('/') }}plugins_old/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ url('/') }}plugins_old/timepicker/bootstrap-timepicker.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ url('/') }}assets/template/dist/css/skins/_all-skins.min.css">
  <!-- DatataTable. -->
  <link rel="stylesheet" href="{{ url('/') }}assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Select2. -->
  <!-- <link rel="stylesheet" href="{{ url('/') }}assets/template/select2/dist/css/select2.min.css"> -->

  <!-- Bootstrap file -->
  <link rel="stylesheet" href="{{ url('/') }}assets/template/bootstrap-file/css/fileinput.min.css">
  <!--ligth-box -->
  <link rel="stylesheet" href="{{ url('/') }}assets/template/lightbox2-master/dist/css/lightbox.min.css">
  <!--ligth-box -->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}assets/template/Carousel/Carousel-Hero.css">
  <!--ligth-box -->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/hoja_de_vida/Hoja_de_vida.css">
  <!--Summernote -->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}assets/template/summernote/summernote.min.css">
  @if($this->uri->segment(1) == 'Home')
    <link rel="stylesheet" href="/css/landing_page/header.css">
  <?php endif ?>
  @if($this->uri->segment(2) == 'Cinvimas')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/invimas/Invimas.css?n={{ time(); }}">
  <?php endif ?>

  @if($this->uri->segment(2) == 'Cordenes_compra')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/ordenes_compra/Ordenes_compra.css?n={{ time(); }}">
  <?php endif ?>

  @if($this->uri->segment(2) == 'Cusuarios')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/usuarios/Usuarios.css?n={{ time(); }}">
  <?php endif ?>
  @if($this->uri->segment(2) == 'Cordenes')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/tickets/Tickets.css?n={{ time(); }}">
  <?php endif ?>
  @if($this->uri->segment(2) == 'Cequipos')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/tickets/Tickets.css?n={{ time(); }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/equipos/Equipos.css?n={{ time(); }}">
  <?php endif ?>
  @if($this->uri->segment(2) == 'Cequipos_ind')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/tickets/Tickets.css?n={{ time(); }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/equipos/Equipos.css?n={{ time(); }}">
  <?php endif ?>
  @if($this->uri->segment(2) == 'Crepuestos')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/repuestos/Repuestos.css?n={{ time(); }}">
  <?php endif ?>

  @if($this->uri->segment(1) == 'Forbidden')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/Forbidden.css?n={{ time(); }}">
  <?php endif ?>

  @if($this->uri->segment(1) == 'guia')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}css/guias/Guias.css?n={{ time(); }}">
  <?php endif ?>

  <link rel="stylesheet" href="{{ url('/') }}css/propio.css?n={{ time(); }}">


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
                <span class="glyphicon glyphicon-user hidden-xs">{{ session('nombre'); }}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ url('/') }}administrador/Ccuentas" class="btn btn-default btn-flat">Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ url('/'); }}Cauth/logout" class="btn btn-default btn-flat">Salir</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>