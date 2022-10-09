<?php
session_start();
include_once "../conection/conection.php";
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
$id = $_SESSION['id'];

if (isset($_POST['btn_crear_cita'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_creacion_cita = date("Y-m-d H:i:s");
    $doctor = $_POST['doctor'];
    $id_paciente = $_POST['id_paciente'];
    $fecha_cita = $_POST['fecha_cita'];

    $sql_crear_cita = "INSERT INTO citas (id_doctor, id_paciente , fecha_cita, fecha_creacion_cita, id_creador_cita) VALUES "
            . "('$doctor', '$id_paciente', '$fecha_cita', '$fecha_creacion_cita', '$id')";
    $query_crear_cita = $mysqli->query($sql_crear_cita);
    if ($query_crear_cita == TRUE) {
        header("location:crear_cita.php?status=OK");
    } else {
        header("location:crear_cita.php?status=ER");
    }
}

if (isset($_POST['btn_editar_cita'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_creacion_cita = date("Y-m-d H:i:s");
    $doctor = $_POST['doctor'];
    $id_paciente = $_POST['id_paciente'];
    $fecha_cita = $_POST['fecha_cita'];
    $creador_cita = $usuario;

    $sql_crear_cita = "update citas set doctor='$doctor', id_paciente='$id_paciente', fecha_cita='$fecha_cita', fecha_creacion_cita='$fecha_creacion_cita', creador_cita='$creador_cita'";
    $query_crear_cita = $mysqli->query($sql_crear_cita);

    if ($query_crear_cita == TRUE) {
        header('location:crear_cita.php');
        echo 'Se creo la cita satisfactoriamente';
    } else {
        echo 'No se pudo crear la cita';
    }
}