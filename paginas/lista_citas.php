<?php
include 'header.php';
$pagina = PAGINAS::LISTA_CITAS;
?>
<head>
    <title>Lista de citas</title>
    <link href="../css/search.min.css" rel="stylesheet">
</head>
<body>
    <section class="cuerpo">
        <h1>Listado de Citas</h1>
        <br>
        <div class="row">
            <div class="col-md-12">
                <?php
                $permisoCreacion = Seguridad::tiene_permiso($rol, $pagina, ACCIONES::CREAR);
                $permisoEdicion = Seguridad::tiene_permiso($rol, $pagina, ACCIONES::EDITAR);
                if ($permisoCreacion) {
                    echo ' <a href="crear_cita.php" class="btn btn-success float-right"> Crear nueva cita</a><br><br>';
                }
                ?>
   
                <table class="table table-bordered table-hover" id="indexcitas">
                    <thead class="tabla_cabecera">
                        <tr>
                            <th>Fecha cita</th>
                            <th>Nombres paciente</th>
                            <th>Apellidos paciente</th>
                            <th>C.Identidad</th>
                            <th>Nombre doctor</th>
                            <th>Creada por</th>                            
                            <th>Realizada</th>
                            <?php
                            if ($permisoEdicion) {
                                echo '<th style="width: 93px">Acciones</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_citas = "SELECT * FROM citas_datos";
                        $result_citas = $mysqli->query($sql_citas);
                        while ($row = mysqli_fetch_array($result_citas)) {
                            echo "<tr>";
                            echo "<td>" . $row['fecha_cita'] . "</td>";
                            echo "<td>" . $row['nombres_paciente'] . "</td>";
                            echo "<td>" . $row['apellidos_paciente'] . "</td>";
                            echo "<td>" . $row['numero_identidad'] . "</td>";
                            echo "<td>" . $row['nombre_doctor'] . "</td>";
                            echo "<td>" . $row['nombre_creador'] . "</td>";
                            echo "<td>" . $row['consultado'] . "</td>";
                            if ($permisoEdicion) {
                                echo "<td><a class='btn btn-success btn-sm' href='editar_cita.php?id_cita=" . $row['id'] . "'><i class='fas fa-edit table-icon'></i></a></td>";
                            }echo "</tr>";
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
            $('#indexcitas').DataTable({
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
