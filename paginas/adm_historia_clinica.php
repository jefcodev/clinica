<?php

session_start();
include_once "../conection/conection.php";
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];

if (isset($_POST['btn_crear_cita'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_creacion_cita = date("Y-m-d H:i:s");
    $nombre_paciente = $_POST['nombre_paciente'];
    $apellidos_paciente = $_POST['apellidos_paciente'];
    $doctor = $_POST['doctor'];
    $telefono_paciente = $_POST['telefono_paciente'];
    $cedula_paciente = sha1($_POST['cedula_paciente']);
    $fecha_cita = $_POST['fecha_cita'];
    $creador_cita = $usuario;

    $sql_crear_usuario = "INSERT INTO citas (nombre_paciente, apellidos_paciente, doctor, telefono_paciente, cedula_paciente, fecha_cita, fecha_creacion_cita, creador_cita) VALUES "
            . "('$nombre_paciente', '$apellidos_paciente', '$doctor', '$telefono_paciente', '$cedula_paciente', '$fecha_cita', '$fecha_creacion_cita', '$creador_cita')";
    $query_crear_usuario = $mysqli->query($sql_crear_usuario);

    if ($query_crear_usuario == TRUE) {
        echo 'Se creo la cita satisfactoriamente';
        header('location:crear_cita.php');
    } else {
        echo 'No se pudo crear la cita';
        var_dump($sql_crear_usuario);
    }
}

if (isset($_POST['btn_editar_cita'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_creacion_cita = date("Y-m-d H:i:s");
    $nombre_paciente = $_POST['nombre_paciente'];
    $apellidos_paciente = $_POST['apellidos_paciente'];
    $doctor = $_POST['doctor'];
    $telefono_paciente = $_POST['telefono_paciente'];
    $cedula_paciente = sha1($_POST['cedula_paciente']);
    $fecha_cita = $_POST['fecha_cita'];
    $creador_cita = $usuario;

    $sql_crear_usuario = "INSERT INTO citas (nombre_paciente, apellidos_paciente, doctor, telefono_paciente, cedula_paciente, fecha_cita, fecha_creacion_cita, creador_cita) VALUES "
            . "('$nombre_paciente', '$apellidos_paciente', '$doctor', '$telefono_paciente', '$cedula_paciente', '$fecha_cita', '$fecha_creacion_cita', '$creador_cita')";
    $query_crear_usuario = $mysqli->query($sql_crear_usuario);

    if ($query_crear_usuario == TRUE) {
        echo 'Se creo la cita satisfactoriamente';
        header('location:crear_cita.php');
    } else {
        echo 'No se pudo crear la cita';
        var_dump($sql_crear_usuario);
    }
}