<?php session_start();

if (isset($_SESSION['idInicio']) !== false) {
    echo '<meta http-equiv="refresh" content="0; url=panel.php" />  ';
}

require_once 'config/conexion.php';
require_once 'clases/clsUsuarios.php';
require_once 'funciones.php';

$conexion = new Conexion();
$con = $conexion->getConectar();

if (isset($_REQUEST['login'])) {
    $email = mysqli_real_escape_string($con, $_REQUEST['email'] ?? '');
    $pasword = mysqli_real_escape_string($con, $_REQUEST['pass'] ?? '');

    $usuario = new Usuario(0, '', '', $email, $pasword);

    $mensaje = $usuario->ValidacionLogin();

    if ($mensaje !== '') {
        $error = $mensaje;
    } else {
        $row = $usuario->InicioSesion($con);
        if ($row) {
            $seguridad = $usuario->getSeguridad();
            $verificado = password_verify($seguridad, $row['pass']);
            if (!$verificado) {
                $error = '<b>Error al ingresar los datos del usuario.</b>';
            } else {
                $_SESSION['idInicio'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['usuario'] = $row['usuario'];
                echo '<meta http-equiv="refresh" content="0; url=panel.php" />  ';
            }
        } else {
            $error = '<b>Error al ingresar los datos del usuario.</b>';
        }
    }
}

require 'views/index.view.php';
