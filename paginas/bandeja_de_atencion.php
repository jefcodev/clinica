<?php
include 'header.php';
$id_cita = $_GET['id_cita'];
?>
<link rel="stylesheet" href="../css/bootstrap_select.min.css">

<body>
    <section class="cuerpo">
        <h1>Atención al paciente</h1><br>
        <?php
        $sql_datos_cita = "SELECT * FROM citas WHERE id='$id_cita'";
        $result_datos_cita = $mysqli->query($sql_datos_cita);
        $rowscita = $result_datos_cita->fetch_assoc();
        $id_paciente = $rowscita['id_paciente'];

        $sql_datos_paciente = "SELECT * FROM pacientes WHERE id='$id_paciente'";
        $result_datos_paciente = $mysqli->query($sql_datos_paciente);
        $rowspaciente = $result_datos_paciente->fetch_assoc();
        ?>
        <div style="padding: 1% 2% 1% 2%; background-color: #D8D8D8">
            <b style="font-size: 18px">Datos del paciente</b><br><br>
            <div class="row" id="edicion_paciente">
                <div class="col-md-4">
                    <input type="hidden" id="id_paciente" name="id_paciente" value="<?php echo $rowspaciente['id']; ?>" />
                    <input class="form-control" title="Cédula o Pasaporte" placeholder="Cédula o Pasaporte" value="<?php echo $rowspaciente['numero_identidad']; ?>" id="numero_identidad" name="numero_identidad" />
                    <input class="form-control" title="Nombres" placeholder="Nombres" value="<?php echo $rowspaciente['nombres']; ?>" id="nombres" name="nombres" />
                    <input class="form-control" title="Apellidos" placeholder="Apellidos" value="<?php echo $rowspaciente['apellidos']; ?>" id="apellidos" name="apellidos" />
                    <input class="form-control" title="Fecha nacimiento" placeholder="Fecha nacimiento" value="<?php echo $rowspaciente['fecha_nacimiento']; ?>" id="fecha_nacimiento" name="fecha_nacimiento" />
                    <select class="form-control" id="genero" name="genero" title="Seleccione el Género">
                        <option value="<?php echo $rowspaciente['genero']; ?>" selected=""><?php echo $rowspaciente['genero']; ?></option>
                        <option value="Masculino">Maculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <input class="form-control" title="Teléfono fijo" placeholder="Teléfono fijo" value="<?php echo $rowspaciente['telefono_fijo']; ?>" id="telefono_fijo" name="telefono_fijo" />
                </div>
                <div class="col-md-4">
                    <input class="form-control" title="Teléfono móvil" placeholder="Teléfono móvil" value="<?php echo $rowspaciente['telefono_movil']; ?>" id="telefono_movil" name="telefono_movil" />
                    <input class="form-control" title="Dirección" placeholder="Dirección" value="<?php echo $rowspaciente['direccion']; ?>" id="direccion" name="direccion" />
                    <select class="form-control" id="raza" name="raza" title="Seleccione la Raza">
                        <option value="<?php echo $rowspaciente['raza']; ?>" selected=""><?php echo $rowspaciente['raza']; ?></option>
                        <option value="Mestiza">Mestiza</option>
                        <option value="Negra">Negra</option>
                        <option value="Blanca">Blanca</option>
                    </select>
                    <input class="form-control" title="Ocupación" placeholder="Ocupación" value="<?php echo $rowspaciente['ocupacion']; ?>" id="ocupacion" name="ocupacion" />
                    <select class="form-control" id="estado_civil" name="estado_civil" title="Seleccione Estado Civil">
                        <option value="<?php echo $rowspaciente['estado_civil']; ?>" selected=""><?php echo $rowspaciente['estado_civil']; ?></option>
                        <option value="Casado">Casado</option>
                        <option value="Soltero">Soltero</option>
                        <option value="Union libre">Unión libre</option>
                    </select>
                    <input class="form-control" title="Correo electrónico" placeholder="Correo electrónico" value="<?php echo $rowspaciente['correo_electronico']; ?>" id="correo_electronico" name="correo_electronico" />
                </div>
                <div class="col-md-4">
                    <textarea class="form-control" title="Antecedentes personales" placeholder="Antecedentes personales" id="antecedentes_personales" name="antecedentes_personales"><?php echo $rowspaciente['antecedentes_personales']; ?></textarea>
                    <textarea class="form-control" title="Antecedentes familiares" placeholder="Antecedentes familiares" id="antecedentes_familiares" name="antecedentes_familiares"><?php echo $rowspaciente['antecedentes_familiares']; ?></textarea><br><br><br>
                    <input class="btn btn-primary float-right" type="button" name="btn_actualizar_paciente" id="btn_actualizar_paciente" value="Guardar datos del paciente" onclick="editar_paciente()" />
                </div>
            </div>
        </div><br>
        <div style="padding: 1% 2% 1% 2%; background-color: #D8D8D8">
            <b style="font-size: 18px">Datos de la consulta</b><br><br>
            <div id="crear_consulta">
                <div class="row">
                    <div class="col-md-6">
                        <textarea class="form-control" title="Motivo de la consulta" placeholder="Motivo de la consulta" id="motivo_consulta" name="motivo_consulta"></textarea>
                        <textarea class="form-control" title="Examen físico" placeholder="Examen físico" id="examen_fisico" name="examen_fisico"></textarea>
                        <textarea class="form-control" title="Tratamiento" placeholder="Tratamiento" id="tratamiento" name="tratamiento"></textarea>
                    </div>
                    <div class="col-md-6">
                        <select class="selectpicker" data-live-search="true" id="cie_10" title="Cie diez">
                            <?php
                            $result_cie_10 = $mysqli->query("SELECT * FROM cie_diez");
                            while ($row_cie10 = mysqli_fetch_array($result_cie_10)) {
                                echo '<option data-tokens="' . $row_cie10['codigo'] . '">' . $row_cie10['codigo'] . '-' . $row_cie10['descripcion'] . '</option>';
                            }
                            ?>
                        </select><br><br>
                        <textarea class="form-control" title="Diagnóstico" placeholder="Diagnóstico" id="diagnostico" name="diagnostico"></textarea>
                        <textarea class="form-control" title="Observaciones" placeholder="Observaciones" id="observaciones" name="observaciones"></textarea>
                        <input class="form-control" type="number" title="Días de certificado: no puede exceder los 60 días" placeholder="Días de certificado" id="certificado" name="certificado" min="1" max="60" />
                    </div>
                </div>


                <b style="font-size: 18px">Costo de consulta</b><br><br>

                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control" type="number" title="Precio de consulta" placeholder="Precio de consulta" id="precio" name="precio" min="1" />
                    </div>
                    <div class="col-md-6">
                        <textarea class="form-control" title="Detalles precio" placeholder="Detalles precio" id="descripcion_precio" name="descripcion_precio"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="id_cita" name="id_cita" value="<?php echo $id_cita; ?>" />
                    </div>
                    <div class="col-md-6">
                        <input class="btn btn-primary float-right" type="button" name="btn_crear_consulta" id="btn_crear_consulta" value="Guardar datos de la consulta" onclick="crear_consulta()" /><br>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>

    <script src="../js/bootstrap-select.js"></script>
    <script type="text/javascript">
        var select = document.getElementById("cie_10");
        var tArea = document.getElementById("diagnostico");
        select.onchange = function() {
            if (tArea.value.length === 0) {
                tArea.value = select.options[select.selectedIndex].value;
            } else {
                tArea.value = tArea.value + '\n' + select.options[select.selectedIndex].value;
            }
        }

        function editar_paciente() {
            var id_paciente = $("#id_paciente").val();
            var numero_identidad = $("#numero_identidad").val();
            var nombres = $("#nombres").val();
            var apellidos = $("#apellidos").val();
            var fecha_nacimiento = $("#fecha_nacimiento").val();
            var genero = document.getElementById("genero").value;
            var telefono_fijo = $("#telefono_fijo").val();
            var telefono_movil = $("#telefono_movil").val();
            var direccion = $("#direccion").val();
            var raza = document.getElementById("raza").value;
            var ocupacion = $("#ocupacion").val();
            var estado_civil = document.getElementById("estado_civil").value;
            var correo_electronico = $("#correo_electronico").val();
            var antecedentes_personales = document.getElementById("antecedentes_personales").value;
            var antecedentes_familiares = document.getElementById("antecedentes_familiares").value;
            $.ajax({
                url: 'editar_paciente_ajax.php',
                type: 'post',
                data: {
                    id_paciente: id_paciente,
                    numero_identidad: numero_identidad,
                    nombres: nombres,
                    apellidos: apellidos,
                    fecha_nacimiento: fecha_nacimiento,
                    genero: genero,
                    telefono_fijo: telefono_fijo,
                    telefono_movil: telefono_movil,
                    direccion: direccion,
                    raza: raza,
                    ocupacion: ocupacion,
                    estado_civil: estado_civil,
                    correo_electronico: correo_electronico,
                    antecedentes_personales: antecedentes_personales,
                    antecedentes_familiares: antecedentes_familiares,
                },
                success: function(response) {
                    $("#edicion_paciente").html(response);
                }
            });
        }

        function crear_consulta() {
            var id_paciente = $("#id_paciente").val();
            var motivo_consulta = document.getElementById("motivo_consulta").value;
            var precio =  $("#precio").val();
            var descripcion_precio = document.getElementById("descripcion_precio").value;
            var examen_fisico = document.getElementById("examen_fisico").value;
            var diagnostico = document.getElementById("diagnostico").value;
            var observaciones = document.getElementById("observaciones").value;
            var tratamiento = $("#tratamiento").val();
            var certificado = $("#certificado").val();
            var id_cita = $("#id_cita").val();
            $.ajax({
                url: 'crear_consulta.php',
                type: 'post',
                data: {
                    id_paciente: id_paciente,
                    motivo_consulta: motivo_consulta,
                    examen_fisico: examen_fisico,
                    diagnostico: diagnostico,
                    tratamiento: tratamiento,
                    id_cita: id_cita,
                    certificado: certificado,
                    observaciones: observaciones,
                    precio: precio,
                    descripcion_precio: descripcion_precio
                },
                success: function(response) {
                    $("#crear_consulta").html(response);
                }
            });
        }
    </script>
</body>