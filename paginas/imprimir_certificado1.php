<?php
require('pdf/fpdf.php');
include './NumeroALetras.php';


class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
    $this->Image('../img/logo.png',70,6,60);
    
    $this->Ln(25);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}


// Instanciation of inherited class


require('../conection/conection.php');

$id_consulta = $_GET['idconsulta'];



// SQL de consultas
$consulta = "SELECT * from consultas_datos c WHERE c.id_consulta='$id_consulta' ";
$resultado = $mysqli->query($consulta);



// Creción de pdf

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(190, 10, utf8_decode('CERTIFICADO MÉDICO DE TRAUMATOLOGÍA '),0, 0,'C' ,0);
$pdf->Ln(15);




$pdf->SetFillColor(234, 236, 238);
$pdf->SetDrawColor(182, 182, 182);
// Lectura de array 


while ($row = $resultado->fetch_assoc()) {


    if ($row['genero'] == 'Masculino') {
        $genero = 'Sr, ';
    } else {
        $genero = 'Sra, ';
    }
    // fecha de nacimiento
    $fecha_nacimiento = $row['fecha_nacimiento'];
	$fecha_nacimiento_str = strtotime($fecha_nacimiento);
    $anno_fecha_nac = date('Y', $fecha_nacimiento_str);
    $edad = 2023 - $anno_fecha_nac;
    $fecha_nac = date('d-m-Y', $fecha_nacimiento_str);


    //fecha consulta
    $fecha_consulta = $row['fecha_hora'];
    $fecha_consulta_str = strtotime($fecha_consulta);
    $dias_certificado = $row['certificado'] - 1;
    $fecha_final_str = strtotime('+' . $dias_certificado . ' day', strtotime($fecha_consulta));
    $fecha_final = date('Y-m-d', $fecha_final_str);
    
    $diasemanaletra = date("D", $fecha_consulta_str);
    //fecha inicial
    $nombre_Semana_fecha_inicial = date('D', $fecha_consulta_str);
    $dia_Semana_fecha_inicial = date('j', $fecha_consulta_str);
    $mes_fecha_inicial = date('F', $fecha_consulta_str);
    $anno_fecha_inicial = date('Y', $fecha_consulta_str);
    //Fecha final
    $nombre_Semana_fecha_final = date('D', $fecha_final_str);
    $dia_Semana_fecha_final = date('j', $fecha_final_str);
    $mes_fecha_final = date('F', $fecha_final_str);
    $anno_fecha_final = date('Y', $fecha_final_str);
    

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, ' NOMBRE: ', 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, utf8_decode($row['apellidos']) .' '. utf8_decode($row['nombres']), 0, 0, 'J', 0);
    $pdf->Ln(7);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, ' CI: ', 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, utf8_decode($row['numero_identidad']), 0, 0, 'J', 0);
    $pdf->Ln(7);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode(' N° HISTORIA: '), 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, utf8_decode($row['id_paciente']), 0, 0, 'J', 0);
    $pdf->Ln(7);

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode(' FECHA DE NACIMIENTO: '), 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, $fecha_nac, 0, 0, 'J', 0);
    $pdf->Ln(7);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode(' EDAD: '), 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, $edad .utf8_decode(' años'), 0, 0, 'J', 0);
    $pdf->Ln(7);



    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode(' DIAGNÓSTICO: '), 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->MultiCell(140,7,$row['diagnostico'], 0, 'L', false);
   
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode('INICIO DE REPOSO : '), 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, utf8_decode('Desde el día '). NumeroALetras::semanaTraducida($nombre_Semana_fecha_inicial).' '. $dia_Semana_fecha_inicial. ' (' . NumeroALetras::convertir($dia_Semana_fecha_inicial). ') de ' . NumeroALetras::mesesTraducida($mes_fecha_inicial) .' del '. $anno_fecha_inicial, 0, 0, 'J', 0);
    $pdf->Ln(7);
    
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode('INICIO DE REPOSO : '), 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(130, 10, utf8_decode('Desde el día '). NumeroALetras::semanaTraducida( $nombre_Semana_fecha_final).' '. $dia_Semana_fecha_final. ' (' . NumeroALetras::convertir($dia_Semana_fecha_final). ') de ' . NumeroALetras::mesesTraducida($mes_fecha_final) .' del '. $anno_fecha_final, 0, 0, 'J', 0);
    $pdf->Ln(7);
    
    


    $pdf->Cell(50, 10, ' FECHA DE NACIMIENTO', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['fecha_nacimiento']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, 'CI', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['numero_identidad']), 1, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode('TELÉFONO MOVIL'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['telefono_movil']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode('DIRECCIÓN'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['direccion']), 1, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode(' CORREO ELECTRÓNICO'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['correo_electronico']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode('OCUPACIÓN'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['ocupacion']), 1, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, 'ANTC. PERSONALES', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['antecedentes_personales']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode('ANTC. FAMILIARES'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['antecedentes_familiares']), 1, 0, 'C', 0);
    $pdf->Ln(15);
    $pdf->Cell(190, 10, 'Por medio del presente, certifico que el '.utf8_decode($genero) . utf8_decode($row['nombres']) .' '.utf8_decode($row['apellidos']). utf8_decode(' con número de cédula') , 0, 0, 'J', 0);
    $pdf->Ln(8);
    $pdf->Cell(200, 10, utf8_decode($row['id_paciente']) .utf8_decode(' asistió a la consulta de traumatología el día de hoy. ') , 0, 0, 'J', 0);
    $pdf->Ln(8);
    $pdf->Cell(200, 10, utf8_decode(' El paciente presenta ') . utf8_decode($row['diagnostico']).' por lat motivo amerita reposo por '.''. 'días' , 0, 0, 'J', 0);
    $pdf->Ln(8);
    
}



$pdf->Output();
