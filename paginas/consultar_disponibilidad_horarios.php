<?php

include '../conection/conection.php';
session_start();

if (isset($_SESSION['usuario']) && (isset($_SESSION['rol']))) {
    $usuario = $_SESSION['usuario'];

    $id_doctor = $_POST['doctor'];
    $fecha_cita = date("Y-m-d H:i:s", strtotime($_POST['fecha_cita']));

    $sql = "SELECT count(id) cantidad FROM citas where id_doctor = '$id_doctor' and fecha_cita = '$fecha_cita'";
    $resultado = $mysqli->query($sql);
    //var_dump($resultado);
    $cantidad = mysqli_fetch_array($resultado)['cantidad'];
    if ($cantidad === 0 or $cantidad === '0') {
        echo $fecha_cita;
    } else {
        echo '';
    }
}    