<?php
session_start();
require_once 'db_conexion.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = $cnnPDO->prepare('SELECT * from registrar WHERE email=:email and confpassword=:password');
$query->bindParam(':email', $email);
$query->bindParam(':password', $password);

    $query->execute();
    $count = $query->rowCount();
    $campo = $query->fetch();
    if ($count) {
        if ($campo['estado'] == 'activo') {
            $_SESSION['email'] = $campo['email'];
            $_SESSION['nombre'] = $campo['nombre'];
            $_SESSION['password'] = $campo['password'];
            $_SESSION['telefono'] = $campo['telefono'];
            header("location:bienvenida.php");
            exit();
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Cuenta no activa',
                text: 'Tu cuenta ha sido deshabilitada.',
                confirmButtonText: 'OK'
            });
        </script>";
        }
    } else {
        // Mostrar una alerta de error solo si las credenciales son incorrectas
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Campos incorrectos',
                    text: 'Los campos no ingresados son incorrectos.',
                    confirmButtonText: 'OK'
                });
            </script>";
    }
    ob_end_flush();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bazarum Inicio de sesión</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/styles.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Remember
  * Updated: Mar 10 2024 with Bootstrap v5.3.3
  * Template URL: https://bootstrapmade.com/remember-free-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex justify-content-between">

      <div class="logo">
        <h1 class="text-light"><a href="index.html">Bazarum</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.html">Volver al inicio</a></li>
          <li><a class="nav-link scrollto" href="registro.php">Registarse</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- Section: Design Block -->
<section class="background-radial-gradient overflow-hidden">
<style>
    .background-radial-gradient {
      background-color: hsl(197, 87%, 86%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(197, 87%, 90%) 15%,
          hsl(197, 87%, 80%) 35%,
          hsl(197, 87%, 70%) 75%,
          hsl(197, 87%, 60%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(197, 87%, 95%) 15%,
          hsl(197, 87%, 80%) 35%,
          hsl(197, 87%, 70%) 75%,
          hsl(197, 87%, 60%) 80%,
          transparent 100%);
    }

 #radius-shape-1 {
  height: 220px;
  width: 220px;
  top: -60px;
  left: -130px;
  background: radial-gradient(hsl(197, 87%, 90%), hsl(197, 87%, 50%)); /* Azul celeste más claro */
  overflow: hidden;
}

#radius-shape-2 {
  border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
  bottom: -60px;
  right: -110px;
  width: 300px;
  height: 300px;
  background: radial-gradient(hsl(197, 87%, 90%), hsl(197, 87%, 50%)); /* Azul celeste más claro */
  overflow: hidden;
}


    .bg-glass {
      background-color: hsla(0, 0%, 100%, 0.9) !important;
      backdrop-filter: saturate(200%) blur(25px);
    }
  </style>

<div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
  <div class="row gx-lg-5 align-items-center mb-5">
    <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
      <h1 class="my-5 display-5 fw-bold ls-tight" style="color: black;">
        ¡Bienvenido de nuevo!<br />
        <span style="color: hsl(0, 0%, 30%);">Inicia sesión y sigue disfrutando de las mejores ofertas.</span>
      </h1>
      <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 25%);">
      ¡Nos alegra verte de nuevo en Bazarum! Inicia sesión para acceder a tu cuenta, descubrir nuevas ofertas y continuar con tus compras favoritas.
      </p>
    </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card bg-glass">
    <div class="card-body px-4 py-5 px-md-5">
        <form method="post">
            <!-- 2 column grid layout with text inputs for the first and last names -->

            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="email" id="email" class="form-control" name="email" />
                <label class="form-label" for="email">Email</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <input type="password" id="password" class="form-control" name="password" />
                <label class="form-label" for="password">Contraseña</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4" id="enviar" name="login">
                Iniciar sesión
            </button>
        </form>
        
        <p class="text-center">¿Nuevo aquí? <a href="registro.php">Regístrate</a> para obtener una cuenta.</p>
    </div>
</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->
    </div>
    </div>
    </main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

  <div class="container footer-bottom clearfix">
    <div class="copyright">
      &copy; Copyright <strong><span>Bazarum</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/remember-free-multipurpose-bootstrap-template/ -->
      Designed by <a href="https://bootstrapmade.com/">Bazarum</a>
    </div>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        
        let formatoemail = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

        $("#enviar").click(function() {

            if ($("#email").val() == "" || !formatoemail.test($("#email").val())) {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true ,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                //  Aqui pones el mensaje donde diga tittle
                title: 'Email incorrecto, utilice un correo válido'

            })
                return false;

            } else if ($("#nombre").val() == "") {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Nombre incompleto, por favor llena el campo'
                })
                return false;

            } else if ($("#password").val() == "") {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Clave incompleta, llena este campo'
                })
                return false;

        }});

});
</script>