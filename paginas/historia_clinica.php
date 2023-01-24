<?php
require('pdf/fpdf.php');


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

$id_paciente = $_GET['id_paciente'];

// Cosultar datos personales de paciente 
$consulta = "SELECT * FROM pacientes WHERE id='$id_paciente' ";
$resultado = $mysqli->query($consulta);

// Creción de pdf

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(190, 10, utf8_decode('Historia Clínica '). utf8_decode(' N° ') . $id_paciente,0, 0,'C' ,0);
$pdf->Ln(15);

$pdf->SetFont('Times', '', 11);


$pdf->SetFillColor(234, 236, 238);
$pdf->SetDrawColor(182, 182, 182);
// Lectura de array 
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(50, 10, ' NOMBRES Y APELLIDOS', 1, 0, 'C', 1);
    $pdf->Cell(140, 10, utf8_decode($row['nombres']) .' '. utf8_decode($row['apellidos']), 1, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, ' FECHA DE NACIMIENTO', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['fecha_nacimiento']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, 'CI', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['numero_identidad']), 1, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode(' GÉNERO'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['genero']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode('TELÉFONO FIJO'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode($row['telefono_fijo']), 1, 0, 'C', 0);
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
}

$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(190, 15, utf8_decode('Consultas '), 0,0,'C', 0);
$pdf->Ln(20);
$pdf->SetFont('Times', '', 11);

// Consulta de # de consultas por id de paciente 

$cosulta_citas = "select * from consultas_datos where id_paciente ='$id_paciente' order by fecha_hora desc";
$resultado_citas = $mysqli->query($cosulta_citas);

while ($row_citas = $resultado_citas->fetch_assoc()) {
    $pdf->Cell(50, 10, utf8_decode('DOCTOR'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, $row_citas['nombre_doctor'] . ' ' . $row_citas['apellidos_doctor'], 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode('FECHA'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, $row_citas['fecha_hora'], 1, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode('MOTIVO CONSULTA'), 1, 0, 'C', 1);
    $pdf->MultiCell(140,6,$row_citas['motivo_consulta'], 'LRT', 'L', false);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode('EXAMEN FÍSICO'), 1, 0, 'C', 1);
    $pdf->Cell(140, 10, $row_citas['examen_fisico'], 1, 0, 'L', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode('DIAGNÓSTICO'), 1, 0, 'C', 1);
    $pdf->Cell(140, 10, $row_citas['diagnostico'], 1, 0, 'L', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode('TRATAMIENTO'), 1, 0, 'C', 1);
    $pdf->Cell(140, 10, $row_citas['tratamiento'], 1, 0, 'L', 0);
    $pdf->Ln(10);
    $pdf->Cell(50, 10, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1);
    $pdf->Cell(140, 10, $row_citas['observaciones'], 1, 0, 'L', 0);
    $pdf->Ln(10);

}

$pdf->Output();
