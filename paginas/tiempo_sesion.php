<?php

date_default_timezone_set('America/Bogota');
//calculamos el tiempo transcurrido 
$horaGuardada = $_SESSION["ultimoAcceso"];
$ahora = new DateTime(date("Y-m-d H:i:s"));

$diff = $ahora->diff($horaGuardada);
$tiempo_transcurrido = (($diff->days * 24) * 60) + ($diff->i);
//comparamos el tiempo transcurrido 
if ($tiempo_transcurrido >= 50) {
    //si pasaron 10 minutos o más 
    session_destroy(); // destruyo la sesión 
    header("Location: ../index.php"); //envío al usuario a la pag. de autenticación 
    //sino, actualizo la fecha de la sesión 
} else {
    $_SESSION["ultimoAcceso"] = $ahora;
}


