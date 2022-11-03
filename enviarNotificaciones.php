<?php
include 'conection/conection.php';
require 'vendor/autoload.php';

date_default_timezone_set('America/Guayaquil');

$fecha_actual = date('m-d-Y h:i:s');
$fechaActualAño = date("Y");
$fechaActualMes = date("m");
$fechaActualDia = date("d");

setlocale(LC_TIME, "es_ES");
$horaActual = strftime("%H:%M");
$horaActualSeparate = (explode(":", $horaActual));
$horaActual_HORA = $horaActualSeparate[0];
$horaActual_MINUTO = $horaActualSeparate[1];


$sql_get_cites = "SELECT c.fecha_cita, p.telefono_movil, p.nombres FROM citas c inner join 
pacientes p on c.id_paciente=p.id WHERE consultado='no' and year(c.fecha_cita)='$fechaActualAño' and Month(c.fecha_cita)='$fechaActualMes'";
$query_crear_notificacion = $mysqli->query($sql_get_cites);
if ($query_crear_notificacion == TRUE) {


  while ($row = mysqli_fetch_array($query_crear_notificacion)) {
    $getObjectCites = array(
      'nombres' => $row['nombres'],
      'fecha_cita' => $row['fecha_cita'],
      'telefono_movil' => $row['telefono_movil']
    );
    // echo $getObjectCites['fecha_cita'];
    // echo "<br>";

    $fecha_cita_separate = (explode(" ", $getObjectCites['fecha_cita']));
    //fecha separada
    $fecha_cita_dma = $fecha_cita_separate[0];
    //Separar Dia mes año
    $fecha_cita_separate_dma = (explode("-", $fecha_cita_dma));
    //Dia
    $fecha_cita_año = $fecha_cita_separate_dma[0];
    //mes
    $fecha_cita_mes = $fecha_cita_separate_dma[1];
    //año
    $fecha_cita_dia = $fecha_cita_separate_dma[2];
    // echo $fecha_cita_dia;
    // hora separada
    $fecha_cita_hms = $fecha_cita_separate[1];
    //Separar hora y minutos
    $fecha_cita_separate_hms = (explode(":", $fecha_cita_hms));
    //hora
    $fecha_cita_hora = $fecha_cita_separate_hms[0];
    //minutos
    $fecha_cita_minutos = $fecha_cita_separate_hms[1];
    $fechaCompararPrincipal = new DateTime($horaActual);

    $rangoPrincipalMaximo = new DateTime("21:00");
    $rangoPrincipalMinimo = new DateTime("23:59");
    if ($fechaCompararPrincipal >= $rangoPrincipalMaximo && $fechaCompararPrincipal <= $rangoPrincipalMinimo) {
      echo "Inecceesario resolver";
    } else {
      // echo "AHciend aca";

      if ($fecha_cita_dia = $fechaActualDia && $horaActual_HORA < $fecha_cita_hora) {
        // echo "haciendo esto";
        $hora_inicio = new DateTime($horaActual);
        $hora_fin = new DateTime($fecha_cita_hms);
        $rangoMaximo = new DateTime("04:00");
        // echo ($rangoMaximo->format('H:i'));
        $rangoMinimo = new DateTime("03:00");
        $diferencia = $hora_fin->diff($hora_inicio);
        $resultTiempoRestanteParaLaCita = $diferencia->format('%H:%i');
        $resultTiempoRestanteParaLaCita = new DateTime($resultTiempoRestanteParaLaCita);
        $textResultTiempoRestanteParaLaCita = $diferencia->format('%H Horas con %i minutos');
        //  echo $diferencia->format('%H horas %i minutos');
        // echo ("resultTiempoRestanteParaLaCita: " .  $textResultTiempoRestanteParaLaCita);
        // $a=($resultTiempoRestanteParaLaCita >= $rangoMaximo);
        // echo "a".$a;

        if ($resultTiempoRestanteParaLaCita <= $rangoMaximo && $resultTiempoRestanteParaLaCita >= $rangoMinimo) {
          // echo "haciendo esto dentro if";
          $mensaje = "RECORDATORIO! " . $getObjectCites['nombres'] . " usted tiene una cita agenda para dentro de " . $textResultTiempoRestanteParaLaCita . "";
          $telefonoMovil = $getObjectCites['telefono_movil'];
          //  sendMessajeWhassap($mensaje, $telefonoMovil);
        }
      }
      $fecha_cita_separate = (explode(" ", $getObjectCites['fecha_cita']));
      //fecha separada
      $fecha_cita_dma = $fecha_cita_separate[0];
      //Separar Dia mes año
      $fecha_cita_separate_dma = (explode("-", $fecha_cita_dma));
      //Dia
      $fecha_cita_año = $fecha_cita_separate_dma[0];
      //mes
      $fecha_cita_mes = $fecha_cita_separate_dma[1];
      //año
      $fecha_cita_dia = $fecha_cita_separate_dma[2];
      // echo $fecha_cita_dia;
      // hora separada
      $fecha_cita_hms = $fecha_cita_separate[1];
      //Separar hora y minutos
      $fecha_cita_separate_hms = (explode(":", $fecha_cita_hms));
      //hora
      $fecha_cita_hora = $fecha_cita_separate_hms[0];
      //minutos
      $fecha_cita_minutos = $fecha_cita_separate_hms[1];
      // echo " fecah actual hora: ".($horaActual_HORA );
      // echo " fecha cita hora: ".($fecha_cita_hora);
      // // echo "<br>";
      // echo " fecha cita dia: ".($fecha_cita_dia );
      // echo " fecha actual dia + uno: ".($fechaActualDia + 1);
      // echo "<br>";  

      if ($fecha_cita_dia == ($fechaActualDia + 1) && $horaActual_HORA == $fecha_cita_hora) {
        echo "haciendo esto dentoro id 2";

        $mensaje = "RECORDATORIO. " . $getObjectCites['nombres'] . " usted tiene una cita agenda para la fecha para dentro de 24 horas";
        $telefonoMovil = $getObjectCites['telefono_movil'];
        sendMessajeWhassap($mensaje, $telefonoMovil);
      }
    }
  }
} else {
  echo 'Error';
}


function sendMessajeWhassap($mensaje, $numeroMovil)
{
  echo $mensaje;
  echo $numeroMovil;
  $numeroSeparete = str_split($numeroMovil);
  $numeresumido = $numeroSeparete[1] . "" . $numeroSeparete[2] . "" . $numeroSeparete[3] . "" . $numeroSeparete[4] . "" . $numeroSeparete[5] . "" . $numeroSeparete[6] . "" . $numeroSeparete[7] . "" . $numeroSeparete[8] . "" . $numeroSeparete[9];
  echo $numeresumido;
  $token =  "GA221103022652";
  $client = new GuzzleHttp\Client(['verify' => false]);
  $payload = array(
    "op" => "registermessage",
    "token_qr" => $token,
    "mensajes" => array(
      array("numero" => "593" . $numeresumido, "mensaje" => $mensaje),
    )
  );
  $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
    'headers' => [
      'Content-Type'     => 'application/json',
      'Accept' => 'application/json'
    ], 'json' =>  $payload
  ]);
  echo $res->getStatusCode() . "<br>";
  echo $res->getBody();
}
