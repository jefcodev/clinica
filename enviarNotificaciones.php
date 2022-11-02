<?php
include 'conection/conection.php';
require 'vendor/autoload.php';

// Descripcion general
// Se realizara la ejecucion cada hora
//obtiene la fecha de la cita, el telefono movil y los nombres cuando aun no se haya realizado la consulta
$sql_get_cites = "SELECT c.fecha_cita, p.telefono_movil, p.nombres FROM citas c inner join pacientes p on c.id_paciente=p.id WHERE consultado='no'";
$query_crear_notificacion = $mysqli->query($sql_get_cites);
if ($query_crear_notificacion == TRUE) {
  date_default_timezone_set('America/Guayaquil');
  //Obetner fecha y hora actual
  $fecha_actual = date('m-d-Y h:i:s a', time());
  // separar la fecha  y la hora
  $fecha_actual_separate = (explode(" ", $fecha_actual));
  //fecha separada
  $fecha_actual_dma = $fecha_actual_separate[0];
  //Separar Dia mes año
  $fecha_actual_separate_dma = (explode("-", $fecha_actual_dma));
  //Dia
  $fecha_actual_dia = $fecha_actual_separate_dma[0];
  //mes
  $fecha_actual_mes = $fecha_actual_separate_dma[1];
  //año
  $fecha_actual_año = $fecha_actual_separate_dma[2];
  // hora separada
  $fecha_actual_hms = $fecha_actual_separate[1];
  //Separar hora y minutos
  $fecha_actual_separate_hms = (explode(":", $fecha_actual_hms));
  //hora
  $fecha_actual_hora = $fecha_actual_separate_hms[0];
  //minutos
  $fecha_actual_minutos = $fecha_actual_separate_hms[1];

  while ($row = mysqli_fetch_array($query_crear_notificacion)) {
    $getObjectCites = array(
      'nombres' => $row['nombres'],
      'fecha_cita' => $row['fecha_cita'],
      'telefono_movil' => $row['telefono_movil']
    );

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
    // hora separada
    $fecha_cita_hms = $fecha_cita_separate[1];
    //Separar hora y minutos
    $fecha_cita_separate_hms = (explode(":", $fecha_cita_hms));
    //hora
    $fecha_cita_hora = $fecha_cita_separate_hms[0];
    //minutos
    $fecha_cita_minutos = $fecha_cita_separate_hms[1];
    //La primera ejecucion se realizara  a las 00:00 

    // la primera condición evalua si la fecha del dia actual es igual a la fecha del dia de cita agendada,
    // y para asegurar que sea 24 horas antes de la cita se verifica si los minutos y la hora son iguales a 0 y enviara el mensaje con 24 horas de anticipacion 
    if (($fecha_actual_dia == $fecha_cita_dia && $fecha_actual_hora == 0 && $fecha_actual_minutos == 0)) {
      echo "Haciendo condicion 1";
      echo "<br>";
      $mensaje = "RECORDATORIO. " . $getObjectCites['nombres'] . " usted tiene una cita agenda para la fecha: " . $getObjectCites['fecha_cita'];
      $telefonoMovil = $getObjectCites['telefono_movil'];
      sendMessajeWhassap($mensaje, $telefonoMovil);
      //segunda condicion evalua si falta n 4 horas sumando la hora actual + 4 y si es igual ala hora de la dita enviara con 4 horas de ainticipacion
    } elseif (($fecha_actual_hora + 4) == $fecha_cita_hora) {

      $mensaje = "RECORDATORIO. " . $getObjectCites['nombres'] . " usted tiene una cita agenda para dentro de 4 horas";
      $telefonoMovil = $getObjectCites['telefono_movil'];
      sendMessajeWhassap($mensaje, $telefonoMovil);
    }
  }
} else {
  echo 'Error';
}


function sendMessajeWhassap($mensaje, $numeroMovil)
{
  $token =  "GA221031231835";
  $client = new GuzzleHttp\Client(['verify' => false]);
  $payload = array(
    "op" => "registermessage",
    "token_qr" => $token,
    "mensajes" => array(
      array("numero" => $numeroMovil, "mensaje" => $mensaje),
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
