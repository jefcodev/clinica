<?php

session_start();
include_once "../conection/conection.php";
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];

if (isset($_POST['btn_crear_usuario'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_hora = date("Y-m-d H:i:s");
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $contrasenna = sha1($_POST['usuario']);
    $rol = $_POST['rol'];

    $sql_crear_usuario = "INSERT INTO usuarios (usuario, nombre, apellidos, telefono, contrasena, rol, fecha_creado) VALUES ('$usuario', '$nombre', '$apellidos', '$telefono', '$contrasenna', '$rol', '$fecha_hora')";
    $query_crear_usuario = $mysqli->query($sql_crear_usuario);
    var_dump($sql_crear_usuario);
    var_dump($query_crear_usuario);
    if ($query_crear_usuario == TRUE) {
        header("location:crear_usuario.php?status=OK");
    } else {
        header("location:crear_usuario.php?status=ER");
    }
}
if (isset($_POST['btn_editar_cuenta_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $contra_lisa = $_POST['contrasenna'];
    $contrasenna = sha1($_POST['contrasenna']);

    if (empty($contra_lisa)) {
        $sql_editar_usuario = "UPDATE usuarios SET  nombre= '$nombre', apellidos = '$apellidos', especialidad = '$especialidad', telefono = '$telefono' WHERE id='$id_usuario'";
    } else {
        $sql_editar_usuario = "UPDATE usuarios SET nombre= '$nombre', apellidos = '$apellidos', especialidad = '$especialidad', telefono = '$telefono',  contrasena = '$contrasenna' WHERE id='$id_usuario'";
    }
    $resul_editar_usuario = $mysqli->query($sql_editar_usuario);
    if ($resul_editar_usuario == TRUE) {
        header("location:editar_cuenta_usuario.php?status=OK");
    } else {
        header("location:editar_cuenta_usuario.php?status=ER");
    }
}
if (isset($_POST['btn_editar_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $contrasenna = sha1($_POST['contrasenna']);
    $contrasenna_plana = $_POST['contrasenna'];
    $rol = $_POST['rol'];

    if (empty($contrasenna_plana)) {
        $sql_editar_usuario = "UPDATE usuarios SET usuario = '$usuario', nombre= '$nombre', apellidos = '$apellidos', telefono = '$telefono', rol = '$rol' WHERE id='$id_usuario'";
    } else {
        $sql_editar_usuario = "UPDATE usuarios SET usuario = '$usuario', nombre= '$nombre', apellidos = '$apellidos', telefono = '$telefono', rol = '$rol', contrasena = '$contrasenna' WHERE id='$id_usuario'";
    }
    $resul_editar_usuario = $mysqli->query($sql_editar_usuario);
    if ($resul_editar_usuario == TRUE && 1 === $mysqli->affected_rows) {
        header("location:editar_cuenta_usuario.php?status=OK");
    } else {
        header("location:editar_cuenta_usuario.php?status=ER");
    }
}