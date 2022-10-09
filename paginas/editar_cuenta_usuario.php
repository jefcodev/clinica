<?php
include 'header.php';
$usuario = $_SESSION['usuario'];
$status = $_GET['status'];
$class = '';
$close = '';
if (isset($status)) {
    $close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>';
    if ($status === 'OK') {
        $error = 'Datos editados correctamente';
        $class = 'class="alert alert-success alert-dismissible fade show" role="alert"';
    } else {
        $error = 'No se puedieron editar los datos';
        $class = 'class="alert alert-danger alert-dismissible fade show" role="alert"';
    }
}
?>
<body>
    <section class="cuerpo">
        <h1>Editar mis datos</h1><br>
        <div id="mensajes" <?php echo $class; ?> >
            <?php echo isset($error) ? $error : ''; ?>
            <?php echo $close; ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                $sql_datos_usuario = "SELECT * FROM usuarios WHERE usuario='$usuario'";
                $result_datos_usuario = $mysqli->query($sql_datos_usuario);
                while ($row = mysqli_fetch_array($result_datos_usuario)) {
                    ?>
                    <form action="adm_usuario.php" method="post">
                        <input disabled class="form-control" placeholder="Usuario" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>" />
                        <input class="form-control" placeholder="Nombre" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" />
                        <input class="form-control" placeholder="Especialidad" id="especialidad" name="especialidad" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row['especialidad']; ?>" />
                        <input class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos" value="<?php echo $row['apellidos']; ?>" />
                        <input class="form-control" placeholder="Teléfono" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>" />
                        <input class="form-control" type="password" placeholder="Contraseña" id="contrasenna" name="contrasenna" />
                        <select disabled class="form-control" id="rol" name="rol">
                            <option value="<?php echo $row['rol']; ?>"><?php
                                include 'MetodosUtiles.php';
                                echo MetodosUtiles::rolUsuarios($row['rol']);
                                ?></option>
                            <option value="adm">Administrador</option>
                            <option value="asi">Asistente</option>
                            <option value="doc">Doctor</option>
                        </select><br> 
                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $row['id']; ?>" />
                        <input class="btn btn-primary" type="submit" name="btn_editar_cuenta_usuario" id="btn_editar_cuenta_usuario" value="Aceptar" /> 
                        <a class="btn btn-danger" href="lista_usuarios.php">Cancelar</a>
                    </form>
<?php } ?>
            </div>
        </div>
    </section>
    <?php
    include 'footer.php';
    ?>
</body>
