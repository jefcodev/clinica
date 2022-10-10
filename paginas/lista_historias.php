<?php
include 'header.php';
$pagina = PAGINAS::LISTA_HISTORIAS;
?>
<head>
    <title>Lista de historias</title>
    <link href="../css/search.min.css" rel="stylesheet">
</head>
<body>
    <section class="cuerpo">
        <h1>Listado de Historias Clínicas</h1>
        <div class="row">
            <div class="col-md-12"><br><br>
                <?php
                $permisoVer = Seguridad::tiene_permiso($rol, $pagina, ACCIONES::VER);
                ?>
                <table class="table table-bordered table-hover" id="indexhistoriah">
                    <thead class="tabla_cabecera">
                        <tr>                            
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Identificación</th>
                            <th>Fecha de nacimiento</th> 
                            <th>Genero</th>
                            <th>Teléfono movil</th>
                            <th>Dirección</th>
                            <th>Correo electrónico</th>
                            <th>Fecha hora</th>
                            <?php
                            if ($permisoVer) {
                                echo '<th>Ver</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_citas = "SELECT * FROM pacientes";
                        $result_citas = $mysqli->query($sql_citas);

                        while ($row = mysqli_fetch_array($result_citas)) {
                            echo "<tr>";
                            echo "<td>" . $row['nombres'] . "</td>";
                            echo "<td>" . $row['apellidos'] . "</td>";
                            echo "<td>" . $row['numero_identidad'] . "</td>";
                            echo "<td>" . $row['fecha_nacimiento'] . "</td>";
                            echo "<td>" . $row['genero'] . "</td>";
                            echo "<td>" . $row['telefono_movil'] . "</td>";
                            echo "<td>" . $row['direccion'] . "</td>";
                            echo "<td>" . $row['correo_electronico'] . "</td>";
                            echo "<td>" . $row['fecha_hora'] . "</td>";

                            if ($permisoVer) {
                                echo "<td><a class='btn btn-primary btn-sm' href='historia_clinica.php?id_paciente=" . $row['id'] . "'><i style='font-size:18px' class='fas fa-eye'></i></a></td>";
                            }
                            echo "</tr>";
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
            $('#indexhistoriah').DataTable({
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
