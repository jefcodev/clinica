<?php
include 'header.php';
$idusuario = $_GET['idusuario'];
?>
<body>
    <div class="row cuerpo">
        <div class="col-md-1"></div>
        <div class="col-md-4">
            <h1>Editar datos de la historia clínica</h1><br>
            <?php
            $sql_datos_usuario = "SELECT * FROM usuarios WHERE id='$idusuario'";
            $result_datos_usuario = $mysqli->query($sql_datos_usuario);
            while ($row = mysqli_fetch_array($result_datos_usuario)) {
                ?>
                <form action="adm_usuario.php" method="post">
                    <input class="form-control" placeholder="Usuario" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>" />
                    <input class="form-control" placeholder="Nombre" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" />
                    <input class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos" value="<?php echo $row['apellidos']; ?>" />
                    <input class="form-control" placeholder="Teléfono" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>" />
                    <input class="form-control" type="password" placeholder="Contraseña" id="contrasenna" name="contrasenna" />
                    <select class="form-control" id="rol" name="rol">
                        <option value="<?php echo $row['rol']; ?>"><?php include 'MetodosUtiles.php'; echo MetodosUtiles::rolUsuarios($row['rol']); ?></option>
                        <option value="adm">Administrador</option>
                        <option value="asi">Asistente</option>
                        <option value="doc">Doctor</option>
                    </select><br> 
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $row['id']; ?>" />
                    <input class="btn btn-primary" type="submit" name="btn_editar_usuario" id="btn_editar_usuario" value="Aceptar" /> 
                    <a class="btn btn-danger" href="lista_usuarios.php">Cancelar</a>
                </form>
            <?php } ?>
        </div>
    </div>
    <br>
    <?php
    include 'footer.php';
    ?>
</body>
