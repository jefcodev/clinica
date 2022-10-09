<?php
include 'header.php';
$id = $_SESSION['id'];
$id_cita = $_GET['id_cita'];
$class = '';
$close = '';
if (isset($_POST['btn_editar_cita'])) {
    $doctor = $_POST['doctor'];
    $fecha_cita = $_POST['fecha_cita'];
    $sql_update_cita = "UPDATE citas SET id_doctor='$doctor', fecha_cita='$fecha_cita', id_creador_cita = '$id' WHERE id='$id_cita'";
    $result_update_cita = $mysqli->query($sql_update_cita);
    if ($result_update_cita === true) {
        $error = 'Cita actualizada con éxito';
        $class = 'class="alert alert-success alert-dismissible fade show" role="alert"';
        $close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>';
    } else {
        $error = 'Ocurrió un error al actualizar la información de la cita';
        $class = 'class="alert alert-danger alert-dismissible fade show" role="alert"';
        $close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>';
    }
}
?>
<body>
    <section class="cuerpo">
        <h1>Editar cita médica</h1><br>        
        <?php
        $sql_datos_cita = "SELECT * FROM citas_datos WHERE id='$id_cita'";
        $result_datos_cita = $mysqli->query($sql_datos_cita);
        $rowcita = $result_datos_cita->fetch_assoc();
        ?>
        <div class="row"> 
            <div class="col-md-2"> 
                <p style="font-weight: bold">Nombres del paciente: </p>
                <p style="font-weight: bold">Apellidos del paciente: </p>
                <p style="font-weight: bold">C. Identida del paciente: </p>
                <p style="font-weight: bold">Doctor: </p>
                <p style="font-weight: bold">Fecha de la cita: </p>
            </div>
            <div class="col-md-2"> 
                <p><?php echo $rowcita['nombres_paciente'] ?></p>
                <p><?php echo $rowcita['apellidos_paciente'] ?></p>
                <p><?php echo $rowcita['numero_identidad'] ?></p>
                <p><?php echo $rowcita['fecha_cita'] ?></p>
                <p><?php echo $rowcita['nombre_doctor'] ?></p>
            </div>
            <div class="col-md-3">  
                <form method="post" >
                    <select class="form-control" id="doctor" name="doctor" required>
                        <option value="" selected="" hidden="">Seleccione el Doctor</option>
                        <?php
                        $sql_traer_doctor = "SELECT * FROM usuarios WHERE rol = 'doc'";
                        $consulta_traer_doctor = $mysqli->query($sql_traer_doctor);
                        while ($row = mysqli_fetch_array($consulta_traer_doctor)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . ' ' . $row['apellidos'] . "</option>";
                        }
                        ?>                   
                    </select>  
                    <input class="form-control" type="text" placeholder="Fecha y hora de la cita" name="fecha_cita" id="fecha_cita" required/><br>
                    <div class="form-group">
                        <div class="input-group date" id="fecha_cita">
                            <input type="text" class="form-control" />
                            <span class="input-group-addon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" name="btn_editar_cita" id="btn_editar_cita" value="Aceptar"/>
                    <a class="btn btn-danger" href="lista_citas.php">Cancelar</a>
                </form> 
                <br><br>
                <div <?php echo $class; ?> >
                    <?php echo isset($error) ? $error : ''; ?>
                    <?php echo $close; ?>
                </div>
            </div>
        </div>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
</body>