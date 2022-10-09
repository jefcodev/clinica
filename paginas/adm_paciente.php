<?php

session_start();
include_once "../conection/conection.php";
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];

if (isset($_POST['btn_crear_paciente'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_hora = date("Y-m-d H:i:s");
    $numero_identidad = $_POST['numero_identidad'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $telefono_fijo = $_POST['telefono_fijo'];
    $telefono_movil = $_POST['telefono_movil'];
    $direccion = $_POST['direccion'];
    $raza = $_POST['raza'];
    $ocupacion = $_POST['ocupacion'];
    $estado_civil = $_POST['estado_civil'];
    $correo_electronico = $_POST['correo_electronico'];
    $antecedentes_personales = $_POST['antecedentes_personales'];
    $antecedentes_familiares = $_POST['antecedentes_familiares'];

    $sql_crear_paciente = "INSERT INTO pacientes (numero_identidad, nombres, apellidos, fecha_nacimiento, genero, telefono_fijo, telefono_movil, "
            . "direccion, raza, ocupacion, estado_civil, correo_electronico, antecedentes_personales, antecedentes_familiares, fecha_hora) "
            . "VALUES ('$numero_identidad', '$nombres', '$apellidos', '$fecha_nacimiento', '$genero', '$telefono_fijo', '$telefono_movil', "
            . "'$direccion', '$raza', '$ocupacion', '$estado_civil', '$correo_electronico', '$antecedentes_personales', '$antecedentes_familiares', '$fecha_hora')";
    $query_crear_paciente = $mysqli->query($sql_crear_paciente);
    if ($query_crear_paciente == TRUE) {
        header("location:lista_pacientes.php?status=OK");
    } else {
        header("location:crear_paciente.php?status=ER");
    }
}

if (isset($_POST['btn_editar_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $contrasenna = sha1($_POST['contrasenna']);
    $rol = $_POST['rol'];

    if (empty($contrasenna)) {
        $sql_editar_usuario = "UPDATE usuarios SET usuario = '$usuario', nombre= '$nombre', apellidos = '$apellidos', telefono = '$telefono', rol = '$rol' WHERE id='$id_usuario'";
    } else {
        $sql_editar_usuario = "UPDATE usuarios SET usuario = '$usuario', nombre= '$nombre', apellidos = '$apellidos', telefono = '$telefono', rol = '$rol', contrasena = '$contrasenna' WHERE id='$id_usuario'";
    }
    $resul_editar_usuario = $mysqli->query($sql_editar_usuario);
    if ($resul_editar_usuario == TRUE) {
        header("location:editar_usuario.php?idusuario=$id_usuario");
    } else {
        echo 'No se pudo editar los datos del usuario';
    }
}