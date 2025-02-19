<?php

require_once 'clases/clsTrabajadores.php';
require_once 'clases/clsValidaciones.php';

$trabajador = new Trabajador();

if (isset($_POST['ingresar_trabajador'])) {
    $add_nombre = mysqli_real_escape_string($con, $_POST['add_nombre'] ?? '');
    $add_email = mysqli_real_escape_string($con, $_POST['add_email'] ?? '');
    $add_direccion = mysqli_real_escape_string($con, $_POST['add_direccion'] ?? '');
    $add_cedula = mysqli_real_escape_string($con, $_POST['add_cedula'] ?? '');
    $add_salario = mysqli_real_escape_string($con, $_POST['add_salario'] ?? '');

    $mensaje = Validaciones::ValidarCedula($add_cedula);

    if (strlen($mensaje) > 0) {
        AlertaAdvertencia($mensaje);
    } else {
        $trabajador->nombre = $add_nombre;
        $trabajador->email = $add_email;
        $trabajador->direccion = $add_direccion;
        $trabajador->salario = $add_salario;
        $trabajador->cedula = $add_cedula;
        $res = $trabajador->Registro($con);
        if ($res) {
            $_SESSION['mensaje'] = "<b>Trabajador registrado exitosamente</b>";
            echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=trabajadores" />  ';
        } else {
            AlertaError('<b>Error al registrar trabajador</b>');
        }
    }
} else if (isset($_POST['modificar_trabajador'])) {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre'] ?? '');
    $cedula = mysqli_real_escape_string($con, $_POST['cedula'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $direccion = mysqli_real_escape_string($con, $_POST['direccion'] ?? '');
    $salario = mysqli_real_escape_string($con, $_POST['salario'] ?? '');
    $id = $_POST['id'];

    $mensaje = Validaciones::ValidarCedula($cedula);

    if (strlen($mensaje) > 0) {
        AlertaAdvertencia($mensaje);
    } else {
        $trabajador->nombre = $nombre;
        $trabajador->email = $email;
        $trabajador->direccion = $direccion;
        $trabajador->salario = $salario;
        $trabajador->cedula = $cedula;
        $trabajador->id = $id;
        $res = $trabajador->Modificar($con);
        if ($res) {
            $_SESSION['mensaje'] = "<b>Trabajador modificado exitosamente</b>";
            echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=trabajadores" />  ';
        } else {
            AlertaError('<b>Error al modificar trabajador</b>');
        }
    }
} else if (isset($_POST['eliminar_trabajador'])) {
    $id = $_POST['delete_id'];
    $trabajador->id = $id;
    $res = $trabajador->Eliminar($con);
    if ($res) {
        $_SESSION['mensaje'] = "<b>Trabajador eliminado exitosamente</b>";
        echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=trabajadores" />  ';
    } else {
        AlertaError('<b>Error al eliminar trabajador</b>');
    }
}

$res = $trabajador->Consultar($con);

require 'views/trabajadores.view.php';
