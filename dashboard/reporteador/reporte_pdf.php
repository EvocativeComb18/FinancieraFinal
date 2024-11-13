<?php
require('fpdf/fpdf.php'); // Asegúrate de tener FPDF en la carpeta 'lib/fpdf'

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "195.250.27.28";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexi車n
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta de datos para el reporte
$sql = "SELECT cliente_id, first_name, last_name, loan_type, requested_amount, loan_term, due_date, remaining_balance FROM loan_information WHERE status = 'activo'";
$result = $conn->query($sql);

// Generación del PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Reporte de Préstamos Activos', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'ID Cliente', 1);
$pdf->Cell(30, 10, 'Nombre', 1);
$pdf->Cell(30, 10, 'Apellido', 1);
$pdf->Cell(30, 10, 'Tipo de Préstamo', 1);
$pdf->Cell(30, 10, 'Monto Solicitado', 1);
$pdf->Cell(20, 10, 'Plazo', 1);
$pdf->Cell(30, 10, 'Fecha de Venc.', 1);
$pdf->Cell(30, 10, 'Saldo Restante', 1);
$pdf->Ln();

// Rellenar el PDF con los datos
$pdf->SetFont('Arial', '', 10);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(20, 10, $row['cliente_id'], 1);
    $pdf->Cell(30, 10, $row['first_name'], 1);
    $pdf->Cell(30, 10, $row['last_name'], 1);
    $pdf->Cell(30, 10, $row['loan_type'], 1);
    $pdf->Cell(30, 10, $row['requested_amount'], 1);
    $pdf->Cell(20, 10, $row['loan_term'], 1);
    $pdf->Cell(30, 10, $row['due_date'], 1);
    $pdf->Cell(30, 10, $row['remaining_balance'], 1);
    $pdf->Ln();
}

$conn->close();
$pdf->Output('D', 'Reporte_Prestamos_Activos.pdf'); // Forzar descarga
?>
