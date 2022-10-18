<?php

include '../conection/conection.php';
session_start();

if (isset($_SESSION['usuario']) && (isset($_SESSION['rol']))) {
    $usuario = $_SESSION['usuario'];
    date_default_timezone_set('America/Bogota');
    $fecha_hora = date("Y-m-d H:i:s");
    $id_paciente = $_POST['id_paciente'];
    $precio = $_POST['precio'];
    $descripcion_precio = $_POST['descripcion_precio'];
    $motivo_consulta = $_POST['motivo_consulta'];
    $examen_fisico = $_POST['examen_fisico'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
    $observaciones = $_POST['observaciones'];
    $id_cita = $_POST['id_cita'];
    $certificado = $_POST['certificado'];
    $sql = "INSERT INTO consultas (id_paciente,motivo_consulta,examen_fisico,diagnostico,tratamiento,fecha_hora, id_cita, certificado, observaciones,precio, descripcion_precio) VALUES ('$id_paciente','$motivo_consulta','$examen_fisico','$diagnostico','$tratamiento','$fecha_hora', '$id_cita', '$certificado', '$observaciones','$precio','$descripcion_precio')";
    $result = $mysqli->query($sql);
    $resultado = "";
    if ($result === true) {
        $mysqli->query("update citas set consultado='si' where id='$id_cita'");
        $resultado_consulta = $mysqli->query("select id from consultas where id_cita='$id_cita' and id_paciente = '$id_paciente'");
        $id_consulta = $resultado_consulta->fetch_assoc();
        $resultado = $resultado . '<div class="row">';
        $resultado = $resultado . '<div class="col-md-6">';
        $resultado = $resultado . '<textarea class="form-control" placeholder="Motivo de la consulta" id="motivo_consulta" name="motivo_consulta">' . $motivo_consulta . '</textarea>';
        $resultado = $resultado . '<textarea class="form-control" placeholder="Precio de la consulta" id="precio" name="precio">' . $precio . '</textarea>';
        $resultado = $resultado . '<textarea class="form-control" placeholder="Descripción de precio de la consulta" id="descripcion_precio" name="descripcion_precio">' . $descripcion_precio . '</textarea>';
        $resultado = $resultado . '<textarea class="form-control" placeholder="Examen físico" id="examen_fisico" name="examen_fisico">' . $examen_fisico . '</textarea>';
        $resultado = $resultado . '<textarea class="form-control" placeholder="Tratamiento" id="tratamiento" name="tratamiento">' . $tratamiento . '</textarea></div>';
        $resultado = $resultado . '<div class="col-md-6">';
        $id_consulta_edit = $id_consulta['id'];
        $resultado = $resultado . '<textarea class="form-control" placeholder="Diagnóstico" id="diagnostico" name="diagnostico">' . $diagnostico . '</textarea>';
        $resultado = $resultado . '<textarea class="form-control" placeholder="Oservaciones" id="observaciones" name="observaciones">' . $observaciones . '</textarea>';
        $resultado = $resultado . '<input class="form-control" type="number" title="Días de certificado: no puede exceder los 60 días" placeholder="Días de certificado" id="certificado" name="certificado" value ="'.$certificado.'" min="1" max="60"/>';
        $resultado = $resultado . '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $resultado = $resultado . 'Consulta registrada con éxito. Para modificarla en el siguiente enlace <a class="btn btn-success btn-sm" href="editar_consulta.php?id_consulta=' . $id_consulta_edit . '">Aquí</a> <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $resultado = $resultado . '<span aria-hidden="true">&times;</span>';
        $resultado = $resultado . '</button></div>';
    } else {
        $resultado = $resultado . '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $resultado = $resultado . 'No se pudieron editar los datos hubo un error <button style="top: -2.35rem" type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $resultado = $resultado . '<span aria-hidden="true">&times;</span>';
        $resultado = $resultado . '</button></div>';
        var_dump($observaciones);
        var_dump($sql);
    }
    echo $resultado;
}
