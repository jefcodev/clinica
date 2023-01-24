<?php

include '../conection/conection.php';
session_start();

if (isset($_SESSION['usuario']) && (isset($_SESSION['rol']))) {
    $usuario = $_SESSION['usuario'];
    
    $numero_identidad = $_POST['numero_identidad'];
    $sql = "SELECT * FROM pacientes where numero_identidad = '$numero_identidad'";
    $result = $mysqli->query($sql);
    $resultado = "";
 
    if ($result->num_rows == 0) {
                $resultado = $resultado . "<p style='color: red; font-size:18'>" . '"No se encuentra un paciente registrado con la identificación ingresada, a continuación la opción para crearlo"' . "</p>";
                $resultado = $resultado . '<a target="_blanck" href="crear_paciente.php" class="btn btn-success btn-sm"> Crear nuevo paciente</a>';
                
     } else {
        while ($row = mysqli_fetch_array($result)) {
            $resultado = $resultado . "<input type='hidden' id='id_paciente_resultado' name='id_paciente_resultado' value='". $row['id'] ."'/>";
            $resultado = $resultado . "<p><b>Identificación: </b>" . $row['numero_identidad'] . "</p>";
            $resultado = $resultado . "<p><b>Nombre: </b>" . $row['nombres'] . "</p>";
            $resultado = $resultado . "<p><b>Apellidos: </b>" . $row['apellidos'] . "</p>";
            $resultado = $resultado . "<p><b>Fecha de nacimiento: </b>" . $row['fecha_nacimiento'] . "</p>";
            $resultado = $resultado . "<p><b>Género: </b>" . $row['genero'] . "</p>";
            
        }
    }
    echo $resultado;
}