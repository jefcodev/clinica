<?php
include 'header.php';
$pagina = PAGINAS::LISTA_CONSULTAS;
?>
<head>
    <title>Lista de consultas</title>
    <link href="../css/search.min.css" rel="stylesheet">
</head>
<body>
    <section class="cuerpo">
        <h1>Listado de Consultas</h1>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="indexconsultas">
                    <thead class="tabla_cabecera">
                        <tr>
                            <th>Identidad</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha consulta</th>
                            <th>Motivo Consulta</th>
                            <th style="width: 95px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_citas = "SELECT c.id, c.fecha_hora, p.nombres, p.apellidos, t.id_doctor, c.motivo_consulta, p.numero_identidad, "
                                . " c.certificado from consultas c join pacientes p on c.id_paciente=p.id JOIN citas t ON c.id_cita=t.id "
                                . " order by c.fecha_hora desc";
                        $result_citas = $mysqli->query($sql_citas);
                        $permisoImpresion = Seguridad::tiene_permiso($rol, $pagina, ACCIONES::IMPRIMIR);
                        $permisoImpresionCla = Seguridad::tiene_permiso($rol, $pagina, ACCIONES::IMPRIMIR_CLASIFICADO);
                        $permisoEdicion = Seguridad::tiene_permiso($rol, $pagina, ACCIONES::EDITAR);
                        while ($row = mysqli_fetch_array($result_citas)) {
                            echo "<tr>";
                            echo "<td>" . $row['numero_identidad'] . "</td>";
                            echo "<td>" . $row['nombres'] . "</td>";
                            echo "<td>" . $row['apellidos'] . "</td>";
                            echo "<td>" . $row['fecha_hora'] . "</td>";
                            echo "<td>" . $row['motivo_consulta'] . "</td>";
                            if ($row['certificado'] == null) {
                                $certificado = '';
                            } else {
                                $certificado = "<a class='btn btn-warning btn-sm ml-1' href='imprimir_certificado.php?idconsulta=" . $row['id'] . "'><i class='fas fa-print table-icon'></i></a>";
                            }
                            echo "<td>";
                            if ($rol == 'adm' or ( $permisoEdicion and $row['id_doctor'] == $id_usuario)) {
                                echo "<a class='btn btn-success btn-sm' href='editar_consulta.php?id_consulta=" . $row['id'] . "'><i class='fas fa-edit table-icon'></i></a>";
                            }
                            if ($rol == 'adm' or $permisoImpresion) {
                               echo "<a class='btn btn-danger btn-sm ml-1' href='imprimir_consulta.php?idconsulta=" . $row['id'] . "'><i class='fas fa-print table-icon'></i></a>";
                               
                            }
                            if ($rol == 'adm' or  ( $permisoImpresionCla and $row['id_doctor'] == $id_usuario)) {
                                echo $certificado;
                                
                            }
                            echo "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
    <script src="../js/jquerysearch.js"></script>
    <script>
        $(document).ready(function () {
            $('#indexconsultas').DataTable({
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sInfoPostFix: "",
                    sSearch: "Buscar:",
                    sUrl: "",
                    sInfoThousands: ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    },
                    oAria: {
                        sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sSortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
</body>
