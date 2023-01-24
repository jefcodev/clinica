<!DOCTYPE html>
<html>
<?php
include 'header.php';
$status = $_GET['status'];
$class = '';
if (isset($status)) {
    if ($status === 'OK') {
        $error = 'Cita creada correctamente';
        $class = 'class="alert alert-success"';
    } else {
        $error = 'Ocurrió un error al crear la cita';
        $class = 'class="alert alert-danger"';
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP MySQL Select2 Example</title>

    <link rel="stylesheet" href="../css/jquery.datetimepicker.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</head>

<body>
    <div class="row mt-5">



        <div class="col-md-6 offset-3 mt-5">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Paciente</h4>
                </div>
                <div class="card-body" style="height: 280px;">
                    <div>

                        <select class="select2 form-control" data-rel="chosen" name="id_paciente" id="id_paciente">
                            <?php
                            // $resultado = "";
                            // while ($row = $result->fetch_assoc()) {
                            //     echo "<option>"
                            //         . "CI: " . $row["numero_identidad"] . "   " . $row["nombres"] .
                            //         " " . $row["apellidos"] .

                            //         "</option>";
                            //     $id_paciente = ["id_paciente"];
                            //     $resultado = $resultado . "<input type='hidden' id='id_paciente_resultado' name='id_paciente_resultado' value='" . $row['id'] . "'/>";
                            // }
                            if ($result) {
                                while ($fila = mysqli_fetch_array($result)) {
                            ?>
                                    <option value="<?php echo $fila["id"] ?>"><?php echo $fila["nombres"] ?></option>
                            <?php
                                }
                            }

                            ?>

                        </select>

                    </div>
                </div>

            </div>
        </div>


        <section class="cuerpo">
            <div id="mensajes" <?php echo $class; ?>>
                <?php echo isset($error) ? $error : ''; ?>
            </div>
            <h1>Crear Cita</h1><br>
            <div class="row">
                <div class="col-md-4">
                    <b style="color: #28a745">1. Buscar usuario para ver si es paciente de la clinica</b><br><br>
                </div>
                <div class="col-md-6">
                    <b style="color: #28a745">2. Asignar doctor y fecha de la cita</b><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" placeholder="Cédula o Pasaporte" id="numero_identidad" name="numero_identidad" />
                    <div id="resultado_paciente"></div>
                </div>
                <div class="col-md-1">
                    <input class="btn btn-primary" type="button" name="btn_buscar_paciente" id="btn_buscar_paciente" value="Buscar" onclick="buscar_paciente()" />
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <form action="adm_citas.php" method="post">
                        <div class="row">
                            <div class="col-md-8">
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
                                <?php

                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "clinica";

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                $sql = "SELECT * FROM `pacientes`";

                                $result = $conn->query($sql);

                                ?>
                                <select class="select2 form-control" data-rel="chosen" id='id_paciente' name='id_paciente'>
                                    <?php
                                    // $resultado = "";
                                    // while ($row = $result->fetch_assoc()) {
                                    //     echo "<option>"
                                    //         . "CI: " . $row["numero_identidad"] . "   " . $row["nombres"] .
                                    //         " " . $row["apellidos"] .

                                    //         "</option>";
                                    //     $id_paciente = ["id_paciente"];
                                    //     $resultado = $resultado . "<input type='hidden' id='id_paciente_resultado' name='id_paciente_resultado' value='" . $row['id'] . "'/>";
                                    // }
                                    if ($result) {
                                        while ($fila = mysqli_fetch_array($result)) {
                                    ?>
                                            <option value="<?php echo $fila["id"] ?>"><?php echo $fila["nombres"] ?></option>
                                    <?php
                                        }
                                    }

                                    ?>
                                    <!-- <input type='hidden' id='id_paciente' name='id_paciente'/> -->
                                    <input class="form-control" type="text" autocomplete="off" placeholder="Fecha y hora de la cita" id="fecha_cita" name="fecha_cita" required /><br>
                            </div>
                            <div class="col-md-4">
                                <input class="btn btn-primary" type="submit" name="btn_crear_cita" id="btn_crear_cita" value="Aceptar" />
                            </div>
                        </div>
                    </form>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-8">
                    <div id="miDiv" class="alert alert-danger" role="alert" style="display: none"></div>
                </div>
            </div>
        </section>
    </div>





    <script type="text/javascript">
        $('.select2').select2({});
    </script>
<script language="javascript" src="../js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('#fecha_cita').datetimepicker({
            startDate: new Date(),
            value: new Date(),
            step: 15,
            minDate: 0,
            minTime: '06:00',
            maxTime: '20:00',
            dayOfWeekStart: 0,
            disabledWeekDays: [0, 6],
            closeOnDateSelect: false,
            closeOnTimeSelect: true,
            onSelectTime: function(ct) {
                validarDisponibilidadHorarios();
            }
        });
        $.datetimepicker.setLocale('es');
        $(document).ready(function() {
            setTimeout(function() {
                $("#mensajes").fadeOut(1500);
            }, 2500);
        });

        function buscar_paciente() {
            var numero_id = $("#numero_identidad").val();
            $.ajax({
                url: 'buscar_paciente.php',
                type: 'post',
                data: {
                    numero_identidad: numero_id
                },
                success: function(response) {
                    $("#resultado_paciente").html(response);
                    $('input[name="id_paciente"]').val($("#id_paciente_resultado").val());
                }
            });
        }

        function validar() {
            var numero_identidad = document.getElementById('numero_identidad').value;
            var miDiv = document.getElementById('miDiv');
            var html = "";
            if (numero_identidad === "") {
                document.getElementById("miDiv").style.display = 'block';
                miDiv.innerHTML = ""; //innerHTML te añade código a lo que ya haya por eso primero lo ponemos en blanco.
                html = "No puede dejar el campo Cédula o Pasaporte vacío, debe antes de crear la cita buscar al paciente.";
                miDiv.innerHTML = html;
                return false;
            }
        }
        $('#doctor').change(function() {
            validarDisponibilidadHorarios();
        });

        function validarDisponibilidadHorarios() {
            var fecha_cita = $("#fecha_cita").val();
            var doctor = $("#doctor").val();
            $.ajax({
                url: 'consultar_disponibilidad_horarios.php',
                type: 'post',
                data: {
                    fecha_cita: fecha_cita,
                    doctor: doctor,
                },
                success: function(response) {
                    if ('' === response) {
                        var miDiv = document.getElementById('miDiv');
                        var html = "";
                        document.getElementById("miDiv").style.display = 'block';
                        miDiv.innerHTML = ""; //innerHTML te añade código a lo que ya haya por eso primero lo ponemos en blanco.
                        html = "La fecha seleccionada no está disponible, por favor seleccione otro horario.";
                        miDiv.innerHTML = html;
                        $("#fecha_cita").datetimepicker('show')
                            .datetimepicker('reset');
                    }
                }
            });
        }
    </script>
</body>

</html>