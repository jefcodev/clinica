<?php
include 'header.php';
$pagina = PAGINAS::VER_HISTORIA_CLINICA;
$id_paciente = $_GET['id_paciente'];
if (!Seguridad::tiene_permiso($rol, $pagina, ACCIONES::VER)) {
    header("location:./inicio.php?status=AD");
}
?>
<body>
    <section class="cuerpo">
        <?php
        $sql_datos_historia = "SELECT * FROM pacientes WHERE id='$id_paciente'";
        $result_datos_historia = $mysqli->query($sql_datos_historia);
        while ($row = mysqli_fetch_array($result_datos_historia)) {
            ?>
        <div id="imprimir">
                <h3 style="color: #007bff; font-weight: bold; margin: 2rem">Historia Clínica Villamedyc</h3>
                <div class="row" style="margin: 2rem">
                    <div class="col-md-6 historiap">
                        <b class="float-left mr-3">Nombres: </b><p><?php echo $row ['nombres']; ?></p>
                        <b class="float-left mr-3">Apellidos: </b><p><?php echo $row ['apellidos']; ?></p>
                        <b class="float-left mr-3">Número identidad: </b><p><?php echo $row ['numero_identidad']; ?></p>
                        <b class="float-left mr-3">Fecha nacimiento: </b><p><?php echo $row ['fecha_nacimiento']; ?></p>
                        <b class="float-left mr-3">Género: </b><p><?php echo $row ['genero']; ?></p>
                        <b class="float-left mr-3">Teléfono fijo: </b><p><?php echo $row ['telefono_fijo']; ?></p>
                        <b class="float-left mr-3">Teléfono movil: </b><p><?php echo $row ['telefono_movil']; ?></p>
                        <b class="float-left mr-3">Dirección: </b><p><?php echo $row ['direccion']; ?></p>
                        <b class="float-left mr-3">Raza: </b><p><?php echo $row ['raza']; ?></p>
                        <b class="float-left mr-3">Ocupación: </b><p><?php echo $row ['ocupacion']; ?></p>
                        <b class="float-left mr-3">Correo electrónico: </b><p><?php echo $row ['correo_electronico']; ?></p>
                        <b class="float-left mr-3">Antecedentes personales: </b><p><?php echo $row ['antecedentes_personales']; ?></p>
                        <b class="float-left mr-3">Antecedentes familiares: </b><p><?php echo $row ['antecedentes_familiares']; ?></p>
                    </div>
                </div>
                <div class="row" style="margin: 2rem">
                    <div class="col-md-6 historiap">
                        <h3 style="color: #007bff; font-weight: bold;">Consultas:</h3>
                        <?php
                    }
                    $sql_consultas = "select * from consultas_datos where id_paciente ='$id_paciente' order by fecha_hora desc";
                    $result_datos_consulta = $mysqli->query($sql_consultas);

                    while ($row_consulta = mysqli_fetch_array($result_datos_consulta)) {
                        ?>
                        <h4 class="float-left mr-3 div_consultas">Fecha consulta: <?php echo $row_consulta ['fecha_hora']; ?></h4><br/>
                        <div style="border:2px solid #ccc;padding: 1.5em 0em 0.8em 1.2em;">
                            <b class="float-left mr-3">Motivo de la consulta: </b><p><?php echo nl2br($row_consulta ['motivo_consulta']); ?></p>
                            <b class="float-left mr-3">Examen físico: </b><p><?php echo nl2br($row_consulta ['examen_fisico']); ?></p>
                            <b class="float-left mr-3">Diagnóstico: </b><p><?php echo nl2br($row_consulta ['diagnostico']); ?></p>
                            <b class="float-left mr-3">Tratamiento: </b><p><?php echo nl2br($row_consulta ['tratamiento']); ?></p>
                             <b class="float-left mr-3">Observaciones: </b><p><?php echo nl2br($row_consulta ['observaciones']); ?><br></p>
                            <b class="float-left mr-3">Doctor: </b><p><?php echo $row_consulta ['nombre_doctor'] . ' ' . $row_consulta ['apellidos_doctor']; ?></p>
                            <?php if ($row_consulta ['certificado'] != 0 or $row_consulta ['certificado'] != '0') { ?>
                                <b class="float-left mr-3">Días de certificado: </b><p><?php echo $row_consulta ['certificado']; ?></p>
                            <?php } ?>
                        </div><br/>
                    <?php } ?>
                </div>
            </div><br>
        </div>
        <input type="button" class="btn btn-danger" value="Imprimir Historia Clínica" onclick="printDiv('imprimir')"/>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
    <script>
        function printDiv(nombreDiv) {
            var contenido = document.getElementById(nombreDiv).innerHTML;
            var contenidoOriginal = document.body.innerHTML;

            document.body.innerHTML = contenido;
            window.print();
            document.body.innerHTML = contenidoOriginal;
        }
    </script>
</body>
