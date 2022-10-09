<?php

include '../conection/conection.php';
session_start();

if (isset($_SESSION['usuario']) && (isset($_SESSION['rol']))) {
    $usuario = $_SESSION['usuario'];

    $id_paciente = $_POST['id_paciente'];
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

    $sql = "UPDATE pacientes SET numero_identidad = '$numero_identidad', nombres = '$nombres', apellidos='$apellidos', fecha_nacimiento='$fecha_nacimiento', genero= '$genero',telefono_fijo='$telefono_fijo',"
            . "telefono_movil= '$telefono_movil', direccion='$direccion', raza='$raza', ocupacion='$ocupacion', estado_civil='$estado_civil',correo_electronico='$correo_electronico',antecedentes_personales='$antecedentes_personales',"
            . "antecedentes_familiares ='$antecedentes_familiares' WHERE id='$id_paciente' ";
    $result = $mysqli->query($sql);
    $resultado = "";

    if ($result === true) {
        $resultado = $resultado . '<div class = "col-md-4">';
        $resultado = $resultado . '<input class = "form-control" title = "Cédula o Pasaporte" placeholder = "Cédula o Pasaporte" value = "' . $numero_identidad . '"id = "numero_identidad" name = "numero_identidad" />';
        $resultado = $resultado . '<input class = "form-control" title = "Nombres" placeholder = "Nombres" value = "' . $nombres . '" id = "nombres" name = "nombres" />';
        $resultado = $resultado . '<input class = "form-control" title = "Apellidos" placeholder = "Apellidos" value = "' . $apellidos . '" id = "apellidos" name = "apellidos" />';
        $resultado = $resultado . '<input class = "form-control" title = "Fecha nacimiento" placeholder = "Fecha nacimiento" value = "' . $fecha_nacimiento . '" id = "fecha_nacimiento" name = "fecha_nacimiento" />';
        $resultado = $resultado . '<select class = "form-control" id = "genero" name = "genero" title = "Seleccione el Género">';
        $resultado = $resultado . '<option value = "' . $genero . '" selected = "">' . $genero . '</option>';
        $resultado = $resultado . '<option value = "Masculino">Maculino</option>';
        $resultado = $resultado . '<option value = "Femenino">Femenino</option>';
        $resultado = $resultado . '</select>';
        $resultado = $resultado . '<input class = "form-control" title = "Teléfono fijo" placeholder = "Teléfono fijo" value = "' . $telefono_fijo . '" id = "telefono_fijo" name = "telefono_fijo" /></div>';
        $resultado = $resultado . '<div class = "col-md-4">';
        $resultado = $resultado . '<input class = "form-control" title = "Teléfono móvil" placeholder = "Teléfono móvil" value = "' . $telefono_movil . '" id = "telefono_movil" name = "telefono_movil" />';
        $resultado = $resultado . '<input class = "form-control" title = "Dirección" placeholder = "Dirección" value = "' . $direccion . '" id = "direccion" name = "direccion" />';
        $resultado = $resultado . '<select class = "form-control" id = "raza" name = "raza" title = "Seleccione la Raza">';
        $resultado = $resultado . '<option value = "' . $raza . '" selected = "">' . $raza . '</option>';
        $resultado = $resultado . '<option value = "Mestiza">Mestiza</option>';
        $resultado = $resultado . '<option value="Negra">Negra</option>';
        $resultado = $resultado . '<option value = "Blanca">Blanca</option></select>';
        $resultado = $resultado . '<input class="form-control" title="Ocupación" placeholder="Ocupación" value="' . $ocupacion . '" id="ocupacion" name="ocupacion" />';
        $resultado = $resultado . '<select class = "form-control" id = "estado_civil" name = "estado_civil" title = "Seleccione Estado Civil">';
        $resultado = $resultado . '<option value="' . $estado_civil . '" selected="">' . $estado_civil . '</option>';
        $resultado = $resultado . '<option value = "Casado">Casado</option>';
        $resultado = $resultado . '<option value="Soltero">Soltero</option>';
        $resultado = $resultado . '<option value = "Union libre">Unión libre</option></select>';
        $resultado = $resultado . '<input class="form-control" title="Correo electrónico" placeholder="Correo electrónico"  value="' . $correo_electronico . '" id="correo_electronico" name="correo_electronico" /></div>';
        $resultado = $resultado . '<div class = "col-md-4">';
        $resultado = $resultado . '<textarea class="form-control" title="Antecedentes personales" placeholder="Antecedentes personales" id="antecedentes_personales" name="antecedentes_personales">' . $antecedentes_personales . '</textarea>';
        $resultado = $resultado . '<textarea class = "form-control" title = "Antecedentes familiares" placeholder = "Antecedentes familiares" id = "antecedentes_familiares" name = "antecedentes_familiares">' . $antecedentes_familiares . '</textarea><br>';
        $resultado = $resultado . '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $resultado = $resultado . 'Se editaron y guardaron correctamente los datos del paciente <button style="top: -2.35rem" type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $resultado = $resultado . '<span aria-hidden="true">&times;</span>';
        $resultado = $resultado . '</button></div>';
        $resultado = $resultado . '<input class = "btn btn-primary float-right" type = "button" name = "btn_actualizar_paciente" id = "btn_actualizar_paciente" value = "Guardar datos del paciente" onclick = "editar_paciente()"/></div>';
    } else {
        $resultado = $resultado . '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        $resultado = $resultado . 'No se pudieron editar los datos hubo un error <button style="top: -2.35rem" type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $resultado = $resultado . '<span aria-hidden="true">&times;</span>';
        $resultado = $resultado . '</button></div>';
    }
    echo $resultado;
}
