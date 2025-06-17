
<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
   <meta name="description" content="Sistema de gestión de equipos - Hospital Universitario del Valle">
   <meta name="author" content="HUV">

  <title>HUV | Dashboard</title>

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/morris.js/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- Hoja de vida styles -->
  <style id="Formato hoja de Vida equipos REG-TEC-009_26218_Styles">
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl16226218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl16326218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl16426218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:11.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl16526218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:9.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl16626218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:9.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl16726218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:9.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl16826218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.5pt solid windowtext;
            border-right:none;
            border-bottom:none;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl16926218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.5pt solid windowtext;
            border-right:none;
            border-bottom:none;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl17026218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl17126218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl17226218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:13.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Cambria, serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:1.0pt solid windowtext;
            background:#BFBFBF;
            mso-pattern:black none;
            white-space:normal;}
          .xl17326218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:13.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Cambria, serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:#BFBFBF;
            mso-pattern:black none;
            white-space:normal;}
          .xl17426218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:2.0pt double windowtext;
            border-right:none;
            border-bottom:none;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl17526218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:2.0pt double windowtext;
            border-right:none;
            border-bottom:none;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl17626218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:2.0pt double windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:none;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl17726218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:none;
            border-bottom:none;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl17826218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl17926218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:1.0pt solid windowtext;
            border-bottom:none;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl18026218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl18126218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl18226218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:none;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl18326218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl18426218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl18526218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl18626218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:0;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl18726218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:0;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl18826218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:0;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl18926218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:9.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19026218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:13.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Cambria, serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:#BFBFBF;
            mso-pattern:black none;
            white-space:normal;}
          .xl19126218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:13.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Cambria, serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:2.0pt double windowtext;
            border-left:none;
            background:#BFBFBF;
            mso-pattern:black none;
            white-space:normal;}
          .xl19226218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:2.0pt double windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19326218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:2.0pt double windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19426218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:2.0pt double windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19526218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19626218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19726218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            background:white;
            mso-pattern:black none;
            white-space:normal;}
          .xl19826218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl19926218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:none;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20026218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:left;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:none;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20126218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20226218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:.5pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20326218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:.5pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20426218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:1.0pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20526218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:.5pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
          .xl20626218
            {padding:0px;
            mso-ignore:padding;
            color:black;
            font-size:10.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:center;
            vertical-align:middle;
            border-top:1.0pt solid windowtext;
            border-right:1.0pt solid windowtext;
            border-bottom:1.0pt solid windowtext;
            border-left:.5pt solid windowtext;
            mso-background-source:auto;
            mso-pattern:auto;
            white-space:normal;}
   </style>


<!--reporte de mantenimiento -->
   <link rel=File-List
href="Formato%20de%20reporte%20de%20mantenimiento_files/filelist.xml">
<!--reporte de mantenimiento -->
<style id="Formato de reporte de mantenimiento_28452_Styles">
      <!--table
        {mso-displayed-decimal-separator:"\.";
        mso-displayed-thousand-separator:"\,";}
      .xl6328452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:bottom;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl6428452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:bottom;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl6528452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl6628452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl6728452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:middle;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl6828452
        {padding:0px;
        mso-ignore:padding;
        color:windowtext;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:middle;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl6928452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:7.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:underline;
        text-underline-style:single;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:bottom;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7028452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:general;
        vertical-align:top;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7128452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7228452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7328452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7428452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7528452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7628452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7728452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:top;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7828452
        {padding:0px;
        mso-ignore:padding;
        color:#C00000;
        font-size:11.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl7928452
        {padding:0px;
        mso-ignore:padding;
        color:#C00000;
        font-size:11.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:none;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8028452
        {padding:0px;
        mso-ignore:padding;
        color:#C00000;
        font-size:11.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8128452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8228452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:none;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8328452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:none;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8428452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8528452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:none;
        border-bottom:none;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8628452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8728452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8828452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl8928452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl9028452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl9128452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9228452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9328452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9428452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:none;
        border-left:.5pt solid windowtext;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9528452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:none;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9628452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9728452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:none;
        border-right:none;
        border-bottom:none;
        border-left:.5pt solid windowtext;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9828452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl9928452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:none;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10028452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:none;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10128452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:none;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10228452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:middle;
        border-top:none;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10328452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:7.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:left;
        vertical-align:middle;
        border:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl10428452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:.5pt solid windowtext;
        mso-background-source:auto;
        mso-pattern:auto;
        white-space:nowrap;}
      .xl10528452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:none;
        border-left:.5pt solid windowtext;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10628452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:none;
        border-bottom:none;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10728452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:.5pt solid windowtext;
        border-right:.5pt solid windowtext;
        border-bottom:none;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10828452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:.5pt solid windowtext;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl10928452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:none;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      .xl11028452
        {padding:0px;
        mso-ignore:padding;
        color:black;
        font-size:8.0pt;
        font-weight:700;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        mso-number-format:General;
        text-align:center;
        vertical-align:bottom;
        border-top:none;
        border-right:.5pt solid windowtext;
        border-bottom:.5pt solid windowtext;
        border-left:none;
        background:#D9D9D9;
        mso-pattern:black none;
        white-space:nowrap;}
      -->
</style>
<!--reporte de mantenimiento -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ asset('') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>HUV</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>HUV</b> | Hospital Universitario</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 4 mensajes</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('') }}assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Equipo de Soporte
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Mantenimiento programado</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('') }}assets/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Equipo de Diseño HUV
                        <small><i class="fa fa-clock-o"></i> 2 horas</small>
                      </h4>
                      <p>Nuevas actualizaciones disponibles</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('') }}assets/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Desarrolladores
                        <small><i class="fa fa-clock-o"></i> Hoy</small>
                      </h4>
                      <p>Sistema actualizado correctamente</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('') }}assets/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Departamento Técnico
                        <small><i class="fa fa-clock-o"></i> Ayer</small>
                      </h4>
                      <p>Revisión de equipos completada</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todos los mensajes</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 10 notificaciones</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 nuevos mantenimientos programados
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Alerta de mantenimiento preventivo
                      para equipos industriales
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 nuevos equipos registrados
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 órdenes completadas
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> Perfil actualizado
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todas</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes 9 tareas pendientes</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Mantenimiento preventivo
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Completado</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Calibración de equipos
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Completado</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Actualización de inventario
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Completado</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Revisión de hojas de vida
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Completado</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">Ver todas las tareas</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('') }}assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ session('nombre') ?? 'Usuario HUV' }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('') }}assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  {{ session('nombre') ?? 'Usuario HUV' }} - Técnico de Mantenimiento
                  <small>Miembro desde {{ date('Y') }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Equipos</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Reportes</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Historial</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ asset('') }}administrador/Ccuentas" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="{{ asset('') }}Cauth/logout" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

