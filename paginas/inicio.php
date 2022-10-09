<?php
include 'header.php';
$status = $_GET['status'];
$pagina = PAGINAS::INICIO;
$class = '';
$close = '';
if (isset($status)) {
    $close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>';
    if ($status === 'AD') {
        $error = 'Usted no tiene accesos para ejecutar la acción solicitada';
        $class = 'class="alert alert-danger alert-dismissible fade show" role="alert"';
    } else {
        $error = 'Exitoso';
        $class = 'class="alert alert-success alert-dismissible fade show" role="alert"';
    }
}
?>
<body>
    <div class="cuerpo">
        <div <?php echo $class; ?> >
            <?php echo isset($error) ? $error : ''; ?>
            <?php echo $close; ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6 logos_azul">
                        <a href="lista_pacientes.php">
                            <i class="fas fa-users fa-6x"></i><br>
                            <label>Pacientes</label>
                        </a>
                    </div>
                    <div class="col-md-6 logos_azul">
                        <a href="lista_citas.php">
                            <i class="fas fa-calendar-alt fa-6x"></i><br>
                            <label>Citas</label>
                        </a>
                    </div>
                </div><br><br><br><br>
                <div class="row">                    
                    <div class="col-md-6 logos_azul">
                        <a href="lista_historias.php">
                            <i class="far fa-file-alt fa-6x"></i><br>
                            <label>Historias</label>
                        </a>
                    </div>
                    <div class="col-md-6 logos_azul">
                        <a href="#">
                            <i class="fas fa-print fa-6x"></i><br>
                            <label>Impresión</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <table class="table table-bordered table-hover">
                            <thead class="tabla_cabecera">
                                <tr>
                                    <th>Fecha cita</th>
                                    <th>Doctor</th>
                                    <th>Paciente</th>
                                    <th>Cédula</th>
                                    <?php 
                                    if (Seguridad::tiene_permiso($rol, $pagina, ACCIONES::ATENDER_CITA)) {
                                    if ($rol == 'adm' or $rol == 'doc') { ?>
                                        <th>Atender</th>
                                    <?php } }?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Bogota');
                                $dia_hoy = date("d");
                                $mes_hoy = date("m");
                                $anio_hoy = date("Y");
                                $sql_citas_hoy = "SELECT * FROM citas_datos where DAY(fecha_cita) = '$dia_hoy' and MONTH(fecha_cita) = '$mes_hoy' and YEAR(fecha_cita) = '$anio_hoy' and consultado='no' order by fecha_cita asc";
                                $result_citas_hoy = $mysqli->query($sql_citas_hoy);
                                if ($result_citas_hoy->num_rows == 0) {
                                    echo "<tr><td colspan='5' style='text-align: center'>No hay citas agendadas para hoy</td></tr>";
                                }
                                while ($row = mysqli_fetch_array($result_citas_hoy)) {
                                    $id = $row['id'];
                                    echo "<tr>";
                                    echo "<td>" . $row['fecha_cita'] . "</td>";
                                    echo "<td>" . $row['nombre_doctor'] . "</td>";
                                    echo "<td>" . $row['nombres_paciente'] . " " . $row['apellidos_paciente'] . "</td>";
                                    echo "<td>" . $row['numero_identidad'] . "</td>";

                                    if (Seguridad::tiene_permiso($rol, $pagina, ACCIONES::ATENDER_CITA)) {
                                        echo "<td>";
                                        if ($rol == 'adm' or $row['id_doctor'] == $id_usuario) {
                                            echo "<a class='btn btn-success btn-sm' href='bandeja_de_atencion.php?id_cita=$id'>Atender</a>";
                                        }
                                        echo "</td>";
                                    }

                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
    include 'footer.php';
    ?>
</body>