<?php session_start();

session_regenerate_id(true);

if (isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "cerrar") {
  session_destroy();
  $_SESSION = array();
  echo '<meta http-equiv="refresh" content="0; url=index.php" />  ';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplicación</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
  <link rel="stylesheet" href="css/editor.dataTables.min.css">

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body id="cuerpo" class="hold-transition sidebar-mini layout-fixed">

  <?php

  $modulo = $_REQUEST['modulo'] ?? '';

  //Conexión a la Base de Datos
  require_once "config/conexion.php";
  $conexion = new Conexion();
  $con = $conexion->getConectar();

  require_once('views/panel-header.view.php');

  require_once 'funciones.php';

  if (isset($_SESSION['mensaje']) && $_SESSION['mensaje'] !== '') {
    AlertaExitosa($_SESSION['mensaje']);
    $_SESSION['mensaje'] = '';
  } else if (isset($_SESSION['error']) && $_SESSION['error'] !== '') {
    AlertaError($_SESSION['error']);
    $_SESSION['error'] = '';
  }

  if (!isset($_SESSION['idInicio'])) {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />  ';
  } else {
    if ($modulo == '' || $modulo == 'inicio') {
      require_once "inicio.php";
    } else {
      $ruta = $modulo . '.php';
      require_once $ruta;
    }
  }

  ?>

  <script src="dist/js/pages/dashboardProd.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
  <!--
<script src="js/dataTables.editor.min.js"></script>
-->
  <script src="js/tablas.js"></script>
  <script src="js/validacion.js"></script>

</body>

</html>