<?php
include 'header.php';
include './NumeroALetras.php';
$id_consulta = $_GET['idconsulta'];
?>

<body>
    <section class="cuerpo">       
        <?php
        date_default_timezone_set('America/Bogota');
        $sql_datos_consulta = "SELECT * from consultas_datos c WHERE c.id_consulta='$id_consulta'";
        $result_datos_consulta = $mysqli->query($sql_datos_consulta);
        $rowconsulta = $result_datos_consulta->fetch_assoc();
        $fecha_consulta = $rowconsulta['fecha_hora'];
		$fecha_consulta_str = strtotime($fecha_consulta);
        $dias_certificado = $rowconsulta['certificado'] - 1;
        $fecha_final_str = strtotime('+' . $dias_certificado . ' day', strtotime($fecha_consulta));
        $fecha_final = date('Y-m-d', $fecha_final_str);
        
		$diasemanaletra = date("D", $fecha_consulta_str);
        //fecha inicial
		$nombre_Semana_fecha_inicial = date('D', $fecha_consulta_str);
		$dia_Semana_fecha_inicial = date('j', $fecha_consulta_str);
		$mes_fecha_inicial = date('F', $fecha_consulta_str);
		$anno_fecha_inicial = date('Y', $fecha_consulta_str);
		//Fecha final
		$nombre_Semana_fecha_final = date('D', $fecha_final_str);
		$dia_Semana_fecha_final = date('j', $fecha_final_str);
		$mes_fecha_final = date('F', $fecha_final_str);
		$anno_fecha_final = date('Y', $fecha_final_str);	
        $texto = $rowconsulta['nombres'] . ' ' . $rowconsulta['apellidos'];
        ?>
        <div class="row">                    
            <div class="col-md-12" id="imprimir">
                <img style="margin-left: 1%" src="../img/logo.png" width="180"><b class="titulo_cert_trau">&nbsp; &nbsp; TRAUMATOLOGÍA &nbsp; &nbsp; &nbsp;  - &nbsp; &nbsp; &nbsp; FISIOTERAPIA Y REHABILITACIÓN&nbsp; &nbsp; </b><br><br><br><br>
                <div style="margin-left: 4rem">
                    <?php
                    $diasemanaletra = date("D");
                    $fecha = NumeroALetras::convertir($rowconsulta['certificado']);
                    $fecha_entrega_certificado = $dia_Semana_fecha_inicial . ' de ' . NumeroALetras::mesesTraducida($mes_fecha_inicial) . ' del ' . $anno_fecha_inicial;
                    echo 'Quito, ' . $fecha_entrega_certificado;
                    if ($rowconsulta['genero'] == 'Masculino') {
                        $genero = 'Sr, ';
                    } else {
                        $genero = 'Sra, ';
                    }
                    ?>
                </div>
                <br><br>
                <div style="margin-left: 4rem; text-align: justify; width: 670px">
                    <p class="titulo_certificado">CERTIFICADO</p><br><br>
                    <p>Por medio del presente, certifico que el <?php echo $genero . strtoupper($texto) . ' con número de cédula ' . $rowconsulta['numero_identidad'] . ' asistió a la consulta de traumatología el día de hoy.'; ?>    </p>
                    <p>El paciente presenta <?php echo $rowconsulta['diagnostico']; ?>, por tal motivo amerita reposo por <?php echo NumeroALetras::convertir($rowconsulta['certificado']) . '(' . $rowconsulta['certificado']; ?>) días.</p>
                    <p>Desde el día <?php echo NumeroALetras::semanaTraducida($nombre_Semana_fecha_inicial) . ' ' . $dia_Semana_fecha_inicial . ' (' . NumeroALetras::convertir($dia_Semana_fecha_inicial). ') de ' . NumeroALetras::mesesTraducida($mes_fecha_inicial) . ' del ' . $anno_fecha_inicial . ' hasta ' . NumeroALetras::semanaTraducida($nombre_Semana_fecha_final) . ' ' . $dia_Semana_fecha_final . ' (' . NumeroALetras::convertir($dia_Semana_fecha_final) . ') de ' . NumeroALetras::mesesTraducida($mes_fecha_final) . ' ' . $anno_fecha_final . '.'; ?></p>
                    <b class="float-left mr-3">Observaciones: </b><p><?php echo nl2br($rowconsulta['observaciones']); ?><br></p>
                    <p>Se expide el presente certificado para los trámites que el interesado creyere conveniente.</p>
                </div><br><br><br><br><br><br><br>
                <div class="creditos_doctor">
                    <p style="text-align: center">______________________________________________</p>
                    <p style="text-align: center"><?php echo 'Dr. ' . $rowconsulta['nombre_doctor'] . ', ' . $rowconsulta['apellidos_doctor']; ?></p>
                    <p style="text-align: center"><?php echo $rowconsulta['especialidad']; ?></p>
                </div>
                <div class="estilo_cabecera_certificado">
                    <p style="text-align: center">Villa  Flora - Alonso de Angulo Oe1-134 y francisco Gómez - Planta Baja</p>
                    <p style="text-align: center">Teléfonos (593) 02 2658 - 550 / 09 99 795 566</p>
                </div>
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