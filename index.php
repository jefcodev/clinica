<?php
session_start();
include_once "./conection/conection.php";
header("Content-Type: text/html;charset=utf-8");

if (!empty($_POST)) {
    $usuario = mysqli_real_escape_string($mysqli, $_POST['usuario']);
    $contrasenna = mysqli_real_escape_string($mysqli, $_POST['contrasenna']);
    $error = '';

    $shal_pass = sha1($contrasenna);
    $sql = "SELECT id, usuario, rol, activo FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$shal_pass'";
    $resul = $mysqli->query($sql);
    $rows = $resul->num_rows;
    $estadoIna = $rows['activo'];

    if ($rows > 0 && $estadoIna == "no") {
        header("location:index.php");
        $error = "Usted es un usuario inactivo no tiene acceso";
    } else
    if ($rows > 0) {
        $rows = $resul->fetch_assoc();
        $_SESSION['id'] = $rows['id'];
        $_SESSION['usuario'] = $rows['usuario'];
        $_SESSION['rol'] = $rows['rol'];
        $_SESSION["ultimoAcceso"] = time();
        header("location: paginas/inicio.php");
    } else
        $error = "El nombre o contraseña son incorrectos";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
        <title>Clínica</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/estilos.css">
        <link rel="stylesheet" href="css/fontawesome-all.min.css">
    </head>
    <body>
        <header class="encabezado">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light fixed-top">
                    <a class="navbar-brand mr-menu" href="index.html"><img src="img/logo.png" width="18%"></a>
                </nav>                    
            </div>                
        </header>
        <div class="row mt-10 mb-10">
            <div class="col-md-4"></div>
            <div class="col-md-3 login" style="width: 330px">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input class="form-control" type="text" name="usuario" id="usuario"  placeholder="usuario"><br>
                    <input class="form-control" type="password" name="contrasenna" id="contrasenna"  placeholder="contraseña"><br>
                    <input type="submit" class="btn btn-danger" name="login" value="Aceptar">
                </form>
                <br>
                <div class="alert-success" style="font-weight: bold">
                    <?php echo isset($error) ? $error : ''; ?>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer-credit"> 
                <div class="row ml-10">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <a>Todos los derechos reservados 2018</a>                
                    </div>
                    <div class="col-md-2">
                        <a href="#"><i class="fab fa-facebook-f social-icon"></i></a>                
                        <a href="#"><i class="fab fa-youtube social-icon"></i></a>                
                    </div>
                </div>
            </div>            
        </footer>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>