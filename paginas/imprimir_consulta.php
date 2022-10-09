<?php
include 'header.php';
$id_consulta = $_GET['idconsulta'];
?>
<body>
    <section class="cuerpo">
        <h1>Imprimir consulta</h1><br>        
        <?php
        $sql_datos_consulta = "SELECT * from consultas_datos c WHERE c.id_consulta='$id_consulta'";
        $result_datos_consulta = $mysqli->query($sql_datos_consulta);
        $rowconsulta = $result_datos_consulta->fetch_assoc();
        $fecha_consulta = $rowconsulta['fecha_hora'];
        $fecha_inicio = date('Y-m-d', strtotime($fecha_consulta));
        $hora_inicio = date('H:i', strtotime($fecha_consulta));
        ?>
        <div class="row">                    
            <div class="col-md-12" id="imprimir">                
                    <img style="margin-left: 8% " src="../img/logo.png" width="180"><br><br><br><br><br><br>
                    <p style="font-size: 22px; text-align: center">CERTIFICADO DE CONSULTA</p><br><br><br><br><br>
                    <div style="margin-left: 8% ">
                    <b style="font-size: 18px">La clínica Villamedyc certifica:</b><br><br>
                    <?php
                    if ($rowconsulta['genero'] == 'Masculino') {
                        $genero = 'el señor';
                    } else {
                        $genero = 'la señora';
                    }
                    ?>
                    <p>Que <?php echo $genero . ' <b>' . $rowconsulta['nombres'] . ' ' . $rowconsulta['apellidos'] . '</b> con <b>C.I. ' . $rowconsulta['numero_identidad'] . '</b>'; ?>  
                        se presentó el día <b><?php echo $fecha_inicio; ?></b> a las <b><?php echo $hora_inicio; ?> horas</b> para una consulta médica.</p>
                    <p>En cuanto certifico a los fines que convenga al interesado.</p>
                    <p>Expedido en la Ciudad de Quito </p><br><br><br><br><br><br> 
                </div>
                <p style="text-align: center">______________________________________________</p>
                <p style="text-align: center"><?php echo 'Dr. ' . $rowconsulta['apellidos_doctor'] . ', ' . $rowconsulta['nombre_doctor']; ?></p>
            </div>
        </div>
        <input type="button" class="btn btn-danger" value="Imprimir" onclick="printDiv('imprimir')"/>
    </section>
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