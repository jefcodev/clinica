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
    <link rel="stylesheet" href="../css/jquery.datetimepicker.css">
</head>
<body>
    <section class="cuerpo">
        <div  id="mensajes" <?php echo $class; ?>>
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
                <input class="btn btn-primary" type="button" name="btn_buscar_paciente" id="btn_buscar_paciente" value="Buscar" onclick="buscar_paciente()"/>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4"> 
                <form action="adm_citas.php" method="post" onsubmit="return validar()">  
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
                            <input type='hidden' id='id_paciente' name='id_paciente'/>
                            <input class="form-control" type="text" autocomplete="off" placeholder="Fecha y hora de la cita" id="fecha_cita" name="fecha_cita" required/><br>  
                        </div>
                        <div class="col-md-4"> 
                            <input class="btn btn-primary" type="submit" name="btn_crear_cita" id="btn_crear_cita" value="Aceptar"/>
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
    <br>
    <?php
    include 'footer.php';
    ?>
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
                        onSelectTime: function (ct) {
                            validarDisponibilidadHorarios();
                        }
                    });
                    $.datetimepicker.setLocale('es');
                    $(document).ready(function () {
                        setTimeout(function () {
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
                            success: function (response) {
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
                    $('#doctor').change(function () {
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
                            success: function (response) {
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

