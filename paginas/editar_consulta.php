<?php
include 'header.php';
$pagina = PAGINAS::EDITAR_CONSULTA;
$id_consulta = $_GET['id_consulta'];
$class = '';
$close = '';
if(!Seguridad::tiene_permiso($rol, $pagina, ACCIONES::EDITAR)){
    header("location:./inicio.php?status=AD");
}
if (isset($_POST['btn_editar_consulta'])) {
    $motivo_consulta = $_POST['motivo_consulta'];
    $examen_fisico = $_POST['examen_fisico'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
    $certificado = $_POST['certificado'];
    $observaciones = $_POST['observaciones'];
    $sql_update_consulta = "UPDATE consultas SET motivo_consulta='$motivo_consulta', examen_fisico='$examen_fisico', diagnostico='$diagnostico', "
            . " tratamiento='$tratamiento', certificado='$certificado', observaciones = '$observaciones' WHERE id='$id_consulta'";
    $result_update_consulta = $mysqli->query($sql_update_consulta);
    if ($result_update_consulta === true) {
        $error = 'Consulta actualizada con éxito';
        $class = 'class="alert alert-success alert-dismissible fade show" role="alert"';
        $close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>';
    } else {
        $error = 'Ocurrió un error al actualizar la información de la consulta';
        $class = 'class="alert alert-danger alert-dismissible fade show" role="alert"';
        $close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>';
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
<body>
    <section class="cuerpo">
        <h1>Atención al paciente</h1><br>        
        <?php
        $sql_datos_consulta = "SELECT * FROM consultas WHERE id='$id_consulta'";
        $result_datos_consulta = $mysqli->query($sql_datos_consulta);
        $rowconsulta = $result_datos_consulta->fetch_assoc();
        ?>
        <div style="padding: 1% 2% 1% 2%; background-color: #D8D8D8">
            <b style="font-size: 18px">Datos de la consulta</b><br><br>
            <form method="post" >
                <div class="row">                    
                    <div class="col-md-6">
                        <textarea class="form-control" title="Motivo de la consulta" placeholder="Motivo de la consulta" id="motivo_consulta" name="motivo_consulta" required><?php echo $rowconsulta['motivo_consulta']; ?></textarea>
                        <textarea class="form-control" title="Examen físico" placeholder="Examen físico" id="examen_fisico" name="examen_fisico" required><?php echo $rowconsulta['examen_fisico']; ?></textarea>
                        <textarea class="form-control" title="Tratamiento" placeholder="Tratamiento" id="tratamiento" name="tratamiento" required><?php echo $rowconsulta['tratamiento']; ?></textarea>
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
                        <textarea class="form-control" title="Diagnóstico" placeholder="Diagnóstico" id="diagnostico" name="diagnostico" required><?php echo $rowconsulta['diagnostico']; ?></textarea>
                        <textarea class="form-control" title="Observaciones" placeholder="Observaciones" id="observaciones" name="observaciones"><?php echo $rowconsulta['observaciones']; ?></textarea>
                        <input class="form-control" type="number" title="Días de certificado: no puede exceder los 60 días" value="<?php echo $rowconsulta['certificado']; ?>" placeholder="Días de certificado" id="certificado" name="certificado" min="1" max="60"/>
                        <div <?php echo $class; ?> >
                            <?php echo isset($error) ? $error : ''; ?>
                            <?php echo $close; ?>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">                        
                        <input type="hidden" id="id_cita" name="id_cita" value="<?php echo $id_cita; ?>"/>
                    </div>
                    <div class="col-md-6">
                        <input class="btn btn-primary float-right" type="submit" name="btn_editar_consulta" id="btn_editar_consulta" value="Guardar datos de la consulta"/><br>
                    </div>
                </div>
            </form>
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
        select.onchange = function () {
            if (tArea.value.length === 0) {
                tArea.value = select.options[select.selectedIndex].value;
            } else {
                tArea.value = tArea.value + '\n' + select.options[select.selectedIndex].value;
            }
        }
    </script>
</body>